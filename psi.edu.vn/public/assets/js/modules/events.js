// events.js - ES6
import {
    fetchTeacherAvailableTimes,
    fetchTeachers,
    createBookings,
    fetchStudents,
    fetchStudentTicketOptions,
} from "./api.js";
import {
    currentFilters,
    dataRegisterModal,
    selectedTeachers,
    selectedTimeSlots,
    selectedCourse,
    selectedDate,
    setSelectedCourse,
    coursesData,
    modalCoursesData,
    setSelectedDate,
    resetPagination,
    resetSelections,
    resetFilters,
    selectedStudent,
    setAllStudents,
    dataRegisterByAdmin,
    getSelectedTicket,
    setSelectedCourseSingle,
} from "./state.js";
import { ModalUtils, ToastUtils, toggleLoadingState } from "./utils.js";
import { renderTeacherList } from "./render/teacher.js";
import { renderTimeSlots } from "./render/timeSlots.js";
import { renderDates } from "./render/dates.js";
import { renderFinalSummary } from "./render/summary.js";
import { renderStudentList } from "./render/student.js";
import {
    setupCourseModalSearchAndFilter,
    loadCoursesForModal,
    renderCourseListModal,
    setupModalCloseResetEvents,
} from "./render/courseModal.js";
import { renderTicketTypes } from "./render/ticket.js";
import { AppConfig } from "./config.js";

// ===================== Attach Once Helper =====================
const attachedListeners = new Set();

function attachOnce(key, fn) {
    if (attachedListeners.has(key)) return;
    fn();
    attachedListeners.add(key);
}

// ===================== REGISTER BUTTON =====================
function addRegisterButtonListeners() {
    document.addEventListener("click", (e) => {
        // Luồng bình thường cho người dùng
        if (e.target.matches(".register-course-btn")) {
            handleCourseRegisterClick(e.target);
        }

        // Luồng admin đăng ký cho học viên khác
        if (e.target.matches("#registerForStudentBtn")) {
            handleAdminRegisterBtnClick(e.target);
        }
    });
}

// ===================== Handle normal course registration =====================
function handleCourseRegisterClick(button) {
    const courseId = parseInt(button.dataset.courseId);
    const card = button.closest(".course-card-booking");
    if (!card) return console.error("❌ Course card not found");

    const course = coursesData.find((c) => c.id === courseId);
    if (!course) return console.error("❌ Course not found in data");

    const courseData = {
        id: courseId,
        title: card.dataset.courseTitle || course.name,
        category: card.dataset.courseCategory || "N/A",
        level: card.dataset.courseLevel || "N/A",
        name: course.name,
        avatar: course.avatar,
        description: course.description,
    };

    setSelectedCourse(courseData);

    if (selectedDate && dataRegisterModal.studentId && selectedTeachers.length > 0) {
        renderFinalSummary();
        ModalUtils.open("finalSummaryModal").show();
        return;
    }

    if (!selectedDate) {
        renderDates();
        ModalUtils.open("dateSelectionModal").show();
        return;
    }

    if (selectedTeachers.length === 0) {
        loadTeachersForDate(selectedDate);
        ModalUtils.open("teacherSelectionModal").show();
        return;
    }

    // if (!dataRegisterModal.studentId) {
    //     ToastUtils.showError("Vui lòng chọn học viên trước khi đăng ký.");
    // }
}

// Gọi khi admin bấm "Đăng ký cho học viên"
function handleAdminRegisterBtnClick() {
    openStudentModal();
}

// ===================== Khi admin confirm chọn học viên =====================

// ===================== COURSE SEARCH =====================
function setupCourseSearch() {
    const searchInput = document.getElementById("mainCourseSearchInput");
    if (searchInput) {
        searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") applySearchFilter();
        });
    }

    const searchBtn = document.getElementById("mainCourseSearchBtn");
    if (searchBtn) searchBtn.addEventListener("click", applySearchFilter);
}

function applySearchFilter() {
    const searchInput = document.getElementById("mainCourseSearchInput");
    currentFilters.search = searchInput?.value.trim() || "";

    resetPagination();

    window.dispatchEvent(new CustomEvent("courses:reload", { detail: { filters: currentFilters } }));
}

