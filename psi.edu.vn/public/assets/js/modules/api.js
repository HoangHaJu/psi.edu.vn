// API Module - ES6
import { AppConfig } from "./config.js";
import { FilterUtils } from "./utils.js";
import {
    currentFilters,
    dataRegisterModal,
    currentPage,
    currentLimit,
    setPagination,
    setLoadingTimeSlots,
    setLoadingTeachers,
    setLoadingStudents,
} from "./state.js";

// Generic API request helper
async function apiRequest(url, options = {}) {
    const defaultOptions = {
        method: "GET",
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "",
            "Content-Type": "application/json",
        },
    };

    const response = await fetch(url, { ...defaultOptions, ...options });

    let responseData;
    try {
        responseData = await response.json();
    } catch {
        responseData = null;
    }

    if (!response.ok) {
        const message = responseData?.error || responseData?.message || response.statusText || "Unknown error";
        throw new Error(`${message}`);
    }

    return responseData;
}

// Courses API
export async function fetchCourses() {
    try {
        // Lọc các filter rỗng trước khi tạo query
        const cleanedFilters = {};
        for (const key in currentFilters) {
            const value = currentFilters[key];
            if (Array.isArray(value) && value.length > 0) cleanedFilters[key] = value;
            else if (typeof value === "string" && value.trim() !== "") cleanedFilters[key] = value;
            else if (typeof value === "number" && !isNaN(value)) cleanedFilters[key] = value;
        }

        const query = FilterUtils.getQueryParams(cleanedFilters, dataRegisterModal, currentPage, currentLimit);
        const response = await apiRequest(`${AppConfig.apiEndpoints.courses}?${query}`);

        const courses = response.data || [];
        const lastPage = response.last_page || 1;

        setPagination({ lastPage });
        return { courses, lastPage };
    } catch (error) {
        console.error("Error fetching courses:", error);
        throw error;
    }
}

// Teachers API
export async function fetchTeachers(date, courseId, teacherFilters = {}) {
    try {
        setLoadingTeachers(true);

        let queryParams = `date=${date}`;
        if (courseId) queryParams += `&course_id=${courseId}`;
        if (teacherFilters?.search) queryParams += `&search=${teacherFilters.search}`;
        if (teacherFilters?.gender) queryParams += `&gender=${teacherFilters.gender}`;
        if (teacherFilters?.rating) queryParams += `&rating=${teacherFilters.rating}`;

        const response = await apiRequest(`${AppConfig.apiEndpoints.teachers}?${queryParams}`);

        const teachers = Array.isArray(response.items)
            ? response.items
            : Array.isArray(response.data)
            ? response.data
            : Array.isArray(response)
            ? response
            : [];

        return teachers;
    } catch (error) {
        console.error("❌ Error fetching teachers:", error);
        return [];
    } finally {
        setLoadingTeachers(false);
    }
}

// Teacher Available Times API
export async function fetchTeacherAvailableTimes(teacherId, date) {
    try {
        setLoadingTimeSlots(true);

        const apiUrl = AppConfig.apiEndpoints.teacherAvailableTimes;

        const fullUrl = `${apiUrl}?teacher_id=${teacherId}&date=${date}`;

        const response = await apiRequest(fullUrl);

        const timeSlotsData = Array.isArray(response.data)
            ? response.data
            : Array.isArray(response.data?.data)
            ? response.data.data
            : [];

        return timeSlotsData.map((slot) => ({
            id: slot.id,
            start_time: slot.start_time,
            teacher_lesson_id: slot.teacher_lesson_id,
            course_id: slot.course_id,
            date: slot.date,
        }));
    } catch (error) {
        console.error("❌ Error fetching available times:", error);
        return [];
    } finally {
        setLoadingTimeSlots(false);
    }
}

// Students api
export async function fetchStudents(page = 1, searchTerm = "") {
    try {
        setLoadingStudents(true);

        const apiUrl = AppConfig.apiEndpoints.students;
        const params = new URLSearchParams();
        if (searchTerm) params.append("search", searchTerm);
        if (page) params.append("page", String(page));

        const url = apiUrl + (params.toString() ? `?${params.toString()}` : "");
        const response = await apiRequest(url);

        // Nếu API đã trả về dạng paginator (có field data)
        if (response && typeof response === "object" && Array.isArray(response.data)) {
            return response;
        }

        // Nếu API cũ trả về mảng, bọc thành paginator cơ bản
        const arr = Array.isArray(response) ? response : [];
        return {
            current_page: 1,
            data: arr,
            first_page_url: "",
            last_page: 1,
            last_page_url: "",
            next_page_url: null,
            path: apiUrl,
            per_page: arr.length,
            prev_page_url: null,
            to: arr.length,
            total: arr.length,
        };
    } catch (error) {
        console.error("Error fetching students:", error);
        ToastUtils?.showError?.("Không thể tải danh sách học viên.");
        return {
            current_page: 1,
            data: [],
            next_page_url: null,
            last_page: 1,
            per_page: 0,
            total: 0,
        };
    } finally {
        setLoadingStudents(false);
    }
}

