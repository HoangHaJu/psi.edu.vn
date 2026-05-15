<?php

namespace App\Admin\Repositories\TicketStudent;

use App\Admin\Repositories\EloquentRepository;
use App\Models\TicketStudent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; // Ensure Log is imported if used elsewhere or for debugging
use Illuminate\Support\Facades\DB;

class TicketStudentRepository extends EloquentRepository implements TicketStudentRepositoryInterface
{
    public function getModel()
    {
        return TicketStudent::class;
    }

    public function getId($id)
    {
        // Phương thức này có vẻ đang tìm kiếm một vé dựa trên admin_id thay vì ID của vé.
        // Tên phương thức có thể gây hiểu nhầm nếu nó dùng để lấy vé theo ID chính.
        // Nếu mục đích là lấy vé của một admin cụ thể, tên phương thức nên rõ ràng hơn, ví dụ: getTicketsByAdminId
        return $this->model->where('admin_id', $id)->first();
    }

    /**
     * Retrieves tickets from the database, filtered by adminId if provided.
     * Calculates KPIs on the filtered dataset.
     *
     * @param int|null $adminId The ID of the admin/user to filter by, or null for all.
     * @return array
     */
    public function checkExistsByAdminId($adminId): bool
    {
        return $this->model->where('admin_id', $adminId)->exists();
    }

    public function getTickets($adminId = null, $ticketType = null)
    {
        $ticket_type = 'Tất cả các loại vé';
        $remaining_quantity = 0;
        $soonest_expiring_date = 'Không xác định';
        $expiryDetails = [];

        // Query tổng quan
        $query = $this->model->newQuery()
            ->join('tickets', 'ticket_students.ticket_id', '=', 'tickets.id')
            ->where('ticket_students.remaining_tickets', '>', 0);

        if ($adminId) {
            $query->where('ticket_students.admin_id', $adminId);
        }

        if ($ticketType) {
            $query->where('tickets.type', $ticketType);
            $ticket_type = ucfirst($ticketType); // hiển thị Normal / Special
        } else {
            // lấy bất kỳ vé gần nhất để hiển thị tên loại
            $latestTicket = $query->orderBy('ticket_students.updated_at', 'desc')->first();
            if ($latestTicket && isset($latestTicket->type)) {
                $ticket_type = ucfirst($latestTicket->type);
            }
        }

        $totalRemaining = $query->sum('ticket_students.remaining_tickets');
        $remaining_quantity = (int) $totalRemaining;

        $detailQuery = $this->model->newQuery()
            ->select(
                'expired_date',
                DB::raw('SUM(remaining_tickets) as total_tickets')
            )
            ->where('remaining_tickets', '>', 0)
            ->groupBy('expired_date')
            ->orderBy('expired_date', 'asc');

        if ($adminId) {
            $detailQuery->where('admin_id', $adminId);
        }

        if ($ticketType) {
            $detailQuery->whereExists(function ($query) use ($ticketType) {
                $query->select(DB::raw(1))
                    ->from('tickets')
                    ->whereRaw('tickets.id = ticket_students.ticket_id')
                    ->where('tickets.type', $ticketType);
            });
        }

        $expiryDetails = $detailQuery->get();

        if ($expiryDetails->isNotEmpty()) {
            $soonest_expiring_date = Carbon::parse($expiryDetails->first()->expired_date)->format('d/m/Y');
        }

        $formattedDetails = $expiryDetails->map(function ($item) {
            return [
                'formatted_date' => Carbon::parse($item->expired_date)->format('d/m/Y'),
                'total_tickets'  => (int) $item->total_tickets
            ];
        });

        $returnArray = [
            'ticket_type' => $ticket_type,
            'remaining_quantity' => $remaining_quantity,
            'soonest_expiring_date' => $soonest_expiring_date,
            'expiryDetails' => $formattedDetails
        ];
        return $returnArray;
    }


    public function findValidTicketForRefund(int $ticketId, int $adminId, string $ticketDate)
    {
        return $this->model
            ->newQuery()
            ->where('ticket_id', $ticketId)
            ->where('admin_id', $adminId)
            ->where('expired_date', $ticketDate)
            ->lockForUpdate()
            ->first();
    }

    public function findByUserAndTicket($userId, $ticketId)
    {
        return TicketStudent::where('admin_id', $userId)
            ->where('ticket_id', $ticketId)
            ->first();
    }

    public function getActiveTickets($adminId)
    {
        return $this->model
            ->where('admin_id', $adminId)
            ->where('expired_date', '>=', now())
            ->get();
    }

    public function checkTypeTicket($admin_id)
    {
        return $this->model->where('admin_id', $admin_id)
            ->where('expired_date', '<', now())
            ->whereHas('ticket', function ($query) {
                $query->where('type', 'special');
            })
            ->get();
    }

    public function getUserTicketTypes(int $userId): array
    {
        return $this->model->where('admin_id', $userId)
            ->where('expired_date', '>=', now())
            ->with('ticket:id,type')
            ->get()
            ->pluck('ticket.type')
            ->unique()
            ->values()
            ->toArray();
    }
}
