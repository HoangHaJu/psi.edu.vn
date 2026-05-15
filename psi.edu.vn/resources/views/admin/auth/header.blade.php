<!-- Header 1 line -->
<header class="main-header d-flex fixed-top bg-white py-3 shadow-sm">
    <div class="container d-flex align-items-center justify-content-between">
        {{-- Phần 1: Logo --}}
        <div class="logo-section">
            <a href="/" class="d-flex align-items-center">
                <img src="{{ asset('/public/assets/images/icon/logo.png') }}" alt="Logo" class="main-logo" />
            </a>
        </div>

        {{-- Phần 2: Menu điều hướng --}}
        <div class="navigation-section d-none d-lg-flex flex-grow-1 justify-content-center">
            <nav class="navbar navbar-expand-lg main-navbar p-0">
                <ul class="navbar-nav fs-5 gap-3 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home"><i class="bi bi-house-door me-1"></i>Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#intro"><i class="bi bi-info-circle me-1"></i>Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#teachers"><i class="bi bi-person me-1"></i>Giáo viên</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#course">
                            <i class="bi bi-book me-1"></i>Ebook
                        </a>
                        <ul class="dropdown-menu fs-5">
                            <li><a class="dropdown-item" href="{{ route('admin.ebook.main') }}">Sách điện tử</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.ebook.ielts') }}">Tài liệu IELTS</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.ebook.toeic') }}">Tài liệu Toeic</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.ebook.dethi') }}">Đề thi tiếng Anh</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.ebook.toefl') }}">Tài liệu TOEFL</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.ebook.sat') }}">Tài liệu SAT</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.game_psi.index') }}">
                            <i class="bi bi-controller me-1"></i>Trò chơi
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        {{-- Phần 3: Đăng nhập/Đăng ký và chọn ngôn ngữ --}}
        <div class="auth-lang-section d-flex align-items-center gap-3">
            @auth('admin')
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none text-dark">
                    <span class="avatar avatar-sm me-2"
                        style="background-image: url({{ asset(auth('admin')->user()->avatar) }})"></span>
                    Dashboard
                </a>
            @else
                <button type="button" class="btn-out-line-authen btn-sm d-xl-block d-none" data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    Đăng nhập
                </button>
                <button type="button" class="btn-authen btn-sm d-xl-block d-none" data-bs-toggle="modal"
                    data-bs-target="#registerModal">
                    Đăng ký
                </button>
            @endauth
            <div id="multi-language">
                {{-- Assuming this partial contains flag icons or a dropdown --}}
                @include('admin.layouts.partials.multi-language')
            </div>
            <button class="navbar-toggler d-lg-none border-0 p-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-label="Toggle navigation">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>
    </div>
</header>
