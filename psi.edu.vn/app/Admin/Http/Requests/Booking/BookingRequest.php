<?php

namespace App\Admin\Http\Requests\Booking;

use App\Admin\Http\Requests\BaseRequest;
use App\Models\StudentLesson;
use App\Models\TeacherLesson;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class BookingRequest extends BaseRequest
{
    protected function methodGet(): array
    {
        return [
            'fullname' => ['nullable'],
            'gender' => ['nullable'],
            'date' => ['nullable'],
            'education_level' => ['nullable'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
        ];
    }

    protected function methodPost(): array
    {
        return [
            '*.course_id' => ['required', 'integer', 'exists:App\Models\Course,id'],
            '*.date' => ['required', 'date_format:Y-m-d'],
            '*.teacher_id' => ['required', 'integer', 'exists:App\Models\Admin,id'],
            '*.lesson_id' => ['required', 'integer', 'exists:App\Models\Lesson,id'],
            '*.teacher_lesson_id' => [
                'required',
                'integer',
                'exists:App\Models\TeacherLesson,id',
            ],
            '*.start_time' => ['required', 'date_format:H:i:s'],
            '*.end_time' => ['nullable', 'date_format:H:i:s'],
            '*.student_id' => ['nullable', 'integer', 'exists:App\Models\Admin,id'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Booking,id'],
            'status' => ['required']
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (request()->isMethod('post')) {
                $bookingsData = $this->all();

                foreach ($bookingsData as $index => $booking) {
                    $teacherLessonId = $booking['teacher_lesson_id'] ?? null;
                    $courseId = $booking['course_id'] ?? null;
                    $selectedDateStr = $booking['date'] ?? null;
                    $teacherId = $booking['teacher_id'] ?? null;
                    $studentId = $booking['student_id'] ?? null;

                    if (is_null($teacherLessonId) || is_null($courseId) || is_null($selectedDateStr) || is_null($teacherId)) {
                        continue;
                    }

                    $teacherLesson = TeacherLesson::find($teacherLessonId);

                    if (!$teacherLesson) {
                        $validator->errors()->add("{$index}.teacher_lesson_id", 'ID buổi học không tồn tại.');
                        continue;
                    }

                    try {
                        $selectedDate = Carbon::parse($selectedDateStr)->startOfDay();
                    } catch (\Exception $e) {
                        $validator->errors()->add("{$index}.date", 'Định dạng ngày không hợp lệ.');
                        continue;
                    }

                    if (Carbon::parse($teacherLesson->lesson->date)->startOfDay()->lt(Carbon::now()->startOfDay())) {
                        $validator->errors()->add("{$index}.date", 'Không thể đăng ký buổi học của quá khứ.');
                        continue;
                    }

                    if (Carbon::parse($teacherLesson->lesson->date)->startOfDay()->format('Y-m-d') !== $selectedDate->format('Y-m-d')) {
                        $validator->errors()->add("{$index}.date", 'Buổi học không diễn ra vào ngày đã chọn.');
                        continue;
                    }

                    if ($studentId) {
                        if (StudentLesson::where('teacher_lesson_id', $teacherLesson->id)->where('admin_id', $studentId)->exists()) {
                            $validator->errors()->add("{$index}.teacher_lesson_id", 'Học viên này đã đăng ký buổi học này rồi.');
                            continue;
                        }
                    } else {
                        if (StudentLesson::where('teacher_lesson_id', $teacherLesson->id)->exists()) {
                            $validator->errors()->add("{$index}.teacher_lesson_id", 'Buổi học này đã có học viên đăng ký.');
                            continue;
                        }
                    }

                    if ($teacherLesson->admin_id != $teacherId) {
                        $validator->errors()->add("{$index}.teacher_id", 'Giáo viên của buổi học không khớp.');
                        continue;
                    }
                }
            }
        });
    }
}
