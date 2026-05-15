<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut()
    {
        $guard = auth('admin')->check() ? 'admin' : 'web';

        return [
            'old_password' => ['required', "current_password:$guard"],
            'password' => ['required', 'string', 'max:255', 'confirmed'],
        ];
    }
}
