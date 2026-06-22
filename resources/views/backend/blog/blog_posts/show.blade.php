@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')

<div class="card-header">
    <i class="fas fa-table me-1"></i>
    Post Details
    <a class="btn btn-sm btn-primary" href="{{ route('blog.posts') }}">List</a>
</div>

<div class="row">
    <div class="col-md-7">

        <h3><b>Title</b> :{{ $postdata->title }}</h3>
        <h5 style=""> <b>Short Description</b></h5>
        <p> {{ $postdata->short_description }}</p>
        <h5><b> Long Description</b></h5>
        <p> {{ $postdata->long_description }}</p>



    </div>

    <div class="col-md-5">

        <td><img src="{{ asset('storage/post-image/'. $postdata->image) }}" style="height: 350px ; width: 380px" /></td>

        <h5><b>Post Category:</b></h5>
        <h5>{{ $category}}</h5>
        <br>
        <br>

        <h5><b>Post Tags</b></h5>
        <h5>{{ $tag}}</h5>
        





    </div>

</div>


<div class="card mb-4">
    
    {{-- <div class="card-body">
        <h3>Category: {{ $postdata->category ?? 'N/A' }}</h3>
        <h3>Title: {{ $postdata->short_description }}</h3>
        <h3>Title: {{ $postdata->long_description }}</h3>
        <h3>Title: {{ $postdata->title }}</h3>


       
    </div> --}}


@endsection