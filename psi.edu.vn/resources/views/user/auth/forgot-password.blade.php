@extends('user.layouts.master')
@section('title', __('Quên mật khẩu'))
@section('content')
    <div class="container mt-5">
        <div class="form-container">
            <h4 class="text-center">Lấy lại mật khẩu</h4>
            <form class="mt-3 align-items-center" action="{{ route('user.auth.forgotPasswordSend') }}" method="post">
                @csrf
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" id="loginEmail" placeholder="Email" required>
                </div>
                <div class="text-center mb-3">
                    <button style="width: 100%;" type="submit" class="btn btn-default">Lấy mã xác nhận</button>
                </div>
            </form>
        </div>
    </div>
@endsection
