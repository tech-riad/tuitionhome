<script>



let is_parent = '' ;

    function parentSearch(phone) {
        var route = '{{ route("parentSearch") }}';

            var input = $("#parentsSearch").val();

        if(phone){
            var input = phone;
        }

        $.ajax({
            type: "GET",
            url: route,
            data: {
                input: input,
            },
            success: function (response) {
                var parent = response.parent[0];

                if (parent == null) {
                    notFoundHtml ='<b id="displayError" style="color:red;" class="derger">Parent not found</b>';
                    // $("#parentFound").html("");
                    $("#parentNotFound").html(notFoundHtml);

                } else if (parent.parents_personal_info == null) {

                    this.is_parent = parent.id;
                    $("#displayError").html("");

                    html =
                    '<img src="" ' +
                    'alt="map" class="img-fluid rounded-circle mb-3 shadow-lg" ' +
                    'style="width: 40px; height: 40px;" />' +
                    '<div>' +
                    '<p class="fw-semibold mb-0">' +
                    parent.name +
                    ' <i class="fas fa-circle" style="color:' +
                    (parent.is_active == 0 ? '#f5422a' : '#34f52a') +
                    ';"></i></p>' +
                    '</div>';

                    $("#parentFound").html(html);
                    $("#parent_id").val(parent.id);
                    $("#guardian_id").text("ID:" + parent.id);
                    $("#reference_parent_id").val(parent.id);
                    $("#add_child_parent_id").val(parent.id);
                    $("#special_note").val(parent.condition_note);


                    var parent_note = parent.parents_note

                    let notesHtml = '';

                    const latestNotes = parent.parents_note
                        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                        .slice(0, 2);

                    latestNotes.forEach((parent_note) => {
                        const date = new Date(parent_note.created_at).toLocaleString('en-US', {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });
                        notesHtml += `
                            <div class="mb-4 border-bottom border-2">
                                <div class="bg-light rounded-3 p-3 my-3" style="height: 150px; overflow-y: scroll">
                                    ${parent_note.body}
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <img src="" alt="map" class="img-fluid rounded-3 mb-3 shadow-lg" style="width: 40px; height: 40px" />
                                        <div>
                                            <p class="fw-semibold mb-0">${parent_note.created_by}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0" style="font-size: 12px">Employee ID- ${parent_note.emp_id}</p>
                                        <p class="text-muted" style="font-size: 12px">${date}</p>
                                    </div>
                                </div>
                            </div>`;
                    });
                    document.getElementById('parentNote').innerHTML = notesHtml;


                } else {
                    var parents_personal_info = parent.parents_personal_info
                    var parent_note = parent.parents_note

                    this.is_parent = parent.id;
                    $("#displayError").html("");

                    html =
                    '<img src="" ' +
                    'alt="map" class="img-fluid rounded-circle mb-3 shadow-lg" ' +
                    'style="width: 40px; height: 40px;" />' +
                    '<div>' +
                    '<p class="fw-semibold mb-0">' +
                    parent.name +
                    ' <i class="fas fa-circle" style="color:' +
                    (parent.is_active == 0 ? '#f5422a' : '#34f52a') +
                    ';"></i></p>' +
                    '</div>';


                    let notesHtml = '';

                    const latestNotes = parent.parents_note
                        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                        .slice(0, 2);

                    latestNotes.forEach((parent_note) => {
                        const date = new Date(parent_note.created_at).toLocaleString('en-US', {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });
                        notesHtml += `
                            <div class="mb-4 border-bottom border-2">
                                <div class="bg-light rounded-3 p-3 my-3" style="height: 150px; overflow-y: scroll">
                                    ${parent_note.body}
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <img src="" alt="map" class="img-fluid rounded-3 mb-3 shadow-lg" style="width: 40px; height: 40px" />
                                        <div>
                                            <p class="fw-semibold mb-0">${parent_note.created_by}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0" style="font-size: 12px">Employee ID- ${parent_note.emp_id}</p>
                                        <p class="text-muted" style="font-size: 12px">${date}</p>
                                    </div>
                                </div>
                            </div>`;
                    });
                    document.getElementById('parentNote').innerHTML = notesHtml;

                    // const countJob = parent.job_offer_count;
                    // const countHtml = `${countJob}`;
                    // console.log(countHtml);



                    const link = document.getElementById('currentPendingLink');
                    link.href = `{{ url('admin/parent-job-status/') }}/${parent.id}`;

                    const countSpan = document.getElementById('count');
                    countSpan.textContent = parent.job_offer_count;

                    // $("#count").html(countHtml);
                    $("#parentFound").html(html);
                    $("#parent_id").val(parent.id);
                    $("#special_note").val(parent.condition_note);
                    $("#full_address").val(
                        parents_personal_info.address_details
                    );
                    $("#institute_name").val(
                        parents_personal_info.institute_name
                    );
                    $("#city_id").val(parents_personal_info.city_id);
                    $("#country_id").val(parents_personal_info.country_id);
                    $("#location_id").val(parents_personal_info.location_id);
                    $("#guardian_id").text("ID:" + parent.id);
                    $("#reference_parent_id").val(parent.id);
                    $("#add_child_parent_id").val(parent.id);

                    //  category_id
                }
            },
        });
    }

    function referenceSearch() {
        var route = '{{ route("reference_search") }}';
        var input = $("#referenceSearch").val();

        $.ajax({
            type: "get",
            url: route,
            data: {
                input: input,
            },
            success: function (response) {
                // console.log(response);
                if (response.data == "") {
                    notFoundHtml =
                        '<b id="displayError" style="color:red;" class="derger">reference not found</b>';
                    $("#referenceFound").html("");

                    $("#referenceNotFound").html(notFoundHtml);
                } else {
                    $("#displayError").html("");

                    html =
                        '<img src=""\
                                alt="map" class="img-fluid rounded-circle mb-3 shadow-lg"\
                                style="width: 40px; height: 40px" />\
                            <div>\
                                <p class="fw-semibold mb-0">' +
                        response.data[0].name +
                        '</p>\
                                <p class="text-muted" style="font-size: 12px">\
                                    Class-10,' +
                        response.data[0].location +
                        " \
                                </p>\
                            </div>";

                    $("#referenceFound").html(html);

                    $("#reference_id").val(response.data[0].id);
                }
            },
        });
    }

    function addAdditionalChild() {
        var x = document.getElementById("additionalChild1.1");
        var y = document.getElementById("additionalChild1.2");

        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

        if (y.style.display === "none") {
            y.style.display = "block";
        } else {
            y.style.display = "none";
        }
    }

    $(function () {
        $("#createJobOffer").on("submit", function (e) {
            e.preventDefault();

            var xxx = $("#parent_id").val();
            var parent_lead_id = $("#parent_lead_id").val();
            var parent_fnf_lead_id = $("#parent_fnf_lead_id").val();
            var hire_date = $("#hire_date").val();
            var formData = new FormData(this);



            formData.append("parent_id", xxx);


            if (xxx == "") {
                alert("pleace select one parent first");
            }
                $.ajax({
                    url: $(this).attr("action"),

                    method: $(this).attr("method"),
                    hire_date: hire_date,
                    data: formData,
                    processData: false,
                    datatype: JSON,
                    contentType: false,
                    beforeSend: function () {
                        $(document).find("span.error-text").text("");
                    },





                    success: function (data) {

                        if (data.status == false) {
                            $.each(data.error, function (prefix, val) {
                                $("span." + prefix + "_error").text(val[0]);
                            });
                        }

                        if (data.status == true) {
                            $("#createJobOffer")[0].reset();

                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "job created successfully",
                                showConfirmButton: false,
                                timer: 1500,
                            });

                            $("#createJobOffer")[0].reset();
                            $("#category_id").html("");
                            $("#course_id").html("");
                            $("#subject_id").html("");
                            $("#category_id_2").html("");
                            $("#course_id_2").html("");
                            $("#subject_id_2").html("");
                            $("#tutoring_category_id").html("");
                            $("#tutor_course_id").html("");
                            $("#tutor_subject_id").html("");
                            $("#tutor_university_id").html("");
                            $("#tutor_study_type_id").html("");
                            $("#tutor_department_id").html("");




                        }
                    },
                    error: function (err) {

                        let error = err.responseJSON;
                    },
                });

        });
    });

    $(function () {
        $("#addParentForm").on("submit", function (event) {

            event.preventDefault();

            var parent_phone = $("#parent_phonenumber").val();

            // parent register

            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                beforeSend: function () {
                    $(document).find("span.error-text").text("");
                },

                success: function (data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "parent added successfully",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        $("#addParentForm")[0].reset();
                        // $("#exampleModal2").modal("toggle");
                        $(".modal-backdrop").remove();
                        // $('body').removeClass('modal-open');
                        $(".modal.fade.show").hide();
                        $('body').attr("style", "overflow:auto");

                        parentSearch(parent_phone);




                        // window.location.reload();

                    } else {
                        $.each(data.error, function (prefix, val) {
                            $("span." + prefix + "_error").text(val[0]);
                        });
                    }
                },

                error: function (err) {
                    let error = err.responseJSON;
                    // console.log(error);
                },
            });
        });
    });



    $(function () {
        $("#addReferenceForm").on("submit", function (event) {
            event.preventDefault();

            var xxx = $("#reference_parent_id").val();
            if (xxx == "") {
                alert("pleace select one parent first");
            }
            // parent register
            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                beforeSend: function () {
                    $(document).find("span.error-text").text("");
                },
                success: function (data) {
                    if (data.status == false) {
                        $.each(data.error, function (prefix, val) {
                            $("span." + prefix + "_error").text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Reference added successfully",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        $("#addReferenceForm")[0].reset();
                        $("#exampleModal3").modal("hide");
                        $(".modal-backdrop").remove();
                        $('body').attr("style", "overflow:auto");
                    }
                },

                error: function (err) {
                    let error = err.responseJSON;
                    console.log(error);
                },
            });
        });
    });

    function refresh()
    {
        $("#addAdditionalChildForm")[0].reset();
    }
    $(function () {
        $("#addAdditionalChildForm").on("submit", function (event) {
            event.preventDefault();

            var xxx = $("#add_child_parent_id").val();
            if (xxx == "") {
                alert("pleace select one parent first");
            }

            // parent register

            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                beforeSend: function () {
                    $(document).find("span.error-text").text("");
                },

                success: function (data) {
                    // console.log(data);

                    if (data.status == false) {
                        console.log("hi");
                        $.each(data.error, function (prefix, val) {
                            $("span." + prefix + "_error").text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "data added successfully",
                            showConfirmButton: false,
                            timer: 1500,
                        });



                        $("#addAdditionalChildForm")[0].reset();
                        $("#course_id_2").html("");
                        $("#subject_id_2").html("");

                        // $("#additionalChildModal").modal("hide");
                        // window.location.reload();
                    }
                },

                error: function (err) {
                    let error = err.responseJSON;
                    console.log(error);
                },
            });
        });
    });




