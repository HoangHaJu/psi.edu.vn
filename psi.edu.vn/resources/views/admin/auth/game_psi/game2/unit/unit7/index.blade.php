@extends('admin.auth.game_psi.layout')

{{-- 1. ĐỊNH NGHĨA BIẾN THAM SỐ CHO UNIT --}}
@php
    $game_number = 2;
    $unit_number = 7;
    $unit_title = 'Unit 7: What do farm animals do?';

    // Dữ liệu cho các mục cần match: [answer] là tên từ, [file] là tên file audio, [image_file] là tên file ảnh.
    // Đảm bảo thứ tự trong $items khớp với thứ tự các nút audio.
    $items = [
        ['answer' => 'horse', 'file' => 'horse.mp3', 'image_file' => 'horse.jpg'],
        ['answer' => 'donkey', 'file' => 'donkey.mp3', 'image_file' => 'donkey.jpg'],
        ['answer' => 'chicken', 'file' => 'chicken.mp3', 'image_file' => 'chicken.jpg'],
        ['answer' => 'cow', 'file' => 'cow.mp3', 'image_file' => 'cow.jpg'],
        ['answer' => 'sheep', 'file' => 'sheep.mp3', 'image_file' => 'sheep.jpg'],
        ['answer' => 'goat', 'file' => 'goat.mp3', 'image_file' => 'goat.jpg'],
    ];

    $total_items = count($items);
@endphp

@section('title', 'Game ' . $game_number . ' - ' . $unit_title)

{{-- 2. ĐỊNH NGHĨA CSS VÀ POPUP STYLE --}}
@push('styles')
    {{-- Đã cập nhật đường dẫn CSS dùng $unit_number (Sử dụng style chung của game2) --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game' . $game_number . '/unit/unit2/style.css') }}">
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

        /* Tùy chọn: Thêm CSS cho hiệu ứng đúng/sai */
        .character.correct {
            border: 5px solid #4CAF50 !important;
        }

        .character.wrong {
            border: 5px solid #F44336 !important;
            animation: shake 0.5s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
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

            {{-- Navigation: Unit trước (Unit 6) và Unit tiếp theo (Unit 8) --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => $unit_number - 1]) }}"
                class="btn nav"><span class="arrow">&laquo;</span></a>
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

            {{-- Nút âm thanh (Đã cập nhật đường dẫn theo cấu trúc /images/.../sound/) --}}
            <div class="audio-buttons">
                @foreach ($items as $item)
                    <button class="audio" data-answer="{{ $item['answer'] }}" {{-- Đường dẫn audio: /admin/assets/images/game2/unit7/sound/{file} --}}
                        data-sound="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/sound/{$item['file']}") }}">
                        <img src="{{ asset('admin/assets/images/game_psi/image_general/speaker.svg') }}" alt="speaker icon"
                            class="icon-loa">
                    </button>
                @endforeach
            </div>

            {{-- Hình nhân vật (Render từ $items) --}}
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
            // Lấy danh sách đáp án từ dữ liệu PHP/Blade (đã được định nghĩa theo thứ tự nút audio)
            const answers = @json(collect($items)->pluck('answer'));
            let currentAudioIndex = null;

            const audioButtons = document.querySelectorAll('.audio');
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');
            const totalCorrectAnswers = answers.length; // Số lượng đáp án là 6

            // Phát âm thanh và chọn đáp án
            audioButtons.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (btn.disabled) return;
                    currentAudioIndex = index;
                    // Tạo một đối tượng Audio mới mỗi lần click để phát lại mà không bị gián đoạn
                    new Audio(btn.dataset.sound).play();
                });
            });

            // Kiểm tra chọn đúng/sai
            characterImages.forEach(character => {
                character.addEventListener('click', () => {
                    if (currentAudioIndex === null) return;

                    // Nếu đã chọn đúng rồi thì bỏ qua
                    if (character.classList.contains('correct')) return;

                    // Xóa trạng thái sai (nếu có)
                    character.classList.remove('wrong');
                    const selected = character.dataset.name.toLowerCase();
                    const correct = answers[currentAudioIndex].toLowerCase();

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
                        setTimeout(() => character.classList.remove('wrong'),
                        500); // Xóa hiệu ứng lắc
                    }
                    // Reset index sau khi chọn để người dùng phải nghe lại hoặc chọn audio khác
                    currentAudioIndex = null;
                });
            });

            // Nút chơi lại
            restartButton.addEventListener('click', () => {
                characterImages.forEach(el => {
                    el.classList.remove('correct', 'wrong');
                });
                // Bật lại tất cả các nút audio
                audioButtons.forEach(btn => btn.disabled = false);
                currentAudioIndex = null;
                closePopup();
            });

            // Đóng popup
            closePopupButton.addEventListener('click', closePopup);

            // Hiện popup
            function showPopup() {
                successPopup.classList.remove("hidden");
            }

            // Đóng popup
            function closePopup() {
                successPopup.classList.add("hidden");
            }
        });
    </script>
@endpush
