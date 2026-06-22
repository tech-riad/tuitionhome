<script>
    
function addTag(){
    
    var name = $("#name").val();
    var route = $("#blog_tag_store_route").val();
    console.log(name);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: route,
        method: "post",
        data: {
            tName:name,
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success:function(response){

            Swal.fire('Tag insert successfully');
            $('.card-body').load(location.href+' .card-body');
        },
        error:function(err){
            let error = err.responseJSON;
            $.each(error.errors,function(index, value){

            })
        }

    })
    //  alert('hi');
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

var route = '{{ route("blog.tag.edit", ":id") }}';
route = route.replace(':id', id);

//  console.log(route);
$.ajax({
type: "GET",
url: route,
success:function(response){
$('#tag_name').val(response.tag.name);
$('#tag_id').val(response.tag.id);
console.log(response.tag.name);

}
});
//  console.log(id);

}




</script>