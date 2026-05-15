@extends('admin.layouts.guest.master')
@section('content')
    @include('admin.auth.header')
    @include('admin.auth.login_register.index')
    @include('admin.auth.term_privacy.index')
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            @auth('admin')
                <a href="{{ route('admin.dashboard') }}" class="btn mb-xl-0 rounded-pill mb-2 me-2">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset(auth('admin')->user()->avatar) }})"></span>
                </a>
            @else
                <h5 class="offcanvas-title">Menu</h5>
            @endauth
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Đóng"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#home"><i class="bi bi-house-door me-1"></i>Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#intro"><i class="bi bi-info-circle me-1"></i>Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#teachers"><i class="bi bi-person me-1"></i>Giáo viên</a>
                </li>
                <li class="nav-item dropdown" id="ebookDropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="ebookDropdownToggle" href="#course">
                        <i class="bi bi-book me-1"></i>Ebook
                    </a>
                    <ul class="dropdown-menu fs-5" id="ebookDropDownMenu"
                        style="transform: translate3d(45px, 0px, 0px) !important;">
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
                        <i class="bi bi-controller me-1"></i>Trò chơi</a>
                </li>
            </ul>
            @if (auth('admin')->check())
            @else
                <div class="mt-4 d-lg-none d-flex gap-2">
                    <x-button.modal-open-button id="desktopLoginButton" target-modal-id="loginModal" label="Đăng nhập"
                        button-class="btn-out-line-authen btn-sm d-lg-inline" />

                    <x-button.modal-open-button id="desktopRegisterButton" target-modal-id="registerModal" label="Đăng ký"
                        button-class="btn-authen btn-sm d-lg-inline" />
                </div>
            @endif
        </div>
    </div>

    <!-- Hero Section -->
    <header class="text-center bg-white" id="home">
        <div class="container">
            <video class="w-100" autoplay muted loop playsinline
                poster="{{ asset('/public/assets/images/icon/logo.png') }}">
                <source src="{{ asset('/public/assets/images/icon/landingPageVideo.mp4') }}" type="video/mp4">
                Trình duyệt của bạn không hỗ trợ video HTML5.
            </video>
        </div>
    </header>

    <!-- Giới thiệu tổng quan -->
    <section id="intro" class="section bg-primary text-center py-5">
        <div class="container">
            <div class="section-title mb-4">
                <h2 class="text-accent">Về chúng tôi</h2>
            </div>

            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('/public/assets/images/icon/logo.png') }}" alt="Logo PSI" class="img-fluid"
                        style="max-width: 300px;">
                </div>
                <div class="col-md-6 text-general">
                    <p>
                        PSI tự hào là nền tảng học tiếng Anh trực tuyến với chất lượng vượt trội, mang đến cho học viên
                        trải nghiệm học tập cùng các giáo viên nước ngoài được đào tạo bài bản.
                    </p>
                    <p>
                        Đội ngũ giáo viên tại PSI sở hữu nhiều năm kinh nghiệm, có bằng đại học và các chứng chỉ giảng
                        dạy uy tín như TESOL, TEFL, TEYL, TESL. Mỗi giáo viên đều tâm huyết và luôn đồng hành cùng học
                        viên vượt qua thử thách để vươn tới thành công.
                    </p>
                    <p>
                        PSI được thành lập với sứ mệnh phổ cập tiếng Anh như ngôn ngữ thứ hai – mở ra cánh cửa đến kho
                        tàng tri thức, khám phá văn hóa mới và chinh phục những cơ hội toàn cầu.
                    </p>
                    <p>
                        Không chỉ là nơi học tập, PSI là nơi kiến tạo nên những giá trị đích thực cho thế hệ học sinh
                        toàn cầu.
                    </p>
                </div>
            </div>

            <div class="row mt-4 justify-content-center">
                <div class="col-lg-10">
                    <p class="text-about-us">
                        PSI là nền tảng học tiếng Anh online duy nhất cho phép bạn tự đăng ký và tham gia lớp học trực
                        tiếp với giáo viên nước ngoài – mọi lúc, mọi nơi, trên mọi thiết bị như máy tính, điện thoại hay
                        máy tính bảng.
                    </p>
                </div>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-6 col-md-3 mb-3">
                    <i class="bi bi-house fs-1 text-primary"></i><br>
                    <strong>Tại nhà</strong>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <i class="bi bi-cup-straw fs-1 text-success"></i><br>
                    <strong>Tại quán cafe</strong>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <i class="bi bi-building fs-1 text-info"></i><br>
                    <strong>Tại công ty</strong>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <i class="bi bi-tree fs-1 text-warning"></i><br>
                    <strong>Tại công viên</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- Thành tựu -->
    <section id="achievements" class="section text-center bg-white py-5">
        <div class="container">
            <div class="section-title mb-5">
                <h2 class="text-accent">Thành tựu</h2>
            </div>
            <div class="row rounded-4 g-4 bg-gradient-web">
                <div class="col-sm-6 col-md-3">
                    <div class="p-4 h-100 hover-scale">
                        <i class="bi bi-award-fill text-primary fs-1 mb-2"></i>
                        <div class="counter fw-bold fs-2" data-target="15">0</div>
                        <p class="mb-0">Năm kinh nghiệm</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-4 h-100 hover-scale">
                        <i class="bi bi-people-fill text-success fs-1 mb-2"></i>
                        <div class="counter fw-bold fs-2" data-target="1000">0</div>
                        <p class="mb-0">Giáo viên</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-4 h-100 hover-scale">
                        <i class="bi bi-mortarboard-fill text-warning fs-1 mb-2"></i>
                        <div class="counter fw-bold fs-2" data-target="100000">0</div>
                        <p class="mb-0">Học viên</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-4 h-100 hover-scale">
                        <i class="bi bi-calendar-event-fill text-danger fs-1 mb-2"></i>
                        <div class="counter fw-bold fs-2" data-target="3000000">0</div>
                        <p class="mb-0">Buổi học đã diễn ra</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sứ mệnh và Giá trị -->
    <section id="mission-value" class="section text-center bg-white py-5">
        <div class="container">
            <div class="section-title mb-5">
                <h2 class="text-accent">Sứ mệnh & Giá trị cốt lõi</h2>
            </div>
            <div class="row rounded-4 g-4 bg-gradient-web">
                <div class="col-md-6">
                    <div class="p-4 h-100 hover-scale">
                        <i class="bi bi-bullseye text-primary fs-1 mb-2"></i>
                        <h3 class="fw-bold fs-2 text-dark">Sứ mệnh</h3>
                        <p class="mb-0 fs-5">Giúp 10 triệu người Việt Nam sử dụng tiếng Anh thành thạo, mở ra cánh cửa đến
                            với thế giới.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 h-100 hover-scale">
                        <i class="bi bi-gem text-success fs-1 mb-2"></i>
                        <h3 class="fw-bold fs-2 text-dark">Giá trị</h3>
                        <p class="mb-0 fs-5">Mang lại giá trị vượt xa chi phí – cung cấp các bài học tiếng Anh chất lượng
                            cao với giá cả hợp lý, do giáo viên nước ngoài chuyên nghiệp giảng dạy và tài liệu học tập hấp
                            dẫn.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Vì sao nên chọn PSI Đồng Cấp -->
    <section id="reason" class="bg-light py-5">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="text-accent">Vì sao nên chọn PSI Đồng Cấp</h2>
            </div>
            <div class="row text-center g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-4 bg-white shadow-sm rounded h-100 hover-scale">
                        <i class="bi bi-globe text-primary fs-1 mb-3"></i>
                        <h5 class="fw-bold">100% giáo viên nước ngoài</h5>
                        <p>Giáo viên chuẩn quốc tế, giàu kinh nghiệm giảng dạy</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-4 bg-white shadow-sm rounded h-100 hover-scale">
                        <i class="bi bi-cash-coin text-success fs-1 mb-3"></i>
                        <h5 class="fw-bold">Chỉ từ 75.000đ/buổi</h5>
                        <p>25 phút học hiệu quả, tiết kiệm chi phí</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-4 bg-white shadow-sm rounded h-100 hover-scale">
                        <i class="bi bi-journal-bookmark-fill text-warning fs-1 mb-3"></i>
                        <h5 class="fw-bold">Chương trình học đa dạng</h5>
                        <p>Phù hợp với mọi độ tuổi và trình độ</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="p-4 bg-white shadow-sm rounded h-100 hover-scale">
                        <i class="bi bi-person-video2 text-info fs-1 mb-3"></i>
                        <h5 class="fw-bold">Tương tác 1:1 cùng thầy cô</h5>
                        <p>Tập trung cá nhân hóa, hiệu quả tối đa</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="p-4 bg-white shadow-sm rounded h-100 hover-scale">
                        <i class="bi bi-laptop text-danger fs-1 mb-3"></i>
                        <h5 class="fw-bold">Học online mọi lúc mọi nơi</h5>
                        <p>Thuận tiện, vui nhộn, linh hoạt thời gian</p>
                    </div>
                </div>
            </div>

            <div class="row mt-3 justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="highlight-callout text-center">
                        Học với giáo viên quốc tế – Nâng tầm kỹ năng tiếng Anh của bạn!
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lợi ích -->
    <section id="benefit" class="bg-primary py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="text-accent fw-bold">Lợi ích khi học cùng PSI</h2>
            </div>

            <!-- Item 1 -->
            <div class="row justify-content-start mb-4" data-aos="fade-left">
                <div class="col-12 col-md-8">
                    <div class="bg-white hover-scale-border rounded shadow-sm p-4 d-flex">
                        <i class="bi bi-clock display-6 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Học trực tuyến mọi lúc, mọi nơi</h6>
                            <p class="mb-0">Không gian học quen thuộc, thời gian học được tối ưu để phù hợp với lịch
                                trình cá nhân.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="row justify-content-end mb-4" data-aos="fade-right">
                <div class="col-12 col-md-8">
                    <div class="bg-white hover-scale-border rounded shadow-sm p-4 d-flex">
                        <i class="bi bi-book display-6 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Chương trình học đa dạng, hấp dẫn</h6>
                            <p class="mb-0">Nội dung theo chuẩn quốc tế, giúp trẻ tăng khả năng tương tác và tự tin
                                giao
                                tiếp.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="row justify-content-start mb-4" data-aos="fade-left">
                <div class="col-12 col-md-8">
                    <div class="bg-white hover-scale-border rounded shadow-sm p-4 d-flex">
                        <i class="bi bi-laptop display-6 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Lớp học 1 kèm 1</h6>
                            <p class="mb-0">Mô hình lớp học cá nhân hoá, nâng cao hiệu quả học tập tối đa cho từng
                                học
                                sinh.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="row justify-content-end mb-4" data-aos="fade-right">
                <div class="col-12 col-md-8">
                    <div class="bg-white hover-scale-border rounded shadow-sm p-4 d-flex">
                        <i class="bi bi-graph-up display-6 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Báo cáo tiến độ</h6>
                            <p class="mb-0">Phụ huynh được cập nhật thường xuyên về sự tiến bộ và lộ trình học của
                                con.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="courses" class="section bg-white py-5">
        <div class="container text-center">
            <div class="section-title mb-4">
                <h2 class="text-accent">Khóa học tiêu biểu</h2>
            </div>

            <ul class="nav nav-pills custom-tab-pills justify-content-center mb-5 gap-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all"
                        type="button" role="tab" aria-controls="pills-all" aria-selected="true">
                        <i class="bi bi-collection"></i> Khóa Học Trẻ Em
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-ielts-tab" data-bs-toggle="pill" data-bs-target="#pills-ielts"
                        type="button" role="tab" aria-controls="pills-ielts" aria-selected="false">
                        <i class="bi bi-translate"></i> Khóa Học Chứng chỉ
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-toeic-tab" data-bs-toggle="pill" data-bs-target="#pills-toeic"
                        type="button" role="tab" aria-controls="pills-toeic" aria-selected="false">
                        <i class="bi bi-journal-bookmark"></i> TESOL
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <div class="row g-4 justify-content-center">
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Gia sư 1:1">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Gia sư 1:1</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Global Success</li>
                                        <li class="clamp-card-list">Ôn tập và học bài mới</li>
                                        <li class="clamp-card-list">Tập trung trọng tâm lớp</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">75.000đ / buổi (25
                                            phút)</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Cambridge">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Cambridge</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Starter, Mover, Flyer</li>
                                        <li class="clamp-card-list">Học bằng giáo trình Cambriedge English</li>
                                        <li class="clamp-card-list">Tập trung vào kĩ năng thi chứng chỉ</li>
                                        <li class="clamp-card-list">Mục tiêu thi IELTS và Du học</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">75.000đ / buổi (25
                                            phút)</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Luyện nói">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Luyện nói</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình riêng theo chủ đề</li>
                                        <li class="clamp-card-list">Học bằng hình ảnh, âm thanh và các trò chơi thú vị</li>
                                        <li class="clamp-card-list">Tập trung vào mục tiêu giao tiếp và nói chuyện</li>
                                        <li class="clamp-card-list">Sau khóa học, con phát âm và nói chuyện tốt, trôi chảy
                                            hàng ngày</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">75.000đ / buổi (25
                                            phút)</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-ielts" role="tabpanel" aria-labelledby="pills-ielts-tab">
                    <div class="row g-4 justify-content-center">
                        {{-- IELTS Card --}}
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ tiếng Anh IELTS">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ tiếng Anh IELTS</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Oxford</li>
                                        <li class="clamp-card-list">Tập trung vào kĩ năng thi IELTS</li>
                                        <li class="clamp-card-list">Phù hợp du học, tìm việc làm hay miễn thi THPT</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">200.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- TOEIC Card --}}
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ tiếng Anh TOEIC">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ tiếng Anh TOEIC</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Oxford</li>
                                        <li class="clamp-card-list">Tập trung vào kĩ năng thi TOEIC</li>
                                        <li class="clamp-card-list">Phù hợp xin việc hay xét tốt nghiệp đại học</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">165.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- TOEFL Card --}}
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ tiếng Anh TOEFL">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ tiếng Anh TOEFL</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Oxford</li>
                                        <li class="clamp-card-list">Tập trung vào kĩ năng thi TOEFL</li>
                                        <li class="clamp-card-list">Tiếng Anh học thuật cho người làm việc hay định cư nước
                                            ngoài</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">95.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Cambridge Card --}}
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ tiếng Anh Cambridge">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ tiếng Anh Cambridge</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Cambridge English</li>
                                        <li class="clamp-card-list">Tập trung vào kĩ năng thi chứng chỉ</li>
                                        <li class="clamp-card-list">Mục tiêu thi Cambridge và du học</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">165.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- CEFR Card --}}
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ CEFR">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ CEFR</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Oxford</li>
                                        <li class="clamp-card-list">Tập trung vào kĩ năng thi chứng chỉ</li>
                                        <li class="clamp-card-list">CEFR giúp đánh giá năng lực sử dụng ngôn ngữ giữa các
                                            quốc gia</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">200.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- SAT Card --}}
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ SAT">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ SAT</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Oxford</li>
                                        <li class="clamp-card-list">Tập trung vào kĩ năng thi chứng chỉ</li>
                                        <li class="clamp-card-list">Chuẩn hóa đầu vào cho du học sinh tại Mĩ hay các nước
                                            sử dụng hệ thống giáo dục tương đương</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">200.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- VSTEP Card --}}
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ VSTEP">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ VSTEP</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Giáo trình Oxford</li>
                                        <li class="clamp-card-list">Đây là chứng chỉ do Bộ Giáo dục & Đào tạo cấp</li>
                                        <li class="clamp-card-list">VSTEP được công nhận toàn quốc, dành cho giáo viên,
                                            công chức, viên chức</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">165.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- TESOL Card --}}
                        {{-- <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Chứng chỉ TESOL">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ TESOL</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Là chứng chỉ nghiệp vụ sư phạm tiếng Anh được công nhận
                                            toàn cầu</li>
                                        <li class="clamp-card-list">Sau khi học xong được bao thi 1 lần miễn phí, bằng được
                                            gửi tới tận địa chỉ học viên</li>
                                        <li class="clamp-card-list">Hợp pháp hóa dạy tiếng Anh tại nước ngoài, dễ xin việc
                                            tại các trường quốc tế. Đủ điều kiện dạy online toàn cầu</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">200.000 VNĐ</span>
                                    </p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-toeic" role="tabpanel" aria-labelledby="pills-toeic-tab">
                    <div class="row g-4 justify-content-center">
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}"
                                    class="card-img-top w-50 mx-auto mt-4" alt="Luyện nói">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-bold clamp-card-title">Chứng chỉ TESOL</h5>
                                    <ul class="ps-3 text-start mb-3 flex-grow-1">
                                        <li class="clamp-card-list">Chứng chỉ được công nhận toàn
                                            cầu.</li>
                                        <li class="clamp-card-list">Sau khi học được thi bao thi 1 lần miễn
                                            phí.</li>
                                        <li class="clamp-card-list">Bằng được gửi đến địa chỉ của học
                                            viên.</li>
                                    </ul>
                                    <p class="mb-0 mt-auto">
                                        <span class="text-danger fw-bold clamp-card-price-new">7.500.000VNĐ/4 tuần</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary btn-lg custom-register-button pulse" data-bs-toggle="modal"
                    data-bs-target="#registerModal">Đăng ký ngay</a>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row mt-5 justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="highlight-callout text-center">
                        Học trực tiếp 1:1 với giáo viên, nâng cao hiệu suất học tập!
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Kỹ thuật tư duy tập trung -->
    <section id="method" class="section bg-primary py-5">
        <div class="container text-center">
            <div class="section-title mb-4">
                <h2 class="text-accent">Kỹ thuật tư duy tập trung</h2>
            </div>
            <p class="lead fw-semibold text-dark-emphasis px-3 px-md-5">
                <span class="bg-opacity-25 px-2 py-1 rounded highlight-animate">
                    Kết nối<span class="fw-bold text-primary"> 5 giác quan </span>ở hiện tại,


                    <span class="text-success">thúc đẩy học tiếng Anh vượt trội</span>
                </span>
            </p>
            <div class="row justify-content-center g-4">
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="bg-white rounded shadow-sm p-3 hover-scale h-100">
                        <i class="bi bi-eye fs-1 text-primary"></i>
                        <div class="fw-bold mt-2">Nhìn</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="bg-white rounded shadow-sm p-3 hover-scale h-100">
                        <i class="bi bi-hand-index-thumb fs-1 text-success"></i>
                        <div class="fw-bold mt-2">Chạm</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="bg-white rounded shadow-sm p-3 hover-scale h-100">
                        <i class="bi bi-ear fs-1 text-danger"></i>
                        <div class="fw-bold mt-2">Nghe</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="bg-white rounded shadow-sm p-3 hover-scale h-100">
                        <i class="bi bi-flower2 fs-1 text-warning"></i>
                        <div class="fw-bold mt-2">Ngửi</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="bg-white rounded shadow-sm p-3 hover-scale h-100">
                        <i class="bi bi-cup-straw fs-1 text-info"></i>
                        <div class="fw-bold mt-2">Nếm</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Giáo viên tiêu biểu -->
    <section id="teachers" class="section bg-white py-5" aria-label="Giáo viên tiêu biểu">
        <div class="container text-center">
            <div class="section-title mb-5">
                <h2 class="text-accent">Giáo viên tiêu biểu</h2>
            </div>

            <div id="teacherCarousel" class="carousel slide position-relative pb-5 " data-bs-ride="carousel"
                style="min-height:450px;">
                <div class="carousel-inner">
                    @foreach ($teachers as $key => $teacher)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row justify-content-center g-4">
                                <article class="col-12 col-md-10 d-flex flex-wrap bg-white p-4 shadow rounded">
                                    <div class="col-12 col-md-4 text-center mt-3 mb-md-0">
                                        <img src="{{ asset($teacher['avatar']) }}"
                                            alt="Ảnh giáo viên {{ $teacher['fullname'] }}"
                                            class="img-fluid img-thumbnail w-75" />
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#teacherDetailModal-{{ $key }}">
                                                Xem hồ sơ chi tiết
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-8 text-start">
                                        <div class="teacher-header d-flex align-items-center gap-2">
                                            <img src="{{ asset($teacher['national_flag']) }}" alt="Quốc kỳ Việt Nam"
                                                class="flag" />
                                            <h3 class="mb-0">{{ $teacher['fullname'] }}</h3>
                                            @if ($teacher['audio'])
                                                <button class="btn btn-sm p-0 ms-2"
                                                    onclick="toggleAudio('audio-{{ $key }}')"
                                                    {{-- Sử dụng toggleAudio --}} aria-label="Nghe/Tắt phát âm tên">
                                                    {{-- Cập nhật label cho phù hợp --}}
                                                    <i class="bi bi-volume-up volume-icon"></i>
                                                </button>
                                                <audio id="audio-{{ $key }}">
                                                    <source src="{{ asset($teacher['audio']) }}" type="audio/mpeg" />
                                                    Trình duyệt không hỗ trợ audio.
                                                </audio>
                                            @else
                                                <span class="text-danger fs-4 ms-2">Không có Audio</span>
                                            @endif
                                        </div>

                                        <p class="mt-2 mb-2">{{ $teacher['description'] ?? 'Chưa có mô tả.' }}</p>
                                        <p class="mb-2 text-warning">
                                            {{-- Bạn có thể điều chỉnh cách hiển thị số sao dựa trên dữ liệu đánh giá thực tế của giáo viên --}}
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="bi {{ $i <= ($teacher['rating'] ?? 4) ? 'bi-star-fill text-warning' : 'bi-star text-muted' }} fs-4"></i>
                                            @endfor
                                        </p>

                                        <div class="mb-2 d-flex align-items-center">
                                            <i class="bi bi-calendar-event me-2"></i>
                                            <span>Lịch dạy hôm nay</span>
                                        </div>

                                        <button class="btn btn-outline-secondary d-md-none mb-3" data-bs-toggle="collapse"
                                            data-bs-target="#schedule-{{ $key }}">
                                            <i class="bi bi-clock me-1"></i> Xem lịch dạy hôm nay
                                        </button>

                                        <div id="schedule-{{ $key }}" class="collapse d-md-block">
                                            @php
                                                $startTimes = collect($teacherStartTimes[$teacher->id] ?? [])->unique();

                                                $morningShift = $startTimes->filter(function ($time) {
                                                    return \Carbon\Carbon::parse($time)->between(
                                                        \Carbon\Carbon::parse('07:00:00'),
                                                        \Carbon\Carbon::parse('18:00:00'),
                                                    );
                                                });

                                                $eveningShift = $startTimes->filter(function ($time) {
                                                    return \Carbon\Carbon::parse($time)->between(
                                                        \Carbon\Carbon::parse('18:00:01'),
                                                        \Carbon\Carbon::parse('22:00:00'),
                                                    );
                                                });
                                            @endphp

                                            <div class="mb-3">
                                                <p class="m-1 fw-semibold">Buổi sáng</p>
                                                <div class="time-grid">
                                                    @forelse($morningShift as $time)
                                                        <span
                                                            class="time-slot">{{ \Carbon\Carbon::parse($time)->format('H:i') }}</span>
                                                    @empty
                                                        <span class="text-muted">Không có lịch trống</span>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div>
                                                <p class="m-1 fw-semibold">Buổi tối</p>
                                                <div class="time-grid">
                                                    @forelse($eveningShift as $time)
                                                        <span
                                                            class="time-slot">{{ \Carbon\Carbon::parse($time)->format('H:i') }}</span>
                                                    @empty
                                                        <span class="text-muted">Không có lịch trống</span>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="carousel-indicators custom-dots">
                    @foreach ($teachers as $key => $teacher)
                        <button type="button" data-bs-target="#teacherCarousel" data-bs-slide-to="{{ $key }}"
                            class="{{ $loop->first ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>


                <button
                    class="carousel-control-prev carousel-control-custom d-flex align-items-center justify-content-center"
                    type="button" data-bs-target="#teacherCarousel" data-bs-slide="prev" aria-label="Trước">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>

                <button
                    class="carousel-control-next carousel-control-custom d-flex align-items-center justify-content-center"
                    type="button" data-bs-target="#teacherCarousel" data-bs-slide="next" aria-label="Tiếp theo">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary btn-lg custom-register-button pulse" data-bs-toggle="modal"
                    data-bs-target="#registerModal">Đăng ký ngay</a>
            </div>
        </div>
    </section>

    <!-- Modal giáo viên tiêu biểu -->
    @foreach ($teachers as $key => $teacher)
        <div class="modal fade" id="teacherDetailModal-{{ $key }}" tabindex="-1"
            aria-labelledby="teacherDetailModalLabel-{{ $key }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content rounded-4 shadow-lg overflow-hidden">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="teacherDetailModalLabel-{{ $key }}">
                            Hồ sơ giáo viên: {{ $teacher['fullname'] }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="container-fluid">
                            <div class="row gy-4">
                                <div class="col-lg-4 text-center">
                                    <img src="{{ asset($teacher['avatar']) }}" class="rounded-circle shadow"
                                        alt="{{ $teacher['fullname'] }}" width="180">
                                    <div class="mt-3 d-flex justify-content-center align-items-center gap-2">
                                        <img src="{{ asset($teacher['national_flag']) }}"
                                            alt="{{ $teacher['country'] }} flag" width="32">
                                        <span class="fs-4 fw-semibold">{{ $teacher['country'] }}</span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="bi {{ $i <= ($teacher['rating'] ?? 4) ? 'bi-star-fill text-warning' : 'bi-star text-muted' }} fs-4"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="ratio ratio-16x9 mb-4 rounded overflow-hidden shadow-sm">
                                        <iframe src="{{ $teacher['link'] }}" title="Video giới thiệu"
                                            allowfullscreen></iframe>
                                    </div>
                                    <div class="d-flex gap-3 justify-content-center"> {{-- Thêm justify-content-center để căn giữa nút còn lại nếu cần --}}
                                        <a href="mailto:{{ $teacher['email'] ?? 'info@example.com' }}"
                                            class="btn btn-outline-primary btn-xl">
                                            <i class="bi bi-envelope-fill me-2"></i>Liên hệ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Đánh giá từ học viên -->
    <section id="reviews" class="section py-5 bg-primary">
        <div class="section-title mb-5 container">
            <h2 class="text-accent">Học viên nói gì về chúng tôi</h2>
        </div>
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/hoang-thi-lan.png') }}"
                                        alt="Avatar Chị Hoàng Thị Lan" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Hoàng Thị Lan</h5>
                                        <small class="text-muted">Phụ huynh bé 4 tuổi (mầm non)</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Tôi rất hài lòng khi cho con bắt đầu học tiếng Anh từ
                                        sớm với PSI. Các bài học được
                                        thiết kế sinh động, nhiều hình ảnh và âm thanh giúp bé thích thú. Bé thường tự mở
                                        bài
                                        học để xem lại các từ mới và bài hát. Sau một năm học, tôi thấy bé đã có thể nhận
                                        biết
                                        nhiều từ vựng cơ bản và tự tin hơn khi giao tiếp với người nước ngoài.</span>
                                    <span class="review-full-text" style="display: none;">Tôi rất hài lòng khi cho con bắt
                                        đầu học tiếng Anh từ sớm với PSI. Các bài học được
                                        thiết kế sinh động, nhiều hình ảnh và âm thanh giúp bé thích thú. Bé thường tự mở
                                        bài
                                        học để xem lại các từ mới và bài hát. Sau một năm học, tôi thấy bé đã có thể nhận
                                        biết
                                        nhiều từ vựng cơ bản và tự tin hơn khi giao tiếp với người nước ngoài.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Hoàng Thị Lan" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/tran-van-hai.jpg') }}"
                                        alt="Avatar Anh Trần Văn Hải" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Anh Trần Văn Hải</h5>
                                        <small class="text-muted">Phụ huynh bé 6 tuổi (mẫu giáo)</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">PSI thật sự là một công cụ hỗ trợ tuyệt vời cho quá
                                        trình học tiếng Anh của con tôi. Con
                                        học ở đây đã gần 3 năm và tôi thấy tiến bộ rõ rệt trong khả năng nghe và nói. Các
                                        giáo
                                        viên rất tận tâm, thường xuyên cập nhật tình hình học tập của con và khuyến khích bé
                                        tham gia các hoạt động ngoại khóa. Tôi thực sự an tâm khi con được học trong một môi
                                        trường chuyên nghiệp như vậy.</span>
                                    <span class="review-full-text" style="display: none;">PSI thật sự là một công cụ hỗ
                                        trợ tuyệt vời cho quá trình học tiếng Anh của con tôi. Con
                                        học ở đây đã gần 3 năm và tôi thấy tiến bộ rõ rệt trong khả năng nghe và nói. Các
                                        giáo
                                        viên rất tận tâm, thường xuyên cập nhật tình hình học tập của con và khuyến khích bé
                                        tham gia các hoạt động ngoại khóa. Tôi thực sự an tâm khi con được học trong một môi
                                        trường chuyên nghiệp như vậy.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Anh Trần Văn Hải" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/nguyen-thi-thuy.png') }}"
                                        alt="Avatar Chị Nguyễn Thị Thủy" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Nguyễn Thị Thủy</h5>
                                        <small class="text-muted">Phụ huynh bé 9 tuổi (tiểu học)</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Con tôi đã học PSI từ năm lớp 1 và đến nay đã được 2
                                        năm. Tôi thấy chương trình học rất
                                        phù hợp với độ tuổi và trình độ của con. Bé đã cải thiện đáng kể khả năng phát âm và
                                        phản xạ tiếng Anh. Hơn nữa, con rất thích tham gia các buổi học nhóm, nơi con có thể
                                        giao tiếp với các bạn khác, giúp con tự tin hơn trong việc sử dụng tiếng Anh hàng
                                        ngày.</span>
                                    <span class="review-full-text" style="display: none;">Con tôi đã học PSI từ năm lớp 1
                                        và đến nay đã được 2 năm. Tôi thấy chương trình học rất
                                        phù hợp với độ tuổi và trình độ của con. Bé đã cải thiện đáng kể khả năng phát âm và
                                        phản xạ tiếng Anh. Hơn nữa, con rất thích tham gia các buổi học nhóm, nơi con có thể
                                        giao tiếp với các bạn khác, giúp con tự tin hơn trong việc sử dụng tiếng Anh hàng
                                        ngày.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Nguyễn Thị Thủy" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/le-van-phong.jpg') }}"
                                        alt="Avatar Anh Lê Văn Phong" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Anh Lê Văn Phong</h5>
                                        <small class="text-muted">Phụ huynh bé 12 tuổi (trung học cơ sở)</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Con tôi đã học PSI từ lớp 4, và hiện tại cháu đã có khả
                                        năng tự tin giao tiếp tiếng Anh.
                                        Điều tôi thích nhất ở PSI là phương pháp học tương tác, không chỉ tập trung vào lý
                                        thuyết mà còn chú trọng vào việc rèn luyện kỹ năng thực tế. Con có thể nghe hiểu các
                                        video tiếng Anh trên YouTube mà không cần phụ đề và thậm chí còn giúp bố mẹ dịch
                                        những
                                        đoạn khó hiểu trong tài liệu tiếng Anh.</span>
                                    <span class="review-full-text" style="display: none;">Con tôi đã học PSI từ lớp 4, và
                                        hiện tại cháu đã có khả năng tự tin giao tiếp tiếng Anh.
                                        Điều tôi thích nhất ở PSI là phương pháp học tương tác, không chỉ tập trung vào lý
                                        thuyết mà còn chú trọng vào việc rèn luyện kỹ năng thực tế. Con có thể nghe hiểu các
                                        video tiếng Anh trên YouTube mà không cần phụ đề và thậm chí còn giúp bố mẹ dịch
                                        những
                                        đoạn khó hiểu trong tài liệu tiếng Anh.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Anh Lê Văn Phong" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/pham-thanh-huong.png') }}"
                                        alt="Avatar Chị Phạm Thanh Hương" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Phạm Thanh Hương</h5>
                                        <small class="text-muted">Phụ huynh bé 15 tuổi (trung học phổ thông)</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Con tôi đã theo học PSI được hơn 3 năm và tôi rất ấn
                                        tượng với kết quả. Các bài học luôn
                                        được cập nhật, sát với chương trình học ở trường và giúp con phát triển toàn diện
                                        các kỹ
                                        năng nghe, nói, đọc, viết. Nhờ đó, con đã đạt được điểm cao trong các kỳ thi tiếng
                                        Anh
                                        và tự tin tham gia các cuộc thi nói tiếng Anh tại trường. PSI cũng tạo ra một môi
                                        trường
                                        học tập thân thiện và khuyến khích con sáng tạo, không chỉ gói gọn trong sách
                                        vở.</span>
                                    <span class="review-full-text" style="display: none;">Con tôi đã theo học PSI được hơn
                                        3 năm và tôi rất ấn tượng với kết quả. Các bài học luôn
                                        được cập nhật, sát với chương trình học ở trường và giúp con phát triển toàn diện
                                        các kỹ
                                        năng nghe, nói, đọc, viết. Nhờ đó, con đã đạt được điểm cao trong các kỳ thi tiếng
                                        Anh
                                        và tự tin tham gia các cuộc thi nói tiếng Anh tại trường. PSI cũng tạo ra một môi
                                        trường
                                        học tập thân thiện và khuyến khích con sáng tạo, không chỉ gói gọn trong sách
                                        vở.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Phạm Thanh Hương" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/hoang-thi-lan.png') }}"
                                        alt="Avatar Chị Phạm Thị Thắm" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Phạm Thị Thắm</h5>
                                        <small class="text-muted">Phụ huynh bé 8 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Sau một thời gian cho bé học 1 kèm 1 với giáo viên tại
                                        PSI, thấy Minh Quân tự tin hơn
                                        hẳn khi giao tiếp bằng tiếng Anh. Cách phát âm, ngữ điệu của con cũng tốt hơn rõ
                                        rệt.
                                        Mỗi buổi học đều rất vui vẻ, khiến con rất hào hứng và chủ động học.</span>
                                    <span class="review-full-text" style="display: none;">Sau một thời gian cho bé học 1
                                        kèm 1 với giáo viên tại PSI, thấy Minh Quân tự tin hơn
                                        hẳn khi giao tiếp bằng tiếng Anh. Cách phát âm, ngữ điệu của con cũng tốt hơn rõ
                                        rệt.
                                        Mỗi buổi học đều rất vui vẻ, khiến con rất hào hứng và chủ động học.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Phạm Thị Thắm" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/tran-van-hai.jpg') }}"
                                        alt="Avatar Chị Ngô Thu Trang" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Ngô Thu Trang</h5>
                                        <small class="text-muted">Phụ huynh bé 7 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Giáo viên rất thân thiện và kiên nhẫn. Con mình lúc đầu
                                        còn nhút nhát, nhưng sau vài
                                        buổi học đã mạnh dạn hơn rất nhiều. Bé bắt đầu giao tiếp tiếng Anh nhanh hơn và còn
                                        chủ
                                        động dùng tiếng Anh ở nhà.</span>
                                    <span class="review-full-text" style="display: none;">Giáo viên rất thân thiện và kiên
                                        nhẫn. Con mình lúc đầu còn nhút nhát, nhưng sau vài
                                        buổi học đã mạnh dạn hơn rất nhiều. Bé bắt đầu giao tiếp tiếng Anh nhanh hơn và còn
                                        chủ
                                        động dùng tiếng Anh ở nhà.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Ngô Thu Trang" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/nguyen-thi-thuy.png') }}"
                                        alt="Avatar Anh Trịnh Đình Anh" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Anh Trịnh Đình Anh</h5>
                                        <small class="text-muted">Phụ huynh bé 9 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Mình rất hài lòng nhất về phương pháp dạy học cá nhân
                                        hóa, phù hợp với khả năng và tính
                                        cách của từng bé. Giáo viên tạo được môi trường học tích cực, giúp con không còn sợ
                                        sai
                                        khi nói tiếng Anh nữa.</span>
                                    <span class="review-full-text" style="display: none;">Mình rất hài lòng nhất về phương
                                        pháp dạy học cá nhân hóa, phù hợp với khả năng và tính
                                        cách của từng bé. Giáo viên tạo được môi trường học tích cực, giúp con không còn sợ
                                        sai
                                        khi nói tiếng Anh nữa.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Anh Trịnh Đình Anh" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/le-van-phong.jpg') }}"
                                        alt="Avatar Chị Đoàn Thị Giang" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Đoàn Thị Giang</h5>
                                        <small class="text-muted">Phụ huynh bé 8 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Mỗi buổi học đều có chủ đề rõ ràng, kết hợp giữa học và
                                        chơi nên con mình học mà như
                                        đang được khám phá điều mới mẻ. Mình thật sự đánh giá cao chất lượng dạy học của PSI
                                        cũng như sự chuyên nghiệp, thân thiện của giáo viên.</span>
                                    <span class="review-full-text" style="display: none;">Mỗi buổi học đều có chủ đề rõ
                                        ràng, kết hợp giữa học và chơi nên con mình học mà như
                                        đang được khám phá điều mới mẻ. Mình thật sự đánh giá cao chất lượng dạy học của PSI
                                        cũng như sự chuyên nghiệp, thân thiện của giáo viên.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Đoàn Thị Giang" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/pham-thanh-huong.png') }}"
                                        alt="Avatar Chị Phạm Minh Ánh" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Phạm Minh Ánh</h5>
                                        <small class="text-muted">Phụ huynh bé 6 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Từ khi học với giáo viên nước ngoài, con mình phát
                                        triển vượt bậc về kỹ năng nghe và
                                        nói. Mình không ngờ bé mới 6 tuổi mà có thể tự tin giới thiệu bản thân bằng tiếng
                                        Anh
                                        như vậy. Cảm ơn trung tâm rất nhiều.</span>
                                    <span class="review-full-text" style="display: none;">Từ khi học với giáo viên nước
                                        ngoài, con mình phát triển vượt bậc về kỹ năng nghe và
                                        nói. Mình không ngờ bé mới 6 tuổi mà có thể tự tin giới thiệu bản thân bằng tiếng
                                        Anh
                                        như vậy. Cảm ơn trung tâm rất nhiều.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Phạm Minh Ánh" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/hoang-thi-lan.png') }}"
                                        alt="Avatar Chị Phạm Thị Hương Giang" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Phạm Thị Hương Giang</h5>
                                        <small class="text-muted">Phụ huynh bé 11 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Trước khi cho con học với giáo viên bản ngữ, mình cũng
                                        khá lo lắng về việc bé có theo
                                        kịp không. Nhưng sau một thời gian, con mình không chỉ học tốt mà còn yêu thích
                                        tiếng
                                        Anh hơn. Giáo viên luôn chú trọng phát triển kỹ năng giao tiếp, giúp con tự tin chia
                                        sẻ
                                        ý tưởng và cảm xúc bằng tiếng Anh.</span>
                                    <span class="review-full-text" style="display: none;">Trước khi cho con học với giáo
                                        viên bản ngữ, mình cũng khá lo lắng về việc bé có theo
                                        kịp không. Nhưng sau một thời gian, con mình không chỉ học tốt mà còn yêu thích
                                        tiếng
                                        Anh hơn. Giáo viên luôn chú trọng phát triển kỹ năng giao tiếp, giúp con tự tin chia
                                        sẻ
                                        ý tưởng và cảm xúc bằng tiếng Anh.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Phạm Thị Hương Giang"
                                            allowfullscreen loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/tran-van-hai.jpg') }}"
                                        alt="Avatar Chị Lê Hải Vân" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Lê Hải Vân</h5>
                                        <small class="text-muted">Phụ huynh bé 13 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Giáo viên rất nhiệt tình, dễ gần và luôn tạo ra không
                                        khí vui vẻ trong mỗi buổi học. Con
                                        mình trước đây rất ngại nói tiếng Anh, nhưng giờ đã tự tin hơn, và thậm chí có thể
                                        tham
                                        gia trò chuyện với các bạn nước ngoài trong các chuyến đi chơi.</span>
                                    <span class="review-full-text" style="display: none;">Giáo viên rất nhiệt tình, dễ gần
                                        và luôn tạo ra không khí vui vẻ trong mỗi buổi học. Con
                                        mình trước đây rất ngại nói tiếng Anh, nhưng giờ đã tự tin hơn, và thậm chí có thể
                                        tham
                                        gia trò chuyện với các bạn nước ngoài trong các chuyến đi chơi.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Lê Hải Vân" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/nguyen-thi-thuy.png') }}"
                                        alt="Avatar Chị Lê Thị Vân Anh" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Lê Thị Vân Anh</h5>
                                        <small class="text-muted">Phụ huynh bé 15 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Phương pháp dạy học của giáo viên bản ngữ ở PSI rất
                                        hiệu quả. Con tôi không chỉ học được
                                        cách nói chuẩn mà còn nâng cao khả năng tư duy bằng tiếng Anh. Bây giờ bé có thể
                                        nghe và
                                        hiểu hầu hết các câu chuyện tiếng Anh mà không cần dịch.</span>
                                    <span class="review-full-text" style="display: none;">Phương pháp dạy học của giáo
                                        viên bản ngữ ở PSI rất hiệu quả. Con tôi không chỉ học được
                                        cách nói chuẩn mà còn nâng cao khả năng tư duy bằng tiếng Anh. Bây giờ bé có thể
                                        nghe và
                                        hiểu hầu hết các câu chuyện tiếng Anh mà không cần dịch.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Lê Thị Vân Anh" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/le-van-phong.jpg') }}"
                                        alt="Avatar Chị Nguyễn Thị Hiền" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Nguyễn Thị Hiền</h5>
                                        <small class="text-muted">Phụ huynh bé 12 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">Bé nhà mình rất thích học với giáo viên nước ngoài. Con
                                        học tiếng Anh mà không cảm thấy
                                        áp lực, thay vào đó là sự thích thú. Mình thấy rõ sự thay đổi trong cách giao tiếp
                                        của
                                        con, bé bây giờ dám nói tiếng Anh một cách bình thường, kể cả ở nhà.</span>
                                    <span class="review-full-text" style="display: none;">Bé nhà mình rất thích học với
                                        giáo viên nước ngoài. Con học tiếng Anh mà không cảm thấy
                                        áp lực, thay vào đó là sự thích thú. Mình thấy rõ sự thay đổi trong cách giao tiếp
                                        của
                                        con, bé bây giờ dám nói tiếng Anh một cách bình thường, kể cả ở nhà.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Nguyễn Thị Hiền" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-card">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('/public/assets/images/img-reviews/pham-thanh-huong.png') }}"
                                        alt="Avatar Chị Trịnh Kim Liên" class="review-avatar me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold">Chị Trịnh Kim Liên</h5>
                                        <small class="text-muted">Phụ huynh bé 10 tuổi</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3 review-text-container" style="min-height: 170px;">
                                    <span class="review-short-text">PSI đã giúp con mình cải thiện khả năng tiếng Anh một
                                        cách toàn diện. Con học được rất
                                        nhiều từ các giáo viên bản ngữ, không chỉ về ngữ pháp mà còn về cách giao tiếp hiệu
                                        quả
                                        trong các tình huống thực tế. Mình thấy rõ sự tiến bộ từng ngày.</span>
                                    <span class="review-full-text" style="display: none;">PSI đã giúp con mình cải thiện
                                        khả năng tiếng Anh một cách toàn diện. Con học được rất
                                        nhiều từ các giáo viên bản ngữ, không chỉ về ngữ pháp mà còn về cách giao tiếp hiệu
                                        quả
                                        trong các tình huống thực tế. Mình thấy rõ sự tiến bộ từng ngày.</span>
                                    <button class="btn btn-link p-0 read-more-btn">Xem thêm</button>
                                </p>
                                <div class="video-wrapper youtube-thumbnail">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Đánh giá từ Chị Trịnh Kim Liên" allowfullscreen
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Đánh giá từ chuyên gia -->
    {{-- <section class="section bg-white py-5" id="expert-review"
        style="background-image: url({{ asset('assets/images/icon/Background_Expert.png') }}); background-size: cover">
        <div class="container text-center px-3">
            <div class="section-title mb-5">
                <h2 class="text-accent">Đánh giá từ chuyên gia</h2>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <div class="ratio ratio-16x9 position-relative overflow-hidden rounded shadow">
                        <video id="expertReviewVideo" preload="metadata" class="w-100 h-100" muted playsinline>
                            <source src="{{ asset('assets/images/Kazuki.mov') }}" type="video/quicktime">
                            <source src="{{ asset('assets/images/Kazuki.mp4') }}" type="video/mp4">
                            Trình duyệt của bạn không hỗ trợ thẻ video.
                        </video>
                        <button id="toggleVolumeButton"
                            class="btn btn-dark btn-sm position-absolute bottom-0 end-0 m-3 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; background-color: rgba(0,0,0,0.6); border: none;"
                            aria-label="Bật/Tắt âm thanh video">
                            <i class="bi bi-volume-mute-fill text-white fs-5"></i> 
                        </button>
                    </div>
                    <blockquote class="blockquote text-center text-md-center mt-3">
                        <footer class="blockquote-footer mt-2">Kazuki Yoshida – CEO CLASSARA INC.</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Các Bước Đăng Ký Học -->
    <section id="steps" class="section text-center bg-primary py-5">
        <div class="container px-2 px-md-4">
            <div class="section-title mb-4">
                <h2 class="text-accent">Các Bước Đăng Ký</h2>
            </div>

            <div class="accordion accordion-flush" id="registerSteps">

                <div class="accordion-item rounded mb-3 shadow-sm">
                    <h2 class="accordion-header" id="step1">
                        <button class="accordion-button fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            <span class="register-number">01</span>
                            <strong class="text-step-register ps-4 ps-sm-5">
                                Đăng ký làm thành viên
                            </strong>
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show bg-primary" aria-labelledby="step1"
                        data-bs-parent="#registerSteps">
                        <div class="accordion-body text-start">
                            <div class="row g-4">
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <img class="img-fluid" src="{{ asset('/public/assets/images/icon/register.png') }}"
                                        alt="Đăng ký thành viên">
                                </div>
                                <div class="col-12 col-md-8">
                                    <p class="text-section-register">
                                        Đầu tiên, ba mẹ sẽ giúp con điền một vài thông tin cơ bản như tên, giới tính và ngày
                                        sinh.
                                        Việc này giúp giáo viên hiểu rõ hơn về con để hướng dẫn phù hợp. Sau bước này, con
                                        chính
                                        thức trở thành thành viên nhí của ngôi nhà học tập PSI!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item rounded mb-3 shadow-sm">
                    <h2 class="accordion-header" id="step2">
                        <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <span class="register-number">02</span>
                            <strong class="text-step-register ps-4 ps-sm-5">
                                Tham gia buổi học thử miễn phí
                            </strong>
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse bg-primary" aria-labelledby="step2"
                        data-bs-parent="#registerSteps">
                        <div class="accordion-body text-start">
                            <div class="row g-4">
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <img class="img-fluid"
                                        src="{{ asset('/public/assets/images/icon/participate.png') }}"
                                        alt="Giáo viên chất lượng">
                                </div>
                                <div class="col-12 col-md-8">
                                    <p class="text-section-register">
                                        Con sẽ tham gia một buổi học thử hoàn toàn miễn phí để làm quen với giáo viên và
                                        phương pháp
                                        học. Đây là cơ hội tuyệt vời để con cảm nhận môi trường học tập trước khi chính thức
                                        bắt
                                        đầu.
                                        <br><br>
                                        <i class="fas fa-check-circle text-success me-2"></i> <strong>10.000+ giáo viên
                                            toàn cầu: Việt Nam, Philippines, bản xứ.</strong>
                                        <br>
                                        <i class="fas fa-check-circle text-success me-2"></i> <strong>Trình độ đại học trở
                                            lên, sở hữu chứng chỉ quốc tế (TESOL, TEFL, CELTA...).</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item rounded mb-3 shadow-sm">
                    <h2 class="accordion-header" id="step3">
                        <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <span class="register-number">03</span>
                            <strong class="text-step-register ps-4 ps-sm-5">
                                Góp ý & Điều chỉnh
                            </strong>
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse bg-primary" aria-labelledby="step3"
                        data-bs-parent="#registerSteps">
                        <div class="accordion-body text-start">
                            <div class="row g-4">
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <img class="img-fluid" src="{{ asset('/public/assets/images/icon/adjust.png') }}"
                                        alt="Công nghệ hiện đại">
                                </div>
                                <div class="col-12 col-md-8">
                                    <p class="text-section-register">
                                        Sau buổi học thử, nếu cần điều chỉnh thời gian, giáo viên hoặc phương pháp học, ba
                                        mẹ chỉ
                                        cần liên hệ – chúng tôi luôn lắng nghe và hỗ trợ để con có trải nghiệm học tập tốt
                                        nhất.
                                        <br><br>
                                        <i class="fas fa-check-circle text-success me-2"></i> <strong>Hệ thống học tập cá
                                            nhân hóa.</strong>
                                        <br>
                                        <i class="fas fa-check-circle text-success me-2"></i> <strong>Báo cáo tiến độ chi
                                            tiết.</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item rounded mb-3 shadow-sm">
                    <h2 class="accordion-header" id="step4">
                        <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <span class="register-number">04</span>
                            <strong class="text-step-register ps-4 ps-sm-5">
                                Chọn khóa học phù hợp
                            </strong>
                        </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse bg-primary" aria-labelledby="step4"
                        data-bs-parent="#registerSteps">
                        <div class="accordion-body text-start">
                            <div class="row g-4">
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <img class="img-fluid" src="{{ asset('/public/assets/images/icon/choose.png') }}"
                                        alt="Góp ý và điều chỉnh">
                                </div>
                                <div class="col-12 col-md-8">
                                    <p class="text-section-register">
                                        Ba mẹ cùng con lựa chọn khóa học phù hợp theo mục tiêu và thời lượng mong muốn.
                                        Chúng tôi
                                        cung cấp nhiều gói học linh hoạt và đa dạng, phù hợp với mọi nhu cầu.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item rounded mb-3 shadow-sm">
                    <h2 class="accordion-header" id="step5">
                        <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <span class="register-number">05</span>
                            <strong class="text-step-register ps-4 ps-sm-5">
                                Thanh toán và bắt đầu hành trình
                            </strong>
                        </button>
                    </h2>
                    <div id="collapse5" class="accordion-collapse collapse bg-primary" aria-labelledby="step5"
                        data-bs-parent="#registerSteps">
                        <div class="accordion-body text-start">
                            <div class="row g-4">
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <img class="img-fluid" src="{{ asset('/public/assets/images/icon/payment.png') }}"
                                        alt="Chọn khóa học">
                                </div>
                                <div class="col-12 col-md-8">
                                    <p class="text-section-register">
                                        Sau khi chọn khóa học, ba mẹ tiến hành thanh toán học phí. Ngay sau đó, lịch học và
                                        tài liệu
                                        sẽ được gửi đến để con sẵn sàng bắt đầu hành trình học tập đầy cảm hứng!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Tin tức -->
    <section id="news" class="section py-5 bg-white">
        <div class="section-title mb-5">
            <h2 class="text-accent">Tin tức & Bài viết</h2>
        </div>
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @if ($posts->isNotEmpty())
                            @foreach ($posts as $post)
                                <div class="swiper-slide">
                                    {{-- Thẻ kích hoạt modal với tất cả dữ liệu cần thiết --}}
                                    <div class="review-card news-card-trigger" data-bs-toggle="modal"
                                        data-bs-target="#newsDetailModal" data-post-id="{{ $post->id }}"
                                        data-post-title="{{ $post->title }}"
                                        data-post-image="{{ asset($post->image) }}"
                                        data-post-date="{{ $post->created_at->format('d/m/Y') }}"
                                        data-post-content="{{ str_replace(["\r\n", "\r", "\n"], '', htmlspecialchars($post->content)) }}"
                                        {{-- RẤT QUAN TRỌNG --}} style="cursor: pointer;">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    {{-- Hình ảnh bài viết --}}
                                                    <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                                                        class="img-thumbnail w-100 mb-3">
                                                    {{-- Tiêu đề bài viết --}}
                                                    <h5 class="card-title">{{ $post->title }}</h5>
                                                    {{-- Mô tả ngắn bài viết --}}
                                                    <p class="card-text">
                                                        {{ Str::limit($post->short_description ?? $post->excerpt, 120) }}
                                                    </p>
                                                    <div class="text-end">
                                                        {{-- Ngày đăng bài viết --}}
                                                        <time class="text-muted small"
                                                            datetime="{{ $post->created_at->format('Y-m-d') }}">
                                                            {{ $post->created_at->format('d/m/Y') }}
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <p class="text-center text-muted">Chưa có bài viết nào để hiển thái.</p>
                            </div>
                        @endif
                    </div>

                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="newsDetailModal" tabindex="-1" aria-labelledby="newsDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsDetailModalLabel">Chi tiết bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Nội dung bài viết sẽ được load vào đây bằng JavaScript từ data attributes --}}
                    <div class="text-center mb-4">
                        <img id="modalPostImage" src="" alt="Hình ảnh bài viết"
                            class="img-fluid rounded w-75">
                    </div>
                    <h3 id="modalPostTitle" class="mb-3"></h3>
                    <p class="text-muted small mb-3">Ngày đăng: <span id="modalPostDate"></span></p>
                    <div id="modalPostBody" class="modal-post-body">
                        {{-- Nội dung đầy đủ của bài viết --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-light py-5 mt-5 border-top">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 col-12">
                    <div class="row g-4">

                        <!-- Cột 1: Thông tin công ty và logo -->
                        <div class="col-lg-8 col-md-6 col-12">
                            <div class="footer-info">
                                <img src="{{ asset('/public/assets/images/icon/logo.png') }}" alt="Logo Công Ty"
                                    class="footer-logo-img mb-3" style="max-width: 150px; height: auto;">
                                <h5 class="fw-bold mb-3 text-primary">CÔNG TY TNHH CLASSARA INC</h5>
                                <ul class="list-unstyled text-secondary small">
                                    <li class="mb-2">
                                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Địa chỉ: Số 22, ngõ 114/18,
                                        Tân
                                        Phong,
                                        Thụy Phương, Q.Bắc Từ Liêm, Hà Nội
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-phone-fill me-2 text-primary"></i>Hotline: +84 583 874 241
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-envelope-fill me-2 text-primary"></i>Email: info@classara.com
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-globe me-2 text-primary"></i>Website: <a
                                            href="https://www.psi.edu.vn"
                                            class="text-secondary text-decoration-none">www.psi.edu.vn</a>
                                    </li>
                                </ul>
                                <div class="footer-seal mt-4">
                                    <!-- <img class="img-fluid" src="./asset/moc.png" alt="Mộc Công Ty" style="max-width: 120px;"> -->
                                </div>
                            </div>
                        </div>

                        <!-- Cột 2: Liên kết nhanh -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <h5 class="fw-bold mb-3">Liên kết nhanh</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Giới
                                        thiệu</a></li>
                                <li class="mb-2">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal"
                                        class="text-secondary text-decoration-none">Chính sách</a>
                                </li>
                                <li class="mb-2"><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#termModal" class="text-secondary text-decoration-none">Điều
                                        khoản</a></li>
                                <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Thành
                                        tựu</a>
                                </li>
                                <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Học
                                        viên
                                        nói
                                        về chúng tôi</a></li>
                                <li class="mb-2"><a href="#expert-review"
                                        class="text-secondary text-decoration-none">Đánh
                                        giá từ
                                        chuyên gia</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Cột 3: Khóa học -->
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-3 col-12">
                            <h5 class="fw-bold mb-3">Khóa học</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Khóa
                                        học
                                        trẻ
                                        em</a></li>
                                <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Khóa
                                        học
                                        chứng chỉ</a></li>
                            </ul>
                        </div>

                        <!-- Cột 4: Mạng xã hội -->
                        <div class="col-lg-8 col-md-12">
                            <h5 class="fw-bold mb-3">Mạng xã hội</h5>
                            <div class="d-flex flex-wrap gap-3 social-icons">
                                @php
                                    $socialLinks = [];
                                    foreach ($settings as $setting) {
                                        if (
                                            in_array($setting->setting_key, [
                                                'youtube',
                                                'zalo',
                                                'instagram',
                                                'facebook',
                                                'tiktok',
                                            ])
                                        ) {
                                            $socialLinks[$setting->setting_key] = $setting->plain_value;
                                        }
                                    }
                                    $youtubeLink = $socialLinks['youtube'] ?? '#';
                                    $zaloLink = $socialLinks['zalo'] ?? '#';
                                    $instagramLink = $socialLinks['instagram'] ?? '#';
                                    $facebookLink = $socialLinks['facebook'] ?? '#';
                                    $tiktokLink = $socialLinks['tiktok'] ?? '#';
                                @endphp

                                <a href="{{ $youtubeLink }}" target="_blank" class="social-icon-link">
                                    <img src="{{ asset('/public/assets/images/icon/youtube.svg') }}" alt="YouTube"
                                        class="social-icon">
                                </a>
                                <a href="{{ $zaloLink }}" target="_blank" class="social-icon-link">
                                    <img src="{{ asset('/public/assets/images/icon/zalo.svg') }}" alt="Zalo"
                                        class="social-icon">
                                </a>
                                <a href="{{ $instagramLink }}" target="_blank" class="social-icon-link">
                                    <img src="{{ asset('/public/assets/images/icon/instagram.svg') }}" alt="Instagram"
                                        class="social-icon">
                                </a>
                                <a href="{{ $facebookLink }}" target="_blank" class="social-icon-link">
                                    <img src="{{ asset('/public/assets/images/icon/facebook.svg') }}" alt="Facebook"
                                        class="social-icon">
                                </a>
                                <a href="{{ $tiktokLink }}" target="_blank" class="social-icon-link">
                                    <img src="{{ asset('/public/assets/images/icon/tiktok.svg') }}" alt="Tiktok"
                                        class="social-icon">
                                </a>
                            </div>
                        </div>

                        <div class="responsive-iframe-wrapper">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3722.7830304219815!2d105.76462157471578!3d21.08132628597213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134550028c34469%3A0xd75ca8465120818f!2sC%C3%94NG%20TY%20TNHH%20Classara%20Inc!5e0!3m2!1svi!2s!4v1753694195762!5m2!1svi!2s"
                                width="100%" height="100%" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Đường kẻ ngang -->
            <hr class="border-secondary my-4">
            <!-- Bản quyền -->
            <div class="text-center text-secondary small">
                <p class="mb-0">&copy; 2025 PSI Education. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Modal: Login -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-3" placeholder="Email">
                    <input type="password" class="form-control mb-3" placeholder="Mật khẩu">
                    <button type="button" class="btn btn-accent w-100">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Register -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-3" placeholder="Họ và tên">
                    <input class="form-control mb-3" placeholder="Email">
                    <input type="password" class="form-control mb-3" placeholder="Mật khẩu">
                    <button type="button" class="btn btn-accent w-100">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ebookDropdown = document.getElementById('ebookDropdown');
            const ebookDropdownToggle = document.getElementById('ebookDropdownToggle');
            const ebookDropDownMenu = document.getElementById('ebookDropDownMenu');
            ebookDropdownToggle.addEventListener('click', function(event) {
                event.preventDefault();
                ebookDropDownMenu.classList.toggle('show');
                ebookDropdown.classList.toggle('show');
            });
        });
    </script>
@endsection
