<?php

namespace App\Admin\Http\Requests\Category;

use App\Admin\Http\Requests\BaseRequest;

class CategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'name' => ['required', 'string', 'max:30'],
            'position' => ['required', 'integer', 'min:0'],
            'is_active' => ['required'],
            'icon' => ['nullable'],
            'avatar' => ['required']
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Category,id'],
            'name' => ['required', 'string', 'max:30'],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required'],
            'icon' => ['nullable'],
            'avatar' => ['required']
        ];
    }
}
