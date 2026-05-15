<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Thông tin Khoá học') }}</h2>
								</div>
								<div class="card-body row">
												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-book-2"></i> {{ __('Tên khoá học') }}:
																</label>
																<x-input name="name" :value="old('name', 'Khoá học')" :required="true" placeholder="{{ __('Tên khoá học') }}" />
												</div>


												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-school"></i> {{ __('Trình độ') }}:
																</label>
																<x-select name="education_level" :required="true">
																				<x-select-option value="" :title="__('Chọn trình độ')" />
																				@foreach ($educationLevel as $key => $value)
																								<x-select-option :value="$key" :title="__($value)" />
																				@endforeach
																</x-select>
												</div>

												<div class="mb-3">
																<label class="control-label"><i class="ti ti-file-description"></i> {{ __('Mô tả') }}:</label>
																<textarea name="description" class="ckeditor visually-hidden">{{ old('description') }}</textarea>
												</div>
								</div>
				</div>
</div>

<script>
				document.addEventListener('DOMContentLoaded', function() {
								const form = document.querySelector('form'); // Đảm bảo bạn đã chỉ định form chính xác

								form.addEventListener('submit', function(event) {
												const today = new Date();
												const startDate = new Date(document.querySelector('input[name="start_date"]').value);
												const endDate = new Date(document.querySelector('input[name="end_date"]').value);
												const startTime = document.querySelector('input[name="start_time"]').value;
												const endTime = document.querySelector('input[name="end_time"]').value;
												const price = parseFloat(document.querySelector('input[name="price"]').value || 0);
												const promotionPrice = parseFloat(document.querySelector('input[name="promotion_price"]')
																.value || 0);

												// Kiểm tra ngày bắt đầu
												if (startDate <= today) {
																event.preventDefault();
																Swal.fire({
																				icon: 'error',
																				title: 'Lỗi',
																				text: 'Ngày bắt đầu phải lớn hơn ngày hiện tại.',
																});
																return;
												}

												// Kiểm tra ngày kết thúc
												if (startDate >= endDate) {
																event.preventDefault();
																Swal.fire({
																				icon: 'error',
																				title: 'Lỗi',
																				text: 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc.',
																});
																return;
												}

												// Kiểm tra thời gian
												if (startTime >= endTime) {
																event.preventDefault();
																Swal.fire({
																				icon: 'error',
																				title: 'Lỗi',
																				text: 'Giờ bắt đầu phải nhỏ hơn giờ kết thúc.',
																});
																return;
												}

												// Kiểm tra giá
												if (price <= promotionPrice) {
																event.preventDefault();
																Swal.fire({
																				icon: 'error',
																				title: 'Lỗi',
																				text: 'Giá thường phải lớn hơn giá khuyến mãi.',
																});
																return;
												}
								});
				});
</script>
