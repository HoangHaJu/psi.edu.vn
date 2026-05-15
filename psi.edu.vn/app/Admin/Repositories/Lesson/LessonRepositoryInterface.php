<?php

namespace App\Admin\Repositories\Lesson;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface LessonRepositoryInterface extends EloquentRepositoryInterface
{
    public function getConflictingLessons($startDate, $endDate, $startTime, $endTime, $teacherId, $studentId = null, $excludeCourseId = null);
    public function getByRole($personId, $role = 'student');
    public function getLessonsInProgress($studentId);
    public function calculateProcess($course_id);
    public function getLessonsByCourseId($course_id);

    public function getFutureLessonsForStudent($studentId);
    public function getLessonsForTeacherToRegister($courseId);
    public function getLessonsForTeacher($teacherId);
    public function getLessonStartTimeForTeacher($teacherId, $date = null);
    public function getLessonForTeacher($teacherId, $date, $courseId = null);
}
