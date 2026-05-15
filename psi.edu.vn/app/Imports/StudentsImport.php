<?php

namespace App\Imports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $student = new Admin([
            'id'                        => $row['id'] ?? null,
            'username'                  => $row['username'] ?? null,
            'fullname'                  => $row['fullname'] ?? null,
            'email'                     => $row['email'] ?? null,
            'phone'                     => $row['phone'] ?? null,
            'skype_id'                  => $row['skype_id'] ?? null,
            'birthday'                  => $row['birthday'] ?? null,
            'gender'                    => $row['gender'] ?? null,
            'avatar'                    => $row['avatar'] ?? null,
            'address'                   => $row['address'] ?? null,
            'audio'                     => $row['audio'] ?? null,
            'education_level'           => $row['education_level'] ?? null,
            'token_active_account'      => $row['token_active_account'] ?? null,
            'token_get_password'        => $row['token_get_password'] ?? null,
            'is_active'                 => $row['is_active'] ?? 1,
            'password'                  => $row['password'] ?? null,
            'remember_token'            => $row['remember_token'] ?? null,
            'created_at'                => $row['created_at'] ?? now(),
            'updated_at'                => $row['updated_at'] ?? now(),
            'remaining_leave_requests'  => $row['remaining_leave_requests'] ?? 0,
            'note'                      => $row['note'] ?? null,
        ]);

        $student->assignRole('student');
        return $student;
    }
}
