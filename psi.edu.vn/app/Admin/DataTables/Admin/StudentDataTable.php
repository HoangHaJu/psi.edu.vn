<?php

namespace App\Admin\DataTables\Admin;

class StudentDataTable extends AdminDataTable
{

    protected $nameTable = 'studentTable';

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.students.datatable.action',
            'edit-link' => 'admin.students.datatable.editlink',
            'gender' => 'admin.students.datatable.gender',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4];

        $this->columnSearchDate = [3];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy('id', 'desc', 'student');
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.student', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'fullname' => $this->view['edit-link'],
            'gender' => $this->view['gender'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'fullname'];
    }
}
