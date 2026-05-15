// renderTimeSlots.js
// Time Slots Render Module - ES6
import {
    selectedTeachers,
    selectedTimeSlots,
    addSelectedTimeSlot,
    removeSelectedTimeSlot,
    setLoadingTimeSlots,
} from "../state.js";
import { AppConfig } from "../config.js";
import { DateUtils } from "../utils.js";

/**
 * Render time slots for teacher selection
 * @param {Array} timeSlots - Array of available time slots
 * @param {number} currentTeacherId - ID of the current teacher
 */
export function renderTimeSlots(timeSlots, currentTeacherId) {
    const container = document.getElementById("timeSlotsContentWrapper");
    if (!container) {
        console.error("Time slots container not found");
        return;
    }

    container.innerHTML = "";

    // Find selected teacher
    const selectedTeacherInModal = selectedTeachers.find((t) => t.id === currentTeacherId);
    if (!selectedTeacherInModal) {
        container.innerHTML = '<p class="text-center text-danger">Không tìm thấy thông tin giáo viên được chọn.</p>';
        document.getElementById("confirmTimeSelectionButton").disabled = true;
        return;
    }

    // Validate time slots data
    if (!Array.isArray(timeSlots)) {
        container.insertAdjacentHTML(
            "beforeend",
            '<p class="text-center text-danger">Đã xảy ra lỗi khi tải thời gian trống (dữ liệu không phải mảng).</p>'
        );
        document.getElementById("confirmTimeSelectionButton").disabled = true;
        return;
    }

    if (timeSlots.length === 0) {
        container.insertAdjacentHTML(
            "beforeend",
            '<p class="text-center w-100">Không có khung giờ trống cho giáo viên này vào ngày đã chọn.</p>'
        );
        document.getElementById("confirmTimeSelectionButton").disabled = true;
        return;
    }

    // Group time slots by time period
    const { morningSlots, afternoonSlots, eveningSlots } = groupTimeSlotsByPeriod(timeSlots);

    // Render each time period
    container.insertAdjacentHTML(
        "beforeend",
        createTimeSlotSection("Buổi Sáng", morningSlots, currentTeacherId, selectedTimeSlots)
    );
    container.insertAdjacentHTML(
        "beforeend",
        createTimeSlotSection("Buổi Chiều", afternoonSlots, currentTeacherId, selectedTimeSlots)
    );
    container.insertAdjacentHTML(
        "beforeend",
        createTimeSlotSection("Buổi Tối", eveningSlots, currentTeacherId, selectedTimeSlots)
    );

    // Update confirm button state
    const confirmButton = document.getElementById("confirmTimeSelectionButton");
    if (confirmButton) {
        confirmButton.disabled = selectedTimeSlots.length === 0;
    }

    // Add event listeners for time slot selection
    addTimeSlotEventListeners(container, currentTeacherId);
}

/**
 * Group time slots by time period (morning, afternoon, evening)
 * @param {Array} timeSlots - Array of time slots
 * @returns {Object} Grouped time slots
 */
function groupTimeSlotsByPeriod(timeSlots) {
    const morningSlots = [];
    const afternoonSlots = [];
    const eveningSlots = [];

    timeSlots.forEach((slot) => {
        if (slot.start_time) {
            const hour = parseInt(slot.start_time.substring(0, 2));
            const config = AppConfig.timeSlots;

            if (hour >= config.morning.start && hour < config.morning.end) {
                morningSlots.push(slot);
            } else if (hour >= config.afternoon.start && hour < config.afternoon.end) {
                afternoonSlots.push(slot);
            } else if (hour >= config.evening.start && hour < config.evening.end) {
                eveningSlots.push(slot);
            }
        }
    });

    return { morningSlots, afternoonSlots, eveningSlots };
}

