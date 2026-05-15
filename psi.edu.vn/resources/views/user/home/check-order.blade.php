@extends('user.layouts.master')
@section('title', __($title))

@php
				$settingRepository = app()->make(App\Admin\Repositories\Setting\SettingRepository::class);
				$settingsGeneral = $settingRepository->getByGroup([App\Enums\Setting\SettingGroup::General]);
				$exchangePercent = $settingsGeneral->where('setting_key', 'exchange_percent')->first()->plain_value;
@endphp

<head>
				<meta name="description" content="{{ $meta_desc }}">
</head>

@section('content')
				<div class="container mt-3 gap-64">
								<div class="row">
												<div
																class="{{ $order->payment_method == App\Enums\Payment\PaymentMethod::Direct ? 'col-12' : 'col-md-6' }} order-info">
																<h3>Thông tin đơn hàng</h3>
																<p><strong>Mã đơn hàng:</strong> {{ $order->code }}</p>
																<div class="row">
																				<div class="col-6 text-start">Tạm tính</div>
																				<div class="col-6 text-end"><strong>{{ format_price($order->total) }}</strong></div>
																				<div class="col-6 text-start">Giảm giá</div>
																				<div class="col-6 text-end">
																								<strong>{{ format_price($order->discount_value ?? 0) }}</strong>
																				</div>
																				<div class="col-6 text-start">Giảm giá bằng điểm</div>
																				<div class="col-6 text-end">
																								<strong>{{ format_price($order->points * $exchangePercent ?? 0) }}</strong>
																				</div>
																				<div class="col-6 border-bottom pb-1 text-start">Phụ thu</div>
																				<div class="col-6 border-bottom pb-1 text-end">
																								{{ format_price($order->surcharge ?? 0) }}
																				</div>
																				<div class="col-6 mt-1 text-start">Tổng</div>
																				<div class="col-6 mb-3 mt-1 text-end">
																								<strong
																												id="totalAfterDiscount">{{ format_price($order->total - $order->discount_value - $order->surcharge - $order->points * $exchangePercent) }}</strong>
																				</div>
																</div>
																<p><strong>Trạng thái đơn hàng:</strong> <span
																								@class([
																												'badge-status',
																												App\Enums\Order\OrderStatus::from($order->status->value)->badge(),
																								])>{{ \App\Enums\Order\OrderStatus::getDescription($order->status->value) }}</span>
																</p>
																<p><strong>Phương thức thanh toán:</strong> <span
																								@class([
																												'badge-status',
																												App\Enums\Payment\PaymentMethod::from(
																																$order->payment_method->value)->badge(),
																								])>{{ \App\Enums\Payment\PaymentMethod::getDescription($order->payment_method->value) }}</span>
																</p>
																<p><strong>Trạng thái thanh toán:</strong> <span
																								@class([
																												'badge-status',
																												App\Enums\Order\PaymentStatus::from($order->payment_status)->badge(),
																								])>{{ \App\Enums\Order\PaymentStatus::getDescription($order->payment_status) }}</span>
																</p>
																<p><strong>Ghi chú:</strong> {{ $order->note }}</p>
																<x-form :action="route('user.uploadCheckoutImage')" type="post" :validate="true" enctype="multipart/form-data">
																				@if ($order->payment_method == App\Enums\Payment\PaymentMethod::Banking)
																								@if ($order->payment_status == App\Enums\Order\PaymentStatus::UnPaid->value)
																												<div class="alert alert-warning mt-3" role="alert">
																																<div class="d-flex align-items-center">
																																				<i class="fas fa-exclamation-triangle me-2"></i>
																																				<strong>Lưu ý:</strong>
																																				<span class="ms-2">Vui lòng tải ảnh chuyển khoản để thanh toán</span>
																																</div>
																												</div>
																												<x-input type="hidden" name="code" :value="$order->code" />
																												<div class="image-upload">
																																<x-input name="payment_image" type="file" class="form-control mt-2" id="banking-receipt"
																																				accept="image/*" :required="true" />
																																<img id="image-preview" class="image-preview img-thumbnail" src="#" alt="Preview"
																																				style="display: none;">
																												</div>
																												<button class="btn btn-default bold-text w-100 mt-3" type="submit">Xác nhận thanh toán</button>
																								@else
																												@if ($order->total - $order->discount_value + $order->surcharge - $order->points * $exchangePercent != 0)
																																<p><strong>Hình ảnh chuyển khoản:</strong>
																																				<img class="image-preview img-thumbnail" src="{{ asset($order->payment_image) }}"
																																								alt="Preview">
																																</p>
																												@endif
																								@endif
																				@endif
																</x-form>
																<div class="mt-4">
																				<h3>Danh sách sản phẩm</h3>
																				<table class="table-center justify-content-center table text-center">
																								<thead>
																												<tr>
																																<th class="text-start">Sản phẩm</th>
																																<th>Giá</th>
																																<th>Số lượng</th>
																																<th>Tổng</th>
																												</tr>
																								</thead>
																								<tbody>
																												@foreach ($order->details as $item)
																																<tr class="bold-text">
																																				<td data-label="Sản phẩm">
																																								<div onclick="location.href='{{ route('user.product.detail', ['slug' => $item->product->slug]) }}';"
																																												style="cursor: pointer" class="align-items-center product-info row">
																																												<div class="col-md-4 col-12"><img src="{{ asset($item->product->avatar) }}"
																																																				class="img-fluid card-item-img"></div>
																																												<div class="col-md-8 col-12">
																																																<div class="product-name">{{ $item->product->name }}</div>
																																																@if ($item->product_variation_id)
																																																				<div class="product-color">
																																																								@foreach ($item->productVariation->attributeVariations as $attributeVariation)
																																																												{{ $attributeVariation->name }}
																																																												@if (!$loop->last)
																																																																,
																																																												@endif
																																																								@endforeach
																																																				</div>
																																																@endif
																																												</div>
																																								</div>
																																				</td>
																																				<td class="align-middle" data-label="Giá">{{ format_price($item->unit_price) }}
																																				</td>
																																				<td class="align-middle" data-label="Số lượng">{{ $item->qty }}</td>
																																				<td class="text-center align-middle" data-label="Tổng">
																																								{{ format_price($item->unit_price * $item->qty) }}</td>
																																</tr>
																												@endforeach
																								</tbody>
																				</table>
																</div>
																<a href="{{ route('user.product.indexUser') }}" class="btn btn-default w-100"><strong>Tiếp tục mua sắm
																								<i class="ti ti-arrow-right"></i></strong></a>
												</div>
												@switch($order->payment_method)
																@case(App\Enums\Payment\PaymentMethod::Banking)
																				<div class="col-md-6 payment-info">
																								<h3>Thông tin thanh toán</h3>
																								@php
																												$bankRepository = app()->make(App\Admin\Repositories\Bank\BankRepository::class);
																												$banks = $bankRepository->getActiveBank();
																												$defaultBank = $banks->first(); // Chọn ngân hàng đầu tiên
																								@endphp

																								<div class="qr-code">
																												<img id="qr-code-image"
																																src="https://img.vietqr.io/image/{{ $defaultBank->code }}-{{ $defaultBank->bank_account_number }}-print.png?amount={{ $order->total - $order->discount_value + $order->surcharge - $order->points * $exchangePercent }}&addInfo=THANH%20TOAN%20DON%20HANG%20{{ $order->code }}&accountName={{ urlencode($defaultBank->bank_account) }}"
																																alt="QR Code">
																								</div>

																								<div class="bank-details mt-3">
																												<p><strong>Ghi chú:</strong> Quét QR chuyển khoản phía trên hoặc Chuyển khoản trực tiếp tới số tài
																																khoản,
																																vui lòng nhập đúng nội dung chuyển khoản để chúng tôi xác nhận đơn hàng
																																nhanh chóng. Ví dụ: "Thanh toan don hang #{{ $order->code }}"</p>
																								</div>
																								<div class="alert alert-info mt-3" role="alert">
																												<div class="d-flex align-items-center">
																																<i class="ti ti-info-hexagon me-2"></i>
																																<strong>Thông tin:</strong>
																																<span class="ms-2">Có thể thay đổi QR Thanh toán bên dưới</span>
																												</div>
																								</div>
																								<x-select class="form-select mt-3" id="bank-select" name="order[payment_method]" :required="true">
																												@foreach ($banks as $bank)
																																<x-select-option :value="$bank->id" :title="$bank->code . ' - ' . $bank->name" data-code="{{ $bank->code }}"
																																				data-account-number="{{ $bank->bank_account_number }}"
																																				data-account-name="{{ $bank->bank_account }}" />
																												@endforeach
																								</x-select>
																				</div>
																@break

																@case(App\Enums\Payment\PaymentMethod::Online)
																				<div class="col-md-6 payment-info">
																								<h3>Thông tin thanh toán</h3>
																								<div class="qr-code">
																												<img src="{{ asset('/userfiles/images/vnpay.png') }}" alt="Vnpay">
																								</div>
																								<div class="bank-details mt-3">
																												<p><strong>Ghi chú:</strong> Nếu đơn hàng của bạn chưa được thanh toán hãy bấm vào nút bên dưới để
																																tiến hành các bước thanh toán cho đơn hàng.</p>
																								</div>
																								<div class="transfer-note mt-3">
																												<a href="{{ route('user.cart.prepareDataVnpay', ['code' => $order->code]) }}"
																																class="btn btn-default w-100"><strong>Tiến hành
																																				thanh toán <i class="ti ti-arrow-right"></i></strong></a>
																								</div>
																				</div>
																@break

																@default
												@endswitch
								</div>
				</div>
				<script>
								document.addEventListener('DOMContentLoaded', function() {
												const bankSelect = document.getElementById('bank-select');
												const qrCodeImage = document.getElementById('qr-code-image');
												const orderCode = "{{ $order->code }}";
												const totalAmount =
																"{{ $order->total - $order->discount_value + $order->surcharge - $order->points * $exchangePercent }}";

												bankSelect.addEventListener('change', function() {
																const selectedOption = bankSelect.options[bankSelect.selectedIndex];
																const bankCode = selectedOption.getAttribute('data-code');
																const accountNumber = selectedOption.getAttribute('data-account-number');
																const accountName = selectedOption.getAttribute('data-account-name');

																if (bankCode && accountNumber && accountName) {
																				const qrUrl =
																								`https://img.vietqr.io/image/${bankCode}-${accountNumber}-print.png?amount=${totalAmount}&addInfo=THANH%20TOAN%20DON%20HANG%20${orderCode}&accountName=${encodeURIComponent(accountName)}`;
																				qrCodeImage.src = qrUrl;
																}
												});
								});
								document.getElementById('banking-receipt').addEventListener('change', function() {
												var preview = document.getElementById('image-preview');
												var file = this.files[0];
												var reader = new FileReader();

												reader.onloadend = function() {
																preview.src = reader.result;
																preview.style.display = 'block';
												}

												if (file) {
																reader.readAsDataURL(file);
												} else {
																preview.src = '';
																preview.style.display = 'none';
												}
								});
				</script>
@endsection

@push('custom-js')
				<script>
								let isNotify = '{{ $order->payment_status == 3 || $order->payment_status == 2 }}';
								if (isNotify == '1') {
												Swal.fire({
																icon: 'success',
																title: 'Thanh toán thành công',
																text: 'Chúng tôi đang xác nhận đơn hàng của bạn.',
																showConfirmButton: true,
																confirmButtonColor: "#1c5639",
												});
								}
				</script>
@endpush
