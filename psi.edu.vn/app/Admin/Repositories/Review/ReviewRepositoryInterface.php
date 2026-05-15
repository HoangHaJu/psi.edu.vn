<?php

namespace App\Admin\Repositories\Review;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface ReviewRepositoryInterface extends EloquentRepositoryInterface
{
    public function getReviewByCourseId($course_id);
    public function getAllDetails();
}
