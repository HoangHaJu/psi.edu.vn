<?php

namespace App\Admin\DataTables\ScheduleOff;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\ScheduleOff\ScheduleOffRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\GetConfig;

class ScheduleOffDataTable extends BaseDataTable
{

    use GetConfig, AuthService;
    protected $nameTable = 'scheduleOffTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        ScheduleOffRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.schedule_off.datatable.action',
            'student' => 'admin.schedule_off.datatable.student',
            'teacher' => 'admin.schedule_off.datatable.teacher',
            'student_lesson' => 'admin.schedule_off.datatable.student_lesson',
            'is_active' => 'admin.schedule_off.datatable.is_active',
            'created_at' => 'admin.schedule_off.datatable.day_off',
        ];
    }

    public function setColumnSearch(): void
    {
        if ($this->getCurrentStudent()) {
            $this->columnAllSearch = [0, 1, 2, 3, 4];
            $this->columnSearchSelect = [
                [
                    'column' => 4,
                    'data' => [0 => 'Chưa duyệt', 1 => 'Đã duyệt']
                ]
            ];
            $this->columnSearchDate = [3];
        } elseif ($this->getCurrentTeacher()) {
            $this->columnAllSearch = [0, 1, 2, 3, 4];
            $this->columnSearchSelect = [
                [
                    'column' => 4,
                    'data' => [0 => 'Chưa duyệt', 1 => 'Đã duyệt']
                ]
            ];
            $this->columnSearchDate = [3];
        } else {
            $this->columnAllSearch = [0, 1, 2, 3, 4, 5];
            $this->columnSearchSelect = [
                [
                    'column' => 5,
                    'data' => [0 => 'Chưa duyệt', 1 => 'Đã duyệt']
                ]
            ];
            $this->columnSearchDate = [4];
        }
    }

    public function query()
    {
        $query = $this->repository->getByQueryBuilder([], ['teacher', 'student', 'student_lesson']);
        if ($this->getCurrentStudent()) {
            $query->where('student_id', $this->getCurrentStudent()->id);
        }
        if ($this->getCurrentTeacher()) {
            $query->where('teacher_id', $this->getCurrentTeacher()->id);
        }
        return $query;
    }


    protected function setCustomColumns(): void
    {
        $config = config('datatables_columns.schedule_off', []);
        if (auth('admin')->user()->isStudent) {
            unset($config['teacher']);
        } else if (auth('admin')->user()->isTeacher) {
            unset($config['student']);
        }
        $this->customColumns = $config;
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'student' => $this->view['student'],
            'teacher' => $this->view['teacher'],
            'student_lesson' => $this->view['student_lesson'],
            'is_active' => $this->view['is_active'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'student', 'teacher', 'student_lesson', 'is_active'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'teacher' => function ($query, $keyword) {
                $query->whereHas('teacher', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'student' => function ($query, $keyword) {
                $query->whereHas('student', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'student_lesson' => function ($query, $keyword) {
                $query->whereHas('student_lesson', function ($subQuery) use ($keyword) {
                    $subQuery->where('course_name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
