<?php

namespace App\Admin\Http\Controllers\TeacherLesson;

use App\Admin\DataTables\TeacherLesson\TeacherLessonDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\TeacherLesson\TeacherLessonRepositoryInterface;
use App\Admin\Services\TeacherLesson\TeacherLessonServiceInterface;
use App\Traits\ResponseController;
use App\Traits\UseLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TeacherLesson;
use Illuminate\Support\Facades\Log;

class TeacherLessonController extends Controller
{
    use ResponseController, UseLog;
    public function __construct(
        TeacherLessonRepositoryInterface $repository,
        TeacherLessonServiceInterface $service,
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.teacher_lessons.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.teacher_lesson.index',
        ];
    }

    public function index(TeacherLessonDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách Buổi học - Giáo viên'))
        ]);
    }

    public function delete($id): RedirectResponse
    {
        $result = $this->service->delete($id);
        if ($result['success']) {
            return to_route($this->route['index'])
                ->with('success', __('notifySuccess'));
        } else {
            return to_route($this->route['index'])
                ->with('error', $result['message']);
        }
    }

    public function trackJoinClass(Request $request)
    {
        $user = Auth::user();

        // 1. Chỉ cho phép giáo viên thực hiện tracking
        if (!$user || !$user->hasRole('teacher')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 2. Xác thực dữ liệu đầu vào
        $request->validate([
            'lesson_id' => 'required|integer|exists:teacher_lessons,lesson_id',
            'teacher_joined_at' => 'required|date',
        ]);

        $lessonId = $request->input('lesson_id');
        $teacherJoinedAtRaw = $request->input('teacher_joined_at');

        try {
            // 3. Tìm bản ghi TeacherLesson theo lesson_id và teacher_id
            $teacherLesson = TeacherLesson::where('lesson_id', $lessonId)
                ->where('admin_id', $user->id)
                ->first();

            if (!$teacherLesson) {
                return response()->json([
                    'message' => 'Không tìm thấy bản ghi bài học của giáo viên phù hợp'
                ], 404);
            }

            // 4. Dùng helper để track join time
            $tracked = trackJoinLesson($teacherLesson, 'teacher_joined_at', $teacherJoinedAtRaw);

            return response()->json([
                'message' => $tracked
                    ? 'Tracked successfully'
                    : 'Đã theo dõi thành công (thời gian đã được thiết lập trước đó)'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi theo dõi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
