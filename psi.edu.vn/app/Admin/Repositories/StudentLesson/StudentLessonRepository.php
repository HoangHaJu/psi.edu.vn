<?php

namespace App\Admin\Repositories\StudentLesson;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface;
use App\Enums\Lesson\LessonStatus;
use App\Models\StudentLesson;
use Carbon\Carbon;

class StudentLessonRepository extends EloquentRepository implements StudentLessonRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return StudentLesson::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function getStudentLessonsByStudentId($studentId)
    {
        $this->getQueryBuilder();

        $this->instance = $this->instance->where('admin_id', $studentId)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return $this->instance;
    }
    public function getUpcomingStudentLessonsByStudentId($studentId, $paginate = false)
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->where('admin_id', $studentId)
            ->whereDate('date', '>', Carbon::now()->startOfDay())
            ->where('day_off_type', 3)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc');
        if ($paginate) {
            $this->instance = $this->instance->paginate(4);
        } else {
            $this->instance = $this->instance->limit(4)->get();
        }

        return $this->instance;
    }

    public function getUpcomingStudentLessonsByTeacherId($teacherId, $paginate = false)
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->whereHas('teacherLesson', function ($query) use ($teacherId) {
            $query->where('admin_id', $teacherId);
        })
            ->whereDate('date', '>', Carbon::now()->startOfDay())
            ->where('day_off_type', 3)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc');
        if ($paginate) {
            $this->instance = $this->instance->paginate(4);
        } else {
            $this->instance = $this->instance->limit(4)->get();
        }

        return $this->instance;
    }

    public function getCompletedStudentLessonsByStudentId($studentId, $paginate = null)
    {
        $this->getQueryBuilder();

        $this->instance = $this->instance->where('admin_id', $studentId)
            ->where('status', LessonStatus::Present)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc');
        if ($paginate) {
            $this->instance = $this->instance->paginate(4);
        } else {
            $this->instance = $this->instance->limit(4)->get();
        }

        return $this->instance;
    }
    public function findConflict(int $studentId, string $date, string $startTime): bool
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance
            ->where('admin_id', $studentId)
            ->where('date', $date)
            ->where('start_time', $startTime);

        return $this->instance->exists();
    }
    public function getLessonsByRole($personId, $role = 'student')
    {
        $this->getQueryBuilder(); // Ensure the query builder is initialized

        if ($role == 'student') {
            $this->instance = $this->instance->where('admin_id', $personId)
                ->with('teacher_lesson.lesson.course') // Ensure the related lesson and course are loaded
                ->paginate(10); // Adjust the number of items per page as needed
        } else {
            $this->instance = $this->instance->whereHas('teacherLesson', function ($query) use ($personId) {
                $query->where('admin_id', $personId);
            })
                ->with('teacher_lesson.lesson.course') // Ensure the related lesson and course are loaded
                ->paginate(10); // Adjust the number of items per page as needed
        }

        return $this->instance;
    }
}
