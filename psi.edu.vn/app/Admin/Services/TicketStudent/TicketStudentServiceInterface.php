<?php

namespace App\Admin\Services\TicketStudent;

use Illuminate\Http\Request;

interface TicketStudentServiceInterface
{
    public function getTicketTypesForStudent(int $studentId);
    public function index();
    public function getTickets($adminId, $ticketType);
}
