@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card g-2 p-3">
                <div class="row">
                    <div style="border: none" class="default-color col-md-3">
                        <x-form type="post" :action="route('admin.booking.create')" :validate="true">
                            <input hidden type="text" name="admin_id" id="" value="{{ auth('admin')->user()->id }}">                            <input hidden type="text" name="course_id" id="" value="{{ $course->id }}">
                            <div class="mb-3 text-center">
                                <img style="max-width: 200px" class="img-fluid" src="{{ asset($course->avatar) }}"
                                    alt="">
                            </div>
                            <h3 class="bold-text text-dark">{{ $course->name }}</h3>
{{--                            @php--}}
{{--                             $daysOfWeek = [--}}
{{--                                 1 => 'Thứ 2',--}}
{{--                                 2 => 'Thứ 3',--}}
{{--                                 3 => 'Thứ 4',--}}
{{--                                 4 => 'Thứ 5',--}}
{{--                                 5 => 'Thứ 6',--}}
{{--                                 6 => 'Thứ 7',--}}
{{--                                 7 => 'Chủ nhật',--}}
{{--                             ];--}}
{{--                             $scheduleText = $course->schedule--}}
{{--                                 ? collect(json_decode($course->schedule))--}}
{{--                                     ->map(fn($day) => $daysOfWeek[(int) $day] ?? '')--}}
{{--                                     ->filter()--}}
{{--                                     ->join(', ')--}}
{{--                                 : 'Chưa có lịch học';--}}
{{--                             $allLessonsMarkedPresent = !$course--}}
{{--                                 ->selfLessons()--}}
{{--                                 ->where('status', '=', \App\Enums\Lesson\LessonStatus::NotPresent->value)--}}
{{--                                 ->exists();--}}
{{--                            @endphp--}}

                            <p><strong><i class="ti ti-calendar me-2"></i>{{ __('Lịch học:') }}</strong>
                                {{ $scheduleText }}</p>
                            <p><strong><i class="ti ti-calendar-event me-2"></i>{{ __('Ngày bắt đầu:') }}</strong>
                                {{ $course->start_date }}</p>
                            <p><strong><i class="ti ti-calendar-minus me-2"></i>{{ __('Ngày kết thúc:') }}</strong>
                                {{ $course->end_date }}</p>
                            <p><strong><i class="ti ti-clock me-2"></i>{{ __('Thời gian:') }}</strong>
                                {{ $course->start_time }} - {{ $course->end_time }}</p>

                            <p><strong><i class="ti ti-currency-dollar me-2"></i>{{ __('Giá:') }}</strong>
                                <del
                                    class="me-1">{{ $course->price ? number_format($course->price, 0, ',', '.') . ' VNĐ' : __('Miễn phí') }}</del>
                                {{ $course->promotion_price ? number_format($course->promotion_price, 0, ',', '.') . ' VNĐ' : __('Miễn phí') }}
                            </p>
                            <p><strong><i class="ti ti-school me-2"></i>{{ __('Trình độ khoá học:') }}</strong>
                                {{ App\Enums\Admin\EducationLevel::getDescription($course->education_level) }}
                            </p>
                            <p><strong><i class="ti ti-shopping-cart me-2"></i>{{ __('Lượt mua:') }}</strong>
                                {{ $course->purchase_count }}</p>
                            <p>{!! $course->description !!}</p>
                            <button type="submit" class="btn btn-default d-flex m-auto">
                                Đăng ký
                            </button>
{{--                            @if ($allLessonsMarkedPresent)--}}
{{--                                <button type="button" data-id="{{ $booking->id }}" data-bs-toggle="modal"--}}
{{--                                    data-bs-target="#reviewCourse" type="button" class="btn btn-default d-flex m-auto mt-2">--}}
{{--                                    Đánh giá--}}
{{--                                </button>--}}
{{--                            @endif--}}
                        </x-form>
                    </div>
                    <div class="default-color col-md-9">
                        <h3 class="bold-text">Bài học</h3>
                        <div class="table-responsive">
                            <table class="table-bordered table-striped table text-center">
                                <thead class="text-white">
                                    <tr class="default-bg text-white">
                                        <th>Lesson Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>File</th>
                                        <th>Class</th>
                                        <th>Precent</th>
                                        <th>Status</th>
                                        @if (auth('admin')->user()->isStudent)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
{{--                                    @foreach ($course->selfLessons as $lesson)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{ $lesson->name }}</td>--}}
{{--                                            <td>{{ format_date($lesson->date) }}</td>--}}

{{--                                            <td>{{ $lesson->start_time . ' - ' . $lesson->end_time }}--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <a target="_blank" href="{{ $lesson->file_link }}"--}}
{{--                                                    class="btn btn-info btn-sm">--}}
{{--                                                    File--}}
{{--                                                </a>--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <a target="_blank" href="{{ $lesson->course->skype_link }}"--}}
{{--                                                    class="btn btn-info btn-sm">--}}
{{--                                                    Class--}}
{{--                                                </a>--}}
{{--                                            </td>--}}
{{--                                            <td>{{ App\Enums\Lesson\LessonStatus::getDescription($lesson->status) }}</td>--}}
{{--                                            <td>{{ App\Enums\Lesson\DayOffType::getDescription($lesson->day_off_type) }}--}}
{{--                                            </td>--}}
{{--                                            @if (auth('admin')->user()->isStudent)--}}
{{--                                                <td>--}}
{{--                                                    <button id="btnModalRequestDayOff" data-id="{{ $lesson->id }}"--}}
{{--                                                        data-bs-toggle="modal" data-bs-target="#requestDayOff"--}}
{{--                                                        type="button" class="btn btn-default text-center">--}}
{{--                                                        Xin nghỉ--}}
{{--                                                    </button>--}}
{{--                                                </td>--}}
{{--                                            @endif--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
            <div class="card p-3 mb-3">
                <h2>Đánh giá của khóa học</h2>
                @if ($reviews->count() > 0)
                    @foreach ($reviews as $review)
                        <div class="mt-3">
                            <p class="mb-0 text-muted"><small>{{ $review->created_at->format('d/m/Y H:i') }}</small></p>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 me-2 fs-3 fw-bold">{{ $review->fullname }}</p>
                                <span class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                            </div>
                            <p class="mb-1">{{ $review->content }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="p-3 text-center">Chưa có đánh giá!</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('custom-js')
@endpush
