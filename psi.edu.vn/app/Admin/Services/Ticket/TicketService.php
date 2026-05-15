<?php

namespace App\Admin\Services\Ticket;

use App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Traits\NotifiesViaFirebase;
use Illuminate\Support\Facades\DB;
use App\Admin\Traits\AuthService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use App\Models\Ticket;
use App\Models\TicketStudent;

class TicketService implements TicketServiceInterface
{
    use AuthService, NotifiesViaFirebase;

    protected $data;
    protected $ticketStudentRepository;
    protected $repository;
    protected $adminRepository;
    // private AdminRepositoryInterface $adminRepository;

    public function __construct(
        TicketRepositoryInterface $repository,
        TicketStudentRepositoryInterface $ticketStudentRepository,
        AdminRepositoryInterface $adminRepository,
    ) {
        $this->repository = $repository;
        $this->ticketStudentRepository = $ticketStudentRepository;
        $this->adminRepository = $adminRepository;
    }

    public function store(Request $request)
    {
        $this->data = $request->validated();
        try {
            DB::beginTransaction();
            DB::commit();

            return $this->repository->create($this->data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }
    public function extendStore(Request $request): array|bool
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:admins,id',
            'id' => 'required|exists:tickets,id',
        ], [
            'user_id.required' => 'ID người dùng là bắt buộc.',
            'user_id.exists' => 'Người dùng không tồn tại.',
            'id.required' => 'ID gói vé là bắt buộc.',
            'id.exists' => 'Gói vé không tồn tại.',
        ]);

        $adminId = $validatedData['user_id'];
        $ticketId = $validatedData['id'];

        DB::beginTransaction();

        try {
            $ticketInfo = Ticket::findOrFail($ticketId);

            $existingTicketStudent = TicketStudent::where('admin_id', $adminId)
                ->latest('expired_date')
                ->first();

            // Xác định mốc bắt đầu tính hạn
            $baseDate = now();
            if ($existingTicketStudent && $existingTicketStudent->expired_date->isFuture()) {
                $baseDate = $existingTicketStudent->expired_date;
            }

            $expiredDate = $baseDate->copy()->addDays($ticketInfo->during);

            // Tạo record mới
            $newTicketStudent = $this->ticketStudentRepository->create([
                'admin_id'          => $adminId,
                'ticket_id'         => $ticketInfo->id,
                'expired_date'      => $expiredDate,
                'remaining_tickets' => $ticketInfo->quantity,
                'status'            => 'active',
            ]);

            // 👉 Cập nhật current_type_ticket cho user
            $user = $this->adminRepository->find($adminId);
            $user->update([
                'current_type_ticket' => $ticketInfo->type,
            ]);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }
}
