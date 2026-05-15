<?php

namespace App\Enums\Notification;

use App\Supports\Enum;

enum NotificationOption: int
{
    use Enum;
    case Teacher = 1;
    case Student = 2;
}
