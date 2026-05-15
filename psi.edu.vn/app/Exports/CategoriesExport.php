<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CategoriesExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Lấy toàn bộ dữ liệu từ bảng 'categories'
        return DB::table('categories')->get();
    }

    public function headings(): array
    {
        // Trả về tiêu đề cho các cột
        return [
            'id',
            '_lft',
            '_rgt',
            'parent_id',
            'name',
            'slug',
            'avatar',
            'icon',
            'position',
            'is_active',
            'is_menu',
            'created_at',
            'updated_at',
        ];
    }
    public function title(): string {
        return 'Categories';
    }
}
