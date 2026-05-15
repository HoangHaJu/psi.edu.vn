<?php

namespace App\Enums\Payment;

use App\Supports\Enum;

enum PaymentMethod: int
{
    use Enum;
        //Thanh toán online
    case Online = 1;

        //Thanh toán trực tiếp
    case Direct = 2;

        //Chuyển khoản ngân hàng
    case Banking = 3;

    public function badge(): string
    {
        return match ($this) {
            PaymentMethod::Online => 'bg-green',
            PaymentMethod::Direct => 'bg-red',
            PaymentMethod::Banking => 'bg-orange',
        };
    }
}
