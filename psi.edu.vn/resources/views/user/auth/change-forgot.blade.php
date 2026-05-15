@extends('user.layouts.master')
@section('title', __('Lấy lại mật khẩu'))

@section('content')
    <div class="container mt-5">
        <div style="border: none; border-radius: 0" class="form-container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                        role="tab" aria-controls="login" aria-selected="true">Lấy lại mật khẩu</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                    <form class="mt-3" action="{{ route('user.auth.changePassword') }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="token_get_password" value="{{ $token }}">
                        <div class="mb-3 form-group">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="mb-3 form-group">
                            <label for="confirm" class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" name="confirm" id="confirm">
                        </div>
                </div>
                <button style="width: 100%;" type="submit" class="btn btn-default">Đăng ký</button>
                </form>
            </div>
        </div>

    </div>
    </div>
@endsection
