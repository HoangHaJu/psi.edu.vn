<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLesson extends Model
{
    use HasFactory;

    protected $table = 'student_lessons';

    protected $fillable = [
        'admin_id',
        'teacher_lesson_id',
        'status',
        'day_off_type',
        'note',
        'file_link',
        'date',
        'start_time',
        'course_name',
        'rate',
        'student_review',
        'teacher_review',
        'interaction',
        'listening',
        'communication',
        'pronunciation',
        'vocab_grammar',
        'ticket_date',
        'ticket_type',
        'ticket_id',
    ];
    protected $guarded = [];

    protected $casts = [
        // 'teacher_lesson_id' => 'array',
    ];
    public function student()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    // Model StudentLesson.php
    public function teacherLesson()
    {
        return $this->belongsTo(TeacherLesson::class, 'teacher_lesson_id');
    }

    public function teacher_lesson()
    {
        return $this->belongsTo(TeacherLesson::class, 'teacher_lesson_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