/**
 * Create HTML for a time slot section
 * @param {string} title - Section title
 * @param {Array} slots - Array of time slots for this section
 * @param {number} currentTeacherId - Current teacher ID
 * @param {Array} selectedTimeSlots - Currently selected time slots
 * @returns {string} HTML string
 */
function createTimeSlotSection(title, slots, currentTeacherId, selectedTimeSlots) {
    if (slots.length === 0) {
        return "";
    }

    let slotsHtml = "";
    slots.forEach((slot) => {
        const displayedStartTime = DateUtils.formatTime(slot.start_time);
        const isSelected = selectedTimeSlots.some((s) => s.teacher_lesson_id === slot.teacher_lesson_id);

        slotsHtml += `
            <button type="button" class="btn btn-outline-primary time-slot-btn mb-2 me-2 ${isSelected ? "active" : ""}"
                    data-start="${slot.start_time || ""}"
                    data-teacher-id="${currentTeacherId}"
                    data-lesson-id="${slot.id || ""}"
                    data-teacher-lesson-id="${slot.teacher_lesson_id || ""}">
                ${displayedStartTime}
            </button>
        `;
    });

    return `
        <div class="time-slot-group mb-4">
            <h5 class="time-group-title">${title}</h5>
            <div class="time-slots-grid d-flex flex-wrap">
                ${slotsHtml}
            </div>
        </div>
    `;
}

/**
 * Add event listeners for time slot buttons
 * @param {HTMLElement} container - Container element
 * @param {number} currentTeacherId - Current teacher ID
 */
function addTimeSlotEventListeners(container, currentTeacherId) {
    container.addEventListener("click", function (event) {
        const btn = event.target.closest(".time-slot-btn");
        if (!btn) return;

        const teacherLessonId = parseInt(btn.dataset.teacherLessonId);
        const teacherId = parseInt(btn.dataset.teacherId);
        const lessonId = parseInt(btn.dataset.lessonId);
        const startTime = btn.dataset.start;

        const existingIndex = selectedTimeSlots.findIndex((s) => s.teacher_lesson_id === teacherLessonId);

        if (existingIndex > -1) {
            // Remove from selection
            selectedTimeSlots.splice(existingIndex, 1);
            btn.classList.remove("active");
        } else {
            // Add to selection
            const newSlot = {
                course_id: null, // Will be set when course is selected
                teacher_id: teacherId,
                lesson_id: lessonId,
                teacher_lesson_id: teacherLessonId,
                start_time: startTime,
            };

            selectedTimeSlots.push(newSlot);
            btn.classList.add("active");
        }

        // Update confirm button state
        const confirmButton = document.getElementById("confirmTimeSelectionButton");
        if (confirmButton) {
            confirmButton.disabled = selectedTimeSlots.length === 0;
        }
    });
}

/**
 * Clear all selected time slots
 */
export function clearSelectedTimeSlots() {
    selectedTimeSlots.length = 0;

    // Remove active class from all time slot buttons
    document.querySelectorAll(".time-slot-btn.active").forEach((btn) => {
        btn.classList.remove("active");
    });

    // Update confirm button
    const confirmButton = document.getElementById("confirmTimeSelectionButton");
    if (confirmButton) {
        confirmButton.disabled = true;
    }
}

/**
 * Get selected time slots count
 * @returns {number} Number of selected time slots
 */
export function getSelectedTimeSlotsCount() {
    return selectedTimeSlots.length;
}

/**
 * Check if a time slot is selected
 * @param {number} teacherLessonId - Teacher lesson ID
 * @returns {boolean} True if selected
 */
export function isTimeSlotSelected(teacherLessonId) {
    return selectedTimeSlots.some((s) => s.teacher_lesson_id === teacherLessonId);
}

/**
 * Update time slots with course information
 * @param {number} courseId - Course ID
 */
export function updateTimeSlotsWithCourse(courseId) {
    selectedTimeSlots.forEach((slot) => {
        slot.course_id = courseId;
    });
}
