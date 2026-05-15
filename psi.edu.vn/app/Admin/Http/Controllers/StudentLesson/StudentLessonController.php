<?php

namespace App\Admin\Http\Controllers\StudentLesson;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\StudentLesson\StudentLessonRequest;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use App\Admin\Services\StudentLesson\StudentLessonServiceInterface;
use App\Enums\Lesson\DayOffType;
use App\Enums\Lesson\LessonStatus;
use App\Traits\ResponseController;
use App\Traits\UseLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeacherReviewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{StudentLesson, TeacherLesson};

class StudentLessonController extends Controller
{
    use UseLog;
    use ResponseController;
    protected $reviewRepository;
    public function __construct(
        StudentLessonRepositoryInterface $repository,
        StudentLessonServiceInterface $service,
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'edit' => 'admin.student_lessons.edit',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.booking.index',
            'edit' => 'admin.lesson.edit',
        ];
    }

    public function edit($id): Factory|View|Application
    {
        $instance = $this->repository->findOrFail($id);
        $status = LessonStatus::asSelectArray();
        if (auth('admin')->user()->isTeacher) {
            unset($status[3]);
        }
        return view(
            $this->view['edit'],
            [
                'instance' => $instance,
                'status' => $status,
                'dayOffType' => DayOffType::asSelectArray(),
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách buổi học'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(StudentLessonRequest $request): RedirectResponse
    {
        $data = $request->validated();
        // Lấy bản ghi trước khi update để truy cập mối quan hệ student
        $instance = $this->repository->findOrFail($data['id']);
        $response = $this->repository->update($data['id'], $data);
        if ($response) {
            // Nếu teacher_review tồn tại và khác null
            if (!empty($data['teacher_review'])) {
                $studentEmail = $instance->student->email ?? null;

                if ($studentEmail) {
                    Mail::to('lel435564@gmail.com')->send(new TeacherReviewNotification($data, $instance));
                }
            }

            return back()->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }
    public function refundTicket($id)
    {
        try {
            $this->service->refundTicket($id);

            return back()->with('success', __('notifySuccess'));
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage() ?: __('notifyFail'))
                ->withInput();
        }
    }


    public function jitsi($teacher_id)
    {
        $room = 'room_' . $teacher_id;
        return view('admin.student_lessons.jitsi', ['room' => $room]);
    }

    public function trackJoinClass(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('student')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'lesson_id' => 'required|integer|exists:lessons,id',
            'student_joined_at' => 'required|date', // thêm validate thời gian join
        ]);

        $lessonId = $request->input('lesson_id');
        $studentJoinedAtRaw = $request->input('student_joined_at');

        try {
            // 1. Tìm teacher_lesson theo lesson_id (chỉ lấy 1 cái gần nhất nếu có nhiều)
            $teacherLesson = TeacherLesson::where('lesson_id', $lessonId)->first();

            if (!$teacherLesson) {
                return response()->json(['message' => 'Không tìm thấy teacher_lesson với lesson_id này'], 404);
            }

            // 2. Tìm student_lesson với student_id và teacher_lesson_id
            $studentLesson = StudentLesson::where('teacher_lesson_id', $teacherLesson->id)
                ->where('admin_id', $user->id)
                ->first();

            if (!$studentLesson) {
                return response()->json(['message' => 'Không tìm thấy student_lesson tương ứng'], 404);
            }

            // 3. Dùng helper để track student_joined_at
            $tracked = trackJoinLesson($studentLesson, 'student_joined_at', $studentJoinedAtRaw);

            return response()->json([
                'message' => $tracked
                    ? 'Tracked student join thành công'
                    : 'Thời gian đã được thiết lập trước đó',
                'student_joined_at' => $studentLesson->student_joined_at,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi tracking.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
