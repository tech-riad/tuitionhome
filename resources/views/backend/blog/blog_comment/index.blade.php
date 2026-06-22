
@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')

<div>
<h3>Blog Comments</h3>
</div>


<div class="card mb-4">
        
<div class="card-body">
    {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}
       <table id="datatablesSimple" class="dataTable-table">
           <thead>
                    <tr>
                        
                        <th data-sortable="" style="width: 8.6154%;"><a href="#" class="dataTable-sorter">SL</a></th>
                        <th data-sortable="" style="width: 8.5769%;"><a href="#" class="dataTable-sorter">Post Id</a></th>
                        <th data-sortable="" style="width: 10.0385%;"><a href="#" class="dataTable-sorter">User Name</a></th>
                        <th data-sortable="" style="width: 19.13462%;"><a href="#" class="dataTable-sorter">Email</a></th>
                        <th data-sortable="" style="width: 19.13462%;"><a href="#" class="dataTable-sorter">Message</a></th>
                        <th data-sortable="" style="width: 12.1923%;"><a href="#" class="dataTable-sorter">Created At</a></th>
                        <th data-sortable="" style="width: 26.1923%;"><a href="#" class="dataTable-sorter">Action</a></th>

                        {{-- <th data-sortable="" style="width: 11.4423%;"><a href="#" class="dataTable-sorter">Salary</a></th> --}}
                    </tr>
           </thead>
        
           <tbody>

            @foreach ($comments as $comment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $comment->post_id }}</td>
                <td>{{ $comment->user_name }}</td>
                <td>{{ $comment->email }}</td>
                <td>{{ $comment->message }}</td>
                <td>{{ $comment->created_at->diffForHumans() }}</td>

                
                <td>

                    <form id="btndelete" action="{{ route('blog.comment.delete', ['comment' => $comment->id]) }}" method="POST" 
                        style="display:inline">
                        @csrf
                        @method('delete')
                        <button type="submit" id="" class="btn btn-danger btn-sm btndelete"onclick="btnDelete(event)" >Delete</button>
                    </form>

                </td>
            </tr>
            @endforeach

          </tbody>
       </table>
</div>
</div>
</div>
</div>


@push('page_scripts')
<script>
  function btnDelete(ev){
      ev.preventDefault();
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
                  $('#btndelete').submit();  
              };      
              });
  }
  
</script>
@endpush



@endsection