// ===================== COURSE FILTERS =====================
function setupCourseFilters() {
    const applyBtn = document.getElementById("applyFiltersBtn");
    if (applyBtn) {
        applyBtn.addEventListener("click", () => {
            applyCourseFilters();
        });
    }

    const clearBtn = document.getElementById("clearFiltersBtn");
    if (clearBtn) {
        clearBtn.addEventListener("click", () => {
            resetFilters();
            document.querySelectorAll(".badge.bg-primary.me-1.mb-1").forEach((tag) => tag.remove());
            document.querySelectorAll(".filter-checkbox").forEach((cb) => (cb.checked = false));
            resetPagination();
            window.dispatchEvent(new CustomEvent("courses:reload"));
        });
    }
}

function applyCourseFilters() {
    const teacherInput = document.getElementById("offcanvasTeacherSearchInput");
    const teacherName = teacherInput?.value.trim();
    const teacher = window.allFetchedTeachers?.find((t) => t.fullname === teacherName);
    currentFilters.teacher_id = teacher ? teacher.id : null;

    currentFilters.date = document.getElementById("filterDate")?.value || "";
    currentFilters.category_ids = getSelectedTagsFromCheckboxes("categoryFilterTags");
    currentFilters.levels = getSelectedTagsFromCheckboxes("levelFilterTags");
    currentFilters.genders = getSelectedTagsFromCheckboxes("genderFilterTags");
    currentFilters.ratings = getSelectedTagsFromCheckboxes("ratingFilterTags");
    currentFilters.lessons = getSelectedTagsFromCheckboxes("lessonFilterTags");

    const studentInput = document.getElementById("offcanvasStudentSearchInput");
    const studentName = studentInput?.value.trim();
    const student = window.allFetchedStudents?.find((s) => s.fullname === studentName);
    currentFilters.student_id = student ? student.id : null;

    if (currentFilters.date) setSelectedDate(currentFilters.date);
    if (teacher) selectedTeachers.splice(0, selectedTeachers.length, teacher);
    if (currentFilters.lessons?.length) {
        selectedTimeSlots.splice(0, selectedTimeSlots.length, {
            lesson_id: currentFilters.lessons[0],
            teacher_id: teacher?.id,
        });
    }
    if (student) dataRegisterModal.studentId = student.id;

    resetPagination();

    const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById("filterOffcanvas"));
    if (offcanvas) offcanvas.hide();

    window.dispatchEvent(new CustomEvent("courses:reload"));
}

function getSelectedTagsFromCheckboxes(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return [];
    return Array.from(container.querySelectorAll("input[type='checkbox']:checked")).map((cb) => cb.value);
}

// ===================== DATE SELECTION =====================
export function setupDateSelectionEvents() {
    const btn = document.getElementById("confirmDateAndShowTeacherModal");
    if (!btn) return;

    btn.addEventListener("click", async () => {
        if (!selectedDate) {
            ToastUtils.showError("Vui lòng chọn một ngày.");
            return;
        }
        try {
            await ModalUtils.switch("dateSelectionModal", "teacherSelectionModal");
            await loadTeachersForDate(selectedDate);
        } catch (err) {
            console.error(err);
            ToastUtils.showError("Không thể chuyển sang bước chọn giáo viên.");
        }
    });
}
// ===================== STUDENT MODAL =====================
let studentPagination = {
    current_page: 1,
    last_page: 1,
    next_page_url: null,
    data: [],
    keyword: "",
    loadingNext: false,
};
async function loadStudentPage(page = 1, keyword = "") {
    try {
        const res = await fetchStudents(page, keyword);
        if (!res) return;

        // Bảo vệ dữ liệu an toàn
        const pageData = Array.isArray(res.data) ? res.data : [];

        studentPagination.data = pageData;
        studentPagination.current_page = res.current_page || page;
        studentPagination.last_page =
            res.last_page || (res.total ? Math.ceil(res.total / (res.per_page || res.data.length || 1)) : 1);
        studentPagination.next_page_url = res.next_page_url || null;
        studentPagination.prev_page_url = res.prev_page_url || null;
        studentPagination.keyword = keyword || "";

        setAllStudents(studentPagination.data);

        // Render danh sách học viên
        renderStudentList(studentPagination.data, selectedStudent, studentPagination.data);

        // Render phân trang
        renderPagination(res);
    } catch (err) {
        console.error("❌ Lỗi loadStudentPage:", err);
        ToastUtils.showError("Không thể tải danh sách học viên.");
    } finally {
        studentPagination.loadingNext = false;
    }
}

