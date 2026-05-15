@extends('admin.auth.game_psi.layout')

{{-- 1. ĐỊNH NGHĨA BIẾN THAM SỐ CHO UNIT --}}
@php
    $game_number = 2;
    $unit_number = 2;
    $unit_title = 'Unit 2: What can you do in the park? (Actions)';

    // Dữ liệu cho các mục cần match.
    // Dãy đáp án cần chọn theo thứ tự SCRIPT.
    $script_answers = ['climb', 'run', 'catch', 'walk', 'kick', 'build'];

    // Các hình ảnh có sẵn trong thư mục, cần hiển thị
    $display_items = [
        ['name' => 'build', 'image_file' => 'build.jpg'],
        ['name' => 'catch', 'image_file' => 'catch.jpg'],
        ['name' => 'climb', 'image_file' => 'climb.jpg'],
        ['name' => 'kick', 'image_file' => 'kick.jpg'],
        ['name' => 'run', 'image_file' => 'run.jpg'],
        ['name' => 'walk', 'image_file' => 'walk.jpg'],
    ];

    // File âm thanh chung được xác định từ thư mục unit2/sound
    $audio_file_name = 'sat_level02_game02.mp3';
    $total_items = count($script_answers);
@endphp

@section('title', 'Game ' . $game_number . ' - ' . $unit_title)

{{-- 2. ĐỊNH NGHĨA CSS VÀ POPUP STYLE --}}
@push('styles')
    <link rel="stylesheet"
        href="{{ asset('admin/assets/css/game_psi/game' . $game_number . '/unit/unit' . $unit_number . '/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Popup Style */
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

        /* Cần thêm style cho nút play chung */
        #main-audio-button {
            background-color: #ff5722;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.2em;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        #main-audio-button:hover:not(:disabled) {
            background-color: #e64a19;
        }

        #main-audio-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Hiệu ứng khi chọn đúng */
        .character.correct {
            border: 5px solid #4CAF50 !important;
            opacity: 0.5;
            /* Mờ đi hình đã chọn */
            pointer-events: none;
            /* Không cho chọn lại */
        }

        /* Hiệu ứng khi chọn sai */
        .character.wrong {
            animation: shake 0.5s;
            border: 5px solid #F44336 !important;
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

            {{-- Navigation: Unit trước (Unit 1), Unit tiếp theo (Unit 3) --}}
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
            <p class="instruction">🎧 Bấm nút Play, sau đó chọn các hình theo thứ tự bạn nghe được.</p>

            {{-- Nút Play chung và Audio ẩn --}}
            <div class="audio-buttons">
                <button id="main-audio-button">▶️ Play Script</button>
                <audio id="combo-audio" style="display: none;">
                    {{-- Đường dẫn audio được sửa để sử dụng /images/.../unit2/sound/ --}}
                    <source
                        src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/sound/{$audio_file_name}") }}"
                        type="audio/mp3">
                </audio>
            </div>

            {{-- Hình nhân vật --}}
            <div class="characters">
                @foreach ($display_items as $item)
                    <div class="character" data-name="{{ $item['name'] }}">
                        <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/{$item['image_file']}") }}"
                            alt="{{ $item['name'] }}" />
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
            // Dãy đáp án đúng theo thứ tự trong file audio script (cần đảm bảo thứ tự này là đúng)
            const scriptAnswers = @json($script_answers);
            let currentStepIndex = 0; // Theo dõi thứ tự chọn hiện tại

            const mainAudioButton = document.getElementById('main-audio-button');
            const comboAudio = document.getElementById('combo-audio');
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');
            const totalCorrectAnswers = scriptAnswers.length;

            // 1. Phát audio chung
            mainAudioButton.addEventListener('click', () => {
                if (mainAudioButton.disabled) return;
                comboAudio.play();
                // Tùy chọn: Vô hiệu hóa nút play trong khi âm thanh đang phát (hoặc luôn vô hiệu hóa nếu chỉ nghe 1 lần)
                // mainAudioButton.disabled = true;
            });

            // 2. Xử lý khi chọn hình ảnh
            characterImages.forEach(character => {
                character.addEventListener('click', () => {
                    // Chỉ cho phép chọn nếu chưa hoàn thành game
                    if (currentStepIndex >= totalCorrectAnswers) return;
                    if (character.classList.contains('correct')) return;

                    character.classList.remove('wrong'); // Xóa trạng thái sai cũ
                    const selected = character.dataset.name.toLowerCase();
                    const correct = scriptAnswers[currentStepIndex].toLowerCase();

                    if (selected === correct) {
                        character.classList.add('correct');
                        currentStepIndex++; // Tăng bước khi chọn đúng

                        // Phát âm thanh chúc mừng ngắn (Tùy chọn)

                        // Kiểm tra hoàn thành game
                        if (currentStepIndex === totalCorrectAnswers) {
                            showPopup();
                            mainAudioButton.disabled = true;
                        }
                    } else {
                        // Chọn sai
                        character.classList.add('wrong');
                        // Tùy chọn: Phát âm thanh báo sai
                        setTimeout(() => character.classList.remove('wrong'),
                        500); // Xóa hiệu ứng lắc
                    }
                });
            });

            // 3. Nút Chơi lại
            restartButton.addEventListener('click', resetGame);
            closePopupButton.addEventListener('click', closePopup);

            function resetGame() {
                characterImages.forEach(el => el.classList.remove('correct', 'wrong'));
                currentStepIndex = 0;
                mainAudioButton.disabled = false;
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
