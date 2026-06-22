<!DOCTYPE html>
@extends('layouts.app')

<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')


<div>
    <h3>Create Posts</h3>
    </div>


<div class="row">
<div class="col-md-7">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data" id="createBlade">

        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="title" value="" required>

               @error('title')
                <div class="text-danger">{{ $message }}</div>
               @enderror
        </div>

        <div class="">
            <label for="description" class="form-label">Short Description</label>
            <textarea name="short_description" class="form-control" rows="8" id="short_description" required>    
            </textarea>
            @error('short_description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="">
            <label for="description" class="form-label">Long Description</label>
            <textarea name="long_description" class="form-control" rows="8" id="long_description" required>      
            </textarea>
            @error('long_description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        

    
  </div>

  <div class="col-md-5">
    <div class="mb-3">
        <label for="description" class="form-label">Post Image</label>
        <input name="image" type="file" class="form-control" id="image" required>
        @error('image')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">Select One</option>
            @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
            @error('category_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Tags</label>
        
        <select name="tag_id" id="category_id" class="form-control" required>
            <option value="">Select One</option>
            @foreach ($tags as $tag)
            <option value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
        </select>
            @error('tag_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
    </div>


    <div class="col-md-12">
        <button type="submit" class="float-right btn btn-success" id="submit"onclick="addPost(event)">Submit</button>
        <button type="button" class="float-left btn btn-danger">Cancel</button>
     </div>
 </form>




 @push('page_scripts')
 <script>

     function addPost(ev){
          ev.preventDefault();
         // ver urlToRedirect=ev.currentTarget.getAttribute('href');
         .then((result) => {
              if (result.isConfirmed) {
                 
                Swal.fire('Data insert successfully');
                     $('.createBlade').submit();  
                    
                 };               
                 });
 
     }
 </script>
{{-- 
<script type="text/javascript">
    $('#long_description,#short_description').summernote({
        height: 300
    });
</script> --}}

<script>
    $(document).ready(function () {
        $('#long_description').summernote({
            height: 300, // You can adjust the height as needed
            placeholder: 'Enter your long description here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });
</script>



 
 @endpush
 

@endsection
</html>


