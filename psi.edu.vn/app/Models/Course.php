<?php

namespace App\Models;

use App\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Admin\Traits\Filterable;

class Course extends Model
{
    use HasFactory, Sluggable, Filterable;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'avatar',
        'description',
        'education_level',
    ];


    protected $columnSlug = 'name';


    protected static function boot()
    {
        parent::boot();
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'courses_categories', 'course_id', 'category_id')->orderBy('position', 'asc');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'course_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'teacher_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'course_id')->orderBy('date', 'asc');
    }

    public function selfLessons(): HasMany
    {
        $adminId = auth('admin')->user()->id;
        return $this->hasMany(Lesson::class, 'course_id')->where('admin_id', $adminId)->orderBy('date', 'asc');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'student_id');
    }
}
