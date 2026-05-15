<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- name -->
            <div class="col-12">
                <div class="mb-3">
                    <label for=""><i class="ti ti-pencil"></i> {{ __('Tên gói vé') }} <span
                            class="text-danger">*</span></label>
                    <x-input name="name" :value="$ticket->name" :placeholder="__('Tên gói vé')" />
                </div>
            </div>
            <!-- quantity -->
            <div class="col-6">
                <div class="mb-3">
                    <label for=""><i class="ti ti-message"></i> {{ __('Số lượng') }} <span
                            class="text-danger">*</span></label>
                    <x-input type="number" name="quantity" :value="$ticket->quantity" :placeholder="__('Số lượng')" />
                </div>
            </div>
            <!-- price -->
            <div class="col-6">
                <div class="mb-3">
                    <label for=""><i class="ti ti-pencil"></i> {{ __('Giá gói vé') }} <span
                            class="text-danger">*</span></label>
                    <x-input name="price" :value="$ticket->price" :placeholder="__('Giá gói vé')" />
                </div>
            </div>
            <!-- during -->
            <div class="col-12">
                <div class="mb-3">
                    <label for=""><i class="ti ti-pencil"></i> {{ __('Thời hạn') }} <span
                            class="text-danger">*</span></label>
                    <x-input name="during" :value="$ticket->during" :placeholder="__('Thời hạn')" />
                </div>
            </div>

            <!-- type -->
            <div class="col-12">
                <div class="mb-3">
                    <label for="type"><i class="ti ti-tag"></i> {{ __('Loại gói') }} <span
                            class="text-danger">*</span></label>
                    <select class="form-select" disabled>
                        <option value="normal" {{ old('type', $ticket->type) == 'normal' ? 'selected' : '' }}>
                            {{ __('Gói thường') }}
                        </option>
                        <option value="special" {{ old('type', $ticket->type) == 'special' ? 'selected' : '' }}>
                            {{ __('Gói đặc biệt') }}
                        </option>
                    </select>
                    <input type="hidden" name="type" value="{{ old('type', $ticket->type) }}">
                </div>
            </div>

            <!-- description -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-file-description"></i> {{ __('Mô tả') }}:</label>
                    <textarea name="description" class="ckeditor">{!! old('description', $ticket->description) !!}</textarea>
                </div>
            </div>


        </div>
    </div>
</div>
