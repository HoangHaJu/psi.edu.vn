// teacher.js - Full version with pagination
import { selectedTeachers } from "../state.js";
import { ToastUtils, ModalUtils } from "../utils.js";

// ===================== STATE =====================
let teacherPagination = {
    page: 1,
    lastPage: 1,
    perPage: 8,
    data: [],
    keyword: "",
    loadingNext: false,
};

// ===================== LOAD TEACHERS =====================
export async function loadTeacherPage(page = 1, keyword = "") {
    try {
        teacherPagination.page = page;
        teacherPagination.keyword = keyword;

        const res = await window.fetchTeachers?.(page, keyword); // API phải trả { teachers: [], lastPage: n }
        if (!res || !Array.isArray(res.teachers)) return;

        teacherPagination.data = res.teachers;
        teacherPagination.lastPage = res.lastPage || 1;

        window.allFetchedTeachers = teacherPagination.data;
        renderTeacherList(teacherPagination.data);
        renderTeacherPagination();
    } catch (err) {
        console.error("❌ Lỗi loadTeacherPage:", err);
        ToastUtils.showError("Không thể tải danh sách giáo viên.");
    } finally {
        teacherPagination.loadingNext = false;
    }
}

// ===================== RENDER TEACHERS =====================
export function renderTeacherList(teachers) {
    const container = document.getElementById("teacherListContainer");
    if (!container) return console.warn("❌ #teacherListContainer not found");
    container.innerHTML = "";

    if (!Array.isArray(teachers) || teachers.length === 0) {
        container.innerHTML = `<p class="text-center w-100">Không tìm thấy giáo viên nào phù hợp.</p>`;
        updateTeacherConfirmButton();
        return;
    }

    teachers.forEach((teacher) => {
        const rating = parseFloat(teacher.rateForStudent ?? teacher.average_rating) || 5;
        const filledStars = Array(Math.floor(rating)).fill('<i class="fas fa-star text-warning"></i>').join("");
        const emptyStars = Array(5 - Math.floor(rating))
            .fill('<i class="far fa-star text-warning"></i>')
            .join("");
        const isSelected = selectedTeachers.some((t) => t.id === teacher.id);
        const checkedAttr = isSelected ? "checked" : "";
        const gender = teacher.gender === 1 ? "Nam" : "Nữ";
        const highlightClass = rating >= 5 ? "teacher-highlight" : "";
        console.log(teacher);

        container.insertAdjacentHTML(
            "beforeend",
            `<div class="col-md-6 mb-3">
                <div class="teacher-card ${isSelected ? "selected" : ""} ${highlightClass}" data-teacher-id="${
                teacher.id
            }">
                    <div class="teacher-avatar">
                        <img src="${teacher.avatar}" alt="Avatar">
                    </div>
                    <div class="teacher-info-wrapper">
                        <h3 class="teacher-info mb-1">${teacher.fullname || "N/A"}</h3>
                        <p class="teacher-detail mb-1">${gender}</p>
                        <div class="star-rating">${filledStars}${emptyStars} <small>(${rating.toFixed(1)})</small></div>
                    </div>
                    <div class="form-check ms-auto">
                        <input class="form-check-input teacher-checkbox" type="checkbox" value="${
                            teacher.id
                        }" ${checkedAttr}>
                        <label class="form-check-label"></label>
                    </div>
                </div>
            </div>`
        );
    });

    bindTeacherCardEvents();
    updateTeacherConfirmButton();
}

// ===================== BIND EVENTS =====================
function bindTeacherCardEvents() {
    const container = document.getElementById("teacherListContainer");
    if (!container) return;

    // Checkbox change
    container.querySelectorAll(".teacher-checkbox").forEach((cb) => {
        cb.onchange = (e) => {
            const id = parseInt(e.target.value);
            const card = e.target.closest(".teacher-card");
            const teacher = window.allFetchedTeachers?.find((t) => t.id === id);
            if (!teacher) return;

            if (e.target.checked) {
                if (!selectedTeachers.some((t) => t.id === id)) selectedTeachers.push(teacher);
                card.classList.add("selected");
            } else {
                const index = selectedTeachers.findIndex((t) => t.id === id);
                if (index > -1) selectedTeachers.splice(index, 1);
                card.classList.remove("selected");
            }
            updateTeacherConfirmButton();
        };
    });

    // Click card to toggle checkbox
    container.querySelectorAll(".teacher-card").forEach((card) => {
        card.onclick = (e) => {
            if (e.target.tagName !== "INPUT") {
                const cb = card.querySelector(".teacher-checkbox");
                cb.checked = !cb.checked;
                cb.dispatchEvent(new Event("change", { bubbles: true }));
            }
        };
    });
}

// ===================== CONFIRM BUTTON =====================
export function updateTeacherConfirmButton() {
    const btn = document.getElementById("teacherConfirmSelectionButton");
    if (!btn) return;

    btn.textContent = `Xác nhận chọn (${selectedTeachers.length})`;
    btn.disabled = selectedTeachers.length === 0;
}

// ===================== SEARCH & FILTER =====================
export function setupTeacherSearchFilter() {
    const searchInput = document.getElementById("teacherSearchInput");
    if (!searchInput) return;

    let timer;
    searchInput.addEventListener("input", () => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const keyword = searchInput.value.trim();
            loadTeacherPage(1, keyword);
        }, 300);
    });
}

// ===================== PAGINATION =====================
function renderTeacherPagination() {
    const container = document.getElementById("teacherPaginationContainer");
    if (!container) return;

    const { page, lastPage } = teacherPagination;
    container.innerHTML = "";

    const ul = document.createElement("ul");
    ul.className = "pagination justify-content-center flex-wrap mb-0";

    const start = Math.max(1, page - 2);
    const end = Math.min(lastPage, page + 2);

    if (page > 1) {
        const liPrev = document.createElement("li");
        liPrev.className = "page-item";
        liPrev.innerHTML = `<a class="page-link" href="#" data-page="${page - 1}">« Trước</a>`;
        ul.appendChild(liPrev);
    }

    for (let i = start; i <= end; i++) {
        const li = document.createElement("li");
        li.className = `page-item ${i === page ? "active" : ""}`;
        li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
        ul.appendChild(li);
    }

    if (page < lastPage) {
        const liNext = document.createElement("li");
        liNext.className = "page-item";
        liNext.innerHTML = `<a class="page-link" href="#" data-page="${page + 1}">Sau »</a>`;
        ul.appendChild(liNext);
    }

    container.appendChild(ul);

    // Click event
    ul.querySelectorAll("a[data-page]").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const targetPage = parseInt(link.dataset.page);
            if (!isNaN(targetPage)) loadTeacherPage(targetPage, teacherPagination.keyword);
        });
    });
}

// ===================== CONFIRM CLICK =====================
document.getElementById("teacherConfirmSelectionButton")?.addEventListener("click", async () => {
    if (!selectedTeachers.length) return ToastUtils.showError("Vui lòng chọn giáo viên.");
    try {
        await ModalUtils.switch("teacherSelectionModal", "timeSelectionModal");
        const selectedDate = window.selectedDate;
        if (selectedDate && selectedTeachers[0]?.id) {
            await window.loadTimeSlotsForTeacher?.(selectedTeachers[0].id, selectedDate);
        }
    } catch (err) {
        console.error(err);
        ToastUtils.showError("Không thể chuyển sang bước chọn thời gian.");
    }
});
