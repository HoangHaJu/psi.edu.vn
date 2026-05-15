<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-playstation-circle me-2"></i>{{ __('Đăng') }}</span>
        </div>
        <div class="card-body d-flex justify-content-between p-2">
            <x-button.submit :title="__('Cập nhật')" />
            <x-button.modal-delete data-route="{{ route('admin.schedule_off.delete', $schedule_off->id) }}"
                :title="__('Xóa')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-user-check me-2"></i>{{ __('Duyệt đơn xin nghỉ') }}</span>
        </div>
        <div class="card-body p-2">
            <input type="hidden" name="is_active" value="0">
            @if ($schedule_off->is_active == 1)
                <x-input-switch name="is_active" value="1" :label="__('Duyệt đơn xin nghỉ?')" :disabled="$schedule_off->is_active == 1" />
            @else
                <x-input-switch name="is_active" value="1" :label="__('Duyệt đơn xin nghỉ?')" :checked="$schedule_off->is_active == 1" />
            @endif
        </div>
    </div>
</div>
