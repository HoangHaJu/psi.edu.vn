<textarea {{ $attributes
    ->class(['form-control'])
    ->merge([
        'data-parsley-type-message' => __('Hãy nhập vào trường này.')
    ])->merge($isRequired())
}}>{{ $slot }}</textarea>