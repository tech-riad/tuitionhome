@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('course_subject.index') }}">
                        All
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header"><h2>Course Subject Add</h2></div>
                        <div class="card-body shadow">
                            <form action="{{ route('course_subject.update',$courseSubject->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Course Name</label>
                                    <select name="course_id" id="course" class="form-control select2" required >
                                        <option value="">~select course name~</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ ($courseSubject->course_id== $course->id)? 'selected': '' }} >{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Subject Name</label>
                                    <select name="subject_id" id="subject" class="form-control select2" required>
                                        <option value="">~select Subject name~</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ ($courseSubject->subject_id== $subject->id)? 'selected': '' }} >{{ $subject->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('page_scripts')
    <script type="text/javascript">
        @if(Session::has('success'))
        toastr.info('{{ session::get('success') }}');
        toastr.options.timeOut = 500;
        @endif

        $("#course").select2({
            width: "100%",
        });
        $("#subject").select2({
            width: "100%",
            height:"10%",
        });
    </script>
@endpush

