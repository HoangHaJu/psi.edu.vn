@extends('admin.auth.game_psi.layout')

{{-- 1. ĐỊNH NGHĨA BIẾN THAM SỐ CHO UNIT --}}
@php
    $game_number = 3;
    $unit_number = 9;
    $unit_title = 'Unit 9: When do we change our clothes?';

    // Dữ liệu cho game Match: [answer] là tên từ, [display] là hiển thị trên nút, [file] là tên file audio.
    $items = [
        ['answer' => 'shirt', 'display' => 'shirt', 'file' => 'shirt.mp3'],
        ['answer' => 'slippers', 'display' => 'slippers', 'file' => 'slippers.mp3'],
        ['answer' => 'jeans', 'display' => 'jeans', 'file' => 'jeans.mp3'],
        ['answer' => 'pajamas', 'display' => 'pajamas', 'file' => 'pajamas.mp3'],
        ['answer' => 'tracksuit', 'display' => 'tracksuit', 'file' => 'tracksuit.mp3'],
        ['answer' => 'sneakers', 'display' => 'sneakers', 'file' => 'sneakers.mp3'],
    ];

    $total_items = count($items);
@endphp

@section('title', 'Game ' . $game_number . ' - ' . $unit_title)

{{-- 2. ĐỊNH NGHĨA CSS VÀ POPUP STYLE --}}
@push('styles')
    {{-- ĐƯỜNG DẪN CSS ĐƯỢC GIỮ CỐ ĐỊNH NHƯ YÊU CẦU: DÙNG style.css CỦA UNIT 1 --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game3/unit/unit1/style.css') }}">
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
            pointer-events: none;
            /* Đảm bảo không thể click ngay cả khi đang ở trạng thái active */
        }

        /* Hiển thị chữ cho nút audio */
        .audio strong.p {
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
@endpush

{{-- 3. NỘI DUNG CHÍNH CỦA TRANG (BODY) --}}
@section('content')
    <header>
        <div class="header-wrapper">
            <div class="breadcrumb">
                {{-- Dùng route động --}}
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

            {{-- Navigation: Unit trước (Unit 8) --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => $unit_number - 1]) }}">
                <button class="btn nav"><span class="arrow">&laquo;</span></button>
            </a>

            {{-- Navigation: Unit tiếp theo (Unit 9 hiện tại) --}}
            {{-- Giữ nguyên trỏ về chính nó hoặc vô hiệu hóa vì là Unit cuối cùng --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => $game_number, 'unit' => 1]) }}">
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

            {{-- Nút âm thanh và từ vựng --}}
            <div class="audio-buttons">
                @foreach ($items as $item)
                    <button class="audio" data-answer="{{ $item['answer'] }}" {{-- Đường dẫn audio: /admin/assets/images/game3/unit9/sound/{file} --}}
                        data-sound="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/sound/{$item['file']}") }}">
                        <strong class="p">{{ $item['display'] }}</strong>
                    </button>
                @endforeach
            </div>

            {{-- Hình nhân vật (Giữ nguyên thứ tự trong HTML gốc) --}}
            <div class="characters">
                {{-- data-name phải khớp với data-answer của nút audio tương ứng --}}
                <div class="character" data-name="jeans">
                    <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/jeans.jpg") }}"
                        alt="jeans" />
                </div>
                <div class="character" data-name="pajamas">
                    <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/pajamas.jpg") }}"
                        alt="pajamas" />
                </div>
                <div class="character" data-name="shirt">
                    <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/shirt.jpg") }}"
                        alt="shirt" />
                </div>
                <div class="character" data-name="slippers">
                    <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/slippers.jpg") }}"
                        alt="slippers" />
                </div>
                <div class="character" data-name="sneakers">
                    <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/sneakers.jpg") }}"
                        alt="sneakers" />
                </div>
                <div class="character" data-name="tracksuit">
                    <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/tracksuit.jpg") }}"
                        alt="tracksuit" />
                </div>
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
            // Lấy danh sách đáp án (Thứ tự phải khớp với thứ tự các nút audio/items)
            const answers = @json(collect($items)->pluck('answer'));
            let currentAudioIndex = null;

            const audioButtons = document.querySelectorAll('.audio');
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');
            const totalCorrectAnswers = answers.length;

            // Xử lý khi bấm nút âm thanh
            audioButtons.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (btn.disabled) return;

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
