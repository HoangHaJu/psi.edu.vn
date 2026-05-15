<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\DB;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'identifier' => 'required',
            'password' => 'required',
            'remember' => 'nullable',
        ];
    }
}
