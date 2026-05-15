<?php

namespace App\Admin\DataTables\TicketStudent;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use App\Models\TicketStudent;

class TicketStudentDataTable extends BaseDataTable
{

    protected $nameTable = 'ticketStudentTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        TicketStudentRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 1];

        $this->columnSearchDate = [1];
    }

    public function setView(): void
    {
        $this->view = [];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'expired_date' => '{{ format_date($expired_date, "d-m-Y") }}',
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        $query = $this->repository->getByQueryBuilder([], ['admin'], ['id', 'asc']);
        if (auth('admin')->user()->isStudent) {
            $query = $query->where('admin_id', auth('admin')->id());
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
        $this->customColumns = config('datatables_columns.ticket_student', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['id', 'expired_date'];
    }
}
