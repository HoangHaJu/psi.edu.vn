<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLesson extends Model
{
    use HasFactory;

    protected $table = 'teacher_lessons';

    protected $guarded = [];

    protected $casts = [];
    public $timestamps = false;

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    public function studentLesson()
    {
        return $this->hasMany(StudentLesson::class, 'teacher_lesson_id', 'id');
    }
}
