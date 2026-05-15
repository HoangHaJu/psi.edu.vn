@extends('admin.auth.game_psi.layout')

@section('title', 'Trò chơi - Listen and Choose | Game 2')

@push('styles')
    {{-- Đảm bảo bạn đã có tệp style.css cho Game 2 tại đường dẫn này --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game2/style.css') }}">
    {{-- Các font đã được nhúng trong layout chung hoặc có thể thêm ở đây nếu cần thiết --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> --}}
@endpush

@section('content')
    <header>
        <div class="header-wrapper">
            <div class="breadcrumb">
                <a href="{{ route('admin.game_psi.index') }}">Mục lục</a>
                {{-- Đã đổi từ "Phần 2" thành "Game 2" để nhất quán với tiêu đề Game 1 --}}
                <span> &gt; Game 2</span>
            </div>
            <h1>TRÒ CHƠI - LISTEN AND CHOOSE</h1>
            <p>Giúp bé phát triển tiếng Anh một cách tự nhiên</p>
        </div>
    </header>

    <main class="game-content">
        {{-- Phần mô tả --}}
        <div class="mota-container">
            <div class="number-wrapper">
                <span class="stroke">2</span>
                <span class="fill">2</span>
            </div>
            <div class="mota">
                <img src="{{ asset('admin/assets/images/game_psi/image_general/pz.svg') }}" alt="Puzzle icon"
                    class="puzzle">
                <p>Một số trò chơi thú vị giúp bé học từ vựng, phát âm và giao tiếp</p>
            </div>
        </div>

        {{-- Danh sách các Unit --}}
        <div class="trochoi-container">
            @php
                // Mảng chứa tên các Unit cho Game 2
                $units = [
                    'Unit 1: How do you make a picture?',
                    'Unit 2: What can you do in the park?',
                    'Unit 3: Who makes you happy?',
                    'Unit 4: What happens when it’s windy?',
                    'Unit 5: What’s in your house?',
                    'Unit 6: What happens in the garden?',
                    'Unit 7: What do farm animals do?',
                    'Unit 8: What do you wear when it’s hot?',
                    'Unit 9: What do our senses tell us?',
                ];
            @endphp

            @foreach ($units as $index => $title)
                <div class="trochoi">
                    {{-- Sử dụng route chuẩn: 'admin.game_psi.unit.show' với tham số 'game' là 2 và 'unit' là $index + 1 --}}
                    <a href="{{ route('admin.game_psi.unit.show', ['game' => 2, 'unit' => $index + 1]) }}">
                        {{ $title }}
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Ảnh góc --}}
        <div class="corner-wrapper">
            <img src="{{ asset('admin/assets/images/game_psi/image_general/image60.png') }}" alt="Ảnh minh họa"
                class="corner-image">
        </div>
    </main>
@endsection
