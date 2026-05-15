@extends('admin.layouts.master')

@push('libs-css')
@endpush

@section('content')
				<div class="mt-3 p-3">
								<div class="container-xl">
												<div style="min-height: 300px">
																<h2 class="default-color">Upcoming Lessons</h2>
																<div class="row g-4 mb-3"> <!-- Sử dụng g-4 để thêm khoảng cách -->
																				@if ($upcomingLessons->count() > 0)
																								@foreach ($upcomingLessons as $lesson)
																												<div class="col-md-3">
																																<div style="border-radius: 15px" class="card h-100 bg-white p-3">
																																				<!-- Card header -->
																																				<div class="d-flex align-items-center default-bg mb-3 rounded p-2">
																																								<img style="height: 50px; width: 50px;" class="img-circle"
																																												src="{{ asset($lesson->teacher_lesson->teacher->avatar) }}"
																																												alt="Teacher Avatar">
																																								<h3 class="ms-2 mt-1 text-white">{{ $lesson->teacher_lesson->teacher->fullname }}
																																								</h3>
																																				</div>

																																				<!-- Course details -->
																																				<div class="lesson-details default-color mb-3">
																																								<h3>Tên buổi học</h3>
																																								<p>{{ format_date($lesson->date) }}
																																								</p>
																																								<p>{{ $lesson->start_time }} </p>
																																				</div>
																																				<button onclick="location.href='{{ route('admin.student_lesson.edit', $lesson->id) }}'"
																																								class="btn btn-primary w-100 d-flex justify-content-between align-items-center">
																																								Detail
																																								<span class="ms-2">&#8594;</span>
																																				</button>
																																</div>
																												</div>
																								@endforeach
																				@else
																								<div style="min-height: 300px" class="card bg-white p-3">
																												<div class="p-5 text-center">
																																<p>You have no upcoming lessons</p>
																																<a href="{{ route('admin.booking.create') }}" class="btn btn-primary text-white">Book
																																				now</a>
																												</div>
																								</div>
																				@endif

																</div>
												</div>
												<div class="mb-3 mt-3">
																<h3 class="bold-text">Buổi học đã học</h3>
																<div class="card-body">
																				<div class="table-responsive position-relative">
																								<x-admin.partials.toggle-column-datatable />
																								{{ $dataTable->table(['class' => 'table table-bordered', 'style' => 'min-width: 900px;'], true) }}
																				</div>
																</div>
												</div>
								</div>
				</div>
@endsection

@push('libs-js')
				<!-- button in datatable -->
				<script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('custom-js')
				{{ $dataTable->scripts() }}

				@include('admin.scripts.datatable-toggle-columns', [
								'id_table' => $dataTable->getTableAttribute('id'),
				])
@endpush
