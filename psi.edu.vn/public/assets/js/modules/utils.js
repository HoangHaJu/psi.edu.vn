// Utils Module - ES6
import { AppConfig } from "./config.js";
import { currentFilters, dataRegisterModal, currentPage, currentLimit, setStudent, clearStudent } from "./state.js";

// Toast Utilities
export const ToastUtils = {
    showSuccess(message) {
        const el = document.getElementById("successToast");
        if (!el) return;
        const toastBody = el.querySelector(".toast-body");
        if (toastBody) toastBody.textContent = message;
        new bootstrap.Toast(el).show();
    },

    showError(message) {
        const el = document.getElementById("errorToast");
        if (!el) return;
        const toastBody = el.querySelector(".toast-body");
        if (toastBody) toastBody.textContent = message;
        new bootstrap.Toast(el).show();
    },

    showInfo(message) {
        // Create a simple info toast if needed
        console.info(message);
    },
};

// Convenience named exports for backward compatibility
export function showSuccessToast(message) {
    ToastUtils.showSuccess(message);
}

export function showErrorToast(message) {
    ToastUtils.showError(message);
}

// Modal Utilities
/** ---------- MODAL UTILS ---------- */
export class ModalUtils {
    /**
     * Mở modal (và tự động đóng tất cả modal khác nếu đang mở)
     * @param {string} id - ID của modal
     * @returns {bootstrap.Modal|null}
     */
    static open(id) {
        const el = document.getElementById(id);
        if (!el) {
            console.warn(`[ModalUtils] Không tìm thấy modal: ${id}`);
            return null;
        }

        // Ẩn tất cả modal khác đang hiển thị
        document.querySelectorAll(".modal.show").forEach((m) => {
            const instance = bootstrap.Modal.getInstance(m);
            if (instance) instance.hide();
        });

        const modal = bootstrap.Modal.getOrCreateInstance(el);
        modal.show();
        return modal;
    }

    static close(id) {
        const el = document.getElementById(id);
        if (!el) return;

        const modal = bootstrap.Modal.getInstance(el);
        if (modal) modal.hide();
    }

    static async switch(fromId, toId) {
        const fromEl = document.getElementById(fromId);
        const toEl = document.getElementById(toId);

        if (!fromEl || !toEl) {
            console.warn(`[ModalUtils] switch: Không tìm thấy ${fromId} hoặc ${toId}`);
            return;
        }

        const fromModal = bootstrap.Modal.getOrCreateInstance(fromEl);
        const toModal = bootstrap.Modal.getOrCreateInstance(toEl);

        return new Promise((resolve) => {
            const onHidden = () => {
                fromEl.removeEventListener("hidden.bs.modal", onHidden);
                toModal.show();
                resolve();
            };

            if (fromEl.classList.contains("show")) {
                fromEl.addEventListener("hidden.bs.modal", onHidden, { once: true });
                fromModal.hide();
            } else {
                toModal.show();
                resolve();
            }
        });
    }

    static isOpen(id) {
        const el = document.getElementById(id);
        return el ? el.classList.contains("show") : false;
    }

    static attachOnce(selector, event, handler) {
        const element = document.querySelector(selector);
        if (!element) return;
        element.removeEventListener(event, handler);
        element.addEventListener(event, handler);
    }
}

