/**
 * Tạo pagination component dùng chung
 * @param {HTMLElement|string} container - element hoặc selector chứa pagination
 * @param {Object} options
 * @param {number} options.page - trang hiện tại
 * @param {number} options.lastPage - tổng số trang
 * @param {(page:number)=>void} options.onChange - callback khi click nút
 */
export function createPagination(container, { page = 1, lastPage = 1, onChange = () => {} }) {
    const el = typeof container === "string" ? document.querySelector(container) : container;
    if (!el) return console.error("[Pagination] Container not found:", container);

    el.innerHTML = renderPaginationHTML(page, lastPage);

    // Gắn sự kiện click
    el.querySelectorAll(".pagination-btn").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const newPage = parseInt(btn.dataset.page, 10);
            if (!isNaN(newPage) && newPage !== page) onChange(newPage);
        });
    });
}

/**
 * Render HTML pagination
 */
function renderPaginationHTML(page, lastPage) {
    if (lastPage <= 1) return ""; // Không cần hiển thị nếu chỉ 1 trang

    let html = `<nav class="d-inline-block"><ul class="pagination pagination-sm mb-0">`;

    // Previous
    html += `
        <li class="page-item ${page === 1 ? "disabled" : ""}">
            <button class="page-link pagination-btn" data-page="${page - 1}" aria-label="Previous">
                &laquo;
            </button>
        </li>`;

    // Pages
    const maxButtons = 5;
    let start = Math.max(1, page - Math.floor(maxButtons / 2));
    let end = Math.min(lastPage, start + maxButtons - 1);
    if (end - start < maxButtons - 1) start = Math.max(1, end - maxButtons + 1);

    for (let i = start; i <= end; i++) {
        html += `
        <li class="page-item ${i === page ? "active" : ""}">
            <button class="page-link pagination-btn" data-page="${i}">${i}</button>
        </li>`;
    }

    // Next
    html += `
        <li class="page-item ${page === lastPage ? "disabled" : ""}">
            <button class="page-link pagination-btn" data-page="${page + 1}" aria-label="Next">
                &raquo;
            </button>
        </li>`;

    html += `</ul></nav>`;
    return html;
}
