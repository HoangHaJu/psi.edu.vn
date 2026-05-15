@extends('admin.auth.game_psi.layout')

{{-- 1. ĐỊNH NGHĨA BIẾN THAM SỐ CHO UNIT --}}
@php
    $game_number = 3;
    $unit_number = 2;
    $unit_title = 'Unit 2: What do you like to eat?';

    // Dữ liệu cho game Match: [answer] là tên từ, [file] là tên file audio, [image_file] là tên file ảnh.
    // Đảm bảo thứ tự trong $items khớp với thứ tự các nút audio.
    $items = [
        ['answer' => 'meat', 'file' => 'meat.mp3', 'image_file' => 'meat.jpg'],
        ['answer' => 'milk', 'file' => 'milk.mp3', 'image_file' => 'milk.jpg'],
        ['answer' => 'fruit', 'file' => 'fruit.mp3', 'image_file' => 'fruit.jpg'],
        ['answer' => 'vegetables', 'file' => 'vegetables.mp3', 'image_file' => 'vegetables.jpg'],
        ['answer' => 'pasta', 'file' => 'pasta.mp3', 'image_file' => 'pasta.jpg'],
        ['answer' => 'rice', 'file' => 'rice.mp3', 'image_file' => 'rice.jpg'],
    ];

    $total_items = count($items);
@endphp

@section('title', 'Game ' . $game_number . ' - ' . $unit_title)

{{-- 2. ĐỊNH NGHĨA CSS VÀ POPUP STYLE --}}
@push('styles')
    {{-- Đã cập nhật đường dẫn CSS dùng $unit_number --}}
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

        /* Thêm CSS cho hiệu ứng đúng/sai */
        .character {
            cursor: pointer;
        }

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

        /* Thêm CSS cho nút audio được chọn */
        .audio.active {
            background-color: #ffc107;
            /* Màu vàng nổi bật */
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.8);
            transform: scale(1.05);
        }

        .audio[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
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

            {{-- Nút về trang chính Game 3 --}}
            <a href="{{ route('admin.game_psi.game.show', ['game' => $game_number]) }}">
                <button class="btn icon number">
                    {{-- Dùng ảnh số 3 --}}
                    <img src="{{ asset('admin/assets/images/game_psi/image_general/' . $game_number . '.png') }}"
                        alt="number {{ $game_number }} icon" class="number-icon" />
                </button>
            </a>

            {{-- Navigation: Unit trước (Unit 1) --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => $unit_number - 1]) }}">
                <button class="btn nav"><span class="arrow">&laquo;</span></button>
            </a>

            {{-- Navigation: Unit tiếp theo (Unit 3) --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => $unit_number + 1]) }}">
                <button class="btn nav"><span class="arrow">&raquo;</span></button>
            </a>
        </div>

        <div class="lesson-box">
            <div class="lesson-header">
                <img src="{{ asset('admin/assets/images/game_psi/image_general/Frame69.png') }}" class="touch-icon"
                    alt="touch icon">
                <h2>{{ $unit_title }}</h2>
            </div>
            <p class="instruction">Listen and match.</p>

            {{-- Nút âm thanh (Không có từ vựng kèm theo, chỉ có biểu tượng loa) --}}
            <div class="audio-buttons">
                @foreach ($items as $item)
                    <button class="audio" data-answer="{{ $item['answer'] }}" {{-- Đường dẫn audio: /admin/assets/images/game3/unit2/sound/{file} --}}
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
            // Lấy danh sách đáp án từ dữ liệu PHP/Blade (đã được định nghĩa theo thứ tự nút audio)
            const answers = @json(collect($items)->pluck('answer'));
            let currentAudioIndex = null;

            const audioButtons = document.querySelectorAll('.audio');
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');
            const totalCorrectAnswers = answers.length; // Số lượng đáp án là 6

            // Xử lý khi bấm nút âm thanh
            audioButtons.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (btn.disabled) return; // Bỏ qua nếu đã chọn đúng và bị vô hiệu hóa

                    // Bỏ highlight audio cũ và highlight audio mới
                    audioButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    currentAudioIndex = index;
                    // Phát âm thanh
                    new Audio(btn.dataset.sound).play();
                });
            });

            // Xử lý khi bấm vào hình ảnh
            characterImages.forEach(character => {
                character.addEventListener('click', () => {
                    if (currentAudioIndex === null) return;

                    // Nếu đã chọn đúng rồi thì bỏ qua
                    if (character.classList.contains('correct')) return;

                    // Xóa trạng thái sai (nếu có)
                    character.classList.remove('wrong');

                    const selected = character.dataset.name.toLowerCase();
                    const correct = answers[currentAudioIndex].toLowerCase();
                    const currentAudioButton = audioButtons[currentAudioIndex];

                    if (selected === correct) {
                        character.classList.add('correct');
                        currentAudioButton.classList.remove('active'); // Bỏ highlight
                        currentAudioButton.disabled =
                        true; // Vô hiệu hóa nút audio sau khi chọn đúng
                        currentAudioIndex = null; // Reset audio index sau khi chọn thành công

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
                });
            });

            // Nút chơi lại
            restartButton.addEventListener('click', () => {
                // Reset trạng thái hình ảnh
                characterImages.forEach(el => {
                    el.classList.remove('correct', 'wrong');
                });
                // Reset trạng thái nút audio
                audioButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('active');
                });
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
