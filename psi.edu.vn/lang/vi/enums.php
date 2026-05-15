<?php

use App\Enums\Admin\EducationLevel;
use App\Enums\Attribute\AttributeType;
use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\PaymentStatus;
use App\Enums\DefaultActiveStatus;
use App\Enums\DefaultStatus;
use App\Enums\Discount\DiscountType;
use App\Enums\FeaturedStatus;
use App\Enums\Lesson\DayOffType;
use App\Enums\Lesson\LessonStatus;
use App\Enums\Notification\NotificationOption;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Post\PostStatus;
use App\Enums\PostCategory\PostCategoryStatus;
use App\Enums\PriorityStatus;
use App\Enums\Product\{ProductInStock, ProductManagerStock, ProductStatus, ProductType, ProductVariationAction};
use App\Enums\Slider\SliderStatus;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\User\{Gender, UserVip, UserRoles};

return [
    Gender::class => [
        Gender::Male->value => 'Nam',
        Gender::Female->value => 'Nữ',
        Gender::Other->value => 'Khác',
    ],
    LessonStatus::class => [
        LessonStatus::NotPresent->value => 'Chưa điểm danh',
        LessonStatus::Present->value => 'Đã điểm danh',
        LessonStatus::Cancelled->value => 'Đã huỷ',
    ],
    DayOffType::class => [
        DayOffType::Teacher->value => 'Giáo viên xin nghỉ',
        DayOffType::Student->value => 'Học viên xin nghỉ',
        DayOffType::None->value => 'Không có',
    ],
    EducationLevel::class => [
        EducationLevel::Primary->value => 'Sơ cấp',
        EducationLevel::Intermediate->value => 'Trung cấp',
        EducationLevel::Advanced->value => 'Cao cấp',
    ],
    NotificationType::class => [
        NotificationType::All->value => 'Tất cả',
        NotificationType::Customer->value => 'Một vài người cụ thể',
    ],
    NotificationOption::class => [
        NotificationOption::Teacher->value => 'Giáo viên',
        NotificationOption::Student->value => 'Học viên',
    ],
    NotificationStatus::class => [
        NotificationStatus::READ->value => 'Đã đọc',
        NotificationStatus::NOT_READ->value => 'Chưa đọc',
    ],
    AttributeType::class => [
        AttributeType::Color->value => 'Màu sắc',
        AttributeType::Button->value => 'Không phải màu sắc',
    ],
    DefaultActiveStatus::class => [
        DefaultActiveStatus::Active->value => 'Có',
        DefaultActiveStatus::UnActive->value => 'Không',
    ],
    PaymentStatus::class => [
        PaymentStatus::UnPaid->value => 'Chưa thanh toán',
        PaymentStatus::Paid->value => 'Đã thanh toán',
    ],
    TransactionStatus::class => [
        TransactionStatus::Pending->value => 'Đang xử lý',
        TransactionStatus::Success->value => 'Thành công',
        TransactionStatus::Failed->value => 'Thất bại',
        // TransactionStatus::Cancelled->value => 'Hủy',
    ],
    PostStatus::class => [
        PostStatus::Draft->value => 'Bản nháp',
        PostStatus::Published->value => 'Đã xuất bản',
    ],
    PostCategoryStatus::class => [
        PostCategoryStatus::Draft => 'Bản nháp',
        PostCategoryStatus::Published => 'Đã xuất bản',
    ],
    ProductStatus::class => [
        ProductStatus::Active->value => 'Đang hoạt động',
        ProductStatus::InActive->value => 'Ngưng hoạt động',
    ],
    ProductManagerStock::class => [
        ProductManagerStock::Managed->value => 'Có quản lý',
        ProductManagerStock::NotManaged->value => 'Không quản lý',
    ],
    ProductInStock::class => [
        ProductInStock::InStock->value => 'Còn hàng',
        ProductInStock::OutOfStock->value => 'Hết hàng',
    ],
    PaymentMethod::class => [
        PaymentMethod::Online->value => 'Online (VNPAY)',
        PaymentMethod::Direct->value => 'COD (Tiền mặt)',
        PaymentMethod::Banking->value => 'Chuyển khoản ngân hàng',
    ],
    UserVip::class => [
        UserVip::Default => 'Mặc định',
        UserVip::Bronze => 'Đồng',
        UserVip::Silver => 'Bạc',
        UserVip::Gold => 'Vàng',
        UserVip::Diamond => 'Kim cương',
    ],
    UserRoles::class => [
        UserRoles::Customer->value => 'Khách hàng',
        UserRoles::Driver->value => 'Tài xế',
    ],
    ProductType::class => [
        ProductType::Simple->value => 'Sản phẩm đơn giản',
        ProductType::Variable->value => 'Sản phẩm có biến thể'
    ],
    DefaultStatus::class => array(
        DefaultStatus::Published->value => 'Đã xuất bản',
        DefaultStatus::Draft->value => 'Bản nháp',
        DefaultStatus::Deleted->value => 'Đã xoá',
    ),
    ProductVariationAction::class => [
        ProductVariationAction::AddSimple => 'Thêm biến thể',
        ProductVariationAction::AddFromAllVariations => 'Tạo biến thể từ tất cả thuộc tính'
    ],
    BookingStatus::class => [
        BookingStatus::Pending->value => 'Chờ xác nhận',
        BookingStatus::Confirmed->value => 'Đã xác nhận',
        BookingStatus::Cancelled->value => 'Đã huỷ',
    ],
    DiscountType::class => [
        DiscountType::Money->value => 'Tiền',
        DiscountType::Percent->value => 'Phần trăm'
    ],
    PriorityStatus::class => [
        PriorityStatus::Priority->value => 'Ưu tiên',
        PriorityStatus::NotPriority->value => 'Không ưu tiên'
    ],
    FeaturedStatus::class => [
        FeaturedStatus::Featured->value => 'Nổi bật',
        FeaturedStatus::Featureless->value => 'Không nổi bật'
    ],
];
