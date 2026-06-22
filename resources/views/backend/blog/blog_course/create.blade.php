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

        <form action="{{ route('blog.course.store') }}" method="POST" enctype="multipart/form-data" id="courseForm">
            @csrf

            <div class="mb-3">
                <label for="learn_category" class="form-label">What You Learn?</label>
                <textarea name="learn_category" class="form-control" rows="8" id="learn_category" required></textarea>
                <div id="learn_category_error" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="about_category_first" class="form-label">About Category</label>
                <textarea name="about_category_first" class="form-control" rows="8" id="about_category_first" required></textarea>
                <div id="about_category_first_error" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="about_category_second" class="form-label">Short Description</label>
                <textarea name="about_category_second" class="form-control" rows="8" id="about_category_second" required></textarea>
                <div id="about_category_second_error" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="slider_image" class="form-label">Post Images</label>
                <input name="slider_image[]" type="file" class="form-control" id="slider_image" multiple required>
                <div id="slider_image_error" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="course_id" class="form-label">Category</label>
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="">Select One</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}  {{App\Models\Category::where('id',$course->category_id)->pluck('name')}}</option>
                    @endforeach
                </select>
                <div id="course_id_error" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <textarea name="tags" class="form-control" rows="8" id="tags" ></textarea>

                <div id="tags_error" class="text-danger"></div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="float-right btn btn-success" id="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page_scripts')

@endpush

</html>
