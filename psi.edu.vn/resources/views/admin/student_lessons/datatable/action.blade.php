@php
    $user = auth('admin')->user();
    $isSpecial = $ticket_type === 'special';
@endphp

<div class="d-flex align-items-center justify-content-center">
    {{-- Nút "Học bù" cho học viên --}}
    @if (!$isSpecial && $day_off_type == 3 && $status == 1 && !$user->isSuperAdmin)
        <button id="btnModalRequestDayOff" data-id="{{ $id }}" data-bs-toggle="modal"
            data-bs-target="#requestDayOff" type="button" class="btn btn-default ms-2 text-center"
            title="Khi học viên nhấn nút này, thì sẽ không được hoàn vé và được sắp xếp học bù với giáo viên đó">
            Xin nghỉ
        </button>
    @endif

    {{-- Nút "Học bù" cho Super Admin --}}
    @if (!$isSpecial && $day_off_type == 1 && $user->isSuperAdmin)
        <button id="btnModalCancel" data-id="{{ $id }}" data-course-id="{{ $courseIds[$id] ?? '' }}"
            data-bs-toggle="modal" data-bs-target="#modalCancel" type="button" class="btn btn-default ms-2 text-center"
            title="Khi admin nhấn nút này, sẽ thực hiện sắp xếp lịch học bù.">
            Xin nghỉ
        </button>
    @endif

    {{-- Nút "Hoàn vé" cho học viên --}}
    @if (!$isSpecial && $user->isStudent && $status == 1)
        <form id="cancelLessonForm-{{ $id }}"
            action="{{ route('admin.student_lesson.refund', ['id' => $id]) }}" method="post">
            @csrf
            <button class="btnCancelLesson btn btn-danger ms-2 text-center" type="button" data-id="{{ $id }}"
                title="Khi học viên nhấn nút này, thì sẽ được hoàn vé, không học bù và buổi tiếp theo là buổi học theo lịch học đăng ký trước đó.">
                Hoàn vé
            </button>
        </form>
    @endif
</div>
<script>
    $(document).ready(function() {
        // Kích hoạt tooltip
        $('[title]').each(function() {
            new bootstrap.Tooltip(this);
        });

        // SweetAlert xác nhận hoàn vé
        $(document).on('click', '.btnCancelLesson', function(e) {
            e.preventDefault();

            const lessonId = $(this).data('id');
            const form = $('#cancelLessonForm-' + lessonId);

            Swal.fire({
                title: 'Bạn có chắc chắn muốn hoàn vé không?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hoàn vé',
                cancelButtonText: 'Không',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
