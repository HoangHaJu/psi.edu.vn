@if (auth('admin')->user()->isSuperAdmin)
    <x-link :href="route('admin.course.edit', $course_id)" :title="$course['name']" />
@else
    {{ $course['name'] }}
@endif
