{{-- Modal: Chọn học viên --}}
<div class="modal fade" id="studentSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ __('Chọn học viên') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <input type="text" class="form-control rounded-pill" id="studentSearchInput"
                            placeholder="{{ __('Tên học viên') }}">
                    </div>
                </div>
                <div class="row" id="studentListContainer"></div>
                <div class="d-flex justify-content-center mt-3" id="studentPaginationContainer"></div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <x-button.step-button from="studentSelectionModal" to="ticketSelectionModal"
                    label="{{ __('Tiếp tục') }} →" id="studentConfirmSelectionButton" />
            </div>
        </div>
    </div>
</div>

{{-- Modal: Chọn vé --}}
<div class="modal fade" id="ticketSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ __('Chọn loại vé') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="row g-3" id="ticketTypeContainer"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <x-button.step-button from="ticketSelectionModal" to="studentSelectionModal" variant="secondary"
                    label="← {{ __('Quay lại') }}" />
                <x-button.step-button from="ticketSelectionModal" to="courseSelectionModal"
                    label="{{ __('Tiếp tục') }} →" id="ticketConfirmSelectionButton" />
            </div>
        </div>
    </div>
</div>

{{-- Modal: Chọn khóa học --}}
<div class="modal fade" id="courseSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ __('Chọn khóa học') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control rounded-pill" id="courseSearchInput"
                            placeholder="{{ __('Tên khóa học') }}">
                    </div>
                    <div class="col-md-6">
                        <select class="form-select rounded-pill" id="courseCategoryFilter">
                            <option value="">{{ __('Danh mục') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">{{ __($category['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row" id="courseListModalContainer"></div>
                <div id="courseModalPagination" class="text-center mt-3"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <x-button.step-button from="courseSelectionModal" to="ticketSelectionModal" variant="secondary"
                    label="← {{ __('Quay lại') }}" />
                <x-button.step-button from="courseSelectionModal" to="dateSelectionModal"
                    label="{{ __('Tiếp tục') }} →" id="courseConfirmSelectionButton" />
            </div>
        </div>
    </div>
</div>

{{-- Modal: Chọn ngày --}}
<div class="modal fade" id="dateSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ __('Chọn ngày học') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="dateCardsContainer"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <x-button.step-button from="dateSelectionModal" to="courseSelectionModal" variant="secondary"
                    label="← {{ __('Quay lại') }}" />
                <x-button.step-button from="dateSelectionModal" to="teacherSelectionModal"
                    label="{{ __('Tiếp tục') }} →" id="confirmDateAndShowTeacherModal" />
            </div>
        </div>
    </div>
</div>

{{-- Modal: Chọn giáo viên --}}
<div class="modal fade" id="teacherSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ __('Chọn giáo viên') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="row teacher-filter-bar mb-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control rounded-pill" id="teacherSearchInput"
                            placeholder="{{ __('Tên') }}">
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
                <div class="row" id="teacherListContainer"></div>
                <div id="teacherPaginationContainer" class="mt-2"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <x-button.step-button from="teacherSelectionModal" to="dateSelectionModal" variant="secondary"
                    label="← {{ __('Quay lại') }}" />
                <x-button.step-button from="teacherSelectionModal" to="timeSelectionModal"
                    label="{{ __('Tiếp tục') }} →" id="teacherConfirmSelectionButton" />
            </div>
        </div>
    </div>
</div>

{{-- Modal: Chọn thời gian --}}
<div class="modal fade" id="timeSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ __('Chọn thời gian học') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="timeSlotsContentWrapper" class="time-section"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <x-button.step-button from="timeSelectionModal" to="teacherSelectionModal" variant="secondary"
                    label="← {{ __('Quay lại') }}" />
                <x-button.step-button from="timeSelectionModal" to="finalSummaryModal"
                    label="{{ __('Tiếp tục') }} →" id="confirmTimeSelectionButton" />
            </div>
        </div>
    </div>
</div>

{{-- Modal: Xác nhận cuối --}}
<div class="modal fade" id="finalSummaryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ __('Đăng ký buổi học') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="summary-section">
                    <h5>{{ __('Khóa học và ngày học') }}</h5>
                    <div class="summary-course-info d-flex">
                        <div class="summary-course-image"><i class="fas fa-image"></i></div>
                        <div class="summary-course-details ms-3">
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
            <div class="modal-footer d-flex justify-content-between">
                <x-button.step-button from="finalSummaryModal" to="timeSelectionModal" variant="secondary"
                    label="← {{ __('Quay lại') }}" />
                <button type="button" class="btn final-confirm-btn" id="finalConfirmBtn">
                    <span class="spinner-border spinner-border-sm me-2" style="display: none;"></span>
                    <span class="button-text">{{ __('Xác nhận đăng ký') }}</span>
                    <span class="loading-text" style="display: none;">{{ __('Đang xử lý...') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