$(document).ready(function(){

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



    // get city

    $('#country_id').select2({
        width: 'resolve'
    });
    $('#city_id').select2();
    $('#location_id').select2();
    $('#category_id').select2();
    $('#course_id').select2();
    $('#subject_id').select2();
    $('#country_id').change(function (){
                let c_id = $(this).val();
                $.ajax({
                    url:'{{route("get_city")}}',
                    type:'post',
                    data:'c_id='+c_id+'&_token={{ csrf_token() }}',
                    success:function (result){
                        $('#city_id').html(result);
                    }


                });
            });

              // get location
              $('#city_id').change(function (){
                let city_id = $(this).val();
                $.ajax({
                    url:'{{route("get_location")}}',
                    type:'post',
                    data:'city_id='+city_id+'&_token={{ csrf_token() }}',
                    success:function (result){
                        $('#location_id').html(result);
                    }


                });
            });


        // .............................Start get Category and course...........................

                $('#category_id').change(function (){
                let category_id = $(this).val();

                    $("#course_id").html("");
                    $("#subject_id").html("");
                // console.log(category_id);
                    $.ajax({
                        url:'{{route("get_class_course")}}',
                        type:'post',
                        data:{ category_id:category_id},
                        success:function (result){
                         $("#course_id").html(result);

                        }

                    });
            });


            $('#course_id').change(function (){
                let course_id = $(this).val();
                $("#subject_id").html("");

                    $.ajax({
                        url:'{{route("get_course_subject")}}',
                        type:'post',
                        data:{ course_id:course_id},
                        success:function (result){
                             $('#subject_id').html(result)

                        }

                    });
            });

            // additional child add modal category

            $('#category_id_2').select2();
            $('#course_id_2').select2();
            $('#subject_id_2').select2();

            $('#category_id_2').change(function (){
                let category_id = $(this).val();

                   $("#course_id_2").html("");
                    $("#subject_id_2").html("");
                    $.ajax({
                        url:'{{route("get_class_course")}}',
                        type:'post',
                        data:{ category_id:category_id},
                        success:function (result){
                            $('#course_id_2').html(result);


                        }

                    });
            });


            $('#course_id_2').change(function (){
                let course_id = $(this).val();
                $("#subject_id_2").html("");

                $('#subject_id_2').select2();

                    $.ajax({
                        url:'{{route("get_course_subject")}}',
                        type:'post',
                        data:{ course_id:course_id},
                        success:function (result){
                             $('#subject_id_2').html(result)

                        }

                    });
            });


             // .............................Start Tutoring Category and course and subject............
             $('#tutoring_category_id').select2();
            $('#tutor_course_id').select2();
            $('#tutor_subject_id').select2();

            $('#tutoring_category_id').change(function (){
                let category_id = $(this).val();

                $("#tutor_course_id").html("");
                $("#tutor_subject_id").html("");

                    $.ajax({
                        url:'{{route("get_class_course")}}',
                        type:'post',
                        data:{ category_id:category_id},
                        success:function (result){
                            $('#tutor_course_id').html(result);


                        }

                    });
            });


        $('#tutor_course_id').change(function () {
            let course_id = $(this).val();
            $("#tutor_subject_id").html("");

            $.ajax({
                url: '{{route("get_course_subject")}}',
                type: 'post',
                data: {
                    course_id: course_id
                },
                success: function (result) {
                    $('#tutor_subject_id').html(result)

                }

            });
        });

        // .............................tutor university,school,study ,Department select2............

        $("#tutor_university_id").select2();
        $("#tutor_university_type_id").select2();
        $("#tutor_study_type_id").select2();
        $("#tutor_department_id").select2();
        $("#tutor_school_id").select2();
        $("#tutor_college_id").select2();


    });




    // function initMap(lat, long) {
    //     var coord = {
    //         lat: lat,
    //         lng: long
    //     };
    //     var map = new google.maps.Map(document.getElementById('map'), {
    //         zoom: 8,
    //         center: coord,
    //     });

    //     new google.maps.Marker({
    //         position: coord,
    //         map: map,
    //     });

    // }

    // initMap({
    //     {
    //         23.790485,
    //         90.352263
    //     }
    // })


    // $(document).ready(function () {

    //     var autocomplete;
    //     var id = 'lat_long';

    //     autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
    //         types: ['geocode'],
    //     })

    // })

</script>
