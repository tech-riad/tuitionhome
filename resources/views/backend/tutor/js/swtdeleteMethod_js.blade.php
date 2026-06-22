<script>

function btnDelete(ev, id){
    Swal.fire({
       title: 'Are you sure?',
       text: "You won't be able to revert this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {

           Swal.fire(
           'Deleted!',
           'Your file has been deleted.',
           'success'
           )
           $('#btndelete'+id).submit();
       };
       });
}

function tutorDeleteBtn(id) {
    const note = $('#tutor_delete_note' + id).val();

    // Check if the note is empty
    if (!note.trim()) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please enter a note before deleting.',
        });
        return; // Exit the function early if note is empty
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with deletion if confirmed
            $('#btndelete' + id).submit();
        }
    });
}




function btnConfirmPremium(ev, id){
    Swal.fire({

       title: 'Are you sure to Make as Premium tutor?',
    //    text: "You won't be able to  this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, do it!'
    }).then((result) => {
    if (result.isConfirmed) {

         //   Swal.fire(
         //   'Make Premium Complete',
         //   'success'
         //   )

           Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Make Premium Complete",
                            showConfirmButton: false,
                            timer: 1500,
                        });




           $('#btnConfirmPremium'+id).submit();
       };
       });
}
function btnConfirmAlert(ev, id){
    Swal.fire({

       title: 'Are you sure to Alert This tutor?',
    //    text: "You won't be able to  this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, do it!'
    }).then((result) => {
    if (result.isConfirmed) {



           Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Make Alert Complete",
                            showConfirmButton: false,
                            timer: 1500,
                        });




           $('#btnConfirmAlert'+id).submit();
       };
       });
}
function btnUndoAlert(ev, id){
    Swal.fire({

       title: 'Are you sure Undo Alert This tutor?',
    //    text: "You won't be able to  this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, do it!'
    }).then((result) => {
    if (result.isConfirmed) {



           Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Mark As Not Alert Complete",
                            showConfirmButton: false,
                            timer: 1500,
                        });




           $('#btnUndoAlert'+id).submit();
       };
       });
}

function btnConfirmFeatured(ev, id){
    Swal.fire({

       title: 'Are you sure to Make as Featured tutor?',
    //    text: "You won't be able to  this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, do it!'
    }).then((result) => {
    if (result.isConfirmed) {


                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Make Featured Complete",
                            showConfirmButton: false,
                            timer: 1500,
                        });


           $('#btnConfirmFeatured'+id).submit();
       };
       });
}

function verifyTutor(ev, id){
   Swal.fire({

      title: 'Are you sure to Make as verified tutor?',
   //    text: "You won't be able to  this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, do it!'
   }).then((result) => {
   if (result.isConfirmed) {

                         Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "verify Complete",
                            showConfirmButton: false,
                            timer: 1500,
                        });

          $('#verifyTutor'+id).submit();
      };
      });
}



</script>
