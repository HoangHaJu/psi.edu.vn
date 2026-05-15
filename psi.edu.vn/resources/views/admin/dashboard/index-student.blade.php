@extends('admin.layouts.master')

{{-- Đặt các file CSS trong push libs-css --}}
@push('custom-css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard.css') }}'">
    <style>
        /* 1. Tùy chỉnh màu sắc và kích thước chữ chung cho tất cả các sự kiện */
        .fc-event {
            overflow: hidden !important;
            white-space: nowrap !important;
            padding: 2px 4px !important;
            /* Tăng padding để dễ nhìn hơn */
        }

        .fc-event-time {
            font-size: 1rem !important;
        }

        /* 2. Tăng kích thước chữ cho tiêu đề sự kiện */
        .fc-event-title {
            font-size: 14px;
            /* Kích thước chữ mong muốn */
            font-weight: bold;
            color: #333;
            /* Màu chữ mặc định (đen xám) */
        }

        /* 3. Tùy chỉnh cho sự kiện ĐÃ HỦY (status 4) */
        .fc-event.bg-danger {
            background-color: #dc3545 !important;
            /* Màu đỏ tiêu chuẩn */
            border-color: #dc3545 !important;
            color: white !important;
            opacity: 0.8;
            /* Làm mờ một chút */
            text-decoration: line-through;
            /* Gạch ngang chữ */
        }

        /* 4. Tùy chỉnh cho sự kiện ĐÃ XÁC NHẬN (status 2) */
        .fc-event.bg-success {
            background-color: #198754 !important;
            border-color: #198754 !important;
            color: white !important;
        }

        /* 5. Tùy chỉnh cho sự kiện CHỜ XÁC NHẬN (status 1) */
        .fc-event.bg-warning {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
            color: #333 !important;
            /* Chữ màu tối để dễ đọc trên nền vàng */
        }

        .fc-daygrid-day.has-lessons {
            background-color: #e0ffe0;
            /* Màu xanh lá cây nhạt để tô màu */
            /* Bạn có thể tùy chỉnh thêm */
        }

        .fc-daygrid-day.has-lessons .fc-daygrid-day-number {
            color: #212529;
            /* Đảm bảo số ngày hiển thị rõ ràng */
        }

        .lesson-dot {
            width: 8px;
            height: 8px;
            background-color: #198754;
            border-radius: 50%;
            display: inline-block;
            margin-top: 5px;
            box-shadow: 0 0 3px rgba(25, 135, 84, 0.4);
            cursor: help;
        }

        /* Tùy chỉnh nhỏ cho khung ngày nếu cần */
        .fc-daygrid-day-frame {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Căn giữa nội dung trong khung ngày */
        }

        .fc-daygrid-day-top {
            width: 100%;
            text-align: center;
            /* Căn giữa số ngày */
        }

        .fc-daygrid-day-number {
            font-weight: bold;
            /* Làm nổi bật số ngày */
        }

        /* Bổ sung CSS cho các sự kiện (event) FullCalendar mà bạn đã cung cấp */
        .fc-event-title {
            white-space: normal !important;
            word-wrap: break-word;
        }

        .fc-event.bg-red {
            background-color: #dc3545;
            /* Bootstrap danger */
            border-color: #dc3545;
        }

        .fc-event.bg-orange {
            background-color: #ffc107;
            /* Bootstrap warning */
            border-color: #ffc107;
        }

        .fc-event.bg-cyan {
            background-color: #0dcaf0;
            /* Bootstrap info */
            border-color: #0dcaf0;
        }

        .fc-event.bg-green {
            background-color: #198754;
            /* Bootstrap success */
            border-color: #198754;
        }

        /* Thêm màu mặc định nếu cần */
        .fc-event {
            background-color: #d6dbdf;
            /* Default Bootstrap secondary */
            border-color: #6c757d;
        }

        .fc-button.fc-button-primary,
        .btn-app {
            background-color: #1d2e61 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary:hover,
        .btn-app:hover {
            background-color: #284086 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary.fc-button-active {
            background-color: #0a1c53 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary:focus,
        .fc-button.fc-button-primary:focus-visible {
            outline: none;
            box-shadow: none !important;
        }
    </style>
@endpush


@section('content')
    <div class="container p-4">
        <div class="row">
            <div class="col-12 mb-3">
                <h1>Xin chào, {{ auth('admin')->user()->fullname }}</h1>
                <h4>Chúng ta hãy học tiếng Anh ngay hôm nay!</h4>
                <div style="min-height: 300px" class="card bg-white p-3">
                    <h3>Bài học sắp tới của bạn</h3>
                    @if ($upcomingLessons->isNotEmpty())
                        <div class="row justify-content-center gap-4">
                            @foreach ($upcomingLessons as $lesson)
                                <div class="card col-md-4">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold fs-2">{{ $lesson->name }}</h5>
                                        <p class="card-text">
                                            Khoá học: {{ $lesson->course_name }} <br>
                                            Ngày: {{ \Carbon\Carbon::parse($lesson->date)->format('d/m/Y') }} <br>
                                            Giờ bắt đầu: {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }}
                                            <br>
                                        </p>
                                        <a href="{{ route('admin.student_lesson.edit', $lesson->id) }}"
                                            class="btn btn-app">Vào học</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
                            @if ($upcomingLessons->hasPages())
                                <button class="pagination-btn prev"
                                    onclick="location.href='{{ $upcomingLessons->previousPageUrl() }}'"
                                    @if ($upcomingLessons->onFirstPage()) disabled @endif>
                                    <i class="ti ti-arrow-left" aria-hidden="true"></i>
                                </button>
                                @for ($i = 1; $i <= $upcomingLessons->lastPage(); $i++)
                                    <button onclick="location.href='{{ $upcomingLessons->url($i) }}'"
                                        class="pagination-btn @if ($i == $upcomingLessons->currentPage()) active @endif">
                                        {{ $i }}
                                    </button>
                                @endfor
                                <button class="pagination-btn next"
                                    onclick="location.href='{{ $upcomingLessons->nextPageUrl() }}'"
                                    @if (!$upcomingLessons->hasMorePages()) disabled @endif>
                                    <i class="ti ti-arrow-right" aria-hidden="true"></i>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="p-5 text-center">
                            @if ($hasTicket)
                                <p>Hôm nay bạn không có bài học nào</p>
                                <a href="{{ route('admin.course.lookup.index') }}" class="btn btn-app text-white">
                                    Đặt lịch học
                                </a>
                            @else
                                <p>Bạn chưa có vé, mua gói vé để tham gia học ngay</p>
                                <a href="{{ route('admin.transaction.create') }}" class="btn btn-danger text-white">
                                    Mua gói vé
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mb-3">
                {{-- hiển thị thống kê tổng số vé hiện có, thống kê các vé gần hết data và ngày của vé đó --}}
                @include('admin.ticket_students.index')
            </div>
            <div class="col-md-6 d-flex align-items-center mb-2 mt-3">
                <div style="width: 20px; height: 20px; background-color: orange; margin-right: 10px; border-radius: 15px">
                </div>
                <span>Buổi học chưa bắt đầu</span>
            </div>
            <div class="col-md-6 d-flex align-items-center mb-2 mt-3">
                <div style="width: 20px; height: 20px; background-color: red; margin-right: 10px; border-radius: 15px">
                </div>
                <span>Giáo viên hoặc Học viên xin nghỉ</span>
            </div>
            <div class="col-md-6 d-flex align-items-center mb-2 mt-3">
                <div style="width: 20px; height: 20px; background-color: cyan; margin-right: 10px; border-radius: 15px">
                </div>
                <span>Đã học bù</span>
            </div>
            <div class="col-md-6 d-flex align-items-center mb-2 mt-3">
                <div style="width: 20px; height: 20px; background-color: green; margin-right: 10px; border-radius: 15px">
                </div>
                <span>Buổi học đã hoàn thành</span>
            </div>
            {{-- Đặt lịch ở đây --}}
            <div class="col-12 mt-3">
                <div class="card card-body mb-4 shadow-sm rounded-3">
                    <h3 class="m-0 mb-3">Lịch học của bạn</h3>
                    <div id="calendar"></div>
                </div>
            </div>

            {{-- NEW: Section to display lesson details --}}
            <div id="lessonDetailsSection" class="col-12 mt-4" style="display: none;">
                <div class="card shadow-sm rounded-3 border-0 p-4">
                    <h4 class="card-title fw-bold mb-3">Thông tin buổi học chi tiết</h4>
                    <div id="lessonDetailsContent">
                        {{-- Lesson details will be injected here by JavaScript --}}
                    </div>
                </div>
            </div>
            {{-- END NEW --}}

        </div> {{-- End row --}}

        {{-- Phần bài viết của bạn --}}
        <div class="row mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="ms-2">Bài viết</h3>
                <a href="{{ route('admin.post.all') }}" class="btn btn-app mx-1 block">Xem tất cả</a>
            </div>
            <div class="container-fluid my-2">
                {{-- Dùng flex để scroll ngang --}}
                <div class="d-flex gap-4 overflow-x-auto overflow-y-hidden py-1">
                    @foreach ($posts as $post)
                        <div class="d-flex" style="flex: 0 0 320px;">
                            <div class="card shadow-sm w-100 d-flex flex-column" style="height: 400px; min-width: 100%;">
                                <img src="{{ asset($post->image) }}" class="card-img-top" alt="Ảnh bài viết"
                                    style="height: 200px; object-fit: cover; flex-shrink: 0;">
                                <div class="card-body d-flex flex-column flex-grow-1 pb-4">
                                    <h5 class="card-title mb-2"
                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $post->title }}
                                    </h5>
                                    <p class="card-text text-muted mb-3 flex-grow-1"
                                        style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $post->excerpt }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div class="small text-muted">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                                        </div>
                                        <a href="{{ route('admin.post.detail', $post->id) }}"
                                            class="btn btn-app btn-sm">Đọc thêm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src='{{ asset('/public/libs/full-calendar/index.global.min.js') }}'></script>
    @include('admin.dashboard.scripts')
@endpush
