<?php

namespace App\Imports;

use App\Models\TeacherLesson;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherLessonsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new TeacherLesson([
            'id'         => $row['id'] ?? null,
            'admin_id' => $row['admin_id'] ?? null,
            'lesson_id'  => $row['lesson_id'] ?? null,
        ]);
    }
}
