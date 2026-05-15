<?php

namespace App\Admin\Services\ScheduleOff;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Services\ScheduleOff\ScheduleOffServiceInterface;
use  App\Admin\Repositories\ScheduleOff\ScheduleOffRepositoryInterface;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use App\Admin\Services\File\FileService;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Enums\Lesson\DayOffType;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Support\Facades\DB;

class ScheduleOffService implements ScheduleOffServiceInterface
{
    use Setup;
    protected $data;

    protected $repository;
    protected $adminRepository;
    protected $notificationRepository;
    protected $studentLessonRepository;

    public function __construct(
        ScheduleOffRepositoryInterface $repository,
        AdminRepositoryInterface $adminRepository,
        NotificationRepositoryInterface $notificationRepository,
        StudentLessonRepositoryInterface $studentLessonRepository,
    ) {
        $this->repository = $repository;
        $this->adminRepository = $adminRepository;
        $this->notificationRepository = $notificationRepository;
        $this->studentLessonRepository = $studentLessonRepository;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->data = $request->validated();
            $admin = $this->adminRepository->find($this->data['admin_id']);
            if ($admin->isSuperAdmin) {
                return false;
            }
            if ($admin->isStudent) {
                $this->data['student_id'] = $admin->id;
                $this->data['is_active'] = 1;
                $isExist = $this->repository->getBy(['student_id' => $admin->id, 'student_lesson_id' => $this->data['student_lesson_id']])->first();
                if ($isExist) {
                    $isExist->update(['reason' => $this->data['reason']]);
                } else {
                    $admin->update(['remaining_leave_requests' => $admin->remaining_leave_requests - 1]);
                    $instance = $this->repository->create($this->data);
                    $instance->student_lesson->update(['day_off_type' => DayOffType::Student->value]);
                }
                $studentLesson= $this->studentLessonRepository->find($this->data['student_lesson_id']);
                $date = format_date($studentLesson->date, 'd-m-Y');
                $teacherLesson = $studentLesson->teacherLesson;
                $teacher = $teacherLesson->teacher;

                $this->createNotification(
                    'Học viên gửi yêu cầu xin nghỉ',
                    "Buổi học vào lúc {$studentLesson->start_time} {$date}. Hãy tiến hành duyệt và tạo buổi bù",
                    $teacher->id,
                );
            }
            if ($admin->isTeacher) {
                $this->data['teacher_id'] = $admin->id;
                $this->data['is_active'] = 0;
                $isExist = $this->repository->getBy(['teacher_id' => $admin->id, 'student_lesson_id' => $this->data['student_lesson_id']])->first();
                if ($isExist) {
                    $isExist->update(['reason' => $this->data['reason']]);
                } else {
                    $this->repository->create($this->data);
                }
                $studentLesson = $this->studentLessonRepository->find($this->data['student_lesson_id']);
                $date = format_date($studentLesson->date, 'd-m-Y');
                $superAdmins = $this->adminRepository->getAllByRole();
                foreach ($superAdmins as $superAdmin) {
                    $this->createNotification(
                        'Giáo viên gửi yêu cầu xin nghỉ',
                        "Buổi học vào lúc {$studentLesson->start_time} {$date}. Hãy tiến hành duyệt và tạo buổi bù",
                        $superAdmin->id,
                    );
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Request $request)
    {
        $this->data = $request->validated();
        $instance = $this->repository->findOrFail($this->data['id']);
        if ($instance->is_active == 0 && $this->data['is_active'] == 1) {
            if ($instance->student_id) {
                $instance->student_lesson->update(['day_off_type' => DayOffType::Student->value]);
            } else {
                $date = format_date($instance->student_lesson->date, 'd-m-Y');
                $this->createNotification(
                    'Yêu cầu xin nghỉ đã được duyệt',
                    "Yêu cầu xin nghỉ buổi học vào lúc {$instance->student_lesson->start_time} {$date} đã được duyệt.",
                    $instance->teacher_id,
                );
                $instance->student_lesson->update(['day_off_type' => DayOffType::Teacher->value]);
            }
        }
        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id)
    {
        $instance = $this->repository->findOrFail($id);
        if ($instance->student_id) {
            $instance->student_lesson->update(['day_off_type' => DayOffType::None->value]);
        }
        return $this->repository->delete($id);
    }

    public function createNotification($title, $message, $adminId)
    {
        $notificationData = [
            'title' => $title,
            'message' => $message,
            'status' => NotificationStatus::NOT_READ->value,
            'admin_id' => $adminId,
        ];
        $this->notificationRepository->create($notificationData);
    }
}
