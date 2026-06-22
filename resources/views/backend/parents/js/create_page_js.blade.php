<script>
    $(function () {

        $("#createForm").on('submit', function (e) {
            e.preventDefault();
            // parent register

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                beforeSend: function () {

                    $(document).find('span.error-text').text('');
                },

                success: function (data) {

                    if (data.status == false) {
                        $.each(data.error, function (prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        })
                    } else {

                        $('#createForm')[0].reset();
                        $("#myModal").modal('show');
                        $('#myModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
                        $('#parents_id').val(data.data.id);
                        console.log(data);
                        $("span.mobile-text b").text(data.data.otp);
                        // $('#phoneNumber').val(data.data.phone);


                    }
                }
            });


        });

    });


    $(function () {


        $("#otpForm").on('submit', function (e) {
            e.preventDefault();
            // parent phone otp validation

            var route = $(this).attr('action');

            console.log(route);
            $.ajax({
                url: route,
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                beforeSend: function () {

                    $(document).find('span.error-text').text('');
                },

                success: function (data) {

                    if (data.status == false) {

                        console.log(data.error);

                        $('span.otp_error').text(data.error.phone_otp);
                        $('span.otp_error2').text(data.error);

                    } else {

                        $('#otpForm')[0].reset();
                        $("#myModal").modal('hide');
                        Swal.fire(data.message);
                        $('#createForm')[0].reset();



                    }
                }
            });


        });





    });

</script>
