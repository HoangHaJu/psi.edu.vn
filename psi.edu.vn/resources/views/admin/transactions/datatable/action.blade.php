@if (auth('admin')->user()->isSuperAdmin)
    <div class="d-flex align-items-center justify-content-center">
        @if ($status == App\Enums\Transaction\TransactionStatus::Pending->value)
            <a id="confirm-transaction" href="{{ route('admin.transaction.confirm', $id) }}" class="ml-2">
                <i class="btn btn-success btn-icon ti ti-alert-circle"></i>
            </a>
            <a id="cancel-transaction" href="{{ route('admin.transaction.cancel', $id) }}" class="ms-2">
                <i class="btn btn-warning btn-icon ti ti-circle-x"></i>
            </a>
        @endif
        <a href="{{ route('admin.transaction.edit', $id) }}" class="ms-2">
            <i class="btn btn-info btn-icon ti ti-pencil"></i>
        </a>
        <x-button.modal-delete class="btn-icon ms-2" data-route="{{ route('admin.transaction.delete', $id) }}">
            <i class="ti ti-trash"></i>
        </x-button.modal-delete>
    </div>
@else
    <div class="d-flex align-items-center justify-content-center">
        @if ($status == App\Enums\Transaction\TransactionStatus::Pending->value)
            <a id="cancel-transaction" href="{{ route('admin.transaction.cancel', $id) }}">
                <i class="btn btn-warning btn-icon ti ti-circle-x"></i>
            </a>
            @if (!isset($payment_image))
                <a class="ms-2" href="{{ route('admin.transaction.payment', $id) }}">
                    <i class="btn btn-success btn-icon ti ti-credit-card"></i>
                </a>
            @endif
        @endif
    </div>
@endif
