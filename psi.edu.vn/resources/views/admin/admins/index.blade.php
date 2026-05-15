@extends('admin.layouts.master')

@push('libs-css')
    <style>
        .fc-button.fc-button-primary,
        .btn-app {
            background-color: #1d2e61 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary:hover,
        .btn-app:hover {
            background-color: #284086 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary.fc-button-active {
            background-color: #0a1c53 !important;
            color: #fff;
        }

        .fc-button.fc-button-primary:focus,
        .fc-button.fc-button-primary:focus-visible {
            outline: none;
            box-shadow: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">@lang('list')</h2>
                    <x-link :href="route('admin.admin.create')" class="btn btn-app">
                        <i class="ti ti-plus"></i>
                        <span class="ms-1">@lang('add')</span>
                    </x-link>
                </div>
                <div class="card-body">
                    <div class="table-responsive position-relative">
                        <x-admin.partials.toggle-column-datatable />
                        {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
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
