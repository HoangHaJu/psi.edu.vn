<?php

namespace App\Admin\Http\Requests\Transaction;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Transaction\TransactionStatus;
use App\Models\Admin;
use App\Models\TicketStudent;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRequest extends BaseRequest
{
    protected function methodGet(): array
    {
        return [
            'user_id' => ['nullable', 'exists:admins,id'],
            'ticket_id' => ['nullable', 'exists:tickets,id'],
            'payment_image' => ['nullable'],
            'status' => ['nullable'],
        ];
    }
    protected function methodPost(): array
    {
        return [
            'user_id' => ['required', 'exists:App\Models\Admin,id'],
            'ticket_id' => ['required', 'exists:App\Models\Ticket,id'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Transaction,id'],
            'status' => ['required'],
            'payment_image' => ['nullable']
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (request()->isMethod('post')) {
                $userId = auth()->id();

                // Kiểm tra tồn tại Transaction đang chờ duyệt
                $isPendingTransactionExist = Transaction::where('status', '=', TransactionStatus::Pending)
                    ->where('user_id', '=', $userId)
                    ->exists();

                // Nếu tồn tại, thêm lỗi vào validator
                if ($isPendingTransactionExist) {
                    $validator->errors()->add('ticket_id', 'Hiện bạn đang có đơn mua vé chưa dc xử lý.');
                }
            }
        });
    }
}
