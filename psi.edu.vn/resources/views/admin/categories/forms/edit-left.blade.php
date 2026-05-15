<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Thông tin danh mục') }}</h2>
								</div>
								<div class="row card-body">
												<!-- name -->
												<div class="col-md-12 col-sm-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-category"></i> {{ __('Tên danh mục') }}:</label>
																				<x-input name="name" :value="$category->name" :required="true" placeholder="{{ __('Tên danh mục') }}" />
																</div>
												</div>
												<!-- position -->
												<div class="col-md-3 col-sm-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-location"></i> {{ __('Vị trí') }}:</label>
																				<x-input type="number" name="position" :value="$category->position" :required="true" />
																</div>
												</div>
												<!-- is active -->
												<div class="col-md-3 col-sm-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-settings-star"></i> {{ __('Trạng thái') }}:</label>
																				<x-select class="select2-bs5" name="is_active" :required="true">
																								<x-select-option :value="true" :title="__('Hoạt động')" />
																								<x-select-option :option="$category->is_active ?: '0'" value="0" :title="__('Tạm ngưng')" />
																				</x-select>
																</div>
												</div>
								</div>
				</div>
</div>
