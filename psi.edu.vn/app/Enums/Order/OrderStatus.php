<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderStatus: int
{
    use Enum;

    case Pending = 1;
    case Confirmed = 2;
    case Prepared = 3; // Đã chuẩn bị đơn xong
    case Delivering = 4;
    case Completed = 5;
    case Cancelled = 6;

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-orange',
            self::Confirmed => 'bg-blue',
            self::Prepared => 'bg-cyan',
            self::Delivering => 'bg-pink',
            self::Completed => 'bg-green',
            self::Cancelled => 'bg-red',
        };
    }
}
