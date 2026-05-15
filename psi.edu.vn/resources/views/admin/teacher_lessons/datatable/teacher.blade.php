@if ($teacher && !empty($teacher['id']) && !empty($teacher['fullname']))
    <x-link :href="route('admin.teacher.edit', $teacher['id'])" :title="$teacher['fullname']" />
@else
    <span class="text-gray-500 italic">Chưa có giáo viên đăng ký</span>
@endif
