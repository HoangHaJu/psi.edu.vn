@if (auth('admin')->user()->isSuperAdmin)
    <div class="d-flex align-items-center justify-content-center">
        @if ($status == App\Enums\Booking\BookingStatus::Pending->value)
            <a id="confirm-booking" href="{{ route('admin.booking.confirm', $id) }}" class="ml-2">
                <i class="btn btn-success btn-icon ti ti-alert-circle"></i>
            </a>
            <a id="cancel-booking" href="{{ route('admin.booking.cancel', $id) }}" class="ms-2">
                <i class="btn btn-warning btn-icon ti ti-circle-x"></i>
            </a>
        @endif
        <a href="{{ route('admin.booking.edit', $id) }}" class="ms-2">
            <i class="btn btn-info btn-icon ti ti-pencil"></i>
        </a>
        <x-button.modal-delete class="btn-icon ms-2" data-route="{{ route('admin.booking.delete', $id) }}">
            <i class="ti ti-trash"></i>
        </x-button.modal-delete>
    </div>
@else
    <div class="d-flex align-items-center justify-content-center">
        @if ($status == App\Enums\Booking\BookingStatus::Pending->value)
            <a id="cancel-booking" href="{{ route('admin.booking.cancel', $id) }}">
                <i class="btn btn-warning btn-icon ti ti-circle-x"></i>
            </a>
            <a class="ms-2" href="{{ route('admin.booking.payment', $id) }}">
                <i class="btn btn-success btn-icon ti ti-credit-card"></i>
            </a>
        @else
            @if (!$is_reviewed && $status == App\Enums\Booking\BookingStatus::Confirmed->value)
                <button type="button" data-id="{{ $id }}" data-bs-toggle="modal"
                    data-bs-target="#reviewCourse" type="button" class="btn btn-default text-center">
                    Đánh giá
                </button>
            @endif
        @endif
    </div>
@endif