export function openStudentModal(initialKeyword = "") {
    // initial load trang 1
    loadStudentPage(1, initialKeyword);

    const studentModalEl = document.getElementById("studentSelectionModal");
    if (!studentModalEl) return console.error("❌ Modal #studentSelectionModal not found");

    const studentModal = bootstrap.Modal.getOrCreateInstance(studentModalEl);
    studentModal.show();
}

export function setupStudentModalEvents() {
    const studentSearch = document.getElementById("studentSearchInput");
    if (studentSearch) {
        let timer;
        studentSearch.addEventListener("input", () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const keyword = studentSearch.value.trim();
                loadStudentPage(1, keyword);
            }, 350);
        });
    }

    const studentConfirmBtn = document.getElementById("studentConfirmSelectionButton");
    if (studentConfirmBtn) {
        studentConfirmBtn.addEventListener("click", async () => {
            // <- thêm async
            if (!selectedStudent) {
                ToastUtils.showError("Vui lòng chọn học viên.");
                return;
            }

            dataRegisterModal.studentId = selectedStudent.id;

            const studentModal = bootstrap.Modal.getOrCreateInstance(document.getElementById("studentSelectionModal"));
            studentModal.hide();

            try {
                const data = await fetchStudentTicketOptions(selectedStudent.id);

                if (!data || !Array.isArray(data.all_types) || !Array.isArray(data.owned)) {
                    console.error("[ERROR] API response format unexpected:", data);
                    ToastUtils.showError("Dữ liệu loại vé nhận về không đúng định dạng.");
                    return;
                }

                renderTicketTypes(data.all_types, data.owned);

                const ticketModalEl = document.getElementById("ticketSelectionModal");
                if (!ticketModalEl) return console.error("❌ Modal #ticketSelectionModal not found");
                const ticketModal = bootstrap.Modal.getOrCreateInstance(ticketModalEl);
                ticketModal.show();
            } catch (err) {
                console.error("[ERROR] Không thể tải loại vé cho học sinh:", err);
                ToastUtils.showError("Không thể tải loại vé cho học sinh. Xem console để biết chi tiết.");
            }
        });
    }

    // Infinite scroll on the student list container (gắn 1 lần)
    const container = document.getElementById("studentListContainer");
    if (container) {
        container.addEventListener("scroll", async () => {
            // nếu đang load next thì skip
            if (studentPagination.loadingNext) return;

            const nearBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - 60;
            if (nearBottom && studentPagination.next_page_url) {
                studentPagination.loadingNext = true;

                // Nếu API trả next_page_url, dùng url đó; nếu không, tăng page
                if (studentPagination.next_page_url) {
                    try {
                        const res = await fetch(
                            studentPagination.next_page_url +
                                (studentPagination.keyword
                                    ? `&search=${encodeURIComponent(studentPagination.keyword)}`
                                    : "")
                        );
                        const data = await res.json();
                        if (data) {
                            // append
                            studentPagination.data = [...studentPagination.data, ...(data.data || [])];
                            studentPagination.current_page = data.current_page || studentPagination.current_page + 1;
                            studentPagination.next_page_url = data.next_page_url || null;
                            setAllStudents(studentPagination.data);
                            renderStudentList(studentPagination.data, selectedStudent, studentPagination.data);
                        }
                    } catch (err) {
                        console.error("Lỗi load next page via next_page_url:", err);
                    } finally {
                        studentPagination.loadingNext = false;
                    }
                } else {
                    // fallback: tăng page số
                    const nextPage = studentPagination.current_page + 1;
                    if (nextPage <= studentPagination.last_page) {
                        await loadStudentPage(nextPage, studentPagination.keyword);
                    } else {
                        studentPagination.loadingNext = false;
                    }
                }
            }
        });
    }
}

