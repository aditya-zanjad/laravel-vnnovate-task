@extends('layouts.default')

@section('title', 'Products | Index')

@push('css')
    <!-- Begin: Datatables - CSS -->
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/jquery.dataTable.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.1.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.dataTables.min.css') }}">
    <!-- End: Datatables - CSS -->

    <!-- Begin: Custom CSS -->
    <style>
        thead input {
            width: 100%;
        }

        th, td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }

        table.dataTable thead th,
        table.dataTable thead td,
        input::placeholder {
            text-align: center;
        }
    </style>
    <!-- End: Custom CSS -->
@endpush

@section('content')
    <div class="container-fluid my-5">
        <div class="card bg-light shadow-lg">
            <div class="card-header">Manage Shops</div>
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped table-hover stripe']) !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Begin: Datatable - JS -->
    <script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <!-- End: Datatable - JS -->

    <!-- Begin: DataTable Column Filter -->
    <script>
        $('#products_table thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#products_table thead');
    </script>
    <!-- End: DataTable Column Filter -->
@endpush
