<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CoursesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Course([
            'id'              => $row['id'] ?? null,
            'name'            => $row['name'] ?? null,
            'slug'            => $row['slug'] ?? null,
            'education_level' => $row['education_level'] ?? null,
            'is_active'       => $row['is_active'] ?? 1,
            'avatar'          => $row['avatar'] ?? null,
            'description'     => $row['description'] ?? null,
            'created_at'      => $row['created_at'] ?? now(),
            'updated_at'      => $row['updated_at'] ?? now(),
        ]);
    }
}
