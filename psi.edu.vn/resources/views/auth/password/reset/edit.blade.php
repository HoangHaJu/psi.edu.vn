@extends('admin.layouts.guest.master')

@section('content')
    <div class="page page-center">
        <div class="container-tight py-4">
            <x-form :action="route('admin.password.reset.update')" class="card card-md" type="put" :validate="true">
                <div class="mt-4 text-center">
                    <img src="{{ asset('assets/images/logo-secondary.png') }}" width="200" alt="">
                </div>
                <x-input type="hidden" name="token" :value="$token" />
                <x-input type="hidden" name="id" :value="$id" />
                <div class="card-body">
                    <h2 class="card-title mb-4 text-center">{{ __('Nhập mật khẩu mới') }}</h2>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Mật khẩu mới') }}</label>
                        <x-input-password name="password" :required="true" :placeholder="__('Mật khẩu mới')" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Nhập lại mật khẩu') }}</label>
                        <x-input-password name="password_confirmation" :required="true" :placeholder="__('Nhập lại mật khẩu')" />
                    </div>
                    <div class="form-footer">
                        <button id="showRegisterForm" style="background-color: #388383 !important;color: #fff;"
                            type="submit" class="btn w-100 mt-3">{{ __('Lấy lại mật khẩu') }}</button>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
@endsection
