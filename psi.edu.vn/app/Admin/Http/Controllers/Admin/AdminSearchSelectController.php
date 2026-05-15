<?php

namespace App\Admin\Http\Controllers\Admin;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Http\Resources\Admin\AdminSearchSelectResource;
use App\Models\Admin; // Ensure Admin model is imported

class AdminSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        AdminRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $students = Admin::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->get();

        $this->instance = [
            'results' => AdminSearchSelectResource::collection($students)
        ];
    }
}
