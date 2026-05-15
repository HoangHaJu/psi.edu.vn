@php
    $badgeClass = App\Enums\Booking\BookingStatus::from($status)->badge();
    $description = App\Enums\Booking\BookingStatus::getDescription($status);
@endphp

<span class="badge {{ $badgeClass }}">
    {{ $description }}
</span>
