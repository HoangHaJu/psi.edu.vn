<div class="col-12 col-md-9">
				<div class="card">
								<div class="row card-body">
												<!-- title -->
												<div class="col-12">
																<div class="mb-3">
																				<label for=""><i class="ti ti-pencil"></i> {{ __('Tiêu đề') }} <span
																												class="text-danger">*</span></label>
																				<x-input :value="$notification->title" name="title" :required="true" :placeholder="__('Tiêu đề')" />
																</div>
												</div>
												<!-- message -->
												<div class="col-12">
																<div class="mb-3">
																				<label for=""><i class="ti ti-message"></i> {{ __('Lời nhắn') }} <span
																												class="text-danger">*</span></label>
																				<x-input :value="$notification->message" name="message" :required="true" :placeholder="__('Lời nhắn')" />
																</div>
												</div>

								</div>
				</div>
</div>
