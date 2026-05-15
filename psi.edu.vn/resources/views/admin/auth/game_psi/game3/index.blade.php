@extends('admin.auth.game_psi.layout')

{{-- 1. ĐỊNH NGHĨA BIẾN THAM SỐ CHO GAME --}}
@php
    $game_number = 3;

    // Danh sách các Unit trong Game 3
    $units = [
        ['unit' => 1, 'title' => 'Unit 1: What do animals eat?'],
        ['unit' => 2, 'title' => 'Unit 2: What can we learn about?'],
        ['unit' => 3, 'title' => 'Unit 3: What jobs do people do?'],
        ['unit' => 4, 'title' => 'Unit 4: What do we do on vacation?'],
        ['unit' => 5, 'title' => 'Unit 5: What do you do on a field trip?'],
        ['unit' => 6, 'title' => 'Unit 6: What does the weather do?'],
        ['unit' => 7, 'title' => 'Unit 7: What do you do in the library?'],
        ['unit' => 8, 'title' => 'Unit 8: How do we get around?'],
        ['unit' => 9, 'title' => 'Unit 9: How do we help others?'],
    ];
@endphp

@section('title', 'Phần ' . $game_number . ' - Trò chơi')

{{-- 2. ĐỊNH NGHĨA CSS --}}
@push('styles')
    {{-- Đường dẫn CSS được điều chỉnh theo chuẩn asset và số game --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game' . $game_number . '/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
@endpush

{{-- 3. NỘI DUNG CHÍNH CỦA TRANG (BODY) --}}
@section('content')
    <header>
        <div class="header-wrapper">
            <div class="breadcrumb">
                {{-- Route về trang mục lục chung --}}
                <a href="{{ route('admin.game_psi.index') }}">Mục lục</a> <span> &gt; Phần {{ $game_number }}</span>
            </div>
            <h1>TRÒ CHƠI</h1>
            <p>Giúp bé phát triển tiếng Anh một cách tự nhiên</p>
        </div>
    </header>
    <main class="game-content">
        <div class="mota-container">
            <div class="number-wrapper">
                <span class="stroke">{{ $game_number }}</span>
                <span class="fill">{{ $game_number }}</span>
            </div>
            <div class="mota">
                {{-- Đường dẫn hình ảnh được điều chỉnh theo chuẩn asset --}}
                <img src="{{ asset('admin/assets/images/game_psi/image_general/pz.svg') }}" alt="Puzzle icon"
                    class="puzzle">
                <p>Một số trò chơi thú vị giúp bé học từ vựng, phát âm và giao tiếp</p>
            </div>
        </div>
        <div class="trochoi-container">
            {{-- Lặp qua danh sách Unit để tạo các liên kết --}}
            @foreach ($units as $unit)
                <div class="trochoi">
                    {{-- Sử dụng route động để trỏ đến trang Unit tương ứng --}}
                    <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => $unit['unit']]) }}">
                        {{ $unit['title'] }}
                    </a>
                </div>
            @endforeach
        </div>

        <div class="corner-wrapper">
            {{-- Đường dẫn hình ảnh được điều chỉnh theo chuẩn asset --}}
            <img src="{{ asset('admin/assets/images/game_psi/image_general/image60.png') }}" alt="ảnh minh họa"
                class="corner-image">
        </div>
    </main>
@endsection

{{-- Không cần push script cho trang Index này --}}
