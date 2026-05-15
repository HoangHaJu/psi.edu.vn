<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="container-fluid">
                    <div class="row justify-content-center modal-content-area">
                        <div class="col-xl-7 d-xl-block d-none modal-background-image">
                        </div>
                        <div class="col-xl-5 col-12 mt-4 d-flex flex-column justify-content-center align-items-center"
                            id="loginForm">
                            <x-form :action="route('admin.auth.post')" type="post" :validate="true" class="w-100"> @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('Email hoặc số điện thoại') }}</label>
                                    <x-input name="identifier" :required="true" autocomplete="username"
                                        placeholder="{{ __('Nhập email hoặc số điện thoại') }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('Mật khẩu') }}</label>
                                    <x-input-password name="password" :required="true"
                                        autocomplete="current-password" />
                                    <p class="mt-3">
                                        <a href="#" id="showForgotPasswordForm">{{ __('Quên mật khẩu?') }}</a>
                                    </p>
                                </div>
                                <div class="form-footer text-center">
                                    <button type="submit" class="btn btn-primary my-2">{{ __('Đăng nhập') }}</button>
                                    <p class="text-center">
                                        {{ __('Chưa có tài khoản?') }} <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#registerModal"
                                            id="openRegisterModal">{{ __('Đăng kí tại đây') }}</a>
                                    </p>
                                </div>
                            </x-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    {{-- Giữ style="max-width: 95%;" và xử lý responsive bằng CSS --}}
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="container-fluid">
                    <div class="row modal-content-area">
                        <div class="col-xl-7 d-xl-block d-none modal-background-image">
                        </div>
                        <div class="col-xl-5 col-12 mt-4 d-flex flex-column justify-content-center align-items-center p-4"
                            id="registerForm">
                            <h2 class="mb-4 text-center">{{ __('Đăng ký tài khoản') }}</h2>
                            <x-form :action="route('admin.auth.register')" type="post" :validate="true" class="w-100"> @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('Họ và tên') }}</label>
                                    <x-input name="fullname" :required="true" placeholder="{{ __('Nhập họ và tên') }}"
                                        autocomplete="name" />
                                </div>
                                <div class="mb-3">
                                    <label class="control-label fw-bold">{{ __('Ngày sinh') }}:</label>
                                    <x-input type="date" name="birthday" :value="old('birthday')" :required="true"
                                        autocomplete="bday" />
                                </div>
                                <div class="mb-3">
                                    <label class="control-label" style="font-weight:600;">{{ __('Email') }}:</label>
                                    <x-input name="email" :value="old('email')"
                                        placeholder="{{ __('Nhập địa chỉ email') }}" autocomplete="email" />
                                </div>
                                <div class="mb-3">
                                    <label class="control-label fw-bold">{{ __('Số điện thoại') }}:</label>
                                    <x-input-phone name="phone" :value="old('phone')" :required="true"
                                        placeholder="{{ __('Nhập số điện thoại') }}" autocomplete="tel" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('Giới tính') }}:</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="genderMale" value="1" checked>
                                            <label class="form-check-label"
                                                for="genderMale">{{ __('Nam') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="genderFemale" value="2">
                                            <label class="form-check-label"
                                                for="genderFemale">{{ __('Nữ') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('Ghi chú') }}:</label>
                                    <textarea class="form-control" name="note" rows="3"
                                        placeholder="{{ __('Nhập các ghi chú của bạn (tùy chọn)') }}"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('Mật khẩu') }}</label>
                                    <x-input-password name="password" :required="true"
                                        placeholder="{{ __('Nhập mật khẩu') }}" autocomplete="new-password" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('Lặp lại mật khẩu') }}</label>
                                    <x-input-password name="password_confirmation" :required="true"
                                        placeholder="{{ __('Nhập lại mật khẩu') }}" autocomplete="new-password" />
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-start align-items-center mb-2">
                                        <input id="is_teacher" type="checkbox" name="is_teacher" value="1"
                                            class="form-check-input me-2">
                                        <label for="is_teacher"
                                            class="form-check-label">{{ __('Tôi là giáo viên') }}</label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="d-flex justify-content-center mt-3">
                                        <input id="check" checked type="checkbox" name="terms_accepted"
                                            class="form-check-input">
                                        <label for="check" class="form-check-label px-1">
                                            {{ __('Tôi đồng ý với ') }}
                                            <a class="fst-italic" href="#" data-bs-toggle="modal"
                                                data-bs-target="#termModal">Điều khoản</a>
                                            <span class="text-black">và</span>
                                            <a class="fst-italic" href="#" data-bs-toggle="modal"
                                                data-bs-target="#privacyModal"> Chính sách bảo
                                                mật</a>
                                        </label>
                                    </div>
                                    <input type="hidden" value="1" name="is_active">
                                    <button type="submit"
                                        class="btn btn-primary my-2 px-5">{{ __('Đăng ký') }}</button>
                                    <p class="mt-3 text-center">
                                        {{ __('Đã có tài khoản?') }} <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#loginModal"
                                            id="openLoginModal">{{ __('Đăng nhập tại đây') }}</a>
                                    </p>
                                </div>
                            </x-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        /* Các biến màu sắc và font đã có của bạn (đảm bảo chúng được định nghĩa ở đây hoặc ở file CSS gốc) */
        --border-radius-md: 0.5rem;
        --modal-fade-width: 30%;
        --modal-background-color: #ffffff;
    }

    .btn-outline-custom {
        color: #ffdfab;
        border: 1px solid #ffdfab;
        background-color: transparent;
        transition: all 0.2s ease-in-out;
        /* Thêm transition để hover mượt mà */
    }

    label.form-label.fw-bold::after,
    label.control-label.fw-bold::after {
        content: " *";
        color: red;
        vertical-align: super;
        font-size: 0.8em;
        margin-left: 2px;
    }

    .btn-outline-custom:hover,
    .btn-outline-custom:focus {
        color: #fff;
        background-color: #ffdfab;
        border-color: #ffdfab;
    }

    .modal-background-image {
        background-image: url('{{ asset('assets/images/img_login.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-top-left-radius: var(--border-radius-md);
        border-bottom-left-radius: var(--border-radius-md);
        position: relative;
        overflow: hidden;
    }

    .modal-background-image::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: var(--modal-fade-width);
        /* Sử dụng biến */
        height: 100%;
        /* Sử dụng biến màu nền của modal để khớp hoàn hảo */
        background: linear-gradient(to right,
                rgba(var(--modal-background-color-rgb, 255, 255, 255), 0) 0%,
                /* Transparent at the start */
                rgba(var(--modal-background-color-rgb, 255, 255, 255), 1) 100%
                /* Solid at the end */
            );
        /* Lưu ý: Bạn cần định nghĩa --modal-background-color-rgb nếu muốn dùng RGB */
        z-index: 1;
    }

    /* Fallback for --modal-background-color-rgb if not defined */
    :root {
        --modal-background-color-rgb: 255, 255, 255;
        /* Default to white RGB if not set elsewhere */
    }

    /* Responsive styles for modal dialog and row height */
    @media (max-width: 1199.98px) {

        /* Cho các màn hình nhỏ hơn XL (bao gồm mobile) */
        .modal-dialog {
            max-width: 95% !important;
            /* Đảm bảo modal chiếm 95% chiều rộng trên mobile */
            margin: 0.5rem auto;
            /* Tùy chỉnh margin cho mobile */
        }

        .modal-dialog .row.modal-content-area {
            height: auto !important;
            /* Bỏ chiều cao cố định */
            /* min-height: 25rem; */
            /* Chiều cao tối thiểu cho nội dung login */
            max-height: 85vh;
            /* Giới hạn chiều cao tối đa theo viewport height */
            overflow-y: auto;
            /* Cho phép cuộn nếu nội dung tràn */
            display: block;
            /* Đảm bảo các col xếp chồng theo mặc định của Bootstrap */
        }

        /* Điều chỉnh riêng cho form đăng ký vì nó thường dài hơn */
        #registerModal .modal-content-area {
            min-height: 35rem;
            /* Tăng min-height cho form đăng ký trên mobile */
        }

        /* Ẩn ảnh nền trên mobile */
        .modal-background-image {
            display: none !important;
        }
    }

    @media (min-width: 1200px) {

        /* Cho màn hình XL (desktop) trở lên */
        .modal-dialog {
            /* Bootstrap modal-xl mặc định có max-width 1140px, nên có thể không cần max-width: 95% */
            /* hoặc bạn có thể đặt một giá trị cố định nếu muốn tùy chỉnh */
            max-width: 1140px;
            /* Hoặc giá trị bạn mong muốn cho desktop */
        }

        .modal-dialog .row.modal-content-area {
            height: 25rem;
            /* Chiều cao cố định cho login modal trên desktop */
            min-height: auto;
            /* Bỏ min-height */
            max-height: none;
            /* Bỏ max-height */
            overflow-y: visible;
            /* Bỏ cuộn */
        }

        #registerModal .modal-content-area {
            height: 43rem;
            /* Chiều cao cố định cho register modal trên desktop */
        }
    }

    .custom-blur-content {
        /* Đảm bảo nền của modal content là màu đặc để hiệu ứng làm mờ không bị nhìn xuyên qua */
        background-color: rgb(105, 105, 105);
        transition: filter 0.3s ease-in-out;
    }

    .modal.fade:not(.show) .custom-blur-content {
        filter: none;
        /* Bỏ làm mờ khi modal không hiển thị */
    }
