<script>

        // document.getElementById('tution_salary').addEventListener('input', updateCharge);
        // document.getElementById('percentage').addEventListener('change', updateCharge);

        function updateCharge() {
            var salary = parseFloat(document.getElementById('tution_salary').value) || 0;
            var percentage = parseFloat(document.getElementById('percentage').value) || 0;

            var charge = (salary * percentage) / 100;

            document.getElementById('charge').value = charge.toFixed(2);
        }


    function stageChange(id, showCanvas=false){
        if(showCanvas){
                var stage =$("#"+id).val();

             if (stage == 'waiting'){
                $(".offcanvas.offcanvas-end.show").offcanvas('hide');
               $(".offcanvas-backdrop.show").hide();
                $("#waitingOffcanvas").offcanvas('show');
                $("#waiting_stage").val('waiting');

            }
            else if (stage == 'meet'){
            $(".offcanvas.offcanvas-end.show").offcanvas('hide');
            $(".offcanvas-backdrop.show").hide();
            $("#meetOffcanvas").offcanvas('show');
                $("#meet_stage").val('meet');
            }

            else if (stage == 'trial'){
            $(".offcanvas.offcanvas-end.show").offcanvas('hide');
            $(".offcanvas-backdrop.show").hide();
            $("#trailOffcanvas").offcanvas('show');
                $("#trial_stage").val('trial');
            }


            else if (stage == 'confirm'){
             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
             $(".offcanvas-backdrop.show").hide();
            $("#confirmOffcanvas").offcanvas('show');
                $("#confirm_stage").val('confirm');
            }


            else if (stage == 'problem'){
            $(".offcanvas.offcanvas-end.show").offcanvas('hide');
            $(".offcanvas-backdrop.show").hide();
            $("#problemOffcanvas").offcanvas('show');
                $("#problem_stage").val('problem');
            }

            else if (stage == 'repost'){
            $(".offcanvas.offcanvas-end.show").offcanvas('hide');
            $(".offcanvas-backdrop.show").hide();
            $("#repostOffcanvas").offcanvas('show');
                $("#repost_stage").val('repost');
            }


            else if (stage == 'closed'){
            $(".offcanvas.offcanvas-end.show").offcanvas('hide');
            $(".offcanvas-backdrop.show").hide();
            $("#closedOffcanvas").offcanvas('show');
                $("#closed_stage").val('closed');
            }

            }




}






function stageJobId(id,canvasId, charge ,due_amount){

    $('#waiting_application_id').val(id);
    $('#meeting_application_id').val(id);
    $('#trial_application_id').val(id);
    $('#problem_application_id').val(id);
    $('#repost_application_id').val(id);
    $('#confirm_application_id').val(id);
    $('#closed_application_id').val(id);
    $('#p_app_id').val(id);
    $('#refund_app_id').val(id);
    $('#due_app_id').val(id);
    $('#net_amount').val(charge);
    $('#due_net_amount').val(due_amount);






    $(`#${canvasId}`).offcanvas('show');

}



// $(document).ready(function(){

//     $('[data-bs-dismiss="offcanvas"]').click(function(){
//         $(".offcanvas-backdrop.show").hide();
//         $(".modal-backdrop.show").hide();
//     });

//     $('#stage').change(function (){

//         let stage = $(this).val();
//         // debugger;
//         if (stage == 'waiting'){

//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#changeMeetingStageModal").offcanvas('show');

//             // $('[data-bs-dismiss="offcanvas"]').trigger('click');


//         //     $("#closedOffcanvas").show();
//         //                 // $('body').removeClass('modal-open');
//         //                 // $(".modal.fade.show").hide();
//         //                 // $('body').attr("style", "overflow:auto");

//         //     var modalTarget = $("#trialStageModalButton").attr("data-bs-target");

//         // // Toggle the modal based on the target
//         //     $(modalTarget).modal('toggle');
//         //     $("#trailchangestageModal").modal('hide');
//         //     // #trailchangestageModal
//         //     // $("#trailchangestageModal").modal('show');
//         //   $("#meetchangestageModal").modal('show');
//             // console.log('tamim');
//         }
//         else if (stage == 'meet'){
//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#changeMeetingStageModal").offcanvas('show');
//         }

//         else if (stage == 'trial'){
//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#trailOffcanvas").offcanvas('show');
//         }


//         else if (stage == 'confirm'){
//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#changeMeetingStageModal").offcanvas('show');
//         }


//         else if (stage == 'payment'){
//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#problemOffcanvas").offcanvas('show');
//         }

//         else if (stage == 'repost'){
//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#changetrialStageModal").offcanvas('show');
//         }

