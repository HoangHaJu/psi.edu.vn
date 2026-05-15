<div class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
        aria-expanded="false">
        <span class="avatar avatar-sm" style="background-image: url({{ asset(auth('admin')->user()->avatar) }})"></span>
        <div class="d-none d-xl-block ps-2">
            <div>Đăng xuất<i class="ti ti-door-exit ms-2"></i></div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <div class="gtranslate_wrapper d-flex justify-content-center align-items-center d-lg-none"></div>
        <a href="{{ url('/') }}" class="dropdown-item">{{ __('Trang chủ') }}</a>
        <a href="{{ route('admin.password.index') }}" class="dropdown-item">{{ __('Đổi mật khẩu') }}</a>
        <a href="#" class="dropdown-item" data-bs-toggle="modal"
            data-bs-target="#modalLogout">{{ __('Đăng xuất') }}</a>
    </div>
</div>
