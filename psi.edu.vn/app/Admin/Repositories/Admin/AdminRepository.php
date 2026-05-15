<?php

namespace App\Admin\Repositories\Admin;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Traits\BaseAuthCMS;
use App\Models\Admin;
use Carbon\Carbon;

class AdminRepository extends EloquentRepository implements AdminRepositoryInterface
{
    use BaseAuthCMS;

    protected $select = [];

    public function getModel(): string
    {
        return Admin::class;
    }

    public function getAllByRole($role = 'superAdmin')
    {
        $this->getQueryBuilder();

        $this->instance->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
        // Paginate results with a limit of $limit
        return $this->instance->get();
    }

    public function getTeachersForSelection(array $filters = [], int $perPage = 10)
    {
        $query = $this->model->newQuery();

        $query->with([
            'roles',
            'teacher_lessons.lesson.course.categories',
        ]);

        // Chỉ lấy user có role teacher
        $query->whereHas('roles', fn($q) => $q->where('name', 'teacher'));

        // --- FILTER FULLNAME ---
        if (!empty($filters['fullname'])) {
            $query->where('fullname', 'like', '%' . $filters['fullname'] . '%');
        }

        // --- FILTER GENDER ---
        if (!empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        // --- FILTER CATEGORY ---
        if (!empty($filters['category_id'])) {
            $query->whereHas('teacher_lessons.lesson.course.categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category_id']);
            });
        }

        // --- FILTER COURSE ---
        if (!empty($filters['course_id'])) {
            $query->whereHas('teacher_lessons.lesson', function ($q) use ($filters) {
                $q->where('course_id', $filters['course_id']);
            });
        }

        // --- FILTER DATE ---
        if (!empty($filters['date'])) {
            try {
                $date = Carbon::parse($filters['date'])->format('Y-m-d');
                $query->whereHas('teacher_lessons.lesson', fn($q) => $q->whereDate('date', $date));
            } catch (\Exception $e) {
                // ignore parse error
            }
        } else {
            $query->whereHas('teacher_lessons.lesson', function ($q) {
                $q->whereDate('date', '>=', Carbon::now()->toDateString());
            });
        }

        // --- FILTER RATING ---
        if (!empty($filters['rating'])) {
            $minRating = (float) $filters['rating'];
            $query->where(function ($sub) use ($minRating) {
                $sub->whereRaw('(SELECT AVG(sl.rate)
                FROM teacher_lessons tl
                JOIN student_lessons sl ON sl.teacher_lesson_id = tl.id
                WHERE tl.admin_id = users.id
            ) >= ?', [$minRating]);
            });
        }

        // Chỉ lấy các trường cần thiết
        $query->select('id', 'fullname', 'avatar', 'gender');

        // --- Paginate ---
        $paginated = $query->paginate($perPage);

        // --- Trả về dạng chuẩn items + meta + links ---
        return [
            'items' => $paginated->items(),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
            'links' => [
                'prev' => $paginated->previousPageUrl(),
                'next' => $paginated->nextPageUrl(),
            ],
        ];
    }


    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC', $role = null)
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->with('roles')->orderBy($column, $sort);
        if ($role) {
            $this->instance = $this->instance->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });
        }
        return $this->instance;
    }

    public function searchAllLimit($keySearch = '', $meta = [], $select = ['id', 'fullname', 'email'])
    {
        $this->instance = $this->model->select($select)
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'superAdmin');
            });
        $this->getQueryBuilderFindByKey($keySearch);

        if (isset($meta['role'])) {
            $this->instance = $this->instance->whereHas('roles', function ($query) use ($meta) {
                $query->where('name', $meta['role']);
            });
        }

        return $this->instance->get();
    }

    protected function getQueryBuilderFindByKey($key): void
    {
        $this->instance = $this->instance->where(function ($query) use ($key) {
            return $query->where('username', 'LIKE', '%' . $key . '%')
                ->orWhere('email', 'LIKE', '%' . $key . '%')
                ->orWhere('fullname', 'LIKE', '%' . $key . '%');
        });
    }
    public function getUserInfoById($id)
    {
        $this->getQueryBuilder();
        return $this->model->where('id', '=', $id)->first();
    }

    public function getTeacherTaughtLessons($teacher_id)
    {
        $this->getQueryBuilder();
        return $this->model->where('id', '=', $teacher_id)->with('lessons')->first();
    }

    public function resetRemainingLeaveCount($student_id)
    {
        $this->getQueryBuilder();
        return $this->model->where('id', '=', $student_id)->update(['remaining_leave_requests' => 10]);
    }
    public function getTeachersListForFilter()
    {
        $this->getQueryBuilder();
        return $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get(['id', 'fullname']);
    }

    public function getStudentsForSelection($keyword = null, $perPage = 20)
    {
        $query = $this->model->newQuery();

        // Lọc theo vai trò 'student'
        $query->whereHas('roles', function ($q) {
            $q->where('name', 'student');
        });

        // Lọc theo từ khóa tìm kiếm (fullname, email, phone)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'like', "%{$keyword}%");
            });
        }

        // Chỉ lấy các trường cần thiết
        $query->select('id', 'fullname', 'avatar');

        return $query->paginate($perPage);
    }
}
