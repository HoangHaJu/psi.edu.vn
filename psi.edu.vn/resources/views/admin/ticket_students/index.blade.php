<div class="container py-3">
    <h1 class="text-center text-dark mb-2">Tổng quan về số lượng vé</h1>

    <!-- Vùng chọn loại vé -->
    <div class="row mb-5 justify-content-center">
        <div class="col-12 col-md-6">
            <label for="ticket-select" class="form-label text-dark fw-semibold mb-2">
                Chọn loại vé:
            </label>
            <select id="ticket-select" class="form-select">
                <option value="">Tất cả các loại vé</option>
                @foreach ($tickets->unique('type') as $ticket)
                    <option value="{{ $ticket->type }}">{{ $ticket->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Hiển thị các thẻ thống kê tổng quan -->
    <div class="row g-4 mb-5" id="ticketOverview">
        {{-- KPI cards sẽ được load bởi JavaScript --}}
    </div>

    <!-- Hiển thị chi tiết hết hạn -->
    <div class="row">
        <div class="col-12">
            <h2 class="text-dark fw-bold mb-4">Chi tiết hết hạn theo ngày</h2>
        </div>
        <div id="expiry-details-container" class="row g-3">
            <!-- ExpiryDateCards sẽ được populate bởi JavaScript -->
        </div>
    </div>
</div>

@push('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiUrl = "{{ route('admin.ticket_students.getFilteredTickets') }}";
            const ticketSelect = document.getElementById('ticket-select');
            const ticketOverview = document.getElementById('ticketOverview');
            const expiryDetailsContainer = document.getElementById('expiry-details-container');
            const DEFAULT_RESPONSE = {
                ticket_type: 'Không rõ',
                remaining_quantity: 0,
                soonest_expiring_date: 'Không xác định',
                expiryDetails: []
            };

            function showLoading() {
                if (ticketOverview) {
                    ticketOverview.innerHTML = `
                    <div class="col-12 text-center py-3">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Đang tải dữ liệu vé...</p>
                    </div>
                `;
                }
                if (expiryDetailsContainer) {
                    expiryDetailsContainer.innerHTML = '';
                }
            }

            async function fetchData(ticketType) {
                try {
                    const params = new URLSearchParams();
                    if (ticketType) params.append('ticket_type', ticketType);
                    const res = await fetch(`${apiUrl}?${params.toString()}`);
                    if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
                    const result = await res.json();
                    return result.data ?? DEFAULT_RESPONSE;
                } catch (e) {
                    console.error("Lỗi khi gọi API:", e);
                    return DEFAULT_RESPONSE;
                }
            }

            async function renderOverview(ticketType = '') {
                showLoading();
                const data = await fetchData(ticketType);

                if (ticketOverview) {
                    ticketOverview.innerHTML = `
                    <div class="col-md-6 col-12">
                        <div class="card p-3 text-center shadow-sm rounded-3 border-0 kpi-card">
                            <div class="card-body">
                                <i class="bi bi-ticket-perforated-fill fs-2 text-success mb-2"></i>
                                <h6 class="card-subtitle my-2 text-muted fs-5">Vé còn lại</h6>
                                <p class="card-text fs-4 fw-bold text-success">${data.remaining_quantity}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card p-3 text-center shadow-sm rounded-3 border-0 kpi-card">
                            <div class="card-body">
                                <i class="bi bi-hourglass-split fs-2 text-warning mb-2"></i>
                                <h6 class="card-subtitle my-2 text-muted fs-5">Hết hạn vào</h6>
                                <p class="card-text fs-4 fw-bold text-warning">${data.soonest_expiring_date}</p>
                            </div>
                        </div>
                    </div>
                `;
                }

                if (expiryDetailsContainer) {
                    expiryDetailsContainer.innerHTML = '';
                    if (data.expiryDetails.length > 0) {
                        data.expiryDetails.forEach(item => {
                            const cardHtml = `
                            <div class="col-12 col-md-6">
                                <div class="card p-3 shadow-sm d-flex flex-row align-items-center">
                                    <div class="text-warning me-3">
                                        <i class="bi bi-hourglass-split fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">${item.formatted_date}</div>
                                        <div class="text-sm text-secondary">${item.total_tickets} vé</div>
                                    </div>
                                </div>
                            </div>
                        `;
                            expiryDetailsContainer.insertAdjacentHTML('beforeend', cardHtml);
                        });
                    } else {
                        expiryDetailsContainer.innerHTML =
                            `<div class="col-12 text-center py-3"><p class="text-muted">Không có chi tiết hết hạn nào được tìm thấy.</p></div>`;
                    }
                }
            }

            ticketSelect.addEventListener('change', (event) => {
                renderOverview(event.target.value);
            });

            renderOverview();
        });
    </script>
@endpush

@push('libs-css')
    <style>
        .kpi-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@endpush
