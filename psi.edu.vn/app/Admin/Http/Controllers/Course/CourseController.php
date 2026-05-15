<?php

namespace App\Admin\Http\Controllers\Course;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Course\CourseRequest;
use App\Admin\Repositories\Course\CourseRepositoryInterface;
use App\Admin\Services\Course\CourseServiceInterface;
use App\Admin\DataTables\Course\CourseDataTable;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Admin\Repositories\Review\ReviewRepositoryInterface;
use App\Enums\Admin\EducationLevel;
use App\Enums\Date\DayOfWeek;
use App\Exports\CoursesExport;
use App\Traits\ResponseController;
use App\Traits\UseLog;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    use ResponseController, UseLog;

    protected CategoryRepositoryInterface $categoryRepository;
    protected ReviewRepositoryInterface $reviewRepository;
    protected LessonRepositoryInterface $lessonRepository;
    protected AdminRepositoryInterface $adminRepository;

    public function __construct(
        AdminRepositoryInterface $adminRepository,
        ReviewRepositoryInterface $reviewRepository,
        CourseRepositoryInterface $repository,
        CategoryRepositoryInterface $categoryRepository,
        LessonRepositoryInterface $lessonRepository,
        CourseServiceInterface $service,
    ) {

        parent::__construct();
        $this->repository = $repository;
        $this->adminRepository = $adminRepository;
        $this->categoryRepository = $categoryRepository;
        $this->lessonRepository = $lessonRepository;
        $this->reviewRepository = $reviewRepository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.courses.index',
            'create' => 'admin.courses.create',
            'edit' => 'admin.courses.edit',
            'detail' => 'admin.courses.detail',
            'register-lessons' => 'admin.courses.register-lessons',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.course.index',
            'create' => 'admin.course.create',
            'edit' => 'admin.course.edit',
            'delete' => 'admin.course.delete',
            'registerLessons' => 'admin.course.registerLessons',
        ];
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            if (auth()->user()->isSuperAdmin) {
                DB::beginTransaction();

                $path = $request->file('excel_file')->getRealPath();
                $data = Excel::toArray([], $path);

                if (empty($data[0])) {
                    return redirect()->back()->with('error', 'File Excel không có dữ liệu!');
                }

                $headers = $data[0][0];

                foreach ($data[0] as $index => $row) {
                    if ($index === 0) {
                        continue;
                    }

                    $rowData = array_combine($headers, $row);
                    $this->repository->create($rowData);
                }

                DB::commit();
                return redirect()->back()->with('success', 'Dữ liệu đã được nhập thành công!');
            }
            return back()->with('error', 'Nhập dữ liệu không thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            $this->logError('Lỗi nhập dữ liệu từ file Excel!', $e);
            return redirect()->back()->with('error', 'Lỗi nhập dữ liệu từ file Excel!');
        }
    }

    public function export()
    {
        try {
            $categories = $this->repository->getAll();
            return Excel::download(new CoursesExport($categories), 'courses.xlsx');
        } catch (Exception $e) {
            $this->logError('Lỗi xuất dữ liệu khoá học!', $e);
            return redirect()->back()->with('error', 'Lỗi xuất dữ liệu khoá học!');
        }
    }

    public function index(CourseDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách khoá học'))
        ]);
    }

    public function create(): Factory|View|Application
    {
        $categories = $this->categoryRepository->getBy(['is_active' => 1]);
        return view($this->view['create'], [
            'categories' => $categories,
            'educationLevel' => EducationLevel::asSelectArray(),
            'dayOfWeek' => DayOfWeek::cases(),
            'breadcrumbs' => $this->crums->add(
                __('Danh sách khoá học'),
                route($this->route['index'])
            )->add(__('add')),
        ]);
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        $response = $this->service->store($request);
        if ($response === 1) {
            return back()->with('error', __('Lịch đăng ký bị trùng cho giáo viên.'))->withInput();
        }
        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);
    }

    public function detail($id): Factory|View|Application
    {
        $course = $this->repository->findOrFailWithRelations($id);
        $reviews = $this->reviewRepository->getReviewByCourseId($id);

        $adminId = auth('admin')->user()->id;

        $lessonsExist = DB::table('student_lessons')
            ->join('lessons', 'student_lessons.teacher_lesson_id', '=', 'lessons.id')
            ->where('lessons.course_id', $id)
            ->whereNotNull('lessons.course_id')
            ->where('student_lessons.admin_id', $adminId)
            ->where('student_lessons.status', 1)
            ->exists();

        $daysOfWeek = [
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
            7 => 'Chủ nhật',
        ];

        $scheduleText = $course->schedule
            ? collect(json_decode($course->schedule))
            ->map(fn($day) => $daysOfWeek[(int) $day] ?? '')
            ->filter()
            ->join(', ')
            : 'Chưa có lịch học';

        $allLessonsMarkedPresent = !DB::table('student_lessons')
            ->join('lessons', 'student_lessons.teacher_lesson_id', '=', 'lessons.id')
            ->where('lessons.course_id', $id)
            ->where('student_lessons.status', '=', \App\Enums\Lesson\LessonStatus::NotPresent->value)
            ->exists();

        return view(
            $this->view['detail'],
            [
                'course' => $course,
                'reviews' => $reviews,
                'lessonsExist' => $lessonsExist,
                'scheduleText' => $scheduleText,
                'allLessonsMarkedPresent' => $allLessonsMarkedPresent,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách khoá học'),
                    route($this->route['index'])
                )->add(__('Chi tiết khoá học'))
            ],
        );
    }

    public function registerLessons(Request $request, $id): Factory|View|Application
    {
        $course = $this->repository->findOrFailWithRelations($id);
        $lessons = $this->lessonRepository->getLessonsForTeacherToRegister($course->id);

        if (auth()->user()->isTeacher) {
            $teacher_id = auth()->user()->id;
        } else {
            $teacher_id = $request->input('teacher_id');
        }
        $teacher = $this->adminRepository->getTeacherTaughtLessons($teacher_id);

        return view(
            $this->view['register-lessons'],
            [
                'educationLevel' => EducationLevel::asSelectArray(),
                'course' => $course,
                'lessons' => $lessons,
                'teacher' => $teacher,
                'selected_teacher_id' => $teacher_id,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách khoá học'),
                    route($this->route['index'])
                )->add(__('Đăng ký buổi học'))
            ],
        );
    }
    public function lessons($teacherId)
    {
        $lessons = $this->lessonRepository->getLessonsForTeacher($teacherId);
        return response()->json($lessons);
    }



    public function storeRegistedLessons(Request $request)
    {
        $response = $this->service->storeRegistedLessons($request);
        if (is_string($response)) {
            // Trường hợp có lỗi trùng lịch
            return back()->with('error', $response);
        } elseif ($response === true) {
            // Thành công
            return back()->with('success', __('Đăng ký buổi học thành công.'));
        }

        // Nếu thất bại không rõ lý do
        return back()->with('error', __('Đã xảy ra lỗi khi đăng ký buổi học.'));
    }

    public function edit($id): Factory|View|Application
    {
        $categories = $this->categoryRepository->getBy(['is_active' => 1]);
        $lessons = $this->lessonRepository->getBy(['course_id' => $id])->sortBy('start_time');
        $course = $this->repository->findOrFailWithRelations($id);
        return view(
            $this->view['edit'],
            [
                'categories' => $categories,
                'educationLevel' => EducationLevel::asSelectArray(),
                'course' => $course,
                'lessons' => $lessons,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách khoá học'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(CourseRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);
        if ($response === 1) {
            return back()->with('error', __('Lịch đăng ký bị trùng cho giáo viên hoặc học viên.'));
        }
        if ($response) {
            return to_route($this->route['edit'], ['id' => $response->id])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {
        $result = $this->service->delete($id);
        if ($result === 1) {
            return back()->with('error', __('Không được xoá khoá học đã từng có người đăng ký.'));
        }
        if ($result) {
            return to_route($this->route['index'])->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }
}
