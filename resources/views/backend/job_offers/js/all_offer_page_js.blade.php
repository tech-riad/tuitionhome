<script>
    // $(document).ready(function () {
    //   $(".owl-carousel").owlCarousel({
    //     loop: true,
    //     autoplay: true,
    //     autoplayTimeout: 1500,
    //     autoplayHoverPause: true,
    //     autoplaySpeed: 1000,
    //     margin: 10,
    //     responsiveClass: true,
    //     nav: true,
    //     navText: [
    //       "<i class='bi bi-chevron-right arrow-icon'></i>",
    //       "<i class='bi bi-chevron-left arrow-icon'></i>",
    //     ],
    //     navClass: ["carousel-nav-btn-prev", "carousel-nav-btn-next"],
    //     responsive: {
    //       0: {
    //         items: 1,
    //         nav: true,
    //         loop: true,
    //       },
    //       600: {
    //         items: 2,
    //         loop: true,
    //       },
    //       1000: {
    //         items: 4,
    //         nav: true,
    //         loop: true,
    //       },
    //     },
    //   });
    // });


    $('#exampleModal2').on('show', function(e) {
    var link     = e.relatedTarget(),
        modal    = $(this),
        time = link.data("time"),
        email    = link.data("email");

        $('#time').text(time);

});


 function action(id){

    $('#actionModal').modal('show');
    $('#job_id').val(id);

    $('#sms_job_id').val(id);

    // console.log(id);



}







async function searchTutor(id) {
  $('#sms_job_id').val(id);

  $(".modal-backdrop").remove();
  $(".modal.fade.show").hide();
  $('body').attr("style", "overflow:auto");
  $('#actionModal').hide();
  $('#actionModal').modal('hide');
  $("#SearchTutorModal").modal('show');

  $.ajax({
    url: "{{ route('admin.job.search-tutor') }}",
    type: 'post',
    data: {
      'job_id': id,
      '_token': '{{ csrf_token() }}'
    },
    beforeSend: function () {
      $('#tutorsDiv').html('');
    },
    success: function (response) {
      let tutors = response.tutors;
      let tutorSmsArray = Array.isArray(response.tutor_sms) ? response.tutor_sms : [];

      console.log('tutorSmsArray:', tutorSmsArray);  // Debugging log

      if (response.all_sms_number) {
        $('#SendSmsCount').html('<p class="p-0 m-0">' + response.all_sms_number + '</p>');
      }

      if (response.count !== null) {
        $('#countingAll').html('<p style="color: red;">' + response.count + '</p>');
      }

      if (response.status == false) {
        $('#tutorsDiv').html('<p style="color: red;">Tutors Not Found</p>');
        return;
      }

      let html = '';

      for (let i = 0; i < tutors.length; i++) {
        const phoneNumber = tutors[i].tutor_phone ?? tutors[i].phone;
        const isTutorInSmsList = tutorSmsArray.includes(phoneNumber);

        html += `
          <div class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3">
            <div>
              <p class="text-info mb-0 fw-semibold">
                <a href="{{ url('/admin/tutor/get-tutor') }}/${tutors[i].tutor_id}">
                  ${tutors[i].tutor_name ? tutors[i].tutor_name.substring(0, 20) : ''}
                </a>
                ${tutors[i].is_verified == 1 ? '<i class="bi bi-patch-check ms-1"></i>' : ''}
                ${tutors[i].is_premium == 1 ? '<i class="bi bi-star-fill ms-1 text-warning"></i>' : ''}
              </p>
              <p class="mb-0 text-muted">${tutors[i].tutor_education ? tutors[i].tutor_education.substring(0, 25) : ''}</p>
              <p class="mb-0 text-muted"><b>${tutors[i].tutor_dept ? tutors[i].tutor_dept.substring(0, 25) : ''}</b></p>
              <div class="d-flex gap-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-gray-500"></i>
                <i class="bi bi-star-fill text-gray-500"></i>
              </div>
            </div>
            <div>
              <p class="text-muted mb-0">${tutors[i].tutor_location ? tutors[i].tutor_location.substring(0, 15) : ''}</p>
              <p class="text-muted mb-0"><b>${tutors[i].tutor_city ? tutors[i].tutor_city.substring(0, 15) : ''}</b></p>
            </div>
            <p id="match_rate${tutors[i].tutor_id}">
              ${matchingRateBs(response.job_id, tutors[i].tutor_id)}
            </p>
          </div>
        `;
      }

      $('#tutorsDiv').html(html);
    },
    error: function (xhr) {
      console.error(xhr.responseText);
      alert('An error occurred. Please try again.');
    }
  });
}


