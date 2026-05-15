<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TeachersExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Lấy toàn bộ dữ liệu từ bảng 'teachers'
        return DB::table('admins')->get();
    }

    public function headings(): array
    {
        // Trả về mảng tiêu đề cho các cột
        return [
            'id',
            'username',
            'fullname',
            'email',
            'phone',
            'skype_id',
            'birthday',
            'gender',
            'avatar',
            'address',
            'audio',
            'education_level',
            'token_active_account',
            'token_get_password',
            'is_active',
            'password',
            'remember_token',
            'created_at',
            'updated_at',
            'remaining_leave_requests',
            'note',
        ];
    }

    public function title(): string
    {
        return 'Teachers';
    }
}
