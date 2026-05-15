@extends('user.layouts.master')
@section('title', __('Xác thực người dùng'))

@section('content')
				<div class="container mt-5">
								<div style="border: none; border-radius: 0" class="form-container">
												<ul class="nav nav-tabs" id="myTab" role="tablist">
																<li class="nav-item" role="presentation">
																				<button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
																								role="tab" aria-controls="login" aria-selected="true">Xác thực người dùng</button>
																</li>
												</ul>
												<div class="tab-content" id="myTabContent">
																<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
																				<form class="mt-3" action="{{ route('user.auth.oauthChange') }}" method="post">
																								@csrf
																								<input type="hidden" name="email" value="{{ $email }}">
																								<div class="form-group mb-3">
																												<label for="oauth" class="form-label">Mã OTP</label>
																												<input type="text" class="form-control" name="oauth" id="oauth">
																								</div>
																</div>
																<button style="width: 100%;" type="submit" class="btn btn-default">Đăng ký</button>
																</form>
												</div>
								</div>

				</div>
				</div>
@endsection
