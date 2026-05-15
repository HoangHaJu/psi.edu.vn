<?php

namespace App\Admin\Repositories\ScheduleOff;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\ScheduleOff\ScheduleOffRepositoryInterface;
use App\Models\ScheduleOff;

class ScheduleOffRepository extends EloquentRepository implements ScheduleOffRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return ScheduleOff::class;
    }
}
