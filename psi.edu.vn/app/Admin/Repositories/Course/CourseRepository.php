<?php

namespace App\Admin\Repositories\Course;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Course\CourseRepositoryInterface;
use App\Enums\Booking\BookingStatus;
use App\Models\Booking;
use App\Models\Course;
use App\Models\StudentLesson;
use Illuminate\Http\Request;

class CourseRepository extends EloquentRepository implements CourseRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return Course::class;
    }
    public function findOrFailWithRelations($id, array $relations = ['categories'])
    {
        $this->findOrFail($id);
        $this->instance = $this->instance->load($relations);
        return $this->instance;
    }

    public function attachCategories(Course $course, array $categoriesId)
    {
        return $course->categories()->attach($categoriesId);
    }

    public function syncCategories(Course $course, array $categoriesId)
    {
        return $course->categories()->sync($categoriesId);
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function getConflictCourse($schedule, $startDate, $endDate, $startTime, $endTime, $teacherId, $studentId = null, $excludeCourseId = null)
    {
        $this->instance = $this->getAll();
        foreach ($this->instance as $course) {
            // Kiểm tra xung đột lịch
            $hasOverlappingSchedule = collect($schedule)
                ->intersect(json_decode($course->schedule))
                ->isNotEmpty();
            if ($hasOverlappingSchedule) {
                // Kiểm tra nếu ngày của khóa học có xung đột
                $courseStartDate = $course->start_date;
                $courseEndDate = $course->end_date;

                if ($this->isDateOverlap($courseStartDate, $courseEndDate, $startDate, $endDate)) {
                    // Kiểm tra nếu khóa học có xung đột về thời gian (nằm trong khoảng thời gian đã cho)
                    $courseStartTime = $course->start_time;
                    $courseEndTime = $course->end_time;

                    if ($this->isTimeOverlap($courseStartTime, $courseEndTime, $startTime, $endTime)) {
                        // Kiểm tra teacher_id
                        if ($course->teacher_id == $teacherId) {
                            if (!is_null($studentId) && $course->student_id == $studentId) {
                                return $course; // Xung đột cả teacher_id và student_id
                            }
                            if (is_null($studentId)) {
                                return $course; // Xung đột teacher_id
                            }
                        }

                        // Kiểm tra nếu khóa học bị loại trừ
                        if ($excludeCourseId && $course->id == $excludeCourseId) {
                            continue;
                        }

                        return $course; // Xung đột khác
                    }
                }
            }
        }
        return false;
    }

    private function isDateOverlap($startDate1, $endDate1, $startDate2, $endDate2)
    {
        return !(strtotime($endDate1) < strtotime($startDate2) || strtotime($startDate1) > strtotime($endDate2));
    }

    private function isTimeOverlap($courseStartTime, $courseEndTime, $startTime, $endTime)
    {
        // Kiểm tra xung đột thời gian (nếu thời gian của khóa học bắt đầu trước khi buổi học kết thúc và kết thúc sau khi buổi học bắt đầu)
        return ($courseStartTime < $endTime && $courseEndTime > $startTime);
    }

    public function getCourseIdByStudentLessonId($studentLessonId)
    {
        return StudentLesson::where('student_lessons.id', $studentLessonId)
            ->join('teacher_lessons', 'student_lessons.teacher_lesson_id', '=', 'teacher_lessons.id')
            ->join('lessons', 'teacher_lessons.lesson_id', '=', 'lessons.id')
            ->value('lessons.course_id');
    }

    public function getAllCourseIdsByStudentLessons()
    {
        return StudentLesson::join('teacher_lessons', 'student_lessons.teacher_lesson_id', '=', 'teacher_lessons.id')
            ->join('lessons', 'teacher_lessons.lesson_id', '=', 'lessons.id')
            ->select('student_lessons.id as student_lesson_id', 'lessons.course_id')
            ->get();
    }


    public function getEducationLevels()
    {
        return $this->model::distinct()
            ->pluck('education_level')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    public function getCoursesForSelection(?string $keyword = null, $perPage, ?int $categoryId = null)
    {
        $query = $this->model->newQuery();

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $query->select('id', 'name', 'avatar', 'description');
        $query->with(['categories:id,name']);

        return $query->paginate($perPage);
    }
}
