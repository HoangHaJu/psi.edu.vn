<?php

namespace App\Admin\Repositories\Ticket;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Ticket;

class TicketRepository extends EloquentRepository implements TicketRepositoryInterface
{

    public function getModel(): string
    {
        return Ticket::class;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function getTicketsWithPaginate()
    {
        return $this->model->where('quantity', '!=', 0)->paginate(8);
    }
    public function getTypeTicket()
    {
        return $this->model->pluck('type')->unique();
    }
}
