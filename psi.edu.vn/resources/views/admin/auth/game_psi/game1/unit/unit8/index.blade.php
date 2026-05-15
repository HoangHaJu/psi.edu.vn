@extends('admin.auth.game_psi.layout')

@section('title', 'Game 1 - Unit 8: What can you do?')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/game_psi/game1/unit/unit2/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
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

@section('content')
    <header>
        <div class="header-wrapper">
            <div class="breadcrumb">
                <a href="{{ route('admin.game_psi.game.show', ['game' => 1]) }}">Phần 1</a>
                <span> &gt; Unit 8</span>
            </div>
            <h1>TRÒ CHƠI</h1>
            <p>Giúp bé phát triển tiếng Anh một cách tự nhiên</p>
        </div>
    </header>

    <main class="game-content">
        <div class="top-bar">
            <a href="{{ route('admin.dashboard') }}">
                <button class="btn icon home">
                    <img src="{{ asset('admin/assets/images/game_psi/image_general/Group.png') }}" alt="home icon"
                        class="home-icon">
                </button>
            </a>

            <a href="{{ route('admin.game_psi.game.show', ['game' => 1]) }}">
                <button class="btn icon number">
                    <img src="{{ asset('admin/assets/images/game_psi/image_general/1.png') }}" alt="number 1 icon"
                        class="number-icon" />
                </button>
            </a>

            {{-- Navigation --}}
            <a href="{{ route('admin.game_psi.unit.show', ['game' => 1, 'unit' => 7]) }}" class="btn nav"><span
                    class="arrow">&laquo;</span></a>
            <a href="{{ route('admin.game_psi.unit.show', ['game' => 1, 'unit' => 9]) }}" class="btn nav"><span
                    class="arrow">&raquo;</span></a>
        </div>

        <div class="lesson-box">
            <div class="lesson-header">
                <img src="{{ asset('admin/assets/images/game_psi/image_general/Frame69.png') }}" class="touch-icon"
                    alt="touch icon">
                <h2>Unit 8: What can you do?</h2>
            </div>
            <p class="instruction">Listen and match.</p>

            {{-- Nút âm thanh --}}
            <div class="audio-buttons">
                @php
                    // CẬP NHẬT: Thay thế run/jump/sing/dance bằng blow/bounce/roll/stack
                    $audioData = [
                        ['answer' => 'blow', 'file' => 'blow.mp3'], // Giả định blow.mp3
                        ['answer' => 'bounce', 'file' => 'bounce.mp3'], // Giả định bounce.mp3
                        ['answer' => 'roll', 'file' => 'roll.mp3'], // Giả định roll.mp3
                        ['answer' => 'stack', 'file' => 'stack.mp3'], // Giả định stack.mp3
                    ];
                @endphp

                @foreach ($audioData as $audio)
                    <button class="audio" data-answer="{{ $audio['answer'] }}"
                        data-sound="{{ asset("admin/assets/images/game_psi/game1/unit8/sound/{$audio['file']}") }}">
                        <img src="{{ asset('admin/assets/images/game_psi/image_general/speaker.svg') }}" alt="speaker icon"
                            class="icon-loa">
                    </button>
                @endforeach
            </div>

            {{-- Hình nhân vật --}}
            <div class="characters">
                {{-- CẬP NHẬT: Sử dụng tên tệp mới: blow, bounce, roll, stack --}}
                @foreach (['blow', 'bounce', 'roll', 'stack'] as $character)
                    <div class="character" data-name="{{ $character }}">
                        <img src="{{ asset("admin/assets/images/game_psi/game1/unit8/img/{$character}.jpg") }}"
                            alt="{{ $character }}">
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // CẬP NHẬT: Danh sách đáp án mới
            const answers = ["blow", "bounce", "roll", "stack"];
            let currentAudioIndex = null;

            const audioButtons = document.querySelectorAll('.audio');
            const characterImages = document.querySelectorAll('.character');
            const restartButton = document.getElementById('restart-button');
            const successPopup = document.getElementById('success-popup');
            const closePopupButton = document.getElementById('close-popup-button');

            // Phát âm thanh
            audioButtons.forEach((btn, index) => {
                btn.addEventListener('click', () => {
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

                    character.classList.toggle('wrong', selected !== correct);
                    if (selected === correct) {
                        character.classList.add('correct');

                        // Kiểm tra nếu tất cả đáp án đã đúng
                        if (document.querySelectorAll('.character.correct').length === answers
                            .length)
                            showPopup();
                    }
                });
            });

            restartButton.addEventListener('click', resetGame);
            closePopupButton.addEventListener('click', closePopup);

            function resetGame() {
                characterImages.forEach(el => el.classList.remove('correct', 'wrong'));
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
