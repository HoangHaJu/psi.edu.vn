<?php

namespace App\Admin\Repositories\Admin;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface AdminRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * make query
     *
     * @return mixed
     */
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC', $role = null);
    public function getAllRoles();
    public function searchAllLimit($keySearch = '', $meta = [], $select = ['id', 'fullname', 'email']);
    public function getTeachersForSelection(array $filters = [], int $perPage = 10);
    public function getUserInfoById($id);
    public function getTeacherTaughtLessons($teacher_id);
    public function getAllByRole($role = 'superAdmin');
    public function resetRemainingLeaveCount($student_id);
    public function getTeachersListForFilter();
    public function getStudentsForSelection($keyword = null, $perPage);
}
