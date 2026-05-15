<?php

namespace App\Enums\Store;


use App\Admin\Support\Enum;

enum StoreStatus: int
{
    use Enum;

    case Open = 1;
    case Close = 2;

    public function badge(): string
    {
        return match($this) {
            StoreStatus::Open => 'bg-green-lt',
            StoreStatus::Close => 'bg-red-lt',
        };
    }
}
