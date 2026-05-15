<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderReview: int
{
    use Enum;

    case NotReviewed = 1;
    case Reviewed = 2;
}
