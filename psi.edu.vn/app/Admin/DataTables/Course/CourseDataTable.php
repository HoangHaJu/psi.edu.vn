<?php

namespace App\Admin\DataTables\Course;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Course\CourseRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Admin\EducationLevel;

class CourseDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'CourseTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        CourseRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.courses.datatable.action',
            'image' => 'admin.courses.datatable.image',
            'status' => 'admin.courses.datatable.status',
            'editlink' => 'admin.courses.datatable.editlink',
            'register_leson' => 'admin.courses.datatable.register_lesson',
            'education_level' => 'admin.courses.datatable.education_level',
            'lesson' => 'admin.courses.datatable.lesson',
        ];
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [1, 3];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => EducationLevel::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        $query = $this->repository->getByQueryBuilder([], []);

        return $query;
    }


    protected function setCustomColumns(): void
    {
        $config = config('datatables_columns.course', []);
        if (auth('admin')->user()->isTeacher) {
            unset($config['lesson']);
            unset($config['register_lesson']);
        }
        $this->customColumns = $config;
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'avatar' => $this->view['image'],
            'name' => $this->view['editlink'],
            'education_level' => $this->view['education_level'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'lesson' => $this->view['lesson'],
            'register_lesson' => $this->view['register_leson'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['avatar', 'name', 'action', 'education_level', 'lesson', 'register_lesson'];
    }
}
