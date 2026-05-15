import { fetchStudents, fetchTeachers, fetchLessons } from "./api.js";
import { dataRegisterModal, currentFilters } from "./state.js";
import { debounce } from "./utils.js";

/** ---------- STUDENT SEARCH ---------- */
export function setupStudentSearch() {
    const input = document.getElementById("offcanvasStudentSearchInput");
    const list = document.getElementById("offcanvasStudentSearchList");
    if (!input || !list) return;

    const debouncedSearch = debounce(async (kw) => {
        try {
            const students = await fetchStudents(kw);
            window.allFetchedStudents = students;
            renderStudentDropdown(students, kw);
        } catch (err) {
            console.error("Error fetching students:", err);
            renderStudentDropdown([], kw);
        }
    }, 300);

    input.addEventListener("input", (e) => {
        const kw = e.target.value.trim();
        if (kw.length) debouncedSearch(kw);
        else renderStudentDropdown(window.allFetchedStudents || []);
    });

    input.addEventListener("focus", () => {
        const kw = input.value.trim();
        renderStudentDropdown(
            (window.allFetchedStudents || []).filter(
                (s) =>
                    s.fullname.toLowerCase().includes(kw.toLowerCase()) ||
                    s.email.toLowerCase().includes(kw.toLowerCase())
            )
        );
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".custom-select-wrapper") && !e.target.closest("#offcanvasStudentSearchList")) {
            list.style.display = "none";
        }
    });
}

function renderStudentDropdown(students, keyword = "") {
    const list = document.getElementById("offcanvasStudentSearchList");
    list.innerHTML = "";
    list.style.display = "none";

    if (!students || students.length === 0) {
        if (keyword) {
            const li = document.createElement("li");
            li.textContent = "Không tìm thấy học viên.";
            li.classList.add("dropdown-item");
            li.style.cursor = "default";
            list.appendChild(li);
            list.style.display = "block";
        }
        return;
    }

    students.forEach((s) => {
        const li = document.createElement("li");
        li.textContent = s.fullname;
        li.dataset.id = s.id;
        li.classList.add("dropdown-item");
        li.addEventListener("click", () => {
            dataRegisterModal.studentId = s.id;
            currentFilters.student_id = s.id;
            document.getElementById("offcanvasStudentSearchInput").value = s.fullname;
            list.style.display = "none";
        });
        list.appendChild(li);
    });

    list.style.display = "block";
}

/** ---------- TEACHER SEARCH ---------- */
export function setupTeacherSearch() {
    const input = document.getElementById("offcanvasTeacherSearchInput");
    const list = document.getElementById("offcanvasTeacherSearchList");
    if (!input || !list) return;

    const debouncedSearch = debounce((kw) => {
        const teachers = window.allFetchedTeachers || [];
        const filtered = teachers.filter((t) => t.fullname.toLowerCase().includes(kw.toLowerCase()));
        renderTeacherDropdown(filtered);
    }, 300);

    input.addEventListener("input", (e) => {
        const kw = e.target.value.trim();
        if (kw.length) debouncedSearch(kw);
        else renderTeacherDropdown(window.allFetchedTeachers || []);
    });

    input.addEventListener("focus", () => {
        const kw = input.value.trim();
        renderTeacherDropdown(
            (window.allFetchedTeachers || []).filter((t) => t.fullname.toLowerCase().includes(kw.toLowerCase()))
        );
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".custom-select-wrapper")) list.style.display = "none";
    });
}

function renderTeacherDropdown(teachers) {
    const list = document.getElementById("offcanvasTeacherSearchList");
    list.innerHTML = "";
    list.style.opacity = 0;
    list.style.display = "block";

    if (!teachers || teachers.length === 0) {
        const li = document.createElement("li");
        li.textContent = "Không có giáo viên.";
        li.classList.add("dropdown-item", "text-muted");
        li.style.cursor = "default";
        list.appendChild(li);
        fadeIn(list);
        return;
    }

    teachers.forEach((t) => {
        const li = document.createElement("li");
        li.textContent = t.fullname;
        li.dataset.id = t.id;
        li.classList.add("dropdown-item");
        li.addEventListener("click", () => handleTeacherSelection(t));
        list.appendChild(li);
    });

    fadeIn(list);
}

