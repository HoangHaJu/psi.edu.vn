<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Categories' => new CategoriesExport(),
            'Courses' => new CoursesExport(),
            'Lessons' => new LessonsExport(),
            'Reviewers' => new ReviewsExport(),
            'StudentLessons' => new StudentLessonsExport(),
            'Students' => new StudentsExport(),
            'TeachingLessons' => new TeacherLessonsExport(),
            'Teachers' => new TeachersExport(),
        ];
    }
}
