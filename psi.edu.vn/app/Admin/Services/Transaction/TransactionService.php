<?php

namespace App\Admin\Services\Transaction;

use App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Transaction\TransactionStatus;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    use AuthService, UseLog, Setup;

    protected $data;

    protected $repository;
    protected $ticketRepository;
    protected $adminRepository;
    protected $fileService;
    protected $notificationRepository;
    protected $ticketStudentRepository;

    public function __construct(
        TransactionRepositoryInterface $repository,
        AdminRepositoryInterface $adminRepository,
        TicketRepositoryInterface $ticketRepository,
        TicketStudentRepositoryInterface $ticketStudentRepository,
        NotificationRepositoryInterface $notificationRepository,
        FileService $fileService
    ) {
        $this->repository = $repository;
        $this->ticketRepository = $ticketRepository;
        $this->adminRepository = $adminRepository;
        $this->fileService = $fileService;
        $this->ticketStudentRepository = $ticketStudentRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function uploadPaymentImage(Request $request)
    {
        $this->data = $request->validated();
        // $transaction = $this->repository->findOrFail($this->data['id']);
        // if ($transaction->payment_image != null) {
        //     return false; // Không thể cập nhật nữa vì đã tải ảnh lên
        // }
        $file = $request->file('payment_image');
        if (isset($file)) {
            $this->data['payment_image'] = $this->fileService->uploadAvatar('images', $file, null);
        }
        return $this->repository->update($this->data['id'], $this->data);
    }

    public function update(Request $request): object|bool
    {
        try {
            $this->data = $request->validated();
            $transaction = $this->repository->findOrFail($this->data['id']);
            if ($this->data['status'] == TransactionStatus::Success->value) {
                $transaction->update(['status' => TransactionStatus::Success]);
                $ticket_students = $this->ticketStudentRepository->getId($transaction->user_id);
                $ticket = $this->ticketRepository->find($transaction->ticket_id);
                $expired_date = Carbon::now()->addDays($ticket->during + 1);

                // Lưu dữ liệu vào bảng ticket_students
                $data = [];
                for ($i = 0; $i < $ticket->quantity; $i++) {
                    $data[] = [
                        'admin_id' => $ticket_students->admin_id,
                        'expired_date' => $expired_date,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Chèn dữ liệu vào bảng ticket_students
                DB::table('ticket_students')->insert($data);
            }

            // Cập nhật transaction
            return $this->repository->update($this->data['id'], $this->data);
        } catch (Exception $e) {
            $this->logError('Failed to update transaction', $e); // Đảm bảo log lỗi
            return false; // Trả về false nếu có lỗi
        }
    }


    public function store(Request $request)
    {
        try {
            $this->data = $request->validated();

            $ticket = $this->ticketRepository->find($this->data['ticket_id']);

            $activePackages = $this->ticketStudentRepository->getActiveTickets($this->data['user_id'] ?? auth()->id());
            foreach ($activePackages as $package) {
                $packageTicket = $this->ticketRepository->find($package->ticket_id);
                if (
                    $package->expired_date >= now() &&
                    $packageTicket->status === 'active'
                ) {
                    throw new \Exception('Không thể mua gói khác loại khi gói hiện tại vẫn còn hạn hoặc còn vé.');
                }
            }

            $this->data['status'] = TransactionStatus::Pending->value;
            $this->data['total'] = $ticket->price;

            return $this->repository->create($this->data);
        } catch (\Exception $e) {
            throw $e;
        }
    }



    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function confirm($id)
    {
        DB::beginTransaction();
        try {
            $transaction = $this->repository->findOrFail($id);
            $transaction->update(['status' => TransactionStatus::Success]);

            $ticket = $this->ticketRepository->find($transaction->ticket_id);

            // 👉 Mỗi lần mua = 1 record, không cần kiểm tra loại gói cũ
            $this->ticketStudentRepository->create([
                'admin_id' => $transaction->user_id,
                'ticket_id' => $ticket->id,
                'remaining_tickets' => $ticket->quantity,
                'expired_date' => now()->addDays($ticket->during),
                'status' => 'active',
            ]);

            // 👉 Cập nhật current_type_ticket của user
            $user = $this->adminRepository->find($transaction->user_id);
            $user->update([
                'current_type_ticket' => $ticket->type
            ]);

            $this->createNotification(
                'Thông báo mua vé',
                'Đơn mua vé của bạn đã được duyệt',
                $transaction->user_id
            );

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $idStudent = $this->repository->getAllByStudentId($id);
            $this->repository->update($id, ['status' => TransactionStatus::Failed]);
            $this->createNotification(
                'Thông báo mua vé',
                'Thông báo mua vé - Đơn mua vé của bạn đã bị hủy',
                $idStudent
            );
            DB::commit();
            return true;
        } catch (Exception $e) {
            $this->logError('Failed to cancel transaction: ', $e);
            DB::rollBack();
            return false;
        }
    }


    private function createNotification($title, $message, $admin_id)
    {
        $notificationData = [
            'title' => $title,
            'message' => $message,
            'status' => NotificationStatus::NOT_READ->value,
            'admin_id' => $admin_id,
        ];
        $this->notificationRepository->create($notificationData);
    }
}