// Categories API
export async function fetchCategories() {
    try {
        const response = await apiRequest(AppConfig.apiEndpoints.categories);
        return Array.isArray(response) ? response : [];
    } catch (error) {
        console.error("Error fetching categories:", error);
        return [];
    }
}

// Levels API
export async function fetchLevels() {
    try {
        const response = await apiRequest(AppConfig.apiEndpoints.levels);
        return Array.isArray(response) ? response : [];
    } catch (error) {
        console.error("Error fetching levels:", error);
        return [];
    }
}

// Lessons API
export async function fetchLessons(teacherId, date) {
    try {
        const queryParams = FilterUtils.getQueryParams(
            {
                ...currentFilters,
                teacher_id: teacherId,
                date: date,
            },
            dataRegisterModal,
            currentPage,
            currentLimit
        );

        const response = await apiRequest(`${AppConfig.apiEndpoints.lessons}?${queryParams}`);
        const lessons = Array.isArray(response.data) ? response.data : [];

        return lessons;
    } catch (error) {
        console.error("Error fetching lessons:", error);
        return [];
    }
}
// Type Tickets API
export async function fetchTypeTickets(studentId) {
    try {
        const queryParams = studentId ? `?student_id=${studentId}` : "";
        const response = await apiRequest(`${AppConfig.apiEndpoints.typeTickets}${queryParams}`);
        return Array.isArray(response.data) ? response.data : [];
    } catch (error) {
        console.error("Error fetching type tickets:", error);
        return [];
    }
}

// Bookings API
/**
 * Create bookings via API
 * @param {string} endpoint - API endpoint (adminRegister / studentRegister)
 * @param {Array} bookingsData - array of booking objects
 */
export async function createBookings(endpoint, bookingsData) {
    if (!endpoint) {
        throw new Error("API endpoint is required for createBookings");
    }

    try {
        const response = await apiRequest(endpoint, {
            method: "POST",
            body: JSON.stringify(bookingsData),
        });

        return response;
    } catch (error) {
        console.error("Error creating bookings:", error);
        throw error;
    }
}

// Course Modal API
export async function fetchCoursesModal({ search = "", categoryIds = [], page = 1, perPage = 20 } = {}) {
    try {
        // Chuẩn hóa query
        const params = new URLSearchParams();

        if (search.trim() !== "") params.append("search", search);
        if (page) params.append("page", String(page));
        if (perPage) params.append("per_page", String(perPage));

        // Nếu lọc nhiều danh mục
        if (Array.isArray(categoryIds) && categoryIds.length > 0) {
            categoryIds.forEach((id) => params.append("category_ids[]", id));
        }
        // Hoặc 1 danh mục duy nhất
        else if (typeof categoryIds === "number") {
            params.append("category_id", categoryIds);
        }

        const response = await apiRequest(`${AppConfig.apiEndpoints.courseModal}?${params.toString()}`);

        const courses = Array.isArray(response.data) ? response.data : [];
        const lastPage = response.last_page ?? 1;

        return { courses, lastPage };
    } catch (error) {
        console.error("❌ Error fetching courses for modal:", error);
        return { courses: [], lastPage: 1 };
    }
}

/**
 * Lấy danh sách vé khả dụng + vé học sinh đã có
 * @param {number} studentId
 * @returns {Promise<{all_types: Array, owned: Array}>}
 */
export async function fetchStudentTicketOptions(studentId) {
    if (!studentId) throw new Error("Missing studentId");

    const id = parseInt(studentId, 10); // đảm bảo int
    const url = AppConfig.apiEndpoints.ticketOptions.replace("{id}", id);

    return await apiRequest(url, { method: "GET" });
}

// Helper function to fetch and display students (for backward compatibility)
export async function fetchAndDisplayStudents(searchTerm = "") {
    return await fetchStudents(searchTerm);
}
