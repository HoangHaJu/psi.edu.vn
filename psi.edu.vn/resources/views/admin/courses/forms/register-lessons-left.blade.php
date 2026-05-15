<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Khoá học') }}</h2>
        </div>
        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-book-2"></i> {{ __('Tên khoá học') }}:
                </label>
                <x-input name="name" :value="$course->name" :required="true" placeholder="{{ __('Tên khoá học') }}"
                    readonly />
                <x-input name="teacher_id" :value="auth()->user()->id" hidden />
            </div>
            <div class="col-md-6 mb-3">
                <label class="control-label"><i class="ti ti-school"></i> {{ __('Trình độ') }}:
                </label>
                <x-select name="education_level" :required="true" :disabled="true">
                    @foreach ($educationLevel as $key => $value)
                        <x-select-option :option="$course->education_level" :value="$key" :title="__($value)" />
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Đăng ký buổi dạy') }}</h2>
        </div>
        <div class="card-body">
            @php
                $groupedLessons = $lessons->groupBy(function ($lesson) {
                    return format_date($lesson->date, 'd-m-Y');
                });
            @endphp
            @if (auth()->user()->isTeacher)
                @foreach ($groupedLessons as $date => $lessonsOnDate)
                    <div class="mb-4">
                        <h4>{{ $date }}</h4>
                        <div class="row">
                            @foreach ($lessonsOnDate as $lesson)
                                @php
                                    $teacherLessons = $teacher?->lessons?->pluck('id')->toArray() ?? [];
                                    $isChecked = in_array($lesson->id, $teacherLessons);
                                @endphp
                                <div class="col-md-3 d-flex align-items-center">
                                    @if ($isChecked)
                                        <x-input-checkbox :checked="[$lesson->id]" name="lesson_id[]" :label="$lesson->start_time"
                                            :value="$lesson->id" onclick="return false;" />
                                    @else
                                        <x-input-checkbox name="lesson_id[]" :label="$lesson->start_time" :value="$lesson->id" />
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @elseif (auth()->user()->isSuperAdmin)
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <button type="button" id="selectAllLessonsBtn" class="btn btn-primary btn-sm">Chọn tất
                            cả</button>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.lesson.create', $course->id) }}">
                            Thêm buổi học
                        </a>
                    </div>
                    <div class="col-6">
                        @if (auth()->user()->isSuperAdmin)
                            <div class="card mb-3 custom-shadow">
                                <div class="card-header">
                                    @lang('Chọn giáo viên')
                                </div>
                                <div class="card-body p-2">
                                    <x-select name="teacher_id" id="user_id" class="select2-bs5-ajax"
                                        data-url="{{ route('admin.search.select.teacher') }}" {{-- cho Select2 --}}
                                        data-lessons-url="{{ url('courses/admin/teachers') }}" {{-- chỉ base URL --}}
                                        :required="true">
                                    </x-select>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div id="teacher-lessons-container">
                    {{-- Nội dung sẽ được render bằng JS --}}
                </div>
            @endif

        </div>
    </div>

</div>
