import { setSelectedTicket, clearSelectedTicket, getSelectedTicket } from "../state.js";
import { formatValueAsLabel } from "../utils.js";

export function renderTicketTypes(allTypes, ownedTickets = []) {
    const container = document.getElementById("ticketTypeContainer");
    if (!container) return;
    container.innerHTML = "";

    clearSelectedTicket();

    allTypes.forEach((type) => {
        const displayLabel = formatValueAsLabel(type);
        const owned = ownedTickets.find((o) => o.type === type);
        const isOwned = !!owned;

        const card = document.createElement("div");
        card.className = "card";

        const input = document.createElement("input");
        input.type = "radio";
        input.name = "ticketType";
        input.className = "d-none";
        input.value = owned ? owned.id : type;
        input.dataset.label = displayLabel;
        input.dataset.description = "";
        input.dataset.type = type;

        const cardBody = document.createElement("div");
        cardBody.className = "card-body";
        cardBody.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">${displayLabel}${isOwned ? " (Đã sở hữu)" : ""}</h5>
                <i class="fas fa-check-circle" style="display: none;"></i>
            </div>
            <p class="card-text"></p>
        `;

        input.addEventListener("change", (e) => {
            setSelectedTicket({
                value: e.target.value,
                label: e.target.dataset.label,
                description: e.target.dataset.description,
                type: e.target.dataset.type,
            });

            container.querySelectorAll(".card").forEach((c) => c.classList.remove("selected"));
            container.querySelectorAll(".fa-check-circle").forEach((icon) => (icon.style.display = "none"));

            const cardEl = e.target.closest(".card");
            cardEl.classList.add("selected");
            cardEl.querySelector(".fa-check-circle").style.display = "inline-block";

            updateTicketConfirmButton();
        });

        card.addEventListener("click", () => {
            input.checked = true;
            input.dispatchEvent(new Event("change"));
        });

        card.appendChild(input);
        card.appendChild(cardBody);
        container.appendChild(card);
    });

    updateTicketConfirmButton();
}

export function updateTicketConfirmButton() {
    const btn = document.getElementById("ticketConfirmSelectionButton");
    if (btn) {
        const ticket = getSelectedTicket();
        btn.textContent = "Xác nhận chọn";
        btn.disabled = !ticket;
    }
}
