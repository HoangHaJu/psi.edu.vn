<?php

namespace App\Admin\Http\Controllers\Teacher;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Http\Resources\Admin\AdminSearchSelectResource;
use App\Models\Admin; // Ensure Admin model is imported

class TeacherSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        AdminRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $teachers = Admin::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();

        $this->instance = [
            'results' => AdminSearchSelectResource::collection($teachers)
        ];
    }
}
