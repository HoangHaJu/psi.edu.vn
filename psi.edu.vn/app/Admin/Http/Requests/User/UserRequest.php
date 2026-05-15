<?php

namespace App\Admin\Http\Requests\User;

use App\Admin\Http\Requests\BaseRequest;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\User\Gender;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends BaseRequest
{

    protected function methodPost(): array
    {
        return [
            'fullname' => ['required', 'string'],
            'phone' => [
                'required',
                'string',
                'unique:App\Models\User,phone'
            ],
            'email' => ['nullable', 'email', 'unique:App\Models\User,email'],
            'address' => ['nullable'],
            'is_checked' => ['nullable'],
            'password' => ['required', 'string', 'confirmed'],
            'gender' => ['required', new Enum(Gender::class)],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'bank_name' => [
                'required_if:is_checked,1',
            ],
            'bank_account_number' => [
                'required_if:is_checked,1',
            ],
            'bank_account' => [
                'required_if:is_checked,1',
            ],
            'active' => ['required'],
            'avatar' => ['nullable']
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\User,id'],
            'fullname' => ['required', 'string'],
            'bank_name' => [
                'required_if:is_checked,1',
            ],
            'bank_account_number' => [
                'required_if:is_checked,1',
            ],
            'bank_account' => [
                'required_if:is_checked,1',
            ],
            'email' => ['nullable', 'email', 'unique:App\Models\User,email,' . $this->id],
            'phone' => [
                'required',
                'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                'unique:App\Models\User,phone,' . $this->id
            ],
            'address' => ['nullable'],
            'is_checked' => ['nullable'],
            'points' => ['required'],
            'password' => ['nullable', 'string', 'confirmed'],
            'gender' => ['nullable', new Enum(Gender::class)],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'avatar' => ['nullable'],
            'active' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required_if' => 'Tên ngân hàng không được để trống',
            'bank_account_number.required_if' => 'Số tài khoản ngân hàng không được để trống',
            'bank_account.required_if' => 'Tài khoản ngân hàng không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'phone.unique' => 'Số điện thoại đã tồn tại',
        ];
    }
}
