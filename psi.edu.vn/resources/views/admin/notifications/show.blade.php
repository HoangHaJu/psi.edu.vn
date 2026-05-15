@extends('admin.layouts.master')

@section('title', 'Chi Tiết Thông Báo')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $notification->title }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nội dung:</strong></p>
                    <div class="notification-message mb-3">
                        {!! $notification->message !!} {{-- Sử dụng {!! !!} nếu message chứa HTML --}}
                    </div>
                    <hr>
                    <p class="text-muted mb-0">
                        Được gửi: {{ \Carbon\Carbon::parse($notification->created_at)->format('H:i d/m/Y') }}
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('admin.notification.index') }}" class="btn btn-primary">
                            <i class="ti ti-arrow-left me-2"></i> {{-- Biểu tượng mũi tên quay lại --}}
                            Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
