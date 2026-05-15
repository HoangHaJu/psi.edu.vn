<?php

namespace App\Admin\Repositories\Booking;

use App\Admin\Repositories\EloquentRepository;
use App\Enums\Booking\BookingStatus;
use App\Models\StudentLesson;

class BookingRepository extends EloquentRepository implements BookingRepositoryInterface
{

    public function getModel(): string
    {
        return StudentLesson::class;
    }
    public function findBy(array $conditions)
    {
        return $this->model->where($conditions)->first();
    }
    public function getConflictBooking($schedule, $startDate, $endDate, $startTime, $endTime, $studentId)
    {
        $this->instance = $this->getBy(['admin_id' => $studentId]);
        foreach ($this->instance as $booking) {
            if ($booking->status != BookingStatus::Cancelled->value) {
                // Kiểm tra xung đột lịch
                $hasOverlappingSchedule = collect($schedule)
                    ->intersect(json_decode($booking->course->schedule))
                    ->isNotEmpty();
                if ($hasOverlappingSchedule) {
                    $courseStartDate = $booking->course->start_date;
                    $courseEndDate = $booking->course->end_date;
                    if ($this->isDateOverlap($courseStartDate, $courseEndDate, $startDate, $endDate)) {
                        // Kiểm tra nếu khóa học có xung đột về thời gian (nằm trong khoảng thời gian đã cho)
                        $courseStartTime = $booking->course->start_time;
                        $courseEndTime = $booking->course->end_time;

                        // Kiểm tra xem thời gian của khóa học có xung đột với thời gian đã truyền vào không
                        if ($this->isTimeOverlap($courseStartTime, $courseEndTime, $startTime, $endTime)) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    private function isDateOverlap($startDate1, $endDate1, $startDate2, $endDate2)
    {
        return !(strtotime($endDate1) < strtotime($startDate2) || strtotime($startDate1) > strtotime($endDate2));
    }

    private function isTimeOverlap($courseStartTime, $courseEndTime, $startTime, $endTime)
    {
        // Kiểm tra xung đột thời gian (nếu thời gian của khóa học bắt đầu trước khi buổi học kết thúc và kết thúc sau khi buổi học bắt đầu)
        return ($courseStartTime < $endTime && $courseEndTime > $startTime);
    }


    //    public function getDetailByCourseId($course_id)
    //    {
    //        return $this->model->where('course_id', '=', $course_id)->first();
    //    }
}
