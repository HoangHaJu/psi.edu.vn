<?php

namespace App\Admin\DataTables\Review;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ReviewDataTable extends BaseDataTable
{
    protected $nameTable = 'reviewTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        ReviewRepositoryInterface $repository
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
            'admin'  => 'admin.reviews.datatable.admin',   // giữ nguyên tên view
            'rating' => 'admin.reviews.datatable.rating',
            'course' => 'admin.reviews.datatable.course',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'admin'      => $this->view['admin'], // hiển thị student (đã lọc ở query)
            'course'     => $this->view['course'],
            'rating'     => $this->view['rating'],
            'created_at' => '{{ format_datetime($created_at) }}',
        ];
    }

    /**
     * Query: chỉ lấy review của student
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([], ['admin', 'course'])
            ->whereHas('admin.roles', function ($q) {
                $q->where('name', 'student');
            });
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.review', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [];
    }

    protected function filename(): string
    {
        return 'review_' . date('YmdHis');
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['id', 'course', 'admin', 'rating'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'admin' => function ($query, $keyword) {
                $query->whereHas('admin', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%')
                        ->whereHas('roles', function ($q) {
                            $q->where('name', 'student');
                        });
                });
            },
            'course' => function ($query, $keyword) {
                $query->whereHas('course', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
