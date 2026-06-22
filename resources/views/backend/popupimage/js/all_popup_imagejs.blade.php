{{-- Filter Modal select --}}
<script>
    $(document).ready(function () {
        $("#userType").change(function () {
            var selectedUser = $(this).val();

            $(".modal").modal("hide");

            if (selectedUser === "tutor") {
                $("#filterTutorsModal").modal("show");
            } else if (selectedUser === "parent") {
                $("#filterParentsModal").modal("show");
            }
        });
        $("#filterTutorsModal, #filterParentsModal").on("hidden.bs.modal", function () {

        });

        $("#applyParentFilter, #clearParentFilter").on("click", function () {
            $("#filterParentsModal").modal("hide");
        });

        $("#applyTutorFilter, #clearTutorFilter").on("click", function () {
            $("#filterTutorsModal").modal("hide");
        });
    });
</script>




{{-- Apply group filter --}}
<script>
    $(document).ready(function () {
        $('#applyFilter').on('click', function () {
            let dateFrom = $('#datef').val();
            let dateTo = $('#datet').val();
            let country = $('#country_id').val();
            let city = $('#city_id').val();
            let location = $('#location_id').val();
            let method = $('#method_id').val();
            let category = $('#category_id').val();
            let course = $('#course_id').val();
            let subject = $('#subject_id').val();
            let study_type = $('#study_type_id').val();
            let ssc_curriculum = $('#ssc_curriculum_id').val();
            let university_type = $('#tutor_university_type').val();
            let institute = $('#institute_id').val();
            let department = $('#department_id').val();
            let selectedUser = $('#userType').val();


            $.ajax({
                url: "{{ route('admin.all.notice.tutor.filter') }}",
                method: "POST",
                data: {
                    date_from: dateFrom,
                    date_to: dateTo,
                    country_id: country,
                    city_id: city,
                    method_id: method,
                    location_id: location,
                    category_id: category,
                    course_id: course,
                    subject_id: subject,
                    study_type_id: study_type,
                    ssc_curriculum_id: ssc_curriculum,
                    tutor_university_type: university_type,
                    institute_id: institute,
                    department_id: department,
                    userType: selectedUser,

                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#audience').html('Audience: ' + response.count);


                        $('#usertype').val(selectedUser);
                        $('#query').val(response.raw_sql);
                        $('#filterTutorsModal').modal('hide');
                    } else {
                        alert('No numbers found');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Something went wrong! Check console for details.');
                }
            });
        });
    });

</script>


