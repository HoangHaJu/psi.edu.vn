<?php

namespace App\Admin\Repositories\Notification;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Notification;

class NotificationRepository extends EloquentRepository implements NotificationRepositoryInterface
{

    public function getModel(): string
    {
        return Notification::class;
    }

    public function getByAdminIdAndLatest($adminId)
    {
        return $this->model->where('admin_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();;
    }
    public function getByAdminIdAndPaginate($adminId)
    {
        return $this->model->where('admin_id', $adminId)->orderBy('created_at', 'desc')->paginate(12);
    }
}
