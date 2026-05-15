<?php

namespace App\Admin\Services\TeacherLesson;

use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\TeacherLesson\TeacherLessonRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use Exception;

class TeacherLessonService implements TeacherLessonServiceInterface
{
    use AuthService, UseLog, Setup;
    protected $data;
    protected $repository;
    public function __construct(TeacherLessonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function delete($id): array
    {
        $teacherLesson = $this->repository->find($id);
        if (!$teacherLesson) {
            return [
                'success' => false,
                'message' => __('Không tìm thấy Teacher Lesson với ID này.'),
            ];
        }
        $hasStudentLessons = $teacherLesson->studentLesson()->exists();
        if ($hasStudentLessons) {
            return [
                'success' => false,
                'message' => __('Không thể xóa vì có học sinh đã đăng ký.'),
            ];
        }
        $this->repository->delete($id);
        return [
            'success' => true,
            'message' => __('Xóa thành công.'),
        ];
    }
}
