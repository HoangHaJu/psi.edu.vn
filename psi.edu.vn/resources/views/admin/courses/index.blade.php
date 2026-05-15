@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">{{ __('Danh sách khoá học') }}</h2>
                    @if (auth()->user()->isSuperAdmin)
                        <x-form :action="route('admin.excel.import')" type="post" enctype="multipart/form-data" :validate="true">
                            <input type="file" name="excel_file" id="excel_file" class="d-none" accept=".xlsx, .xls, .csv">
                            <button type="button" class="btn btn-primary" id="import-button">
                                Nhập <i class="ti ti-file-arrow-left ms-2"></i>
                            </button>
                            <button id="export-button" type="button" class="btn btn-secondary">Xuất <i
                                    class="ti ti-file-arrow-right ms-2"></i></button>
                        </x-form>
                    @endif
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
    <script>
        document.getElementById('import-button').addEventListener('click', function() {
            document.getElementById('excel_file').click();
        });

        document.getElementById('excel_file').addEventListener('change', function() {
            this.closest('form').submit();
        });

        document.getElementById('export-button').addEventListener('click', function() {
            window.location.href = "{{ route('admin.excel.export') }}";
        });
    </script>
    {{ $dataTable->scripts() }}

    @include('admin.scripts.datatable-toggle-columns', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])
@endpush
