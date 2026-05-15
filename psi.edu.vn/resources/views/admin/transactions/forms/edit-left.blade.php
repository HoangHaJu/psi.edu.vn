<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin đăng ký') }}</h2>
        </div>
        <div class="card-body row">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-book-2"></i> {{ __('Tên gói vé') }}: <x-link
                        :href="route('admin.ticket.edit', $transaction->ticket->id)" :title="$transaction->ticket->name" />
                </label><br>
                <label class="control-label"><i class="ti ti-user"></i> {{ __('Tên học viên') }}: <x-link
                        :href="route('admin.student.edit', $transaction->user->id)" :title="$transaction->user->fullname" />
                </label><br>
                <label class="control-label"><i class="ti ti-currency-dollar"></i> {{ __('Tổng tiền') }}:
                    {{ format_price($transaction->total) }}
                </label><br>
                <label class="control-label"><i class="ti ti-image"></i> {{ __('Ảnh chuyển khoản') }}:</label></br>
                @if (!empty($transaction->payment_image))
                    <img src="{{ url($transaction->payment_image) }}" alt="payment_image" class="img-fluid"
                        style="max-width: 500px; max-height: 500px; object-fit: cover;">
                @else
                    <p class="text-muted">{{ __('Chưa có ảnh nào được tải lên.') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
