<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use HasRoles;
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => 'integer',
        'education_level' => 'integer',
    ];
    protected $appends = ['age']; // Thêm thuộc tính ảo 'age'

    public function getAgeAttribute()
    {
        return $this->birthday ? Carbon::parse($this->birthday)->age : null;
    }
    public function ticket_students()
    {
        return $this->hasMany(TicketStudent::class, 'admin_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles',  'model_id', 'role_id')->wherePivotIn('model_type', ['AppModelsAdmin', 'App\Models\Admin']);
    }
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'teacher_lessons', 'admin_id', 'lesson_id');
    }

    public function student_lessons()
    {
        return $this->hasMany(StudentLesson::class, 'admin_id', 'id');
    }

    public function teacher_lessons()
    {
        return $this->hasMany(TeacherLesson::class, 'admin_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'admin_id', 'id');
    }

    public function checkPermissions($permissionsArr): bool
    {
        $adminPermissions = $this->getAllPermissions()->pluck('name')->toArray();
        foreach ($permissionsArr as $permission) {
            if (in_array($permission, $adminPermissions)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        $roles = array_column($this->roles->toArray(), 'name');
        return in_array($role, $roles);
    }

    public function getIsTeacherAttribute()
    {
        return $this->hasRole('teacher');
    }

    public function getIsStudentAttribute()
    {
        return $this->hasRole('student');
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->hasRole('superAdmin');
    }
    public function student_lesson()
    {
        return $this->hasManyThrough(StudentLesson::class, TeacherLesson::class, 'admin_id', 'teacher_lesson_id', 'id', 'id');
    }
}
