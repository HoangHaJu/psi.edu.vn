import { setSelectedStudent } from "../state.js";

export function renderStudentList(students, currentSelected, allStudents) {
    const container = document.getElementById("studentListContainer");
    container.innerHTML = "";

    if (!students || students.length === 0) {
        container.innerHTML = '<p class="text-center w-100">Không tìm thấy học viên phù hợp.</p>';
        updateStudentConfirmButton(null);
        return;
    }

    students.forEach((student) => {
        const isSelected = currentSelected && currentSelected.id === student.id;
        const checkedAttr = isSelected ? "checked" : "";

        // Nếu student.avatar null thì dùng ảnh mặc định
        const avatarUrl = student.avatar
            ? student.avatar.replace(/^\/?public\//, "/storage/")
            : "/assets/images/default-avatar.png";

        container.insertAdjacentHTML(
            "beforeend",
            `
            <div class="col-md-6 mb-3">
                <div class="student-card ${isSelected ? "selected" : ""}" data-student-id="${student.id}">
                    <img src="${avatarUrl}" 
                        alt="Avatar" 
                        class="rounded-circle me-3" 
                        style="width: 60px; height: 60px; object-fit: cover;">
                    <p>${student.fullname || "N/A"}</p>
                    <div class="form-check ms-auto">
                        <input class="form-check-input student-radio" 
                               type="radio" 
                               name="student" 
                               value="${student.id}" ${checkedAttr}>
                        <label class="form-check-label"></label>
                    </div>
                </div>
            </div>`
        );
    });

    // gán sự kiện cho từng card
    container.querySelectorAll(".student-card").forEach((card) => {
        const radio = card.querySelector(".student-radio");

        radio.addEventListener("change", (e) => {
            handleStudentSelect(card, allStudents, e.target.value);
        });

        card.addEventListener("click", (e) => {
            if (e.target.tagName !== "INPUT") {
                radio.checked = true;
                radio.dispatchEvent(new Event("change", { bubbles: true }));
            }
        });
    });

    updateStudentConfirmButton(currentSelected);

    function handleStudentSelect(card, allStudents, studentId) {
        const id = parseInt(studentId);
        const student = allStudents.find((s) => s.id === id);

        if (student) {
            setSelectedStudent(student);
            container.querySelectorAll(".student-card").forEach((c) => c.classList.remove("selected"));
            card.classList.add("selected");
            updateStudentConfirmButton(student);
        }
    }
}

export function updateStudentConfirmButton(student) {
    const btn = document.getElementById("studentConfirmSelectionButton");
    if (btn) {
        btn.textContent = "Xác nhận chọn";
        btn.disabled = !student;
    }
}
