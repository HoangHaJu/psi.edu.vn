@props([
    'id' => null, // ID tùy chọn cho nút (để JS có thể tương tác nếu cần)
    'targetModalId', // ID của modal cần mở (VD: 'loginModal', 'registerModal')
    'label', // Text hiển thị trên nút (VD: 'Đăng nhập')
    'buttonClass' => 'btn btn-primary', // Class CSS cho nút
])

<button @if ($id) id="{{ $id }}" @endif {{-- Chỉ thêm ID nếu được cung cấp --}} type="button"
    class="{{ $buttonClass }}" data-bs-toggle="modal" data-bs-target="#{{ $targetModalId }}" {{ $attributes }}>
    {{ __($label) }}
</button>