{{-- select Filter Option Select 2 --}}
<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function trimText(text, length = 20) {
            return text.length > length ? text.substring(0, length) + '...' : text;
        }

        function updateDropdown(selector, result) {
            $(selector).empty().append('<option selected value="">Select</option>');
            $(result).each(function () {
                let optionText = trimText($(this).text());
                let optionValue = $(this).val();
                $(selector).append(`<option value="${optionValue}">${optionText}</option>`);
            });

            $(selector).select2({
                width: '215px'
            });
        }

        $('#country_id, #country_id_2,#city_id,#city_id_2, #location_id,#location_id_2, #category_id, #course_id, #subject_id').select2({
            width: '215px'
        });
        $('#category_id_2, #course_id_2, #subject_id_2').select2({
            width: '215px'
        });
        $('#tutoring_category_id, #tutor_course_id, #tutor_subject_id').select2({
            width: '215px'
        });
        $('#tutor_university_id,#department_id, #tutor_university_type_id, #tutor_study_type_id, #tutor_department_id, #tutor_school_id, #tutor_college_id')
            .select2({
                width: '215px'
            });

        // Get City Tutor
        $('#country_id').change(function () {
            let c_id = $(this).val();
            $.ajax({
                url: '{{route("get_city")}}',
                type: 'post',
                data: {
                    c_id: c_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (result) {
                    updateDropdown('#city_id', result);
                }
            });
        });

        // Get Location Tutor
        $('#city_id').change(function () {
            let city_id = $(this).val();
            $.ajax({
                url: '{{route("get_location")}}',
                type: 'post',
                data: {
                    city_id: city_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (result) {
                    updateDropdown('#location_id', result);
                }
            });
        });
        // Get City Parent
        $('#country_id_2').change(function () {
            let c_id = $(this).val();
            $.ajax({
                url: '{{route("get_city")}}',
                type: 'post',
                data: {
                    c_id: c_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (result) {
                    updateDropdown('#city_id_2', result);
                }
            });
        });

        // Get Location Parent
        $('#city_id_2').change(function () {
            let city_id = $(this).val();
            $.ajax({
                url: '{{route("get_location")}}',
                type: 'post',
                data: {
                    city_id: city_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (result) {
                    updateDropdown('#location_id_2', result);
                }
            });
        });

        // Get Course by Category
        $('#category_id, #category_id_2, #tutoring_category_id').change(function () {
            let category_id = $(this).val();
            let courseSelector = $(this).attr('id') === 'tutoring_category_id' ? '#tutor_course_id' :
                ($(this).attr('id') === 'category_id_2' ? '#course_id_2' : '#course_id');
            let subjectSelector = $(this).attr('id') === 'tutoring_category_id' ? '#tutor_subject_id' :
                ($(this).attr('id') === 'category_id_2' ? '#subject_id_2' : '#subject_id');

            $(courseSelector).html('');
            $(subjectSelector).html('');

            $.ajax({
                url: '{{route("get_class_course")}}',
                type: 'post',
                data: {
                    category_id: category_id
                },
                success: function (result) {
                    updateDropdown(courseSelector, result);
                }
            });
        });

        $('#course_id, #course_id_2, #tutor_course_id').change(function () {
            let course_id = $(this).val();
            let subjectSelector = $(this).attr('id') === 'tutor_course_id' ? '#tutor_subject_id' :
                ($(this).attr('id') === 'course_id_2' ? '#subject_id_2' : '#subject_id');

            $.ajax({
                url: '{{route("get_course_subject")}}',
                type: 'post',
                data: {
                    course_id: course_id
                },
                success: function (result) {
                    updateDropdown(subjectSelector, result);
                }
            });
        });

    });

</script>

{{-- Apply tutor Filter --}}
<script>
    $(document).ready(function() {
    $('#applyFilter').click(function() {
        let formData = {
            country_id: $('#country_id').val(),
            city_id: $('#city_id').val(),
            location_id: $('#location_id').val(),
            method_id: $('#method_id').val(),
            date_from: $('#datef').val(),
            date_to: $('#datet').val(),
            year: $('#year').val(),
            gender: $('#gender').val(),
            category_id: $('#category_id').val(),
            course_id: $('#course_id').val(),
            subject_id: $('#subject_id').val(),
            study_type_id: $('#study_type_id').val(),
            ssc_curriculum_id: $('#ssc_curriculum_id').val(),
            tutor_university_type: $('#tutor_university_type').val(),
            tutor_university_id: $('#tutor_university_id').val(),
            department_id: $('#department_id').val(),
        };

        $.ajax({
            url: "{{ route('admin.all.popup.tutor.filter') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                    if (response.status === 'success') {
                        $('#usertype').val(selectedUser);
                        $('#query').val(response.raw_sql);
                        $('#filterTutorsModal').modal('hide');
                    } else {
                        alert('No numbers found');
                    }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    $('#clearFilter').click(function() {
        $('#filterTutorsModal select, #filterTutorsModal input').val('');
    });
    });

</script>

{{-- Time --}}
<script>
    $(document).ready(function () {

        // Set hidden inputs for Send Now
        $("#sendNowBtn").on("click", function () {
            $("#sendNow").val("1"); // or true
            $("#sendLaterTime").val(""); // Clear any previous time
            submitPopupForm();
        });

        // Set hidden inputs for Send Later
        $("#sendLaterBtn").on("click", function () {
            const time = $("#sendLaterInput").val();
            if (!time) {
                alert("Please select a date & time.");
                return;
            }
            $("#sendNow").val(""); // Clear now
            $("#sendLaterTime").val(time); // Set the chosen time
            $("#sendModal").modal('hide');
            submitPopupForm();
        });

        function submitPopupForm() {
            let formData = new FormData($("#smsForm")[0]);

            $.ajax({
                url: "{{ route('admin.all.popup.tutor.send') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });
                    location.reload(1500);
                    $('#smsForm')[0].reset();
                },
                    error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("An error occurred. Please try again.");
                }
            });
        }
    });
</script>



{{-- Send Sms form  --}}
<script>
    $(document).ready(function() {
        $("#smsForm").on("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.all.popup.tutor.send') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                },
                success: function(response) {
                    if (response.success) {
                        alert("Popup sent successfully!");
                        $("#smsForm")[0].reset();
                    } else {
                        alert("Failed to send popup.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });


    function liveChange(id) {
        var isChecked = $("#button-check[data-id='" + id + "'] .checkbox").is(":checked");
        var newState = isChecked ? 1 : 0;

        $('#loading-spinner').show();

        $.ajax({
            url: "{{ route('admin.all.popup.tutor.send.status.change') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                state: newState
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                toastr.error('Something went wrong!');
            },
            complete: function() {
                // Hide spinner no matter what happens
                $('#loading-spinner').hide();
            }
        });
    }


</script>


{{-- Parent Filter All --}}

<script>
    $(document).ready(function () {
        $('#applyParentFilter').on('click', function () {
            let dateFrom = $('#datefp').val();
            let dateTo = $('#datetp').val();
            let selectedUser = $('#userType').val();
            let country = $('#country_id_2').val();
            let city = $('#city_id_2').val();
            let location = $('#location_id_2').val();
            let verified = $('#verified').val();
            $.ajax({
                url: "{{ route('admin.all.popup.parent.filter') }}",
                method: "POST",
                data: {
                    datefp: dateFrom,
                    datetp: dateTo,
                    userType: selectedUser,
                    country_id: country,
                    city_id: city,
                    verified: verified,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#audience').html('Audience: ' + response.count);


                        $('#usertype').val(selectedUser);
                        $('#query').val(response.raw_sql);

                        $('#filterParentsModal').modal('hide');
                    } else {
                        alert('No numbers found');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Error! Check console.');
                }
            });
        });

        $('#clearParentFilter').on('click', function () {
            $('#parentFilterForm')[0].reset();
        });
    });
</script>


{{-- Popup Plan Delete  --}}
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
                    url: "{{ route('admin.all.popup.delete', '') }}/" + noticeId,
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