</style>
@push('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Khởi tạo các Modal Bootstrap instances ---
            const loginModalElement = document.getElementById('loginModal');
            const registerModalElement = document.getElementById('registerModal');
            const termModalElement = document.getElementById('termModal');
            const privacyModalElement = document.getElementById('privacyModal');

            let loginModal = loginModalElement ? new bootstrap.Modal(loginModalElement) : null;
            let registerModal = registerModalElement ? new bootstrap.Modal(registerModalElement) : null;
            // KHÔNG CÓ backdrop: false ở đây, để mỗi modal tự quản lý backdrop của nó
            let termModal = termModalElement ? new bootstrap.Modal(termModalElement) : null;
            let privacyModal = privacyModalElement ? new bootstrap.Modal(privacyModalElement) : null;

            // --- Lấy các phần tử DOM cho các form và liên kết ---
            const openRegisterModalLink = document.getElementById('openRegisterModal');
            const openLoginModalLink = document.getElementById('openLoginModal');
            const showForgotPasswordFormLink = document.getElementById('showForgotPasswordForm');
            const cancelForgotPasswordFormButton = document.getElementById('cancelForgotPasswordForm');
            const loginForm = document.getElementById('loginForm');
            const forgotPasswordForm = document.getElementById('forgotPasswordForm');
            const registerFormElement = document.querySelector('#registerForm form');
            const termsCheckbox = document.getElementById("check");

            // Lấy các liên kết mở modal con
            const termLink = document.querySelector('#registerForm a[data-bs-target="#termModal"]');
            const privacyLink = document.querySelector('#registerForm a[data-bs-target="#privacyModal"]');

            // Lấy các nút quay lại từ modal con (đã thêm vào HTML)
            const backToRegisterModalFromTermButton = document.getElementById('backToRegisterModalFromTerm');
            const backToRegisterModalFromPrivacyButton = document.getElementById('backToRegisterModalFromPrivacy');


            // --- Chức năng chuyển đổi giữa Login Modal và Register Modal ---
            function setupModalSwitching() {
                if (openRegisterModalLink && loginModal && registerModal) {
                    openRegisterModalLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        loginModal.hide();
                        registerModal.show();
                    });
                }

                if (openLoginModalLink && loginModal && registerModal) {
                    openLoginModalLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        registerModal.hide();
                        loginModal.show();
                    });
                }
            }

            // --- Chức năng chuyển đổi giữa Login Form và Forgot Password Form ---
            function setupPasswordRecoveryForms() {
                if (showForgotPasswordFormLink && loginForm && forgotPasswordForm) {
                    showForgotPasswordFormLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        loginForm.style.display = 'none';
                        forgotPasswordForm.style.display = 'block';
                    });
                }

                if (cancelForgotPasswordFormButton && loginForm && forgotPasswordForm) {
                    cancelForgotPasswordFormButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        loginForm.style.display = 'block';
                        forgotPasswordForm.style.display = 'none';
                    });
                }
            }

            // --- Xử lý việc gửi form đăng ký và kiểm tra điều khoản ---
            function setupRegisterFormValidation() {
                if (registerFormElement && termsCheckbox) {
                    registerFormElement.addEventListener("submit", function(event) {
                        if (!termsCheckbox.checked) {
                            event.preventDefault(); // Ngăn chặn submit form
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: "Bạn phải đồng ý với điều khoản!",
                                    icon: "warning",
                                    draggable: true
                                });
                            } else {
                                alert("Bạn phải đồng ý với điều khoản!");
                            }
                        }
                    });
                }
            }

            // --- Xử lý mở và quay lại từ modal lồng nhau (Term Modal và Privacy Modal) ---
            function setupNestedModalNavigation() {
                // Khi click vào link "Điều khoản" từ Register Modal
                if (termLink && termModal && registerModal) {
                    termLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        registerModal.hide(); // Ẩn modal đăng ký
                        termModal.show(); // Hiển thị modal điều khoản
                    });
                }

                // Khi click vào link "Chính sách bảo mật" từ Register Modal
                if (privacyLink && privacyModal && registerModal) {
                    privacyLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        registerModal.hide(); // Ẩn modal đăng ký
                        privacyModal.show(); // Hiển thị modal chính sách bảo mật
                    });
                }

                // Khi click nút "Quay lại" từ Term Modal
                if (backToRegisterModalFromTermButton && termModal && registerModal) {
                    backToRegisterModalFromTermButton.addEventListener('click', function() {
                        termModal.hide(); // Ẩn modal điều khoản
                        registerModal.show(); // Hiển thị lại modal đăng ký
                    });
                }

                // Khi click nút "Quay lại" từ Privacy Modal
                if (backToRegisterModalFromPrivacyButton && privacyModal && registerModal) {
                    backToRegisterModalFromPrivacyButton.addEventListener('click', function() {
                        privacyModal.hide(); // Ẩn modal chính sách bảo mật
                        registerModal.show(); // Hiển thị lại modal đăng ký
                    });
                }

                // Xử lý khi Term Modal hoặc Privacy Modal đóng bằng nút X hoặc click ra ngoài
                // Chúng ta cần đảm bảo khi chúng đóng, registerModal được show lại
                if (termModalElement && registerModal) {
                    termModalElement.addEventListener('hidden.bs.modal', function() {
                        // Chỉ show lại registerModal nếu nó không phải đang hiển thị
                        // để tránh lỗi backdrop
                        if (!registerModalElement.classList.contains('show')) {
                            registerModal.show();
                        }
                    });
                }

                if (privacyModalElement && registerModal) {
                    privacyModalElement.addEventListener('hidden.bs.modal', function() {
                        if (!registerModalElement.classList.contains('show')) {
                            registerModal.show();
                        }
                    });
                }
            }

            // --- LOGIC BỔ SUNG: Xóa tất cả backdrops khi registerModal đóng ---
            // Đây là phần cốt lõi để giải quyết vấn đề của bạn.
            if (registerModalElement) {
                registerModalElement.addEventListener('hidden.bs.modal', function() {
                    // Đợi một chút để Bootstrap hoàn tất các thao tác của nó,
                    // sau đó mới xóa các backdrops còn sót lại.
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => backdrop.remove());
                        // Đảm bảo class modal-open cũng bị xóa khỏi body
                        document.body.classList.remove('modal-open');
                    }, 100); // Khoảng thời gian nhỏ (ví dụ 100ms) có thể giúp
                    // Bootstrap hoàn tất transitions của nó.
                });
            }


            // --- Gọi các chức năng khi DOM đã tải xong ---
            setupModalSwitching();
            setupPasswordRecoveryForms();
            setupRegisterFormValidation();
            setupNestedModalNavigation();
        });
    </script>
@endpush
