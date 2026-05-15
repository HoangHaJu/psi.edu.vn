@props(['from', 'to', 'variant' => 'secondary', 'label' => null])

<button type="button"
    {{ $attributes->merge([
        'class' => 'step-btn ' . ($variant === 'secondary' ? 'btn btn-outline-secondary' : 'btn btn-primary'),
    ]) }}
    data-from="{{ $from }}" data-to="{{ $to }}">
    {{ $label ?? $slot }}
</button>
