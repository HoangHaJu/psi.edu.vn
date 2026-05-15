<div id="teachersCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($teachers as $key => $teacher)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10 overflow-auto" style="max-height:600px; ">
                            <div class="card mb-3 bg-transparent">
                                <div class="row g-0 card-teacher">
                                    <div class="col-md-3 text-center">
                                        <img src="{{ asset($teacher['avatar']) }}"
                                            class="img-fluid rounded-start p-3 w-75" alt="{{ $teacher['fullname'] }}">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <h2 class="card-title fs-1 m-0 pe-2">{{ $teacher['fullname'] }}</h2>
                                                @if ($teacher['audio'])
                                                    <i class="bi bi-megaphone-fill audio-icon"
                                                        style="cursor: pointer; font-size: 2rem;"
                                                        onclick="toggleAudio(this)">
                                                        <audio class="teacher-audio" hidden>
                                                            <source src="{{ asset($teacher['audio']) }}"
                                                                type="audio/mpeg">
                                                        </audio>
                                                    </i>
                                                @else
                                                    <span class="text-danger fs-4">
                                                        Không có Audio
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="card-text m-0">
                                                <small
                                                    class="fs-3">{{ \Carbon\Carbon::parse($teacher['birthday'])->age }}
                                                    tuổi</small>
                                            </p>
                                            <p class="card-text m-0">
                                                <small class="fs-3">Trên 5 năm kinh nghiệm giảng dạy</small>
                                            </p>

                                            <div class="d-flex align-items-center my-2">
                                                <div class="review_rating text-start">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <label style="color: gold">★</label>
                                                    @endfor
                                                </div>
                                                <small class="px-2 fs-3">5.0</small>
                                            </div>

                                            @php
                                                $startTimes = $teacherStartTimes[$teacher->id] ?? [];

                                                $morningShift = collect($startTimes)->filter(function ($time) {
                                                    return \Carbon\Carbon::parse($time)->between(
                                                        \Carbon\Carbon::parse('07:00:00'),
                                                        \Carbon\Carbon::parse('18:00:00'),
                                                    );
                                                });

                                                $eveningShift = collect($startTimes)->filter(function ($time) {
                                                    return \Carbon\Carbon::parse($time)->between(
                                                        \Carbon\Carbon::parse('18:00:01'),
                                                        \Carbon\Carbon::parse('22:00:00'),
                                                    );
                                                });
                                            @endphp

                                            <div class="row mt-3">
                                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-brightness-high me-1 fs-4"></i>
                                                        <small class="px-2 fs-3">Sáng</small>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-2 my-2">
                                                        @forelse($morningShift as $time)
                                                            <button class="btn btn-outline-primary btn-time-slot">
                                                                {{ \Carbon\Carbon::parse($time)->format('g:i A') }}
                                                            </button>
                                                        @empty
                                                            <span class="text-muted fs-4">Không có lịch trống</span>
                                                        @endforelse
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-moon me-1 fs-4"></i>
                                                        <small class="px-2 fs-3">Tối</small>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-2 my-2">
                                                        @forelse($eveningShift as $time)
                                                            <button class="btn btn-outline-primary btn-time-slot">
                                                                {{ \Carbon\Carbon::parse($time)->format('g:i A') }}
                                                            </button>
                                                        @empty
                                                            <span class="text-muted fs-4">Không có lịch trống</span>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#teachersCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#teachersCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach ($teachers as $key => $teacher)
            <button type="button" data-bs-target="#teachersCarousel" data-bs-slide-to="{{ $key }}"
                class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}">
            </button>
        @endforeach
    </div>
</div>
<style>
    .card-teacher {
        border: 1px solid #dee2e6;
        border-radius: 15px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .carousel-item {
        padding: 2rem 0;
    }

    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 8px;
        background-color: #6c757d;
        border: none;
    }

    .carousel-indicators .active {
        background-color: #0d6efd;
    }

    .btn-time-slot {
        font-size: 1.1rem;
        padding: 0.25rem 0.75rem;
    }

    .audio-icon:hover {
        color: #0d6efd !important;
    }
</style>
@push('scripts')
    <script>
        // Carousel initialization
        const teachersCarousel = new bootstrap.Carousel('#teachersCarousel', {
            interval: 7000,
            wrap: true,
            pause: 'hover'
        });

        // Audio control function
        function toggleAudio(icon) {
            const audio = icon.querySelector('audio');
            if (audio.paused) {
                audio.play();
                icon.classList.add('text-primary');
            } else {
                audio.pause();
                audio.currentTime = 0;
                icon.classList.remove('text-primary');
            }
        }

        // Pause audio when changing slide
        document.getElementById('teachersCarousel').addEventListener('slide.bs.carousel', function(e) {
            const activeSlide = e.from;
            const audioElements = activeSlide.querySelectorAll('audio');
            audioElements.forEach(audio => {
                audio.pause();
                audio.currentTime = 0;
                audio.parentElement.classList.remove('text-primary');
            });
        });
    </script>
@endpush
