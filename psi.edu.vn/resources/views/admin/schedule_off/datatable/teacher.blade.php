@if (isset($teacher))
				@if (auth('admin')->user()->isSuperAdmin)
								<x-link :href="route('admin.teacher.edit', $teacher_id)" :title="$teacher['fullname']" />
				@else
								{{ $teacher['fullname'] }}
				@endif
@endif
