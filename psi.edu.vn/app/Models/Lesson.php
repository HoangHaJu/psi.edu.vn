<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $fillable = [
        'start_time',
        'date',
        'course_id',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function teacherLessons()
    {
        return $this->hasMany(TeacherLesson::class, 'lesson_id', 'id');
    }

    // public function admin(): BelongsToMany
    // {
    //     return $this->belongsToMany(related: Admin::class, 'teacher_lessons', 'lesson_id', 'admin_id');
    // }

    public function scheduleOff(): HasOne
    {
        return $this->hasOne(ScheduleOff::class, 'lesson_id');
    }
    public static function getLessonsForTeachers()
    {
        return self::query()
            ->select('*')
            ->join('teacher_lessons as t', 'lessons.id', '=', 't.lesson_id')
            ->whereIn('t.admin_id', function ($query) {
                $query->select('a.id')
                    ->from('admins as a')
                    ->join('model_has_roles as m', 'a.id', '=', 'm.model_id')
                    ->join('roles as r', 'r.id', '=', 'm.role_id')
                    ->where('r.name', 'teacher');
            })
            ->get();
    }
}
