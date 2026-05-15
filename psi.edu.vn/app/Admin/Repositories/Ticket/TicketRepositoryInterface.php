<?php

namespace App\Admin\Repositories\Ticket;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface TicketRepositoryInterface extends EloquentRepositoryInterface
{
    // public function getByAdminIdAndPaginate($adminId);
    public function getTicketsWithPaginate();
    public function create(array $data);
    public function getTypeTicket();
}
