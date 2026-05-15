@extends('admin.auth.game_psi.layout')

{{-- 1. ĐỊNH NGHĨA BIẾN THAM SỐ CHO UNIT --}}
@php
    $game_number = 2;
    $unit_number = 1;
    $unit_title = 'Unit 1: How do we make pictures?';

    // Dữ liệu cho các mục cần match: [answer] là tên từ, [file] là tên file.
    $items = [
        // Chú ý: Đường dẫn âm thanh giờ đây trỏ đến /images/.../sound/
        ['answer' => 'eraser', 'file' => 'eraser.mp3', 'image_file' => 'eraser.jpg'],
        ['answer' => 'brush', 'file' => 'brush.mp3', 'image_file' => 'brush.jpg'],
        ['answer' => 'pen', 'file' => 'pen.mp3', 'image_file' => 'pen.jpg'],
        ['answer' => 'paper', 'file' => 'paper.mp3', 'image_file' => 'paper.jpg'],
        ['answer' => 'glitter', 'file' => 'glitter.mp3', 'image_file' => 'glitter.jpg'],
        ['answer' => 'paint', 'file' => 'paint.mp3', 'image_file' => 'paint.jpg'],
    ];

    $total_items = count($items);
@endphp

@section('title', 'Game ' . $game_number . ' - ' . $unit_title)

{{-- 2. ĐỊNH NGHĨA CSS VÀ POPUP STYLE --}}
@push('styles')
    {{-- CSS riêng cho Unit 1 của Game 2 --}}
    <link rel="stylesheet"
        href="{{ asset('admin/assets/css/game_psi/game' . $game_number . '/unit/unit' . $unit_number . '/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Popup style */
        .popup {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .popup.hidden {
            display: none;
        }
    </style>
@endpush

{{-- 3. NỘI DUNG CHÍNH CỦA TRANG (BODY) --}}
@section('content')
    <header>
        <div class="header-wrapper">
            <div class="breadcrumb">
                <a href="{{ route('admin.game_psi.game.show', ['game' => $game_number]) }}">Phần {{ $game_number }}</a>
                <span> &gt; Unit {{ $unit_number }}</span>
            </div>
            <h1>TRÒ CHƠI</h1>
            <p>Giúp bé phát triển tiếng Anh một cách tự nhiên</p>
        </div>
    </header>

    <main class="game-content">
        <div class="top-bar">
            {{-- Nút Home --}}
            <a href="{{ route('admin.dashboard') }}">
                <button class="btn icon home">
                    <img src="{{ asset('admin/assets/images/game_psi/image_general/Group.png') }}" alt="home icon"
                        class="home-icon">
                </button>
            </a>

            {{-- Nút về trang chính Game 2 --}}
            <a href="{{ route('admin.game_psi.game.show', ['game' => $game_number]) }}">
                <button class="btn icon number">
                    <img src="{{ asset('admin/assets/images/game_psi/image_general/' . $game_number . '.png') }}"
                        alt="number {{ $game_number }} icon" class="number-icon" />
                </button>
            </a>

            {{-- Navigation --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => $unit_number]) }}"
                class="btn nav disabled"><span class="arrow">&laquo;</span></a>
            <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => $unit_number + 1]) }}"
                class="btn nav"><span class="arrow">&raquo;</span></a>

        </div>

        <div class="lesson-box">
            <div class="lesson-header">
                <img src="{{ asset('admin/assets/images/game_psi/image_general/Frame69.png') }}" class="touch-icon"
                    alt="touch icon">
                <h2>{{ $unit_title }}</h2>
            </div>
            <p class="instruction">Listen and match.</p>

            {{-- Nút âm thanh (Đường dẫn audio đã được sửa theo yêu cầu) --}}
            <div class="audio-buttons">
                @foreach ($items as $item)
                    <button class="audio" data-answer="{{ $item['answer'] }}" {{-- **Đường dẫn audio đã được sửa để sử dụng /images/.../unit1/sound/** --}}
                        data-sound="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/sound/{$item['file']}") }}">
                        <img src="{{ asset('admin/assets/images/game_psi/image_general/speaker.svg') }}" alt="speaker icon"
                            class="icon-loa">
                    </button>
                @endforeach
            </div>

            {{-- Hình nhân vật --}}
            <div class="characters">
                @foreach ($items as $item)
                    <div class="character" data-name="{{ $item['answer'] }}">
                        <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/{$item['image_file']}") }}"
                            alt="{{ $item['answer'] }}" />
                    </div>
                @endforeach
            </div>

            {{-- Nút chơi lại --}}
            <div class="restart-container">
                <button id="restart-button">🔁 Chơi lại</button>
            </div>

            {{-- Ảnh góc --}}
            <img src="{{ asset('admin/assets/images/game_psi/image_general/image60.png') }}" alt="Character illustration"
                class="corner-image">
        </div>
    </main>

    {{-- Popup chúc mừng --}}
    <div id="success-popup" class="popup hidden">
        <div class="popup-content">
            <h2>🎉 Chúc mừng!</h2>
            <p>Bạn đã làm đúng hết rồi!</p>
            <button id="close-popup-button">Đóng</button>
        </div>
    </div>
@endsection

{{-- 4. LOGIC JAVASCRIPT --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Lấy danh sách đáp án từ dữ liệu PHP/Blade
            const answers = @json(collect($items)->pluck('answer'));
            let currentAudioIndex = null;

            const audioButtons = document.querySelectorAll('.audio');
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');
            const totalCorrectAnswers = answers.length;

            // Phát âm thanh và chọn đáp án
            audioButtons.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (btn.disabled) return;
                    currentAudioIndex = index;
                    new Audio(btn.dataset.sound).play();
                });
            });

            // Kiểm tra chọn đúng/sai
            characterImages.forEach(character => {
                character.addEventListener('click', () => {
                    if (currentAudioIndex === null) return;
                    if (character.classList.contains('correct')) return;

                    const selected = character.dataset.name.toLowerCase();
                    const correct = answers[currentAudioIndex].toLowerCase();

                    character.classList.remove('wrong');

                    if (selected === correct) {
                        character.classList.add('correct');
                        // Tối ưu: Vô hiệu hóa nút audio sau khi chọn đúng
                        audioButtons[currentAudioIndex].disabled = true;

                        // Kiểm tra nếu đã đúng hết tất cả hình ảnh
                        if (document.querySelectorAll('.character.correct').length ===
                            totalCorrectAnswers) {
                            showPopup();
                        }
                    } else {
                        character.classList.add('wrong');
                    }
                    // Reset index sau khi chọn để người dùng phải nghe lại hoặc chọn audio khác
                    currentAudioIndex = null;
                });
            });

            restartButton.addEventListener('click', resetGame);
            closePopupButton.addEventListener('click', closePopup);

            function resetGame() {
                characterImages.forEach(el => el.classList.remove('correct', 'wrong'));
                // Bật lại tất cả các nút audio
                audioButtons.forEach(btn => btn.disabled = false);
                currentAudioIndex = null;
                closePopup();
            }

            function showPopup() {
                successPopup.classList.remove("hidden");
            }

            function closePopup() {
                successPopup.classList.add("hidden");
            }
        });
    </script>
@endpush
