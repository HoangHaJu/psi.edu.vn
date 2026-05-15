<?php

namespace App\Admin\Http\Requests\Teacher;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\DB;

class TeacherUpdateRequest extends BaseRequest
{
    protected function methodPut()
    {
        return
            [
                'id' => ['required', 'exists:App\Models\Admin,id'],
                'fullname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string'],
                'email' => ['required'],
                'password' => ['nullable', 'confirmed'],
                'is_active' => ['required'],
                'address' => ['nullable'],
                'birthday' => ['nullable'],
                'gender' => ['nullable'],
                'avatar' => ['nullable'],
                'note' => ['nullable'],
                'display' => ['required'],
            ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('skype_id')) {
                $skypeExists = DB::table('admins')
                    ->where('skype_id', $this->input('skype_id'))
                    ->where('is_active', 1)
                    ->where('id', '!=', $this->id)
                    ->exists();

                if ($skypeExists) {
                    $validator->errors()->add('skype_id', 'Skype ID đã tồn tại.');
                }
            }

            $phoneExists = DB::table('admins')
                ->where('phone', $this->input('phone'))
                ->where('is_active', 1)
                ->where('id', '!=', $this->id)
                ->exists();

            if ($phoneExists) {
                $validator->errors()->add('phone', 'Số điện thoại đã tồn tại.');
            }

            $emailExists = DB::table('admins')
                ->where('email', $this->input('email'))
                ->where('is_active', 1)
                ->where('id', '!=', $this->id)
                ->exists();

            if ($emailExists) {
                $validator->errors()->add('email', 'Email đã tồn tại.');
            }
        });
    }
}
