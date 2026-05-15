<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin giáo viên') }}</h2>
        </div>
        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Họ và tên') }}:
                </label>
                <x-input name="fullname" :value="$admin->fullname" :required="true" placeholder="{{ __('Họ và tên') }}" />
            </div>
            <div class="col-md-3 mb-3">
                <label class="control-label"><i class="ti ti-calendar"></i> {{ __('Ngày sinh') }}:
                </label>
                <x-input type="date" name="birthday" :value="format_date($admin->birthday ? $admin->birthday : '')" :required="true" />
            </div>
            <div class="col-md-3 mb-3">
                <label class="control-label"><i class="ti ti-phone"></i> {{ __('Số điện thoại') }}:
                </label>
                <x-input-phone name="phone" :value="$admin->phone" :required="true" />
            </div>
            <div class="col-md-4 mb-3">
                <label class="control-label"><i class="ti ti-gender-agender"></i> {{ __('Giới tính') }}:
                </label>
                <x-select name="gender">
                    <x-select-option value="" :title="__('Chọn Giới tính')" />
                    @foreach ($gender as $key => $value)
                        <x-select-option :option="$admin->gender" :value="$key" :title="__($value)" />
                    @endforeach
                </x-select>
            </div>
            <div class="col-md-8 mb-3">
                <label class="control-label"><i class="ti ti-location"></i>
                    {{ __('Địa chỉ') }}:
                </label>
                <x-input name="address" :value="$admin->address" placeholder="{{ __('Địa chỉ') }}" />
            </div>
            <div class="col-md-12 mb-3">
                <label class="control-label"><i class="ti ti-mail"></i> {{ __('Email') }}:
                </label>
                <x-input-email name="email" :value="$admin->email" :required="true" />
            </div>
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-note"></i> {{ __('Ghi chú') }}:
                </label>
                <x-input name="note" :value="$admin->note" />
            </div>
            {{-- <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-volume"></i> {{ __('Giọng nói') }}:
                </label>
                <x-input type="file" class="form-control" name="audio" accept="audio/mp3,audio/wav" />
                <audio class="w-100 my-2" controls>
                    <source src="{{ asset($admin->audio) }}" type="audio/mp3">
                    <source src="{{ asset($admin->audio) }}" type="audio/wav">
                    Trình duyệt của bạn không hỗ trợ phát audio này
                </audio>
            </div> --}}
        </div>
    </div>
</div>
