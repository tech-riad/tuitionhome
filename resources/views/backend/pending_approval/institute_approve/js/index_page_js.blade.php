<script>


var checked_tutor_id = 0;

function btnEdit(id){

    var route = '{{ route("admin.approve.institute.edit", ":id") }}';
    route = route.replace(':id', id);
    // console.log(route);

    $.ajax({
      type: "GET",
      url: route,
      success:function(response){
        console.log(response);
         $('#title').val(response.institute.university);
         $('#degree_name').val(response.institute.degree_name);
         $('#id').val(response.institute.id);
         $('#tutor_id').val(response.institute.tutor_id);
      }
    });
    };




    function clickfunction(id){


      // console.log(id);
      var checkbox = document.getElementById("checkbox_tutor_id" + id);
      $('[id^="checkbox_tutor_id"]').not(checkbox).prop('checked', false);

    if (checkbox.checked) {


      let tutor_id = $("#checkbox_tutor_id" + id).val();


      this.checked_tutor_id = tutor_id

      
      // console.log(this.tutor_id);


            } 

      // return('tamim');
    }



//     $(function(){

// $(".checkbox_tutor_id").on('click',function(e){
//     var checkbox = document.getElementById("checkbox_tutor_id");
//     if (checkbox.checked) {


//       let tutor_id= $(checkbox_tutor_id).val();


//       this.tutor_id = tutor_id

      
//       console.log(this.tutor_id);


//             } 

// });

// });




    function btnChangeSearchInput(data){


      // let text = "How are you doing today?";
      const myArray = data.split("-");
      let tutor_id = myArray[0];
      let search_input = myArray[1];

        // console.log(data);
        $('#inputSearch').val(search_input).button("refresh");
        // $("##addthis").attr('value', 'Save');
        // $('#addthis').html= id;
        btnSearch(tutor_id);

        // $("#addthis").tutor_id(tutor_id);


    }

    function btnSearch(tutor_id){
        // e.preventDefault();
        var ar = [];
        buildTable(ar);

    var route = '{{ route("admin.institute.search") }}';
     var input = $("#inputSearch").val();

    $.ajax({
      type: "get",
      url: route,
      data: {
            input:input,
        },
      success:function(response){
        if(response.instituties == ''){
        $('#displayError').html("Data not found");
        }
        else{
            $('#displayError').html("");
        }

        $('#dataTable2').empty();

        ar = response.instituties;
          buildTable(ar,tutor_id);
        $('#title').val(response.instituties.title);

      }
    });
    }

function buildTable(data,tutor_id){

    var table  = document.getElementById("dataTable2")
    $('table.output').empty();
   for(var i=0 ; i <data.length ; i++){
       var row = `<tr>
           <td>${data[i].id}</td>
           <td>${data[i].title}</td>
           <td>${data[i].type}</td>
           <td><button id="${tutor_id}"class="btn_include_institute btn btn-sm btn-primary" tutor-id="${tutor_id}" data-name="${data[i].type}" data-id ="${data[i].id} ">Include</button></td>
           </tr>`
           table.innerHTML += row ;
   }
   }

   $("tbody").on("click" , ".btn_include_institute", function(){
       let institute_id = $(this).attr("data-id");
       let type = $(this).attr("data-name");
       let tutor_id = $(this).attr("tutor-id");
      //  console.log(institute_id,tutor_id);
       var route = '{{ route("admin.institute.include") }}';


       if(tutor_id =='[object KeyboardEvent]'){


          var checkBoxes = document.getElementsByName("checkbox_tutor_id");
        var isChecked = false;

        for (var i = 0; i < checkBoxes.length; i++) {
          if (checkBoxes[i].checked) {
            isChecked = true;
            break;
          }
        }

        if (!isChecked) {

         alert("please select one institute request First");

        } else {


          console.log(institute_id);
          console.log(checked_tutor_id);


          $.ajax({
      type: "get",
      url: route,
      data: {
             institute_id:institute_id,
             tutor_id: checked_tutor_id,
        },
      success:function(response){


        console.log(response);
        if(response.status == 'institute include successfully'){

          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'institute include successfully',
            showConfirmButton: false,
            timer: 1500
          })

          $('.card-body1').load(location.href+' .card-body1');
        }
        else{
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'institute already included',
            showConfirmButton: false,
            timer: 1500
          })

         $('.card-body1').load(location.href+' .card-body1');


        }
      }
    });






        }


       }
      
       else{

        $.ajax({
      type: "get",
      url: route,
      data: {
             institute_id:institute_id,
             tutor_id:tutor_id,
        },
      success:function(response){

        console.log(response);

        if(response.status == 'institute include successfully'){

          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'institute include successfully',
            showConfirmButton: false,
            timer: 1500
          })

          $('.card-body1').load(location.href+' .card-body1');
        }
        else{
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'institute already included',
            showConfirmButton: false,
            timer: 1500
          })

         $('.card-body1').load(location.href+' .card-body1');


        }
      }
    });

       }



    //  console.log(institute_id,tutor_id);
   })


   function btnApproveInstitute(ev, id){
   Swal.fire({

      title: 'Are you sure to approve this Institute?',
   //    text: "You won't be able to  this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, do it!'
   }).then((result) => {
   if (result.isConfirmed) {
          $('#approveInstitute'+id).submit();
      };
      });
}

</script>
