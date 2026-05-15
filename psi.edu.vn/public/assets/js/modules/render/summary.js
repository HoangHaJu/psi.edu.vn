import { selectedCourse, selectedTimeSlots, selectedTeachers, getSelectedDate, dataRegisterModal } from "../state.js";

export function renderFinalSummary() {
    const course = selectedCourse || dataRegisterModal.course;
    const date = getSelectedDate() || dataRegisterModal.date;
    const teachers = selectedTeachers.length ? selectedTeachers : dataRegisterModal.teachers;
    const timeSlots = selectedTimeSlots.length ? selectedTimeSlots : dataRegisterModal.timeSlots;

    if (!course || !date || timeSlots.length === 0) {
        console.warn("Không đủ dữ liệu để hiển thị summary", { course, date, timeSlots, teachers });
        return;
    }

    document.getElementById("summaryCourseTitle").textContent = `${course.name}`;
    document.getElementById("summaryCourseCategory").textContent = course.category;

    const d = new Date(date);
    document.getElementById("summarySelectedDate").textContent = `Học vào ${new Intl.DateTimeFormat("vi-VN", {
        weekday: "long",
    }).format(d)} ngày ${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;

    const container = document.getElementById("summaryTeacherList");
    container.innerHTML = "";

    timeSlots.forEach((slot, index) => {
        const teacher = teachers.find((t) => t.id === slot.teacher_id);
        if (!teacher) {
            console.warn(`Không tìm thấy teacher với id ${slot.teacher_id}. Sử dụng teacher đầu tiên làm fallback.`);
        }
        const finalTeacher = teacher ||
            teachers[0] || { fullname: "Giáo viên không xác định", avatar: "https://via.placeholder.com/100x100" };

        container.insertAdjacentHTML(
            "beforeend",
            `
        <div class="col-12 mb-3">
            <div class="card teacher-summary-card">
                <div class="card-body d-flex align-items-center">
                    <img src="${finalTeacher.avatar}" class="rounded-circle me-3" width="50" height="50" alt="Avatar">
                    <div>
                        <h3>${finalTeacher.fullname}</h3>
                        <h4 class="mb-0 text-muted">${slot.start_time?.substring(0, 5) || "N/A"}</h4>
                    </div>
                </div>
            </div>`
        );
    });

    document.getElementById("finalConfirmBtn").disabled = timeSlots.length === 0;
}
