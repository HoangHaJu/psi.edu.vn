@extends('admin.layouts.guest.master')

@section('content')
<div class="row mt-5">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<x-form :action="route('admin.auth.post')" class="card card-md" type="post" :validate="true">
			<div class="card-body" id="loginForm">
				<div class="mb-4 text-center">
					<img src="{{ asset('assets/images/logo-secondary.png') }}" width="200" alt="">
				</div>
				<h2 class="card-title mb-4 text-center">{{ __('Đăng nhập') }}</h2>
				<div class="mb-3">
					<label class="form-label">{{ __('Email') }}</label>
					<x-input-email name="email" :required="true" />
				</div>
				<div class="mb-3">
					<label class="form-label">{{ __('Mật khẩu') }}</label>
					<x-input-password name="password" :required="true" />
				</div>
				<div class="form-footer">
					<button style="background-color: #4DBBBB !important;color: #fff;" type="submit"
						class="btn w-100">{{ __('Đăng nhập') }}</button>
					<button id="showRegisterForm" style="background-color: #388383 !important;color: #fff;"
						type="button" class="btn w-100 mt-3">{{ __('Đăng ký') }}</button>
					<button id="showForgotPasswordForm" style="background-color: #388383c2 !important;color: #fff;"
						type="button" class="btn w-100 mt-3">{{ __('Quên mật khẩu') }}</button>
				</div>
			</div>
		</x-form>

		<x-form :action="route('admin.auth.register')" class="card card-md" type="post" :validate="true">
			<div class="card-body row" id="registerForm" style="display: none;">
				<div class="mb-4 text-center">
					<img src="{{ asset('assets/images/logo-secondary.png') }}" width="200" alt="">
				</div>
				<h2 class="card-title mb-4 text-center">{{ __('Thông tin đăng ký') }}</h2>
				<div class="mb-3">
					<label class="form-label">{{ __('Họ và tên') }}</label>
					<x-input name="fullname" :required="true" placeholder="{{ __('Họ và tên') }}" />
				</div>
				<div class="mb-3">
					<label class="control-label"> {{ __('Ngày sinh') }}:
					</label>
					<x-input type="date" name="birthday" :value="old('birthday')" :required="true" />
				</div>
				<div class="mb-3">
					<label class="control-label">{{ __('Email') }}:
					</label>
					<x-input-email name="email" :value="old('email')" :required="true" />
				</div>
				<div class="mb-3">
					<label class="form-label">{{ __('Mật khẩu') }}</label>
					<x-input-password name="password" :required="true" />
				</div>
				<div class="mb-3">
					<label class="form-label">{{ __('Lặp lại mật khẩu') }}</label>
					<x-input-password name="password_confirmation" :required="true" />
				</div>
				<div class="form-footer text-end">
					<button style="background-color: #4DBBBB !important;color: #fff;" type="submit"
						class="btn w-25">{{ __('Đăng ký') }}</button>
					<button type="button" id="cancelRegisterForm" style="color: #000;"
						class="btn w-25">{{ __('Huỷ bỏ') }}</button>
				</div>
			</div>
		</x-form>

		<x-form :action="route('admin.auth.forgot')" class="card card-md" type="post" :validate="true">
			<div class="card-body row" id="forgotPasswordForm" style="display: none;">
				<div class="mb-4 text-center">
					<img src="{{ asset('assets/images/logo-secondary.png') }}" width="200" alt="">
				</div>
				<h2 class="card-title mb-4 text-center">{{ __('Nhập email để lấy lại mật khẩu') }}</h2>
				<div class="mb-3">
					<label class="control-label">{{ __('Email') }}:
					</label>
					<x-input-email name="email" :value="old('email')" :required="true" />
				</div>
				<div class="form-footer text-end">
					<button style="background-color: #4DBBBB !important;color: #fff;" type="submit"
						class="btn w-25">{{ __('Lấy lại mật khẩu') }}</button>
					<button id="cancelForgotPasswordForm" style="color: #000;" type="button"
						class="btn w-25">{{ __('Huỷ bỏ') }}</button>
				</div>
			</div>
		</x-form>
	</div>
	<div class="col-md-3"></div>
</div>
@endsection

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const loginForm = document.getElementById('loginForm');
		const registerForm = document.getElementById('registerForm');
		const forgotPasswordForm = document.getElementById('forgotPasswordForm');
		const showRegisterFormButton = document.getElementById('showRegisterForm');
		const cancelRegisterFormButton = document.getElementById('cancelRegisterForm');
		const showForgotPasswordFormButton = document.getElementById('showForgotPasswordForm');
		const cancelForgotPasswordFormButton = document.getElementById('cancelForgotPasswordForm');

		// Hiển thị form Đăng ký và ẩn form Đăng nhập
		showRegisterFormButton.addEventListener('click', function(e) {
			e.preventDefault();
			loginForm.style.display = 'none';
			registerForm.style.display = 'block';
			forgotPasswordForm.style.display = 'none';
		});

		showForgotPasswordFormButton.addEventListener('click', function(e) {
			e.preventDefault();
			loginForm.style.display = 'none';
			registerForm.style.display = 'none';
			forgotPasswordForm.style.display = 'block';
		});

		// Quay lại form Đăng nhập và ẩn form Đăng ký
		cancelRegisterFormButton.addEventListener('click', function(e) {
			e.preventDefault();
			loginForm.style.display = 'block';
			registerForm.style.display = 'none';
			forgotPasswordForm.style.display = 'none';
		});

		cancelForgotPasswordFormButton.addEventListener('click', function(e) {
			e.preventDefault();
			loginForm.style.display = 'block';
			registerForm.style.display = 'none';
			forgotPasswordForm.style.display = 'none';
		});
	});
</script>