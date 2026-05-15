<?php

namespace App\Admin\DataTables\Admin;

use App\Enums\Admin\EducationLevel;
use App\Enums\User\Gender;

class TeacherDatatable extends AdminDataTable
{

    protected $nameTable = 'teacherTable';

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.teachers.datatable.action',
            'edit-link' => 'admin.teachers.datatable.editlink',
            'gender' => 'admin.teachers.datatable.gender',
            'level' => 'admin.teachers.datatable.level',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4];

        $this->columnSearchDate = [3];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy('id', 'desc', 'teacher');
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.teacher', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'gender' => $this->view['gender'],
            'education_level' => $this->view['level'],
            'fullname' => $this->view['edit-link'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'fullname'];
    }
}
