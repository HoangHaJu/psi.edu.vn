<style>
    .notification {
        padding: 0.75rem 1.5rem;
        /* Padding for notification items */
        position: relative;
        /* Positioning for overlapping effect */
        border-bottom: 1px solid #e9ecef;
        /* Optional: Line separator */
    }

    #notification-dropdown {
        max-height: 350px;
        /* Giới hạn chiều cao dropdown */
        overflow-y: auto;
        scrollbar-width: thin;
        /* Làm scrollbar nhỏ gọn (Firefox) */
    }

    /* Tùy chọn: làm scrollbar đẹp hơn (Chrome, Edge, Safari) */
    #notification-dropdown::-webkit-scrollbar {
        width: 6px;
    }

    #notification-dropdown::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    #notification-dropdown::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    .dropdown-title {
        font-size: 0.9rem;
        /* Title font size */
        font-weight: 600;
        /* Title font weight */
        margin-bottom: 0.25rem;
        /* Space between title and message */
    }

    .dropdown-message {
        font-size: 0.8rem;
        /* Message font size */
        color: #fff;
        /* Message color */
        margin-bottom: 0;
        /* No margin at the bottom */
    }

    /* Overlapping effect for notification items */
    .notification:not(:last-child) {
        margin-bottom: -1.5rem;
        /* Adjust negative margin to overlap notifications */
    }

    /* Optional hover effect */
    .notification:hover {
        /* Light hover background */
        cursor: pointer;
        /* Pointer on hover */
    }

    .btn-doc {
        background: linear-gradient(135deg, #ffffff, #ff4d4d);
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .btn-doc:hover {
        background: linear-gradient(135deg, #ffcccc, #ff0000);
        color: #fff;
    }

    .icon-book {
        margin-right: 8px;
        font-size: 1.2em;
    }

    .ti-book {
        font-size: 1.5em;
    }

    .icon-bell {
        font-size: 1.5em;
        color: #333;
        right: -3em;
        transition: color 0.3s ease;
    }

    .icon-bell:hover {
        color: #ff4d4d;
    }

    .icon-bell .badge {
        font-size: 0.7em;
        right: 2em !important;
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none bg-topbar">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="multi-language" class="navbar-nav flex-row me-auto">
            @include('admin.layouts.partials.multi-language')
        </div>

        <div id="notification-icon" class="navbar-nav order-md-last flex-row">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="icon-bell position-relative">
                        <i class="ti ti-bell me-5"></i>
                        <span id="notification-badge"
                            class="badge bg-danger rounded-pill position-absolute translate-middle top-0 d-none"></span>
                    </span>
                </a>
                <div id="notification-dropdown" class="dropdown-menu dropdown-menu-end">
                </div>
            </div>
            @include('admin.layouts.partials.account')
        </div>
        <div class="navbar-collapse collapse" id="navbar-menu">
        </div>
    </div>
</header>
@push('custom-js')
    <script>
        $(document).ready(function() {
            // Hàm để lấy thông báo
            function fetchNotifications() {
                $.ajax({
                    url: "{{ route('admin.notification.getAllNotificationAdmin') }}",
                    method: "GET",
                    success: function(response) {
                        if (response.status === 200) {
                            const notifications = response.data || [];
                            const count = notifications.length;

                            // Cập nhật số lượng trên badge
                            if (count > 0) {
                                const badgeText = count > 9 ? '9+' : count;
                                $('#notification-badge')
                                    .text(badgeText)
                                    .removeClass('d-none')
                                    .show();
                            } else {
                                $('#notification-badge')
                                    .addClass('d-none')
                                    .hide();
                            }

                            // Xóa nội dung cũ của dropdown
                            $('#notification-dropdown').empty();

                            if (count === 0) {
                                $('#notification-dropdown').append(
                                    '<div class="dropdown-item text-center text-muted">Không có thông báo</div>'
                                );
                                return;
                            }

                            // Thêm từng thông báo vào dropdown
                            notifications.forEach(notification => {
                                const isRead = notification.read_at !== null;
                                const bgColor = isRead ? 'bg-light' : 'bg-white';
                                const textColor = 'text-dark';
                                const badge = isRead ?
                                    '<span class="badge bg-success ms-2">Đã đọc</span>' :
                                    '<span class="badge bg-danger ms-2">Chưa đọc</span>';

                                const receivedAt = new Date(notification.created_at)
                                    .toLocaleString('vi-VN');
                                const readAt = notification.read_at ?
                                    new Date(notification.read_at).toLocaleString('vi-VN') :
                                    'Chưa đọc';

                                $('#notification-dropdown').append(`
                                    <div class="dropdown-item ${bgColor} ${textColor} dropdown-item-notification" id="notification-${notification.id}" data-id="${notification.id}">
                                        <div class="notification p-2 border-bottom">
                                            <h6 class="dropdown-title d-flex align-items-center">
                                                ${notification.title} ${badge}
                                            </h6>
                                            <small class="text-muted">Nhận lúc: ${receivedAt}</small><br>
                                            <small class="text-muted">Đọc lúc: ${readAt}</small>
                                        </div>
                                    </div>
                                `);
                            });

                            // Thêm nút "Đọc tất cả"
                            $('#notification-dropdown').append(`
                                <a href="{{ route('admin.notification.readAllNotification') }}" class="dropdown-item bg-white text-center justify-content-center text-dark fw-bold" style="cursor: pointer;">
                                    Đọc tất cả
                                </a>
                            `);

                            // Gán sự kiện click cho từng thông báo
                            $('.dropdown-item-notification').on('click', function() {
                                const notificationId = $(this).data('id');
                                window.location.href =
                                    "{{ route('admin.notification.edit', ['id' => '__ID__']) }}"
                                    .replace('__ID__', notificationId);
                            });
                        } else {
                            console.warn("Không lấy được danh sách thông báo đúng định dạng.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi khi gọi API thông báo:");
                        console.log("Status: ", status);
                        console.log("Error: ", error);
                        console.log("Response: ", xhr.responseText);
                    }
                });
            }

            // Gọi hàm khi trang tải
            fetchNotifications();
        });
    </script>
@endpush
