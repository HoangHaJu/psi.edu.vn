<?php

namespace App\Admin\Services\Booking;

use Illuminate\Http\Request;

interface BookingServiceInterface
{
    // public function store(Request $request);
    public function update(Request $request);
    public function delete($id);
    public function confirm($id);
    public function cancel($id);

    public function checkLessonConflicts($request, $studentLesson, $teacherLesson, $startTime);
    public function createLessonWithTransaction($request, $studentLesson, $startTime);

    public function adminRegister(Request $request);
    public function studentRegister(Request $request);
}