// ------------------ Ticket Modal ------------------------ //
export function setupTicketModalEvents() {
    const ticketConfirmBtn = document.getElementById("ticketConfirmSelectionButton");
    if (!ticketConfirmBtn) return;

    ticketConfirmBtn.addEventListener("click", async () => {
        const selectedTicket = getSelectedTicket();
        if (!selectedTicket) {
            ToastUtils.showError("Vui lòng chọn vé trước khi tiếp tục.");
            return;
        }

        try {
            await ModalUtils.switch("ticketSelectionModal", "courseSelectionModal");

            const previousCourse = dataRegisterModal.course;
            if (previousCourse?.id) {
                const fullCourse = modalCoursesData.find((c) => c.id === previousCourse.id);
                if (fullCourse) setSelectedCourseSingle(fullCourse);
            }

            renderCourseListModal(modalCoursesData);
        } catch (err) {
            console.error("[Ticket → Course] Lỗi load courses:", err);
            ToastUtils.showError("Không thể tải danh sách khóa học.");
        }
    });

    // 🔙 Back: Ticket → Student
    document.querySelectorAll('[data-bs-target="#studentSelectionModal"]').forEach((btn) => {
        btn.addEventListener("click", async () => {
            await ModalUtils.switch("ticketSelectionModal", "studentSelectionModal");
        });
    });
}
// --------------------------- Course Modal --------------------------------//
export function setupCourseModalEvents() {
    const modalEl = document.getElementById("courseSelectionModal");
    if (!modalEl || modalEl.dataset.bound) return;

    modalEl.addEventListener("show.bs.modal", async () => {
        await loadCoursesForModal();
    });

    setupCourseModalSearchAndFilter();
    modalEl.dataset.bound = "true";
}

async function loadTeachersForDate(date) {
    try {
        const course = dataRegisterModal.course;
        if (!course?.id) {
            console.warn("[WARN] loadTeachersForDate: Chưa chọn khóa học hợp lệ.", course);
            ToastUtils.showError("Vui lòng chọn khóa học trước khi chọn giáo viên.");
            return;
        }

        const teachers = await fetchTeachers(date, course.id, {});
        window.allFetchedTeachers = teachers;

        renderTeacherList(teachers, selectedTeachers, teachers);
    } catch (err) {
        console.error(err);
        ToastUtils.showError("Không thể tải danh sách giáo viên.");
    }
}

// ===================== TEACHER SELECTION =====================
function setupTeacherSelectionEvents() {
    const searchInput = document.getElementById("teacherSearchInput");
    if (searchInput) searchInput.addEventListener("input", filterTeachersInModal);

    const genderFilter = document.getElementById("teacherGenderFilter");
    if (genderFilter) genderFilter.addEventListener("change", filterTeachersInModal);

    const ratingFilter = document.getElementById("teacherRatingFilter");
    if (ratingFilter) ratingFilter.addEventListener("change", filterTeachersInModal);

    const confirmBtn = document.getElementById("teacherConfirmSelectionButton");
    if (confirmBtn) {
        confirmBtn.addEventListener("click", async () => {
            if (!selectedTeachers.length) {
                ToastUtils.showError("Vui lòng chọn ít nhất một giáo viên.");
                return;
            }
            try {
                await ModalUtils.switch("teacherSelectionModal", "timeSelectionModal");
                await loadTimeSlotsForTeacher(selectedTeachers[0].id, selectedDate);
            } catch (err) {
                console.error(err);
                ToastUtils.showError("Không thể chuyển sang bước chọn thời gian.");
            }
        });
    }
}

function filterTeachersInModal() {
    const searchText = document.getElementById("teacherSearchInput")?.value.toLowerCase() || "";
    const gender = document.getElementById("teacherGenderFilter")?.value || "";
    const rating = parseInt(document.getElementById("teacherRatingFilter")?.value) || NaN;
    const allTeachers = window.allFetchedTeachers || [];

    const filtered = allTeachers.filter((t) => {
        const matchName = t.fullname.toLowerCase().includes(searchText);
        const matchGender = !gender || String(t.gender) === gender;
        const teacherRating = parseFloat(t.average_rating || t.rateForStudent || 0);
        const matchRating = isNaN(rating) || teacherRating >= rating;
        return matchName && matchGender && matchRating;
    });

    renderTeacherList(filtered, selectedTeachers, allTeachers);
}

