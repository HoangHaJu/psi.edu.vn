<a href="{{ route('admin.student_lesson.jitsi', 'room_' . $teacher_lesson['lesson']['id']) }}" class="join-class"
    target="_blank" data-is-teacher="{{ auth()->user()->hasRole('teacher') ? '1' : '0' }}"
    data-lesson-id="{{ $teacher_lesson['lesson']['id'] }}">
    Vào lớp học
</a>

<script>
    function trackJoinClass(linkSelector) {
        $(linkSelector).each(function() {
            const $joinLink = $(this);
            const isTeacher = $joinLink.data("isTeacher") === 1 || $joinLink.data("isTeacher") === '1';
            const lessonId = $joinLink.data("lessonId");
            const roleKey = isTeacher ? 'teacher' : 'student';
            const localStorageKey = `joined_class_${roleKey}_${lessonId}`;

            $joinLink.on("click", function() {
                console.log(`${isTeacher ? 'Giáo viên' : 'Học viên'} đã nhấp vào nút vào lớp`);

                if (!localStorage.getItem(localStorageKey)) {
                    const now = new Date();
                    now.setHours(now.getHours() + 7); // UTC+7 cho VN
                    const joinedAt = now.toISOString();

                    const url = isTeacher ?
                        "{{ route('admin.teacher_lesson.trackJoinClass') }}" :
                        "{{ route('admin.student_lesson.trackJoinClass') }}";

                    const body = isTeacher ? {
                        lesson_id: lessonId,
                        teacher_joined_at: joinedAt
                    } : {
                        lesson_id: lessonId,
                        student_joined_at: joinedAt // ✅ gửi student_joined_at
                    };

                    fetch(url, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify(body)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Tracking thành công:", data.message);
                            // ✅ Lưu vào localStorage
                            localStorage.setItem(localStorageKey, joinedAt);
                        })
                        .catch(error => {
                            console.error("Lỗi khi tracking:", error);
                        });
                } else {
                    console.log(`Đã tracking ${roleKey} cho lớp này trước đó`);
                }
            });
        });
    }

    $(document).ready(function() {
        trackJoinClass(".join-class");
    });
</script>
