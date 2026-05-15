<?php

namespace App\Exports;

use App\Models\Admin; // đảm bảo model Admin đã use HasRoles
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentSingleExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Admin::role('student') // dùng từ Spatie để lọc theo role
            ->select('fullname', 'email', 'phone')
            ->get();
    }

    public function headings(): array
    {
        return [
            'fullname',
            'email',
            'phone'
        ];
    }


    public function title(): string
    {
        return 'Students';
    }
}
