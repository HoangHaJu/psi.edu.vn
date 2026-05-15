<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetImport implements WithMultipleSheets
{
    public function __construct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Tắt kiểm tra khóa ngoại
    }

    public function __destruct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Bật lại kiểm tra khóa ngoại
    }


    public function sheets(): array
    {
        return [
            'Categories' => new CategoriesImport(),
            'Courses' => new CoursesImport(),
            'Lessons' => new LessonsImport(),
            'Reviews' => new ReviewsImport(),
            'Students' => new StudentsImport(),
            'StudentLessons' => new StudentLessonsImport(),
            'TeacherLessons' => new TeacherLessonsImport(),
            'Teachers' => new TeachersImport(),
        ];
    }
}
