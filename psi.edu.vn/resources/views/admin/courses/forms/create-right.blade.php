<div class="col-12 col-md-3">
				<div class="card mb-3">
								<div class="card-header">
												<span><i class="ti ti-playstation-circle me-2"></i>{{ __('Đăng') }}</span>
								</div>
								<div class="card-body p-2">
												<x-button.submit :title="__('Thêm')" />
								</div>
				</div>

				<div class="card mb-3">
								<div class="card-header">
												<i class="ti ti-category"></i>
												<span class="ms-2">{{ __('Danh mục') }}</span>
								</div>
								<div class="card-body wrap-list-checkbox p-2">
												@foreach ($categories as $category)
																<x-input-checkbox :depth="$category->depth" name="categories_id[]" :label="$category->name" :value="$category->id" />
												@endforeach
								</div>
				</div>
				@if (auth()->user()->isSuperAdmin)
								<div class="card mb-3">
												<div class="card-header">
																<span><i class="ti ti-user-check me-2"></i>{{ __('Duyệt khoá học') }}</span>
												</div>
												<div class="card-body p-2">
																<input type="hidden" name="is_active" value="0">
																<x-input-switch name="is_active" value="1" :label="__('Duyệt khoá học?')" />
												</div>
								</div>
				@endif
				<div class="card mb-3">
								<div class="card-header">
												<i class="ti ti-photo"></i>
												<span class="ms-2">@lang('avatar')</span>
								</div>
								<div class="card-body p-2">
												<section class="modal-profile-header position-relative d-flex ps-5">
																<div class="modal-cover-photo">
																				<div id="previewCover">
																								<img id="myImg" src="" class="w-100" alt="">
																				</div>
																				<label for="coverInp">
																								<div class="tool-edit-cover mt-3"><i class="ti ti-camera"></i></div>
																				</label>
																				<input accept="image/*" style="display: none" type='file' id="coverInp" name="avatar" />
																</div>
												</section>
												@include('user.scripts.upload-image')
								</div>
				</div>
</div>