//         else if (stage == 'problem'){
//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#changeMeetingStageModal").offcanvas('show');
//         }

//         else if (stage == 'closed'){
//             $(".offcanvas.offcanvas-end.show").offcanvas('hide');
//             $(".offcanvas-backdrop.show").hide();
//             $("#changeMeetingStageModal").offcanvas('show');
//         }







//         if (stage == 'trial'){

//             //  $('[data-bs-dismiss="offcanvas"]').trigger('click');
//             var modalTarget = $("#trialStageModalButton").attr("data-bs-target");

//         // Toggle the modal based on the target
//             $(modalTarget).modal('toggle');


//             console.log('tamim trial')
//             // $('[data-bs-dismiss="offcanvas"]').trigger('click');
//             // // #trailchangestageModal
//             $("#trailchangestageModal").modal('show');

//             // $("#trailchangestageModal").modal('show');


//             // console.log('tamim');
//             }


//      console.log(stage);

// });





// });



$(function(){

$("#applicationNote").on('submit',function(e){
e.preventDefault();


const formElement = document.getElementById('applicationNote');
      const formData = new FormData(formElement);
const note_application_id = formData.get('note_application_id');

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
                            title: "Note added successfully",
                            showConfirmButton: false,
                            timer: 1000,
                        });

          $('#applicationNote')[0].reset();


          btnNote(note_application_id);

          // $("#editSmsModal").modal("hide");
          //  $(".modal-backdrop").remove();
          //  $(".modal.fade.show").hide();
          //  $('#vsms_data_table').load(location.href+' #vsms_data_table');
          // $('html').css('overflow', 'auto');
          // $('.sidebar-mini.layout-fixed').css('height', 'auto');


        }
    }
});


});

});


function btnNote(id){


$('#note_application_id').val(id);

//  console.log(id);

     $.ajax({
        url:'{{route("admin.application.getnote")}}',
        type:'get',
        data: {
               id:id,
               },
        success:function (response){

            let html ='';
            var notes = response.data
            for(i=0 ; i<notes.length; i++){

                // console.log(notes[i].body);

          html+= ' <div class="border-bottom border-1 pb-3">\
                                    <div class="bg-light rounded-2 p-2" style="font-size: 14px">\
                                      '+notes[i].body+'\
                                    </div>\
                                </div>\
                                <div class="d-flex justify-content-between align-items-center mt-3">\
                                    <div class="d-flex justify-content-start align-items-center gap-3">\
                                        <img height="45" width="45" class="rounded-3"\
                                            src="/images/avatar.svg" alt="" />\
                                        <div class="">\
                                            <p class="m-0" style="font-size: 14; font-weight: 500">\
                                              '+notes[i].created_by+'\
                                            </p>\
                                            <p class="m-0 fw-light" style="font-size: 12px">\
                                                Sales & Operation Dep:\
                                            </p>\
                                        </div>\
                                    </div>\
                                    <div>\
                                        <p style="font-size: 12px">'+timeDate(notes[i].created_at)+'</p>\
                                    </div>\
                                </div>';

        }


            $('#allNote').html(html);


        }
    });

}




$(function(){

$("#applicationStageChangeForm").on('submit',function(e){
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

            console.log(data);
            if(data.status == false){

                $.each(data.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                })
            }

            else{

                Swal.fire({
                             position: "top-end",
                                icon: "success",
                                title: "job Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
               $('#applicationStageChangeForm')[0].reset();

            $('[data-bs-dismiss="offcanvas"]').trigger('click');
            $('#takenApplicationTable').load(location.href+' #takenApplicationTable');
            $('#meetApplicationTable').load(location.href+' #meetApplicationTable');
            $('#confirmApplicationTable').load(location.href+' #confirmApplicationTable');
            $('#waitingApplicationTable').load(location.href+' #waitingApplicationTable');
            $('#trialApplicationTable').load(location.href+' #trialApplicationTable');
            $('#repostApplicationTable').load(location.href+' #repostApplicationTable');
            $('#problemApplicationTable').load(location.href+' #problemApplicationTable');
            $('#closedApplicationTable').load(location.href+' #closedApplicationTable');



            }
        }
    });


 });

});



$(function(){

$("#problemStageChangeForm").on('submit',function(e){
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

            console.log(data);
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
                                title: "job Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
               $('#problemStageChangeForm')[0].reset();

            $('[data-bs-dismiss="offcanvas"]').trigger('click');
            $('#takenApplicationTable').load(location.href+' #takenApplicationTable');
            $('#meetApplicationTable').load(location.href+' #meetApplicationTable');
            $('#confirmApplicationTable').load(location.href+' #confirmApplicationTable');
            $('#waitingApplicationTable').load(location.href+' #waitingApplicationTable');
            $('#trialApplicationTable').load(location.href+' #trialApplicationTable');
            $('#repostApplicationTable').load(location.href+' #repostApplicationTable');
            $('#problemApplicationTable').load(location.href+' #problemApplicationTable');
            $('#closedApplicationTable').load(location.href+' #closedApplicationTable');




            }
        }
    });


 });

});



