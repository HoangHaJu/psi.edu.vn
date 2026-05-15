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
