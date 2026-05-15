<script>
    document.querySelectorAll('.time-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.closest('label');
            if (this.checked) {
                // Thêm lớp btn-primary khi checkbox được chọn
                label.classList.add('btn-primary');
                label.classList.remove('btn-default');
            } else {
                // Loại bỏ lớp btn-primary và quay lại btn-outline-primary khi checkbox bị bỏ chọn
                label.classList.remove('btn-primary');
                label.classList.add('btn-default');
            }
        });
    });
</script>
