@if (auth()->user()->isSuperAdmin)
    <x-link :href="route('admin.course.edit', $id)" :title="$name" />
@else
    {{-- @if (auth()->user()->isTeacher) --}}
    <x-link :href="route('admin.course.registerLessons', $id)" :title="$name" />
    {{-- @endif --}}
@endif
