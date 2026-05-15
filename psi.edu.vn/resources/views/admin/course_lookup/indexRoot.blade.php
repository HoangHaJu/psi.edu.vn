@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row search-filter-section align-items-center mb-4 justify-content-between">
                <div class="col-md-auto mb-3 mb-md-0">
                    <button class="btn btn-outline-secondary rounded-pill px-3" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                        <i class="fas fa-filter me-2"></i> Bộ lọc
                    </button>
                </div>
                <div class="col-md-7 mb-3 mb-md-0">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-pill pe-5"
                            placeholder="Tìm tên khóa học, danh mục, trình độ..." id="mainCourseSearchInput" />
                        <span
                            class="input-group-text bg-transparent border-0 position-absolute end-0 top-50 translate-middle-y"
                            style="z-index: 1">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-auto">
                    <select class="form-select rounded-pill" id="displayLimitSelect">
                        <option selected value="10">Hiển thị 10</option>
                        <option value="20">Hiển thị 20</option>
                        <option value="50">Hiển thị 50</option>
                    </select>
                </div>
            </div>

            <div class="row" id="courseListContainer"></div>

            <div class="row pagination-section justify-content-center">
                <div class="col-auto">
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0" id="coursePagination"></ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="filterOffcanvasLabel">Bộ lọc</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="filter-group">
                    <h6>Tìm kiếm tên khóa học</h6>
                    <input type="text" class="form-control" id="offcanvasCourseSearchInput"
                        placeholder="Nhập tên khóa học..." />
                </div>

                <div class="filter-group">
                    <h6>Ngày học</h6>
                    <input type="text" class="form-control" placeholder="Chọn ngày học" readonly data-bs-toggle="modal"
                        data-bs-target="#dateSelectionModal" id="dateFilterInput" />
                </div>

                <div class="filter-group">
                    <h6>Danh mục</h6>
                    <div class="d-flex flex-wrap" id="categoryFilterTags"></div>
                </div>

                <div class="filter-group">
                    <h6>Theo trình độ khóa học</h6>
                    <div class="d-flex flex-wrap" id="levelFilterTags"></div>
                </div>

                <div class="filter-group">
                    <h6>Giới tính giảng viên</h6>
                    <div class="d-flex flex-wrap" id="genderFilterTags"></div>
                </div>

                <div class="filter-group">
                    <h6>Đánh giá giảng viên</h6>
                    <div class="d-flex flex-wrap" id="ratingFilterTags"></div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <button class="btn btn-primary w-100" id="applyFiltersBtn">
                    Áp dụng
                </button>
            </div>
        </div>

        <!-- Modal Chọn Ngày Học -->
        <div class="modal fade" id="dateSelectionModal" tabindex="-1" aria-labelledby="dateSelectionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dateSelectionModalLabel">
                            Chọn ngày học
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="dateCardsContainer">
                            <!-- Date cards will be rendered here by JavaScript -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmDateAndShowTeacherModal">
                            Xác nhận chọn
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Chọn Giáo viên -->
        <div class="modal fade" id="teacherSelectionModal" tabindex="-1" aria-labelledby="teacherSelectionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teacherSelectionModalLabel">
                            Chọn giáo viên
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-body-scrollable">
                        <!-- Filter bar within the modal body -->
                        <div class="row teacher-filter-bar mb-3 align-items-center">
                            <div class="col-md-4">
                                <input type="text" class="form-control rounded-pill" id="teacherSearchInput"
                                    placeholder="Tên" />
                            </div>
                            <div class="col-md-4">
                                <select class="form-select rounded-pill" id="teacherGenderFilter">
                                    <option value="">Giới tính</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select rounded-pill" id="teacherRatingFilter">
                                    <option value="">Đánh giá</option>
                                    <option value="1">Trên 1 sao</option>
                                    <option value="2">Trên 2 sao</option>
                                    <option value="3">Trên 3 sao</option>
                                    <option value="4">Trên 4 sao</option>
                                    <option value="5">5 sao</option>
                                </select>
                            </div>
                        </div>

                        <!-- Danh sách giáo viên -->
                        <div class="row" id="teacherListContainer">
                            <!-- Teacher cards will be rendered here by JavaScript -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmTeacherSelectionButton" disabled>
                            Xác nhận chọn (0)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Chọn Thời gian học -->
        <div class="modal fade" id="timeSelectionModal" tabindex="-1" aria-labelledby="timeSelectionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="timeSelectionModalLabel">
                            Chọn thời gian học
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="time-section" id="timeSlotsContentWrapper">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary w-100" id="confirmTimeSelectionButton">
                            Xác nhận chọn
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal đăng ký buổi học -->
        <div class="modal fade" id="finalSummaryModal" tabindex="-1" aria-labelledby="finalSummaryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="finalSummaryModalLabel">
                            Đăng ký buổi học
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="summary-section">
                            <h5>Khóa học và ngày học</h5>
                            <div class="summary-course-info">
                                <div class="summary-course-image">
                                    <i class="fas fa-image"></i>
                                </div>
                                <div class="summary-course-details">
                                    <h6 id="summaryCourseTitle">Tên khóa học - sơ cấp</h6>
                                    <p id="summaryCourseCategory">Tên danh mục</p>
                                    <p id="summarySelectedDate">Học vào thứ 4 ngày 25/06/2025</p>
                                </div>
                            </div>
                        </div>

                        <div class="summary-section">
                            <h5>Giảng viên và thời gian học</h5>
                            <div class="row" id="summaryTeacherList"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn final-confirm-btn" id="finalConfirmBtn">
                            Xác nhận đăng ký
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-delay="3000">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Thành công!</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">Đăng ký khóa học thành công!</div>
            </div>
        </div>
    </div>
@endsection

@push('libs-css')
    @include('admin.course_lookup.css.style')
@endpush

@push('custom-js')
    @include('admin.course_lookup.scripts.scripts')
@endpush
