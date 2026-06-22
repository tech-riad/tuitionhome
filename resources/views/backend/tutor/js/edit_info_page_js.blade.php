<script>


$(function () {
    $('#certificateForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '{{ route("admin.tutor.updateCertificateFile") }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                } else {
                    var errors = response.error;
                    var errorMessage = '';

                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + '\n';
                    });

                    alert(errorMessage);
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
});





  $(function () {
        $("#updateSscEducationalInfo").on("submit", function (e) {
            e.preventDefault();
                $.ajax({
                    url: $(this).attr("action"),
                    method: $(this).attr("method"),
                    data: new FormData(this),
                    processData: false,
                    datatype: JSON,
                    contentType: false,
                    beforeSend: function () {
                        // $(document).find("span.error-text").text("");
                    },

                    success: function (data) {
                        if (data.status == false) {
                            console.log('hi');

                        }

                        if (data.status == true) {

                            if(data.message =='added Successfully!'){
                                Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Added Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            }

                            else{

                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Updated Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                        }

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
        $("#updateHscEducationalInfo").on("submit", function (e) {
            e.preventDefault();
                $.ajax({
                    url: $(this).attr("action"),
                    method: $(this).attr("method"),
                    data: new FormData(this),
                    processData: false,
                    datatype: JSON,
                    contentType: false,
                    beforeSend: function () {
                        // $(document).find("span.error-text").text("");
                    },

                    success: function (data) {
                        if (data.status == false) {
                            console.log(data);

                        }

                        if (data.status == true) {

                            if(data.message =='added Successfully!'){
                                Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Added Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            }

                            else{

                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Updated Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                        }

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
        $("#updateHonoursEducationalInfo").on("submit", function (e) {
            e.preventDefault();
                $.ajax({
                    url: $(this).attr("action"),
                    method: $(this).attr("method"),
                    data: new FormData(this),
                    processData: false,
                    datatype: JSON,
                    contentType: false,
                    beforeSend: function () {
                        // $(document).find("span.error-text").text("");
                    },

                    success: function (data) {
                        if (data.status == false) {
                            console.log('hi');

                        }

                        if (data.status == true) {

                            if(data.message =='added Successfully!'){
                                Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Added Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            }

                            else{

                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Updated Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                        }

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
        $("#updateMastersEducationalInfo").on("submit", function (e) {
            e.preventDefault();
                $.ajax({
                    url: $(this).attr("action"),
                    method: $(this).attr("method"),
                    data: new FormData(this),
                    processData: false,
                    datatype: JSON,
                    contentType: false,
                    beforeSend: function () {
                        // $(document).find("span.error-text").text("");
                    },

                    success: function (data) {
                        if (data.status == false) {
                            console.log('hi');

                        }

                        if (data.status == true) {

                            if(data.message =='added Successfully!'){
                                Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Added Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            }

                            else{

                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Updated Successfully!",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                        }

                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON;
                        console.log(error);
                    },
                });

        });
});










    function isDiploma(){

var x = document.getElementById("hscDiv");
if (x.style.display === "none") {
x.style.display = "block";
} else {
x.style.display = "none";
}


}


function isGraduation(){

var x = document.getElementById("postGraduationDiv");
if (x.style.display === "none") {
x.style.display = "block";
} else {
x.style.display = "none";
}


}

$(document).ready(function(){

    $('#post_gra_institute_id').select2();
    $('#gra_institute_id').select2();
    $('#ssc_institute_id').select2();
    $('#hsc_institute_id').select2();




});



$(document).ready(function(){

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



// get city

$('#countryy_id').select2();
$('#cityy_id').select2();
$('#locationn_id').select2();
$('#category_id').select2();
$('#course_id').select2();
$('#subject_id').select2();
$('#days_id').select2();
$('#tecahing_method_id').select2();
$('#p_locationn_id').select2();

const prevCategory=$('#category_id').val();
const prevCourse=$('#course_id').val();
const prevSubject=$('#subject_id').val();


$('#countryy_id').change(function (){
            let c_id = $(this).val();

            $("#locationn_id").html("");
            $("#p_locationn_id").html("");
            $("#cityy_id").html("");

            $.ajax({
                url:'{{route("get_city")}}',
                type:'post',
                data:'c_id='+c_id+'&_token={{ csrf_token() }}',
                success:function (result){
                    $('#cityy_id').html(result);
                }


            });
        });

          // get location
          $('#cityy_id').change(function (){
            let city_id = $(this).val();
            $("#locationn_id").html("");
            $("#p_locationn_id").html("");
            $.ajax({
                url:'{{route("get_location")}}',
                type:'post',
                data:'city_id='+city_id+'&_token={{ csrf_token() }}',
                success:function (result){
                    $('#locationn_id').html(result);
                    $('#p_locationn_id').html(result);

                }


            });
        });


    // .............................Start get Category and course...........................

            $('#category_id').change(function (){
            let category_id = $(this).val();
            // console.log(category_id);
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

    });


</script>
{{-- <script>
    // Fetch courses based on selected categories
    document.getElementById('category_id').addEventListener('change', function() {
        var categoryId = this.value;
        var courseSelect = document.getElementById('course_id');
        courseSelect.innerHTML = '<option value="">Select Course</option>';
        courseSelect.disabled = true;

        if (categoryId) {
            fetchCourses(categoryId);
        }
    });

    function fetchCourses(categoryId) {
        fetch('/courses/' + categoryId)
            .then(response => response.json())
            .then(data => {
                var courseSelect = document.getElementById('course_id');
                data.forEach(course => {
                    var option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.name + ' (' + course.category.name + ')';
                    courseSelect.appendChild(option);
                });
                courseSelect.disabled = false;
            })
            .catch(error => console.error('Error fetching courses:', error));
    }

    // Fetch subjects based on selected courses
    document.getElementById('course_id').addEventListener('change', function() {
        var courseIds = Array.from(this.selectedOptions).map(option => option.value);
        var subjectSelect = document.getElementById('subject_id');
        subjectSelect.innerHTML = '<option value="">Select Subject</option>';
        subjectSelect.disabled = true;

        if (courseIds.length > 0) {
            fetchSubjects(courseIds);
        }
    });

    function fetchSubjects(courseIds) {
        fetch('/subjects/' + courseIds.join(','))
            .then(response => response.json())
            .then(data => {
                var subjectSelect = document.getElementById('subject_id');
                data.forEach(subject => {
                    var option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.title + ' (' + subject.course.name + ' - ' + subject.course.category.name + ')';
                    subjectSelect.appendChild(option);
                });
                subjectSelect.disabled = false;
            })
            .catch(error => console.error('Error fetching subjects:', error));
    }
</script> --}}
