<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\DB;

class ForgotPasswordRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isExist = DB::table('admins')
                ->where('email', $this->input('email'))
                ->where('is_active', 1)
                ->exists();

            if (!$isExist) {
                $validator->errors()->add('email', 'Tài khoản không tồn tại.');
            }
        });
    }
}
