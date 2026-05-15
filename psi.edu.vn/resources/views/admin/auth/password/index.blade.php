@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <x-form :action="route('admin.password.update')" type="put" enctype="multipart/form-data" :validate="true">
                    <div class="card">
                        <div class="card-header justify-content-center">
                            <h2 class="mb-0">{{ __('Đổi mật khẩu') }}</h2>
                        </div>
                        <div class="card-body">
                            <!-- password old -->
                            <div class="mb-3">
                                <label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu cũ') }}:
                                    <span class="text-danger">*</span></label>
                                <x-input-password name="old_password" :required="true" />
                            </div>
                            <!-- new password -->
                            <div class="mb-3">
                                <label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu mới') }}:
                                    <span class="text-danger">*</span></label>
                                <x-input-password name="password" :required="true" />
                            </div>
                            <!-- new password confirmation-->
                            <div class="mb-3">
                                <label class="control-label"><i class="ti ti-key"></i> {{ __('Xác nhận mật khẩu') }}:
                                    <span class="text-danger">*</span></label>
                                <x-input-password name="password_confirmation" :required="true"
                                    data-parsley-equalto="input[name='password']"
                                    data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" />
                            </div>
                        </div>
                        <div class="card-footer mt-auto bg-transparent">
                            <div class="btn-list justify-content-center">
                                <x-button.submit :title="__('Đổi mật khẩu')" />
                            </div>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@endsection
