<?php

namespace App\Enums\Booking;

use App\Supports\Enum;

enum PaymentStatus: int
{
    use Enum;

    case UnPaid = 1;
    case Paid = 2;

    public function badge(): string
    {
        return match ($this) {
            self::Paid => 'bg-green',
            self::UnPaid => 'bg-red',
        };
    }
}
