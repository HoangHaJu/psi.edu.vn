@extends('admin.layouts.master')

@section('content')
				<div class="page-body">
								<div class="container-xl">
												<x-form :action="route('admin.teacher.update')" type="put" enctype="multipart/form-data" :validate="true">
																<x-input type="hidden" name="id" :value="$admin->id" />
																<div class="row justify-content-center">
																				@include('admin.teachers.forms.edit-left')
																				@include('admin.teachers.forms.edit-right')
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
