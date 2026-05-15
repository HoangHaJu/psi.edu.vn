<?php

namespace App\Admin\DataTables\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;

class CategoryDataTable extends BaseDataTable
{

    use GetConfig;

    protected $nameTable = 'categoryTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        CategoryRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView()
    {
        $this->view = [
            'action' => 'admin.categories.datatable.action',
            'editlink' => 'admin.categories.datatable.editlink',
            'avatar' => 'admin.categories.datatable.avatar',
            'is_active' => 'admin.categories.datatable.is_active',
            'icon' => 'admin.categories.datatable.icon',
            'courses' => 'admin.categories.datatable.courses',
        ];
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function query()
    {
        $query = $this->repository->getByQueryBuilder([], ['courses']);
        return $query;
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'id' => $this->view['editlink'],
            'name' => $this->view['editlink'],
            'avatar' => $this->view['avatar'],
            'is_active' => $this->view['is_active'],
            'icon' => $this->view['icon'],
            'courses' => $this->view['courses'],
        ];
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.category', []);
    }

    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }

    protected function setCustomRawColumns()
    {
        $this->customRawColumns = ['name', 'avatar', 'is_active', 'icon', 'action', 'courses'];
    }

    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 2, 4];

        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => [1 => 'Đang hoạt động', 0 => 'Ngưng hoạt động']
            ],
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'courses' => function ($query, $keyword) {
                $query->whereHas('courses', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
