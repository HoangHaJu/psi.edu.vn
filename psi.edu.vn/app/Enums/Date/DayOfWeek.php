<?php

namespace App\Enums\Date;

use App\Admin\Support\Enum;

enum DayOfWeek: int
{
    use Enum;

    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;
    case Sunday = 7;

    public function label(): string
    {
        return match ($this) {
            DayOfWeek::Sunday => __('Chủ nhật'),
            DayOfWeek::Monday => __('Thứ 2'),
            DayOfWeek::Tuesday => __('Thứ 3'),
            DayOfWeek::Wednesday => __('Thứ 4'),
            DayOfWeek::Thursday => __('Thứ 5'),
            DayOfWeek::Friday => __('Thứ 6'),
            DayOfWeek::Saturday => __('Thứ 7'),
        };
    }
}
