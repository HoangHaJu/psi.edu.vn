@if (isset($courses))
				@foreach ($courses as $item)
								<x-link :href="route('admin.course.edit', $item['id'])" :title="__($item['name'])" />
								@if (!$loop->last)
												, {{-- Thêm dấu phẩy nếu không phải phần tử cuối --}}
								@endif
				@endforeach
@endif
