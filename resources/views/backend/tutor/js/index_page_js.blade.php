<script>




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
$('#ssc_institute_id').select2();
$('#department_id').select2();
$('#category_id').select2();
$('#hsc_institute_id').select2();
$('#pre_location_id').select2();

// $('#category_id').select2();
$('#course_id').select2();
// $('#subject_id').select2();
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
                    $('#pre_location_id').html(result);

                }


            });
        });


    // .............................Start get Category and course...........................




    });

    $(document).ready(function() {
    $('#category_id').change(function() {
        let category_id = $(this).val();
        $("#course_id").html("");
        $("#subject_id").html("");

        $.ajax({
            url: '{{ route("get_class_course") }}',
            type: 'post',
            data: { category_id: category_id },
            success: function(result) {
                $("#course_id").html(result);
            }
        });
    });

    $('#course_id').change(function() {
        let course_id = $(this).val();
        $("#subject_id").html("");

        $.ajax({
            url: '{{ route("get_course_subject") }}',
            type: 'post',
            data: { course_id: course_id },
            success: function(result) {
                $('#subject_id').html(result).select2(); // Initialize Select2 plugin
            }
        });
    });
});



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
            alert("please select atleast one tutor");
           }
         else{
          $("#smsForm").submit();
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

      var hour = parseInt(time.split(":")[0]) % 12;
      var timeInAmPm = (hour == 0 ? "12": hour ) + ":" + time.split(":")[1] + " " + (parseInt(parseInt(time.split(":")[0]) / 12) < 1 ? "am" : "pm");

      $("#date").text(`${day} ${month} ${year}`);
      $("#time").text(timeInAmPm);

      }


  function filterButton() {
    var x = document.getElementById("filter");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  };

  // var select_box_element = document.querySelector('#city');

  // dselect(select_box_element, {
  //   search :true,
  // });

//   $(document).ready(function() {
//     $('#filter select').chosen({
//       placeholder: 'select',
//       Height: "120%",
//       width: "100%",
//     });
// });


// function btnCreateNote(e){
//   var tutor_id = $("#tutor_id").val();
//    var note = $("#tutor_note").val();
//   var route = $("#tutor_note_create_route").val();
//   var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//   $.ajax({
//       url: route,
//       method: "post",
//       data: {
//           t_id:tutor_id,
//           t_note:note,
//       },
//       headers: {
//           'X-CSRF-TOKEN': csrfToken
//       },
//       success:function(response){

//         // $("body>#noteModal").remove();
//            $('#noteModal').hide();

//            Swal.fire({
//             position: 'top-end',
//             icon: 'success',
//             title: 'Your Note has been saved',
//             showConfirmButton: false,
//             timer: 1500
//           })

//                 $(".modal-backdrop").remove();
//                         //  $('body').removeClass('modal-open');
//                 // $(".modal.fade.show").hide();
//                 $('body').attr("style", "overflow:auto");

//            $('#tutor_data_table').load(location.href+' #tutor_data_table');
//           //  window.location.href = 'http://localhost/tuition%20terminal/project-tuitionterminal/public/admin/tutor';

//           // $('#dataTable').load(location.href+' #dataTable');
//       },
//       error:function(err){
//           let error = err.responseJSON;
//           $.each(error.errors,function(index, value){

//           })
//       }

//   })
//   //  alert('hi');
// }

function btnEdit(id){

var route = '{{ route("tutor.edit", ":id") }}';
route = route.replace(':id', id);
$.ajax({
  type: "GET",
  url: route,
  success:function(response){
     $('#tutor_id').val(response.tutor.id);
     $('#name').val(response.tutor.name);
     $('#email').val(response.tutor.email);
     $('#phone').val(response.tutor.phone);
     $('#gender').val(response.tutor.gender);
  }
});
}

function btnNote(id){

var route = '{{ route("admin.tutor.note", ":id") }}';
route = route.replace(':id', id);

$.ajax({
type: "GET",
url: route,
success:function(response){

  $('#tutor_note').val(response.tutor.condition_note);
  $('#tutor_name').text(response.tutor.name);
  $('#tutor_id').val(response.tutor.id);

}
});
}




// tutor note

// ==========================================
// TUTOR NOTE SYSTEM
// ==========================================

