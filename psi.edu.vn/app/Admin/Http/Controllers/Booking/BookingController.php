<?php

namespace App\Admin\Http\Controllers\Booking;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Booking\BookingRequest;
use App\Admin\Repositories\{
    Admin\AdminRepositoryInterface,
    Booking\BookingRepositoryInterface,
    Category\CategoryRepositoryInterface,
    Course\CourseRepositoryInterface,
    Lesson\LessonRepositoryInterface,
    Review\ReviewRepositoryInterface,
    StudentLesson\StudentLessonRepositoryInterface,
    TeacherLesson\TeacherLessonRepositoryInterface,
    TicketStudent\TicketStudentRepositoryInterface,
};
use App\Admin\Services\{
    Booking\BookingServiceInterface,
    StudentLesson\StudentLessonServiceInterface,
    TicketStudent\TicketStudentServiceInterface,
};
use App\Admin\DataTables\StudentLesson\StudentLessonDataTable;
use App\Enums\{
    Admin\EducationLevel,
    Booking\BookingStatus,
    User\Gender
};
use App\Traits\UseLog;
use App\Admin\Traits\AuthService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class BookingController extends Controller
{
    use AuthService, UseLog;

    protected $categoryRepository, $adminRepository, $reviewRepository, $courseRepository, $ticketStudentRepository;
    protected $lessonRepository, $studentLessonRepository, $teacherLessonRepository;
    protected $studentlessonService, $ticketStudentService;
    protected $service, $repository;

    public function __construct(
        BookingRepositoryInterface $repository,
        CategoryRepositoryInterface $categoryRepository,
        AdminRepositoryInterface $adminRepository,
        ReviewRepositoryInterface $reviewRepository,
        LessonRepositoryInterface $lessonRepository,
        CourseRepositoryInterface $courseRepository,
        StudentLessonRepositoryInterface $studentLessonRepository,
        TeacherLessonRepositoryInterface $teacherLessonRepository,
        TicketStudentRepositoryInterface $ticketStudentRepository,
        BookingServiceInterface $service,
        TicketStudentServiceInterface $ticketStudentService,
        StudentLessonServiceInterface $studentlessonService,
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->adminRepository = $adminRepository;
        $this->reviewRepository = $reviewRepository;
        $this->courseRepository = $courseRepository;
        $this->lessonRepository = $lessonRepository;
        $this->studentLessonRepository = $studentLessonRepository;
        $this->ticketStudentRepository = $ticketStudentRepository;
        $this->teacherLessonRepository = $teacherLessonRepository;
        $this->service = $service;
        $this->ticketStudentService = $ticketStudentService;
        $this->studentlessonService = $studentlessonService;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.student_lessons.index',
            'create' => 'admin.bookings.create',
            'edit' => 'admin.bookings.edit',
            'payment' => 'admin.bookings.payment',
            'teacher-modal' => 'components.quickview',
            'ticket' => 'admin.bookings.ticket',
            'course' => 'admin.bookings.course',
            'lesson' => 'admin.bookings.lesson',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.booking.index',
            'create' => 'admin.booking.create',
            'edit' => 'admin.booking.edit',
            'delete' => 'admin.booking.delete',
            'payment' => 'admin.booking.payment',
            'ticket' => 'admin.booking.ticket',
            'course' => 'admin.booking.course',
            'lesson' => 'admin.booking.lesson',
        ];
    }

    public function index(StudentLessonDataTable $dataTable)
    {
        $studentLessons = $this->courseRepository->getAllCourseIdsByStudentLessons();
        $courseIds = [];

        foreach ($studentLessons as $lesson) {
            $courseIds[$lesson->student_lesson_id] = $lesson->course_id;
        }
        view()->share('courseIds', $courseIds);

        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách buổi học')),
        ]);
    }

    public function create(BookingRequest $request)
    {
        $data = $request->validated();
        $categories = $this->categoryRepository->getBy(['is_active' => 1]);
        $teachers = $this->adminRepository->getTeachersForSelection($data);
        $paginate = $teachers;

        $existTeacherLessonDateTime = $this->getCurrentAdmin()
            ->student_lessons
            ->map(fn($lesson) => $lesson->date . ' ' . $lesson->start_time)
            ->unique();

        if (!empty($teachers)) {
            $teachers = $teachers->map(function ($teacher) use ($existTeacherLessonDateTime, $data) {
                $teacherLessons = $teacher->teacher_lessons;
                $rateForStudent = $this->studentlessonService->getAverageRatingsForStudent($teacher->id);
                $filteredLessons = $teacherLessons->filter(function ($teacherLesson) use ($existTeacherLessonDateTime, $data) {
                    $lessonDateTime = $teacherLesson->lesson->date . ' ' . $teacherLesson->lesson->start_time;
                    $currentDate = Carbon::now()->startOfDay();
                    $lessonDate = Carbon::parse($teacherLesson->lesson->date)->startOfDay();
                    if (isset($data['date'])) {
                        $selectedDate = Carbon::parse($data['date'])->startOfDay();
                        return !$existTeacherLessonDateTime->contains($lessonDateTime)
                            && $lessonDate->isSameDay($selectedDate)
                            && $lessonDate->greaterThan($currentDate);
                    }
                    return !$existTeacherLessonDateTime->contains($lessonDateTime)
                        && $lessonDate->greaterThan($currentDate);
                });
                if ($filteredLessons->isEmpty()) {
                    return null;
                }
                $teacher->teacher_lessons = $filteredLessons;
                $teacher->rateForStudent = $rateForStudent;
                return $teacher;
            })->filter();
        }

        return view($this->view['create'], [
            'educationLevel' => EducationLevel::asSelectArray(),
            'categories' => $categories,
            'courseCategory' => isset($data['category_id']) ? $this->categoryRepository->find($data['category_id']) : null,
            'teachers' => $teachers,
            'paginate' => $paginate,
            'gender' => Gender::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('Danh sách đăng ký'), route($this->route['index']))->add(__('add')),
        ]);
    }
    public function adminRegister(BookingRequest $request)
    {
        return $this->handleBookingRequest(function () use ($request) {
            return $this->service->adminRegister($request);
        });
    }

    public function studentRegister(BookingRequest $request)
    {
        return $this->handleBookingRequest(function () use ($request) {
            return $this->service->studentRegister($request);
        });
    }

    public function store(BookingRequest $request)
    {
        return $this->handleBookingRequest(function () use ($request) {
            return $this->service->store($request);
        });
    }

    public function edit($id)
    {
        $booking = $this->repository->findOrFail($id);
        return view($this->view['edit'], [
            'booking' => $booking,
            'status' => BookingStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('Danh sách đăng ký'), route($this->route['index']))->add(__('edit'))
        ]);
    }

    public function update(BookingRequest $request)
    {
        $this->service->update($request);
        return back()->with('success', __('notifySuccess'));
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }

    public function confirm($id)
    {
        return $this->service->confirm($id)
            ? to_route($this->route['index'])->with('success', __('Duyệt thành công'))
            : to_route($this->route['index'])->with('error', __('Duyệt thất bại'));
    }

    public function cancel($id)
    {
        return $this->service->cancel($id)
            ? to_route($this->route['index'])->with('success', __('Huỷ thành công'))
            : to_route($this->route['index'])->with('error', __('Huỷ thất bại'));
    }

    private function handleBookingRequest(callable $callback)
    {
        try {
            $result = $callback();
            return response()->json([
                'message' => __('Đăng ký thành công!'),
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            $statusCode = 500;
            $errorMessage = __('Đăng ký thất bại. Vui lòng thử lại.');

            if (str_contains($e->getMessage(), 'trùng lịch')) {
                $statusCode = 409; // Conflict
                $errorMessage = $e->getMessage();
            } elseif (str_contains($e->getMessage(), 'không đủ vé')) {
                $statusCode = 403; // Forbidden
                $errorMessage = $e->getMessage();
            } else {
                $errorMessage = $e->getMessage();
            }

            return response()->json(['error' => $errorMessage], $statusCode);
        }
    }
}
