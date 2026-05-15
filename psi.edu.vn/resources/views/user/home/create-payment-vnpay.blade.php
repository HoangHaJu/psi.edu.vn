@extends('user.layouts.master')
@section('title', __('Thanh toán'))

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div class="d-flex justify-content-center align-items-center container bg-white">
								<div class="container gap-64">
												<x-input :value="$order->id" type="hidden" name="order_id" />
												<div class="row">
																<div class="col-12 mt-3">
																				<div class="form-group">
																								<label for="language">Tổng tiền</label>
																								<input type="text" class="form-control" disabled
																												value="{{ format_price($order->total - $order->discount_value + $order->surcharge) }}" />
																				</div>
																				<div class="form-group mt-3">
																								<label for="bankcode">Ngân hàng</label>
																								<select name="bankcode" id="bankcode" class="form-control">
																												<option value="">Không chọn </option>
																												<option value="QRONLY">Thanh toan QRONLY</option>
																												<option value="MBAPP">Ung dung MobileBanking</option>
																												<option value="VNPAYQR">VNPAYQR</option>
																												<option value="VNBANK">LOCAL BANK</option>
																												<option value="IB">INTERNET BANKING</option>
																												<option value="ATM">ATM CARD</option>
																												<option value="INTCARD">INTERNATIONAL CARD</option>
																												<option value="VISA">VISA</option>
																												<option value="MASTERCARD"> MASTERCARD</option>
																												<option value="JCB">JCB</option>
																												<option value="UPI">UPI</option>
																												<option value="VIB">VIB</option>
																												<option value="VIETCAPITALBANK">VIETCAPITALBANK</option>
																												<option value="SCB">Ngan hang SCB</option>
																												<option value="NCB">Ngan hang NCB</option>
																												<option value="SACOMBANK">Ngan hang SacomBank </option>
																												<option value="EXIMBANK">Ngan hang EximBank </option>
																												<option value="MSBANK">Ngan hang MSBANK </option>
																												<option value="NAMABANK">Ngan hang NamABank </option>
																												<option value="VNMART"> Vi dien tu VnMart</option>
																												<option value="VIETINBANK">Ngan hang Vietinbank </option>
																												<option value="VIETCOMBANK">Ngan hang VCB </option>
																												<option value="HDBANK">Ngan hang HDBank</option>
																												<option value="DONGABANK">Ngan hang Dong A</option>
																												<option value="TPBANK">Ngân hàng TPBank </option>
																												<option value="OJB">Ngân hàng OceanBank</option>
																												<option value="BIDV">Ngân hàng BIDV </option>
																												<option value="TECHCOMBANK">Ngân hàng Techcombank </option>
																												<option value="VPBANK">Ngan hang VPBank </option>
																												<option value="AGRIBANK">Ngan hang Agribank </option>
																												<option value="MBBANK">Ngan hang MBBank </option>
																												<option value="ACB">Ngan hang ACB </option>
																												<option value="OCB">Ngan hang OCB </option>
																												<option value="IVB">Ngan hang IVB </option>
																												<option value="SHB">Ngan hang SHB </option>
																												<option value="APPLEPAY">Apple Pay </option>
																												<option value="GOOGLEPAY">Google Pay </option>
																								</select>
																				</div>
																				<div class="form-group mb-3 mt-3">
																								<label for="language">Ngôn ngữ</label>
																								<select name="language" id="language" class="form-control">
																												<option value="vn">Tiếng Việt</option>
																												<option value="en">English</option>
																								</select>
																				</div>
																				<button type="button" id="payButton" class="btn btn-default w-100 mb-3"><strong>Thanh
																												toán</strong></button>
																</div>
												</div>
								</div>
				</div>
@endsection

@push('custom-js')
				<script>
								document.getElementById('payButton').addEventListener('click', function() {
												let orderId = document.querySelector('input[name="order_id"]').value;
												let bankcode = document.getElementById('bankcode').value;
												let language = document.getElementById('language').value;

												let url =
																`{{ route('user.cart.handleVnpay') }}?order_id=${orderId}&bankcode=${bankcode}&language=${language}`;

												window.location.href = url;
								});
				</script>
@endpush