// ===================== TIME SELECTION =====================
function setupTimeSelectionEvents() {
    const confirmBtn = document.getElementById("confirmTimeSelectionButton");
    if (!confirmBtn) return;

    confirmBtn.addEventListener("click", () => {
        if (!selectedTimeSlots.length) {
            ToastUtils.showError("Vui lòng chọn ít nhất một khung giờ.");
            return;
        }
        ModalUtils.switch("timeSelectionModal", "finalSummaryModal");
        renderFinalSummary();
    });
}

async function loadTimeSlotsForTeacher(teacherId, date) {
    try {
        const timeSlots = await fetchTeacherAvailableTimes(teacherId, date);
        renderTimeSlots(timeSlots, teacherId);
    } catch (err) {
        console.error(err);
        ToastUtils.showError("Không thể tải khung giờ trống.");
    }
}

// ===================== FINAL SUMMARY ===================== //
export function setupFinalSummaryEvents() {
    const btn = document.getElementById("finalConfirmBtn");
    if (!btn) return;

    btn.addEventListener("click", async () => {
        const course = dataRegisterModal.course || selectedCourse;
        const date = dataRegisterModal.date || selectedDate;
        const studentId = dataRegisterModal.studentId;
        const selectedTicket = getSelectedTicket();

        if (studentId) {
            dataRegisterByAdmin.ticketId = selectedTicket?.value || null;
            dataRegisterByAdmin.ticketType = selectedTicket?.type || null; // lưu luôn type
        }

        const ticketId = dataRegisterByAdmin?.ticketId;
        const ticketType = dataRegisterByAdmin?.ticketType; // lấy type
        const teachers = dataRegisterModal.teachers?.length ? dataRegisterModal.teachers : selectedTeachers;
        const timeSlots = dataRegisterModal.timeSlots?.length ? dataRegisterModal.timeSlots : selectedTimeSlots;

        if (!course) return ToastUtils.showError("Chưa chọn khóa học.");
        if (!date) return ToastUtils.showError("Chưa chọn ngày học.");
        if (!timeSlots.length) return ToastUtils.showError("Chưa có time slot nào được chọn.");

        const today = new Date().toISOString().split("T")[0];
        if (new Date(date) < new Date(today)) {
            return ToastUtils.showError("Không thể đăng ký ngày học trong quá khứ.");
        }

        // ===================== BUILD BOOKINGS DATA =====================
        const bookings = timeSlots.map((slot) => {
            const baseData = {
                course_id: course.id,
                date: slot.date || date,
                teacher_id: teachers?.[0]?.id ?? slot.teacher_id ?? null,
                lesson_id: slot.lesson_id || slot.lesson?.lesson_id,
                teacher_lesson_id: slot.teacher_lesson_id || slot.lesson?.teacher_lesson_id,
                start_time: slot.start_time || slot.lesson?.start_time,
            };

            if (studentId) {
                // Admin flow, thêm ticketId và ticketType
                return { ...baseData, student_id: studentId, ticket_id: ticketId, ticket_type: ticketType };
            }

            // Student flow
            return baseData;
        });

        // Validate bookings
        const invalid = bookings.filter((b) => !b.lesson_id || !b.start_time || !b.date || !b.teacher_id);
        if (invalid.length) {
            console.warn("[DEBUG] Invalid bookings detected:", invalid);
            return ToastUtils.showError("Time slot không hợp lệ. Vui lòng chọn lại.");
        }

        toggleLoadingState(true);
        try {
            // ===================== CALL API =====================
            const endpoint = studentId ? AppConfig.apiEndpoints.adminRegister : AppConfig.apiEndpoints.studentRegister;

            const response = await createBookings(endpoint, bookings);

            ToastUtils.showSuccess("✅ Đăng ký khóa học thành công!");
            ModalUtils.close("finalSummaryModal");

            resetSelections();
            resetFilters();
            window.dispatchEvent(new CustomEvent("courses:reload"));
        } catch (err) {
            console.error("[ERROR] Booking API error:", err);
            if (err.errors) {
                const messages = Object.values(err.errors).flat().join("<br>");
                ToastUtils.showError(`Lỗi đăng ký:<br>${messages}`);
            } else {
                ToastUtils.showError(err.message || "Có lỗi xảy ra khi đăng ký.");
            }
        } finally {
            toggleLoadingState(false);
        }
    });
}

