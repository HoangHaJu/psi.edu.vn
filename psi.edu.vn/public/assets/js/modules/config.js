const BASE_URL = "https://psi.edu.vn";

export const AppConfig = {
    apiEndpoints: {
        courses: `${BASE_URL}/bookings/api/courses`,
        courseModal: `${BASE_URL}/bookings/api/courses-modal`,
        teachers: `${BASE_URL}/bookings/api/teachers`,
        students: `${BASE_URL}/bookings/api/students`,

        adminRegister: `${BASE_URL}/bookings/admin-register`,
        studentRegister: `${BASE_URL}/bookings/student-register`,

        categories: `${BASE_URL}/bookings/api/courses/categories`,
        levels: `${BASE_URL}/bookings/api/courses/levels`,
        lessons: `${BASE_URL}/bookings/api/lessons`,
        teacherAvailableTimes: `${BASE_URL}/bookings/api/teachers/available-times`,
        typeTickets: `${BASE_URL}/bookings/api/type-tickets`,
        ticketOptions: `${BASE_URL}/bookings/api/students/{id}/ticket-options`,
    },

    // Pagination defaults
    pagination: {
        defaultPage: 1,
        defaultLimit: 10,
        maxVisiblePages: 5,
    },

    // UI Configuration
    ui: {
        dateRange: 7, // Số ngày hiển thị trong date picker
        maxTeachersPerPage: 20,
        maxStudentsPerPage: 50,
        debounceDelay: 300, // ms
    },

    // Time slot configuration
    timeSlots: {
        morning: { start: 0, end: 12 },
        afternoon: { start: 12, end: 18 },
        evening: { start: 18, end: 24 },
    },

    // Toast configuration
    toast: {
        duration: 5000,
        position: "top-end",
    },
};
