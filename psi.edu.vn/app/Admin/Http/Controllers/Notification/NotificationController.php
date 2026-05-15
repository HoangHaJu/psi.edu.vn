<?php

namespace App\Admin\Http\Controllers\Notification;

use App\Admin\DataTables\Notification\NotificationDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Notification\NotificationRequest;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Services\Notification\NotificationServiceInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Notification\NotificationOption;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    use AuthService;
    protected $driverRepository;
    protected $storeRepository;
    protected $userRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        NotificationServiceInterface    $service
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.notifications.index',
            'create' => 'admin.notifications.create',
            'edit' => 'admin.notifications.edit',
            'show' => 'admin.notifications.show'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.notification.index',
            'create' => 'admin.notification.create',
            'edit' => 'admin.notification.edit',
            'show' => 'admin.notification.show'
        ];
    }

    public function index(NotificationDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách thông báo'))
        ]);
    }

    public function create(): View|Application
    {
        return view($this->view['create'], [
            'types' => NotificationType::asSelectArray(),
            'status' => NotificationStatus::asSelectArray(),
            'options' => NotificationOption::asSelectArray(),
            'breadcrumbs' => $this->crums->add(
                __('Danh sách thông báo'),
                route($this->route['index'])
            )->add(__('add')),
        ]);
    }
    public function store(NotificationRequest $request)
    {
        $response = $this->service->store($request);
        if ($response) {
            return redirect()->route($this->route['index'])->with('success', __('notifySuccess'));
        }
        return redirect()->route($this->route['create'])->with('error', __('notifyFail'));
    }

    public function getAllNotificationAdmin()
    {
        $adminId = auth()->id(); // hoặc lấy từ session, guard khác tùy theo hệ thống xác thực bạn đang dùng
        $isNewNotification = true;

        $conditions = [
            'status'   => NotificationStatus::NOT_READ,
            'read_at'  => null,
            'admin_id' => $adminId, // điều kiện thêm vào
        ];

        $notifications = $this->repository->getBy($conditions);

        if (!isset($notifications[0])) {
            $isNewNotification = false;
            $notifications = $this->repository->getBy($conditions, [], 5);
        }

        return response()->json([
            'status' => 200,
            'data'   => $notifications,
            'count'  => $isNewNotification ? count($notifications) : 0,
        ]);
    }
    public function show($id)
    {
        $response = $this->repository->findOrFail($id);
        if ($response) {
            $response->markAsRead();
        }
        return view(
            $this->view['show'],
            [
                'notification' => $response,
                'status' => NotificationStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách thông báo'),
                    route($this->route['index'])
                )->add(__('show'))
            ],
        );
    }
    public function readAllNotification()
    {
        $notifications = $this->repository->getBy(['admin_id' => $this->getCurrentAdminId()]);
        foreach ($notifications as $notification) {
            $notification->update(['status' => NotificationStatus::READ]);
        }
        return redirect()->back()->with('success', 'Đọc thông báo thành công');
    }


    public function edit($id): View|Application
    {
        $response = $this->repository->findOrFail($id);
        if ($response) {
            $response->markAsRead();
        }
        return view(
            $this->view['edit'],
            [
                'notification' => $response,
                'status' => NotificationStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách thông báo'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(NotificationRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);
        if ($response) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
