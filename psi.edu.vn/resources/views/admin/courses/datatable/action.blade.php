@if (auth()->user()->isSuperAdmin)
    <div class="d-flex align-items-center justify-content-center">
        <a class="btn btn-primary" href="{{ route('admin.lesson.create', $id) }}">
            Thêm buổi học
        </a>
        <x-button.modal-delete class="btn-icon ms-2" data-route="{{ route('admin.course.delete', $id) }}">
            Xóa
        </x-button.modal-delete>
    </div>
@else
    <div class="d-flex align-items-center justify-content-center">
        <a href="{{ route('admin.course.registerLessons', $id) }}">
            <i class="btn btn-info btn-icon ti ti-pencil"></i>
        </a>
    </div>
@endif
