// renderDates.js
import { currentFilters, setSelectedDate } from "../state.js";

export function renderDates() {
    const container = document.getElementById("dateCardsContainer");
    container.innerHTML = "";
    const today = new Date();
    let initialSelectedDate = currentFilters.date || null;
    const btn = document.getElementById("confirmDateAndShowTeacherModal");

    for (let i = 0; i < 7; i++) {
        const date = new Date(today);
        date.setDate(today.getDate() + i);
        const fullDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(
            date.getDate()
        ).padStart(2, "0")}`;
        const isActive = initialSelectedDate === fullDate ? "active" : "";
        container.insertAdjacentHTML(
            "beforeend",
            `
            <div class="col-md-4 mb-3 justify-content-center">
                <div class="card date-card ${isActive}" data-date="${fullDate}">
                    <div class="card-body text-center">
                        <h5 class="card-title m-0">${new Intl.DateTimeFormat("vi-VN", { weekday: "long" }).format(
                            date
                        )}</h5>
                        <p class="card-text">${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}</p>
                    </div>
                </div>
            </div>`
        );
    }

    if (!initialSelectedDate) btn.disabled = true;
    else btn.disabled = false;

    container.querySelectorAll(".date-card").forEach((card) => {
        card.addEventListener("click", () => {
            container.querySelectorAll(".date-card").forEach((c) => c.classList.remove("active"));
            card.classList.add("active");
            setSelectedDate(card.dataset.date);
            currentFilters.date = card.dataset.date;
            btn.disabled = false;
        });
    });
}
