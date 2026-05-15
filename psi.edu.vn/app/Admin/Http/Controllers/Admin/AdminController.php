<?php

namespace App\Admin\Http\Controllers\Admin;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Admin\AdminRequest;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Services\Admin\AdminServiceInterface;
use App\Admin\DataTables\Admin\AdminDataTable;
use App\Admin\DataTables\StudentLesson\StudentLessonDataTable;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use App\Admin\Traits\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    use AuthService;
    protected $lessonRepository;
    protected $studentLessonRepository;
    public function __construct(
        LessonRepositoryInterface $lessonRepository,
        AdminRepositoryInterface $repository,
        StudentLessonRepositoryInterface $studentLessonRepository,
        AdminServiceInterface $service,
    ) {

        parent::__construct();

        $this->lessonRepository = $lessonRepository;
        $this->repository = $repository;
        $this->studentLessonRepository = $studentLessonRepository;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.admins.index',
            'create' => 'admin.admins.create',
            'edit' => 'admin.admins.edit',
            'student-schedule' => 'admin.schedule.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.admin.index',
            'create' => 'admin.admin.create',
            'edit' => 'admin.admin.edit',
            'delete' => 'admin.admin.delete'
        ];
    }
    public function index(AdminDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách admin'))
        ]);
    }

    public function schedule(StudentLessonDataTable $dataTable)
    {
        $admin = $this->repository->findOrFail(auth('admin')->user()->id);
        $upcomingLessons = $this->studentLessonRepository->getUpcomingStudentLessonsByStudentId($admin->id);
        $completedLessons = $this->studentLessonRepository->getUpcomingStudentLessonsByStudentId($admin->id, true);
        return $dataTable->render($this->view['student-schedule'], [
            'upcomingLessons' => $upcomingLessons,
            'completedLessons' => $completedLessons,
        ]);
    }


    public function create(): Factory|View|Application
    {
        $roles = $this->repository->getAllRolesByGuardName('admin');
        return view($this->view['create'], [
            'roles' => $roles,
            'breadcrumbs' => $this->crums->add(
                __('Danh sách admin'),
                route($this->route['index'])
            )->add(__('add')),
        ]);
    }


    public function store(AdminRequest $request): RedirectResponse
    {

        $instance = $this->service->store($request);
        $instance->syncRoles($request->roles);

        return to_route($this->route['edit'], $instance->id);
    }

    public function edit($id): Factory|View|Application
    {

        $instance = $this->repository->findOrFail($id);
        $roles = $this->repository->getAllRolesByGuardName('admin');
        return view(
            $this->view['edit'],
            [
                'admin' => $instance,
                'roles' => $roles,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách admin'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(AdminRequest $request): RedirectResponse
    {

        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));
    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
