<?php

namespace App\Enums\Lesson;

use App\Supports\Enum;

enum LessonStatus: int
{
    use Enum;

    case NotPresent = 1;
    case Present = 2;
    case Cancelled = 3;

    public function badge(): string
    {
        return match ($this) {
            self::NotPresent => 'bg-orange',
            self::Present => 'bg-green',
            self::Cancelled => 'bg-red',
        };
    }
}
