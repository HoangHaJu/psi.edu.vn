<?php

namespace App\Enums\Booking;

use App\Supports\Enum;

enum BookingStatus: int
{
    use Enum;

    case Pending = 1;
    case Confirmed = 2;
    case Cancelled = 3;

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-orange',
            self::Confirmed => 'bg-green',
            self::Cancelled => 'bg-red',
        };
    }
}
