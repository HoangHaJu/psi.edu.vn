<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return DB::table('admins')
            ->leftJoin('student_lessons', 'admins.id', '=', 'student_lessons.admin_id')
            ->select(
                'admins.id',
                'admins.username',
                'admins.fullname',
                'admins.email',
                'admins.phone',
                'admins.birthday',
                'admins.gender',
                'admins.avatar',
                'admins.address',
                'admins.audio',
                'admins.education_level',
                'admins.token_active_account',
                'admins.token_get_password',
                'admins.is_active',
                'admins.password',
                'admins.remember_token',
                'admins.created_at as admin_created_at',
                'admins.updated_at as admin_updated_at',
                'admins.remaining_leave_requests',
                'admins.note',

                // Thêm các cột từ bảng student_lessons
                'student_lessons.id as lesson_id',
                'student_lessons.teacher_lesson_id',
                'student_lessons.status',
                'student_lessons.day_off_type',
                'student_lessons.note as lesson_note',
                'student_lessons.file_link',
                'student_lessons.created_at as lesson_created_at',
                'student_lessons.updated_at as lesson_updated_at',
                'student_lessons.date',
                'student_lessons.start_time',
                'student_lessons.course_name',
                'student_lessons.teacher_review',
                'student_lessons.student_review',
                'student_lessons.interaction',
                'student_lessons.listening',
                'student_lessons.communication',
                'student_lessons.pronunciation',
                'student_lessons.vocab_grammar',
                'student_lessons.ticket_date',
                'student_lessons.rate'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            // Cột của bảng admins
            'id',
            'username',
            'fullname',
            'email',
            'phone',
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
            'admin_created_at',
            'admin_updated_at',
            'remaining_leave_requests',
            'note',

            // Cột của bảng student_lessons
            'lesson_id',
            'teacher_lesson_id',
            'status',
            'day_off_type',
            'lesson_note',
            'file_link',
            'lesson_created_at',
            'lesson_updated_at',
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
            'rate'
        ];
    }

    public function title(): string
    {
        return 'Students';
    }
}
