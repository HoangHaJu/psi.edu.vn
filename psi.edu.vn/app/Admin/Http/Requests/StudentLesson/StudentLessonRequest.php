<?php

namespace App\Admin\Http\Requests\StudentLesson;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Lesson\LessonStatus;
use App\Models\StudentLesson;
use Carbon\Carbon;

class StudentLessonRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\StudentLesson,id'],
            'status' => ['nullable'],
            'day_off_type' => ['nullable'],
            'note' => ['nullable'],
            'file_link' => ['nullable'],
            'student_review' => ['nullable'],
            'teacher_review' => ['nullable'],
            'rate' => ['nullable', 'numeric', 'min: 1', 'max: 5'],
            'interaction' => ['nullable', 'numeric', 'min: 1', 'max: 5'],
            'listening' => ['nullable', 'numeric', 'min: 1', 'max: 5'],
            'communication' => ['nullable', 'numeric', 'min: 1', 'max: 5'],
            'pronunciation' => ['nullable', 'numeric', 'min: 1', 'max: 5'],
            'vocab_grammar' => ['nullable', 'numeric', 'min: 1', 'max: 5'],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (request()->isMethod('put')) {
                $instance = StudentLesson::find($this->id);
                if ($instance->date <= Carbon::now()->subDays(7)) {
                    $validator->errors()->add('date', 'Không thể cập nhật các buổi học đã qua.');
                }
                if (auth('admin')->user()->isStudent) {
                    if ($instance->status != LessonStatus::Present->value) {
                        $validator->errors()->add('student_review', 'Không thể đánh giá buổi học chưa được học xong.');
                    }
                }
                if (auth('admin')->user()->isTeacher) {
                    if (
                        $instance->status != LessonStatus::Present->value &&
                        (isset($this->teacher_review) || isset($this->interaction) || isset($this->listening)
                            || isset($this->communication)
                            || isset($this->pronunciation)
                            || isset($this->vocab_grammar))
                    ) {
                        $validator->errors()->add('teacher_review', 'Không thể đánh giá buổi học chưa được học xong.');
                    }
                }
            }
        });
    }
}
