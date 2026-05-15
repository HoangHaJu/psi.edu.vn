<?php

namespace App\Admin\DataTables\Booking;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Booking\BookingStatus;
use Illuminate\Database\Eloquent\Builder;

class BookingDataTable extends BaseDataTable
{
    use AuthService;
    protected $nameTable = 'bookingTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        BookingRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 1, 2, 3];


        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => BookingStatus::asSelectArray()
            ],
        ];
    }

    public function setView(): void
    {
        $this->view = [
            'admin' => 'admin.bookings.datatable.admin',
            'course' => 'admin.bookings.datatable.course',
            'status' => 'admin.bookings.datatable.status',
            'action' => 'admin.bookings.datatable.action',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'status' => $this->view['status'],
            'course_id' => $this->view['course'],
            'admin_id' => $this->view['admin'],
            'action' => $this->view['action'],
            'total' => '{{ format_price($total) }}',
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        $admin = $this->getCurrentAdmin();
        $query = $this->repository->getByQueryBuilder([], ['course', 'admin']);
        if ($admin->isStudent) {
            $query = $query->where('admin_id', $admin->id);
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
        $this->customColumns = config('datatables_columns.booking', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['admin_id', 'course_id', 'status', 'action', 'total'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'course_id' => function ($query, $keyword) {
                $query->whereHas('course', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
            'admin_id' => function ($query, $keyword) {
                $query->whereHas('admin', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
