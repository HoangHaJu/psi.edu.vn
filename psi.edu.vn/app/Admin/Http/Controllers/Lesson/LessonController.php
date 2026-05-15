<?php

namespace App\Admin\Http\Controllers\Lesson;

use App\Admin\Repositories\Course\CourseRepositoryInterface;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Admin\Services\Lesson\LessonServiceInterface;
use App\Admin\Http\Requests\Lesson\LessonRequest;
use App\Admin\DataTables\Lesson\LessonDataTable;
use Illuminate\Contracts\Foundation\Application;
use App\Admin\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Traits\ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\UseLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; // thêm ở đầu file nếu chưa có

class LessonController extends Controller
{
    use ResponseController, UseLog;
    protected $courseRepository;
    public function __construct(
        LessonRepositoryInterface $repository,
        CourseRepositoryInterface $courseRepository,
        LessonServiceInterface $service,
    ) {

        parent::__construct();
        $this->repository = $repository;
        $this->courseRepository = $courseRepository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.lessons.index',
            'create' => 'admin.lessons.create',
            'edit' => 'admin.lessons.edit',
            'detail' => 'admin.lessons.detail',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.lesson.index',
            'course' => 'admin.course.index',
            'create' => 'admin.lesson.create',
            'edit' => 'admin.lesson.edit',
            'delete' => 'admin.lesson.delete'
        ];
    }

    public function index($course_id, LessonDataTable $dataTable)
    {
        $course = $this->courseRepository->findOrFail($course_id);
        return $dataTable
            ->with(
                'course',
                $course,
            )
            ->render($this->view['index'], [
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách khoá học'),
                    route($this->route['course'])
                )->add(__('Danh sách buổi học'))
            ]);
    }
    public function create($id): Factory|View|Application
    {
        return view($this->view['create'], [
            'course_id' => $id,
            'breadcrumbs' => $this->crums->add(
                __('Danh sách khoá học'),
                route($this->route['course'])
            )->add(
                __('Danh sách buổi học'),
                route($this->route['index'], ['id' => $id])
            )->add(__('add')),
        ]);
    }


    public function store(LessonRequest $request)
    {
        try {
            DB::beginTransaction();

            $startTime = $request->input('start_time');
            $endTime = $request->input('end_time');
            $period = $request->input('period'); // minutes
            $courseId = $request->input('course_id');
            $dateRange = $request->input('daterange'); // "YYYY-MM-DD - YYYY-MM-DD"

            // 🔹 Kiểm tra giờ kết thúc phải lớn hơn giờ bắt đầu
            if (Carbon::parse($endTime)->lte(Carbon::parse($startTime))) {
                return back()
                    ->withInput()
                    ->with('error', 'Giờ kết thúc phải lớn hơn giờ bắt đầu.');
            }

            [$startDate, $endDate] = explode(' - ', $dateRange);
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->startOfDay();

            $timeIntervals = $this->service->generateTimeIntervals($startTime, $endTime, $period);

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                if ($date->lt(now()->startOfDay())) {
                    Log::info("Bỏ qua ngày quá khứ: " . $date->toDateString());
                    continue;
                }

                foreach ($timeIntervals as $time) {
                    $isExist = $this->repository->getBy([
                        'course_id' => $courseId,
                        'start_time' => $time,
                        'date' => $date->toDateString()
                    ])->first();

                    if ($isExist) {
                        Log::info("Đã tồn tại: course_id={$courseId}, date={$date->toDateString()}, time={$time}");
                        continue;
                    }

                    $this->service->store(new Request([
                        'start_time' => $time,
                        'course_id' => $courseId,
                        'date' => $date->toDateString()
                    ]));

                    Log::info("Tạo mới: course_id={$courseId}, date={$date->toDateString()}, time={$time}");
                }
            }

            DB::commit();

            return to_route('admin.lesson.index', $courseId)->with('success', __('Tạo các buổi học thành công'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Lỗi tạo buổi học: ' . $th->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi: ' . $th->getMessage());
        }
    }

    public function edit($id): Factory|View|Application
    {
        $lesson = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'lesson' => $lesson,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách khoá học'),
                    route($this->route['course'])
                )->add(
                    __('Danh sách buổi học'),
                    route($this->route['index'], $lesson->course_id)
                )->add(__('edit'))
            ],
        );
    }

    public function update(LessonRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);
        if ($response) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function delete($id): RedirectResponse
    {
        $lesson = $this->repository->findOrFail($id);
        $result = $this->service->delete($id);
        if ($result) {
            return to_route($this->route['index'], ['id' => $lesson->course_id])->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }
}