function matchingRateBs(job_id, tutor_id) {
    var match_rate = 0;
    $.ajax({
        url: '{{ route("admin.job.match.rate") }}',
        type: 'post',
        data: {
            job_id: job_id,
            tutor_id: tutor_id,
        },
        success: function(responce) {
            $('#match_rate' + tutor_id).text(responce.count + '%');
            $('#match_rate' + tutor_id).text(responce.count + '%');
        },
    });
}






function classifyTutor(val) {
    let tutortype = $("#" + val).val();
    let job_id = $('#sms_job_id').val();

    $.ajax({
        url: "{{ route('admin.job.search-tutor') }}",
        type: 'post',
        data: {
            job_id: job_id,
            types: tutortype,
        },
        beforeSend: function () {
            $('#tutorsDiv').html('');
        },
        success: function (response) {
            let tutors = response.tutors;
            let tutorSmsArray = Array.isArray(response.tutor_sms) ? response.tutor_sms : [];

            if (response.status == false) {
                $('#tutorsDiv').html('<p style="color: red;">tutors Not Found</p>');
                return;
            }

            let html = '';

            for (let i = 0; i < tutors.length; i++) {
                const isTutorInSmsList = tutorSmsArray.includes(tutors[i].tutor_phone ?? tutors[i].phone);

                html += '<div class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3">';
                html += '<div class="">';
                html += '<p class="text-info mb-0 fw-semibold"><a href="{{ url('/admin/tutor/get-tutor') }}/' + tutors[i].tutor_id + '"> ' + (tutors[i].tutor_name ? tutors[i].tutor_name.substring(0, 25) : '') + '</a>';

                if (tutors[i].is_verified == 1) {
                    html += '<i class="bi bi-patch-check ms-1"></i>';
                }

                if (tutors[i].is_premium == 1) {
                    html += '<i class="bi bi-star-fill ms-1 text-warning"></i>';
                }

                html += '<p class="mb-0 text-muted">' + (tutors[i].tutor_education ? tutors[i].tutor_education.substring(0, 25) : '') + '</p>';
                html += '<p class="mb-0 text-muted"> <b> ' + (tutors[i].tutor_dept ? tutors[i].tutor_dept.substring(0, 25) : '') + ' </b> </p>';

                html += '<div class="d-flex gap-1">';
                html += '<i class="bi bi-star-fill text-warning"></i>';
                html += '<i class="bi bi-star-fill text-warning"></i>';
                html += '<i class="bi bi-star-fill text-warning"></i>';
                html += '<i class="bi bi-star-fill text-gray-500"></i>';
                html += '<i class="bi bi-star-fill text-gray-500"></i>';
                html += '</div>';
                html += '</div>';

                html += '<div>';
                html += '<p class="text-muted mb-0">' + (tutors[i].tutor_location ? tutors[i].tutor_location.substring(0, 15) : '') + '</p> ';
                html += '<p class="text-muted mb-0"> <b> ' + (tutors[i].tutor_city ? tutors[i].tutor_city.substring(0, 15) : '') + ' </b> </p>';
                html += '</div>';

                html += '<p id="match_rate' + tutors[i].tutor_id + '">' + matchingRateBs(response.job_id, tutors[i].tutor_id) + '</p>';

                if (response.requestType !== "All_tutor") {
                    html += '<div class="checkbox-wrapper-13">';
                    html += '<input class="checkboxxx" type="checkbox" name="t_ids" id="' + tutors[i].tutor_id + '" value="' + tutors[i].tutor_id + '" ' + (isTutorInSmsList ? '' : 'checked') + ' />';
                    html += '</div>';
                }

                html += '</div>';
            }

            $('#tutorsDiv').html(html);
        }
    });
}