export function setupStepButtons() {
    document.querySelectorAll(".step-btn").forEach((btn) => {
        if (btn.dataset.bound) return;

        btn.addEventListener("click", () => {
            const from = btn.dataset.from;
            const to = btn.dataset.to;

            if (!from || !to) {
                console.warn("[StepButton] missing from/to dataset", btn);
                return;
            }

            ModalUtils.switch(from, to);
        });

        btn.dataset.bound = "true";
    });
}
function renderPagination(data) {
    const paginationContainer = document.getElementById("studentPaginationContainer");
    if (!paginationContainer) return;

    const { current_page, last_page, prev_page_url, next_page_url } = data;

    paginationContainer.innerHTML = `
        <nav aria-label="Student pagination">
            <ul class="pagination justify-content-center flex-wrap mb-0"></ul>
        </nav>
    `;

    const ul = paginationContainer.querySelector(".pagination");

    // Previous button
    ul.insertAdjacentHTML(
        "beforeend",
        `
        <li class="page-item ${!prev_page_url ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${
                current_page - 1
            }" tabindex="-1" aria-disabled="${!prev_page_url}">
                « Trước
            </a>
        </li>`
    );

    // Hiển thị 2 trang trước & sau
    const start = Math.max(1, current_page - 2);
    const end = Math.min(last_page, current_page + 2);

    if (start > 1) {
        ul.insertAdjacentHTML(
            "beforeend",
            `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`
        );
        if (start > 2)
            ul.insertAdjacentHTML(
                "beforeend",
                `<li class="page-item disabled"><span class="page-link">...</span></li>`
            );
    }

    for (let i = start; i <= end; i++) {
        ul.insertAdjacentHTML(
            "beforeend",
            `
            <li class="page-item ${i === current_page ? "active" : ""}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`
        );
    }

    if (end < last_page) {
        if (end < last_page - 1)
            ul.insertAdjacentHTML(
                "beforeend",
                `<li class="page-item disabled"><span class="page-link">...</span></li>`
            );
        ul.insertAdjacentHTML(
            "beforeend",
            `<li class="page-item"><a class="page-link" href="#" data-page="${last_page}">${last_page}</a></li>`
        );
    }

    // Next button
    ul.insertAdjacentHTML(
        "beforeend",
        `
        <li class="page-item ${!next_page_url ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${current_page + 1}">
                Sau »
            </a>
        </li>`
    );

    // Gắn sự kiện
    ul.querySelectorAll("a[data-page]").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const page = parseInt(link.dataset.page);
            if (!isNaN(page)) {
                loadStudentPage(page, studentPagination.keyword || "");
            }
        });
    });
}

// ===================== INIT =====================
export function setupAllEvents() {
    attachOnce("registerButtons", addRegisterButtonListeners);
    attachOnce("courseSearch", setupCourseSearch);
    attachOnce("courseFilters", setupCourseFilters);
    attachOnce("dateSelection", setupDateSelectionEvents);
    attachOnce("teacherSelection", setupTeacherSelectionEvents);
    attachOnce("timeSelection", setupTimeSelectionEvents);
    attachOnce("finalSummary", setupFinalSummaryEvents);

    attachOnce("studentModal", setupStudentModalEvents);
    attachOnce("ticketModal", setupTicketModalEvents);
    attachOnce("courseModal", setupCourseModalEvents);
    attachOnce("modalCloseResetDate", setupModalCloseResetEvents);
}

// DOM ready
document.addEventListener("DOMContentLoaded", setupAllEvents);