$(function(){

$("#repostStageChangeForm").on('submit',function(e){
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

            console.log(data);
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
                                title: "job Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
               $('#repostStageChangeForm')[0].reset();

            $('[data-bs-dismiss="offcanvas"]').trigger('click');
            $('#takenApplicationTable').load(location.href+' #takenApplicationTable');
            $('#meetApplicationTable').load(location.href+' #meetApplicationTable');
            $('#confirmApplicationTable').load(location.href+' #confirmApplicationTable');
            $('#waitingApplicationTable').load(location.href+' #waitingApplicationTable');
            $('#trialApplicationTable').load(location.href+' #trialApplicationTable');
            $('#repostApplicationTable').load(location.href+' #repostApplicationTable');
            $('#problemApplicationTable').load(location.href+' #problemApplicationTable');
            $('#closedApplicationTable').load(location.href+' #closedApplicationTable');

            //    $('[data-bs-dismiss="offcanvas"]').trigger('click');




            }
        }
    });


 });

});









$(function(){

$("#meetingStageChangeForm").on('submit',function(e){
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

            console.log(data);
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
                                title: "job Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
               $('#meetingStageChangeForm')[0].reset();

            $('[data-bs-dismiss="offcanvas"]').trigger('click');
            $('#takenApplicationTable').load(location.href+' #takenApplicationTable');
            $('#meetApplicationTable').load(location.href+' #meetApplicationTable');
            $('#confirmApplicationTable').load(location.href+' #confirmApplicationTable');
            $('#waitingApplicationTable').load(location.href+' #waitingApplicationTable');
            $('#trialApplicationTable').load(location.href+' #trialApplicationTable');
            $('#repostApplicationTable').load(location.href+' #repostApplicationTable');
            $('#problemApplicationTable').load(location.href+' #problemApplicationTable');
            $('#closedApplicationTable').load(location.href+' #closedApplicationTable');

            //    $('[data-bs-dismiss="offcanvas"]').trigger('click');




            }
        }
    });


 });

});



$(function(){

$("#trialStageChangeForm").on('submit',function(e){
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

            console.log(data);
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
                                title: "job Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
               $('#trialStageChangeForm')[0].reset();

            $('[data-bs-dismiss="offcanvas"]').trigger('click');
            $('#takenApplicationTable').load(location.href+' #takenApplicationTable');
            $('#meetApplicationTable').load(location.href+' #meetApplicationTable');
            $('#confirmApplicationTable').load(location.href+' #confirmApplicationTable');
            $('#waitingApplicationTable').load(location.href+' #waitingApplicationTable');
            $('#trialApplicationTable').load(location.href+' #trialApplicationTable');
            $('#repostApplicationTable').load(location.href+' #repostApplicationTable');
            $('#problemApplicationTable').load(location.href+' #problemApplicationTable');
            $('#closedApplicationTable').load(location.href+' #closedApplicationTable');
            //    $("#changeStageModal").offcanvas("hide");

            //    $('[data-bs-dismiss="offcanvas"]').trigger('click');




            }
        }
    });


 });

});



$(function(){

$("#confirmStageChangeForm").on('submit',function(e){
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


            console.log(data);
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
                                title: "job Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
               $('#confirmStageChangeForm')[0].reset();

            $('[data-bs-dismiss="offcanvas"]').trigger('click');
            $('#takenApplicationTable').load(location.href+' #takenApplicationTable');
            $('#meetApplicationTable').load(location.href+' #meetApplicationTable');
            $('#confirmApplicationTable').load(location.href+' #confirmApplicationTable');
            $('#waitingApplicationTable').load(location.href+' #waitingApplicationTable');
            $('#trialApplicationTable').load(location.href+' #trialApplicationTable');
            $('#repostApplicationTable').load(location.href+' #repostApplicationTable');
            $('#problemApplicationTable').load(location.href+' #problemApplicationTable');
            $('#closedApplicationTable').load(location.href+' #closedApplicationTable');
            //    $("#changeStageModal").offcanvas("hide");

            //    $('[data-bs-dismiss="offcanvas"]').trigger('click');




            }
        }
    });


 });

});


