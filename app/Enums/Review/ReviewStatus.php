<?php
namespace App\Enums\Review;

use App\Supports\Enum;

enum ReviewStatus: int
{
    use Enum;

    //Đang chờ duyệt
    case Pending = 0;
    //Đã Phê duyệt
    case Approved = 1;
    //Bị từ chối
    case Rejected = 2;
    // Được đánh giấu
    case Flagged = 3;

    public function badge():string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-lt',
            self::Approved => 'bg-green-lt',
            self::Rejected => 'bg-red-lt',
            self::Flagged => 'bg-blue-lt',
        };
    }

}

