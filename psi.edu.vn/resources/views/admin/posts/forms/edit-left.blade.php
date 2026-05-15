<div class="col-12 col-md-9">
    <div class="row">
        <!-- name -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-article"></i> {{ __('Tiêu đề') }}:</label>
                <x-input name="title" :value="$post->title" :required="true" placeholder="{{ __('Tiêu đề') }}" />
            </div>
        </div>

        <!-- meta title -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-article"></i> {{ __('Tiêu đề (Meta title)') }}:</label>
                <x-input name="meta_title" :value="$post->meta_title" :required="true"
                    placeholder="{{ __('Tiêu đề (Meta title)') }}" />
            </div>
        </div>

        <!-- slug -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-link"></i> {{ __('Slug bài viết') }}:</label>
                <x-input name="slug" :value="$post->slug" :required="true" placeholder="{{ __('Slug bài viết') }}" />
            </div>
        </div>

        <!-- desc -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-file-description"></i>
                    {{ __('Nội dung bài viết') }}:</label>
                <textarea name="content" class="ckeditor visually-hidden">{{ $post->content }}</textarea>
            </div>
        </div>

        <!-- excerpt -->
        <div class="col-12">
            <div class="mb-3">
                <label class="control-label"><i class="ti ti-file-description"></i>
                    {{ __('Mô tả ngắn (Meta description)') }}:</label>
                <textarea class="form-control" name="excerpt" rows="5">{{ $post->excerpt }}</textarea>
            </div>
        </div>
    </div>
</div>
