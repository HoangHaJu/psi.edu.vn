<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class NotificationDataTable extends BaseDataTable
{

    protected $nameTable = 'notificationTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        NotificationRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4, 5];

        $this->columnSearchDate = [5];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => NotificationStatus::asSelectArray()
            ],
        ];
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.notifications.datatable.action',
            'status' => 'admin.notifications.datatable.status',
            'admin' => 'admin.notifications.datatable.admin',
            'id' => 'admin.notifications.datatable.id',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'status' => $this->view['status'],
            'admin' => $this->view['admin'],
            'id' => $this->view['id'],
            'created_at' => '{{ format_date($created_at) }}',
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    // public function query(): Builder
    // {
    //     return $this->repository->getByQueryBuilder([], ['admin']);
    // }
    public function query(): Builder
    {
        $user = Auth::user();

        $query = $this->repository->getByQueryBuilder([], ['admin']);

        if ($user) {
            if ($user->isSuperAdmin) {
                // superAdmin sees all notifications
            } elseif ($user->isTeacher) {
                $query->where('admin_id', $user->id);
            } elseif ($user->isStudent) {
                $query->where('admin_id', $user->id);
            } else {
                $query->where('admin_id', $user->id);
            }
        } else {
            $query->where('is_public', true);
        }

        return $query;
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    /**
     * Get columns.
     *
     * @return void
     */
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.notification', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['id', 'status', 'admin', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'admin' => function ($query, $keyword) {
                $query->whereHas('admin', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
