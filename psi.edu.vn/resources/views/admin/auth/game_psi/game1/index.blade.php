@extends('admin.auth.game_psi.layout')

@section('title', 'Trò chơi - Listen and Choose | Game 1')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game1/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
@endpush

@section('content')
    <header>
        <div class="header-wrapper">
            <div class="breadcrumb">
                <a href="{{ route('admin.game_psi.index') }}">Mục lục</a>
                <span> &gt; Game 1</span>
            </div>
            <h1>TRÒ CHƠI - LISTEN AND CHOOSE</h1>
            <p>Giúp bé phát triển tiếng Anh một cách tự nhiên</p>
        </div>
    </header>

    <main class="game-content">
        {{-- Phần mô tả --}}
        <div class="mota-container">
            <div class="number-wrapper">
                <span class="stroke">1</span>
                <span class="fill">1</span>
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
                $units = [
                    'Unit 1: Who’s in your family?',
                    'Unit 2: What’s this?',
                    'Unit 3: How many eyes?',
                    'Unit 4: What do you ride?',
                    'Unit 5: What can you find outside?',
                    'Unit 6: What’s in the toy box?',
                    'Unit 7: What pets do you like?',
                    'Unit 8: What can you do?',
                    'Unit 9: What snacks do you like?',
                ];
            @endphp

            @foreach ($units as $index => $title)
                <div class="trochoi">
                    <a href="{{ route('admin.game_psi.unit.show', ['game' => 1, 'unit' => $index + 1]) }}">
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
