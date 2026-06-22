<script>

$(function(){

$("#vSmsStoreForm").on('submit',function(e){
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
              $('#vSmsStoreForm')[0].reset();
              $("#storeModal").modal("hide");
              $(".modal-backdrop").remove();
              $(".modal.fade.show").hide();

              $('#vsms_data_table').load(location.href+' #vsms_data_table');
              $('html, body').css('overflow', 'auto');


            }
        }
    });


 });

});


function btnTamplateEdit(id){

        $.ajax({
    type: "GET",
    url: '{{route("admin.sms_template.edit")}}',
    data: {
        id:id,
    },
    success:function(response){

        // console.log(response);
        
        $('#edit_id').val(response.sms.id);
        $('#edit_title').val(response.sms.title);
        $('#edit_body').val(response.sms.body);
    }
    });


}


$(function(){

$("#templateUpdateFrom").on('submit',function(e){
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

          $('#templateUpdateFrom')[0].reset();
          $("#editSmsModal").modal("hide");
           $(".modal-backdrop").remove();
           $(".modal.fade.show").hide();
           $('#vsms_data_table').load(location.href+' #vsms_data_table');
          $('html').css('overflow', 'auto');
          $('.sidebar-mini.layout-fixed').css('height', 'auto');
          

        }
    }
});


});

});


</script>