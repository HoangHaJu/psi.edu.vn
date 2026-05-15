<?php

namespace App\Imports;

use App\Models\StudentLesson;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentLessonsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new StudentLesson([
            'id'                    => $row['id'] ?? null,
            'admin_id'              => $row['admin_id'] ?? null,
            'teacher_lesson_id'     => $row['teacher_lesson_id'] ?? null,
            'status'                => $row['status'] ?? null,
            'day_off_type'          => $row['day_off_type'] ?? null,
            'note'                  => $row['note'] ?? null,
            'file_link'             => $row['file_link'] ?? null,
            'created_at'            => $row['created_at'] ?? now(),
            'updated_at'            => $row['updated_at'] ?? now(),
            'date'                  => $row['date'] ?? null,
            'start_time'            => $row['start_time'] ?? null,
            'course_name'           => $row['course_name'] ?? null,
            'teacher_review'        => $row['teacher_review'] ?? null,
            'student_review'        => $row['student_review'] ?? null,
            'interaction'           => $row['interaction'] ?? null,
            'listening'             => $row['listening'] ?? null,
            'communication'         => $row['communication'] ?? null,
            'pronunciation'         => $row['pronunciation'] ?? null,
            'vocab_grammar'         => $row['vocab_grammar'] ?? null,
            'ticket_date'           => $row['ticket_date'] ?? null,
            'rate'                  => $row['rate'] ?? null,
        ]);
    }
}
