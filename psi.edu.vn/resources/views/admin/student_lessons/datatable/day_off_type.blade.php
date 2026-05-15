@php
 $badgeClass = App\Enums\Lesson\DayOffType::from($day_off_type)->badge();
 $description = App\Enums\Lesson\DayOffType::getDescription($day_off_type);
@endphp

<span class="badge {{ $badgeClass }}">
				{{ $description }}
</span>
