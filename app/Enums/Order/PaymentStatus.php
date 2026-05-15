<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum PaymentStatus: int
{
    use Enum;

    case UnPaid = 1;
    case Paid = 2;
    case Pending = 3;

    public function badge(): string
    {
        return match ($this) {
            self::Paid => 'bg-green',
            self::UnPaid => 'bg-red',
            self::Pending => 'bg-orange',
        };
    }
}
