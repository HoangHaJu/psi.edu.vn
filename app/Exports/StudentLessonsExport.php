<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentLessonsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Lấy toàn bộ dữ liệu từ bảng 'student_lessons'
        return DB::table('student_lessons')->get();
    }

    public function headings(): array
    {
        // Trả về mảng tiêu đề cho các cột
        return [
            'id',
            'admin_id',
            'teacher_lesson_id',
            'status',
            'day_off_type',
            'note',
            'file_link',
            'created_at',
            'updated_at',
            'date',
            'start_time',
            'course_name',
            'teacher_review',
            'student_review',
            'interaction',
            'listening',
            'communication',
            'pronunciation',
            'vocab_grammar',
            'ticket_date',
            'rate',
        ];
    }

    public function title(): string
    {
        return 'StudentLessons';
    }
}
