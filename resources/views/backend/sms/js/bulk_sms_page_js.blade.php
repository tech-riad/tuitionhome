<script>


    function countAlphabets(sentence) {
    const cleanSentence = sentence.replace(/[^a-zA-Z]/g, '').toLowerCase();

    const count = cleanSentence.length;

    return count;
    }

 function changeTemplate(id){

    $.ajax({
        type: "GET",
        url: '{{route("admin.template.change")}}',
        data: {
            id:id,
        },
        success:function(response){
            
            console.log(response);


        

            $('#sms_body').val(response.template.description);

            const alphabetCount = countAlphabets(response.template.description);
            const remaining = 260-alphabetCount;
            $('#char').text(alphabetCount+'/260');
            $('#rem').text(remaining);



        }
        });

 }

 function count(value){

    const alphabetCount = countAlphabets(value);

    const remaining = 260-alphabetCount;
            $('#char').text(alphabetCount+'/260');
            $('#rem').text(remaining);

 }



 

    // $(function () {
    //     $("#bulkSmsSend").on('submit', function (e) {
    //         e.preventDefault();
    //         $.ajax({
    //             url: $(this).attr('action'),
    //             method: $(this).attr('method'),
    //             data: new FormData(this),
    //             processData: false,
    //             contentType: false,
    //             dataType: 'json',
    //             beforeSend: function () {
    //                 $(document).find('span.error-text').text('');
    //             },
    //             success: function (data) {
    //                 if (data.status === false) {
    //                     $.each(data.error, function (prefix, val) {
    //                         $('span.' + prefix + '_error').text(val[0]);
    //                     });
    //                 } else {
    //                     Swal.fire({
    //                         position: "top-end",
    //                         icon: "success",
    //                         title: "SMS sent successfully",
    //                         showConfirmButton: false,
    //                         timer: 1500,
    //                     });
    //                     $('#bulkSmsSend')[0].reset();
    //                 }
    //             },
    //             error: function (xhr, status, error) {
    //                 console.error(xhr.responseText);
    //                 // Handle error response here
    //             }
    //         });
    //     });
    // });




let filter = {};
    function filterChange(colname, id){

        filter[colname]=$("#"+id).val();

      var input = '';

      Object.entries(filter).forEach((entry,index) => {
          const [key, value] = entry;

          if(index==(Object.keys(filter).length-1)){
              input+= `${key}='${value}' `;
          }
          else{

              input+= `${key}='${value}' and `;
          }

      });

      $('#searchInput').val(input);



    }






</script>
