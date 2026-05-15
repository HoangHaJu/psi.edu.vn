<?php

return [
    [
        'title' => 'Dashboard',
        'routeName' => 'admin.dashboard',
        'icon' => '<i class="ti ti-home"></i>',
        'roles' => [],
        'permissions' => ['viewDashboard'],
        'sub' => []
    ],
    [
        'title' => 'Bài viết',
        'routeName' => null,
        'icon' => '<i class="ti ti-article"></i>',
        'roles' => [],
        'permissions' =>
        [
            'createAdmin',
        ],
        'sub' => [
            [
                'title' => 'Thêm Bài viết',
                'routeName' => 'admin.post.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createAdmin'],
            ],
            [
                'title' => 'DS Bài viết',
                'routeName' => 'admin.post.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewAdmin'],
            ],
            [
                'title' => 'DS Chuyên mục',
                'routeName' => 'admin.post_category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewAdmin'],
            ]
        ]
    ],
    [
        'title' => 'Thông tin cá nhân',
        'icon' => '<i class="ti ti-user"></i>',
        'roles' => [],
        'routeName' => 'admin.profile.index',
        'permissions' => ['mevivuDev'],
        'sub' => []
    ],
    [
        'title' => 'Thông báo',
        'routeName' => 'admin.notification.index',
        'icon' => '<i class="ti ti-bell-ringing"></i>',
        'roles' => [],
        'permissions' => [
            'createNotification',
            'viewNotification',
            'updateNotification',
            'deleteNotification',
        ],
        'sub' => [
            [
                'title' => 'Thêm thông báo',
                'routeName' => 'admin.notification.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => ['superAdmin'],
                'permissions' => ['createNotification'],
            ],
            [
                'title' => 'DS thông báo',
                'routeName' => 'admin.notification.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => ['student', 'teacher', 'superAdmin'],
                'permissions' => ['viewNotification'],
            ],
        ]
    ],
    [
        'title' => 'Gói vé',
        'routeName' => 'admin.ticket.index',
        'icon' => '<i class="ti ti-ticket"></i>',
        'roles' => [],
        'permissions' => [
            'createTicket',
            'viewTicket',
            'updateTicket',
            'deleteTicket',
        ],
        'sub' => [
            [
                'title' => 'Gia hạn gói vé',
                'routeName' => 'admin.ticket.extend',
                'icon' => '<i class="ti ti-clock"></i>',
                'roles' => [],
                'permissions' => ['createTicket'],
            ],
            [
                'title' => 'Thêm gói vé',
                'routeName' => 'admin.ticket.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createTicket'],
            ],
            [
                'title' => 'DS gói vé',
                'routeName' => 'admin.ticket.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewTicket'],
            ],
        ]
    ],
    [
        'title' => 'Giáo viên',
        'routeName' => null,
        'icon' => '<i class="ti ti-school"></i>',
        'roles' => [],
        'permissions' => [
            'createAdmin',
            'viewAdmin',
            'updateAdmin',
            'deleteAdmin',
        ],
        'sub' => [
            [
                'title' => 'Thêm Giáo viên',
                'routeName' => 'admin.teacher.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createAdmin'],
            ],
            [
                'title' => 'DS Giáo viên',
                'routeName' => 'admin.teacher.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewAdmin'],
            ],
        ]
    ],
    [
        'title' => 'Học viên',
        'routeName' => null,
        'icon' => '<i class="ti ti-user"></i>',
        'roles' => [],
        'permissions' => [
            'createAdmin',
            'viewAdmin',
            'updateAdmin',
            'deleteAdmin',
        ],
        'sub' => [
            [
                'title' => 'Thêm Học viên',
                'routeName' => 'admin.student.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createAdmin'],
            ],
            [
                'title' => 'DS Học viên',
                'routeName' => 'admin.student.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewAdmin'],
            ],
        ]
    ],
    [
        'title' => 'Ngày nghỉ',
        'routeName' => 'admin.schedule_off.index',
        'icon' => '<i class="ti ti-calendar"></i>',
        'roles' => [],
        'permissions' => [
            'mevivuDev',
        ],
    ],
    [
        'title' => 'Buổi học - Giáo viên',
        'routeName' => 'admin.teacher_lesson.index',
        'icon' => '<i class="ti ti-school"></i>',
        'roles' => [],
        'permissions' => [
            'deleteAdmin',
            'deleteLesson'
        ]
    ],
    [
        'title' => 'Buổi học',
        'routeName' => 'admin.booking.index',
        'icon' => '<i class="ti ti-book-2"></i>',
        'roles' => [],
        'permissions' => [
            'viewBooking',
        ],
        'sub' => [
            [
                'title' => 'Đăng ký',
                'routeName' => 'admin.course.lookup.index',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => ['student', 'superAdmin'],
                'permissions' => ['createBooking'],
            ],
            [
                'title' => 'DS Buổi học',
                'routeName' => 'admin.booking.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => ['student', 'superAdmin'],
                'permissions' => ['viewBooking'],
            ],
        ]
    ],
    [
        'title' => 'Vé',
        'routeName' => 'admin.transaction.index',
        'icon' => '<i class="ti ti-ticket"></i>',
        'roles' => [],
        'permissions' => [
            'createTransaction',
            'viewTransaction',
            'updateTransaction',
            'deleteTransaction',
        ],
        'sub' => [
            [
                'title' => 'Mua vé',
                'routeName' => 'admin.transaction.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => ['student'],
                'permissions' => ['createTransaction'],
            ],
            [
                'title' => 'Lịch sử mua vé',
                'routeName' => 'admin.transaction.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => ['student'],
                'permissions' => ['viewTransaction'],
            ],
            // [
            //     'title' => 'DS vé',
            //     'routeName' => 'admin.ticket_students.index',
            //     'icon' => '<i class="ti ti-list"></i>',
            //     'roles' => [],
            //     'permissions' => ['viewTicketList'],
            // ],
        ]
    ],
    [
        'title' => 'Khoá học',
        'routeName' => 'admin.course.index',
        'icon' => '<i class="ti ti-book-2"></i>',
        'roles' => [],
        'permissions' => ['updateCourse', 'viewCourse'],
        'sub' => [
            [
                'title' => 'Thêm khoá học',
                'routeName' => 'admin.course.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => ['superAdmin'],
                'permissions' => ['createCourse'],
            ],
            [
                'title' => 'DS Khoá học',
                'routeName' => 'admin.course.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => ['superAdmin'],
                'permissions' => ['viewCourse'],
            ],
            [
                'title' => 'Thêm danh mục',
                'routeName' => 'admin.category.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => ['superAdmin'],
                'permissions' => ['createCategory'],
            ],
            [
                'title' => 'DS Danh mục khoá học',
                'routeName' => 'admin.category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => ['superAdmin'],
                'permissions' => ['createCategory'],
            ],

        ]
    ],
    [
        'title' => 'Đánh giá',
        'routeName' => null,
        'icon' => '<i class="ti ti-star"></i>',
        'roles' => [],
        'routeName' => 'admin.review.index',
        'permissions' => ['viewReview'],
        'sub' => []
    ],
    // [
    //     'title' => 'Vai trò',
    //     'routeName' => null,
    //     'icon' => '<i class="ti ti-user-check"></i>',
    //     'roles' => [],
    //     'permissions' => ['createRole', 'viewRole', 'updateRole', 'deleteRole'],
    //     'sub' => [
    //         [
    //             'title' => 'Thêm Vai trò',
    //             'routeName' => 'admin.role.create',
    //             'icon' => '<i class="ti ti-plus"></i>',
    //             'roles' => [],
    //             'permissions' => ['createRole'],
    //         ],
    //         [
    //             'title' => 'DS Vai trò',
    //             'routeName' => 'admin.role.index',
    //             'icon' => '<i class="ti ti-list"></i>',
    //             'roles' => [],
    //             'permissions' => ['viewRole'],
    //         ]
    //     ]
    // ],
    // [
    //     'title' => 'Modules',
    //     'routeName' => null,
    //     'icon' => '<i class="ti ti-code"></i>',
    //     'roles' => [],
    //     'permissions' => ['mevivuDev'],
    //     'sub' => [
    //         [
    //             'title' => 'Add Module',
    //             'routeName' => 'admin.module.create',
    //             'icon' => '<i class="ti ti-plus"></i>',
    //             'roles' => [],
    //             'permissions' => ['mevivuDev'],
    //         ],
    //         [
    //             'title' => 'Module List',
    //             'routeName' => 'admin.module.index',
    //             'icon' => '<i class="ti ti-list"></i>',
    //             'roles' => [],
    //             'permissions' => ['mevivuDev'],
    //         ]
    //     ]
    // ],
    [
        'title' => 'Cài đặt',
        'routeName' => null,
        'icon' => '<i class="ti ti-settings"></i>',
        'roles' => [],
        'permissions' => ['settingGeneral'],
        'sub' => [
            [
                'title' => 'Chung',
                'routeName' => 'admin.setting.general',
                'icon' => '<i class="ti ti-tool"></i>',
                'roles' => [],
                'permissions' => ['settingGeneral'],
            ],
        ]
    ],
];
