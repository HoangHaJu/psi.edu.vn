<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Thông tin đăng ký') }}</h2>
								</div>
								<div class="card-body row">
												<div class="mb-3">
																<label class="control-label"><i class="ti ti-book-2"></i> {{ __('Tên khoá học') }}: <x-link
																								:href="route('admin.course.edit', $booking->course->id)" :title="$booking->course->name" />
																</label><br>
																<label class="control-label"><i class="ti ti-user"></i> {{ __('Tên học viên') }}: <x-link
																								:href="route('admin.student.edit', $booking->admin->id)" :title="$booking->admin->fullname" />
																</label><br>
																<label class="control-label"><i class="ti ti-currency-dollar"></i> {{ __('Tổng tiền') }}:
																				{{ format_price($booking->total) }}
																</label>
												</div>
								</div>
				</div>
</div>
