<div id="resultQuickViewRequest">
				@if (isset($teacherModal))
								<div id="registerModal" class="modal">
												<div class="modal-dialog modal-dialog-product-preview">
																<div class="modal-content">
																				<x-form type="post" :action="route('admin.booking.create')" :validate="true">
																								<div class="modal-body row">
																												<div class="col-md-3 d-flex text-center">
																																<div class="mb-3">
																																				<img class="img-circle d-block mx-auto" src="{{ asset($teacherModal->avatar) }}"
																																								alt="">
																																</div>
																																<div class="ms-3 mt-3">
																																				<h3 class="default-color">{{ $teacherModal->fullname }}</h3>
																																				<h4 class="badge bg-success">Teacher</h4>
																																</div>
																												</div>
																												<div class="col-md-3">
																																<h3><strong>Email: </strong>{{ $teacherModal->email }}</h3>
																																<h3><strong>Số điện thoại: </strong>{{ $teacherModal->phone }}</h3>

																																<h3><strong>Giọng nói: </strong></h3>
																																<audio class="w-100 my-1" controls>
																																				<source src="{{ asset($teacherModal->audio) }}" type="audio/mp3">
																																				<source src="{{ asset($teacherModal->audio) }}" type="audio/wav">
																																				Trình duyệt của bạn không hỗ trợ phát audio này
																																</audio>
																												</div>
																												<div class="col-md-3">
																																<h3><strong>SkypeID: </strong>{{ $teacherModal->skype_id }}</h3>
																																<h3><strong>Giới tính:
																																				</strong>{{ App\Enums\User\Gender::getDescription($teacherModal->gender) }}</h3>
																												</div>

																												<div class="col-md-3 text-end">
																																<button type="submit" class="btn btn-default">Confirm</button>
																																<button type="button" class="btn bg-white">Cancel</button>
																												</div>
																												@foreach ($teacherModal->activeCourses() as $course)
																																<div class="col-md-3 mb-3">
																																				<div style="border: none" class="card course-card"
																																								data-course-id="{{ $course->id }}">
																																								<div>
																																												<input type="radio" class="course-radio d-none" name="course_id"
																																																value="{{ $course->id }}" id="course_{{ $course->id }}">
																																												<label for="course_{{ $course->id }}" class="course-label">
																																																<div class="mb-3 text-center">
																																																				<img style="width: 150px; height: 150px"
																																																								class="img-fluid cursor-default"
																																																								src="{{ asset($course->avatar) }}" alt="">
																																																</div>
																																																<h3 class="bold-text">
																																																				{{ $course->name }}
																																																</h3>
																																																@php
																																																				$daysOfWeek = [
																																																				    1 => 'Thứ 2',
																																																				    2 => 'Thứ 3',
																																																				    3 => 'Thứ 4',
																																																				    4 => 'Thứ 5',
																																																				    5 => 'Thứ 6',
																																																				    6 => 'Thứ 7',
																																																				    7 => 'Chủ nhật',
																																																				];
																																																				$scheduleText = $course->schedule
																																																				    ? collect(json_decode($course->schedule))
																																																				        ->map(fn($day) => $daysOfWeek[(int) $day] ?? '')
																																																				        ->filter()
																																																				        ->join(', ')
																																																				    : 'Chưa có lịch học';
																																																@endphp

																																																<p><strong><i
																																																												class="ti ti-calendar me-2"></i>{{ __('Lịch học:') }}</strong>
																																																				{{ $scheduleText }}</p>
																																																<p><strong><i
																																																												class="ti ti-calendar-event me-2"></i>{{ __('Ngày bắt đầu:') }}</strong>
																																																				{{ $course->start_date }}</p>
																																																<p><strong><i
																																																												class="ti ti-calendar-minus me-2"></i>{{ __('Ngày kết thúc:') }}</strong>
																																																				{{ $course->end_date }}</p>
																																																<p><strong><i
																																																												class="ti ti-clock me-2"></i>{{ __('Thời gian:') }}</strong>
																																																				{{ $course->start_time }} - {{ $course->end_time }}</p>

																																																<p><strong><i
																																																												class="ti ti-currency-dollar me-2"></i>{{ __('Giá:') }}</strong>
																																																				<del
																																																								class="me-1">{{ $course->price ? number_format($course->price, 0, ',', '.') . ' VNĐ' : __('Miễn phí') }}</del>
																																																				{{ $course->promotion_price ? number_format($course->promotion_price, 0, ',', '.') . ' VNĐ' : __('Miễn phí') }}
																																																</p>
																																																<p><strong><i
																																																												class="ti ti-school me-2"></i>{{ __('Trình độ khoá học:') }}</strong>
																																																				{{ App\Enums\Admin\EducationLevel::getDescription($course->education_level) }}
																																																</p>
																																																<p><strong><i
																																																												class="ti ti-shopping-cart me-2"></i>{{ __('Lượt mua:') }}</strong>
																																																				{{ $course->purchase_count }}</p>
																																																<button id="" data-id="{{ $course->id }}"
																																																				onclick="window.location.href = '{{ route('admin.course.detail', $course->id) }}'"
																																																				type="button" class="btn btn-default d-flex m-auto">
																																																				Chi tiết
																																																</button>
																																												</label>
																																								</div>
																																				</div>
																																</div>
																												@endforeach
																								</div>
																				</x-form>
																</div>
												</div>
								</div>
				@endif
</div>

<script src="{{ asset('public/user/assets/js/jquery.js') }}"></script>
<script src="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
{{-- <link href="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet"type="text/css"> --}}

<script>
				$(document).ready(function() {
								$(".btn.bg-white").on("click", function() {
												$('#registerModal').modal('hide');
								});
								document.querySelectorAll('.course-card').forEach(card => {
												card.addEventListener('click', () => {
																const checkbox = card.querySelector('.course-checkbox');
																checkbox.checked = !checkbox.checked;
																card.classList.toggle('selected', checkbox.checked);
												});
								});
				});
</script>
