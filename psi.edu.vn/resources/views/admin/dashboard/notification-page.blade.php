@extends('admin.layouts.master')

<link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard.css') }}">
<style>
				.fc-event-title {
								white-space: normal !important;
								/* Cho phép xuống hàng */
								word-wrap: break-word;
								/* Tự động ngắt dòng nếu từ quá dài */
				}
</style>
@section('content')
				<div class="container p-4">
								<h1 class="mb-3 text-center">Thông báo</h1>
								@if ($notifications)
												<div class="list-group">
																@foreach ($notifications as $notification)
																				<div class="list-group-item d-flex justify-content-between">
																								<div>
																												<div class="fw-bold" style="max-width: 90%;">
																																{{ $notification->title }}
																												</div>
																												<div class="text-muted" style="max-width: 90%;">
																																{{ $notification->message }}
																												</div>
																								</div>
																								<span class="text-muted">
																												{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans(null, true) }} trước
																								</span>
																				</div>
																@endforeach
												</div>
												<div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
																@if ($notifications->hasPages())
																				<!-- Nút Previous -->
																				<button class="pagination-btn prev" onclick="location.href='{{ $notifications->previousPageUrl() }}'"
																								@if ($notifications->onFirstPage()) disabled @endif>
																								<i class="ti ti-arrow-left" aria-hidden="true"></i>
																				</button>

																				<!-- Nút phân trang -->
																				@for ($i = 1; $i <= $notifications->lastPage(); $i++)
																								<button onclick="location.href='{{ $notifications->url($i) }}'"
																												class="pagination-btn @if ($i == $notifications->currentPage()) active @endif">
																												{{ $i }}
																								</button>
																				@endfor

																				<!-- Nút Next -->
																				<button class="pagination-btn next" onclick="location.href='{{ $notifications->nextPageUrl() }}'"
																								@if (!$notifications->hasMorePages()) disabled @endif>
																								<i class="ti ti-arrow-right" aria-hidden="true"></i>
																				</button>
																@endif
												</div>
								@else
												<div class="p-5 text-center">
																<p>You have no notification</p>
																<a href="{{ route('admin.dashboard') }}" class="btn btn-app text-white">Go back</a>
												</div>
								@endif
				</div>
@endsection
