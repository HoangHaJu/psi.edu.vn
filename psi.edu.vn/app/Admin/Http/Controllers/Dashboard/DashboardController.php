<?php

namespace App\Admin\Http\Controllers\Dashboard;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use Illuminate\Http\{
    JsonResponse,
    Request
};
use App\Models\Admin;

class DashboardController extends Controller
{
    use AuthService;
    protected $notificationRepository;
    protected $lessonRepository;
    protected $studentLessonRepository;
    protected $adminRepository;
    protected $postRepository;
    protected $ticketStudentRepository;

    protected $ticketRepository;
    public function __construct(
        NotificationRepositoryInterface $repository,
        PostRepositoryInterface $postRepository,
        LessonRepositoryInterface $lessonRepository,
        AdminRepositoryInterface $adminRepository,
        StudentLessonRepositoryInterface $studentLessonRepository,
        TicketStudentRepositoryInterface $ticketStudentRepository,
        TicketRepositoryInterface $ticketRepository,

    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->lessonRepository = $lessonRepository;
        $this->studentLessonRepository = $studentLessonRepository;
        $this->adminRepository = $adminRepository;
        $this->postRepository = $postRepository;
        $this->ticketStudentRepository = $ticketStudentRepository;
        $this->ticketRepository = $ticketRepository;
    }


    public function getView()
    {
        return [
            'index' => 'admin.dashboard.index',
            'index-default' => 'admin.dashboard.index-default',
            'notification-page' => 'admin.dashboard.notification-page',
            'post-detail' => 'admin.dashboard.post-detail',
            'post' => 'admin.dashboard.post',
        ];
    }

    public function index()
    {
        $admin = $this->getCurrentAdmin();
        $notifications = $this->repository->getByAdminIdAndLatest($this->getCurrentAdminId());

        // Lấy danh sách bài học dựa trên vai trò
        $lessons = $admin->isStudent
            ? $this->studentLessonRepository->getLessonsByRole($admin->id, 'student')
            : $this->studentLessonRepository->getLessonsByRole($admin->id, 'teacher');

        $hasTicket = false;
        if ($admin->isStudent) {
            $hasTicket = $this->ticketStudentRepository->checkExistsByAdminId($admin->id);
        }

        $upcomingLessons = $this->studentLessonRepository
            ->getUpcomingStudentLessonsByStudentId($admin->id, true);

        $upcomingTeacherLessons = $this->studentLessonRepository
            ->getUpcomingStudentLessonsByTeacherId($admin->id, true);

        $posts = $this->postRepository->getLatestPosts(3);

        $tickets = $this->ticketRepository->getAll();

        return view($this->view['index'], [
            'notifications' => $notifications,
            'lessons' => $lessons,
            'upcomingLessons' => $upcomingLessons,
            'upcomingTeacherLessons' => $upcomingTeacherLessons,
            'posts' => $posts,
            'hasTicket' => $hasTicket,
            'tickets' => $tickets,
        ]);
    }


    public function notificationsPage()
    {
        $notifications = $this->repository->getByAdminIdAndPaginate($this->getCurrentAdminId());
        return view($this->view['notification-page'], [
            'notifications' => $notifications
        ]);
    }

    public function postDetail($id)
    {
        $post = $this->postRepository->find($id);
        return view($this->view['post-detail'], [
            'post' => $post
        ]);
    }

    public function post()
    {
        $posts = $this->postRepository->getQueryBuilderOrderBy()->get();
        return view($this->view['post'], [
            'posts' => $posts
        ]);
    }

    public function resetAllStudentRemainingLeave()
    {
        $students = $this->adminRepository->getAllByRole('student');
        foreach ($students as $student) {
            $this->adminRepository->resetRemainingLeaveCount($student->id);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Số lượt xin nghỉ của học viên đã được reset về 10.');
    }

    public function switchTypeTicket(Request $request, $id)
    {
        $request->validate([
            'current_type_ticket' => 'required|in:none,normal,special'
        ]);

        // Tìm user theo id
        $student = Admin::findOrFail($id);

        $availableTickets = $this->ticketStudentRepository->getUserTicketTypes($student->id);

        // Kiểm tra xem user có role 'student' không
        if (!$student->hasRole('student')) {
            return response()->json([
                'message' => 'Người dùng không phải student'
            ], 403);
        }

        // Cập nhật vé hiện tại
        $student->update([
            'current_type_ticket' => $request->current_type_ticket
        ]);

        return response()->json([
            'message' => 'Cập nhật loại vé thành công',
            'current_type_ticket' => $student->current_type_ticket,
            'available_tickets' => $availableTickets
        ]);
    }
}
