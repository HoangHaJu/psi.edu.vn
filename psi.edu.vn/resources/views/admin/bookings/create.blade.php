@extends('admin.layouts.master')
@push('libs-css')
    <style>
        .form-check-button {
            padding: 0 5px;
        }

        .form-check-button .form-check-input:checked+.form-check-label {
            background-color: #388D83;
            color: white;
            border-color: #388D83;
        }

        .form-check-button .form-check-label {
            padding: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        .form-check-button .form-check-label:hover {
            background-color: #e2f1f0;
        }

        .d-flex.align-items-center.justify-content-between {
            gap: 0;
            /* Ensure buttons are evenly spaced without extra gaps */
        }

        .fc-button.fc-button-primary,
        .btn-app {
            background-color: #1d2e61 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary:hover,
        .btn-app:hover {
            background-color: #284086 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary.fc-button-active {
            background-color: #0a1c53 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary:focus,
        .fc-button.fc-button-primary:focus-visible {
            outline: none;
            box-shadow: none !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@section('content')
    <div class="card bg-white p-3">
        <div class="container-xl">
            <x-form :action="route('admin.booking.create')" class="row" :validate="true" id="search-form">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-book-2"></i> {{ __('Danh mục') }}:
                    </label>
                    <x-select name="category_id">
                        <x-select-option value="" :title="__('Chọn danh mục')" />
                        @foreach ($categories as $category)
                            <x-select-option :value="$category->id" :title="__($category->name)" :selected="request('category_id') == $category->id" />
                        @endforeach
                    </x-select>
                </div>
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-book-2"></i> {{ __('Chọn khoá học') }}:
                    </label>
                    <x-select name="course_id">
                        @if (isset($courseCategory) && $courseCategory->courses)
                            @foreach ($courseCategory->courses as $course)
                                <x-select-option :value="$course->id" :title="__($course->name)" :selected="request('course_id') == $course->id" />
                            @endforeach
                        @else
                            <x-select-option value="" :title="__('Chọn danh mục để lọc khoá học')" />
                        @endif
                    </x-select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="control-label"><i class="ti ti-book-2"></i> {{ __('Tên giáo viên') }}:
                    </label>
                    <x-input name="fullname" :value="request('fullname')" :placeholder="__('Nhập tên giáo viên')" />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="control-label"><i class="ti ti-book-2"></i> {{ __('Trình độ') }}:
                    </label>
                    <x-select name="education_level">
                        <x-select-option value="" :title="__('Chọn trình độ')" />
                        @foreach ($educationLevel as $key => $value)
                            <x-select-option :value="$key" :title="__($value)" :selected="request('education_level') == $key" />
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="control-label"><i class="ti ti-flag"></i> {{ __('Giới tính') }}:
                    </label>
                    <x-select name="gender">
                        @foreach ($gender as $key => $value)
                            <x-select-option :value="$key" :title="__($value)" :selected="request('gender') == $key" />
                        @endforeach
                    </x-select>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        @php
                            $selectedDate = request()->query('date'); // Lấy giá trị 'date' từ query param
                        @endphp
                        @for ($i = 1; $i <= 7; $i++)
                            @php
                                $date = \Carbon\Carbon::now()->addDays($i);
                                $formattedDate = $date->toDateString(); // Định dạng Y-m-d
                            @endphp
                            <div class="form-check form-check-button flex-grow-1">
                                <input class="form-check-input d-none" type="radio" name="date"
                                    id="date-{{ $i }}" value="{{ $formattedDate }}"
                                    {{ $selectedDate === $formattedDate ? 'checked' : '' }}>
                                <label class="form-check-label btn btn-outline-secondary w-100 text-center"
                                    for="date-{{ $i }}">
                                    {{ $date->format('d/m/Y') }}
                                </label>
                            </div>
                        @endfor
                    </div>
                </div>
                <button class="btn btn-app col-md-1 bold-text"><i class="ti ti-search me-2"></i> Tìm kiếm </button>
            </x-form>
        </div>
        @if (isset($teachers))
            <div class="mt-3 p-3">
                <div class="container-xl">
                    <form action="{{ route('admin.booking.store') }}" method="POST">
                        @csrf
                        <div class="row g-4"> <!-- Sử dụng g-4 để thêm khoảng cách -->
                            @foreach ($teachers as $teacher)
                                <div class="col-6 col-md-6 mb-2 pb-4 pt-4" style="border: 2px solid #ddd;">
                                    <!-- Dọc giữa hai cột -->
                                    <div class="row gx-2 d-flex align-items-stretch">
                                        <div class="col-3 mb-0 text-center">
                                            <img class="img-rounded mx-auto h-full" src="{{ asset($teacher->avatar) }}"
                                                alt="">
                                        </div>
                                        <div class="col-9">
                                            <h3 class="default-color">{{ $teacher->fullname }}</h3>
                                            @php
                                                $age = \Carbon\Carbon::parse($teacher->birthday)->age;
                                            @endphp
                                            <h4 class="text-muted">Age: {{ $age }}</h4>
                                            <h4 class="badge bg-success mb-0">Teacher</h4>
                                            <div class="review-rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="star" data-value="{{ $i }}"
                                                        @if ($teacher->rate >= $i) class="selected" @endif>★</span>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 mb-2 pb-4 pt-4" style="border: 2px solid #ddd;">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row g-4 pt-2">
                                                @foreach ($teacher->teacher_lessons as $teacher_lesson)
                                                    <div class="col-lg-3">
                                                        <div class="btn-group-toggle d-flex justify-content-center"
                                                            data-toggle="buttons">
                                                            <label class="btn btn-default">
                                                                <input hidden type="checkbox" class="time-checkbox"
                                                                    autocomplete="off" value="{{ $teacher_lesson['id'] }}"
                                                                    name="teacher_lesson_id[]">
                                                                {{ $teacher_lesson['lesson']['start_time'] }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-12 mb-3 text-center">
                                <button type="submit" class="btn btn-default px-5">Đăng ký</button>
                            </div>
                        </div>
                    </form>
                </div>
                @if (!empty($paginate))
                    <div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
                        @if ($paginate->hasPages())
                            <button class="pagination-btn prev"
                                onclick="location.href='{{ $paginate->previousPageUrl() }}'"
                                @if ($paginate->onFirstPage()) disabled @endif>
                                <i class="ti ti-arrow-left" aria-hidden="true"></i>
                            </button>
                            @for ($i = 1; $i <= $paginate->lastPage(); $i++)
                                <button onclick="location.href='{{ $paginate->url($i) }}'"
                                    class="pagination-btn @if ($i == $paginate->currentPage()) active @endif">
                                    {{ $i }}
                                </button>
                            @endfor
                            <button class="pagination-btn next" onclick="location.href='{{ $paginate->nextPageUrl() }}'"
                                @if (!$paginate->hasMorePages()) disabled @endif>
                                <i class="ti ti-arrow-right" aria-hidden="true"></i>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
@endpush

@push('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('search-form');
            const selects = form.querySelectorAll('select');

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    form.submit();
                });
            });

            const stars = document.querySelectorAll('.star');
            @if (isset($teacher->rateForStudent) && is_numeric($teacher->rateForStudent))
                let selectedRating = Math.ceil({{ $teacher->rateForStudent }});

                function highlightStars(value) {
                    stars.forEach(star => {
                        if (star.getAttribute('data-value') <= value) {
                            star.classList.add('selected');
                        } else {
                            star.classList.remove('selected');
                        }
                    });
                }
                highlightStars(selectedRating);
            @endif
        });
    </script>
    @include('admin.bookings.scripts.scripts')
@endpush

@push('custom-css')
    <style>
        .star {
            font-size: 30px;
            color: lightgray;
            cursor: pointer;
        }

        .star:hover,
        .star.selected {
            color: gold;
        }

        .star.selected {
            color: orange;
            /* Màu của sao đã được chọn */
        }
    </style>
@endpush
