@push('page_scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('/backend')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('/backend')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{asset('/backend')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('/backend')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/backend')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



<script>
    $(function () {
        var paginationLimit = $('#paginationLimit').val();



        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "pageLength": paginationLimit
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#example3").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "pageLength": paginationLimit
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": paginationLimit
        });
    });

</script>
@endpush
