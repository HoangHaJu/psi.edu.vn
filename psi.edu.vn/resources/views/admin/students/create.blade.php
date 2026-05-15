@extends('admin.layouts.master')

@section('content')
				<div class="page-body">
								<div class="container-xl">
												<x-form :action="route('admin.student.store')" type="post" :validate="true">
																<div class="row justify-content-center">
																				@include('admin.students.forms.create-left')
																				@include('admin.students.forms.create-right')
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
