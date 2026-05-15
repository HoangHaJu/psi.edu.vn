<?php

namespace App\Imports;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReviewsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Review([
            'id'         => $row['id'] ?? null,
            'rating'     => $row['rating'] ?? null,
            'content'    => $row['content'] ?? null,
            'created_at' => $row['created_at'] ?? now(),
            'updated_at' => $row['updated_at'] ?? now(),
            'admin_id'   => $row['admin_id'] ?? null,
            'course_id'  => $row['course_id'] ?? null,
        ]);
    }
}
