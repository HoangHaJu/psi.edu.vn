@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row search-filter-section align-items-center mb-4 justify-content-between">
                <div class="col-md-auto mb-3 mb-md-0">
                    <button class="btn btn-outline-secondary rounded-pill px-3" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                        <i class="ti ti-filter fs-1 pe-1"></i> {{ __('Bộ lọc') }}
                    </button>
                </div>
                <div class="col-md-7 mb-3 mb-md-0">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-pill pe-5"
                            placeholder="{{ __('Tìm tên khóa học, danh mục, trình độ...') }}" id="mainCourseSearchInput" />
                        <span
                            class="input-group-text bg-transparent border-0 position-absolute end-0 top-50 translate-middle-y"
                            style="z-index: 1">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-auto">
                    <select class="form-select rounded-pill" id="displayLimitSelect">
                        <option selected value="10">{{ __('Hiển thị 10') }}</option>
                        <option value="20">{{ __('Hiển thị 20') }}</option>
                        <option value="50">{{ __('Hiển thị 50') }}</option>
                    </select>
                </div>
            </div>

            {{-- New container for main content and pagination --}}
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

        <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">{{ __('Bộ lọc') }}</h4>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- 1. Danh mục --}}
                <div class="filter-group mb-3">
                    <h5>{{ __('Danh mục') }}</h5>
                    <div id="categoryFilterTags" class="tag-group">
                    </div>
                </div>

                {{-- 2. Theo trình độ khóa học --}}
                <div class="filter-group mb-3">
                    <h5>{{ __('Theo trình độ khóa học') }}</h5>
                    <div id="levelFilterTags" class="tag-group">
                    </div>
                </div>

                {{-- 3. Giới tính giảng viên --}}
                <div class="filter-group mb-3">
                    <h5>{{ __('Giới tính giảng viên') }}</h5>
                    <div id="genderFilterTags" class="tag-group">
                    </div>
                </div>

                {{-- 4. Đánh giá giảng viên --}}
                <div class="filter-group mb-3">
                    <h5>{{ __('Đánh giá giảng viên') }}</h5>
                    <div id="ratingFilterTags" class="tag-group">
                    </div>
                </div>

                {{-- 5. Ngày học --}}
                <div class="filter-group mb-3">
                    <h5>{{ __('Ngày học') }}</h5>
                    <input type="date" class="form-control" id="filterDate" placeholder="{{ __('Chọn ngày học') }}">
                </div>

                {{-- 6. Giáo viên (trong Offcanvas) --}}
                <div class="filter-group mb-3">
                    <h5>{{ __('Giáo viên') }}</h5>
                    <div class="custom-select-wrapper dropdown">
                        <input type="text" id="offcanvasTeacherSearchInput" placeholder="{{ __('Tìm giáo viên...') }}"
                            class="form-control" autocomplete="off">
                        <ul id="offcanvasTeacherSearchList" class="dropdown-menu w-100">
                        </ul>
                    </div>
                </div>

                {{-- 7. Buổi học --}}
                <div class="filter-group mb-3">
                    <h5>{{ __('Buổi học') }}</h5>
                    <div id="lessonFilterTags" class="tag-group">
                    </div>
                </div>

                {{-- 8. Đăng ký giúp học viên --}}
                @if (Auth::guard()->user()->hasRole('superAdmin'))
                    <div class="filter-group mb-3">
                        <h5>{{ __('Đăng ký giúp học viên') }}</h5>
                        <div class="custom-select-wrapper dropdown">
                            <input type="text" id="offcanvasStudentSearchInput"
                                placeholder="{{ __('Tìm học viên...') }}" class="form-control" autocomplete="off">
                            <ul id="offcanvasStudentSearchList" class="dropdown-menu w-100">
                            </ul>
                        </div>
                    </div>
                @endif

                <button type="button" class="btn btn-primary-booking w-100 mt-4"
                    id="applyFiltersBtn">{{ __('Áp dụng') }}</button>
                <button type="button" class="btn btn-outline-secondary w-100 mt-2"
                    id="clearFiltersBtn">{{ __('Xóa bộ lọc') }}</button>
            </div>
        </div>

        <div class="modal fade" id="dateSelectionModal" tabindex="-1" aria-labelledby="dateSelectionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dateSelectionModalLabel">
                            {{ __('Chọn ngày học') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="dateCardsContainer">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary-booking" id="confirmDateAndShowTeacherModal">
                            {{ __('Xác nhận chọn') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="teacherSelectionModal" tabindex="-1" aria-labelledby="teacherSelectionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teacherSelectionModalLabel">
                            {{ __('Chọn giáo viên') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-body-scrollable">
                        <div class="row teacher-filter-bar mb-3 align-items-center">
                            <div class="col-md-4">
                                <input type="text" class="form-control rounded-pill" id="teacherSearchInput"
                                    placeholder="{{ __('Tên') }}" />
                            </div>
                            <div class="col-md-4">
                                <select class="form-select rounded-pill" id="teacherGenderFilter">
                                    <option value="">{{ __('Giới tính') }}</option>
                                    <option value="1">{{ __('Nam') }}</option>
                                    <option value="2">{{ __('Nữ') }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select rounded-pill" id="teacherRatingFilter">
                                    <option value="">{{ __('Đánh giá') }}</option>
                                    <option value="1">{{ __('Trên 1 sao') }}</option>
                                    <option value="2">{{ __('Trên 2 sao') }}</option>
                                    <option value="3">{{ __('Trên 3 sao') }}</option>
                                    <option value="4">{{ __('Trên 4 sao') }}</option>
                                    <option value="5">{{ __('5 sao') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" id="teacherListContainer">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary-booking" id="teacherConfirmSelectionButton"
                            disabled>
                            {{ __('Xác nhận chọn') }} (0)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="timeSelectionModal" tabindex="-1" aria-labelledby="timeSelectionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="timeSelectionModalLabel">
                            {{ __('Chọn thời gian học') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="time-section" id="timeSlotsContentWrapper">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary-booking w-100" id="confirmTimeSelectionButton">
                            {{ __('Xác nhận chọn') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="finalSummaryModal" tabindex="-1" aria-labelledby="finalSummaryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="finalSummaryModalLabel">
                            {{ __('Đăng ký buổi học') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="summary-section">
                            <h5>{{ __('Khóa học và ngày học') }}</h5>
                            <div class="summary-course-info">
                                <div class="summary-course-image">
                                    <i class="fas fa-image"></i>
                                </div>
                                <div class="summary-course-details">
                                    <h5 id="summaryCourseTitle">{{ __('Tên khóa học - sơ cấp') }}</h5>
                                    <p id="summaryCourseCategory">{{ __('Tên danh mục') }}</p>
                                    <p id="summarySelectedDate">{{ __('Học vào thứ 4 ngày 25/06/2025') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="summary-section">
                            <h5>{{ __('Giảng viên và thời gian học') }}</h5>
                            <div class="row" id="summaryTeacherList"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn final-confirm-btn" id="finalConfirmBtn">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"
                                style="display: none;"></span>
                            <span class="button-text">{{ __('Xác nhận đăng ký') }}</span>
                            <span class="loading-text" style="display: none;">{{ __('Đang xử lý...') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
            <!-- Toast Thành công -->
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-delay="3000">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">{{ __('Thành công!') }}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ __('Đăng ký khóa học thành công!') }}</div>
            </div>

            <!-- Toast Lỗi -->
            <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-delay="5000">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">{{ __('Lỗi!') }}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ __('Đã xảy ra lỗi!') }}</div>
            </div>
        </div>

    </div>
    <script type="module" src="{{ asset('assets/js/modules/index.js') }}"></script>
@endsection

@push('libs-css')
    @include('admin.course_lookup.css.style')
@endpush

@push('custom-js')
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
@endpush
