<?php

namespace App\Admin\Services\Booking;

use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Admin\Repositories\Course\CourseRepositoryInterface;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Admin\Repositories\TeacherLesson\TeacherLessonRepositoryInterface;
use App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use App\Mail\RegisterLessonNotificationMail;
use App\Enums\Booking\BookingStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Admin\Traits\AuthService;
use App\Models\TicketStudent;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use App\Models\Admin;
use Carbon\Carbon;
use Exception;

class BookingService implements BookingServiceInterface
{
    use AuthService, UseLog, Setup;

    protected $data;
    protected $repository;
    protected $courseRepository;
    protected $lessonRepository;
    protected $notificationRepository;
    protected $teacherLessonRepository;
    protected $ticketStudentRepository;
    protected $studentLessonRepository;

    public function __construct(
        BookingRepositoryInterface $repository,
        LessonRepositoryInterface $lessonRepository,
        CourseRepositoryInterface $courseRepository,
        NotificationRepositoryInterface $notificationRepository,
        StudentLessonRepositoryInterface $studentLessonRepository,
        TeacherLessonRepositoryInterface $teacherLessonRepository,
        TicketStudentRepositoryInterface $ticketStudentRepository
    ) {
        $this->repository = $repository;
        $this->courseRepository = $courseRepository;
        $this->lessonRepository = $lessonRepository;
        $this->notificationRepository = $notificationRepository;
        $this->studentLessonRepository = $studentLessonRepository;
        $this->teacherLessonRepository = $teacherLessonRepository;
        $this->ticketStudentRepository = $ticketStudentRepository;
    }