$(document).ready(function () {

    // ------------------------------------------
    // Add Note
    // ------------------------------------------
    $(document).on('submit', '#tutorNote', function (event) {

        event.preventDefault();

        const form = this;

        // IMPORTANT:
        // Always take tutor ID from hidden input
        const tutorId = $('#note_tutor_id').val();

        console.log('Saving note for tutor:', tutorId);

        if (!tutorId) {

            Swal.fire({
                icon: 'error',
                title: 'Tutor ID missing!',
                text: 'Please select a tutor first.'
            });

            return;
        }

        const formData = new FormData(form);

        // Force current tutor ID
        formData.set('tutor_id', tutorId);

        $.ajax({

            url: $(form).attr('action'),

            type: 'POST',

            data: formData,

            processData: false,

            contentType: false,

            dataType: 'json',

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            beforeSend: function () {

                $(form).find('button[type="submit"]')
                    .prop('disabled', true)
                    .text('Saving...');
            },

            success: function (response) {

                console.log('Note saved:', response);

                if (response.status) {

                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Note added successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Clear textarea only
                    $('#tutor_note').val('');

                    // IMPORTANT:
                    // Don't lose tutor ID after reset
                    $('#note_tutor_id').val(tutorId);

                    // Reload notes for SAME tutor
                    btnNote(tutorId);
                }

            },

            error: function (xhr) {

                console.log('Note save error:', xhr.responseText);

                let message = 'Something went wrong!';

                if (xhr.responseJSON) {

                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    if (xhr.responseJSON.errors) {
                        console.log(xhr.responseJSON.errors);
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });

            },

            complete: function () {

                $(form).find('button[type="submit"]')
                    .prop('disabled', false)
                    .text('Save');
            }

        });

    });


    // ------------------------------------------
    // Load Tutor Notes
    // ------------------------------------------
    window.btnNote = function (id) {

        // Convert to string so we can compare reliably
        const tutorId = String(id);

        console.log('Opening notes for tutor:', tutorId);

        // IMPORTANT
        // Set current tutor ID
        $('#note_tutor_id').val(tutorId);

        // Clear old notes immediately
        $('#allNote').html(`
            <div class="text-center text-muted py-3">
                Loading...
            </div>
        `);

        $.ajax({

            url: '{{ route("admin.tutor.getnote") }}',

            type: 'GET',

            data: {
                id: tutorId
            },

            dataType: 'json',

            success: function (response) {

                let html = '';

                if (
                    response.status &&
                    response.data &&
                    response.data.length > 0
                ) {

                    response.data.forEach(function (note) {

                        html += `
                            <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>
                                        <p class="mb-0 text-dark fs-5">
                                            ${escapeHtml(note.created_by ?? '')}
                                        </p>

                                        <p class="text-info mb-0"
                                           style="font-size: 12px">
                                            ${escapeHtml(note.emp_id ?? '')}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="mb-0">
                                            ${formatNoteDate(note.created_at)}
                                        </p>
                                    </div>

                                </div>

                                <p class="mt-2 mb-2">
                                    ${escapeHtml(note.body ?? '')}
                                </p>

                            </div>
                        `;

                    });

                } else {

                    html = `
                        <div class="text-center text-muted py-4">
                            No notes found for this tutor.
                        </div>
                    `;
                }

                $('#allNote').html(html);

            },

            error: function (xhr) {

                console.log('Get notes error:', xhr.responseText);

                $('#allNote').html(`
                    <div class="alert alert-danger">
                        Failed to load notes.
                    </div>
                `);

            }

        });

    };


    // ------------------------------------------
    // Date Format
    // ------------------------------------------
    window.formatNoteDate = function (dateString) {

        if (!dateString) {
            return '';
        }

        const date = new Date(dateString);

        if (isNaN(date.getTime())) {
            return '';
        }

        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();

        return `${day}-${month}-${year}`;
    };


    // ------------------------------------------
    // Prevent XSS in Note Body
    // ------------------------------------------
    window.escapeHtml = function (value) {

        return $('<div>')
            .text(value)
            .html();
    };

});



      function liveChange(id){
        var isChecked = $(".checkbox").is(":checked");
                var newState = isChecked ? 1 : 0;
                $.ajax({
                    url: "{{ route('admin.tutor.sms.status')}}",
                    type: "POST",
                    data: { state: newState,id:id },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                    }
                });


        }




        // function paginateValue(id){
        //     let paginate_val = $("#" + id).val();
        //     let currentUrl = new URL(window.location.href);
        //     currentUrl.searchParams.set('pagination_limit', paginate_val);
        //     window.location.href = currentUrl.href;
        // }

</script>
