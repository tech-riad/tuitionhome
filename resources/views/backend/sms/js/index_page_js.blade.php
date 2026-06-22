<script>

$(function(){

$("#smsStoreFrom").on('submit',function(e){
    e.preventDefault();
// parent register

    $.ajax({
        url:$(this).attr('action'),
        method:$(this).attr('method'),
        data: new FormData(this),
        processData:false,
        datatype:JSON,
        contentType:false,
        beforeSend:function(){

            $(document).find('span.error-text').text('');
        },

        success:function(data){

            if(data.status == false){

                console.log('hi');
                $.each(data.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                })
            }

            else{

                Swal.fire({
                             position: "top-end",
                                icon: "success",
                                title: "Data added successfully",
                                showConfirmButton: false,
                                timer: 1500,
                            });
              $('#smsStoreFrom')[0].reset();
              $("#exampleModal").modal("hide");
              $(".modal-backdrop").remove();
              $(".modal.fade.show").hide();

              $('#sms_data_table').load(location.href+' #sms_data_table');
              $('html, body').css('overflow', 'auto');


            }
        }
    });


 });

});

function btnTamplateEdit(id){


    console.log(id);
            $.ajax({
        type: "GET",
        url: '{{route("admin.sms.edit")}}',
        data: {
            id:id,
        },
        success:function(response){

            console.log(response);


            $('#edit_id').val(response.sms.id);
            $('#edit_user_id').val(response.sms.user_id);
            $('#edit_title').val(response.sms.title);
            $('#edit_description').val(response.sms.description);
            // $('#phone').val(response.tutor.phone);
            // $('#gender').val(response.tutor.gender);
        }
        });


}


$(function(){

$("#smsUpdateFrom").on('submit',function(e){
    e.preventDefault();
// parent register

    $.ajax({
        url:$(this).attr('action'),
        method:$(this).attr('method'),
        data: new FormData(this),
        processData:false,
        datatype:JSON,
        contentType:false,
        beforeSend:function(){

            $(document).find('span.error-text').text('');
        },

        success:function(data){

            if(data.status == false){

                // console.log('hi');
                $.each(data.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                })
            }

            else{

                Swal.fire({
                             position: "top-end",
                                icon: "success",
                                title: "Data Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
              $('#smsStoreFrom')[0].reset();
              $("#editSmsModal").modal("hide");
               $(".modal-backdrop").remove();
               $(".modal.fade.show").hide();
              $('#sms_data_table').load(location.href+' #sms_data_table');
              $('html').css('overflow', 'auto');
              $('.sidebar-mini.layout-fixed').css('height', 'auto');
              $('#editSmsModal').modal({ backdrop: 'static', keyboard: false })



            }
        }
    });


 });

});

// function btnEdit(id){

// var route = '{{ route("tutor.edit", ":id") }}';
// route = route.replace(':id', id);

// console.log(route);
// $.ajax({
//   type: "GET",
//   url: route,
//   success:function(response){
//      $('#tutor_id').val(response.tutor.id);
//      $('#name').val(response.tutor.name);
//      $('#email').val(response.tutor.email);
//      $('#phone').val(response.tutor.phone);
//      $('#gender').val(response.tutor.gender);
//   }
// });
// }







</script>
