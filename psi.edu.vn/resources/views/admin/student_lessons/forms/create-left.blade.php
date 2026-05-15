<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Tạo các buổi học cho khoá học: ') . $course_id }}</h2>
								</div>
								<div class="card-body row">
												<x-input type="hidden" :value="$course_id" name="course_id" />
												<div class="col-md-4 mb-3">
																<label class="control-label"><i class="ti ti-clock"></i> {{ __('Thời gian bắt đầu') }}:</label>
																<x-input type="time" name="start_time" :value="old('start_time')" :required="true" />
												</div>
												<div class="col-md-4 mb-3">
																<label class="control-label"><i class="ti ti-clock"></i> {{ __('Thời gian kết thúc') }}:</label>
																<x-input type="time" name="end_time" :value="old('end_time')" :required="true" />
												</div>
												<div class="col-md-4 mb-3">
																<label class="control-label"><i class="ti ti-clock"></i> {{ __('Khoảng thời gian (phút)') }}:</label>
																<x-input type="number" name="period" :value="old('period')" :required="true" />
												</div>
								</div>
				</div>
</div>
