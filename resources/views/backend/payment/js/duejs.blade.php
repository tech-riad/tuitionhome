    <script>
        $(document).ready(function() {
            $('.due-verify-button').click(function() {
                var button = $(this);
                var itemId = button.data('id');

                $.ajax({
                    url: '/admin/payment/verify-due-payment',  // Your verification route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',  // CSRF token for security
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

                            // Optionally, you can change the button appearance here
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

    {{-- Due Note --}}
    <script>
        $(document).ready(function() {
            $('.due-note').click(function() {
                var itemId = $(this).attr('id');
                $('#itemId').val(itemId);

                $('#noteTitle').val('');
                $('#noteDetails').val('');
            });

            $('#btnDueSaveNote').click(function() {
                var formData = {
                    _token: '{{ csrf_token() }}',
                    item_id: $('#itemId').val(),
                    note_title: $('#noteTitle').val(),
                    note_details: $('#noteDetails').val()
                };

                $.ajax({
                    url: '/admin/due/note-create',
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
                            console.log(response);
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
                url: '/admin/due/note-details/' + itemId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#noteModalBody').html(response.html); // Update modal body with fetched HTML
                    $('#noteModal').modal('show'); // Show the modal
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

        // Convert the date format if necessary
        const dateValue = filter[colname].replace(/-/g, '');

        Object.entries(filter).forEach((entry, index) => {
            const [key, value] = entry;

            if (index == (Object.keys(filter).length - 1)) {
                input += `${key}='${value}' `;
            } else {
                input += `${key}='${value}' and `;
            }
        });

        $('#due_filter').val(input);
        $('#due_filter_pending_date').val(input);
        }
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

