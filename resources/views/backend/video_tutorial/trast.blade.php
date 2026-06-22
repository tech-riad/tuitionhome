@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
@section('content')


<div class="card-header">
  <i class="fas fa-table me-1"></i>
  <a class="btn btn-sm btn-info" href="{{route('tutorial.index')}}">List</a>
</div>
<div class="card mb-4">
    <div class="card-body">

            @if(session('message'))
            <p class="alert alert-success">{{ session('message') }}</p>
            @endif

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
                    <td><a href="{{$tutorial->video_link}}">{{$tutorial->video_link}}</a></td>
                    <td>{{ $tutorial->deleted_at->diffForHumans() }}</td>
    
    
                    <td>
    
                      <a class="btn btn-warning btn-sm" href="{{ route('tutorial.restore', ['tutorial' => $tutorial->id]) }}">Restore</a>    
    
                      <form id="btndelete{{$tutorial->id}}" action="{{ route('tutorial.delete', ['tutorial' => $tutorial->id]) }}" method="POST" 
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
</script>
@endpush