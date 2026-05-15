<?php

namespace App\Enums\Topping;

use App\Supports\Enum;

enum ToppingStatus: int
{
    use Enum;

    case InStock = 1;
    case OutOfStock = 2;

    public function badge(): string
    {
        return match($this) {
            self::InStock => 'bg-yellow-lt',
            self::OutOfStock => 'bg-green-lt',
        };
    }

}
