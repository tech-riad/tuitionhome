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
        <a type="button" href="{{route('blog.course.create')}}" class="btn btn-sm btn-primary">Add New</a>


    </div>
    <div class="card-body">
        {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}
            <table class="dataTable-table">
                <thead>
                    <tr>
                        <th style="width: 8.6154%;">SL</th>
                        <th style="width: 18.5769%;">Slider Image</th>
                        <th style="width: 18.5769%;">Course Name</th>
                        <th style="width: 9.13462%;">Learn Description</th>
                        <th style="width: 26.1923%">About category</th>
                        <th style="width: 26.1923%;">Short Description</th>
                        <th style="width: 9.13462%;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($blogposts as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($item->slider_image)
                                    @foreach(json_decode($item->slider_image) as $image)
                                        <img style="height: 30px; width: 30px;" src="{{ asset('storage/course-blog-images/' . $image) }}" alt="Image" class="img-thumbnail">
                                    @endforeach
                                @else
                                    <span>n/a</span>
                                @endif
                            </td>

                            <td>{!! $item->courses && $item->courses->name ? Str::limit($item->courses->name, 100) : 'n/a' !!}</td>
                            <td>{!! $item->learn_category ? Str::limit($item->learn_category, 100) : 'n/a' !!}</td>
                            <td>{!! $item->about_category_first ? Str::limit($item->about_category_first, 100) : 'n/a' !!}</td>
                            <td>{!! $item->about_category_second ? Str::limit($item->about_category_second, 100) : 'n/a' !!}</td>

                            <td>
                                <a href="{{ route('blog.course.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        <div class="d-flex justify-content-center align-items-center gap-2">

                    {{ $blogposts->appends(request()->except('page'))->links() }}

                </div>
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
                <form id="" method="post" action="{{route('blog.category.update')}}">
                    @csrf
                    <input class="form-control" type="hidden" id="category_id" name="category_id" value="">
                    <label style="" class="form-la">Edit Category Name</label><br>
                    <input type="text" value="" class="form-control name" name="name" id="category_name" required>
                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="btnEdit()">update</button>
            </div>

            </form>

        </div>

    </div>
</div>


{{-- end Edit Modal --}}


@push('page_scripts')
<script type="text/javascript" src="{{asset('js/dashboard/blog/category_create.js')}}"></script>
@endpush

@endsection