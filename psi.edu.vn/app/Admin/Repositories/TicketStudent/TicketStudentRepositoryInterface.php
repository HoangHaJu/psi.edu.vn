<?php

namespace App\Admin\Repositories\TicketStudent;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface TicketStudentRepositoryInterface extends EloquentRepositoryInterface
{
    public function getId($id);
    public function getTickets($adminId = null, $ticketType = null);

    public function getUserTicketTypes(int $userId): array;
    public function checkExistsByAdminId($adminId): bool;
    public function findByUserAndTicket($userId, $ticketId);
    public function getActiveTickets($adminId);
    public function checkTypeTicket($admin_id);
    public function findValidTicketForRefund(int $ticketId, int $adminId, string $ticketDate);
}
