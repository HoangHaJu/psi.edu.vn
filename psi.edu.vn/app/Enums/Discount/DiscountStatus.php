<?php

namespace App\Enums\Discount;


use App\Admin\Support\Enum;

enum DiscountStatus: int
{
    use Enum;

    case Published = 1;
    case Draft = 2;

    public function badge(): string
    {
        return match($this) {
            DiscountStatus::Published => 'bg-green',
            DiscountStatus::Draft => '',
        };
    }
}
