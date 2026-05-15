<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            <span><i class="ti ti-playstation-circle me-2"></i>{{ __('Đăng') }}</span>
        </div>
        <div class="card-body d-flex justify-content-between p-2">
            <x-button.submit :title="__('Cập nhật')" />
            <x-button.modal-delete data-route="{{ route('admin.student.delete', $admin->id) }}" :title="__('Xóa')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-user-check me-2"></i>{{ __('Kích hoạt tài khoản') }}</span>
        </div>
        <div class="card-body p-2">
            <input type="hidden" name="is_active" value="0">
            <x-input-switch name="is_active" value="1" :label="__('Kích hoạt tài khoản?')" :checked="$admin->is_active == 1" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-photo"></i>
            <span class="ms-2">@lang('avatar')</span>
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="avatar" showImage="avatar" class="img-fluid" :value="$admin->avatar" />
        </div>
    </div>
</div>
