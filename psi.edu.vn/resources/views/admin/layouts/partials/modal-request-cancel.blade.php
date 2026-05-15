<!-- Modal -->
<div class="modal fade" id="modalCancel" tabindex="-1" aria-labelledby="modalCancelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body justify-content-center">
                <x-form :action="route('admin.booking.createWithTeacherLesson')" type="post" class="mb-3">
                    <h3 class="bold-text text-center">Xin chuyển ngày học</h3>
                    <div class="p-2">
                        <label class="control-label text-left"><i class="ti ti-calendar"></i>
                            {{ __('Ngày học bù') }}:
                            <span class="text-danger">*</span></label>
                        <x-input type="date" name="date" :required="true" placeholder="{{ __('Ngày học bù') }}" />
                        <label class="control-label text-left mt-3"><i class="ti ti-clock"></i>
                            {{ __('Giờ học bù') }}:
                            <span class="text-danger">*</span></label>
                        <x-input type="time" name="start_time" :required="true" placeholder="{{ __('Giờ học bù') }}" />
                        <x-input type="hidden" id="course_id" name="course_id" :required="true" />
                        <x-input type="hidden" id="student_lesson_id" name="student_lesson_id" :required="true" />
                        <x-input type="hidden" name="end_time" id="end_time" />
                        <x-input type="hidden" name="period" value="60" />
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-default text-center">Gửi yêu cầu</button></div>
                </x-form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalCancel');
    modal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const courseId = button.getAttribute('data-course-id');
        const studentLessonId = button.getAttribute('data-id');
        const inputCourseId = document.getElementById('course_id');
        const inputStudentLessonId = document.getElementById('student_lesson_id');
        inputCourseId.value = courseId;
        inputStudentLessonId.value = studentLessonId;
    });

    const form = document.querySelector('#modalCancel form');
    form.addEventListener('submit', function(event) {
        const startTimeInput = form.querySelector('input[name="start_time"]');
        const endTimeInput = form.querySelector('input[name="end_time"]');
        const courseIdInput = form.querySelector('input[name="course_id"]');
        const startTime = startTimeInput.value;
        const courseId = document.getElementById('course_id').value;

        if (startTime) {
            endTimeInput.value = startTime;
        }

        if (courseId) {
            courseIdInput.value = courseId;
        }
    });
});
</script>
