<!-- Begin: Datatables - CSS -->
<link rel="stylesheet" href="{{ asset('assets/datatable/css/jquery.dataTable.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/fixedHeader.dataTable.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/fixedColumn.dataTable.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.dataTables.min.css') }}">
<!-- End: Datatables - CSS -->

<!-- Begin: Custom Datatable CSS -->
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

    table.dataTable thead th, table.dataTable thead td, input::placeholder {
        text-align: center;
    }

    .dataTables_info, .dataTables_paginate {
        margin-top: 12px;
    }
</style>
<!-- End: Custom Datatable CSS -->
