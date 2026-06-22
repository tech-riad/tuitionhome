
@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')

<div>
<h3>Blog Posts</h3>
</div>

    @if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif


<div class="card mb-4">


    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <a class="btn btn-sm btn-warning" href="">Trush List</a>
        <a class="btn btn-sm btn-primary" href="{{route('post.create')}}">Add New</a>
    </div>
<div class="card-body">
    {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}

       <table id="datatablesSimple" class="dataTable-table" >
           <thead>
                    <tr style="border: 0">

                        <th data-sortable="" style="width: 6.6154%;"><a href="#" class="dataTable-sorter">SL</a></th>
                        <th data-sortable="" style="width: 10.0385%;"><a href="#" class="dataTable-sorter">Title</a></th>
                        <th data-sortable="" style="width: 10.0385%;"><a href="#" class="dataTable-sorter">image</a></th>
                        <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">Short Description</a></th>
                        <th data-sortable="" style="width: 19.13462%;"><a href="#" class="dataTable-sorter">Long Description</a></th>
                        <th data-sortable="" style="width: 9.13462%;"><a href="#" class="dataTable-sorter">Updated At</a></th>
                        <th data-sortable="" style="width: 26.1923%;"><a href="#" class="dataTable-sorter">Action</a></th>
                    </tr>
           </thead>

           <tbody>

            @foreach ($posts as $post)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{Str::limit( $post->title,20 )}}</td>
                <td><img src="{{ asset('storage/post-image/'. $post->image) }}" style="height: 60px ; width: 80px" /></td>
                <td>{{ Str::limit($post->short_description , 40) }}</td>
                <td>{{Str::limit($post->long_description , 60)}} </td>
                <td>{{ $post->created_at->diffForHumans() }}</td>



                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('post.show', ['post' => $post->id]) }}">Show</a>

                    <a class="btn btn-warning btn-sm" href="{{ route('post.edit', ['post' => $post->id]) }}">Edit</a>


                    <form id="btndelete{{$post->id}}" action="{{ route('post.delete', ['post' => $post->id]) }}" method="POST"
                        style="display:inline">
                        @csrf
                        @method('delete')
                        <button type="button" id="{{$post->id}}" class="btn btn-danger btn-sm btndelete"onclick="btnDelete(this, this.id)" >Delete</button>
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

</script>

@endpush


@endsection
