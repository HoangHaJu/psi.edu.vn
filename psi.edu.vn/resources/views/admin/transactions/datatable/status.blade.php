@php
    $badgeClass = App\Enums\Transaction\TransactionStatus::from($status)->badge();
    $description = App\Enums\Transaction\TransactionStatus::getDescription($status);
@endphp

<span class="badge {{ $badgeClass }}">
    {{ $description }}
</span>
