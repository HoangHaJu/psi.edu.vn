<?php

namespace App\Enums\Store;


use App\Admin\Support\Enum;

enum BossType: int
{
    use Enum;

    // Nhà hàng
    case Restaurant = 1;
    // Tạp hoá
    case Grocery = 2;

    // Khách sạn
    case Hotel = 3;

    public function badge(): string
    {
        return match ($this) {
            BossType::Restaurant => 'bg-green-lt',
            BossType::Grocery => 'bg-red-lt',
            BossType::Hotel => 'bg-pink-lt',
        };
    }
}
