<?php

namespace App\Admin\Http\Resources\Booking;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,  // ID của booking
            'status' => $this->status,  // Trạng thái của booking
            'teacher_lesson_id' => $this->teacher_lesson_id,  // ID của buổi học giáo viên
            'admin_id' => $this->admin_id,  // ID của admin tạo booking
            'date' => $this->date,  // Ngày tạo booking
        ];
    }
}
