@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')


<h1>Tutorials</h1>
    @if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif

<div class="card-header">
    <i class="fas fa-table me-1"></i>
    <a class="btn btn-sm btn-warning" href="{{route('tutorial.trash')}}">Trush List</a>

<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">Add Video link</button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
        <p>Add NewTutorial</p>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            {{-- <input type="hidden" value="{{ route('blog.category.store') }}" id="blog_category_store_route"/> --}}

            <form id="" action="{{route('tutorial.store')}}" method="post" >
                @csrf
                <div id="">
                <label class="form-label">Tutorial Type</label>
                <select name="tutorial_type" id="" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="affilite">Affiliate</option>
                    <option value="tutor">Tutor</option>
                    <option value="parent">Parent</option>
                    @foreach ($types as $type)
                    <option value="{{$type->name}}">{{$type->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" style="">Tutorial Title:</label>
                <input type="text" class="form-control" name="video_title" id="" required>
                <label class="form-label" style="">Tutorial embedded link:</label>
                <input type="text" class="form-control" name="video_link" id="" required>
                </div>

                {{-- <p>Some text in the modal.</p> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"  onclick="">Submiit</button>
                </div>
            </form>
        </div>

    </div>
    </div>



<div class="card mb-4">
<div class="card-body">
    {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}

       <table id="datatablesSimple" class="dataTable-table">
           <thead>
                    <tr>

                        <th data-sortable="" style="width: 4.6154%;"><a href="#" class="dataTable-sorter">SL</a></th>
                        <th data-sortable="" style="width: 10.0385%;"><a href="#" class="dataTable-sorter">tutorial_type</a></th>
                        <th data-sortable="" style="width: 20.0385%;"><a href="#" class="dataTable-sorter">Video Title</a></th>
                        <th data-sortable="" style="width: 28.5769%;"><a href="#" class="dataTable-sorter">Video Link</a></th>
                        <th data-sortable="" style="width: 8.5769%;"><a href="#" class="dataTable-sorter">Created At</a></th>
                        <th data-sortable="" style="width: 10.1923%;"><a href="#" class="dataTable-sorter">Action</a></th>
                    </tr>
           </thead>

           <tbody>

          @foreach($tutorials as $tutorial)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$tutorial->tutorial_type}}</td>
                <td>{{Str::limit( $tutorial->video_title,20 )}}</td>
                <td>{{$tutorial->video_link}}</td>
                <td>{{ $tutorial->created_at->diffForHumans() }}</td>
                <td>

                  <button id="{{$tutorial->id}}" onclick="btnEdit(this.id)"  type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal">Edit</button>

                  {{-- <a class="btn btn-warning btn-sm" href="{{ route('tutorial.edit', ['tutorial' => $tutorial->id]) }}">Edit</a>     --}}

                  <form id="btndelete{{$tutorial->id}}" action="{{ route('tutorial.destroy', ['tutorial' => $tutorial->id]) }}" method="POST"
                    style="display:inline">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-danger btn-sm " id="{{$tutorial->id}}" onclick="btnDelete(this, this.id)" >Delete</button>
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


{{--  edit modal --}}
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
        <p>Edit Tutorial</p>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            {{-- <input type="hidden" value="{{ route('blog.category.store') }}" id="blog_category_store_route"/> --}}

            <form id="" action="{{route('video-tutorial.update')}}" method="POST" >

                @csrf
                <input type="hidden" name="tutorial_id" id="tutorial_id">
                <label class="form-label">Tutorial Type</label>
                <select name="tutorial_type" id="tutorial_type" class="form-control" required>
                    <option value="affilite">Affiliate</option>
                    <option value="tutor">Tutor</option>
                    <option value="parent">Parent</option>
                    @foreach ($types as $type)
                    <option value="{{$type->name}}">{{$type->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" style="">Tutorial Title:</label>
                <input type="text" class="form-control" name="video_title" id="name" required>
                <label class="form-label" style="">Tutorial embedded link:</label>
                <input type="text" class="form-control" name="video_link" id="link" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"  onclick="">Update</button>
                </div>
            </form>
        </div>

    </div>
    </div>

{{-- end edit modal --}}




@endsection



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
     function btnEdit(id){

            var route = '{{ route("tutorial.edit", ":id") }}';
            route = route.replace(':id', id);
            $.ajax({
            type: "GET",
            url: route,
            success:function(response){
                 $('#tutorial_type').val(response.tutorial.tutorial_type);
                 $('#name').val(response.tutorial.video_title);
                 $('#link').val(response.tutorial.video_link);
                 $('#tutorial_id').val(response.tutorial.id);
            }
            });

      }


</script>
@endpush
