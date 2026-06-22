<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Id:') !!}
    {!! Form::select('category_id', $categoryItems, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('course_image', 'Image:') !!}
    {{-- @if ($courses->course_image)
        <img src="{{ asset('storage/course-images/' . $courses->course_image) }}" alt="Course Image" style="max-width: 100px;">
    @endif --}}
    {!! Form::file('course_image', ['class' => 'form-control']) !!}
</div>

@if(isset($courses) && $courses->course_image)
    <div class="form-group col-sm-6">
        <label>Current Image:</label>
        <img style="height: 120px;width:120px;" src="{{ asset('storage/course-images/' . $courses->course_image) }}" alt="Current Image" class="img-thumbnail">
    </div>
@endif
