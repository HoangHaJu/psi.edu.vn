@extends('admin.auth.game_psi.layout')

@section('title', 'Trò chơi - Listen and Choose')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/mucluc.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
@endpush

@section('content')
    <header class="mb-8">
        <div class="header-wrapper text-center">
            <div class="breadcrumb mb-3">
                <a href="{{ route('admin.game_psi.index') }}" class="text-decoration-none text-primary fw-bold">Trang chủ</a>
                <span class="text-muted"> &gt; Trò chơi</span>
            </div>

            <h1 class="fw-bold" style="font-family: 'Baloo 2', cursive;">TRÒ CHƠI</h1>
            <p class="text-muted" style="font-family: 'Roboto', sans-serif;">Giúp bé phát triển tiếng Anh một cách tự nhiên
            </p>
        </div>
    </header>

    <main class="game-content text-center">
        {{-- 🔹 Hiệu ứng chữ tiêu đề động --}}
        <div class="instruction-text mb-5">
            <div class="text-wrapper">
                <span class="stroke">Listen</span>
                <span class="fill">Listen</span>
            </div>
            <div class="text-wrapper small">
                <span class="stroke">and</span>
                <span class="fill">and</span>
            </div>
            <div class="text-wrapper">
                <span class="stroke">Choose</span>
                <span class="fill">Choose</span>
            </div>
        </div>

        {{-- 🔹 Các lựa chọn game --}}
        <div class="options d-flex justify-content-center flex-wrap gap-4">
            @foreach ([1, 2, 3] as $game)
                <a href="{{ route('admin.game_psi.game.show', ['game' => $game]) }}" class="option text-decoration-none">
                    <div class="number-wrapper">
                        <span class="stroke">{{ $game }}</span>
                        <span class="fill">{{ $game }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </main>

    <img src="{{ asset('admin/assets/images/game_psi/image_general/image60.png') }}" alt="Nhân vật"
        class="corner-image position-absolute bottom-0 end-0 img-fluid" style="max-width: 200px;">
@endsection
