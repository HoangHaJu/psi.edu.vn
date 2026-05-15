<?php

namespace App\Admin\Repositories\TeacherLesson;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\TeacherLesson\TeacherLessonRepositoryInterface;
use App\Models\TeacherLesson;

class TeacherLessonRepository extends EloquentRepository implements TeacherLessonRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return TeacherLesson::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
