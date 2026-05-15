<div id="details" style="display: none;">
				<div class="mb-3">
								<label for="order[name_other]" class="form-label">Họ và tên khác</label>
								<x-input type="text" class="form-control" name="order[name_other]" placeholder="Nhập họ và tên khác" />
				</div>
				<div class="mb-3">
								<label for="order[address_other]" class="form-label">Địa chỉ khác</label>
								<x-input type="text" class="form-control" name="order[address_other]" placeholder="Nhập địa chỉ khác" />
				</div>
				<div class="mb-3">
								<label for="order[phone_other]" class="form-label">Số điện thoại khác</label>
								<x-input-phone name="order[phone_other]" :value="old('order[phone_other]')" />
				</div>
				<div class="mb-3">
								<label for="order[note_other]" class="form-label">Ghi chú khác</label>
								<textarea class="form-control" name="order[note_other]" rows="3" placeholder="Nhập ghi chú khác"></textarea>
				</div>
</div>
