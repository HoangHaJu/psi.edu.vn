@php
    $admin = App\Models\Admin::find($admin['id']);
@endphp
@if (isset($admin))
    @if ($admin->isTeacher)
        <span>{{ $admin['fullname'] }}</span>
    @elseif($admin->isStudent)
        <span>{{ $admin['fullname'] }}</span>
    @endif
@endif
