@extends('admin.layouts.master')

@php
				$settingRepository = app()->make(App\Admin\Repositories\Setting\SettingRepository::class);
				$settings = $settingRepository->getAll();
@endphp

@section('content')
				<div class="page-body">
								<div class="container-xl">
												<div class="card p-3 text-center">
																<div class="alert alert-info mt-3" role="alert">
																				<div class="align-items-center">
																								<strong>Lưu ý: Chuyển khoản trực tiếp cho chúng tôi thông qua các số tài khoản như bên dưới theo cú
																												pháp</strong><br>
																								<strong>"PSI#{{ $transaction->id }}"</strong><br>
																								<strong>để chúng tôi có thể dễ dàng kiểm tra và
																												xác nhận cho bạn nhé!</strong><br>
																								<strong>SỐ TIỀN CẦN CHUYỂN: {{ format_price($transaction->total) }}</strong>
																				</div>
																</div>
																{!! $settings->firstWhere('setting_key', 'payment_info')->plain_value !!}
												</div>
												@if (!$transaction->payment_image)
																<form action="{{ route('admin.transaction.paymentUpdate') }}" method="post" enctype="multipart/form-data">
																				@csrf <!-- CSRF token để bảo vệ form -->
																				<input type="hidden" name="_method" value="PUT"> <!-- Dùng để chỉ định phương thức PUT -->

																				<div class="col-md-6 mb-3 mt-3">
																								<label class="control-label"><i class="ti ti-image"></i>
																												{{ __('Tải lên ảnh chuyển khoản') }}:</label>
																								<div class="image-upload">
																												<x-input name="payment_image" type="file" class="form-control mt-2" id="banking-receipt"
																																accept="image/*" :required="true" />
																												<img id="image-preview" class="image-preview img-thumbnail" src="#" alt="Preview"
																																style="display: none;">
																								</div>
																								<input type="text" name="id" value="{{ $transaction->id }}" hidden>
																								<input type="text" name="status" value="{{ $transaction->status }}" hidden>
																				</div>
																				<button type="submit" class="btn btn-primary">Tải ảnh lên</button>
																</form>
												@endif

								</div>
				</div>
				<script>
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

@push('libs-js')
				<!-- button in datatable -->
				<script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush
