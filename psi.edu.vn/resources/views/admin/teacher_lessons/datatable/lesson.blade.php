@if (isset($lesson))
    {{ $lesson['course']['name'] . ' - ' . $lesson['start_time'] . ' ' . format_date($lesson['date'], 'd-m-Y') }}
@else
    {{ 'Không tồn tại khóa học' }}
@endif
