<?php

namespace App\Admin\DataTables\TeacherLesson;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\TeacherLesson\TeacherLessonRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TeacherLessonDataTable extends BaseDataTable
{
    protected $nameTable = 'teacherLessonTable';

    protected array $actions = ['reset', 'reload'];

    public function __construct(
        TeacherLessonRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 1, 2];
        $this->columnSearchDate = [1];
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.teacher_lessons.datatable.action',
            'lesson_date' => 'admin.teacher_lessons.datatable.lesson_date',
            'teacher' => 'admin.teacher_lessons.datatable.teacher',
            'course' => 'admin.teacher_lessons.datatable.course',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'teacher' => $this->view['teacher'],
            'action' => $this->view['action'],
            'course' => $this->view['course'],
            'lesson_date' => $this->view['lesson_date'],
        ];
    }

    public function query(): Builder
    {
        $query = $this->repository->getByQueryBuilder([], ['lesson.course', 'teacher']);
        if (auth()->user()->isTeacher) {
            $query = $query->whereHas('teacher', function ($subQuery) {
                $subQuery->where('admin_id', auth()->user()->id);
            });
        }
        return $query;
    }

    protected function setCustomColumns(): void
    {
        $config  = config('datatables_columns.teacher_lesson', []);
        $this->customColumns = $config;
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['teacher', 'lesson_date', 'course', 'action'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'teacher' => function ($query, $keyword) {
                $query->whereHas('teacher', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'course' => function ($query, $keyword) {
                $query->whereHas('lesson.course', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
            'lesson_date' => function ($query, $keyword) {
                $query->whereHas('lesson', function ($subQuery) use ($keyword) {
                    $subQuery->where(function ($query) use ($keyword) {
                        $query
                            ->where('date', 'like', '%' . $keyword . '%')
                            ->orWhere('start_time', 'like', '%' . $keyword . '%');
                    });
                });
            },
        ];
    }
}
