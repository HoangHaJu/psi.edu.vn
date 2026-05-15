<?php

namespace App\Admin\Services\StudentLesson;

use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use Exception;

class StudentLessonService implements StudentLessonServiceInterface
{
    use AuthService, UseLog, Setup;

    protected $data;

    protected $repository;
    protected $ticketStudentRepository;
    protected $notificationRepository;
    public function __construct(
        StudentLessonRepositoryInterface $repository,
        NotificationRepositoryInterface $notificationRepository,
        TicketStudentRepositoryInterface $ticketStudentRepository,
    ) {
        $this->repository = $repository;
        $this->notificationRepository = $notificationRepository;
        $this->ticketStudentRepository = $ticketStudentRepository;
    }
    public function refundTicket($id): void
    {
        DB::beginTransaction();
        try {
            $now   = now();
            $start = $now->copy()->startOfDay();
            $end   = $now->copy()->setTime(15, 0, 0);

            if ($now->isSunday()) {
                throw new \Exception('Chủ nhật không được hoàn vé.');
            }

            if (! $now->between($start, $end->subSecond())) {
                throw new \Exception('Chỉ được hoàn vé từ 00:00 đến trước 15:00 mỗi ngày.');
            }

            $student_lesson = $this->repository->findOrFail($id);

            // ✅ Luôn hoàn vào đúng vé gốc đã dùng khi booking
            $ticketStudent = $this->ticketStudentRepository->find($student_lesson->ticket_id);

            if (! $ticketStudent) {
                throw new \Exception('Không tìm thấy vé gốc để hoàn.');
            }

            $ticketStudent->increment('remaining_tickets');
            $ticketStudent->refresh();

            // ✅ Chỉ chuyển status về active nếu vẫn cùng loại vé cũ (normal)
            if ($ticketStudent->remaining_tickets > 0 && $ticketStudent->status === 'no_ticket') {
                $ticketStudent->status = 'active';
                $ticketStudent->save();
            }

            $date = format_date($student_lesson->date, 'd-m-Y');

            $this->createNotification(
                'Học sinh vừa huỷ buổi học của bạn',
                "Buổi học vào lúc {$student_lesson->start_time} {$date} của khoá học {$student_lesson->course_name} vừa bị huỷ",
                $student_lesson->teacherLesson->admin_id,
            );

            $this->repository->delete($id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi hủy tiết học: ' . $e->getMessage(), [
                'id'       => $id,
                'admin_id' => auth('admin')->id(),
            ]);
            throw $e;
        }
    }

    private function createNotification($title, $message, $adminId)
    {
        $notificationData = [
            'title' => $title,
            'message' => $message,
            'status' => NotificationStatus::NOT_READ->value,
            'admin_id' => $adminId,
        ];
        $this->notificationRepository->create($notificationData);
    }

    public function getAverageRatingsForStudent($teacherId)
    {
        $averageRating = DB::table('student_lessons as s')
            ->join('teacher_lessons as t', 's.teacher_lesson_id', '=', 't.id')
            ->where('t.admin_id', $teacherId)
            ->selectRaw('AVG(s.rate) as avg_rate')
            ->value('avg_rate');
        return $averageRating;
    }
}
