<?php

namespace App\Admin\DataTables\Lesson;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class LessonDataTable extends BaseDataTable
{

    protected $lessons;

    protected $nameTable = 'lessonTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        LessonRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 1];

        $this->columnSearchDate = [0];

        $this->columnSearchSelect = [];
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.lessons.datatable.action',
            'start_time' => 'admin.lessons.datatable.start_time',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'start_time' => $this->view['start_time'],
            'date' => '{{ format_date($date, "d-m-Y") }}',
        ];
    }


    public function setLessons($lessons): self
    {
        $this->lessons = $lessons;
        return $this;
    }
    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        $query = $this->repository->getQueryBuilderOrderBy('start_time', 'ASC')->orderBy('date', 'ASC')->where('course_id', $this->course->id);
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
        $this->customColumns = config('datatables_columns.lesson', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'start_time'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [];
    }
}
