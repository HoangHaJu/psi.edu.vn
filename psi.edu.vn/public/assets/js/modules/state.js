// Global application state (ES6 module)
import { AppConfig } from "./config.js";
// Pagination state
export let currentPage = AppConfig.pagination.defaultPage;
export let currentLimit = AppConfig.pagination.defaultLimit;
export let totalPages = 1;

// Data arrays
export let coursesData = [];
export let modalCoursesData = [];
export let filteredCourses = [];
export let allTeachers = [];
export let allFetchedTeachers = [];
export let allFetchedStudents = [];
export let allFetchedLessons = [];
export let allFetchedModalCourses = [];
export let bookingsData = [];

// Selection state
export let selectedCourseModal = null;
export let selectedCourse = null;
export let selectedDate = null;
export let selectedTeachers = [];
export let selectedTimeSlots = [];
export let timeSlotsToRegister = [];
export let selectedStudent = null;
export let allStudents = [];
export let selectedTicket = null;
export let selectedCourseSingle = null;
// Modal data
export let dataRegisterModal = {
    course: null,
    date: null,
    timeSlots: [],
    teachers: [],
    studentId: null,
    studentName: null,
};

export let dataRegisterByAdmin = {
    course: null,
    date: null,
    timeSlots: [],
    teachers: [],
    studentId: null,
    studentName: null,
    ticketId: null,
};

// Filter state
export const currentFilters = {
    search: "",
    category_ids: [],
    levels: [],
    genders: [],
    ratings: [],
    date: "",
    teacher_id: null,
    lessons: [],
    student_id: null,
};

// Search lists for dropdowns
export let teacherSearchList = [];
export let studentSearchList = [];

// Loading states
export let isLoadingTimeSlots = false;
export let isLoadingTeachers = false;
export let isLoadingStudents = false;

// Helper functions for pagination
export function setPagination({ page, limit, lastPage }) {
    if (typeof page === "number") currentPage = page;
    if (typeof limit === "number") currentLimit = limit;
    if (typeof lastPage === "number") totalPages = lastPage;
}

export function resetPagination() {
    currentPage = AppConfig.pagination.defaultPage;
    currentLimit = AppConfig.pagination.defaultLimit;
    totalPages = 1;
}

// Reset all selections
export function resetSelections() {
    selectedCourse = null;
    selectedDate = null;
    selectedTeachers = [];
    selectedTimeSlots = [];
    timeSlotsToRegister = [];

    dataRegisterModal = {
        course: null,
        date: null,
        timeSlots: [],
        teachers: [],
        studentId: null,
        studentName: null,
    };
}

// Reset all filters
export function resetFilters() {
    Object.assign(currentFilters, {
        search: "",
        category_ids: [],
        levels: [],
        genders: [],
        ratings: [],
        date: "",
        teacher_id: null,
        lessons: [],
        student_id: null,
    });
}

// Reset all data
export function resetAllData() {
    coursesData = [];
    filteredCourses = [];
    allTeachers = [];
    allFetchedTeachers = [];
    allFetchedStudents = [];
    allFetchedLessons = [];
    bookingsData = [];
    teacherSearchList = [];
    studentSearchList = [];

    resetSelections();
    resetFilters();
    resetPagination();
}

// Setters/Getters for cross-module updates
export function setSelectedDate(value) {
    selectedDate = value;
    currentFilters.date = value;
    dataRegisterModal.date = value;
}

export function getSelectedDate() {
    return selectedDate;
}

export function setSelectedCourse(course) {
    selectedCourse = course;
    dataRegisterModal.course = course;
}

export function getSelectedCourse() {
    return selectedCourse;
}

export function addSelectedTeacher(teacher) {
    if (!selectedTeachers.some((t) => t.id === teacher.id)) {
        selectedTeachers.push(teacher);
        dataRegisterModal.teachers = [...selectedTeachers];
    }
}

export function removeSelectedTeacher(teacherId) {
    selectedTeachers = selectedTeachers.filter((t) => t.id !== teacherId);
    dataRegisterModal.teachers = [...selectedTeachers];
}

export function addSelectedTimeSlot(slot) {
    if (!selectedTimeSlots.some((s) => s.teacher_lesson_id === slot.teacher_lesson_id)) {
        selectedTimeSlots.push(slot);
    }
}

export function removeSelectedTimeSlot(teacherLessonId) {
    selectedTimeSlots = selectedTimeSlots.filter((s) => s.teacher_lesson_id !== teacherLessonId);
}

export function setStudent(student) {
    dataRegisterModal.studentId = student.id;
    dataRegisterModal.studentName = student.fullname;
    currentFilters.student_id = student.id;
}

export function setAllStudents(students) {
    allStudents = students;
}

export function setSelectedStudent(student) {
    selectedStudent = student;
}
export function clearStudent() {
    dataRegisterModal.studentId = null;
    dataRegisterModal.studentName = null;
    currentFilters.student_id = null;
}

// Loading state helpers
export function setLoadingTimeSlots(loading) {
    isLoadingTimeSlots = loading;
}

export function setLoadingTeachers(loading) {
    isLoadingTeachers = loading;
}

export function setLoadingStudents(loading) {
    isLoadingStudents = loading;
}

// Data getters
export function getTeacherNameById(teacherId) {
    const teacher = allFetchedTeachers.find((t) => String(t.id) === String(teacherId));
    return teacher ? teacher.fullname : "Tất cả giáo viên";
}

export function getStudentNameById(studentId) {
    const student = allFetchedStudents.find((s) => String(s.id) === String(studentId));
    return student ? student.fullname : "Chưa chọn học viên";
}
//  ---- Modal Ticket ---- //
export function getSelectedTicket() {
    return selectedTicket;
}

export function setSelectedTicket(ticket) {
    selectedTicket = ticket;
}

export function clearSelectedTicket() {
    selectedTicket = null;
}
// ---- Modal Course ---- //
export function setSelectedCourseSingle(course) {
    selectedCourseSingle = course;
    if (course && !allFetchedModalCourses.some((c) => c.id === course.id)) {
        allFetchedModalCourses.push(course);
    }
}

export function getSelectedCourseSingle() {
    return selectedCourseSingle;
}
// Setter / Getter riêng cho modal
export function setSelectedCourseModal(course) {
    selectedCourseModal = course;
}

export function getSelectedCourseModal() {
    return selectedCourseModal;
}
export function clearSelectedCourseSingle() {
    selectedCourseSingle = null;
    dataRegisterModal.course = null;
}
