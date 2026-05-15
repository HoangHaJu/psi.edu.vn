<style>
    /* ==================== 1. BIẾN MÀU (COLOR VARIABLES) ==================== */
    :root {
        --color-Bunting-50: #edf6ff;
        --color-Bunting-100: #d7e9ff;
        --color-Bunting-200: #b7d9ff;
        --color-Bunting-300: #86c3ff;
        --color-Bunting-400: #4da2ff;
        --color-Bunting-500: #247bff;
        /* Màu chính (Primary) */
        --color-Bunting-600: #0d58ff;
        --color-Bunting-700: #0641ef;
        --color-Bunting-800: #0c36c1;
        --color-Bunting-900: #113397;
        --color-Bunting-950: #0d1b4c;

        /* Định nghĩa thêm một số biến màu chung từ bảng Bunting để dễ sử dụng */
        --color-primary: var(--color-Bunting-500);
        --color-primary-hover: var(--color-Bunting-600);
        --color-primary-light: var(--color-Bunting-100);
        --color-text-dark: var(--color-Bunting-950);
        --color-text-muted: var(--color-Bunting-700);
        --color-border-light: var(--color-Bunting-200);
        /* Viền và border nhạt */
        --color-shadow-light: rgba(0, 0, 0, 0.05);
        /* Bóng nền chung */
        --color-focus-shadow: rgba(var(--color-Bunting-500), 0.25);
        /* Bóng khi focus */
        --color-star-rating: #f39c12;
        /* Màu vàng cam cho sao */
        --color-success: #2ecc71;
        /* Màu xanh lá cây cho success (cho toast) */
        --color-danger: #e74c3c;
        /* Màu đỏ cho danger (cho toast) */
    }

    .container-fluid {
        max-width: 1300px;
        padding-left: 15px;
        padding-right: 15px;
        font-size: 15px;
    }

    /* ==================== 2. KHỐI CHUNG & HIỆU ỨNG THẺ (CARD & SHADOWS) ==================== */
    #studentListContainer .student-card p,
    #courseListModalContainer.course-card-modal p {
        font-size: 0.95rem;
        margin: 0;
    }

    /* Thiết lập chung cho các khối chứa nội dung quan trọng */
    .course-card-booking,
    .summary-section,
    .offcanvas,
    .date-card,
    .teacher-card,
    .modal-content,
    .summary-course-info,
    #ticketTypeContainer .card,
    #studentListContainer .student-card,
    #courseListModalContainer .course-card-modal {
        font-size: 15px;
        background-color: #fff;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Unified Section Styling */
    .course-card-modal-booking,
    .summary-section {
        padding: 0;
        margin-bottom: 25px;
        border: 1px solid var(--color-Bunting-100);
        box-shadow: 0 4px 12px var(--color-shadow-light);
    }

    .summary-section {
        padding: 30px;
    }

    /* COURSE CARD: HOVER TỐI ƯU */
    .course-card-booking {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        position: relative;
        border-radius: 12px;
    }

    .course-card-booking:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(var(--color-Bunting-900), 0.15);
        border-color: var(--color-Bunting-300);
    }

    /* ==================== 3. NÚT (BUTTONS) ==================== */

    .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: none;
    }

    /* Nút chính */
    .btn-primary-booking,
    .final-confirm-btn {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: #fff;
        padding: 12px 28px;
        font-size: 1.05rem;
        box-shadow: 0 4px 15px rgba(var(--color-Bunting-500), 0.3);
    }

    .btn-primary-booking:hover,
    .final-confirm-btn:hover {
        background-color: var(--color-primary-hover);
        border-color: var(--color-primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(var(--color-Bunting-500), 0.4);
        color: #fff;
    }

    /* Nút Outline */
    .btn-outline-lesson,
    .btn-outline-secondary {
        font-size: 0.85rem;
        border-color: var(--color-border-light);
        color: var(--color-text-muted);
        padding: 12px 15px;
    }

    .btn-outline-secondary:hover {
        background-color: var(--color-Bunting-50);
        border-color: var(--color-Bunting-300);
        color: var(--color-Bunting-900);
        transform: none;
    }

    /* ==================== 4. FORM VÀ INPUTS ==================== */

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid var(--color-border-light);
        padding: 12px 18px;
        box-shadow: none;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 0.25rem var(--color-focus-shadow);
    }

    /* Filter Tags (Checkboxes as Tags) */
    .form-check-inline .form-check-label {
        padding: 8px 18px;
        border: 1px solid var(--color-Bunting-200);
        border-radius: 25px;
        background-color: var(--color-Bunting-50);
        color: var(--color-Bunting-800);
        font-size: 0.9rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* TAGS: HOVER TỐI ƯU */
    .form-check-inline .form-check-label:hover {
        border-color: var(--color-primary);
        background-color: var(--color-Bunting-100);
        color: var(--color-Bunting-900);
        box-shadow: 0 2px 8px rgba(var(--color-Bunting-500), 0.1);
        transform: none;
    }

    .form-check-inline .form-check-input:checked+.form-check-label {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(var(--color-Bunting-500), 0.3);
    }


    /* ẨN INPUT MẶC ĐỊNH CHO TẤT CẢ CHECKBOX TRONG CÁC THẺ CHỌN */
    .form-check-inline .form-check-input,
    #studentListContainer .student-card .form-check-input,
    #teacherListContainer .teacher-card .form-check-input,
    #courseListModalContainer .course-card-modal .form-check-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
    }

    /* ==================== 5. CHI TIẾT THẺ KHÓA HỌC (COURSE CARD DETAILS) ==================== */

    .course-card-image {
        width: 100%;
        background-color: var(--color-Bunting-50);
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        font-size: 3.5em;
        color: var(--color-Bunting-300);
    }

    .course-card-body {
        padding: 25px;
        flex-grow: 1;
    }

    .course-title {
        font-size: 1.65rem;
        font-weight: 800;
        margin-bottom: 10px;
        color: var(--color-text-dark);
        line-height: 1.2;
    }

    .course-category {
        font-size: 0.95rem;
        color: var(--color-Bunting-700);
        margin-bottom: 12px;
    }

    .course-actions {
        padding: 15px 25px;
        border-top: 1px solid var(--color-Bunting-100);
        background-color: var(--color-Bunting-50);
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .course-price {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--color-Bunting-700);
    }

    /* ==================== 6. MODAL/OFFCANVAS VÀ THẺ CON ==================== */

    /* Offcanvas (Filter Sidebar) */
    .offcanvas {
        background-color: var(--color-Bunting-50);
        box-shadow: -8px 0 25px rgba(0, 0, 0, 0.1);
        border-radius: 15px 0 0 15px;
        width: 320px;
        border: none;
    }

    .offcanvas-body .filter-group .btn-filter-tag:hover {
        background-color: var(--color-Bunting-200);
        border-color: var(--color-Bunting-300);
        transform: none;
    }

    /* Modal - General */
    .modal-content {
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: none;
    }

    /* Modal Date Selection */
    .date-card {
        padding: 12px;
        border: 1px solid var(--color-Bunting-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* DATE CARD: HOVER TỐI ƯU */
    .date-card:hover {
        border-color: var(--color-primary);
        box-shadow: 0 0 15px rgba(var(--color-Bunting-500), 0.2);
        transform: translateY(-4px);
    }

    .date-card.active {
        background-color: var(--color-Bunting-50);
        border-color: var(--color-primary);
        box-shadow: 0 0 18px rgba(var(--color-Bunting-500), 0.3);
    }

    /* TEACHER CARD (ĐÃ TỐI ƯU HÓA) */
    .teacher-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        border: 1px solid var(--color-Bunting-200);
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Hover và Selected cho Teacher Card */
    .teacher-card:hover,
    .teacher-card.selected {
        border-color: var(--color-primary) !important;
        box-shadow: 0 0 15px rgba(var(--color-Bunting-500), 0.2);
        transform: translateY(-4px);
    }

    .teacher-card.selected {
        background-color: var(--color-Bunting-50);
        transform: none;
        /* Bỏ transform khi đã chọn để ổn định */
    }

    .teacher-avatar-wrapper {
        width: 60px;
        height: 60px;
        min-width: 60px;
        margin-right: 15px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--color-Bunting-100);
    }

    .teacher-avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .teacher-info-wrapper {
        flex-grow: 1;
    }

    .teacher-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 2px !important;
    }

    .teacher-detail {
        font-size: 0.9rem;
        color: var(--color-text-muted);
        margin-bottom: 4px !important;
    }

    /* Đánh giá Sao */
    .star-rating {
        font-size: 0.9rem;
        white-space: nowrap;
        /* Giữ sao và rating cùng 1 hàng */
    }

    .star-rating .fas,
    .star-rating .far,
    .star-rating .fa-star-half-alt {
        color: var(--color-star-rating);
        font-size: 0.9em;
    }

    .star-rating .far.fa-star {
        color: var(--color-Bunting-300);
    }

    .star-rating .rating-value {
        font-size: 0.85em;
        color: var(--color-Bunting-600);
        font-weight: 600;
        margin-left: 3px;
    }

    /* Checkbox Tùy chỉnh (Hiện icon tick khi chọn) - ĐỂ CÓ VISUAL FEEDBACK KHI CHỌN */
    .teacher-checkbox+.form-check-label {
        display: block;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .teacher-checkbox+.form-check-label::before {
        content: "";
        display: block;
        width: 20px;
        height: 20px;
        border: 2px solid var(--color-Bunting-300);
        border-radius: 6px;
        background-color: #fff;
        transition: all 0.2s ease-in-out;
    }

    .teacher-checkbox:checked+.form-check-label::before {
        border-color: var(--color-primary);
        background-color: var(--color-primary);
    }



    /* Modal Time Selection */
    .time-slot {
        background-color: var(--color-Bunting-50);
        border: 1px solid var(--color-Bunting-200);
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.03);
    }

    /* TIME SLOT: HOVER TỐI ƯU */
    .time-slot:hover {
        background-color: var(--color-Bunting-100);
        border-color: var(--color-Bunting-300);
        transform: none;
    }

    .time-slot.selected {
        background-color: var(--color-primary);
        color: #fff;
        border-color: var(--color-primary);
        box-shadow: 0 3px 10px rgba(var(--color-Bunting-500), 0.3);
    }

    .time-slot.disabled {
        background-color: var(--color-Bunting-100);
        color: var(--color-Bunting-400);
    }

    /* Summary Course Info */
    .summary-course-info {
        background-color: var(--color-Bunting-50);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--color-Bunting-100);
    }

    /* ==================== 7. SUMMARY VÀ TOASTS ==================== */

    .summary-course-details h5 {
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--color-Bunting-900);
        font-size: 1.25rem;
    }

    .summary-course-details p {
        font-size: 0.95rem;
        color: var(--color-Bunting-700);
        margin-bottom: 5px;
    }

    .summary-teacher-card {
        border: 1px solid var(--color-Bunting-100);
        border-radius: 12px;
        padding: 20px;
        background-color: var(--color-Bunting-50);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        position: relative;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        transition: box-shadow 0.3s ease;
    }

    /* SUMMARY TEACHER CARD: HOVER TỐI ƯU (Dù là summary, nên thêm 1 hover nhẹ) */
    .summary-teacher-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .summary-teacher-card .teacher-avatar {
        width: 70px;
        height: 70px;
        font-size: 2rem;
        margin: 0;
        margin-right: 20px;
    }

    .summary-teacher-card .selected-times {
        color: var(--color-Bunting-700);
        font-weight: 700;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        white-space: nowrap;
    }

    .final-confirm-btn {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: #fff;
        font-size: 1.2rem;
        padding: 15px 30px;
        border-radius: 12px;
        width: 100%;
        box-shadow: 0 6px 20px rgba(var(--color-Bunting-500), 0.25);
    }

    /* FINAL CONFIRM BUTTON: HOVER TỐI ƯU */
    .final-confirm-btn:hover {
        background-color: var(--color-primary-hover);
        border-color: var(--color-primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(var(--color-Bunting-600), 0.35);
    }

    /* Toast Notifications */
    .toast-header.bg-success {
        background-color: var(--color-success) !important;
        color: #fff;
    }

    .toast-header.bg-danger {
        background-color: var(--color-danger) !important;
        color: #fff;
    }

    /* ==================== 8. LISTS VÀ SELECTION ==================== */

    /* STUDENT LIST */
    #studentListContainer .student-card {
        display: flex;
        width: -webkit-fill-available;
        padding: 10px;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--color-Bunting-200);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    /* STUDENT CARD: HOVER TỐI ƯU */
    #studentListContainer .student-card:hover,
    #studentListContainer .student-card.selected {
        border-color: var(--color-primary) !important;
        box-shadow: 0 0 15px rgba(var(--color-Bunting-500), 0.2);
    }


    /* TICKET LIST */
    #ticketTypeContainer {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 15px;
    }

    #ticketTypeContainer .card {
        border: 1px solid var(--color-border-light);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* TICKET CARD: HOVER TỐI ƯU */
    #ticketTypeContainer .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-color: var(--color-Bunting-300);
    }

    /* Khi chọn */
    #ticketTypeContainer .card.selected {
        border-color: var(--color-primary);
        background-color: var(--color-Bunting-50);
        box-shadow: 0 0 18px rgba(var(--color-Bunting-500), 0.3);
    }

    /* Icon check */
    #ticketTypeContainer .fa-check-circle {
        color: var(--color-success);
    }

    /* COURSE LIST MODAL */
    #courseListModalContainer .course-card-modal {
        display: flex;
        width: -webkit-fill-available;
        padding: 10px;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--color-Bunting-200);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    /* COURSE CARD MODAL: HOVER TỐI ƯU */
    #courseListModalContainer .course-card-modal:hover,
    #courseListModalContainer .course-card-modal.selected {
        border-color: var(--color-primary) !important;
        box-shadow: 0 0 15px rgba(var(--color-Bunting-500), 0.2);
        background-color: var(--color-Bunting-50);
    }

    /* ==================== 9. RESPONSIVE ADJUSTMENTS ==================== */

    @media (max-width: 768px) {

        /* Giảm hiệu ứng nâng trên mobile */
        .course-card-booking:hover,
        .date-card:hover,
        .teacher-card:hover {
            transform: translateY(-2px);
        }

        /* Cải thiện hiển thị thẻ giáo viên trên mobile */
        .teacher-card {
            padding: 12px;
        }

        .teacher-avatar-wrapper {
            width: 50px;
            height: 50px;
            min-width: 50px;
        }

        .summary-teacher-card .selected-times {
            position: static;
            transform: none;
            margin-top: 10px;
            text-align: left;
            width: 100%;
        }
    }

    @media (max-width: 576px) {

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 15px 20px;
        }

        .final-confirm-btn {
            padding: 12px 20px;
            font-size: 1.0rem;
        }
    }
</style>
