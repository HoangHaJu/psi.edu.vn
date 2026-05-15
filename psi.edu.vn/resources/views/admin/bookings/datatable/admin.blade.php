@if (auth('admin')->user()->isSuperAdmin)
				<x-link :href="route('admin.student.edit', $admin_id)" :title="$admin['fullname']" />
@else
				{{ $admin['fullname'] }}
@endif
