<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Học viên -->
            <div class="col-12">
                <div class="mb-3">
                    <label for="user_id"><i class="ti ti-pencil"></i> {{ __('Học viên') }} <span
                            class="text-danger">*</span></label>
                    <x-select name="user_id" id="user_id" class="select2-bs5-ajax"
                        data-url="{{ route('admin.search.select.admin') }}" :required="true">
                    </x-select>
                </div>
            </div>

            <!-- Gói vé -->
            <div class="col-12">
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <label class="me-3"><i class="ti ti-message"></i> {{ __('Gói vé') }} <span
                                class="text-danger">*</span></label>
                        <!-- Legend giải thích icon -->
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-user-check text-primary me-1"></i>
                                <small>Gói thường</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-star text-warning me-1"></i>
                                <small>Gói đặc biệt</small>
                            </div>
                        </div>
                    </div>

                    <!-- Radio gói vé -->
                    @foreach ($packageTickets as $item)
                        @php
                            if ($item->type === 'normal') {
                                $icon = 'ti ti-user-check';
                                $color = 'text-primary';
                                $tooltip = 'Gói thường';
                            } elseif ($item->type === 'special') {
                                $icon = 'ti ti-star';
                                $color = 'text-warning';
                                $tooltip = 'Gói đặc biệt';
                            } else {
                                $icon = 'ti ti-ticket';
                                $color = 'text-secondary';
                                $tooltip = 'Gói khác';
                            }
                        @endphp

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="id" value="{{ $item->id }}"
                                id="ticket_{{ $item->id }}">
                            <label class="form-check-label d-flex align-items-center" for="ticket_{{ $item->id }}">
                                <i class="{{ $icon }} me-1 {{ $color }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="{{ $tooltip }}"></i>
                                {{ $item->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@push('custom-js')
    <script>
        $(document).ready(function() {
            // Khởi tạo tooltip Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Load dữ liệu select2 cho học viên
            select2LoadData($('#user_id').data('url'), '#user_id');
        });
    </script>
@endpush