function selectAllTutor(){

  $('.checkboxxx').prop('checked',$(this).prop('checked'));





}


$(function(e){
    $("#selectAllTutor").click(function(){
      $('.checkboxxx').prop('checked',$(this).prop('checked'));
    });


    $("#tutorSendSms").click(function(e){
       e.preventDefault();
       var all_t_ids =[];

       $('input:checkbox[name=t_ids]:checked').each(function(){
        all_t_ids.push($(this).val());
       });

       $("#all_t_ids").val(all_t_ids);
       console.log(all_t_ids);
       if(all_t_ids == ''){
            alert("please select atleast one tutor first");
           }
         else{
          $("#tutorSendSms").submit();
           }

    });

  });

  function dateTime(dateTime){

    let xx = dateTime;
    const myArray = xx.split(" ");

    let date = new Date(myArray[0]);
    let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
    let month = new Intl.DateTimeFormat('en', { month: 'short' }).format(date);
    let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);


    let time = myArray[1];

    console.log(time);


    var hour = parseInt(time.split(":")[0]) % 12;
    var timeInAmPm = (hour == 0 ? "12": hour ) + ":" + time.split(":")[1] + " " + (parseInt(parseInt(time.split(":")[0]) / 12) < 1 ? "am" : "pm");

    $("#date").text(`${day} ${month} ${year}`);
    $("#time").text(timeInAmPm);




  }


  function liveChange(id){



    var isChecked = $(".checkbox").is(":checked");
            var newState = isChecked ? 1 : 0; // Toggle the state
            // var id = $(this).data('id');
            // Make an AJAX request to update the state on the server
            $.ajax({
                url: "{{ route('admin.job_offers.status')}}",
                type: "POST",
                data: { state: newState,id:id },
                success: function (response) {
                    if (response.status === "success") {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                        location.reload(1500)
                    }
                },
                error: function (xhr, status, error) {
                    // Handle errors
                }
            });


  }


    //   $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $(document).ready(function () {
    //     $("#button-check").click(function () {
    //         var isChecked = $(".checkbox").is(":checked");
    //         var newState = isChecked ? 1 : 0; // Toggle the state
    //         var id = $(this).data('id');
    //         // Make an AJAX request to update the state on the server
    //         $.ajax({
    //             url: "{{ route('admin.job_offers.status')}}",
    //             type: "POST",
    //             data: { state: newState,id:id },
    //             success: function (response) {
    //                 toastr.success(response.message);
    //             },
    //             error: function (xhr, status, error) {
    //                 // Handle errors
    //             }
    //         });
    //     });
    // });





    $(document).ready(function(){

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



// get city


// $('#country_id').select2();
$('#city_id').select2();
$('#location_id').select2();
$('#institute_id').select2();
// $('#ssc_institute_id').select2();
$('#department_id').select2();
$('#hsc_institute_id').select2();
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
                $.ajax({
                    url:'{{route("get_course_subject")}}',
                    type:'post',
                    data:{ course_id:course_id},
                    success:function (result){
                         $('#subject_id').html(result)

                    }

                });
        });

    });




    // let filter = {};
    // function inputChange(colname, id){

    //     filter[colname]=$("#"+id).val();

    //   var input = '';

    //   Object.entries(filter).forEach((entry,index) => {
    //       const [key, value] = entry;

    //       if(index==(Object.keys(filter).length-1)){
    //           input+= `${key}='${value}' `;
    //       }
    //       else{

    //           input+= `${key}='${value}' and `;
    //       }

    //   });

    //   $('#job_search').val(input);





    // }

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

    $('#job_search').val(input);
}






    $(document).ready(function () {
        $("#check-All").change(function () {
            var atLeastOneChecked = $(".check-row:checked").length > 0;
            $(".check-row").prop('checked', $(this).prop("checked"));

        });
        $(".check-row").change(function () {
            var atLeastOneChecked = $(".check-row:checked").length > 0;
            if (!$(this).prop("checked")) {

                $("#check-All").prop("checked", false);

            }

        });
        $('#sendBulkSmsApplicant').on('click', function (e) {
            e.preventDefault();
            var offer_id = $('.offer_id').val();

            var listingCheckedRows = $(".check-row:checked");
            var ListingSelectedData = [];
            listingCheckedRows.each(function () {
                var id = $(this).data("id");
                ListingSelectedData.push(id);
            });
            if (Object.keys(ListingSelectedData).length === 0) {

                toastr.warning('Opps! select at least one item.');
                return;
            }
            $('.job_id').val(offer_id);
            $('.tutor_id').val(ListingSelectedData);
            $('#bulkSmsForm').submit();
        });
    });

