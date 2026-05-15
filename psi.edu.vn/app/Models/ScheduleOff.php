<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleOff extends Model
{
    use HasFactory;

    protected $table = 'schedule_off';

    protected $fillable = [
        'student_lesson_id',
        'student_id',
        'teacher_id',
        'is_active',
        'reason',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'teacher_id');
    }

    public function student_lesson(): BelongsTo
    {
        return $this->belongsTo(StudentLesson::class, 'student_lesson_id');
    }
}
