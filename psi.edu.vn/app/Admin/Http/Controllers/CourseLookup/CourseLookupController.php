<?php

namespace App\Admin\Http\Controllers\CourseLookup;

use App\Admin\Repositories\Course\CourseRepositoryInterface;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Services\Course\CourseServiceInterface;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use App\Admin\Http\Controllers\Controller;
use App\Traits\ResponseController;
use App\Admin\Traits\AuthService;
use App\Models\Course;
use App\Traits\UseLog;


class CourseLookupController extends Controller
{
    use ResponseController, AuthService, UseLog;

    protected $courseRepository;
    protected $courseService;
    protected $categoryRepository;
    protected $ticketRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepository,
        CourseServiceInterface $courseService,
        CategoryRepositoryInterface $categoryRepository,
        TicketRepositoryInterface $ticketRepository,
    ) {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
        $this->courseRepository = $courseRepository;
        $this->courseService = $courseService;
        $this->ticketRepository = $ticketRepository;
    }
    public function getView()
    {
        return [
            'index' => 'admin.course_lookup.index-test',
            'detail' => 'admin.course_lookup.detail',
        ];
    }
    public function index()
    {

        $auth = auth('admin')->user();
        $types = $this->ticketRepository->getTypeTicket();
        $categories = $this->categoryRepository->getAll();
        return view($this->view['index'], [
            'categories' => $categories,
            'types' => $types,
            'breadcrumbs' => $this->crums->add(__('Đăng ký buổi học')),
        ]);
    }

    public function detail($id)
    {
        $course = $this->courseRepository->findOrFail($id);
        $teachers = $this->courseService->getTeacherNames($id);
        $categories = $this->categoryRepository->getBy(['is_active' => 1]);
        return view($this->view['detail'], [
            'course' => $course,
            'teachers' => $teachers,
            'categories' => $categories,
        ]);
    }


    public function getCourses($id)
    {
        // Lấy danh sách khóa học theo categoryId
        $courses = Course::whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->get();
        if ($courses->isEmpty()) {
            return response()->json(['message' => __('Không có khóa học nào.')], 404);
        }

        return response()->json($courses);
    }
}
