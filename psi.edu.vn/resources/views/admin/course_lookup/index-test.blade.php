@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row search-filter-section align-items-center mb-4 justify-content-between">
                    <div class="col-md-auto mb-3 mb-md-0">
                        <button class="btn btn-outline-secondary rounded-pill px-3" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#filterOffcanvas">
                            <i class="ti ti-filter fs-1 pe-1"></i> {{ __('Bộ lọc') }}
                        </button>
                        @if (Auth::guard()->user()->hasRole('superAdmin'))
                            <button class="btn btn-outline-secondary rounded-pill px-3" type="button"
                                data-bs-toggle="modal" data-bs-target="#studentSelectionModal" id="registerForStudentBtn">
                                <i class="ti ti-user-plus fs-1 pe-1"></i> {{ __('Đăng ký hộ') }}
                            </button>
                        @endif
                    </div>
                    <div class="col-md-7 mb-3 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-pill pe-5"
                                placeholder="{{ __('Tìm tên khóa học, danh mục, trình độ...') }}"
                                id="mainCourseSearchInput" />
                            <span
                                class="input-group-text bg-transparent border-0 position-absolute end-0 top-50 translate-middle-y">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-auto" style="min-width: 140px;">
                        <select class="form-select rounded-pill" id="displayLimitSelect">
                            <option value="10" selected>{{ __('Hiển thị 10') }}</option>
                            <option value="20">{{ __('Hiển thị 20') }}</option>
                            <option value="50">{{ __('Hiển thị 50') }}</option>
                        </select>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex flex-column" style="min-height: calc(100vh - 200px);">
                        <div class="flex-grow-1">
                            <div class="row" id="courseListContainer"></div>
                        </div>
                        <div class="row pagination-section justify-content-center mt-4 mb-4">
                            <div class="col-auto">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0" id="coursePagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📋 Partials --}}
            @include('admin.course_lookup.partials.filter-offcanvas')
            @include('admin.course_lookup.partials.modals')
            @include('admin.course_lookup.partials.toast')
        </div>
    </div>
    <script>
        window.currentUserRole = @json(optional(Auth::guard()->user()->roles->first())->name);
    </script>

    <script type="module" src="{{ asset('assets/js/modules/index.js') }}"></script>
@endsection

@push('libs-css')
    @include('admin.course_lookup.css.style')
@endpush

@push('custom-js')
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
@endpush
