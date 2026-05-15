<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-playstation-circle me-2"></i>{{ __('Đăng') }}</span>
        </div>
        <div class="card-body d-flex justify-content-between p-2">
            <x-button.submit :title="__('Cập nhật')" />
        </div>
    </div>
    @if (!auth('admin')->user()->isStudent)
        <div class="card mb-3">
            <div class="card-header">
                <i class="ti ti-toggle-right"></i>
                <span class="ms-2">{{ __('Trạng thái') }}</span>
            </div>
            <div class="card-body p-2">
                <x-select class="form-select" name="status" :required="true">
                    @foreach ($status as $key => $value)
                        <x-select-option :option="$instance->status" :value="$key" :title="$value" />
                    @endforeach
                </x-select>
            </div>
        </div>
    @endif
    @if (auth('admin')->user()->isSuperAdmin)
        <div class="card mb-3">
            <div class="card-header">
                <i class="ti ti-toggle-right"></i>
                <span class="ms-2">{{ __('Loại ngày nghỉ') }}</span>
            </div>
            <div class="card-body p-2">
                <x-select class="form-select" name="day_off_type" :required="true">
                    @foreach ($dayOffType as $key => $value)
                        <x-select-option :option="$instance->day_off_type" :value="$key" :title="$value" />
                    @endforeach
                </x-select>
            </div>
        </div>
    @endif
</div>
