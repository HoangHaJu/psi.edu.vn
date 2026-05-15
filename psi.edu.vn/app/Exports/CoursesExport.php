<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CoursesExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Lấy toàn bộ dữ liệu từ bảng 'courses'
        return DB::table('courses')->get();
    }

    public function headings(): array
    {
        // Trả về tiêu đề cho các cột
        return [
            'id',
            'name',
            'slug',
            'education_level',
            'is_active',
            'avatar',
            'description',
            'created_at',
            'updated_at',
        ];
    }

    public function title(): string
    {
        return 'Courses';
    }
}
