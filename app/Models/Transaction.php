<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $guarded = [];

    protected $casts = [];

    /**
     * Lấy các Permissions của Module đó.
     */
    public function user()
    {
        return $this->belongsTo(Admin::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
