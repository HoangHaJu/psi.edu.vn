<script>
    $(document).ready(function() {
        const lessonsFromBlade = @json($lessons);

        // Nhóm lessons theo ngày
        function groupByDate(arr) {
            return arr.reduce((acc, lesson) => {
                const date = (lesson.date || '').split('T')[0];
                acc[date] = acc[date] || [];
                acc[date].push(lesson);
                return acc;
            }, {});
        }

        // Render danh sách
        function renderLessons(grouped, selectedIds = []) {
            let html = '';

            Object.entries(grouped).forEach(([date, lessons]) => {
                html += `<div class="mb-4"><h4>${date}</h4><div class="row">`;

                lessons.forEach(lesson => {
                    const checked = selectedIds.includes(lesson.id) ? 'checked' : '';
                    html += `
                        <div class="col-md-3 d-flex align-items-center lesson-item" style="cursor:pointer;">
                            <input type="checkbox"
                                   name="lesson_id[]"
                                   value="${lesson.id}"
                                   class="form-check-input lesson-checkbox me-2"
                                   data-lesson-id="${lesson.id}"
                                   ${checked} />
                            <label class="form-check-label mb-0">${lesson.start_time}</label>
                        </div>`;
                });

                html += `</div></div>`;
            });

            $('#teacher-lessons-container').html(html);
            $('#selectAllLessonsBtn').text('Chọn tất cả');
            toggleCheckboxesBasedOnTeacher();
            bindCheckboxEvents();
        }

        const groupedInitial = groupByDate(lessonsFromBlade);
        renderLessons(groupedInitial, []);

        select2LoadData($('#user_id').data('url'), '#user_id');

        // Khi chọn giáo viên
        $('#user_id').on('select2:select', function(e) {
            const teacherId = e.params.data.id;
            const baseLessons = $(this).data('lessons-url');
            const fetchUrl = `${baseLessons}/${teacherId}/lessons`;

            $('input[name="teacher_id"]').val(teacherId);

            fetch(fetchUrl)
                .then(res => res.json())
                .then(groupedForTeacher => {
                    const assignedIds = [];
                    Object.values(groupedForTeacher).forEach(arr =>
                        arr.forEach(lesson => assignedIds.push(lesson.id))
                    );
                    renderLessons(groupedInitial, assignedIds);
                })
                .catch(err => console.error('Lỗi khi tải lessons:', err));
        });

        // Disable checkbox nếu chưa chọn giáo viên
        function toggleCheckboxesBasedOnTeacher() {
            const hasTeacher = $('#user_id').val();
            const checkboxes = $('input[name="lesson_id[]"]');
            const selectAllButton = $('#selectAllLessonsBtn');

            if (currentUser.isAdmin) {
                checkboxes.prop('disabled', !hasTeacher);
                selectAllButton.prop('disabled', !hasTeacher);
            } else {
                checkboxes.prop('disabled', false);
                selectAllButton.prop('disabled', false);
            }
        }

        // Gắn sự kiện click vào cả ô lesson
        function bindCheckboxEvents() {
            // Cảnh báo nếu chưa chọn giáo viên
            $('.lesson-item').on('click', function(e) {
                const checkbox = $(this).find('input.lesson-checkbox');
                const hasTeacher = $('#user_id').val();

                // Ngăn double toggle nếu click trực tiếp vào checkbox (tránh nhảy 2 lần)
                if ($(e.target).is('input')) return;

                if (currentUser.isAdmin && !hasTeacher) {
                    alert('Vui lòng chọn giáo viên trước khi chọn giờ học.');
                    e.preventDefault();
                    return;
                }

                if (!checkbox.prop('disabled')) {
                    checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                }
            });
        }

        // Nút "Chọn tất cả / Bỏ chọn tất cả"
        $('#selectAllLessonsBtn').on('click', function() {
            if ($(this).prop('disabled')) return;

            const checkboxes = $('input[name="lesson_id[]"]:not(:disabled)');
            const allChecked = checkboxes.length > 0 && checkboxes.filter(':checked').length ===
                checkboxes.length;

            if (allChecked) {
                checkboxes.prop('checked', false);
                $(this).text('Chọn tất cả');
            } else {
                checkboxes.prop('checked', true);
                $(this).text('Bỏ chọn tất cả');
            }
        });

        toggleCheckboxesBasedOnTeacher();
    });
</script>
