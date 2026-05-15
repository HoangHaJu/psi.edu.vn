// main.js - Main Application Module (ES6)
import { currentFilters, coursesData, resetPagination, setPagination } from "./state.js";

import { fetchCourses, fetchCategories, fetchLevels, fetchStudents } from "./api.js";

import { renderCourses, renderPagination } from "./render/course.js";
import { setupOffcanvas } from "./offcanvas.js";
import { setupAllEvents, setupCourseModalEvents } from "./events.js";
import { FilterUtils, debounce } from "./utils.js";
import { loadCoursesForModal, setupCourseModalSearchAndFilter } from "./render/courseModal.js";
import { setupStepButtons } from "./events.js";
let isInitialized = false;

/** ---------- INITIALIZATION ---------- */
async function initApp() {
    if (isInitialized) return console.warn("App already initialized");

    try {
        await loadInitialData();
        setupUI();
        setupAppEventListeners();
        await loadCourses();

        setupCourseModal(); // setup modal course
        isInitialized = true;
    } catch (error) {
        console.error("❌ Failed to initialize app:", error);
        showErrorToast("Không thể khởi tạo ứng dụng. Vui lòng tải lại trang.");
    }
}

/** ---------- SETUP COURSE MODAL ---------- */
function setupCourseModal() {
    const courseModalEl = document.getElementById("courseSelectionModal");
    if (!courseModalEl) return;

    // mỗi lần mở modal → load lại danh sách
    courseModalEl.addEventListener("show.bs.modal", async () => {
        await loadCoursesForModal();
    });

    // gắn event handler chỉ 1 lần
    setupCourseModalSearchAndFilter();
    setupCourseModalEvents();
}

/** ---------- LOAD INITIAL DATA ---------- */
async function loadInitialData() {
    try {
        const [categories, levels] = await Promise.all([fetchCategories(), fetchLevels()]);
        renderFilterOptions(categories, levels);
        await loadStudents();
    } catch (error) {
        console.error("❌ Failed to load initial data:", error);
        throw error;
    }
}

/** ---------- RENDER FILTER OPTIONS ---------- */
function renderFilterOptions(categories, levels) {
    renderCheckboxFilter("categoryFilterTags", categories, "category", (c) => c.name);
    renderCheckboxFilter("levelFilterTags", levels, "level", (l) => l);

    renderGenderOptions();
    renderRatingOptions();

    setupFilterCheckboxListeners();
}

function renderCheckboxFilter(containerId, items, type, getLabel) {
    const container = document.getElementById(containerId);
    if (!container || !Array.isArray(items)) return;

    container.innerHTML = "";
    items.forEach((item) => {
        const div = document.createElement("div");
        div.className = "form-check form-check-inline dynamic p-0";
        div.innerHTML = `
            <input class="form-check-input filter-checkbox" type="checkbox" 
                   id="${type}-${item.id || item}" data-type="${type}" value="${item.id || item}">
            <label class="form-check-label" for="${type}-${item.id || item}">${getLabel(item)}</label>
        `;
        container.appendChild(div);
    });
}

function renderGenderOptions() {
    const container = document.getElementById("genderFilterTags");
    if (!container) return;

    container.innerHTML = "";
    const genders = [
        { value: 1, text: "Nam" },
        { value: 2, text: "Nữ" },
    ];
    genders.forEach((g) => {
        const div = document.createElement("div");
        div.className = "form-check form-check-inline dynamic p-0";
        div.innerHTML = `
            <input class="form-check-input filter-checkbox" type="checkbox" 
                   id="gender-${g.value}" data-type="gender" value="${g.value}">
            <label class="form-check-label" for="gender-${g.value}">${g.text}</label>
        `;
        container.appendChild(div);
    });
}

function renderRatingOptions() {
    const container = document.getElementById("ratingFilterTags");
    if (!container) return;

    container.innerHTML = "";
    for (let i = 5; i >= 1; i--) {
        const div = document.createElement("div");
        div.className = "form-check form-check-inline dynamic p-0";
        div.innerHTML = `
            <input class="form-check-input filter-checkbox" type="checkbox" 
                   id="rating-${i}" data-type="rating" value="${i}">
            <label class="form-check-label" for="rating-${i}">${i} sao</label>
        `;
        container.appendChild(div);
    }
}

function setupFilterCheckboxListeners() {
    document.querySelectorAll(".filter-checkbox").forEach((cb) => {
        cb.addEventListener("change", () => {
            const type = cb.dataset.type;
            const value = cb.value;
            const labelText = cb.nextElementSibling.textContent;
            const container = document.getElementById(`${type}FilterTags`);

            if (cb.checked) FilterUtils.addTag(labelText, value, type, container);
            else FilterUtils.remove(value, type);

            resetPagination();
            loadCourses();
        });
    });
}

/** ---------- LOAD STUDENTS ---------- */
async function loadStudents() {
    try {
        const students = await fetchStudents();
        window.allFetchedStudents = students;
    } catch (err) {
        console.error("Failed to load students:", err);
    }
}

/** ---------- LOAD COURSES ---------- */
async function loadCourses(page = 1) {
    try {
        const { courses, lastPage } = await fetchCourses(page);
        coursesData.length = 0;
        coursesData.push(...courses);

        renderCourses(coursesData, setupAllEvents, page, lastPage, handlePageChange);
        renderPagination(page, lastPage, handlePageChange);
    } catch (err) {
        console.error("Failed to load courses:", err);
        showErrorToast("Không thể tải danh sách khóa học");
    }
}

function handlePageChange(newPage) {
    currentPage = newPage;
    loadCourses();
}

/** ---------- SETUP UI ---------- */
function setupUI() {
    setupOffcanvas();
    setupAllEvents();
    setupStepButtons();
}

/** ---------- APPLICATION EVENT LISTENERS ---------- */
function setupAppEventListeners() {
    const mainSearchInput = document.getElementById("mainCourseSearchInput");
    if (mainSearchInput) {
        const debouncedSearch = debounce(() => {
            currentFilters.search = mainSearchInput.value.trim();
            resetPagination();
            loadCourses();
        }, 300);

        mainSearchInput.addEventListener("input", debouncedSearch);
        mainSearchInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                currentFilters.search = mainSearchInput.value.trim();
                resetPagination();
                loadCourses();
            }
        });
    }

    const displayLimitSelect = document.getElementById("displayLimitSelect");
    if (displayLimitSelect) {
        displayLimitSelect.addEventListener("change", (e) => {
            const newLimit = parseInt(e.target.value);
            setPagination({ limit: newLimit });
            resetPagination();
            loadCourses();
        });
    }
    const filterDateInput = document.getElementById("filterDate");
    if (filterDateInput) {
        filterDateInput.addEventListener("change", (e) => {
            currentFilters.date = e.target.value;
            resetPagination();
            loadCourses();
        });
    }
}

/** ---------- ERROR TOAST ---------- */
function showErrorToast(msg) {
    console.error(msg);
}

/** ---------- INIT ---------- */
document.addEventListener("DOMContentLoaded", initApp);

/** ---------- LISTEN TO FILTER RELOAD EVENT ---------- */
window.addEventListener("courses:reload", () => {
    resetPagination();
    loadCourses();
});

export { initApp, loadCourses, loadInitialData };
