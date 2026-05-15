<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\DB;

class ProfileRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut()
    {
        $this->validate = [
            'fullname' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'unique:App\Models\Admin,phone,' . auth('admin')->user()->id
            ],

            'email' => [
                'required',
                'email',
                'unique:App\Models\Admin,email,' . auth('admin')->user()->id
            ],
            'address' => ['nullable'],
            'audio' => ['nullable', 'file', 'mimes:mp3,wav', 'max:2048'],
            'birthday' => ['nullable'],
            'gender' => ['required'],
            'avatar' => ['nullable'],
            'skype_id' => ['nullable'],
            'education_level' => ['nullable'],
            'national_flag' => ['nullable'],
            'link' => ['nullable'],
        ];
        return $this->validate;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('skype_id')) {
                $skypeExists = DB::table('admins')
                    ->where('skype_id', $this->input('skype_id'))
                    ->where('is_active', 1)
                    ->where('id', '!=', auth('admin')->user()->id)
                    ->exists();

                if ($skypeExists) {
                    $validator->errors()->add('skype_id', 'Skype ID đã tồn tại.');
                }
            }

            $phoneExists = DB::table('admins')
                ->where('phone', $this->input('phone'))
                ->where('is_active', 1)
                ->where('id', '!=', auth('admin')->user()->id)
                ->exists();

            if ($phoneExists) {
                $validator->errors()->add('phone', 'Số điện thoại đã tồn tại.');
            }

            $emailExists = DB::table('admins')
                ->where('email', $this->input('email'))
                ->where('is_active', 1)
                ->where('id', '!=', auth('admin')->user()->id)
                ->exists();

            if ($emailExists) {
                $validator->errors()->add('email', 'Email đã tồn tại.');
            }
        });
    }
}
