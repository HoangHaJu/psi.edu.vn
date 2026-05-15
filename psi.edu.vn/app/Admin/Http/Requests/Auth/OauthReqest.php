<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class OauthReqest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'email' => 'required|email',
        ];
    }
    protected function methodPost()
    {
        return [
            'email' => 'required|email',
            'token_active_account' => 'required|numeric',
        ];
    }
}
