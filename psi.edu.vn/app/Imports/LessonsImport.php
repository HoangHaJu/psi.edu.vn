<?php

namespace App\Imports;

use App\Models\Lesson;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LessonsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Lesson([
            'id'         => $row['id'] ?? null,
            'start_time' => $row['start_time'] ?? null,
            'created_at' => $row['created_at'] ?? now(),
            'updated_at' => $row['updated_at'] ?? now(),
            'course_id'  => $row['course_id'] ?? null,
            'date'       => $row['date'] ?? null,
        ]);
    }
}