    /**
     * Lấy vé còn lượt theo loại ticket
     */
    private function getTicketsByType(int $studentId, int $requiredCount, string $type)
    {
        $tickets = TicketStudent::where('admin_id', $studentId)
            ->whereHas('ticket', function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->where('expired_date', '>=', Carbon::today())
            ->orderBy('expired_date', 'asc')
            ->get();

        $totalRemaining = $tickets->sum('remaining_tickets');

        if ($tickets->isEmpty() || $totalRemaining < $requiredCount) {
            throw new Exception("Người dùng không còn đủ vé.");
        }

        return $tickets;
    }

    /**
     * Tìm vé hợp lệ theo loại ticket
     */
    private function findTicketByType($tickets, string $type)
    {

        foreach ($tickets as $ticket) {
            if ($ticket->remaining_tickets > 0 && $ticket->ticket->type === $type) {
                return $ticket;
            }
        }
        return null;
    }


    /**
     * Tìm vé còn lượt
     */
    private function findAvailableTicket($tickets)
    {
        foreach ($tickets as $ticket) {
            if ($ticket->remaining_tickets > 0) {
                return $ticket;
            }
        }
        return null;
    }


    private function determineStudentId(Admin $currentAdmin, ?int $studentIdFromFrontend = null): int
    {
        if ($currentAdmin->hasRole('superAdmin')) {
            if (!is_null($studentIdFromFrontend)) {
                return $studentIdFromFrontend;
            }
            throw new Exception("Cần có ID học sinh khi SuperAdmin đăng ký thay cho một học sinh.");
        }
        // User bình thường (student) → trả về chính họ
        return $currentAdmin->id;
    }


    private function checkSpecialTicketAccess($ticket, $currentAdmin)
    {
        // Kiểm tra nếu vé đầu tiên là vé đặc biệt
        if ($ticket->ticket->type === 'special' && !$currentAdmin->hasRole('superAdmin')) {
            throw new Exception("Bạn không thể tự đăng ký buổi học với vé đặc biệt. Vui lòng liên hệ Admin để được hỗ trợ.");
        }
    }

    private function getTeacherLesson(int $lessonId)
    {
        $teacherLesson = $this->teacherLessonRepository->find($lessonId);
        if (!$teacherLesson) {
            throw new Exception("Buổi học với ID $lessonId không tìm thấy.");
        }
        return $teacherLesson;
    }

    private function validateBookingConflict(int $studentId, string $date, string $startTime): void
    {
        $exists = DB::table('student_lessons')
            ->where('admin_id', $studentId)
            ->where('date', $date)
            ->where('start_time', $startTime)
            ->exists();
        if ($exists) {
            throw new Exception("Học viên đã có buổi học vào lúc {$startTime} ngày {$date}. Không thể đăng ký trùng lịch.");
        }
    }


    private function createBooking(int $studentId, $teacherLesson, $usedTicket)
    {
        $data = [
            'status' => BookingStatus::Pending->value,
            'admin_id' => $studentId,
            'date' => $teacherLesson->lesson->date,
            'start_time' => $teacherLesson->lesson->start_time,
            'course_name' => $teacherLesson->lesson->course->name,
            'teacher_lesson_id' => $teacherLesson->id,
            'ticket_date' => $usedTicket->expired_date,
            'ticket_type' => $usedTicket->ticket->type,
            'ticket_id' => $usedTicket->ticket_id,
        ];

        return $this->repository->create($data);
    }
    private function processBookingRequest(array $bookingItemsData, Admin $currentAdmin, ?int $studentIdFromFrontend = null): array
    {
        DB::beginTransaction();

        try {
            if (empty($bookingItemsData)) {
                throw new Exception("Dữ liệu đăng ký không hợp lệ hoặc trống.");
            }

            // Xác định học sinh
            $studentId = $this->determineStudentId($currentAdmin, $studentIdFromFrontend);
            $student = Admin::find($studentId);
            if (!$student) {
                throw new Exception("Học sinh không tồn tại.");
            }

            $createdBookings = [];

            foreach ($bookingItemsData as $item) {
                if (!isset($item['teacher_lesson_id'], $item['course_id'], $item['date'], $item['start_time'])) {
                    throw new Exception("Thiếu thông tin cần thiết cho một buổi học.");
                }

                // 🎯 1. Kiểm tra ngày giờ phải lớn hơn hiện tại
                $bookingDateTime = Carbon::parse($item['date'] . ' ' . $item['start_time']);
                if ($bookingDateTime->lte(now())) {
                    throw new Exception("Thời gian học phải lớn hơn thời điểm hiện tại.");
                }

                // 🎯 2. Kiểm tra trùng lịch học
                $this->validateBookingConflict($studentId, $item['date'], $item['start_time']);

                // 🎯 3. Lấy thông tin teacher lesson
                $teacherLesson = $this->getTeacherLesson($item['teacher_lesson_id']);

                // 🎯 4. Xử lý ticket theo role
                if ($currentAdmin->hasRole('student')) {
                    $ticketType = 'normal'; // Student tự đăng ký chỉ dùng normal

                    $tickets = TicketStudent::where('admin_id', $studentId)
                        ->whereHas('ticket', fn($q) => $q->where('type', $ticketType))
                        ->where('expired_date', '>=', Carbon::today())
                        ->where('remaining_tickets', '>', 0)
                        ->orderBy('expired_date', 'asc')
                        ->get();

                    if ($tickets->isEmpty()) {
                        throw new Exception("Bạn không còn vé loại thường hợp lệ để đăng ký buổi học.");
                    }

                    $usedTicket = $this->findAvailableTicket($tickets);
                } else {
                    $ticketType = $item['ticket_type'] ?? null;

                    if (!$ticketType) {
                        throw new Exception("Thiếu thông tin loại vé (ticket_type) khi admin đăng ký.");
                    }

                    $tickets = $this->getTicketsByType($studentId, 1, $ticketType);
                    $usedTicket = $this->findTicketByType($tickets, $ticketType);

                    if (!$usedTicket) {
                        throw new Exception("Không còn vé hợp lệ cho loại vé {$ticketType}.");
                    }
                }

                // 🎯 5. Tạo booking
                $booking = $this->createBooking($studentId, $teacherLesson, $usedTicket);
                $createdBookings[] = $booking;

                // 🎯 6. Gửi thông báo cho giáo viên
                $this->sendTeacherNotification($booking, $teacherLesson);

                // 🎯 7. Cập nhật vé
                $usedTicket->decrement('remaining_tickets');
                if ($usedTicket->remaining_tickets <= 0) {
                    $usedTicket->status = 'no_ticket';
                    $usedTicket->save();
                }
            }

            DB::commit();

            // 🎯 8. Gửi notification cho super admin
            $this->sendSuperAdminNotifications($createdBookings);

            return $createdBookings;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Booking creation failed: " . $e->getMessage());
            throw $e;
        }
    }



    // Chỉ dành cho Admin đăng ký thay cho học sinh
    public function adminRegister(Request $request): array
    {
        $currentAdmin = auth('admin')->user();
        $bookingItemsData = $request->all();
        $studentIdFromFrontend = $bookingItemsData[0]['student_id'] ?? null;

        return $this->processBookingRequest($bookingItemsData, $currentAdmin, $studentIdFromFrontend);
    }

    // Chỉ dành cho Student đăng ký buổi học cho chính mình
    public function studentRegister(Request $request): array
    {
        $currentStudent = auth('admin')->user();
        $bookingItemsData = $request->all();

        return $this->processBookingRequest($bookingItemsData, $currentStudent);
    }

    private function sendTeacherNotification($booking, $teacherLesson): void
    {
        $student = Admin::find($booking->admin_id);
        $studentName = $student?->fullname ?? 'Học viên';

        $this->createNotification(
            'Bạn có một học sinh mới đăng ký buổi học',
            "Buổi học ngày {$booking->date} từ {$booking->start_time} đã được đăng ký bởi {$studentName}.",
            $teacherLesson->admin_id
        );

        $this->sendEmailNotificationToTeacher($booking, $studentName, $teacherLesson->teacher);
    }

    private function sendSuperAdminNotifications(array $createdBookings): void
    {
        $superAdmins = Admin::whereHas('roles', function ($q) {
            $q->where('name', 'superAdmin');
        })->get();

        foreach ($createdBookings as $booking) {
            $student = Admin::find($booking->admin_id);
            $studentName = $student?->fullname ?? 'Học viên';

            foreach ($superAdmins as $admin) {
                $this->createNotification(
                    'Học sinh vừa đăng ký buổi học',
                    "{$studentName} đã đăng ký buổi học ngày {$booking->date}.",
                    $admin->id
                );

                $this->sendEmailNotificationToAdmin($admin, $booking, $studentName);
            }
        }
    }

    private function createNotification(string $title, string $message, int $adminId): void
    {
        $this->notificationRepository->create([
            'title' => $title,
            'message' => $message,
            'status' => NotificationStatus::NOT_READ->value,
            'admin_id' => $adminId,
        ]);
    }

    private function sendEmailNotificationToTeacher($booking, string $studentName, Admin $teacher): void
    {
        if (!$teacher || !$teacher->email) return;

        try {
            Mail::to($teacher->email)->send(new RegisterLessonNotificationMail([
                'title' => 'Bạn có một buổi học mới được đăng ký',
                'content' => "Buổi học ngày {$booking->date} từ {$booking->start_time} đã được đăng ký bởi {$studentName}.",
            ]));
        } catch (Exception $e) {
            Log::warning('Failed to send email to teacher: ' . $e->getMessage());
        }
    }

    private function sendEmailNotificationToAdmin(Admin $admin, $booking, string $studentName): void
    {
        if (!$admin->email) return;

        try {
            Mail::to($admin->email)->send(new RegisterLessonNotificationMail([
                'title' => 'Học sinh mới đăng ký buổi học',
                'content' => "{$studentName} đã đăng ký buổi học vào ngày {$booking->date}.",
            ]));
        } catch (Exception $e) {
            Log::warning('Failed to send email to admin: ' . $e->getMessage());
        }
    }

    public function update(Request $request): object|bool
    {
        $this->data = $request->validated();
        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function confirm($id)
    {
        DB::beginTransaction();
        try {
            $booking = $this->repository->findOrFail($id);

            if ($booking->course->is_registered) {
                return false;
            }

            $booking->update(['status' => BookingStatus::Confirmed]);
            $booking->course->update([
                'student_id' => $booking->admin_id,
                'is_registered' => 1,
                'purchase_count' => $booking->course->purchase_count + 1
            ]);

            $this->createLessonsForCourse($booking->course);

            $this->createNotification(
                'Đơn đăng ký đã được duyệt',
                'Đơn đăng ký #' . $booking->id . ' đã được duyệt.',
                $booking->admin_id
            );

            $this->createNotification(
                'Khoá học của bạn vừa có người đăng ký',
                'Khoá học ' . $booking->course->name . ' của bạn vừa được học viên đăng ký.',
                $booking->course->teacher_id
            );

            DB::commit();
            return true;
        } catch (Exception $e) {
            $this->logError('Failed to confirm booking: ', $e);
            DB::rollBack();
            return false;
        }
    }

    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $booking = $this->repository->update($id, ['status' => BookingStatus::Cancelled]);

            $this->createNotification(
                'Đơn đăng ký đã bị từ chối',
                'Đơn đăng ký #' . $booking->id . ' đã bị từ chối.',
                $booking->admin_id
            );

            DB::commit();
            return true;
        } catch (Exception $e) {
            $this->logError('Failed to cancel booking: ', $e);
            DB::rollBack();
            return false;
        }
    }