$(function(){

$("#closedStageChangeForm").on('submit',function(e){
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

            console.log(data);
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
                                title: "job Updated successfully",
                                showConfirmButton: false,
                                timer: 1000,
                            });
               $('#closedStageChangeForm')[0].reset();

            $('[data-bs-dismiss="offcanvas"]').trigger('click');
            $('#takenApplicationTable').load(location.href+' #takenApplicationTable');
            $('#meetApplicationTable').load(location.href+' #meetApplicationTable');
            $('#confirmApplicationTable').load(location.href+' #confirmApplicationTable');
            $('#waitingApplicationTable').load(location.href+' #waitingApplicationTable');
            $('#trialApplicationTable').load(location.href+' #trialApplicationTable');
            $('#repostApplicationTable').load(location.href+' #repostApplicationTable');
            $('#problemApplicationTable').load(location.href+' #problemApplicationTable');
            $('#closedApplicationTable').load(location.href+' #closedApplicationTable');
            //    $("#changeStageModal").offcanvas("hide");

            //    $('[data-bs-dismiss="offcanvas"]').trigger('click');




            }
        }
    });


 });

});





function timeDate(data){

  var createdDate = data;
createdDate = new Date(createdDate);
date = createdDate.toLocaleDateString();
time = createdDate.toLocaleTimeString().replace(/(.*)\D\d+/, '$1');

let smy = date+'-'+time


return smy;


}


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


function paymentAdjust(id) {
    let received_amount = parseFloat($("#" + id).val());
    let charge = parseFloat($("#net_amount").val());
    let due = charge - received_amount;

    if (due == 0) {
        $("#checkbox_due").prop("checked", false);
    } else {
        $("#checkbox_due").prop("checked", true);
    }
    if ($("#checkbox_due").is(":checked")) {
        $('#collapsedue').collapse('show');
    } else {
        $('#collapsedue').collapse('hide');
    }

    $('#due_amount').val(due);
}


function dueAdjust(id) {

    let received_amount = parseFloat($("#" + id).val());
    let charge = parseFloat($("#due_net_amount").val());
    let due = charge - received_amount;


    if (due == 0) {
        $("#due_checkbox_due").prop("checked", false);
    } else {
        $("#due_checkbox_due").prop("checked", true);
    }
    if ($("#due_checkbox_due").is(":checked")) {
        $('#duecollapsedue').collapse('show');
    } else {
        $('#duecollapsedue').collapse('hide');
    }

    $('#due_due_amount').val(due);
}




$(function() {
    $("#refundPaymentStatus").on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(document).find('span.error-text').text('');
            },
            success: function(data) {
                if (data.status == false) {
                    $.each(data.error, function(prefix, val) {
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Added For Refund",
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    $('[data-bs-dismiss="modal"]').trigger('click');

                    $('#takenApplicationTable').load(location.href + ' #takenApplicationTable');
                    $('#payment_table').load(location.href + ' #payment_table');
                    $('#due_table').load(location.href + ' #due_table');
                }
            }
        });
    });
});



$(function(){
    $("#payment_form").on('submit', function(e){
        e.preventDefault();

        var submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'JSON',
            contentType: false,
            beforeSend: function(){
                $(document).find('span.error-text').text('');
            },
            success: function(data){
                if (data.status == false) {
                    if (typeof data.error === 'object') {
                        // Validation errors (field-specific)
                        $.each(data.error, function(prefix, val){
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        // General error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.error,
                        });
                    }
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Payment updated successfully",
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    $('[data-bs-dismiss="modal"]').trigger('click');
                    $('#takenApplicationTable').load(location.href + ' #takenApplicationTable');
                    $('#payment_table').load(location.href + ' #payment_table');
                    $('#due_table').load(location.href + ' #due_table');
                }

                submitButton.prop('disabled', false);
            },
            error: function() {
                submitButton.prop('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });
            }
        });
    });
});







$(function(){

$("#due_payment_form").on('submit', function(e){
    e.preventDefault();

    // Disable the submit button
    var submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true);

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        processData: false,
        datatype: 'JSON',
        contentType: false,
        beforeSend: function(){
            $(document).find('span.error-text').text('');
        },
        success: function(data){
            console.log(data);
            if(data.status == false){
                console.log('hi');
                $.each(data.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                });
            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Job updated successfully",
                    showConfirmButton: false,
                    timer: 1000,
                });

                $('[data-bs-dismiss="modal"]').trigger('click');

                $('#takenApplicationTable').load(location.href + ' #takenApplicationTable');
                $('#payment_table').load(location.href + ' #payment_table');
                $('#due_table').load(location.href + ' #due_table');
            }

            // Re-enable the submit button after the AJAX request is complete
            submitButton.prop('disabled', false);
        },
        error: function() {
            // Re-enable the submit button if an error occurs
            submitButton.prop('disabled', false);
        }
    });
});

});



</script>
