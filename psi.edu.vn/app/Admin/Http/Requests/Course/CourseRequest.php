<?php

namespace App\Admin\Http\Requests\Course;

use App\Admin\Http\Requests\BaseRequest;
use App\Models\Course;

class CourseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'categories_id' => ['required', 'array'],
            'categories_id.*' => ['required', 'exists:App\Models\Category,id'],
            'name' => ['required', 'string'],
            'is_active' => ['nullable'],
            'avatar' => ['required'],
            'description' => ['required'],
            'education_level' => ['required'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Course,id'],
            'categories_id' => ['required', 'array'],
            'categories_id.*' => ['required', 'exists:App\Models\Category,id'],
            'name' => ['required', 'string'],
            'is_active' => ['nullable'],
            'avatar' => ['nullable'],
            'description' => ['required'],
            'education_level' => ['required'],
        ];
    }
}
