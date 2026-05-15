@if (isset($student))
				@if (auth('admin')->user()->isSuperAdmin)
								<x-link :href="route('admin.student.edit', $student_id)" :title="$student['fullname']" />
				@else
								{{ $student['fullname'] }}
				@endif
@endif
