function toggleAudio(audioId) {
    const audio = document.getElementById(audioId);
    if (audio) {
        if (audio.paused) {
            audio.play();
            console.log(`Đang phát audio với ID: ${audioId}`);
        } else {
            audio.pause();
            console.log(`Đã tạm dừng audio với ID: ${audioId}`);
        }
    } else {
        console.warn(`Không tìm thấy phần tử audio với ID: ${audioId}`);
    }
}
