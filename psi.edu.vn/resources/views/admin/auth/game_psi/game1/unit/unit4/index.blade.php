@extends('admin.auth.game_psi.layout')

@section('title', 'Game 1 - Unit 4: What do you ride?')

@push('styles')
    {{-- Đảm bảo đường dẫn CSS này đúng --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game1/unit/unit2/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Basic styling for the popup (nên đưa vào layout cha nếu tất cả unit đều dùng) */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .popup.hidden {
            display: none;
        }

        /* Styling for the order numbers (cần cho game Listen and Order) */
        .order-number {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #ffcc00;
            color: #333;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 1.2em;
            border: 2px solid #ffa500;
        }

        .character.correct .order-number {
            background-color: #4CAF50;
            color: white;
            border-color: #388E3C;
        }

        .character.wrong .order-number {
            background-color: #F44336;
            color: white;
            border-color: #D32F2F;
        }

        .character {
            position: relative;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .character.selected {
            border-color: #007bff;
        }

        .character.correct {
            border-color: #4CAF50;
        }

        .character.wrong {
            border-color: #F44336;
        }

        /* Style for the new play audio button */
        .play-audio-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            margin: 20px auto;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .play-audio-btn:hover {
            background-color: #0056b3;
        }

        .play-audio-btn img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
    </style>
@endpush

@section('content')
    <header>
        <div class="header-wrapper">
            <div class="breadcrumb">
                {{-- Dùng route chuẩn: admin.game_psi.game.show với tham số game = 1 --}}
                <a href="{{ route('admin.game_psi.game.show', ['game' => 1]) }}">Phần 1</a>
                <span> &gt; Unit 4</span>
            </div>
            <h1>TRÒ CHƠI</h1>
            <p>Giúp bé phát triển tiếng Anh một cách tự nhiên</p>
        </div>
    </header>

    <main class="game-content">
        <div class="top-bar">
            {{-- Home Button --}}
            <a href="{{ route('admin.dashboard') }}">
                <button class="btn icon home">
                    <img src="{{ asset('admin/assets/images/game_psi/image_general/Group.png') }}" alt="home icon"
                        class="home-icon">
                </button>
            </a>
            {{-- Unit Index Button (Game 1) --}}
            <a href="{{ route('admin.game_psi.game.show', ['game' => 1]) }}">
                <button class="btn icon number">
                    <img src="{{ asset('admin/assets/images/game_psi/image_general/1.png') }}" alt="number 1 icon"
                        class="number-icon" />
                </button>
            </a>
            {{-- Navigation Prev (Unit 3) --}}
            {{-- Đã sửa route theo chuẩn: admin.game_psi.unit.show --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => 1, 'unit' => 3]) }}">
                <button class="btn nav"><span class="arrow">&laquo;</span></button>
            </a>
            {{-- Navigation Next (Unit 5) --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => 1, 'unit' => 5]) }}">
                <button class="btn nav"><span class="arrow">&raquo;</span></button>
            </a>
        </div>

        <div class="lesson-box">
            <div class="lesson-header">
                <img src="{{ asset('admin/assets/images/game_psi/image_general/Frame69.png') }}" class="touch-icon"
                    alt="touch icon">
                <h2>Unit 4: What do you ride?</h2>
            </div>
            <p class="instruction">Listen and order.</p>

            {{-- Nút "Nghe âm thanh" mới --}}
            <button id="play-audio-button" class="play-audio-btn">
                <img src="{{ asset('admin/assets/images/game_psi/image_general/audio_icon.png') }}" alt="Play Audio">
                Nghe âm thanh
            </button>

            {{-- Audio Element (Hidden by default, controlled by JS) --}}
            <audio id="combo-audio" controls style="display: none;">
                <source src="{{ asset('admin/assets/images/game_psi/game1/unit4/sound/sat_level01_game04.mp3') }}"
                    type="audio/mp3">
                Trình duyệt của bạn không hỗ trợ phần tử audio.
            </audio>

            {{-- Vùng nhân vật/tùy chọn --}}
            <div class="characters">
                @foreach (['bike', 'bus', 'train', 'car'] as $item)
                    <div class="character" data-name="{{ $item }}">
                        <img src="{{ asset("admin/assets/images/game_psi/game1/unit4/img/{$item}.jpg") }}"
                            alt="{{ $item }}" />
                    </div>
                @endforeach
            </div>

            <div class="restart-container">
                <button id="restart-button">🔁 Chơi lại</button>
            </div>
            <div class="check-container">
                <button id="check-button" disabled>✅ Kiểm tra</button>
            </div>
            <img src="{{ asset('admin/assets/images/game_psi/image_general/image60.png') }}" alt="Character illustration"
                class="corner-image">
        </div>
    </main>

    <div id="success-popup" class="popup hidden">
        <div class="popup-content">
            <h2>🎉 Chúc mừng!</h2>
            <p>Bạn đã làm đúng hết rồi!</p>
            <button id="close-popup-button">Đóng</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // MẢNG THỨ TỰ ĐÚNG
        const correctOrder = ["car", "bus", "bike", "train"];
        let userSelections = [];

        document.addEventListener('DOMContentLoaded', () => {
            const comboAudio = document.getElementById("combo-audio");
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const checkButton = document.getElementById('check-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');
            const playAudioButton = document.getElementById('play-audio-button');

            // Hàm hiển thị/đóng popup
            const showPopup = () => successPopup.classList.remove("hidden");
            const closePopup = () => successPopup.classList.add("hidden");

            // Hàm đặt lại trạng thái trò chơi
            const resetGame = () => {
                userSelections = [];
                characterImages.forEach(item => {
                    item.classList.remove("selected", "correct", "wrong");
                    const orderNumberElement = item.querySelector(".order-number");
                    if (orderNumberElement) {
                        orderNumberElement.remove(); // Xóa số thứ tự
                    }
                });
                checkButton.disabled = true;
                comboAudio.pause();
                comboAudio.currentTime = 0;
                closePopup();
            };

            // Sự kiện phát âm thanh
            if (playAudioButton) {
                playAudioButton.addEventListener('click', () => {
                    resetGame(); // Reset game trước khi bắt đầu nghe lại
                    comboAudio.play().catch(e => {
                        console.error("Lỗi khi phát âm thanh:", e);
                        alert(
                            "Trình duyệt có thể chặn tự động phát âm thanh. Vui lòng nhấp lại nút này."
                        );
                    });
                });
            }

            // Sự kiện chọn ảnh (Gán thứ tự)
            characterImages.forEach(character => {
                character.addEventListener('click', () => {
                    const name = character.dataset.name;

                    // Chỉ cho phép chọn khi chưa chọn (không trùng) và không ở trạng thái correct/wrong
                    if (userSelections.includes(name) || character.classList.contains('correct') ||
                        character.classList.contains('wrong')) {
                        return;
                    }

                    userSelections.push(name);
                    character.classList.add('selected');

                    // Thêm số thứ tự chọn
                    const orderNumber = document.createElement('div');
                    orderNumber.className = 'order-number';
                    orderNumber.innerText = userSelections.length;
                    character.appendChild(orderNumber);

                    // Mở nút kiểm tra khi chọn đủ
                    if (userSelections.length === 4) {
                        checkButton.disabled = false;
                    }
                });
            });

            // Sự kiện bấm nút kiểm tra
            checkButton.addEventListener("click", () => {
                if (userSelections.length !== 4) return;

                let allCorrect = true;
                checkButton.disabled = true; // Vô hiệu hóa nút kiểm tra sau khi kiểm tra

                userSelections.forEach((selectedName, index) => {
                    const element = document.querySelector(
                        `.character[data-name="${selectedName}"]`);
                    const orderNumberElement = element.querySelector('.order-number');

                    // Kiểm tra vị trí
                    if (correctOrder[index] === selectedName) {
                        element.classList.add("correct");
                        element.classList.remove("selected", "wrong");
                        if (orderNumberElement) orderNumberElement.classList.add('correct');
                    } else {
                        element.classList.add("wrong");
                        element.classList.remove("selected");
                        if (orderNumberElement) orderNumberElement.classList.add('wrong');
                        allCorrect = false;
                    }
                });

                if (allCorrect) {
                    showPopup();
                }
            });

            // Gán sự kiện cho nút "Chơi lại" và "Đóng" popup
            restartButton.addEventListener("click", resetGame);
            closePopupButton.addEventListener('click', closePopup);
        });
    </script>
@endpush
