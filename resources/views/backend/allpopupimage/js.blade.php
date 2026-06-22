<script>
    $(document).ready(function () {
        // Send Now Button
        $('#sendNowBtn').on('click', function () {
            $('#sendNow').val(1);
            submitPopupForm();
        });

        // Send Later Button in Modal

        function submitPopupForm() {
            const form = $('#smsForm')[0];
            const formData = new FormData(form);

            $.ajax({
                url: $('#smsForm').attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    // You can show a loader here
                },
                success: function (response) {
                    alert('Popup image sent successfully!');
                    // Reset form
                    $('#smsForm')[0].reset();
                    $('#preview').html('');
                },
                error: function (xhr) {
                    alert('Something went wrong. Please check your inputs.');
                    console.log(xhr.responseText);
                }
            });
        }
    });
</script>


<script>
    function liveChange(id) {
        var isChecked = $("#button-check[data-id='" + id + "'] .checkbox").is(":checked");
        var newStatus = isChecked ? 1 : 0;

        $('#loading-spinner').show();

        $.ajax({
            url: "{{ route('admin.item.status.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                status: newStatus // ✅ fixed here
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'Status updated.');
                } else {
                    toastr.error(response.message || 'Update failed.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Something went wrong!');
            },
            complete: function() {
                $('#loading-spinner').hide();
            }
        });
    }
</script>



<script>
    $(document).on('click', '.deletePopup', function(e) {
        e.preventDefault();
        var noticeId = $(this).data('id');

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
                $.ajax({
                    url: "{{ route('admin.item.popup.delete', '') }}/" + noticeId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Oops!',
                            'Something went wrong!',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>


