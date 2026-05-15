@extends('user.layouts.master')
@section('title', __('Đổi mật khẩu'))
@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div class="d-flex justify-content-center align-items-center container bg-white">
								<div class="container gap-64">
												<div class="row mb-3 mt-3">
																@include('user.auth.menu')
																<div class="col-md-10">
																				<x-form :action="route('user.password.update')" type="put" enctype="multipart/form-data" :validate="true">
																								<div class="row">
																												<div class="col-md-4"></div>
																												<div class="col-md-4">
																																<label for="currentPassword">Mật khẩu hiện tại <p style="display: inline;" class="text-red">*
																																				</p></label>
																																<x-input-password name="old_password" :required="true" />

																																<label class="mt-3" for="newPassword">Mật khẩu mới <p style="display: inline;"
																																								class="text-red">*</p></label>
																																<x-input-password name="password" :required="true" />

																																<label class="mt-3" for="confirmPassword">Xác nhận mật khẩu mới <p
																																								style="display: inline;" class="text-red">*</p></label>
																																<x-input-password name="password_confirmation" :required="true"
																																				data-parsley-equalto="input[name='password']"
																																				data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" />
																																<button type="submit" class="btn btn-default w-100 mt-2"><strong>CẬP NHẬT</strong></button>
																												</div>
																								</div>
																				</x-form>
																</div>
												</div>
								</div>
				</div>
@endsection
