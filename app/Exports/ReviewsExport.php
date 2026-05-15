<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReviewsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return DB::table('reviews')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'rating',
            'content',
            'created_at',
            'updated_at',
            'admin_id',
            'course_id',
        ];
    }

    public function title(): string
    {
        return 'Reviews';
    }
}
