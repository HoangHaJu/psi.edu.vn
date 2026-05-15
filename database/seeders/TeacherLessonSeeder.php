<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\TeacherLesson;
use Carbon\Carbon;

class TeacherLessonSeeder extends Seeder
{
    public function run(): void
    {
        // Chọn 1 khóa học cụ thể (hoặc tạo mới nếu chưa có)
        $course = Course::first() ?? Course::factory()->create();

        // Ngày dạy cố định
        $date = Carbon::today()->format('Y-m-d');

        // Lấy tất cả giáo viên (hoặc tạo 1000 giáo viên nếu chưa đủ)
        $teachersCount = 1000;
        $teachers = Admin::whereHas('roles', function ($q) {
            $q->where('name', 'teacher');
        })->get();

        if ($teachers->count() < $teachersCount) {
            $needed = $teachersCount - $teachers->count();
            Admin::factory($needed)->create()->each(function ($admin) {
                $admin->roles()->attach(3); // assuming role_id = 2 is 'teacher'
            });
            $teachers = Admin::whereHas('roles', function ($q) {
                $q->where('name', 'teacher');
            })->get();
        }

        // Tạo lịch dạy cho từng giáo viên cùng 1 ngày và 1 khóa
        foreach ($teachers as $teacher) {
            TeacherLesson::create([
                'admin_id' => $teacher->id,
                'lesson_id' => Lesson::factory()->create([
                    'course_id' => $course->id,
                    'date' => $date,
                ])->id,
            ]);
        }

        $this->command->info("✅ 1000 giáo viên đã được đăng ký lịch dạy cùng 1 ngày cho khóa học '{$course->name}'");
    }
}
