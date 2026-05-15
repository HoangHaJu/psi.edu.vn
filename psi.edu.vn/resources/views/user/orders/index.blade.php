@extends('user.layouts.master')
@section('title', __('Đơn hàng'))

@push('custom-css')
				<style>
								.review_rating {
												input {
																display: none;

																&:checked {
																				&~label {
																								color: #aaa;
																				}
																}
												}

												label {
																color: orange;
																font-size: 2rem;
												}
								}

								h1 {
												font-family: sans-serif;
												color: #222;
								}
				</style>
@endpush

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div class="d-flex justify-content-center align-items-center container bg-white">
								<div class="container gap-64">
												<div class="row mb-3 mt-3">
																@include('user.auth.menu')
																<div class="col-md-10 col-12">
																				<div class="table-responsive position-relative">
																								<x-user.partials.toggle-column-datatable />
																								{{ $dataTable->table(['class' => 'table table-bordered', 'style' => 'min-width: 900px;'], true) }}
																				</div>
																</div>
												</div>
								</div>
				</div>
@endsection

@push('libs-js')
				<script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('custom-js')
				{{ $dataTable->scripts() }}

				@include('admin.scripts.datatable-toggle-columns', [
								'id_table' => $dataTable->getTableAttribute('id'),
				])

				@include('user.orders.scripts.scripts')
@endpush
