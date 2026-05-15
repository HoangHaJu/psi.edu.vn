<?php

namespace App\Admin\Http\Controllers\ScheduleOff;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\ScheduleOff\ScheduleOffRequest;
use App\Admin\Repositories\ScheduleOff\ScheduleOffRepositoryInterface;
use App\Admin\Services\ScheduleOff\ScheduleOffServiceInterface;
use App\Admin\DataTables\ScheduleOff\ScheduleOffDataTable;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;

class ScheduleOffController extends Controller
{
    protected $categoryRepository;
    protected $adminRepository;
    public function __construct(
        ScheduleOffRepositoryInterface $repository,
        CategoryRepositoryInterface $categoryRepository,
        AdminRepositoryInterface $adminRepository,
        ScheduleOffServiceInterface $service
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->adminRepository = $adminRepository;


        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.schedule_off.index',
            'create' => 'admin.schedule_off.create',
            'edit' => 'admin.schedule_off.edit',
        ];
    }

    public function getRoute()
    {
        return [
            'index' => 'admin.schedule_off.index',
            'create' => 'admin.schedule_off.create',
            'edit' => 'admin.schedule_off.edit',
        ];
    }
    public function index(ScheduleOffDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách ngày nghỉ'))
        ]);
    }

    public function store(ScheduleOffRequest $request)
    {
        $response = $this->service->store($request);
        if ($response) {
            return to_route($this->route['index'])->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function edit($id)
    {
        $schedule_off = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'schedule_off' => $schedule_off,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách ngày nghỉ'),
                    route($this->route['index'])
                )->add(__('edit'))
            ]
        );
    }

    public function update(ScheduleOffRequest $request)
    {
        $this->service->update($request);
        return back()->with('success', __('notifySuccess'));
    }

    public function delete($id, ScheduleOffRequest $request)
    {
        $result = $this->service->delete($id);

        if ($result) {
            return to_route($this->route['index'])->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }
}
