<!-- Modal -->
<div class="modal fade" id="requestDayOff" tabindex="-1" aria-labelledby="requestDayOffLabel" aria-hidden="true">
				<div class="modal-dialog">
								<div class="modal-content">
												<div class="modal-body justify-content-center">
																<x-form :action="route('admin.schedule_off.store')" type="post" class="mb-3">
																				<h3 class="bold-text text-center">{{ __('Xin nghỉ') }}</h3>
																				<div class="p-2">
																								<label class="control-label text-left"><i class="ti ti-file-alert"></i>
																												{{ __('Lý do xin nghỉ') }}:
																												<span class="text-danger">*</span></label>
																								<x-input name="reason" :required="true" placeholder="{{ __('Lý do xin nghỉ') }}" />
																								<x-input type="hidden" id="studentLessonId" name="student_lesson_id" :required="true" />
																								<x-input type="hidden" name="admin_id" :value="auth('admin')->user()->id" :required="true" />
																				</div>
																				<div class="text-center"><button type="submit" class="btn btn-default text-center">Gửi yêu
																												cầu</button>
																				</div>
																</x-form>
												</div>
								</div>
				</div>
</div>

<script>
				document.addEventListener('DOMContentLoaded', function() {
								// Lắng nghe sự kiện khi modal hiển thị
								const modal = document.getElementById('requestDayOff');
								modal.addEventListener('show.bs.modal', function(event) {
												// Lấy nút được nhấn để mở modal
												const button = event.relatedTarget;

												// Lấy giá trị data-id từ nút
												const lessonId = button.getAttribute('data-id');

												// Tìm input trong modal và gán giá trị
												const inputLessonId = document.getElementById('studentLessonId');
												inputLessonId.value = lessonId;
								});
				});
</script>
