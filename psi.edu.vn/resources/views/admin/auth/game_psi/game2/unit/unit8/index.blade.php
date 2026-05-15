@extends('admin.auth.game_psi.layout')

{{-- 1. ĐỊNH NGHĨA BIẾN THAM SỐ CHO UNIT --}}
@php
    $game_number = 2;
    $unit_number = 8;
    $unit_title = 'Unit 8: What do you wear when it’s hot?';

    // Dữ liệu cho game Order. $items chỉ dùng để render, $correctOrder dùng cho logic JS.
    $items = [
        ['name' => 'jacket', 'image_file' => 'jacket.jpg'],
        ['name' => 't-shirt', 'image_file' => 't-shirt.jpg'],
        ['name' => 'pants', 'image_file' => 'pants.jpg'],
        ['name' => 'skirt', 'image_file' => 'skirt.jpg'],
        ['name' => 'sandals', 'image_file' => 'sandals.jpg'],
        ['name' => 'shorts', 'image_file' => 'shorts.jpg'],
    ];

    // Dãy đáp án đúng theo thứ tự trong file audio script
    $correctOrder = ['jacket', 'pants', 'sandals', 'shorts', 'skirt', 't-shirt'];
    $audio_file_name = 'sat_level02_game08.mp3';
    $total_items = count($items);
@endphp

@section('title', 'Game ' . $game_number . ' - ' . $unit_title)

{{-- 2. ĐỊNH NGHĨA CSS VÀ POPUP STYLE --}}
@push('styles')
    {{-- Đã cập nhật đường dẫn CSS dùng $unit_number (Nếu có style riêng cho unit này) --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game' . $game_number . '/unit/unit1/style.css') }}">
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

        /* Style cho số thứ tự và hiệu ứng chọn */
        .character {
            position: relative;
            cursor: pointer;
        }

        .order-number {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #ffc107;
            /* Màu vàng nổi bật */
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 1.2em;
            z-index: 10;
        }

        /* Trạng thái đúng/sai sau khi kiểm tra */
        .character.correct {
            border: 5px solid #4CAF50 !important;
        }

        .character.wrong {
            border: 5px solid #F44336 !important;
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

            {{-- Navigation: Unit trước (Unit 7) và Unit tiếp theo (Unit 9) --}}
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
            <p class="instruction">Listen and order.</p>

            {{-- Audio tổng hợp (Đã cập nhật đường dẫn theo cấu trúc /images/.../sound/) --}}
            <audio id="combo-audio" controls>
                <source
                    src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/sound/{$audio_file_name}") }}"
                    type="audio/mp3">
                Trình duyệt của bạn không hỗ trợ thẻ audio.
            </audio>

            {{-- Hình nhân vật (Render từ $items) --}}
            <div class="characters">
                @foreach ($items as $item)
                    <div class="character" data-name="{{ $item['name'] }}">
                        <img src="{{ asset("admin/assets/images/game_psi/game{$game_number}/unit{$unit_number}/img/{$item['image_file']}") }}"
                            alt="{{ $item['name'] }}" />
                    </div>
                @endforeach
            </div>

            <div class="action-buttons">
                {{-- Nút chơi lại --}}
                <div class="restart-container">
                    <button id="restart-button">🔁 Chơi lại</button>
                </div>
                {{-- Nút kiểm tra --}}
                <div class="check-container">
                    <button id="check-button">✅ Kiểm tra</button>
                </div>
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
            // Lấy dãy đáp án đúng từ PHP/Blade
            const correctOrder = @json($correctOrder);
            let userSelections = [];

            const comboAudio = document.getElementById("combo-audio");
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const checkButton = document.getElementById('check-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');
            const totalItems = correctOrder.length;

            // Khóa nút kiểm tra ban đầu
            checkButton.disabled = true;

            // Khi audio phát → reset trò chơi
            comboAudio.addEventListener("play", () => {
                resetVisuals();
                checkButton.disabled = true;
            });

            // Sự kiện chọn ảnh
            characterImages.forEach(item => {
                item.addEventListener('click', () => {
                    const name = item.dataset.name;

                    // Không cho chọn nếu đã chọn đủ hoặc đã chọn rồi
                    if (userSelections.length >= totalItems || userSelections.includes(name))
                return;

                    userSelections.push(name);
                    item.classList.add('selected');

                    // Thêm số thứ tự chọn
                    const orderNumber = document.createElement('div');
                    orderNumber.className = 'order-number';
                    orderNumber.innerText = userSelections.length;
                    item.appendChild(orderNumber);

                    // Khi chọn đủ thì mở nút kiểm tra
                    if (userSelections.length === totalItems) {
                        checkButton.disabled = false;
                    }
                });
            });

            // Sự kiện bấm nút kiểm tra
            checkButton.addEventListener("click", () => {
                if (userSelections.length !== totalItems) return;

                let allCorrect = true;

                userSelections.forEach((selectedName, index) => {
                    const element = document.querySelector(
                        `.character[data-name="${selectedName}"]`);

                    // Xóa trạng thái cũ để cập nhật lại
                    element.classList.remove("correct", "wrong");

                    if (correctOrder[index] === selectedName) {
                        element.classList.add("correct");
                    } else {
                        element.classList.add("wrong");
                        allCorrect = false;
                    }
                });

                checkButton.disabled = true; // Khóa nút sau khi kiểm tra

                if (allCorrect) {
                    showPopup();
                }
            });

            // Sự kiện nút "Chơi lại"
            restartButton.addEventListener("click", resetGame);

            // Đóng popup
            closePopupButton.addEventListener('click', closePopup);

            function resetVisuals() {
                userSelections = [];
                characterImages.forEach(item => {
                    item.classList.remove("selected", "correct", "wrong");
                });
                document.querySelectorAll(".order-number").forEach(el => el.remove());
            }

            function resetGame() {
                resetVisuals();
                checkButton.disabled = true;
                comboAudio.pause();
                comboAudio.currentTime = 0;
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
