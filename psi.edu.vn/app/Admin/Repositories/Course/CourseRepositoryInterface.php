<?php

namespace App\Admin\Repositories\Course;

use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Models\Course;
use Illuminate\Http\Request;

interface CourseRepositoryInterface extends EloquentRepositoryInterface
{
    public function findOrFailWithRelations($id, array $relations = ['categories']);
    public function attachCategories(Course $post, array $categoriesId);
    public function syncCategories(Course $post, array $categoriesId);
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function getConflictCourse($schedule, $startDate, $endDate, $startTime, $endTime, $teacherId, $studentId = null, $excludeCourseId = null);
    public function getCourseIdByStudentLessonId($studentLessonId);
    public function getAllCourseIdsByStudentLessons();
    public function getEducationLevels();
    public function getCoursesForSelection(?string $keyword = null, $perPage, ?int $categoryId = null);
}