// Filter Utilities
export const FilterUtils = {
    createTag(text, value, type) {
        const tag = document.createElement("span");
        tag.className = "badge bg-primary me-1 mb-1";
        tag.dataset.value = value;
        tag.dataset.type = type;
        tag.innerHTML = `${text} <i class="fas fa-times ms-1" style="cursor: pointer;"></i>`;

        // Add click handler for remove
        tag.addEventListener("click", (e) => {
            if (e.target.classList.contains("fa-times")) {
                this.remove(value, type);
            }
        });

        return tag;
    },

    addTag(text, value, type, container) {
        if (!container) return;

        const existing = container.querySelector(`[data-value="${value}"][data-type="${type}"]`);
        if (existing) return;

        // Add to filters
        switch (type) {
            case "category":
                if (!currentFilters.category_ids.includes(value)) {
                    currentFilters.category_ids.push(value);
                }
                break;
            case "level":
                if (!currentFilters.levels.includes(value)) {
                    currentFilters.levels.push(value);
                }
                break;
            case "gender":
                if (!currentFilters.genders.includes(value)) {
                    currentFilters.genders.push(value);
                }
                break;
            case "rating":
                if (!currentFilters.ratings.includes(value)) {
                    currentFilters.ratings.push(value);
                }
                break;
        }

        container.appendChild(this.createTag(text, value, type));
    },

    remove(value, type) {
        const container = document.getElementById(`${type}FilterTags`);
        if (container) {
            const tag = container.querySelector(`[data-value="${value}"][data-type="${type}"]`);
            if (tag) tag.remove();
        }

        // Remove from filters
        switch (type) {
            case "category":
                currentFilters.category_ids = currentFilters.category_ids.filter((id) => id !== value);
                break;
            case "level":
                currentFilters.levels = currentFilters.levels.filter((l) => l !== value);
                break;
            case "gender":
                currentFilters.genders = currentFilters.genders.filter((g) => g !== value);
                break;
            case "rating":
                currentFilters.ratings = currentFilters.ratings.filter((r) => r !== value);
                break;
            case "teacher":
                currentFilters.teacher_id = null;
                currentFilters.lessons = [];
                if (dataRegisterModal) {
                    dataRegisterModal.teachers = [];
                    dataRegisterModal.timeSlots = [];
                }
                // Clear teacher input
                const teacherInput = document.getElementById("offcanvasTeacherSearchInput");
                if (teacherInput) teacherInput.value = "";
                break;
            case "lesson":
                currentFilters.lessons = currentFilters.lessons.filter((l) => l !== value);
                if (dataRegisterModal) {
                    dataRegisterModal.timeSlots = dataRegisterModal.timeSlots.filter(
                        (ts) => String(ts.teacher_lesson_id) !== String(value)
                    );
                }
                // Remove active class from lesson button
                const lessonButton = document.querySelector(`button[data-lesson-id="${value}"]`);
                if (lessonButton) lessonButton.classList.remove("active");
                break;
            case "date":
                currentFilters.date = null;
                if (dataRegisterModal) {
                    dataRegisterModal.date = null;
                    dataRegisterModal.teachers = [];
                    dataRegisterModal.timeSlots = [];
                }
                // Clear date input
                const dateInput = document.getElementById("filterDate");
                if (dateInput) dateInput.value = "";
                break;
            case "student":
                clearStudent();
                const studentInput = document.getElementById("offcanvasStudentSearchInput");
                if (studentInput) studentInput.value = "";
                break;
        }
    },

    clearAll() {
        // Clear UI tags
        ["category", "level", "gender", "rating", "teacher", "lesson", "date", "student"].forEach((type) => {
            const container = document.getElementById(`${type}FilterTags`);
            if (container) container.innerHTML = "";
        });

        // Reset filters
        Object.assign(currentFilters, {
            search: "",
            category_ids: [],
            levels: [],
            genders: [],
            ratings: [],
            date: null,
            teacher_id: null,
            lessons: [],
            student_id: null,
        });

        // Reset modal data
        if (dataRegisterModal) {
            dataRegisterModal.date = null;
            dataRegisterModal.teachers = [];
            dataRegisterModal.timeSlots = [];
            dataRegisterModal.studentId = null;
            dataRegisterModal.studentName = null;
        }

        // Clear inputs
        const inputs = [
            "mainCourseSearchInput",
            "offcanvasTeacherSearchInput",
            "offcanvasStudentSearchInput",
            "filterDate",
        ];

        inputs.forEach((id) => {
            const input = document.getElementById(id);
            if (input) input.value = "";
        });
    },

    getQueryParams(filters, dataRegisterModal, currentPage, currentLimit) {
        const params = new URLSearchParams();

        // Search
        if (filters.search && filters.search.trim() !== "") {
            params.append("search", filters.search.trim());
        }

        // Categories
        if (Array.isArray(filters.category_ids) && filters.category_ids.length > 0) {
            filters.category_ids.forEach((id) => {
                if (id != null && id !== "") params.append("categories[]", id);
            });
        }

        // Levels
        if (Array.isArray(filters.levels) && filters.levels.length > 0) {
            filters.levels.forEach((level) => {
                if (level != null && level !== "") params.append("levels[]", level);
            });
        }

        // Genders
        if (Array.isArray(filters.genders) && filters.genders.length > 0) {
            filters.genders.forEach((g) => {
                if (g != null && g !== "") params.append("teacherGender[]", g);
            });
        }

        // Ratings
        if (Array.isArray(filters.ratings) && filters.ratings.length > 0) {
            filters.ratings.forEach((r) => {
                if (r != null && r !== "") params.append("teacherRating[]", r);
            });
        }

        // Date
        if (filters.date) {
            params.append("date", filters.date);
        }

        // Teacher ID
        if (filters.teacher_id !== undefined && filters.teacher_id !== null) {
            params.append("teacher_id", filters.teacher_id);
        }

        // Student ID
        if (filters.student_id !== undefined && filters.student_id !== null) {
            params.append("student_id", filters.student_id);
        }

        // Lessons
        if (Array.isArray(dataRegisterModal.timeSlots) && dataRegisterModal.timeSlots.length > 0) {
            const lessonIds = dataRegisterModal.timeSlots
                .map((ts) => ts.teacher_lesson_id)
                .filter((id) => id != null && id !== "")
                .join(",");
            if (lessonIds) {
                params.append("lessonId", lessonIds);
            }
        }

        // Pagination
        if (typeof currentLimit !== "undefined") {
            params.append("limit", currentLimit);
        }
        if (typeof currentPage !== "undefined") {
            params.append("page", currentPage);
        }

        return params.toString();
    },
};