    protected function createLessonsForCourse($course)
    {
        $schedule = json_decode($course->schedule, true);
        $startDate = Carbon::parse($course->start_date);
        $endDate = Carbon::parse($course->end_date);

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            if (in_array($currentDate->dayOfWeekIso, $schedule)) {
                $this->lessonRepository->create([
                    'course_id' => $course->id,
                    'admin_id' => $course->student_id,
                    'date' => $currentDate->toDateString(),
                    'is_active' => 1,
                    'name' => $this->createCodeUser(),
                    'start_time' => $course->start_time,
                    'end_time' => $course->end_time,
                ]);
            }
            $currentDate->addDay();
        }
    }

    protected function checkConflicts($data)
    {
        $schedule = json_decode($data['schedule']);
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $studentId = $data['student_id'];
        $startTime = $data['start_time'];
        $endTime = $data['end_time'];

        $isConflict = $this->repository->getConflictBooking(
            $schedule,
            $startDate,
            $endDate,
            $startTime,
            $endTime,
            $studentId,
        );

        return $isConflict ? 1 : null;
    }

    private function check()
    {
        $ticket = $this->ticketStudentRepository->findByField('admin_id', auth()->user()->id);
        return (bool) $ticket;
    }

    public function checkLessonConflicts($request, $studentLesson, $teacherLesson, $startTime)
    {
        if (!$studentLesson) {
            return back()->with('error', __('Student lesson not found.'));
        }

        if (!$teacherLesson) {
            return back()->with('error', __('Teacher lesson not found.'));
        }

        $existingStudentLesson = DB::table('student_lessons')
            ->where('date', $request->input('date'))
            ->where('start_time', $startTime)
            ->where('admin_id', $studentLesson->admin_id)
            ->first();

        if ($existingStudentLesson) {
            return back()->with('error', __('Học sinh này có buổi học bị trùng, vui lòng nhập thời gian học khác.'));
        }

        $existingTeacherLesson = DB::table('teacher_lessons')
            ->join('student_lessons', 'teacher_lessons.id', '=', 'student_lessons.teacher_lesson_id')
            ->where('student_lessons.date', $request->input('date'))
            ->where('student_lessons.start_time', $startTime)
            ->where('teacher_lessons.admin_id', $teacherLesson->admin_id)
            ->first();

        if ($existingTeacherLesson) {
            return back()->with('error', __('The teacher already has a lesson at the same date and start time.'));
        }

        return null;
    }

    public function createLessonWithTransaction($request, $studentLesson, $startTime)
    {
        if ($request->input('date') <= now()->startOfDay()) {
            return back()->with('error', __('Thời gian học phải lớn hơn ngày hiện tại.'));
        }

        if (!$studentLesson) {
            return back()->with('error', __('Student lesson not found.'));
        }

        $teacherLesson = $this->teacherLessonRepository->find($studentLesson->teacher_lesson_id);
        if (!$teacherLesson) {
            return back()->with('error', __('Teacher lesson not found.'));
        }

        $existingStudentLesson = DB::table('student_lessons')
            ->where('date', $request->input('date'))
            ->where('start_time', $startTime)
            ->where('admin_id', $studentLesson->admin_id)
            ->first();

        if ($existingStudentLesson) {
            return back()->with('error', __('Học sinh này có buổi học bị trùng, vui lòng nhập thời gian học khác.'));
        }

        $existingTeacherLesson = DB::table('teacher_lessons')
            ->join('student_lessons', 'teacher_lessons.id', '=', 'student_lessons.teacher_lesson_id')
            ->where('student_lessons.date', $request->input('date'))
            ->where('student_lessons.start_time', $startTime)
            ->where('teacher_lessons.admin_id', $teacherLesson->admin_id)
            ->first();

        if ($existingTeacherLesson) {
            return back()->with('error', __('The teacher already has a lesson at the same date and start time.'));
        }

        DB::beginTransaction();
        try {
            $lesson = $this->lessonRepository->create([
                'start_time' => $startTime,
                'date' => $request->input('date'),
                'course_id' => $request->input('course_id'),
            ]);

            $adminId = $teacherLesson->admin_id;

            $newTeacherLessonId = DB::table('teacher_lessons')->insertGetId([
                'admin_id' => $adminId,
                'lesson_id' => $lesson->id,
            ]);

            $this->studentLessonRepository->create([
                'admin_id' => $studentLesson->admin_id,
                'teacher_lesson_id' => $newTeacherLessonId,
                'note' => $studentLesson->note,
                'file' => $studentLesson->file,
                'file_link' => $studentLesson->file_link,
                'date' => $lesson->date,
                'start_time' => $lesson->start_time,
                'course_name' => $lesson->course->name,
                'teacher_review' => $studentLesson->teacher_review,
                'student_review' => $studentLesson->student_review,
            ]);

            $oldLesson = $studentLesson->teacher_lesson->lesson;
            $this->studentLessonRepository->delete($studentLesson->id);
            $this->teacherLessonRepository->delete($teacherLesson->id);
            $this->lessonRepository->delete($oldLesson->id);

            DB::commit();
            return back()->with('success', __('Lesson created successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create lesson: ' . $e->getMessage());
            return back()->with('error', __('Failed to create lesson.'));
        }
    }
}
