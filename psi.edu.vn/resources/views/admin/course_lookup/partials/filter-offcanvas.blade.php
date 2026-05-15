<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">{{ __('Bộ lọc') }}</h4>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        {{-- 1. Danh mục --}}
        <div class="filter-group mb-3">
            <h5>{{ __('Danh mục') }}</h5>
            <div id="categoryFilterTags" class="tag-group"></div>
        </div>

        {{-- 2. Trình độ --}}
        <div class="filter-group mb-3">
            <h5>{{ __('Theo trình độ khóa học') }}</h5>
            <div id="levelFilterTags" class="tag-group"></div>
        </div>

        {{-- 3. Giới tính giáo viên --}}
        {{-- <div class="filter-group mb-3">
            <h5>{{ __('Giới tính giảng viên') }}</h5>
            <div id="genderFilterTags" class="tag-group"></div>
        </div> --}}

        {{-- 4. Đánh giá --}}
        {{-- <div class="filter-group mb-3">
            <h5>{{ __('Đánh giá giảng viên') }}</h5>
            <div id="ratingFilterTags" class="tag-group"></div>
        </div> --}}

        {{-- 5. Ngày học --}}
        <div class="filter-group mb-3">
            <h5>{{ __('Ngày học') }}</h5>
            <input type="date" class="form-control" id="filterDate">
        </div>

        {{-- 6. Giáo viên --}}
        {{-- <div class="filter-group mb-3">
            <h5>{{ __('Giáo viên') }}</h5>
            <div class="custom-select-wrapper dropdown">
                <input type="text" id="offcanvasTeacherSearchInput" placeholder="{{ __('Tìm giáo viên...') }}"
                    class="form-control" autocomplete="off">
                <ul id="offcanvasTeacherSearchList" class="dropdown-menu w-100"></ul>
            </div>
        </div> --}}

        {{-- 7. Buổi học --}}
        {{-- <div class="filter-group mb-3">
            <h5>{{ __('Buổi học') }}</h5>
            <div id="lessonFilterTags" class="tag-group"></div>
        </div> --}}

        <button type="button" class="btn btn-primary-booking w-100 mt-4"
            id="applyFiltersBtn">{{ __('Áp dụng') }}</button>
        <button type="button" class="btn btn-outline-secondary w-100 mt-2"
            id="clearFiltersBtn">{{ __('Xóa bộ lọc') }}</button>
    </div>
</div>
