<?php

namespace App\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResetPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodGet()
    {
        return [
            'id' => ['required', 'exists:App\Models\Admin,id'],
            'token' => ['required', 'exists:App\Models\Admin,token_get_password']
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Admin,id'],
            'token' => ['required', 'exists:App\Models\Admin,token_get_password'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }
}
