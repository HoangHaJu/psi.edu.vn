<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Thông tin đơn xin nghỉ') }}</h2>
								</div>
								<div class="card-body row">
												<div class="mb-3">
             <label class="control-label"><i class="ti ti-book-2"></i> {{ __('Tên buổi học') }}:
              @if ($schedule_off->lesson)
               <x-link :href="route('admin.lesson.edit', $schedule_off->lesson->id)" :title="$schedule_off->lesson->name" />
              @else
               {{ __('No lesson available') }}
              @endif
             </label><br>
																@if ($schedule_off->student_id)
																				<label class="control-label"><i class="ti ti-user"></i> {{ __('Học viên xin nghỉ') }}: <x-link
																												:href="route('admin.student.edit', $schedule_off->student->id)" :title="$schedule_off->student->fullname" />
																				</label><br>
																@else
																				<label class="control-label"><i class="ti ti-user"></i> {{ __('Giáo viên xin nghỉ') }}: <x-link
																												:href="route('admin.teacher.edit', $schedule_off->teacher->id)" :title="$schedule_off->teacher->fullname" />
																				</label><br>
																@endif
																<label class="control-label"><i class="ti ti-message"></i> {{ __('Lý do xin nghỉ') }}:
																				{{ $schedule_off->reason }}
																</label>
												</div>
								</div>
				</div>
</div>
