<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends  Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tickets';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'during',
        'description',
        'type',
        'avatar',
    ];

    public function studentLessons()
    {
        return $this->hasMany(StudentLesson::class, 'ticket_id');
    }

    public function ticketStudent()
    {
        return $this->hasMany(TicketStudent::class, 'ticket_id', 'id');
    }
}