</script>
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
<script>
    $(document).ready(function () {
        $("#submitBtn").click(function () {
            var formData = {
                tutor_id: $("input[name='tutor_id']").val(),
                job_id: $("input[name='job_id']").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                type: "POST",
                url: "{{ route('admin.tutor.job.apply') }}",
                data: formData,
                success: function (response) {
                    console.log(response);
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        $("#exampleModal4").modal("hide");
                        location.reload();
                    } else if (response.status == 'error') {
                        toastr.warning(response.message, '', { timeOut: 300 });
                    } else if (response.status == 'tutor') {
                        toastr.warning(response.message, '', { timeOut: 300 });
                    } else if (response.status == 'job') {
                        toastr.warning(response.message, '', { timeOut: 300 });
                    } else if (response.status == 'alreadyApplied') {
                        toastr.warning(response.message, '', { timeOut: 300 });
                    }
                },
                error: function (error) {
                    console.error(error);
                    toastr.error('An error occurred. Please try again later.', '', { timeOut: 300 });
                }
            });
        });
    });




     function matchingRate(tdElement, job_id, tutor_id){


        var match_rate =0;
        // var job_id = 4444;
        // var tutor_id = 34223;


        $.ajax({
                url:'{{route("admin.job.match.rate")}}',
                type:'post',
                data: {
                        job_id:job_id,
                        tutor_id : tutor_id,
                    },
                     success:function (responce){

                        $(tdElement).text(responce.count+'%');

                        // $('#' + match_rate + tutor_id).text(response.count + '%');
                        $('#match_rate' + tutor_id).text(responce.count + '%');

                        $('#match_rate' + tutor_id).text(responce.count + '%');


                        // $(match_rate+'tutor_id').text(responce.count+'%');


                        // match_rate = responce;
                        // match_rate = responce.count;
                        // console.log(match_rate);
                }


            });


            // return match_rate;


    }


    $(document).ready(function() {
    $('#application_table .count-cell').each(function() {
        var parameter = $(this).data('parameter');
        var parameter2 = $(this).data('parameter2');

        // console.log(parameter);

        matchingRate(this , parameter ,parameter2)
    });
});


</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('paginationLimit').addEventListener('change', function () {
            document.getElementById('paginationForm').submit();
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('#all_offer_paginationLimit').change(function() {
            $('#all_offer_paginationForm').submit();
        });
    });

    $("#sendSms").click(function(e){
       e.preventDefault();
       var all_ids =[];

       $('input:checkbox[name=ids]:checked').each(function(){
        all_ids.push($(this).val());
       });

       $("#var1").val(all_ids);
       if(all_ids == ''){
            alert("please select atleast one tutor");
           }
         else{
          $("#smsForm").submit();
           }
    });
</script>


<script>
    $(document).ready(function() {
        $("#select_all").click(function(){
        $('.checkboxx').prop('checked',$(this).prop('checked'));
        });
    });
</script>