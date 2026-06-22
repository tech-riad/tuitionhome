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


function btnConfirmPremium(ev, id){
    Swal.fire({

       title: 'Are you sure for Make as Premium tutor?',
    //    text: "You won't be able to  this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, do it!'
    }).then((result) => {
    if (result.isConfirmed) {

           Swal.fire(
           'Make Premium Complete',
           'success'
           )
           $('#btnConfirmPremium'+id).submit();
       };
       });
}

function btnConfirmFeatured(ev, id){
    Swal.fire({

       title: 'Are you sure for Make as Featured tutor?',
    //    text: "You won't be able to  this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, do it!'
    }).then((result) => {
    if (result.isConfirmed) {

           Swal.fire(
           'Make Premium Complete',
           'success'
           )
           $('#btnConfirmFeatured'+id).submit();
       };
       });
}

function verifyTutor(ev, id){
   Swal.fire({

      title: 'Are you sure for Make as verified tutor?',
   //    text: "You won't be able to  this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, do it!'
   }).then((result) => {
   if (result.isConfirmed) {

          Swal.fire(
          'Make Premium Complete',
          'success'
          )
          $('#verifyTutor'+id).submit();
      };
      });
}
