<?php

namespace App\Admin\Http\Controllers\Teacher;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Teacher\{TeacherCreateRequest, TeacherUpdateRequest};
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Services\Admin\AdminServiceInterface;
use App\Admin\DataTables\Admin\TeacherDatatable;
use App\Enums\User\Gender;
use App\Traits\UseLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TeacherController extends Controller
{
    use UseLog;
    public function __construct(
        AdminRepositoryInterface $repository,
        AdminServiceInterface $service
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.teachers.index',
            'create' => 'admin.teachers.create',
            'edit' => 'admin.teachers.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.teacher.index',
            'create' => 'admin.teacher.create',
            'edit' => 'admin.teacher.edit',
            'delete' => 'admin.teacher.delete'
        ];
    }
    public function index(TeacherDatatable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách giáo viên'))
        ]);
    }

    public function create(): Factory|View|Application
    {
        return view($this->view['create'], [
            'gender' => Gender::asSelectArray(),
            'breadcrumbs' => $this->crums->add(
                __('Danh sách giáo viên'),
                route($this->route['index'])
            )->add(__('add')),
        ]);
    }


    public function store(TeacherCreateRequest $request): RedirectResponse
    {
        $instance = $this->service->store($request, 'teacher');
        return to_route($this->route['edit'], $instance->id);
    }

    public function edit($id): Factory|View|Application
    {
        $instance = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'admin' => $instance,
                'gender' => Gender::asSelectArray(),
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách giáo viên'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(TeacherUpdateRequest $request): RedirectResponse
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
