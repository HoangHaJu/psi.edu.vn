<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Thông tin Khoá học') }}</h2>
								</div>
								<div class="card-body row">
												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-book-2"></i> {{ __('Tên khoá học') }}:
																</label>
																<x-input name="name" :value="$course->name" :required="true" placeholder="{{ __('Tên khoá học') }}" />
												</div>
												<div class="col-md-6 mb-3">
																<label class="control-label"><i class="ti ti-school"></i> {{ __('Trình độ') }}:
																</label>
																<x-select name="education_level" :required="true">
																				@foreach ($educationLevel as $key => $value)
																								<x-select-option :option="$course->education_level" :value="$key" :title="__($value)" />
																				@endforeach
																</x-select>
												</div>
												<div class="mb-3">
																<label class="control-label"><i class="ti ti-file-description"></i> {{ __('Mô tả') }}:</label>
																<textarea name="description" class="ckeditor visually-hidden">{{ $course->description }}</textarea>
												</div>
								</div>
				</div>
</div>
