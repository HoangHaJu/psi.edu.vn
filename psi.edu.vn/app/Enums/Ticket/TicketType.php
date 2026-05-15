<?php

namespace App\Enums\Ticket;

use App\Admin\Support\Enum;

enum TicketType: string
{
    use Enum;

    case Normal = 'normal';
    case Special = 'special';


    /**
     * Lấy tất cả các giá trị (values) của enum dưới dạng mảng.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
