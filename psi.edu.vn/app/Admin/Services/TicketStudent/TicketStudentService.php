<?php

namespace App\Admin\Services\TicketStudent;

use App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Traits\NotifiesViaFirebase;
use App\Enums\Ticket\TicketType;
use App\Models\TicketStudent;

class TicketStudentService implements TicketStudentServiceInterface
{
    use AuthService, NotifiesViaFirebase;

    protected $data;

    protected $repository;
    protected $ticketRepository;

    public function __construct(
        TicketStudentRepositoryInterface $repository,
        TicketRepositoryInterface $ticketRepository,
    ) {
        $this->repository = $repository;
        $this->ticketRepository = $ticketRepository;
    }

    public function index() {}

    public function getTickets($adminId, $ticketType): mixed
    {
        return $this->repository->getTickets($adminId, $ticketType);
    }

    public function getTicketTypesForStudent(int $studentId): array
    {
        $owned = TicketStudent::where('admin_id', $studentId)
            ->where('status', 'active')
            ->where('remaining_tickets', '>', 0)
            ->whereDate('expired_date', '>=', now())
            ->with('ticket')
            ->orderBy('expired_date')
            ->get()
            ->groupBy(fn($ts) => $ts->ticket->type)
            ->map(fn($group) => $group->first())
            ->map(fn($ts) => [
                'id' => $ts->id,
                'type' => $ts->ticket->type,
            ])
            ->values()
            ->toArray();

        $allTypes = TicketType::values();

        return [
            'all_types' => $allTypes,
            'owned' => $owned,
        ];
    }
}
