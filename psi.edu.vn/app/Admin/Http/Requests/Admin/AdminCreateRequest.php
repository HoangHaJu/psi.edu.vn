<?php

namespace App\Admin\Http\Requests\Admin;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\DB;

class AdminCreateRequest extends BaseRequest
{
    protected function methodPost()
    {
        return
            [
                'fullname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string'],
                'email' => ['required'],
                'password' => ['required', 'confirmed'],
                'is_active' => ['required'],
                'address' => ['nullable'],
                'birthday' => ['nullable'],
                'gender' => ['required'],
                'avatar' => ['nullable'],
                'note' => ['nullable'],
            ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('skype_id')) {
                $skypeExists = DB::table('admins')
                    ->where('skype_id', $this->input('skype_id'))
                    ->where('is_active', 1)
                    ->exists();

                if ($skypeExists) {
                    $validator->errors()->add('skype_id', 'Skype ID đã tồn tại.');
                }
            }

            $phoneExists = DB::table('admins')
                ->where('phone', $this->input('phone'))
                ->where('is_active', 1)
                ->exists();

            if ($phoneExists) {
                $validator->errors()->add('phone', 'Số điện thoại đã tồn tại.');
            }

            $emailExists = DB::table('admins')
                ->where('email', $this->input('email'))
                ->where('is_active', 1)
                ->exists();

            if ($emailExists) {
                $validator->errors()->add('email', 'Email đã tồn tại.');
            }
        });
    }
}
