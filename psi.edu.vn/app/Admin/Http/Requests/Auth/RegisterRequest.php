<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'fullname' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'string', 'confirmed'],
            'is_active' => ['nullable'],
            'phone' => [
                'required',
                'string',
                'unique:admins,phone',
            ],
            'is_teacher' => ['boolean'],
            'gender' => ['nullable', 'in:1,2'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $email = $this->input('email');
            $phone = $this->input('phone');

            // Check email only if user has provided it
            if ($email) {
                $emailExists = DB::table('admins')
                    ->where('email', $email)
                    ->where('is_active', 1)
                    ->exists();
                if ($emailExists) {
                    $validator->errors()->add('email', 'The email address is already in use.');
                }
            }

            $phoneExists = DB::table('admins')
                ->where('phone', $phone)
                ->where('is_active', 1)
                ->exists();

            if ($phoneExists) {
                $validator->errors()->add('phone', 'The phone number is already in use.');
            }
        });
    }
}
