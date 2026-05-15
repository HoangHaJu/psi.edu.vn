// renderCourses.js

/**
 * Render danh sách khóa học
 * @param {Array} courses - danh sách course
 * @param {Function} addRegisterButtonListeners - callback gắn sự kiện register
 * @param {Number} currentPage - trang hiện tại
 * @param {Number} totalPages - tổng số trang
 * @param {Function} fetchCourses - hàm fetch courses
 */
export function renderCourses(courses, addRegisterButtonListeners, currentPage, totalPages, fetchCourses) {
    const container = document.getElementById("courseListContainer");
    container.innerHTML = "";

    if (!Array.isArray(courses) || courses.length === 0) {
        container.innerHTML = '<p class="text-center w-100">Không tìm thấy khóa học nào.</p>';
        return;
    }

    courses.forEach((course) => {
        // Chỉ hiển thị nút với student
        const showRegisterBtn = window.currentUserRole === "student";

        container.insertAdjacentHTML(
            "beforeend",
            `
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <div class="card h-100 overflow-hidden course-card-booking"
                  data-course-id="${course.id}"
                  data-course-title="${course.name}"
                  data-course-category="${course.categories?.map((c) => c.name).join(", ") || "N/A"}"
                  data-course-level="${course.education_level || "N/A"}">
                <div class="course-card-image p-3 d-flex align-items-center justify-content-center bg-light">
                  ${
                      course.avatar
                          ? `<img src="${course.avatar}" class="img-fluid rounded" alt="Course Image">`
                          : `<i class="fas fa-book-open fa-4x text-muted"></i>`
                  }
                </div>
                <div class="card-body d-flex flex-column px-2">
                  <h5 class="card-title pb-2 text-primary fw-bold mb-2">${course.name}</h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                    ${
                        course.education_level
                            ? `<span class="badge bg-info text-white text-uppercase me-1 py-1 px-2">Cấp độ ${course.education_level}</span>`
                            : ""
                    }
                    ${
                        course.categories?.length
                            ? `<span class="badge bg-secondary text-white text-uppercase py-1 px-2">Danh mục ${course.categories
                                  .map((cat) => cat.name)
                                  .join(", ")}</span>`
                            : ""
                    }
                  </h6>
                  ${course.description || "Không có mô tả chi tiết cho khóa học này."}
                </div>
                ${
                    showRegisterBtn
                        ? `<div class="card-footer bg-white border-top-0 pt-0">
                              <button class="btn btn-primary-booking btn-lg w-100 register-course-btn" data-course-id="${course.id}">
                                  <i class="fas fa-sign-in-alt me-2"></i> Đăng ký ngay
                              </button>
                           </div>`
                        : ""
                }
              </div>
            </div>`
        );
    });

    // Gắn sự kiện cho các nút chỉ tồn tại nếu student
    if (window.currentUserRole === "student") {
        addRegisterButtonListeners();
    }
}

/**
 * Render phân trang
 * @param {Number} currentPage
 * @param {Number} totalPages
 * @param {Function} fetchCourses
 */
export function renderPagination(currentPage, totalPages, fetchCourses) {
    const paginationUl = document.getElementById("coursePagination");
    paginationUl.innerHTML = "";
    if (totalPages <= 1) return;

    const prevLi = document.createElement("li");
    prevLi.className = `page-item ${currentPage === 1 ? "disabled" : ""}`;
    prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Trước</a>`;
    paginationUl.appendChild(prevLi);

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    if (endPage - startPage < 4) {
        if (startPage === 1) endPage = Math.min(totalPages, startPage + 4);
        else if (endPage === totalPages) startPage = Math.max(1, endPage - 4);
    }

    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement("li");
        li.className = `page-item ${i === currentPage ? "active" : ""}`;
        li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
        paginationUl.appendChild(li);
    }

    const nextLi = document.createElement("li");
    nextLi.className = `page-item ${currentPage === totalPages ? "disabled" : ""}`;
    nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Tiếp</a>`;
    paginationUl.appendChild(nextLi);

    paginationUl.querySelectorAll(".page-link").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const newPage = parseInt(e.target.dataset.page);
            if (newPage > 0 && newPage <= totalPages && newPage !== currentPage) {
                fetchCourses(newPage);
            }
        });
    });
}
