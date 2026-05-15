<?php

namespace App\Enums\Lesson;

use App\Supports\Enum;

enum DayOffType: int
{
    use Enum;

    case Teacher = 1;
    case Student = 2;
    case None = 3;

    public function badge(): string
    {
        return match ($this) {
            self::Teacher => 'bg-orange',
            self::Student => 'bg-red',
            self::None => 'bg-green',
        };
    }
}
