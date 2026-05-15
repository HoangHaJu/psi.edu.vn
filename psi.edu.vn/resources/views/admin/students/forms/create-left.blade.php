<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Thông tin học viên') }}</h2>
								</div>
								<div class="card-body row">
												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Họ và tên') }}:
																</label>
																<x-input name="fullname" :value="old('fullname')" :required="true" placeholder="{{ __('Họ và tên') }}" />
												</div>
												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-calendar"></i> {{ __('Ngày sinh') }}:
																</label>
																<x-input type="date" name="birthday" :value="old('birthday')" :required="true" />
												</div>
												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu') }}: <span
																												class="text-danger">*</span></label>
																				<x-input-password name="password" :required="true" />
																</div>
												</div>
												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Xác nhận mật khẩu') }}: <span
																												class="text-danger">*</span></label>
																				<x-input-password name="password_confirmation" :required="true" />
																</div>
												</div>
												<div class="col-md-3 mb-3">
																<label class="control-label"><i class="ti ti-phone"></i> {{ __('Số điện thoại') }}:
																</label>
																<x-input-phone name="phone" :value="old('phone')" :required="true" />
												</div>
												<div class="col-md-3 mb-3">
																<label class="control-label"><i class="ti ti-gender-agender"></i> {{ __('Giới tính') }}:
																</label>
																<x-select name="gender" :required="true">
																				<x-select-option value="" :title="__('Chọn Giới tính')" />
																				@foreach ($gender as $key => $value)
																								<x-select-option :option="old('gender')" :value="$key" :title="__($value)" />
																				@endforeach
																</x-select>
												</div>
												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-location"></i>
																				{{ __('Địa chỉ') }}:
																</label>
																<x-input name="address" :value="old('address')" placeholder="{{ __('Địa chỉ') }}" />
												</div>
												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-mail"></i> {{ __('Email') }}:
																</label>
																<x-input-email name="email" :value="old('email')" :required="true" />
												</div>
												<div class="mb-3">
																<label class="control-label"><i class="ti ti-note"></i> {{ __('Ghi chú') }}:
																</label>
																<x-input name="note" :value="old('note')" />
												</div>
								</div>
				</div>
</div>
