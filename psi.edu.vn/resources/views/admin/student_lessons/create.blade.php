@extends('admin.layouts.master')

@push('libs-css')
				<link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
				<link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@section('content')
				<div class="page-body">
								<div class="container-xl">
												<x-form :action="route('admin.student_lesson.store')" type="post" enctype="multipart/form-data" :validate="true">
																<div class="row justify-content-center">
																				@include('admin.student_lessons.forms.create-left')
																				@include('admin.student_lessons.forms.create-right')
																</div>
												</x-form>
								</div>
				</div>
@endsection

@push('libs-js')
				<script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
				<script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
				<script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
				@include('ckfinder::setup')
@endpush

@push('custom-js')
				@include('admin.student_lessons.scripts.scripts')
@endpush
