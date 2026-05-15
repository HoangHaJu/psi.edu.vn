<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketStudent extends Model
{
    use HasFactory;

    protected $table = 'ticket_students';

    protected $fillable = [
        'id',
        'ticket_id',
        'admin_id',
        'remaining_tickets',
        'expired_date',
        'status',
    ];

    protected $dates = ['expired_date'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Helper: check vé còn hợp lệ
    public function isValid(): bool
    {
        return $this->status === 'active'
            && $this->remaining_tickets > 0
            && $this->expired_date->isFuture();
    }

    public function getStatusAttribute($value)
    {
        if ($this->remaining_tickets <= 0) {
            return 'no_ticket';
        }

        if ($this->expired_date < now()->toDateString()) {
            return 'expired';
        }

        return $value; // status hiện tại, ví dụ 'active'
    }
    public static function getUserTicketTypes(int $adminId): array
    {
        return self::where('admin_id', $adminId)
            ->where('status', 'active')
            ->where('remaining_tickets', '>', 0)
            ->whereDate('expired_date', '>=', now())
            ->with('ticket')
            ->get()
            ->pluck('ticket.type') // lấy type từ relation ticket
            ->unique()
            ->values()
            ->toArray();
    }
}
