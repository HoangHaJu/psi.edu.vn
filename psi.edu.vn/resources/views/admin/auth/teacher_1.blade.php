<div style="overflow-x: auto; white-space: nowrap; max-height: 1000px;" id="scroll-container">
    @foreach ($teachers as $teacher)
        <div class="teacher-card rounded-3 shadow-lg">
            <div class="card w-100 bg-secondary rounded-3 text-center">
                <div class="d-flex justify-content-center pb-2 pt-4">
                    <img src="{{ asset($teacher['avatar']) }}" class="rounded-pill" alt="..." width="150px">
                </div>
                <div class="card-body pt-0">
                    <h4 class="card-title fw-bold fs-1">{{ $teacher['fullname'] }}</h4>
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <img class="img-fluid" style="width:100px; height:70px;"
                            src="{{ asset($teacher['national_flag']) }}" alt="national_flag">
                        <span class="text-bold fs-2 fw-bold">{{ $teacher['country'] }}</span>
                    </div>
                    <p class="fs-1 fw-bold text-wrap">Chuyên gia về tiếng Anh với hơn 5 năm kinh nghiệm</p>
                    <div class="position-relative">
                        <iframe class="object-fit-cover w-100 rounded border" controls style="max-height:300px"
                            src="{{ $teacher['link'] }}" frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <div class="my-4">
                        <a href="#register" class="fs-2 rounded-pill btn btn-primary">Đặt lớp bài học</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .video-wrapper {
        position: relative;
        display: inline-block;
    }

    .custom-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 48px;
        background: rgba(0, 0, 0, 0.4);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        cursor: pointer;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .custom-play-btn:hover {
        background: rgba(0, 0, 0, 0.7);
    }
</style>
{{-- @push('scripts') --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.position-relative > video').forEach(function(video) {
            // Tạo wrapper nếu chưa có
            var wrapper = video.parentElement;
            if (!wrapper.classList.contains('video-wrapper')) {
                wrapper.classList.add('video-wrapper');
            }
            // Tạo nút play nếu chưa có
            if (!wrapper.querySelector('.custom-play-btn')) {
                var btn = document.createElement('button');
                btn.className = 'custom-play-btn';
                btn.innerHTML = '▶';
                wrapper.appendChild(btn);
            }
        });
        // Gán sự kiện cho từng video
        document.querySelectorAll('.video-wrapper').forEach(function(wrapper) {
            var video = wrapper.querySelector('video');
            var btn = wrapper.querySelector('.custom-play-btn');
            // Ẩn controls mặc định khi chưa play
            video.controls = false;
            btn.style.display = 'flex';
            // Khi bấm nút play
            btn.addEventListener('click', function() {
                video.play();
                video.controls = true;
                btn.style.display = 'none';
            });
            // Khi video pause thì hiện lại nút play
            video.addEventListener('pause', function() {
                if (video.currentTime > 0 && !video.ended) {
                    btn.style.display = 'flex';
                    video.controls = false;
                }
            });
            // Khi video play thì ẩn nút play
            video.addEventListener('play', function() {
                btn.style.display = 'none';
                video.controls = true;
            });
            // Khi video kết thúc thì hiện lại nút play
            video.addEventListener('ended', function() {
                btn.style.display = 'flex';
                video.controls = false;
            });
        });
    });
</script>
{{-- @endpush --}}
