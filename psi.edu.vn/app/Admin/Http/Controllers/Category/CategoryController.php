<?php

namespace App\Admin\Http\Controllers\Category;

use App\Admin\DataTables\Category\CategoryDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Category\CategoryRequest;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Services\Category\CategoryServiceInterface;
use App\Traits\ResponseController;
use App\Traits\UseLog;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    use ResponseController, UseLog;

    public function __construct(
        CategoryRepositoryInterface $repository,
        CategoryServiceInterface $service,
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'edit' => 'admin.categories.edit',
            'product' => 'admin.categories.product',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.category.index',
            'create' => 'admin.category.create',
            'edit' => 'admin.category.edit',
            'delete' => 'admin.category.delete',
        ];
    }

    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách danh mục'))
        ]);
    }

    public function create(): Factory|View|Application
    {
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(
                __('Danh sách danh mục'),
                route($this->route['index'])
            )->add(__('add')),
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);
        if ($response) {
            return to_route($this->route['edit'], $response->id);
        }
        return back()->with('error', __('notifyFail'));
    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $instance = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'category' => $instance,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách danh mục'),
                    route($this->route['index'])
                )->add(__('edit'))
            ]
        );
    }

    public function update(CategoryRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);
        if ($response) {
            return to_route($this->route['index'])->with('success', __('notifySuccess'));
        }
        return to_route($this->route['index'])->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {

        $response = $this->service->delete($id);
        if ($response) {
            return to_route($this->route['index'])->with('success', __('notifySuccess'));
        }
        return to_route($this->route['index'])->with('error', __('notifyFail'));
    }
}
