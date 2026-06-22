
@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')

<div>
<h3>Blog Category</h3>
</div>

@if(session('message'))
 <p class="alert alert-success">{{ session('message') }}</p>
@endif

<div class="card mb-4" id="dataTable">
        

    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <a class="btn btn-sm btn-warning" href="">Trush List</a>
        {{-- <a class="btn btn-sm btn-primary" href="">Add New</a> --}}

            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">Add New</button>
          
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                   <p>Create Category</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    {{-- <h4 class="modal-title">Modal Header</h4> --}}
                  </div>
                  <div class="modal-body">
                    <input type="hidden" value="{{ route('blog.category.store') }}" id="blog_category_store_route"/>
                    <label >Enter Category Name</label><br>
                    <form id="blogPost" method="post" >
                      @csrf
                      <div id="">
                    <input type="text" class="form-control name" name="name" id="name" required>
                       </div>
                    </form>
                    {{-- <p>Some text in the modal.</p> --}}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addCategory()">Submit</button>
                  </div>
                </div>


              
                
              </div>
            </div>
            
    </div>
 <div class="card-body">
    {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}
       <table id="datatablesSimple" class="dataTable-table">
           <thead>
                    <tr>
                        
                        <th data-sortable="" style="width: 8.6154%;"><a href="#" class="dataTable-sorter">SL</a></th>
                        <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">Category Name</a></th>
                        <th data-sortable="" style="width: 9.13462%;"><a href="#" class="dataTable-sorter">Created At</a></th>
                        <th data-sortable="" style="width: 9.13462%;"><a href="#" class="dataTable-sorter">Updated At</a></th>
                        <th data-sortable="" style="width: 26.1923%;"><a href="#" class="dataTable-sorter">Action</a></th>
                        {{-- <th data-sortable="" style="width: 11.4423%;"><a href="#" class="dataTable-sorter">Salary</a></th> --}}
                    </tr>
           </thead>
        
           <tbody>

            @foreach ($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->created_at->diffForHumans()}}</td>
                <td>{{ $category->updated_at->diffForHumans()}}</td>
                
                <td>
                  
                 
                  <button id="{{$category->id}}" onclick="btnEdit(this.id)"  type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal">Edit</button>
                 
  
                  <form id="btndelete{{$category->id}}" action="{{ route('blog.category.delete', ['category' => $category->id]) }}" method="POST" 
                    style="display:inline">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-danger btn-sm " id="{{$category->id}}" onclick="btnDelete(this, this.id)" >Delete</button>
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

{{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <p>Edit & Update Category</p>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <form id="" method="post" action="{{route('blog.category.update')}}" >
          @csrf
          <input class="form-control" type="hidden" id="category_id" name="category_id" value="">
        <label style="" class="form-la">Edit Category Name</label><br>
        <input type="text" value="" class="form-control name" name="name" id="category_name" required>    
        {{-- <p>Some text in the modal.</p> --}}
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"  onclick="btnEdit()">update</button>
      </div>
      
    </form>

    </div>
    
  </div>
</div>


{{-- end Edit Modal --}}


@endsection


@push('page_scripts')
<script type="text/javascript" src="{{asset('js/dashboard/blog/category_create.js')}}"></script>
@include('backend.blog.js.category_create_js');


@endpush