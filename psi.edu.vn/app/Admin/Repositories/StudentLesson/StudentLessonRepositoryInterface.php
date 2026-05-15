<?php

namespace App\Admin\Repositories\StudentLesson;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface StudentLessonRepositoryInterface extends EloquentRepositoryInterface
{
    public function getStudentLessonsByStudentId($studentId);
    public function getUpcomingStudentLessonsByStudentId($studentId, $paginate = false);
    public function getCompletedStudentLessonsByStudentId($studentId, $paginate = false);
    public function getLessonsByRole($personId, $role = 'student');
    public function getUpcomingStudentLessonsByTeacherId($teacherId, $paginate = false);
    public function findConflict(int $studentId, string $date, string $startTime): bool;
}
