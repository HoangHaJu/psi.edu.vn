@extends('admin.layouts.master')

@push('custom-css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard.css') }}">

<style>
    .fc-event-title {
        white-space: normal !important;
        word-wrap: break-word;
    }

    /* Lưới bài viết: desktop 4, tablet 3, mobile 2 (không dùng col/row) */
    .posts-grid {
        display: grid;
        gap: 1.25rem;
        grid-template-columns: repeat(4, minmax(0, 1fr));
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

    @media (max-width: 1199.98px) {
        .posts-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .posts-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>
@endpush

@section('content')
    <div class="container d-flex align-items-center">
        <div class="row">
            <div class="col-md-4 my-3">
                @if (auth('admin')->user()->isSuperAdmin)
                    <a href="{{ route('admin.dashboard.reset') }}" class="btn btn-app mx-1 block">
                        Đặt lại số ngày nghỉ của học sinh
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 mb-3 rounded">
                <div style="min-height: 400px" class="card equal-height p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="m-0">Thông báo</h3>
                        <a href="{{ route('admin.notificationsPage') }}" class="btn btn-app mx-1 block">Xem tất cả</a>
                    </div>
                    <div class="list-group">
                        @foreach ($notifications as $notification)
                            <a href="{{ route('admin.notification.show', $notification->id) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                style="max-width: 100%; overflow: hidden;">
                                <div style="max-width: 80%;">
                                    <div class="fw-bold text-truncate"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $notification->title }}
                                    </div>
                                    <div class="text-muted text-truncate"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $notification->message }}
                                    </div>
                                </div>
                                <span class="text-muted text-nowrap ms-auto">
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans(null, true) }} trước
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Khu vực bài viết --}}
        <div class="row mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="ms-2">Bài viết</h3>
                <a href="{{ route('admin.post.all') }}" class="btn btn-app mx-1 block">Xem tất cả</a>
            </div>

            <div class="container-fluid my-2">
                <div class="posts-grid py-1">
                    @foreach ($posts as $post)
                        <div class="card shadow-sm h-100 d-flex flex-column">
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
                                    <a href="{{ route('admin.post.detail', $post->id) }}" class="btn btn-app btn-sm">Đọc
                                        thêm</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
