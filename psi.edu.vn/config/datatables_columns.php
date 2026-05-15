<?php

return [
    'post' => [
        'image' => [
            'title' => 'Ảnh',
            'icon' => 'ti-photo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'title' => [
            'title' => 'Tiêu đề',
            'icon' => 'ti-file',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'icon' => 'ti-toggle-right',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'is_featured' => [
            'title' => 'Nổi bật',
            'icon' => 'ti-star',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
    ],
    'post_category' => [
        'avatar' => [
            'title' => 'Ảnh đại diện',
            'icon' => 'ti-photo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên danh mục',
            'icon' => 'ti-folder',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'icon' => 'ti-toggle-right',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'transaction' => [
        'user_id' => [
            'title' => 'Học viên',
            'icon' => 'ti-discount-2',  // biểu tượng mã giảm giá
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'ticket_id' => [
            'title' => 'Gói vé',
            'icon' => 'ti-calendar-event',  // biểu tượng ngày bắt đầu
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'icon' => 'ti-currency-dollar',  // biểu tượng ngày kết thúc
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'status' => [
            'title' => 'Trạng thái giao dịch',
            'icon' => 'ti-ticket',  // biểu tượng số lượng phiếu
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',  // biểu tượng cài đặt
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
    ],
    'booking' => [
        'admin_id' => [
            'title' => 'Học viên',
            'icon' => 'ti-discount-2',  // biểu tượng mã giảm giá
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'course_id' => [
            'title' => 'Khoá học',
            'icon' => 'ti-calendar-event',  // biểu tượng ngày bắt đầu
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'icon' => 'ti-currency-dollar',  // biểu tượng ngày kết thúc
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'status' => [
            'title' => 'Trạng thái đơn',
            'icon' => 'ti-ticket',  // biểu tượng số lượng phiếu
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',  // biểu tượng cài đặt
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'review' => [
        'admin' => [
            'title' => 'ID - Học viên',
            'icon' => 'ti-user',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'course' => [
            'title' => 'Khoá học',
            'icon' => 'ti-brand-producthunt',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'rating' => [
            'title' => 'Số sao đánh giá',
            'icon' => 'ti-star',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'content' => [
            'title' => 'Bình luận',
            'icon' => 'ti-message',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'icon' => 'ti-calendar',
            'title' => 'Ngày đánh giá',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'notification' => [
        'id' => [
            'title' => 'Mã',
            'icon' => 'ti-discount-2',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'title' => [
            'title' => 'Tiêu đề',
            'icon' => 'ti-bell',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'admin' => [
            'title' => 'Người nhận',
            'icon' => 'ti-user',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'message' => [
            'title' => 'Nội dung',
            'icon' => 'ti-message',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'status' => [
            'title' => 'Trạng thái',
            'icon' => 'ti-flag',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'created_at' => [
            'title' => 'Ngày thông báo',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],
    'ticket' => [
        'name' => [
            'title' => 'Tên gói',
            'icon' => 'ti-discount-2',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'quantity' => [
            'title' => 'Số lượng',
            'icon' => 'ti-bell',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'price' => [
            'title' => 'Giá tiền',
            'icon' => 'ti-user',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'description' => [
            'title' => 'Mô tả',
            'icon' => 'ti-calendar',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'during' => [
            'title' => 'Thời hạn',
            'icon' => 'ti-message',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],
    'schedule_off' => [
        'teacher' => [
            'title' => 'Giáo viên',
            'icon' => 'ti-bell',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'student' => [
            'title' => 'Học viên',
            'icon' => 'ti-shield',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'student_lesson' => [
            'title' => 'Tên khoá học',
            'icon' => 'ti-user',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'reason' => [
            'title' => 'Lý do xin nghỉ',
            'icon' => 'ti-message',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'created_at' => [
            'title' => 'Ngày nghỉ',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'is_active' => [
            'title' => 'Trạng thái',
            'icon' => 'ti-flag',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-tools',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],
    'module' => [
        'id' => [
            'title' => 'ID',
            'icon' => 'ti-hash',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'name' => [
            'title' => 'Tên Module',
            'icon' => 'ti-box',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'status' => [
            'title' => 'Trạng thái',
            'icon' => 'ti-check',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-tools',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],
    'permission' => [
        'id' => [
            'title' => 'ID',
            'icon' => 'ti-hash',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'title' => [
            'title' => 'Tên quyền',
            'icon' => 'ti-lock',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'name' => [
            'title' => 'Slug ( Permission_name )',
            'icon' => 'ti-tag',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'module_id' => [
            'title' => 'Thuộc Module',
            'icon' => 'ti-folder',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'guard_name' => [
            'title' => 'Nhóm quyền ( Guard Name )',
            'icon' => 'ti-shield',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],
    'admin' => [
        'fullname' => [
            'title' => 'Họ tên',
            'icon' => 'ti-user',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'icon' => 'ti-phone',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'email' => [
            'title' => 'Email',
            'icon' => 'ti-mail',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'roles' => [
            'title' => 'Vai trò',
            'icon' => 'ti-users',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'visible' => false,
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],
    'student' => [
        'fullname' => [
            'title' => 'Họ tên',
            'icon' => 'ti-user',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'icon' => 'ti-mail',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'icon' => 'ti-phone',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'birthday' => [
            'title' => 'Ngày sinh',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'address' => [
            'title' => 'Địa chỉ',
            'icon' => 'ti-map-pin',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'teacher' => [
        'fullname' => [
            'title' => 'Họ tên',
            'icon' => 'ti-user',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'icon' => 'ti-mail',
            'addClass' => 'text-center align-middle',
            'orderable' => false,
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'icon' => 'ti-phone',
            'addClass' => 'text-center align-middle',
            'orderable' => false
        ],
        'birthday' => [
            'title' => 'Ngày sinh',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'address' => [
            'title' => 'Địa chỉ',
            'icon' => 'ti-map-pin',
            'orderable' => false,
            'addClass' => 'text-center align-middle',
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'category' => [
        'name' => [
            'title' => 'Tên danh mục',
            'icon' => 'ti-folder',
            'orderable' => false,
            'addClass' => 'align-middle text-center'
        ],
        'avatar' => [
            'title' => 'Hình ảnh',
            'icon' => 'ti-photo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'is_active' => [
            'title' => 'Trạng thái',
            'icon' => 'ti-toggle-right',
            'orderable' => false,
            'addClass' => 'align-middle text-center'
        ],
        'icon' => [
            'title' => 'Icon',
            'icon' => 'ti-star',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'courses' => [
            'title' => 'Danh sách khoá học',
            'icon' => 'ti-package',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'course' => [
        'avatar' => [
            'title' => 'Ảnh',
            'icon' => 'ti-photo',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên khoá học',
            'icon' => 'ti-tag',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'register_lesson' => [
            'title' => 'Đăng ký buổi học',
            'icon' => 'ti-tag',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'education_level' => [
            'title' => 'Trình độ giáo dục',
            'icon' => 'ti-user',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'lesson' => [
            'title' => 'Danh sách buổi học',
            'icon' => 'ti-file',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
    ],
    'teacher_lesson' => [
        'course' => [
            'title' => 'Khóa học',
            'icon' => 'ti-book',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'lesson_date' => [
            'title' => 'Ngày học',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'teacher' => [
            'title' => 'Giáo viên',
            'icon' => 'ti-school',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'student_lesson' => [
        'id' => [
            'title' => 'Mã buổi học',
            'icon' => 'ti-tag',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'course_name' => [
            'title' => 'Khoá học',
            'icon' => 'ti-book',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'student' => [
            'title' => 'Học viên',
            'icon' => 'ti-user',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'teacher' => [
            'title' => 'Giáo viên',
            'icon' => 'ti-school',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'date' => [
            'title' => 'Ngày học',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'start_time' => [
            'title' => 'Giờ bắt đầu',
            'icon' => 'ti-clock',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'icon' => 'ti-toggle-right',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'day_off_type' => [
            'title' => 'Loại xin nghỉ',
            'icon' => 'ti-toggle-right',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'skype' => [
            'title' => 'Jitsi',
            'icon' => 'fa-brands fa-jitsi',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'file' => [
            'title' => 'File',
            'icon' => 'ti-file',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'lesson' => [
        'date' => [
            'title' => 'Ngày học',
            'icon' => 'ti-calendar',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'start_time' => [
            'title' => 'Giờ bắt đầu',
            'icon' => 'ti-clock',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'role' => [
        'id' => [
            'title' => 'ID',
            'icon' => 'ti-id-badge',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'title' => [
            'title' => 'Tên vai trò',
            'icon' => 'ti-user',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'name' => [
            'title' => 'Slug (role_name)',
            'icon' => 'ti-tag',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'guard_name' => [
            'title' => 'Vai trò của nhóm (Guard Name)',
            'icon' => 'ti-shield',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'icon' => 'ti-settings',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'ticket_student' => [
        'id' => [
            'title' => 'Mã vé',
            'icon' => 'ti-id-badge',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
        'expired_date' => [
            'title' => 'Ngày hết hạn',
            'icon' => 'ti-comment-alt',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],
    ],
];
