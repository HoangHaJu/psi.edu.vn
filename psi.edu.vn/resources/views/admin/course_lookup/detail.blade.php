@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card g-2 p-3">
                <div class="row">
                    <div style="border: none" class="default-color col-md-12">
                        <x-form type="post" :action="route('admin.booking.create')" :validate="true">
                            <input hidden type="text" name="admin_id" value="{{ auth('admin')->user()->id }}">
                            <input hidden type="text" name="course_id" value="{{ $course->id }}">

                            {{-- Hiển thị ảnh khoá học --}}
                            <div class="mb-3 text-center">
                                <img class="img-fluid"
                                    style="max-width: 200px; border-radius: 50%; border: 4px solid #1EA38F;"
                                    src="{{ asset($course->avatar) }}" alt="Course Avatar">
                            </div>

                            {{-- Thông tin khoá học --}}
                            <p><strong><i class="ti ti-school me-2"></i>{{ __('Tên khoá học:') }}</strong>
                                {{ $course->name }}
                            </p>
                            <p><strong><i class="ti ti-school me-2"></i>{{ __('Trình độ khoá học:') }}</strong>
                                {{ App\Enums\Admin\EducationLevel::getDescription($course->education_level) }}
                            </p>
                            <p><strong><i class="ti ti-school me-2"></i>{{ __('Mô tả:') }}</strong>
                                {!! $course->description !!}
                            </p>

                            {{-- Danh mục --}}
                            <p><strong><i class="ti ti-tag me-2"></i>{{ __('Danh mục:') }}</strong>
                                @foreach ($categories as $category)
                                    <span>{{ $category->name }}</span>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>

                            {{-- Giáo viên --}}
                            <p><strong><i class="ti ti-users me-2"></i>{{ __('Giáo viên dạy khóa học:') }}</strong>
                                <br>
                                @if (is_string($teachers))
                                    <span>{{ $teachers }}</span>
                                @else
                                    <ul>
                                        @foreach ($teachers as $teacher)
                                            <li>{{ $teacher->fullname }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </p>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
@endpush

@push('custom-js')
@endpush
