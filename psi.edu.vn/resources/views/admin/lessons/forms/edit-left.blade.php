<div class="col-12 col-md-9">
	<div class="card">
		<div class="card-header justify-content-center">
			<h2 class="mb-0">{{ __('Thông tin buổi học') }}</h2>
		</div>
		<div class="card-body row">
			<x-input type="hidden" :value="$lesson->course_id" name="course_id" />
			<div class="col-md-6 mb-3">
				<label class="control-label"><i class="ti ti-clock"></i> {{ __('Thời gian học') }}:</label>
				<x-input type="time" name="start_time" :value="$lesson->start_time" :required="true" />
			</div>
		</div>
	</div>
</div>