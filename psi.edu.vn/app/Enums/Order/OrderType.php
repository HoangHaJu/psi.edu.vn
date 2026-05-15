<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderType: int
{
    use Enum;

    case Booking = 1;

    case Renting = 2;
    public function badge(): string
    {
        return match($this) {
            self::Booking => 'bg-yellow-lt',
            self::Renting => 'bg-green-lt',

        };
    }

}
