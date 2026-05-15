<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TicketStudent;
use Carbon\Carbon;

class UpdateTicketStatus extends Command
{
    protected $signature = 'ticket:update-status';
    protected $description = 'Cập nhật trạng thái vé theo ngày hết hạn và remaining_tickets';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        // Cập nhật vé hết hạn
        TicketStudent::where('expired_date', '<', $today)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        // Cập nhật vé hết lượt
        TicketStudent::where('remaining_tickets', '<=', 0)
            ->where('status', 'active')
            ->update(['status' => 'used_up']);

        $this->info('Cập nhật trạng thái vé thành công!');
    }
}
