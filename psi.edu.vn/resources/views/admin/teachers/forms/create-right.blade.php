<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            <span><i class="ti ti-playstation-circle me-2"></i>{{ __('Đăng') }}</span>
        </div>
        <div class="card-body p-2">
            <x-button.submit :title="__('Thêm')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-user-check me-2"></i>{{ __('Kích hoạt tài khoản') }}</span>
        </div>
        <div class="card-body p-2">
            <input type="hidden" name="is_active" value="0">
            <x-input-switch name="is_active" value="1" :label="__('Kích hoạt tài khoản?')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <span><i class="ti ti-user-check me-2"></i>{{ __('Hiển thị phía người dùng') }}</span>
        </div>
        <div class="card-body p-2">
            <input type="hidden" name="display" value="0">
            <x-input-switch name="display" value="1" :label="__('Hiển thị phía người dùng?')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="ti ti-photo"></i>
            <span class="ms-2">@lang('avatar')</span>
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="avatar" showImage="avatar" class="img-fluid" />
        </div>
    </div>
</div>
