<?php

namespace App\Admin\Http\Requests\Lesson;

use App\Admin\Http\Requests\BaseRequest;

class LessonRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Lesson,id'],
            'start_time' => ['required'],
            'course_id' => ['required', 'exists:App\Models\Course,id'],
        ];
    }
    protected function methodPost(): array
    {
        return [
            'start_time' => ['required'],
            'end_time' => ['required'],
            'period' => ['required'],
            'date' => ['nullable'],
            'daterange'  => ['required', 'string'],
            'course_id' => ['required', 'exists:App\Models\Course,id'],
        ];
    }
}
