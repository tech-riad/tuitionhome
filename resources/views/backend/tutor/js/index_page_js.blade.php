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

$(function () {
        $("#tutorNote").on("submit", function (event) {
            event.preventDefault();


            const formElement = document.getElementById('tutorNote');
             const formData = new FormData(formElement);

             const parent_id = formData.get('tutor_id');
             var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                headers: {
                          'X-CSRF-TOKEN': csrfToken
                         },

                success: function (response) {

                    Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "note added successfully",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                    $("#tutorNote")[0].reset();
                    btnNote(parent_id);
                },

                error: function (err) {
                    let error = err.responseJSON;
                    console.log(error);
                },
            });
        });
    });



    let filter = {};
        let orFilter = [];

    // let orFilter = ['group_or_major','university_type' ,'department_id'];
    function filterChange(colname, id){

        filter[colname]=$("#"+id).val();

      var input = '';

      const orDatas = new Map();
      Object.entries(filter).forEach((entry,index) => {
          const [key, value] = entry;


          if(orFilter.includes(key)){
            orDatas.set(key, value);
          }
          else{
            if(index==(Object.keys(filter).length-1)){
                if(key=='created_at <' || key=='country_id' || key=='city_id' || key=='created_at >' || key=='gender' || key =='tutoring_experience' || key =='religion' || key=='blood_group' || key =='method_id' || key =='group_or_major' || key=='blood_group' || key =='method_id' || key =='institute_id' || key=='category_id' || key=='curriculum_id' || key=='location_id'
                || key=='university_type' || key=='degree_name' || key=='department_id' || key=="degree_name='honours' and institute_id" || key=="degree_name='ssc' and institute_id" || key=="degree_name='hsc' and institute_id" || key=="department_id" || key=="expected_salary" || key=="education_board"){
                    input+= `${key}='${value}' `;
                }
                else{
                    input+= `${key} in (${value})` ;
                }
            }
            else{
                if(key=='created_at <' || key=='country_id' || key=='city_id' || key=='created_at >' || key=='gender' || key =='tutoring_experience' || key =='religion' || key=='blood_group' || key =='method_id' || key =='group_or_major' || key=='blood_group' || key =='method_id' || key =='institute_id' || key=='category_id' || key=='curriculum_id' || key=='location_id'
                || key=='university_type' || key=='degree_name' || key=='department_id' || key=="degree_name='honours' and institute_id" || key=="degree_name='ssc' and institute_id" || key=="degree_name='hsc' and institute_id" || key=="department_id" || key=="expected_salary" || key=="education_board"){
                        input+= `${key}='${value}' and `;
                }
                else{
                    input+= `${key} in (${value}) and ` ;
                }
            }
        }


      });

      if(orDatas.size>0){
            input+= '('
        }
        orDatas.forEach((value,key)=>{
            const currLen = Array.from(orDatas);
            const lastEntry = currLen[currLen.length-1];
            const [lkey,lvalus] = lastEntry;



            if(lkey==key){
                input+= `${key} = '${value}' ` ;
            }
            else{
                input+= `${key} = '${value}' or ` ;
            }

        });
        if(orDatas.size>0){
            input+= ')'
        }

    //    console.log(input);


      $('#searchInput').val(input);





    }


    $.date = function(dateObject) {
    const myArray = dateObject.split("T");
    var d = new Date(myArray[0]);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = day + "-" + month + "-" + year;

    return date;
};


    function btnNote(id){


        $('#note_tutor_id').val(id);

        //  console.log(id);

             $.ajax({
                url:'{{route("admin.tutor.getnote")}}',
                type:'get',
                data: {
                       id:id,
                       },
                success:function (response){

                    let html ='';

                    var notes = response.data
                    for(i=0 ; i<notes.length; i++){

                        // console.log(notes[i].body);



                  html+= '<div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3" >\
                    <div class="d-flex justify-content-between align-items-center" id="singleNote">\
                        <div>\
                          <p class="mb-0 text-dark fs-5">'+notes[i].created_by+'</p>\
                          <p class="text-info" style="font-size: 12px">ID-23456</p>\
                        </div>\
                        <div><p>'+ $.date(notes[i].created_at)+'</p></div>\
                      </div>\
                      <p>'+notes[i].body+'</p>\
                      <div class="d-flex justify-content-between align-items-center">\
                        <div>\
                          <p>Read More</p>\
                        </div>\
                        <div>\
                        </div>\
                    </div>\
                  </div>';

                }


                    $('#allNote').html(html);



                }
            });

}




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