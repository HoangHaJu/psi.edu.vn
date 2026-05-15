<?php

namespace App\Admin\Services\StudentLesson;

use Illuminate\Http\Request;

interface StudentLessonServiceInterface
{
    public function refundTicket($id);
    // public function saveRatingsForTeacher($teacherId);
    public function getAverageRatingsForStudent($teacherId);
}
