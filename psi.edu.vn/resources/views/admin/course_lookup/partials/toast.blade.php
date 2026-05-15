<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="successToast" class="toast" data-bs-delay="3000">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">{{ __('Thành công!') }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">{{ __('Đăng ký khóa học thành công!') }}</div>
    </div>

    <div id="errorToast" class="toast" data-bs-delay="5000">
        <div class="toast-header bg-danger text-white">
            <strong class="me-auto">{{ __('Lỗi!') }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">{{ __('Đã xảy ra lỗi!') }}</div>
    </div>
</div>
