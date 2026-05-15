<?php

namespace App\Admin\Services\Notification;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Notification\NotificationOption;
use App\Enums\Notification\NotificationType;
use App\Traits\NotifiesViaFirebase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationService implements NotificationServiceInterface
{
    use AuthService, NotifiesViaFirebase;

    protected $data;

    protected $repository;
    private AdminRepositoryInterface $adminRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        AdminRepositoryInterface        $adminRepository,
    ) {
        $this->repository = $repository;
        $this->adminRepository = $adminRepository;
    }

    public function store(Request $request)
    {
        $this->data = $request->validated();
        try {
            DB::beginTransaction();
            if ($this->data['type'] == NotificationType::All->value) {
                if ($this->data['option'] == NotificationOption::Teacher->value) {
                    $admins = $this->adminRepository->searchAllLimit('', ['role' => 'teacher']);
                } else {
                    $admins = $this->adminRepository->searchAllLimit('', ['role' => 'student']);
                }
                foreach ($admins as $admin) {
                    $this->data['admin_id'] = $admin->id;
                    $this->repository->create($this->data);
                }
            } else {
                $adminIds = $this->data['admin_id'];
                foreach ($adminIds as $adminId) {
                    $this->data['admin_id'] = $adminId;
                    $this->repository->create($this->data);
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }
}
