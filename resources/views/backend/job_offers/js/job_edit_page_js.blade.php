<script>


$('body').attr("style", "overflow:auto")


$(document).on('hidden.bs.modal', '#modal_2',function () {
       $('##additionalChildModal').css('overflowY','auto')
});

$(function () {
        $("#updateAdditionalChildForm_{{$item->id ?? ''}}").on("submit", function (event) {
            event.preventDefault();

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
                      console.log(data);

                    if (data.status == false) {
                        console.log("hi");
                        $.each(data.error, function (prefix, val) {
                            $("span." + prefix + "_error").text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "data Updated successfully",
                            showConfirmButton: false,
                            timer: 1500,
                        });

                        $("#updateAdditionalChildForm")[0].reset();
                        // $("#category_id_2").html("");
                        // $("#course_id_2").html("");
                        // $("#subject_id_2").html("");
                          $(".modal-backdrop").remove();
                         $("#additionalChildModal").hide();
                         $('body').attr("style", "overflow:auto")


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



$(function () {
        $("#updateJobOffer").on("submit", function (e) {
            e.preventDefault();


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
                        console.log(data);
                        if (data.status == false) {
                            console.log("hi");
                            $.each(data.error, function (prefix, val) {
                                $("span." + prefix + "_error").text(val[0]);
                            });
                        }

                        if (data.status == true) {
                            console.log(data.job);
                            $("#updateJobOffer")[0].reset();

                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "job updated successfully",
                                showConfirmButton: false,
                                timer: 1500,
                            });

                            $("#additionalChildModal").hide();
                            $("#additionalChildModal").css('display:', 'none')




                            window.location.href="/admin/job-offer/all-offer" ;


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

               $('#country_id').select2({
                width: 'resolve'
            });
            $('#city_id').select2();
            $('#location_id').select2();
            $('#category_id').select2();
            $('#course_id').select2();
            $('#subject_id').select2();
            $("#tutor_university_id").select2();
           $("#tutor_university_type_id").select2();
           $("#tutor_study_type_id").select2();
           $("#tutor_department_id").select2();
           $("#tutor_school_id").select2();
           $("#tutor_college_id").select2();
           $('#tutoring_category_id').select2();
           $('#tutor_course_id').select2();
           $('#tutor_subject_id').select2();
           $('#category_id_2').select2();
           $('#course_id_2').select2();
           $('#subject_id_2').select2();


    const prevCategory=$('#category_id').val();
    const prevCourse=$('#course_id').val();
    const prevSubject=$('#subject_id').val();

    const tPrevCategory= $('#tutoring_category_id').val();
    const tPrevCourse=$('#tutor_course_id').val();
    const tPrevSubject=$('#tutor_subject_id').val();

    const acPrevCategory=$('#category_id_2').val();
    const acPrevCourse=$('#course_id_2').val();
    const acPrevSubject=$('#subject_id_2').val();



    console.log(tPrevCategory);
    console.log(tPrevCourse);
    console.log(tPrevSubject);

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



// get city


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
             console.log(category_id);
                $.ajax({
                    url:'{{route("get_class_course")}}',
                    type:'post',
                    data:{ category_id:category_id},
                    success:function (result){

                        $("#course_id").html(result);
                        if(prevCategory==category_id){
                            $('#course_id').val(prevCourse).change();
                        }
                        else
                        $('#course_id').val(prevCourse).change();
                        // $("#subject_id").val(null).trigger('change');
                    }

                });
        });


        $('#course_id').change(function (){
            let course_id = $(this).val();
                $.ajax({
                    url:'{{route("get_course_subject")}}',
                    type:'post',
                    data:{ course_id:course_id},
                    success:function (result){
                         $('#subject_id').html(result)
                         if(prevCourse==course_id){
                            // $("#subject_id").val(prevSubject).trigger('change');
                            $('#subject_id').val(prevSubject).change();
                         }
                         else{
                         $("#subject_id").val(null).trigger('change');
                         }


                    }

                });
        });




        // additional child add modal category


        $('#category_id_2').change(function (){
            let category_id = $(this).val();
                $.ajax({
                    url:'{{route("get_class_course")}}',
                    type:'post',
                    data:{ category_id:category_id},
                    success:function (result){
                        $('#course_id_2').html(result);

                        $("#course_id_2").html(result);
                        if(acPrevCategory==category_id){
                            $('#course_id_2').val(acPrevCourse).change();
                        }
                        else
                        $('#course_id_2').val(acPrevCourse).change();


                    }

                });
        });


        $('#course_id_2').change(function (){
            let course_id = $(this).val();
                $.ajax({
                    url:'{{route("get_course_subject")}}',
                    type:'post',
                    data:{ course_id:course_id},
                    success:function (result){
                         $('#subject_id_2').html(result)

                         if(acPrevCourse==course_id){
                            // $("#subject_id").val(prevSubject).trigger('change');
                            $('#subject_id_2').val(acPrevSubject).change();
                         }
                         else{
                         $("#subject_id_2").val(null).trigger('change');
                         }

                    }

                });
        });



         // .............................Start Tutoring Category and course and subject............



        $('#tutoring_category_id').change(function (){
            let category_id = $(this).val();
                $.ajax({
                    url:'{{route("get_class_course")}}',
                    type:'post',
                    data:{ category_id:category_id},
                    success:function (result){
                        $('#tutor_course_id').html(result);

                        if(tPrevCategory==category_id){
                            $('#tutor_course_id').val(tPrevCourse).change();
                        }
                        else
                        $('#tutor_course_id').val(tPrevCourse).change();
                        // $("#subject_id").val(null).trigger('change');




                    }

                });
        });



        $('#tutor_course_id').change(function (){
            let tcourse_id = $(this).val();
                $.ajax({
                    url:'{{route("get_course_subject")}}',
                    type:'post',
                    data:{ course_id:tcourse_id},
                    success:function (result){
                         $('#tutor_subject_id').html(result)

                         if(tPrevCourse == tcourse_id){
                            // $("#tutor_subject_id").val(tPrevSubject).trigger('change');
                            $("#tutor_subject_id").val(tPrevSubject).change();
                         }
                         else{
                            $("#tutor_subject_id").val(tPrevSubject).change();
                         }

                    }

                });
        });

           // .............................tutor university,school,study ,Department select2............



});



        function initMap(lat, lng) {
            // console.log(lat, lng);

            var coord = { lat: lat, lng: lng };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: coord,
            });

            new google.maps.Marker({
                position: coord,
                map: map,
            });
        }

        $(document).ready(function () {
            let coordinates = $('#lat_long').val();
            let [lat, lng] = coordinates.split(', ').map(parseFloat);

            // console.log("Latitude:", lat);
            // console.log("Longitude:", lng);

            initMap(lat, lng);

            var autocomplete;
            var id = 'lat_long';

            autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
                types: ['geocode'],
            });
        });




</script>
