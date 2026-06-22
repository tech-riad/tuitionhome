@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')



<div>
    <h3>Create Posts</h3>
    </div>


<div class="row">
<div class="col-md-7">

    <form id="editBlade" action="{{route('post.update',$postdata->id)}}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label for="product_title" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="title" value="{{$postdata->title}}">

        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Short Description</label>
            <textarea name="short_description" class="form-control" rows="10" id="short_description" >
                {{ old('short_description', $postdata->short_description) }}  
            </textarea>

        </div>

        <div class="mb-3">
            <label for="description" class="form-contol">Long Description</label>
            <textarea name="long_description" class="form-control description" rows="10" id="long_description">
                {{ old('long_description', $postdata->long_description) }}    
            </textarea>
        </div>

        

    
  </div>

  <div class="col-md-5">
    <div class="mb-3">
        <label for="description" class="form-label">Post Image</label>
        <input name="image" type="file" class="form-control" id="image">

    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">{{$category}}</option>
            @foreach ($categories as $category)
            <option value="{{$category->id}}"{{$postdata->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Tags</label>
        <select name="tag_id" id="category_id" class="form-control">
            <option value="">{{$tag}}</option>
            @foreach ($tags as $tag)
            <option value="{{$tag->id}}"{{$postdata->tag_id == $tag->id ? 'selected' : '' }}>{{$tag->name}}</option>
            @endforeach
        </select>
    </div>


    <div class="col-md-12">
        <button type="button" class="float-right btn btn-success btnUpdate" id="btnUpdate" onclick="btnSubmit(event)">Submit</button>
        <button type="button" class="float-left btn btn-danger">Cancel</button>
     </div>


 </form>


</div>
</div>

@endsection

@push('page_scripts')
<script>

    function btnSubmit(ev){
        ev.preventDefault();
                        Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
                }).then((result) => {
                    if (result.isConfirmed) {

                         $('#editBlade').submit();  
                
            };
            
            
            });

    }
    
</script>
<script type="text/javascript">
    $('#long_description,#short_description').summernote({
        height: 300
    });
</script>

@endpush
