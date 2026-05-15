@if (isset($ticketModal))
    <div class="modal fade h-60" id="registerTicketModal" tabindex="-1" aria-labelledby="registerTicketModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" :action="route('admin.transaction.store')">
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-4 d-flex text-center">
                            <div class="mb-3">
                                <img class="img-circle d-block mx-auto"
                                    src="{{ asset('/public/assets/images/avatar-user.png') }}" alt="">
                            </div>
                            <input type="text" name="ticket_id" value="{{ $ticketModal->id }}" hidden>
                            <input type="text" name="user_id" value="{{ auth()->id() }}" hidden>
                            <div class="ms-3 mt-3">
                                <h3 class="default-color">{{ $ticketModal->name }}</h3>
                                <h4 class="badge bg-success">
                                    {{ format_price($ticketModal->price) }}</h4>
                                <h4 class="default-color">Số vé: <span class="text-primary">{{ $ticketModal->quantity }}
                                        vé</span></h4>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h3><strong>Tổng tiền: </strong><span
                                    class="fw-normal">{{ format_price($ticketModal->price) }}</span>
                            </h3>
                            <h3><strong>Thời hạn sử dụng: </strong><span class="fw-normal">{{ $ticketModal->during }}
                                    ngày</span></h3>
                            <input type="number" name="quantity" id="ticket-quantity" class="form-control"
                                value="{{ $ticketModal->quantity }}" placeholder="Nhập số lượng vé" hidden>
                        </div>

                        <div class="col-md-4 text-end">
                            <button type="submit" class="btn btn-default" id="create-transaction"
                                data-url="{{ route('admin.transaction.store') }}">Confirm</button>
                            <button type="button" class="btn bg-white">Cancel</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<script>
    $(document).ready(function() {
        $(".btn.bg-white").on("click", function() {
            $('#registerTicketModal').modal('hide');
        });
    });
</script>
