<?php

namespace App\Admin\DataTables\Ticket;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TicketDataTable extends BaseDataTable
{

    protected $nameTable = 'ticketTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        TicketRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4];

        $this->columnSearchDate = [4];
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.tickets.datatable.action',
            'name' => 'admin.tickets.datatable.name',
            'description' => 'admin.tickets.datatable.description',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'description' => $this->view['description'],
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([], []);
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
        $this->customColumns = config('datatables_columns.ticket', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['name', 'quantity', 'price', 'during', 'description', 'action'];
    }

    // public function setCustomFilterColumns(): void
    // {
    //     $this->customFilterColumns = [
    //         'admin' => function ($query, $keyword) {
    //             $query->whereHas('admin', function ($subQuery) use ($keyword) {
    //                 $subQuery->where('fullname', 'like', '%' . $keyword . '%');
    //             });
    //         },
    //     ];
    // }
}
