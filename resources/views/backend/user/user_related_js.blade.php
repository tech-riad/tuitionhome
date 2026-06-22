@push('page_scripts')
    <script>

        // Edit user jquery
        $(document).ready(function (){
            $('.editBtn').on('click',function (){
                $("#editUserModal").modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children('td').map(function (){
                    return $(this).text();
                }).get();

                console.log(data);
                var us_id = $(this).attr("data-id");

                $('#us_id').val(us_id);
                $('#user_name').val(data[1]);
                $('#user_email').val(data[2]);
                $('#user_phone').val(data[3]);
                $('#user_role').val(data[4]);
            });


        });
        // End Edit user jquery
        function btnDelete(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    $('#btndelete'+id).submit();
                };
            });
        }

        function btnPermissionDelete(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    $('#btndelete'+id).submit();
                };
            });
        }

        // Edit Permission jquery
        $(document).ready(function (){
            $('.editPermissionBtn').on('click',function (){

               $("#editPermissionModal").modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children('td').map(function (){
                    return $(this).text();
                }).get();

                console.log(data);
                var permission_id = $(this).attr("data-id");

                $('#permission_group_id').val(permission_id);
                $('#permission_group_name').val(data[1]);
                $('#permission_name').val(data[2]);
             });


        });
        // End Edit Permission jquery

    </script>
@endpush
