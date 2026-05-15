<?php

namespace App\Admin\Services\Admin;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Services\File\FileService;

class AdminService implements AdminServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;
    protected FileService $fileService;

    public function __construct(
        AdminRepositoryInterface $repository,
        FileService $fileService,
    ) {

        $this->fileService = $fileService;
        $this->repository = $repository;
    }

    public function store(Request $request, $role = null)
    {

        $this->data = $request->validated();
        unset($this->data['is_teacher']);
        $this->data['password'] = bcrypt($this->data['password']);

        if ($request->routeIs('admin.auth.register')) {
            if (isset($this->data['email'])) {
                $this->data['is_active'] = 0;
            }
        }

        $instance = $this->repository->create($this->data);
        if ($role) {
            $this->repository->assignRoles($instance, [$role]);
        }
        return $instance;
    }

    public function update(Request $request)
    {
        $this->data = $request->validated();
        if (isset($this->data['password']) && $this->data['password']) {
            $this->data['password'] = bcrypt($this->data['password']);
        } else {
            unset($this->data['password']);
        }
        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
