<!-- Begin: Datatable - JS -->
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTable.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTable.fixedColumn.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>

@json($dataTable->scripts())
<!-- End: Datatable - JS -->

