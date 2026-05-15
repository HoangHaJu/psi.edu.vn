@extends('admin.layouts.master')

@push('libs-css')
				<link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
				<link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@section('content')
				<div class="page-body">
								<div class="container-xl">
												<x-form :action="route('admin.course.update')" type="put" enctype="multipart/form-data" :validate="true">
																<x-input type="hidden" name="id" :value="$course->id" />
																<div class="row justify-content-center">
																				@include('admin.courses.forms.edit-left')
																				@include('admin.courses.forms.edit-right')
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
				@include('admin.courses.scripts.scripts')
@endpush
