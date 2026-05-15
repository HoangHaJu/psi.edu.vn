<div class="col-12 col-md-9">
    <div class="row">
        <!-- name -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-article"></i> {{ __('Tiêu đề') }}: <span
                        class="text-danger">*</span></label>
                <x-input name="title" :value="old('title')" :required="true" placeholder="{{ __('Tiêu đề') }}" />
            </div>
        </div>

        <!-- desc -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-file-description"></i>
                    {{ __('Nội dung bài viết') }}:</label>
                <textarea name="content" class="ckeditor visually-hidden">
                    {{ old('content') }}
                </textarea>
            </div>
        </div>
        <!-- excerpt -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-file-description"></i>
                    {{ __('Mô tả ngắn (Meta description)') }}:</label>
                <textarea class="form-control" name="excerpt" rows="5">{{ old('excerpt') }}</textarea>
            </div>
        </div>
    </div>
</div>
