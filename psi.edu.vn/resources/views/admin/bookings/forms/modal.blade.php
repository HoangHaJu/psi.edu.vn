<!-- Modal -->
<div id="resultQuickViewRequest">
    @if (isset($teacherModal))
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body justify-content-center">
                        <x-form type="post" class="mb-3">
                            <h3 class="bold-text text-center">Điền thông tin của bạn</h3>
                            <div class="p-2">
                                <label class="control-label text-left"><i class="ti ti-user-edit"></i>
                                    {{ __('Họ và tên') }}:
                                    <span class="text-danger">*</span></label>
                                <x-input name="fullname" :value="old('fullname')" :required="true"
                                    placeholder="{{ __('Họ và tên') }}" />
                            </div>
                            <div class="p-2">
                                <label class="control-label"><i class="ti ti-mail"></i> {{ __('Email') }}: <span
                                        class="text-danger">*</span></label>
                                <x-input-email name="email" :value="old('email')" :required="true" />
                            </div>
                            <div class="p-2">
                                <label class="control-label"><i class="ti ti-phone"></i> {{ __('Số điện thoại') }}:
                                    <span class="text-danger">*</span></label>
                                <x-input-phone name="phone" :value="old('phone')" :required="true" />
                            </div>
                            <div class="text-center"><button type="submit" class="btn btn-pink text-center">Gửi
                                    đi</button>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
