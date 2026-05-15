<?php

namespace App\Admin\DataTables\Transaction;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Transaction\TransactionStatus;
use Illuminate\Database\Eloquent\Builder;

class TransactionDataTable extends BaseDataTable
{
    use AuthService;
    protected $nameTable = 'transactionTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        TransactionRepositoryInterface $repository
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
                'data' => TransactionStatus::asSelectArray()
            ],
        ];
    }

    public function setView(): void
    {
        $this->view = [
            'admin' => 'admin.transactions.datatable.admin',
            'ticket' => 'admin.transactions.datatable.ticket',
            'total' => 'admin.transactions.datatable.total',
            'status' => 'admin.transactions.datatable.status',
            'action' => 'admin.transactions.datatable.action',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'status' => $this->view['status'],
            'total' => $this->view['total'],
            'ticket_id' => $this->view['ticket'],
            'user_id' => $this->view['admin'],
            'action' => $this->view['action'],
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
        $query = $this->repository->getByQueryBuilder([], ['ticket', 'user']);
        if ($admin->isStudent) {
            $query = $query->where('user_id', $admin->id);
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
        $this->customColumns = config('datatables_columns.transaction', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['user_id', 'ticket_id', 'total', 'status', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'ticket_id' => function ($query, $keyword) {
                $query->whereHas('ticket', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
            'user_id' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
