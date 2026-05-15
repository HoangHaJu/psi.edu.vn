<input type="text"
    {{ $attributes->class(['form-control'])->merge([
            'placeholder' => __('Số điện thoại'),
            'data-parsley-pattern' => '/^(0\d{9}|\+?[1-9]\d{1,14})$/',
            'data-parsley-pattern-message' => __('Số điện thoại không hợp lệ.'),
        ])->merge($isRequired()) }}>
