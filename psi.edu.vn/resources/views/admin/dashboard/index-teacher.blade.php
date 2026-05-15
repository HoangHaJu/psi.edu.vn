@extends('admin.layouts.master')

@push('custom-css')
    <link href="{{ asset('libs/full-calendar/index.global.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard.css') }}'">

    <style>
        .fc-event-title {
            white-space: normal !important;
            word-wrap: break-word;
        }

        .equal-height {
            height: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container p-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div style="min-height: 280px" class="card p-3">
                    <h3 class="mb-4">Buổi dạy sắp tới</h3>
                    @if ($upcomingTeacherLessons->isNotEmpty())
                        <div class="row justify-content-center gap-4">
                            @foreach ($upcomingTeacherLessons as $lesson)
                                <div class="card col-md-auto">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold fs-2">{{ $lesson->name }}</h5>
                                        <p class="card-text">
                                            Ngày học: {{ $lesson->date }} <br>
                                            Giờ bắt đầu: {{ $lesson->start_time }} <br>
                                        </p>
                                        <a href="{{ route('admin.student_lesson.edit', $lesson->id) }}"
                                            class="btn btn-app">Vào ngay</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
                            @if ($lessons->hasPages())
                                <button class="pagination-btn prev"
                                    onclick="location.href='{{ $lessons->previousPageUrl() }}'"
                                    @if ($lessons->onFirstPage()) disabled @endif>
                                    <i class="ti ti-arrow-left" aria-hidden="true"></i>
                                </button>
                                @for ($i = 1; $i <= $lessons->lastPage(); $i++)
                                    <button onclick="location.href='{{ $lessons->url($i) }}'"
                                        class="pagination-btn @if ($i == $lessons->currentPage()) active @endif">
                                        {{ $i }}
                                    </button>
                                @endfor
                                <button class="pagination-btn next" onclick="location.href='{{ $lessons->nextPageUrl() }}'"
                                    @if (!$lessons->hasMorePages()) disabled @endif>
                                    <i class="ti ti-arrow-right" aria-hidden="true"></i>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <p>Hôm nay bạn không có lịch học</p>
                        </div>
                    @endif
                </div>
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
                <span>Giáo viên hoặc Học viên xin nghỉ nhưng đã học bù</span>
            </div>
            <div class="col-md-6 d-flex align-items-center mb-2 mt-3">
                <div style="width: 20px; height: 20px; background-color: green; margin-right: 10px; border-radius: 15px">
                </div>
                <span>Buổi học đã hoàn thành</span>
            </div>
            <div class="col-12 mt-3">
                <div id="calendar"></div>
                <div id="lessonDetailsSection" class="mt-4" style="display: none;">
                    <div id="lessonDetailsContent"></div>
                </div>
            </div>
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
                                <div class="card shadow-sm w-100 d-flex flex-column"
                                    style="height: 400px; min-width: 100%;">
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
