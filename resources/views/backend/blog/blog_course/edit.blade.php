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

        <form action="{{ route('blog.course.update',$courseBlog->id) }}" method="POST" enctype="multipart/form-data" id="courseForm">
            @csrf
            <div class="mb-3">
                <label for="learn_category" class="form-label">What You Learn?</label>
                <textarea name="learn_category"  class="form-control editor" rows="8" id="learn_category" required>{{@$courseBlog->learn_category ?? @old('learn_category')}}</textarea>

                <div id="learn_category_error" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="about_category_first" class="form-label">About Category</label>
                <textarea name="about_category_first"  class="form-control editor" rows="8" id="about_category_first" required>{{@$courseBlog->about_category_first ?? @old('about_category_first')}}</textarea>
                <div id="about_category_first_error" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="about_category_second" class="form-label">Short Description</label>
                <textarea name="about_category_second"  class="form-control editor" rows="8" id="about_category_second" required>{{@$courseBlog->about_category_second ?? @old('about_category_second')}}</textarea>
                <div id="about_category_second_error" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="slider_image">Slider Profile Image</label>
                <div>
                    <input type="file" name="slider_image[]" class="form-control" id="slider_image" multiple>
                    <br>
                    @if ($courseBlog->slider_image)
                        <div class="old_images mt-2">
                            <label class="mb-0" for="old_images">Old Profile Images:</label><br>
                            @foreach (json_decode($courseBlog->slider_image) as $profileImage)
                                <img class="mt-2" src="{{ asset('storage/course-blog-images/' .$profileImage) }}" alt="Old Profile Image" width="100" height="100" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <label for="course_id" class="form-label">Category</label>
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="">Select One</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @if ($course->id == $courseBlog->course_id)
                            selected

                        @endif>{{ $course->name }}  {{App\Models\Category::where('id',$course->category_id)->pluck('name')}}</option>
                    @endforeach
                </select>
                <div id="course_id_error" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <textarea
                    name="tags"
                    class="form-control"
                    rows="8"
                    id="tags">{{ old('tags', $courseBlog->tags ?? '') }}</textarea>

                <div id="tags_error" class="text-danger"></div>
            </div>


            <div class="col-md-12">
                <button type="submit" class="float-right btn btn-success">Update</button>
            </div>
        </form>

    </div>
</div>

@endsection

@push('page_scripts')
<script>
    $(document).ready(function() {
        $('#courseForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Update successfully",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endpush

</html>
