<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CourseFilter extends BaseFilter
{
    protected function filters(): array
    {
        return [
            'search',
            'categories',
            'levels',
            'lessons',
            'teacherGender',
            'teacherRating'
        ];
    }

    protected function search()
    {
        if ($this->request->filled('search')) {
            $searchTerm = $this->request->input('search');

            $this->query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhereHas('categories', fn(Builder $sq) =>
                    $sq->where('name', 'like', "%{$searchTerm}%"))
                    ->orWhereHas('lessons.teacherLessons.teacher', fn(Builder $sq) =>
                    $sq->where('fullname', 'like', "%{$searchTerm}%"));
            });
        }
    }

    protected function categories()
    {
        if ($this->request->filled('categories')) {
            $ids = is_array($this->request->categories)
                ? $this->request->categories
                : explode(',', $this->request->categories);

            $this->query->whereHas('categories', fn(Builder $q) =>
            $q->whereIn('id', $ids));
        }
    }

    protected function levels()
    {
        if ($this->request->filled('levels')) {
            $levels = is_array($this->request->levels)
                ? $this->request->levels
                : explode(',', $this->request->levels);

            $this->query->whereIn('education_level', $levels);
        }
    }

    protected function lessons()
    {
        $date      = $this->request->input('date');
        $teacherId = $this->request->input('teacher_id');
        $lessonId  = $this->request->input('lesson_id') ?? $this->request->input('lessonId');

        if ($date || $teacherId || $lessonId) {
            $this->query->whereHas('lessons', function (Builder $lessonQ) use ($date, $teacherId, $lessonId) {
                $lessonQ->when($date, fn($q) => $q->whereDate('date', $date))
                    ->when($teacherId || $lessonId, function ($q) use ($teacherId, $lessonId) {
                        $q->whereHas('teacherLessons', function (Builder $tq) use ($teacherId, $lessonId) {
                            if ($teacherId) $tq->where('admin_id', $teacherId);
                            if ($lessonId)  $tq->where('id', $lessonId);
                        });
                    });
            });
        }
    }

    protected function teacherGender()
    {
        if ($this->request->filled('teacherGender')) {
            $genders = is_array($this->request->teacherGender)
                ? $this->request->teacherGender
                : explode(',', $this->request->teacherGender);

            $this->query->whereHas('lessons.teacherLessons.teacher', fn(Builder $q) =>
            $q->whereIn('gender', $genders));
        }
    }

    protected function teacherRating()
    {
        if ($this->request->filled('teacherRating')) {
            $ratings = is_array($this->request->teacherRating)
                ? array_map('intval', $this->request->teacherRating)
                : array_map('intval', explode(',', $this->request->teacherRating));

            $this->query->whereHas('lessons.teacherLessons.studentLesson', fn(Builder $q) =>
            $q->whereIn('rate', $ratings));
        }
    }
}