// Student Dropdown Utilities
export function renderStudentDropdown(students, showDropdown = false) {
    const listEl = document.getElementById("offcanvasStudentSearchList");
    if (!listEl) return;

    listEl.innerHTML = "";
    listEl.style.display = "none";

    if (!Array.isArray(students) || students.length === 0) {
        if (showDropdown) {
            const li = document.createElement("li");
            li.textContent = "Không tìm thấy học viên nào.";
            li.classList.add("dropdown-item");
            li.style.cursor = "default";
            listEl.appendChild(li);
            listEl.style.display = "block";
        }
        return;
    }

    students.forEach((student) => {
        const li = document.createElement("li");
        li.textContent = `${student.fullname}`;
        li.setAttribute("data-id", student.id);
        li.classList.add("dropdown-item");
        li.style.cursor = "pointer";

        li.addEventListener("click", () => {
            const input = document.getElementById("offcanvasStudentSearchInput");
            if (input) {
                input.value = `${student.fullname}`;
                setStudent(student);
            }
            listEl.style.display = "none";
        });

        listEl.appendChild(li);
    });

    if (showDropdown) listEl.style.display = "block";
}

// Loading State Utilities
export function toggleLoadingState(isLoading) {
    const finalConfirmBtn = document.getElementById("finalConfirmBtn");
    if (!finalConfirmBtn) return;

    const buttonText = finalConfirmBtn.querySelector(".button-text");
    const loadingText = finalConfirmBtn.querySelector(".loading-text");
    const spinner = finalConfirmBtn.querySelector(".spinner-border");

    if (isLoading) {
        finalConfirmBtn.disabled = true;
        if (buttonText) buttonText.style.display = "none";
        if (loadingText) loadingText.style.display = "inline";
        if (spinner) spinner.style.display = "inline-block";
    } else {
        finalConfirmBtn.disabled = false;
        if (buttonText) buttonText.style.display = "inline";
        if (loadingText) loadingText.style.display = "none";
        if (spinner) spinner.style.display = "none";
    }
}

// Debounce utility
export function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Date utilities
export const DateUtils = {
    formatDate(date, options = {}) {
        const defaultOptions = {
            weekday: "long",
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
        };
        return new Intl.DateTimeFormat("vi-VN", { ...defaultOptions, ...options }).format(date);
    },

    formatTime(timeString) {
        if (!timeString) return "N/A";
        return timeString.substring(0, 5);
    },

    getNextDays(count = AppConfig.ui.dateRange) {
        const days = [];
        const today = new Date();

        for (let i = 0; i < count; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);
            days.push(date);
        }

        return days;
    },
};

// Validation utilities
export const ValidationUtils = {
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },

    isValidPhone(phone) {
        const phoneRegex = /^[0-9]{10,11}$/;
        return phoneRegex.test(phone.replace(/\s/g, ""));
    },

    isRequired(value) {
        return value !== null && value !== undefined && value.toString().trim() !== "";
    },
};

export function formatValueAsLabel(str) {
    if (!str) return "";
    return str
        .replace(/[-_]/g, " ")
        .split(" ")
        .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
        .join(" ");
}
