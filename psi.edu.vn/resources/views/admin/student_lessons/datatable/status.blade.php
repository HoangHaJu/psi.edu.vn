@php
				$badgeClass = App\Enums\Lesson\LessonStatus::from($status)->badge();
				$description = App\Enums\Lesson\LessonStatus::getDescription($status);
@endphp

<span class="badge {{ $badgeClass }}">
				{{ $description }}
</span>
