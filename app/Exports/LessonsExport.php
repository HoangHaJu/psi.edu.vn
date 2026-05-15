<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


class LessonsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return DB::table('lessons')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'start_time',
            'created_at',
            'updated_at',
            'course_id',
            'date'
        ];
    }

    public function title(): string
    {
        return 'Lessons';
    }
}