async function handleTeacherSelection(teacher) {
    const input = document.getElementById("offcanvasTeacherSearchInput");
    const lessonContainer = document.getElementById("lessonFilterTags");
    if (input) input.value = teacher.fullname;

    currentFilters.teacher_id = teacher.id;
    dataRegisterModal.teachers = [teacher];
    dataRegisterModal.timeSlots = [];

    if (lessonContainer) {
        lessonContainer.innerHTML = '<p class="text-muted">Đang tải buổi học...</p>';
        lessonContainer.style.opacity = 0;
    }

    try {
        const lessons = await fetchLessons(teacher.id, currentFilters.date);
        window.allFetchedLessons = lessons;
        renderLessons(lessons);
        fadeIn(lessonContainer);
    } catch (err) {
        console.error("Error fetching lessons:", err);
        if (lessonContainer) lessonContainer.innerHTML = '<p class="text-danger">Không thể tải buổi học.</p>';
        fadeIn(lessonContainer);
    }
}

/** ---------- LESSON RENDER & TOGGLE ---------- */
function renderLessons(lessons) {
    const container = document.getElementById("lessonFilterTags");
    container.innerHTML = "";

    if (!lessons || lessons.length === 0) {
        container.innerHTML = "<p>Không có buổi học khả dụng.</p>";
        return;
    }

    lessons.forEach((lesson) => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = `btn btn-outline-lesson btn-sm m-1 lesson-tag`;
        btn.dataset.lessonId = lesson.teacher_lesson_id;
        btn.textContent = lesson.start_time?.substring(0, 5) || "N/A";
        btn.addEventListener("click", () => toggleLessonSelection(lesson, btn));
        container.appendChild(btn);
    });
}

function toggleLessonSelection(lesson, button) {
    const idx = dataRegisterModal.timeSlots.findIndex((ts) => ts.teacher_lesson_id === lesson.teacher_lesson_id);
    if (idx > -1) {
        dataRegisterModal.timeSlots.splice(idx, 1);
        button.classList.remove("active");
    } else {
        dataRegisterModal.timeSlots.push({ lesson, teacher_lesson_id: lesson.teacher_lesson_id });
        button.classList.add("active");
    }
}

/** ---------- LOAD DATA ---------- */
async function loadTeachersForDate(date) {
    const list = document.getElementById("offcanvasTeacherSearchList");
    if (list) {
        list.innerHTML = '<li class="dropdown-item text-muted">Đang tải giáo viên...</li>';
        list.style.display = "block";
        list.style.opacity = 0;
    }

    try {
        const teachers = await fetchTeachers(date);
        window.allFetchedTeachers = teachers;
        renderTeacherDropdown(teachers);
    } catch (err) {
        console.error("Error loading teachers:", err);
        renderTeacherDropdown([]);
    }
}

async function loadStudents() {
    try {
        const students = await fetchStudents();
        window.allFetchedStudents = students;
    } catch (err) {
        console.error("Error loading students:", err);
        window.allFetchedStudents = [];
    }
}

/** ---------- OFFCANVAS INIT ---------- */
export function setupOffcanvas() {
    setupStudentSearch();


    const offcanvasElement = document.getElementById("filterOffcanvas");
    if (offcanvasElement) {
        offcanvasElement.addEventListener("show.bs.offcanvas", async () => {
            try {
                await loadStudents();

                setupDateFilter();
            } catch (err) {
                console.error("❌ Error loading offcanvas data:", err);
            }
        });
    }
}

/** ---------- DATE FILTER ---------- */
function setupDateFilter() {
    const input = document.getElementById("filterDate");
    if (!input) return;

    if (currentFilters.date) input.value = currentFilters.date;

    input.addEventListener("change", async (e) => {
        const newDate = e.target.value;
        currentFilters.date = newDate;
        dataRegisterModal.date = newDate;

        // Reset selections
        currentFilters.teacher_id = null;
        currentFilters.lessons = [];
        dataRegisterModal.teachers = [];
        dataRegisterModal.timeSlots = [];

        document.getElementById("offcanvasTeacherSearchInput").value = "";
        const lessonContainer = document.getElementById("lessonFilterTags");
        if (lessonContainer) {
            lessonContainer.style.opacity = 0;
            lessonContainer.innerHTML = "<p>Vui lòng chọn Giáo viên.</p>";
        }

        await loadTeachersForDate(newDate);

        if (lessonContainer) fadeIn(lessonContainer);
    });
}

/** ---------- UTILS ---------- */
function fadeIn(el, duration = 300) {
    el.style.transition = `opacity ${duration}ms ease`;
    requestAnimationFrame(() => {
        el.style.opacity = 1;
    });
}
