<?php

namespace App\Admin\DataTables\StudentLesson;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use App\Enums\Lesson\DayOffType;
use App\Enums\Lesson\LessonStatus;
use Illuminate\Database\Eloquent\Builder;

class StudentLessonDataTable extends BaseDataTable
{
    protected $nameTable = 'studentLessonTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        StudentLessonRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    // app/Admin/DataTables/StudentLesson/StudentLessonDataTable.php

    public function getStudentLessonData()
    {
        return $this->query()->get();
    }
    protected function setColumnSearch()
    {
        if (auth('admin')->user()->isTeacher) {
            $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6];

            $this->columnSearchDate = [3];

            $this->columnSearchSelect = [
                [
                    'column' => 5,
                    'data' => LessonStatus::asSelectArray()
                ],
                [
                    'column' => 6,
                    'data' => DayOffType::asSelectArray()
                ],
            ];
        } else if (auth('admin')->user()->isStudent) {
            $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6];

            $this->columnSearchDate = [3];

            $this->columnSearchSelect = [
                [
                    'column' => 5,
                    'data' => LessonStatus::asSelectArray()
                ],
                [
                    'column' => 6,
                    'data' => DayOffType::asSelectArray()
                ],
            ];
        } else {
            $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7];

            $this->columnSearchDate = [4];

            $this->columnSearchSelect = [
                [
                    'column' => 6,
                    'data' => LessonStatus::asSelectArray()
                ],
                [
                    'column' => 7,
                    'data' => DayOffType::asSelectArray()
                ],
            ];
        }
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.student_lessons.datatable.action',
            'start_time' => 'admin.student_lessons.datatable.start_time',
            'id' => 'admin.student_lessons.datatable.id',
            'student' => 'admin.student_lessons.datatable.student',
            'teacher' => 'admin.student_lessons.datatable.teacher',
            'status' => 'admin.student_lessons.datatable.status',
            'day_off_type' => 'admin.student_lessons.datatable.day_off_type',
            'file' => 'admin.student_lessons.datatable.file',
            'skype' => 'admin.student_lessons.datatable.skype',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'skype' => $this->view['skype'],
            'start_time' => $this->view['start_time'],
            'id' => $this->view['id'],
            'student' => $this->view['student'],
            'teacher' => $this->view['teacher'],
            'status' => $this->view['status'],
            'day_off_type' => $this->view['day_off_type'],
            'file' => $this->view['file'],
            'date' => '{{ format_date($date, "d-m-Y") }}',
        ];
    }

    public function query(): Builder
    {
        $query = $this->repository->getByQueryBuilder([], ['teacher_lesson.lesson', 'teacher_lesson.teacher', 'student'], ['id', 'asc']);
        if (auth('admin')->user()->isTeacher) {
            $query = $query->whereHas('teacher_lesson', function ($subQuery) {
                $subQuery->where('admin_id', auth('admin')->id());
            });
        }
        if (auth('admin')->user()->isStudent) {
            $query = $query->where('admin_id', auth('admin')->id());
        }
        return $query;
    }
    // Setup column
    protected function setCustomColumns(): void
    {
        $config  = config('datatables_columns.student_lesson', []);
        if (auth('admin')->user()->isStudent) {
            unset($config['student']);
        } else if (auth('admin')->user()->isTeacher) {
            unset($config['teacher']);
        }
        $this->customColumns = $config;
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'start_time', 'id', 'student', 'teacher', 'status', 'day_off_type', 'file', 'skype'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'student' => function ($query, $keyword) {
                $query->whereHas('student', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'teacher' => function ($query, $keyword) {
                $query->whereHas('teacher_lesson.teacher', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
