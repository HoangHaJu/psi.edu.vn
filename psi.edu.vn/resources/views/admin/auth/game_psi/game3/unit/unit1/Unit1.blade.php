<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trò chơi - Listen and Choose</title>
  <link rel="stylesheet" href="Unit1.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-wrapper">
          <div class="breadcrumb">
            <a href="/Game 3/Game3.html">Phần 3</a> <span> &gt; Unit 1</span>
          </div>
        <h1>TRÒ CHƠI</h1>
        <p>Giúp bé phát triển tiếng Anh một cách tự nhiên</p>
      </header>
<main class="game-content"> 
  <div class="top-bar">
        <a href="/index.html"><button class="btn icon home"><img src="/IMG/Group.png" alt="h" class="home-icon"></button></a>
        <a href="/Game 3/Game3.html">
          <button class="btn icon number">
              <img src="/IMG/Frame 86.png" alt="3" class="number-icon"/>
          </button>
        </a>
        <a href="/Game 3/Unit/Unit1/Unit1.html"><button class="btn nav"><span class="arrow">&laquo;</span></button></a>
        <a href="/Game 3/Unit/Unit2/Unit2.html"><button class="btn nav"><span class="arrow">&raquo;</span></button></a>
    </div>
    <div class="lesson-box">
      <div class="lesson-header">
        <img src="/IMG/Frame 69.png" class="touch-icon">
        <h2>Unit 1: What's your school like?</h2>
      </div>
    <p class="instruction">Listen and match.</p>
    <div class="audio-buttons">
        <button class="audio" data-answer="ceiling" data-sound="/Game 3/Unit/Unit1/Sound/Unit1/ceiling.mp3"><strong class="p">ceiling</strong></button>
        <button class="audio" data-answer="door" data-sound="/Game 3/Unit/Unit1/Sound/Unit1/door.mp3"><strong class="p">door</strong></button>
        <button class="audio" data-answer="floor" data-sound="/Game 3/Unit/Unit1/Sound/Unit1/floor.mp3"><strong class="p">floor</strong></button>
        <button class="audio" data-answer="light" data-sound="/Game 3/Unit/Unit1/Sound/Unit1/light.mp3"><strong class="p">light</strong></button>
        <button class="audio" data-answer="sink" data-sound="/Game 3/Unit/Unit1/Sound/Unit1/sink.mp3"><strong class="p">sink</strong></button>
        <button class="audio" data-answer="window" data-sound="/Game 3/Unit/Unit1/Sound/Unit1/window.mp3"><strong class="p">window</strong></button>
    </div>

    <div class="characters">
      <div class="character" data-name="sink">
        <img src="/Game 3/Unit/Unit1/img unit/Unit1/sink.jpg" alt="sink" />
      </div>
      <div class="character" data-name="ceiling">
        <img src="/Game 3/Unit/Unit1/img unit/Unit1/ceiling.jpg" alt="ceiling" />
      </div>
      <div class="character" data-name="door">
        <img src="/Game 3/Unit/Unit1/img unit/Unit1/door.jpg" alt="door" />
      </div>
      <div class="character" data-name="light">
        <img src="/Game 3/Unit/Unit1/img unit/Unit1/light.jpg" alt="light" />
      </div>
      <div class="character" data-name="floor">
        <img src="/Game 3/Unit/Unit1/img unit/Unit1/floor.jpg" alt="floor" />
       </div>
      <div class="character" data-name="window">
        <img src="/Game 3/Unit/Unit1/img unit/Unit1/window.jpg" alt="window" />
      </div>
    </div>
    <div class="restart-container">
        <button id="restart-button">🔁 Chơi lại</button>
    </div>
    <img src="/IMG/image 60.png" alt="Nhân vật" class="corner-image">
  </div>
</main>
<script>
const answers = [ "ceiling", "door", "floor", "light", "sink", "window" ];
let currentAudioIndex = null;

document.querySelectorAll('.audio').forEach((btn, index) => {
  btn.addEventListener('click', () => {
    currentAudioIndex = index;
    new Audio(btn.dataset.sound).play();
  });
});

document.querySelectorAll('.character').forEach(character => {
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

      // ✅ Kiểm tra nếu đã đúng hết 6 hình
      const correctCount = document.querySelectorAll('.character.correct').length;
      if (correctCount === 6) {
        showPopup();
      }
    } else {
      character.classList.add('wrong');
    }
  });
});

// Nút chơi lại
document.getElementById('restart-button').addEventListener('click', () => {
  document.querySelectorAll('.character').forEach(el => {
    el.classList.remove('correct', 'wrong');
  });
  currentAudioIndex = null;
  closePopup();
});

// Hiện popup
function showPopup() {
  document.getElementById("success-popup").classList.remove("hidden");
}

// Đóng popup
function closePopup() {
  document.getElementById("success-popup").classList.add("hidden");
}
</script>
<div id="success-popup" class="popup hidden">
  <div class="popup-content">
    <h2>🎉 Chúc mừng!</h2>
    <p>Bạn đã làm đúng hết rồi!</p>
    <button onclick="closePopup()">Đóng</button>
  </div>
</div>

</body>
</html>