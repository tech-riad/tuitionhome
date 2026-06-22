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
{{-- Group Filter --}}

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

<script>
    $(document).ready(function () {
    $('#sendNowBtn').click(function () {
        $('#sendNow').val(1);
        $('#sendLaterTime').val('');
        submitForm();
    });

    $('#sendLaterBtn').click(function () {
        var sendLaterTime = $('#sendLaterInput').val();
        if (!sendLaterTime) {
            alert('Please select a valid date and time.');
            return;
        }
        $('#sendNow').val(0);
        $('#sendLaterTime').val(sendLaterTime);
        $('#sendModal').modal('hide');
        submitForm();
    });

    function submitForm() {
        $.ajax({
            url: $('#smsForm').attr('action'),
            type: 'POST',
            data: $('#smsForm').serialize(),
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
                alert('Something went wrong!');
            }
        });
    }
    });


    function liveChange(id) {
        var isChecked = $("#button-check[data-id='" + id + "'] .checkbox").is(":checked");
        var newState = isChecked ? 1 : 0;

        $("#loading-spinner").show(); // Show loading

        $.ajax({
            url: "{{ route('admin.all.notice.tutor.send.status.change') }}",
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
                $("#loading-spinner").hide(); // Always hide loading when request ends
            }
        });
    }



</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fields = [
            { id: "description", char: "char", rem: "rem", msg: "msg", message: "char-left-message" },
            { id: "description_unit", char: "char_unit", rem: "rem_unit", msg: "msg_unit", message: "char-left-message-unit" }
        ];

        fields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element) {
                element.addEventListener("input", function () {
                    count(this, field);
                });
            }
        });
    });

    function count(element, field) {
        const maxCharacters = 250;
        let text = element.value;
        let charCount = text.length;

        if (charCount > maxCharacters) {
            text = text.slice(0, maxCharacters);
            element.value = text;
            charCount = maxCharacters;
        }

        const remaining = maxCharacters - charCount;
        const msgCount = Math.ceil(charCount / 125);

        document.getElementById(field.char).textContent = `${charCount}/250`;
        document.getElementById(field.rem).textContent = remaining;
        document.getElementById(field.msg).textContent = msgCount;

        const messageElement = document.getElementById(field.message);
        if (remaining <= 20) {
            document.getElementById(field.rem).classList.add('text-danger');
            messageElement.textContent = `${remaining} characters left`;
        } else {
            document.getElementById(field.rem).classList.remove('text-danger');
            messageElement.textContent = '';
        }
    }
</script>



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
                url: "{{ route('admin.all.notice.parent.filter') }}",
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



<script>
    $(document).on('click', '.deleteNotice', function(e) {
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
                    url: "{{ route('admin.all.notice.delete', '') }}/" + noticeId,
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



{{-- Restore notice --}}
<script>
    $(document).on('click', '.restoreNotice', function(e) {
        e.preventDefault();
        var noticeId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will restore the notice!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.all.notice.restore', '') }}/" + noticeId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Restored!',
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const textarea = document.getElementById('edit_description');
        const charUnit = document.getElementById('edit_char_unit');
        const remUnit = document.getElementById('edit_rem_unit');
        const msgUnit = document.getElementById('edit_msg_unit');
        const warning = document.getElementById('edit-char-left-message-unit');
        const maxLength = 250;

        function updateCounter() {
            let value = textarea.value;

            if (value.length > maxLength) {
                value = value.substring(0, maxLength);
                textarea.value = value;
            }

            const length = value.length;
            const remaining = maxLength - length;
            const messages = Math.ceil(length / 160);

            charUnit.textContent = `${length}/${maxLength}`;
            remUnit.textContent = remaining;
            msgUnit.textContent = messages;

            if (remaining < 10) {
                warning.textContent = `Only ${remaining} characters left!`;
                warning.style.color = 'red';
            } else {
                warning.textContent = '';
                warning.style.color = '';
            }
        }

        // Initial count on load (optional)
        updateCounter();

        // Update on input
        textarea.addEventListener('input', updateCounter);
    });
</script>

<script>
    $(document).ready(function () {
        // Open Modal and load data
        $('.openEditModal').on('click', function () {
            let itemId = $(this).data('id');

            $.ajax({
                url: `/admin/marketting-plan/${itemId}/edit`,
                type: 'GET',
                success: function (response) {
                    $('#edit-id').val(response.id);
                    $('#edit-title').val(response.title);
                    $('#edit_description').val(response.description);
                    $('#editModal').modal('show');
                    updateCounter(response.description);
                },
                error: function () {
                    alert('Failed to fetch item data');
                }
            });
        });

        // Form submit via AJAX
        // Form submit via AJAX
        $('#editForm').submit(function (e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#editModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'The marketing plan has been updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Optionally reload or update the table/list
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function (xhr) {
                    $('.text-danger').text(''); // Clear previous errors

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.title) {
                            $('#title_error').text(errors.title[0]);
                        }
                        if (errors.description) {
                            $('#description_error').text(errors.description[0]);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please correct the highlighted fields.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again later.',
                        });
                    }
                }
            });
        });


        // Character Counter
        $('#edit_description').on('input', function () {
            updateCounter($(this).val());
        });

        function updateCounter(text) {
            let length = text.length;
            let remaining = 250 - length;
            let messageCount = Math.ceil(length / 160);

            $('#edit_char_unit').text(length + '/250');
            $('#edit_rem_unit').text(remaining);
            $('#edit_msg_unit').text(length === 0 ? 0 : messageCount);

            if (remaining < 10) {
                $('#edit-char-left-message-unit').text("Less than 10 characters remaining!");
            } else {
                $('#edit-char-left-message-unit').text("");
            }

            if (length > 250) {
                $('#edit_description').val(text.substring(0, 250));
            }
        }
    });
</script>