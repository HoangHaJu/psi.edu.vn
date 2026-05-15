<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TeacherLessonsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Lấy toàn bộ dữ liệu từ bảng 'teacher_lessons'
        return DB::table('teacher_lessons')->get();
    }

    public function headings(): array
    {
        // Trả về mảng tiêu đề cho các cột
        return [
            'id',
            'admin_id',
            'lesson_id',
        ];
    }

    public function title(): string
    {
        return 'TeacherLessons';
    }
}
