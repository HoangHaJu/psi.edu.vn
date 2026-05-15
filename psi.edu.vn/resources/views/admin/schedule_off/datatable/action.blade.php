<div class="d-flex align-items-center justify-content-center">
    @if (auth('admin')->user()->isSuperAdmin)
        <a href="{{ route('admin.schedule_off.edit', $id) }}" class="ms-2">
            Sửa
        </a>
    @endif
    <x-button.modal-delete class="btn-icon ms-2" data-route="{{ route('admin.schedule_off.delete', $id) }}">
        Xóa
    </x-button.modal-delete>
</div>
