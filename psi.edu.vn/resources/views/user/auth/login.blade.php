@extends('user.layouts.master')
@section('title', __('Đăng nhập'))

@section('content')
				<div class="container mt-5">
								<div style="border: none; border-radius: 0" class="form-container">
												<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
																<li class="nav-item" role="presentation">
																				<button class="nav-link active fs-5 fw-bold" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
																								type="button" role="tab" aria-controls="login" aria-selected="true" style="color: #333;">Đăng
																								nhập</button>
																</li>
																<li class="nav-item" role="presentation">
																				<button class="nav-link fs-5 fw-bold" id="register-tab" data-bs-toggle="tab" data-bs-target="#register"
																								type="button" role="tab" aria-controls="register" aria-selected="false"
																								style="color: #333;">Đăng ký</button>
																</li>
												</ul>

												<div class="tab-content" id="myTabContent">
																<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
																				<p class="mt-2">Nhập tên người dùng và mật khẩu để đăng nhập.</p>
																				<x-form :action="route('user.auth.loginUser')" class="mt-3" type="post" :validate="true">
																								<div class="mb-3">
																												<x-input-email name="email" :required="true" />
																								</div>
																								<div class="position-relative mb-3">
																												<x-input-password id="password" name="password" :required="true" />
																												<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
																								</div>
																								<div class="d-flex mb-3">
																												<input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
																												Ghi nhớ
																								</div>
																								<div class="mb-3 text-center">
																												<button style="width: 100%;" type="submit" class="btn btn-default">Đăng nhập</button>
																								</div>
																								<div class="text-center">
																												<a href="{{ route('user.auth.forgotPassword') }}" style="width: 100%;" type="Quên mật khẩu"
																																class="btn btn-outline-success">Quên mật khẩu</a>
																								</div>
																				</x-form>
																</div>
																<div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
																				<p class="mt-2">Nhập email và mật khẩu của bạn để đăng ký.</p>
																				<x-form class="mt-3" action="{{ route('user.auth.register') }}" method="post">
																								<div class="mb-3">
																												<x-input class="form-control" name="fullname" placeholder="Nguyễn Văn A" />
																								</div>
																								<div class="mb-3">
																												<x-input-email name="email" :value="old('email')" :required="true" />
																								</div>
																								<div class="position-relative mb-3">
																												<x-input-password id="registerPassword" name="password" :required="true" />
																												<span toggle="#registerPassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
																								</div>
																								<div class="position-relative mb-3">
																												<x-input-password id="confirmed" name="confirmed" :required="true" />
																												<span toggle="#confirmed" class="fa fa-fw fa-eye field-icon toggle-password"></span>
																								</div>
																								<p>Dữ liệu cá nhân của bạn sẽ được sử dụng để hỗ trợ trải nghiệm của bạn trên toàn bộ trang web này.
																								</p>
																								<button style="width: 100%;" type="submit" class="btn btn-default">Đăng ký</button>
																				</x-form>
																</div>
												</div>
								</div>
				</div>
@endsection
<!-- Thêm một đoạn JavaScript để điều khiển sự hiển thị mật khẩu -->
@push('custom-js')
				<script>
								$(document).ready(function() {
												$(".toggle-password").click(function() {
																$(this).toggleClass("fa-eye fa-eye-slash");
																const input = $(this).attr("toggle");
																if ($(input).attr("type") === "password") {
																				$(input).attr("type", "text");
																} else {
																				$(input).attr("type", "password");
																}
												});
								});
				</script>
@endpush

<!-- Thêm CSS nếu cần thiết -->
<style>
				.field-icon {
								position: absolute;
								right: 10px;
								top: 10px;
								cursor: pointer;
								color: #aaa;
				}

				.position-relative {
								position: relative;
				}
</style>
