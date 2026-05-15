@if (auth('admin')->user()->isSuperAdmin)
    <x-link :href="route('admin.student.edit', $user_id)" :title="$user['fullname']" />
@else
    {{ $user['fullname'] }}
@endif
