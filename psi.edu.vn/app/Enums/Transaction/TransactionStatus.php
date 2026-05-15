<?php

namespace App\Enums\Transaction;


use App\Admin\Support\Enum;

enum TransactionStatus: int
{
    use Enum;

    case Pending = 1;

    case Success = 2;

    case Failed = 3;

    // case Cancelled = 4;

    public function badge(): string
    {
        return match($this) {
            self::Pending => 'text-bg-warning',
            self::Success => 'text-bg-success',
            self::Failed => 'text-bg-danger',
            // self::Cancelled => 'text-bg-secondary',
        };
    }
}
