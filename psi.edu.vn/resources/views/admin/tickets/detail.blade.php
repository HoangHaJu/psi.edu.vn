@extends('admin.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --light-bg: #f4f6f9;
        }

        .card {
            margin-bottom: 20px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background-color: #fff;
            font-weight: 600;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding-bottom: 0.5rem;
        }

        .detail-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }

        .highlight-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .logo-placeholder img {
            width: 50%;
            height: auto;
            border-radius: 10px;
            border: 2px solid #ddd;
            object-fit: cover;
        }

        .description-content {
            white-space: pre-wrap;
            padding: 1rem;
            min-height: 250px;
            background-color: var(--light-bg);
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <main class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- (1) Hình ảnh đại diện -->
                    <div class="card shadow-lg mb-4">
                        <div class="card-header bg-white">
                            <i class="fas fa-image me-2 text-primary"></i> Hình ảnh đại diện
                        </div>
                        <div class="card-body text-center">
                            <div class="logo-placeholder mb-3">
                                <img src="{{ asset($ticket->avatar) }}" alt="Logo gói vé">
                            </div>
                            <p class="small text-muted">Ảnh minh họa cho gói vé "{{ $ticket->name }}".</p>
                        </div>
                    </div>

                    <!-- (2) Thông tin gói vé -->
                    <div class="card shadow-lg mb-4">
                        <div class="card-header bg-white">
                            <i class="fas fa-ticket-alt me-2 text-primary"></i> Thông tin gói vé
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="detail-label">Tên gói vé</span>
                                <div class="highlight-value text-dark">{{ $ticket->name }}</div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 bg-light rounded-3 text-center">
                                        <span class="detail-label"><i class="fas fa-box me-1"></i> Số lượng</span>
                                        <div class="highlight-value text-success">{{ $ticket->quantity }}</div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 bg-light rounded-3 text-center">
                                        <span class="detail-label"><i class="fas fa-dollar-sign me-1"></i> Giá gói vé</span>
                                        <div class="highlight-value text-danger">
                                            {{ number_format($ticket->price, 0, ',', '.') }} VND
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 bg-light rounded-3 text-center">
                                        <span class="detail-label"><i class="fas fa-clock me-1"></i> Thời hạn (Ngày)</span>
                                        <div class="highlight-value text-primary">{{ $ticket->during }}</div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 bg-light rounded-3 text-center">
                                        <span class="detail-label"><i class="fas fa-tags me-1"></i> Loại gói</span>
                                        <div class="highlight-value text-warning">
                                            {{ $ticket->type == 'special' ? 'Đặc biệt' : 'Thường' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- (3) Mô tả chi tiết -->
                    <div class="card shadow-lg">
                        <div class="card-header bg-white">
                            <i class="fas fa-file-alt me-2 text-primary"></i> Mô tả chi tiết
                        </div>
                        <div class="card-body p-0">
                            <div class="description-content">
                                {!! $ticket->description !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
@endsection
