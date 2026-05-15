<?php

namespace App\Admin\Http\Requests\ScheduleOff;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Lesson\DayOffType;
use App\Models\Lesson;
use App\Models\ScheduleOff;
use App\Models\StudentLesson;
use Carbon\Carbon;

class ScheduleOffRequest extends BaseRequest
{
    protected function methodPost(): array
    {
        return [
            'reason' => ['required'],
            'student_lesson_id' => ['required', 'exists:App\Models\StudentLesson,id'],
            'admin_id' => ['required', 'exists:App\Models\Admin,id'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\ScheduleOff,id'],
            'is_active' => ['required'],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Kiểm tra nếu method là POST
            if (request()->isMethod('post')) {
                if (auth('admin')->user()->isStudent) {
                    if (auth('admin')->user()->remaining_leave_requests <= 0) {
                        $validator->errors()->add('student_lesson_id', 'Bạn đã hết lượt yêu cầu nghỉ phép.');
                    }
                }
                $student_lesson = StudentLesson::find($this->student_lesson_id);

                $currentDate = Carbon::now();
                $studentLessonDate = Carbon::parse($student_lesson->date); // Chuyển đổi sang Carbon
                $studentLessonStartTime = Carbon::parse($student_lesson->start_time); // Chuyển đổi sang Carbon

                // Kiểm tra nếu buổi học vào cuối tuần (thứ 7 hoặc chủ nhật)
                if ($currentDate->isSaturday() || $currentDate->isSunday()) {
                    $validator->errors()->add('student_lesson_id', 'Không thể xin nghỉ vào cuối tuần.');
                }


                // Nếu buổi học < ngày hiện tại
                if ($studentLessonDate->copy()->startOfDay()->lt($currentDate)) { // Dùng copy để giữ nguyên thời gian
                    $validator->errors()->add('student_lesson_id', 'Buổi học đã quá thời gian cho phép để xin nghỉ.');
                }

                // Nếu buổi học là ngày hôm nay
                if ($studentLessonDate->isToday()) {
                    // Nếu đã > 3 giờ chiều
                    if ($currentDate->format('H:i') > '15:00') {
                        $validator->errors()->add('student_lesson_id', 'Buổi học đã quá thời gian cho phép để xin nghỉ.');
                    }

                    // Nếu giờ bắt đầu của buổi học >= 3 giờ chiều
                    if ($studentLessonStartTime->format('H:i') >= '15:00') {
                        $validator->errors()->add('student_lesson_id', 'Buổi học bắt đầu sau 3 giờ chiều không thể xin nghỉ trong ngày.');
                    }
                }
            }

            if (request()->isMethod('delete')) {
                $scheduleOff = ScheduleOff::find($this->id);

                $currentDate = now();
                $studentLessonDate = Carbon::parse($scheduleOff->student_lesson->date); // Chuyển đổi sang Carbon
                $studentLessonStartTime = Carbon::parse($scheduleOff->student_lesson->start_time); // Chuyển đổi sang Carbon

                // Nếu buổi học < ngày hiện tại
                if ($studentLessonDate->copy()->startOfDay()->lt($currentDate)) { // Dùng copy để giữ nguyên thời gian
                    $validator->errors()->add('student_lesson_id', 'Buổi học đã quá thời gian cho phép để huỷ.');
                }

                // Nếu buổi học là ngày hôm nay
                if ($studentLessonDate->isToday()) {
                    // Nếu đã > 3 giờ chiều
                    if ($currentDate->format('H:i') > '15:00') {
                        $validator->errors()->add('student_lesson_id', 'Buổi học đã quá thời gian cho phép để huỷ.');
                    }

                    // Nếu giờ bắt đầu của buổi học >= 3 giờ chiều
                    if ($studentLessonStartTime->format('H:i') >= '15:00') {
                        $validator->errors()->add('student_lesson_id', 'Buổi học bắt đầu sau 3 giờ chiều không thể huỷ.');
                    }
                }
            }
        });
    }
}
