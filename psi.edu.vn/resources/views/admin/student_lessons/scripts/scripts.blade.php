<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('button[title]');
        buttons.forEach(btn => new bootstrap.Tooltip(btn));
        document.querySelectorAll('.btnCancelLesson').forEach(button => {
            button.addEventListener('click', function(e) {

                e.preventDefault();
                const lessonId = this.dataset.id;
                const form = document.querySelector(`#cancelLessonForm-${lessonId}`);

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn hoàn vé không?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hoàn vé',
                    cancelButtonText: 'Không',
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
