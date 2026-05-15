import {
    modalCoursesData,
    getSelectedCourseSingle,
    setSelectedCourseSingle,
    dataRegisterModal,
    resetSelections,
} from "../state.js";
import { fetchCoursesModal } from "../api.js";
import { ModalUtils, ToastUtils } from "../utils.js";
import { createPagination } from "../pagination.js";
import { renderDates } from "./dates.js";
import { setupDateSelectionEvents } from "../events.js";

function bindResetDateOnModalClose(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    // ❌ user bấm nút close
    modalEl.addEventListener("click", (e) => {
        const closeBtn = e.target.closest(".btn-close");
        if (!closeBtn) return;

        resetSelections();
    });

    // 🖱️ user click backdrop
    modalEl.addEventListener("mousedown", (e) => {
        if (e.target === modalEl) {
            resetSelections();
        }
    });
}

export function setupModalCloseResetEvents() {
    ["teacherSelectionModal", "dateSelectionModal", "timeSelectionModal", "finalSummaryModal"].forEach(
        bindResetDateOnModalClose
    );
}

// ===================== RESTORE PREVIOUS SELECTION =====================
export function restorePreviousCourse() {
    const previousCourse = dataRegisterModal.course;
    if (!previousCourse?.id) return;

    const fullCourse = modalCoursesData.find((c) => c.id === previousCourse.id);
    if (fullCourse) setSelectedCourseSingle(fullCourse);
    else {
        setSelectedCourseSingle(null);
        dataRegisterModal.course = null;
    }
}

// ===================== STATE & HELPERS =====================
const modalState = {
    search: "",
    categoryIds: [],
    page: 1,
    lastPage: 1,
    perPage: 8,
};

// ===================== LOAD + FILTER COURSES =====================
export async function loadCoursesForModal() {
    try {
        toggleCourseModalLoading(true);

        const { courses, lastPage } = await fetchCoursesModal({
            search: modalState.search,
            categoryIds: modalState.categoryIds, // ✅ đúng key
            page: modalState.page,
            perPage: modalState.perPage,
        });

        modalState.lastPage = lastPage;

        modalCoursesData.length = 0;
        modalCoursesData.push(...courses.map((c) => ({ ...c })));

        restorePreviousCourse();
        renderCourseListModal(modalCoursesData);

        createPagination("#courseModalPagination", {
            page: modalState.page,
            lastPage: modalState.lastPage,
            onChange: async (newPage) => {
                modalState.page = newPage;
                await loadCoursesForModal();
                window.scrollTo({ top: 0, behavior: "smooth" });
            },
        });
    } catch (err) {
        console.error("[loadCoursesForModal] Failed:", err);
        ToastUtils.showError("Không thể tải danh sách khóa học.");
    } finally {
        toggleCourseModalLoading(false);
    }
}

// ===================== RENDER COURSES =====================
export function renderCourseListModal(courses = []) {
    const container = document.getElementById("courseListModalContainer");
    if (!container) return;

    container.innerHTML = "";
    const currentSelected = getSelectedCourseSingle();

    if (!courses.length) {
        container.innerHTML = '<p class="text-center w-100">Không tìm thấy khóa học phù hợp.</p>';
        updateCourseConfirmButton(null);
        return;
    }

    courses.forEach((course) => {
        const isSelected = currentSelected?.id === course.id;
        const categoryName =
            Array.isArray(course.categories) && course.categories.length
                ? course.categories.map((c) => c.name).join(", ")
                : "N/A";
        container.insertAdjacentHTML(
            "beforeend",
            `<div class="col-md-6 mb-3">
                <div class="course-card-modal ${isSelected ? "selected" : ""}" data-course-id="${course.id}">
                    <div>
                        <p>${course.name || "N/A"}</p>
                        <p class="text-muted">${categoryName}</p>
                    </div>
                    <div class="form-check ms-auto">
                        <input class="form-check-input course-radio" type="radio" name="course" value="${course.id}" ${
                isSelected ? "checked" : ""
            }>
                        <label class="form-check-label"></label>
                    </div>
                </div>
            </div>`
        );
    });

    // click & radio event
    container.querySelectorAll(".course-card-modal").forEach((card) => {
        const radio = card.querySelector(".course-radio");

        radio.addEventListener("change", () => {
            const courseId = parseInt(radio.value, 10);
            const course = courses.find((c) => c.id === courseId);
            if (course) {
                setSelectedCourseSingle(course);
                container.querySelectorAll(".course-card-modal").forEach((c) => c.classList.remove("selected"));
                card.classList.add("selected");
                updateCourseConfirmButton(course);
            }
        });

        card.addEventListener("click", (e) => {
            if (e.target.tagName !== "INPUT") {
                radio.checked = true;
                radio.dispatchEvent(new Event("change", { bubbles: true }));
            }
        });
    });

    updateCourseConfirmButton(currentSelected);
}

// ===================== CONFIRM BUTTON =====================
export function updateCourseConfirmButton(selectedCourse) {
    const btn = document.getElementById("courseConfirmSelectionButton");
    if (!btn) return;

    btn.textContent = "Xác nhận chọn";
    btn.disabled = !selectedCourse;

    btn.replaceWith(btn.cloneNode(true));
    const newBtn = document.getElementById("courseConfirmSelectionButton");

    newBtn.addEventListener("click", async () => {
        const selected = getSelectedCourseSingle();
        if (!selected) return ToastUtils.showError("Vui lòng chọn một khóa học.");
        dataRegisterModal.course = selected;

        try {
            await ModalUtils.switch("courseSelectionModal", "dateSelectionModal");
            setTimeout(() => {
                renderDates();
                setupDateSelectionEvents();
            }, 150);
        } catch (err) {
            ToastUtils.showError("Không thể mở modal chọn ngày.");
            console.error("[CourseModal] Error switching modals:", err);
        }
    });
}

// ===================== SEARCH + FILTER =====================
let courseSearchTimer;
export function setupCourseModalSearchAndFilter() {
    const searchInput = document.getElementById("courseSearchInput");
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            clearTimeout(courseSearchTimer);
            courseSearchTimer = setTimeout(async () => {
                modalState.search = searchInput.value.trim();
                modalState.page = 1;
                await loadCoursesForModal();
            }, 300);
        });
    }

    // Filter by category
    document.querySelectorAll(".course-category-filter").forEach((cb) => {
        cb.addEventListener("change", async () => {
            modalState.categoryIds = Array.from(document.querySelectorAll(".course-category-filter:checked")).map(
                (el) => parseInt(el.value, 10)
            );
            modalState.page = 1;
            await loadCoursesForModal();
        });
    });
}

// ===================== LOADING OVERLAY =====================
function toggleCourseModalLoading(isLoading) {
    const overlay = document.getElementById("courseModalLoading");
    if (!overlay) return;
    overlay.classList.toggle("d-none", !isLoading);
}
