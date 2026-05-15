@if (auth('web')->user())
				<div class="mb-3">
								<label for="order[fullName]" class="form-label">Họ và tên</label>
								<x-input readonly :value="$user->fullname" type="text" class="form-control" name="order[fullname]"
												placeholder="Nhập họ và tên" />
				</div>
				<div class="mb-3">
								<label for="order[address]" class="form-label">Địa chỉ</label>
								<x-input readonly :value="$user->address" type="text" class="form-control" name="order[address]"
												placeholder="Nhập địa chỉ" />
				</div>
				<div class="mb-3">
								<label for="order[phone]" class="form-label">Số điện thoại</label>
								<x-input-phone readonly :value="$user->phone" name="order[phone]" :required="true" />
				</div>
				<div class="mb-3">
								<label for="order[email]" class="form-label">Email</label>
								<x-input-email readonly :value="$user->email" name="order[email]" :required="true" />
				</div>
				<div class="mb-3">
								<label for="order[note]" class="form-label">Ghi chú</label>
								<textarea class="form-control" name="order[note]" rows="3" placeholder="Nhập ghi chú"></textarea>
				</div>
				<div class="form-check">
								<input class="form-check-input ms-3" type="checkbox" id="showDetails">
								<label class="form-check-label" for="showDetails">
												Giao đến địa chỉ khác
								</label>
				</div>
@else
				<div class="mb-3">
								<label for="order[fullname]" class="form-label">Họ và tên</label>
								<x-input type="text" class="form-control" name="order[fullname]" placeholder="Nhập họ và tên"
												:required="true" />
				</div>
				<div class="mb-3">
								<label for="order[address]" class="form-label">Địa chỉ</label>
								<x-input type="text" class="form-control" name="order[address]" placeholder="Nhập địa chỉ"
												:required="true" />
				</div>
				<div class="mb-3">
								<label for="order[phone]" class="form-label">Số điện thoại</label>
								<x-input-phone name="order[phone]" :value="old('order[phone]')" :required="true" />
				</div>
				<div class="mb-3">
								<label for="order[email]" class="form-label">Email</label>
								<x-input-email name="order[email]" :value="old('order[email]')" :required="true" />
				</div>
				<div class="mb-3">
								<label for="order[note]" class="form-label">Ghi chú</label>
								<textarea class="form-control" name="order[note]" rows="3" placeholder="Nhập ghi chú"></textarea>
				</div>
				<div class="form-check">
								<input class="form-check-input ms-3" type="checkbox" id="showDetails">
								<label class="form-check-label" for="showDetails">
												Giao đến địa chỉ khác
								</label>
				</div>
@endif
