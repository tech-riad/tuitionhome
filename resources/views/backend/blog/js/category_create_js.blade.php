<script>
function addCategory(){

    $("h1").html("change");
    var name = $("#name").val();
    var route = $("#blog_category_store_route").val();
    console.log(name);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: route,
        method: "post",
        data: {
            cName:name,
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success:function(response){

            Swal.fire('Category insert successfully');
            $('#dataTable').load(location.href+' #dataTable');
        },
        error:function(err){
            let error = err.responseJSON;
            $.each(error.errors,function(index, value){

            })
        }

    })
    //  alert('hi');
}


function addPost(ev){
    //  ev.preventDefault();
     // ver urlToRedirect=ev.currentTarget.getAttribute('href');
     Swal.fire('Category insert successfully')
     .then((result) => {
                       
             });

 }


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

  function btnEdit(id){

    var route = '{{ route("blog.category.edit", ":id") }}';
    route = route.replace(':id', id);

      console.log(id);
    $.ajax({
      type: "GET",
      url: route,
      success:function(response){
        $('#category_name').val(response.category.name);
        $('#category_id').val(response.category.id);
          // console.log(response.category.name);
      }
    });
  //  console.log(id);

  }


</script>