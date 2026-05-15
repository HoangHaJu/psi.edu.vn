<div class="col-12 col-md-9">
				<div class="card">
								<div class="row card-body">
												<!-- type -->
												<div class="col-12">
																<div class="mb-3">
																				<label class="mb-1" for=""><i class="ti ti-tag"></i> {{ __('Loại thông báo') }} <span
																												class="text-danger">*</span></label>
																				<x-select class="notification-type" name="type" :required="true">
																								@foreach ($types as $key => $value)
																												<x-select-option :value="$key" :title="$value" />
																								@endforeach
																				</x-select>
																</div>
												</div>
												<div class="col-12">
																<div class="mb-3">
																				<label class="mb-1" for=""><i class="ti ti-tag"></i> {{ __('Loại người nhận') }} <span
																												class="text-danger">*</span></label>
																				<x-select class="notification-option" name="option" :required="true">
																								@foreach ($options as $key => $value)
																												<x-select-option :value="$key" :title="$value" />
																								@endforeach
																				</x-select>
																</div>
												</div>
												<!-- customer -->
												<div style="display: none" id="notification-customer-select" class="col-12">
																<div class="mb-3">
																				<label class="mb-1" for=""><i class="ti ti-user"></i> {{ __('Người nhận') }} <span
																												class="text-danger">*</span></label>
																				<x-select name="admin_id[]" class="select2-bs5-ajax" :data-url="route('admin.search.select.admin')" id="admin_id" multiple>
																				</x-select>
																</div>
												</div>
												<!-- title -->
												<div class="col-12">
																<div class="mb-3">
																				<label for=""><i class="ti ti-pencil"></i> {{ __('Tiêu đề') }} <span
																												class="text-danger">*</span></label>
																				<x-input name="title" :value="old('title')" :placeholder="__('Tiêu đề')" />
																</div>
												</div>
												<!-- message -->
												<div class="col-12">
																<div class="mb-3">
																				<label for=""><i class="ti ti-message"></i> {{ __('Lời nhắn') }} <span
																												class="text-danger">*</span></label>
																				<x-input name="message" :value="old('message')" :placeholder="__('Lời nhắn')" />
																</div>
												</div>

								</div>
				</div>
</div>
