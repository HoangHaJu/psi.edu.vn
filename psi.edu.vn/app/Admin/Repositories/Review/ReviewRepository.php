<?php

namespace App\Admin\Repositories\Review;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Review\ReviewRepositoryInterface;
use App\Models\Review;

class ReviewRepository extends EloquentRepository implements ReviewRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Review::class;
    }

    public function getReviewByCourseId($course_id)
    {
        $this->instance = $this->model->join('courses', 'courses.id', 'course_id')
                                    ->join('admins', 'admins.id', 'admin_id')
                                    ->where('course_id', '=', $course_id)
                                    ->orderBy('reviews.created_at', 'desc')
                                    ->get();
        return $this->instance;
    }

    public function getAllDetails()
    {
        return $this->model->join('courses', 'courses.id', 'course_id')
                ->join('admins', 'admins.id', 'admin_id')
                ->orderBy('reviews.created_at', 'desc')
                ->get();
    }
}
