@extends('admin.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@section('content')
    <div class="mt-3 p-3">
        <div class="container-xl">
            <div class="row g-4"> <!-- khoảng cách giữa các card -->
                @foreach ($tickets as $ticket)
                    @php
                        // Chuẩn hóa loại vé
                        $ticketType = ucfirst(strtolower($ticket->type ?? 'Normal'));
                        // Gán màu cho loại vé
                        $typeClass = $ticketType === 'Special' ? 'bg-warning text-dark' : 'bg-secondary';
                    @endphp

                    <div class="col-md-3">
                        <div class="card h-100 bg-white p-3 text-center d-flex flex-column">
                            <!-- Logo -->
                            <div class="mb-3">
                                <img class="img-circle d-block mx-auto" src="{{ asset($ticket->avatar) }}" alt="Logo">
                            </div>

                            <!-- Thông tin vé -->
                            <div>
                                <h3 class="default-color">{{ $ticket->name }}</h3>

                                {{-- Loại vé --}}
                                <h5 class="badge {{ $typeClass }} mb-2">{{ $ticketType }}</h5>

                                {{-- Giá --}}
                                <h4 class="badge bg-success mb-2">{{ format_price($ticket->price) }}</h4>

                                {{-- Số lượng --}}
                                <h4 class="default-color mb-1">Số vé: <span class="text-primary">{{ $ticket->quantity }}
                                        vé</span></h4>

                                {{-- Thời hạn --}}
                                <h4 class="default-color">Thời hạn: <span class="text-primary">{{ $ticket->during }}
                                        ngày</span></h4>
                            </div>

                            <!-- Nút đặt vé -->
                            <div class="mt-auto">
                                <button onclick="showDetailTicketModal({{ $ticket->id }})"
                                    class="btn btn-default w-100 mt-3">Đặt ngay</button>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('admin.ticket.detail', $ticket->id) }}"
                                    class="btn btn-default w-100 mt-3">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
                    @if ($tickets->hasPages())
                        <button class="pagination-btn prev" onclick="location.href='{{ $tickets->previousPageUrl() }}'"
                            @if ($tickets->onFirstPage()) disabled @endif>
                            <i class="ti ti-arrow-left" aria-hidden="true"></i>
                        </button>

                        @for ($i = 1; $i <= $tickets->lastPage(); $i++)
                            <button onclick="location.href='{{ $tickets->url($i) }}'"
                                class="pagination-btn @if ($i == $tickets->currentPage()) active @endif">
                                {{ $i }}
                            </button>
                        @endfor

                        <button class="pagination-btn next" onclick="location.href='{{ $tickets->nextPageUrl() }}'"
                            @if (!$tickets->hasMorePages()) disabled @endif>
                            <i class="ti ti-arrow-right" aria-hidden="true"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-quickview />
@endsection

@push('libs-js')
    <script src="{{ asset('public/user/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
@endpush

@push('custom-js')
    @include('admin.transactions.scripts.scripts')
@endpush
