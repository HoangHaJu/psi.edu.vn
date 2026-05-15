<?php

namespace App\Admin\Repositories\Booking;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface BookingRepositoryInterface extends EloquentRepositoryInterface
{
    public function findBy(array $conditions);

    public function getConflictBooking($schedule, $startDate, $endDate, $startTime, $endTime, $studentId);
}
