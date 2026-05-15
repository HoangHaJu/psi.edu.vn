<?php

namespace App\Admin\Http\Requests\Review;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Lesson\LessonStatus;
use App\Models\Booking;
use App\Models\Lesson;
use Illuminate\Validation\Validator;

class ReviewRequest extends BaseRequest
{

    protected function methodPost(): array
    {
        return [
            'booking_id' => ['required', 'exists:App\Models\Booking,id'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'content' => ['nullable'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $booking = Booking::find($this->booking_id);
            $isExist = Lesson::where('course_id', $booking->course_id)->where('admin_id', $booking->admin_id)->where('status', LessonStatus::NotPresent)->first();
            if ($isExist) {
                $validator->errors()->add('course_id', __('Bạn phải học xong khoá học mới có thể đánh giá.'));
            }
        });
    }
}
