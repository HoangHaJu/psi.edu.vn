<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin học viên') }}</h2>
        </div>
        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Họ và tên') }}:</label>
                <x-input name="fullname" :value="$admin->fullname" :required="true" placeholder="{{ __('Họ và tên') }}" />
            </div>
            <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-calendar"></i> {{ __('Ngày sinh') }}:</label>
                <x-input type="date" name="birthday" :value="format_date($admin->birthday ?? '')" :required="true" />
            </div>
            <div class="col-md-3 mb-3">
                <label class="control-label"><i class="ti ti-phone"></i> {{ __('Số điện thoại') }}:</label>
                <x-input-phone name="phone" :value="$admin->phone" :required="true" />
            </div>
            <div class="col-md-3 mb-3">
                <label class="control-label"><i class="ti ti-gender-agender"></i> {{ __('Giới tính') }}:</label>
                <x-select name="gender" :required="true">
                    <x-select-option value="" :title="__('Chọn Giới tính')" />
                    @foreach ($gender as $key => $value)
                        <x-select-option :option="$admin->gender" :value="$key" :title="__($value)" />
                    @endforeach
                </x-select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-location"></i> {{ __('Địa chỉ') }}:</label>
                <x-input name="address" :value="$admin->address" placeholder="{{ __('Địa chỉ') }}" />
            </div>
            <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-mail"></i> {{ __('Email') }}:</label>
                <x-input-email name="email" :value="$admin->email" :required="true" />
            </div>
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-note"></i> {{ __('Ghi chú') }}:</label>
                <x-input name="note" :value="$admin->note" />
            </div>
        </div>

        <div class="card-body row g-2">
            <div class="col-12">
                <label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Thông tin vé chi tiết') }}:
                </label>
                @if (!empty($ticketDetails))
                    <ul>
                        @foreach ($ticketDetails as $detail)
                            <li>
                                <strong>{{ $detail['name'] }}</strong>:
                                {{ __('Số vé còn lại') }}: {{ $detail['remaining_tickets'] }},
                                {{ __('Hạn sử dụng sớm nhất') }}: {{ format_date($detail['expired_min']) }},
                                {{ __('Hạn sử dụng muộn nhất') }}: {{ format_date($detail['expired_max']) }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>{{ __('Chưa có vé') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
