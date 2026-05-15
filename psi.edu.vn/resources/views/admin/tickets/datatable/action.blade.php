<div class="d-flex justify-content-between">
    <a href="{{ route('admin.ticket.edit', $id) }}"><x-button type="button" class="btn-info btn-icon">
            Sửa
        </x-button></a>
    <x-button.modal-delete class="btn-icon" data-route="{{ route('admin.ticket.delete', $id) }}">
        Xóa
    </x-button.modal-delete>
</div>
