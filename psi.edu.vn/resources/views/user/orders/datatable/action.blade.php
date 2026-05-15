@if ($status == App\Enums\Order\OrderStatus::Pending->value)
    <a id="cancel-order" href="{{ route('user.order.cancel', $id) }}" class="ml-2">
        <x-button type="button" class="btn-icon btn-danger">
            <i class="ti ti-trash"></i>
        </x-button>
    </a>
@endif
