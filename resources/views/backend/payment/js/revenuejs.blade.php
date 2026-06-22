<script>
    $(document).ready(function() {
        $('.service-verify-button').click(function() {
            var button = $(this);
            var itemId = button.data('id');

            $.ajax({
                url: '/admin/payment/verify-service-charge',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: itemId
                },
                success: function(response) {
                    if (response.status === false) {
                        $.each(response.error, function(prefix, val) {
                            $("span." + prefix + "_error").text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Verified successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        button.removeClass('btn-warning').addClass('btn-primary').text('Verified');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>

{{-- Payment Note Submit --}}
<script>
    $(document).ready(function() {
        $('.btn-note').click(function() {
            var itemId = $(this).attr('id');
            $('#itemId').val(itemId);


            $('#noteTitle').val('');
            $('#noteDetails').val('');
        });

        $('#btnSaveNote').click(function() {
            var formData = {
                _token: '{{ csrf_token() }}',
                item_id: $('#itemId').val(),
                note_title: $('#noteTitle').val(),
                note_details: $('#noteDetails').val()
            };

            $.ajax({
                url: '/admin/payment/note-create',
                method: 'POST',
                data: formData,
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                    icon: 'success',
                    title: 'Note saved successfully',
                    showConfirmButton: false,
                    timer: 1500
                    }).then(function() {
                        $('#createNoteModal').modal('hide');
                        location.reload();
                    });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to save note',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred',
                        text: 'Please try again.'
                    });
                }
            });
        });
    });
</script>



    {{-- Note Details --}}
    <script>
        function loadNoteDetails(itemId) {
            $.ajax({
                url: '/admin/get-note-details/' + itemId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#noteModalBody').html(response.html);
                    $('#noteModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to fetch note details. Please try again.');
                }
            });
        }

    </script>

    <script>
        let filter = {};

        function inputChange(colname, id) {
        filter[colname] = $("#" + id).val();
        var input = '';

        const dateValue = filter[colname].replace(/-/g, '');

        Object.entries(filter).forEach((entry, index) => {
            const [key, value] = entry;

            if (index == (Object.keys(filter).length - 1)) {
                input += `${key}='${value}' `;
            } else {
                input += `${key}='${value}' and `;
            }
        });

        $('#revenue_filter').val(input);
        }
    </script>

<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('admin.revenue.search') }}",
                type: "GET",
                data: { query: query },
                success: function(data) {
                    $('#search-results').html(data);
                }
            });
        });
    });
</script>

<script>
    $(function(e){
    $("#select_all").click(function(){
      $('.checkboxx').prop('checked',$(this).prop('checked'));
    });

    $("#sendSms").click(function(e){
       e.preventDefault();
       var all_ids =[];

       $('input:checkbox[name=ids]:checked').each(function(){
        all_ids.push($(this).val());
       });

       $("#var1").val(all_ids);
       if(all_ids == ''){
            alert("please select atleast one parents");
           }
         else{
          $("#smsForm").submit();
           }
    });

  });
</script>
