<script>
    function showDetailTicketModal(ticket_id) {
        if (ticket_id) {
            // console.log('{{ route('admin.transaction.render') }}' + `/${ticket_id}`);
            $.ajax({
                type: "GET",
                url: '{{ route('admin.transaction.render') }}' + `/${ticket_id}`,
                success: function(response) {
                    // Cập nhật nội dung modal
                    $("#resultQuickViewRequest").html(response);
                    // Hiển thị modal sau khi nội dung đã được cập nhật
                    $('#registerTicketModal').modal('show');


                    $('.modal-dialog').css('display', 'flex');
                    $('.modal-content').css('margin', '5% auto');
                },
                error: function(response) {
                    handleAjaxError(response);
                }
            });
        }
        // setTimeout(() => {
        //     $('#registerTicketModal').css('display', 'flex');
        // }, 750);
    }

    $(document).on('click', '#create-transaction', function(e) {
        e.preventDefault();
        var url = $(this).data('url');

        const ticketQuantity = $('input[name="quantity"]').val();

        if (!ticketQuantity || ticketQuantity <= 0) {
            Swal.fire({
                title: "Vui lòng nhập số lượng vé.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        Swal.fire({
            title: "Bạn có chắc chắn mua gói vé này?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#1c5639",
            cancelButtonColor: "#d33",
            confirmButtonText: "Chắc chắn!",
            cancelButtonText: "Quay lại!"
        }).then((result) => {
            if (result.isConfirmed) {
                // window.location.href = url;
                const form = $('<form>', {
                    method: 'POST',
                    action: url
                });

                // Thêm CSRF token
                const csrfToken = $('meta[name="X-TOKEN"]').attr('content');
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: csrfToken
                }));

                const ticketId = $('input[name="ticket_id"]').val();
                const userId = $('input[name="user_id"]').val();
                const ticketQuantity = $('input[name="quantity"]').val();
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'ticket_id',
                    value: ticketId
                }));
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'user_id',
                    value: userId
                }));
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'quantity',
                    value: ticketQuantity
                }));

                $('body').append(form);
                form.submit();
            }
        });
    });

    $(document).on('click', '#confirm-transaction', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        Swal.fire({
            title: "Bạn có chắc chắn duyệt đơn này?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#1c5639",
            cancelButtonColor: "#d33",
            confirmButtonText: "Chắc chắn!",
            cancelButtonText: "Quay lại!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    $(document).on('click', '#cancel-transaction', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        Swal.fire({
            title: "Bạn có chắc chắn muốn huỷ?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#1c5639",
            cancelButtonColor: "#d33",
            confirmButtonText: "Chắc chắn!",
            cancelButtonText: "Quay lại!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
</script>
