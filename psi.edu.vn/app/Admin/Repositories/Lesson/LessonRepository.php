<?php

namespace App\Admin\Repositories\Lesson;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Models\Lesson;
use App\Enums\Lesson\{DayOffType, LessonStatus};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LessonRepository extends EloquentRepository implements LessonRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return Lesson::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function getByRole($personId, $role = 'student')
    {
        $this->getQueryBuilder();
        if ($role == 'student') {
            $this->instance = $this->instance->join('student_lessons', 'student_lessons.teacher_lesson_id', '=', 'lessons.id')
                ->where('student_lessons.admin_id', $personId)
                ->get();
        } else {
            $this->instance = $this->instance->join('teacher_lessons', 'teacher_lessons.lesson_id', '=', 'lessons.id')
                ->where('teacher_lessons.admin_id', $personId)
                ->get();
        }
        return $this->instance;
    }


    public function getConflictingLessons($startDate, $endDate, $startTime, $endTime, $teacherId, $studentId = null, $excludeCourseId = null)
    {
        $this->getQueryBuilder();

        return $this->instance->where(function ($query) use ($startDate, $endDate, $startTime, $endTime, $teacherId, $studentId, $excludeCourseId) {
            // Kiểm tra xung đột ngày
            $query->whereBetween('date', [$startDate, $endDate])
                ->whereHas('course', function ($courseQuery) use ($teacherId, $studentId, $startTime, $endTime, $excludeCourseId) {
                    $courseQuery->where(function ($subQuery) use ($teacherId, $studentId) {
                        // Luôn kiểm tra teacher_id
                        $subQuery->where('teacher_id', $teacherId);

                        // Chỉ kiểm tra student_id nếu không null
                        if (!is_null($studentId)) {
                            $subQuery->orWhere('student_id', $studentId);
                        }
                    })
                        // Kiểm tra xung đột thời gian
                        ->where(function ($timeQuery) use ($startTime, $endTime) {
                            $timeQuery->whereTime('start_time', '<', $endTime) // Bắt đầu trước khi buổi học mới kết thúc
                                ->whereTime('end_time', '>', $startTime); // Kết thúc sau khi buổi học mới bắt đầu
                        });

                    // Loại trừ khóa học nếu có
                    if ($excludeCourseId) {
                        $courseQuery->where('id', '!=', $excludeCourseId);
                    }
                });
        })->get();
    }
    public function getLessonsForTeacher($teacherId)
    {
        $lessons = Lesson::select('lessons.id', 'lessons.start_time', 'lessons.date', 'teacher_lessons.lesson_id')
            ->join('teacher_lessons', 'lessons.id', '=', 'teacher_lessons.lesson_id')
            ->where('teacher_lessons.admin_id', $teacherId) // Lọc theo admin_id động
            ->whereDate('lessons.date', '>=', Carbon::today()) // Lọc các buổi học từ hôm nay
            ->orderBy('lessons.date', 'asc') // Sắp xếp theo ngày
            ->orderBy('lessons.start_time', 'asc') // Sắp xếp theo giờ bắt đầu
            ->get();

        $groupedLessons = $lessons->groupBy(function ($lesson) {
            return Carbon::parse($lesson->date)->format('d-m-Y'); // Định dạng lại ngày để nhóm
        });

        return $groupedLessons;
    }


    public function getLessonsForTeacherToRegister($courseId)
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->where('course_id', $courseId)->whereDate('date', '>', Carbon::now())->whereDate('date', '<=', Carbon::now()->addDays(7))->orderBy('date', 'asc')->orderBy('start_time', 'asc');

        return $this->instance->get();
    }

    public function getLessonsInProgress($studentId)
    {
        $this->getQueryBuilder();
        // Join with student_lessons and use paginate instead of get
        $this->instance = $this->instance->join('student_lessons', 'student_lessons.teacher_lesson_id', '=', 'lessons.id')
            ->where('student_lessons.admin_id', $studentId)
            ->where('student_lessons.status', LessonStatus::Present->value) // Filter by status = 2
            ->paginate(10); // Adjust the number of items per page as needed

        return $this->instance;
    }
    public function calculateProcess($course_id)
    {
        $this->getQueryBuilder();
        return $this->instance
            ->where('course_id', '=', $course_id)
            ->where('is_registered', '=', 1)
            ->where('status', '=', LessonStatus::Present->value)
            ->count();
    }
    public function getLessonsByCourseId($course_id)
    {
        $this->getQueryBuilder();
        return $this->instance
            ->where('course_id', '=', $course_id)
            ->get();
    }

    public function getFutureLessonsForStudent($studentId)
    {
        $this->getQueryBuilder();
        // Join with student_lessons and use paginate instead of get
        $this->instance = $this->instance->join('student_lessons', 'student_lessons.teacher_lesson_id', '=', 'lessons.id')
            ->where('student_lessons.admin_id', $studentId)
            ->paginate(10); // Adjust the number of items per page as needed

        return $this->instance;
    }

    public function getLessonStartTimeForTeacher($teacherId, $date = null)
    {
        $this->getQueryBuilder();

        $query = $this->instance
            ->select('lessons.*', 'lessons.start_time')
            ->join('teacher_lessons', 'teacher_lessons.lesson_id', '=', 'lessons.id')
            ->where('teacher_lessons.admin_id', $teacherId);

        if ($date) {
            $query->where('lessons.date', $date);
        } else {
            $query->where('lessons.date', '>=', Carbon::today());
        }

        $this->instance = $query
            ->orderBy('lessons.date', 'asc')
            ->orderBy('lessons.start_time', 'asc')
            ->paginate(10);

        return $this->instance;
    }

    // Trong LessonRepository hoặc service tương tự
    public function getLessonForTeacher($teacherId, $date, $courseId = null)
    {
        return $this->getQueryBuilder()
            ->select('lessons.*', 'teacher_lessons.id as teacher_lesson_id')
            ->join('teacher_lessons', 'teacher_lessons.lesson_id', '=', 'lessons.id')
            ->where('teacher_lessons.admin_id', $teacherId)
            ->whereDate('lessons.date', $date)
            ->when(!is_null($courseId), fn($q) => $q->where('lessons.course_id', $courseId))
            ->paginate(10); // Lấy 10 bản ghi mỗi trang
    }
}
