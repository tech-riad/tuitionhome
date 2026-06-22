@extends('layouts.app')

@push('page_css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Course Subjects</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('course_subject.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{--   Category import modal start --}}
    <div class="modal fade" id="CourseImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.config.coursesubjects.import.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="">Course subject Import CSV FIle</label>
                            <input type="file" class="form-control" name="import_course_subjects" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--end Course import modal--}}

    <div class="content px-3">

        @include('flash::message')
        @if($errors->has('import_course'))
            <div class="error text-danger">{{ $errors->first('import_course') }}</div>
        @endif
        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#CourseImport"> <i class="fas fa-plus-circle"></i> Import Course</a>
            </div>
            <form action="{{route('courseSubjectsSearch')}}" method="post">
                @csrf
                <div class="card-footer clearfix">
                    <div class="float-right">
                        <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                            style="border: 1px solid #cfdfdb">
                            <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                                placeholder="Search" style="padding: 12px 18px" id="searchInput">
                            <button type="submit" class="btn btn-link" ><i
                                    class="bi bi-search text-muted ms-1"></i></button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-body p-0">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Course Name</th>
                        <th scope="col">Subject Name</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courseSubjects as $courseSubject)
                        <tr>
                            <th scope="row">{{ $loop->iteration }} '{{@$courseSubject->id}}'</th>
                            <td>{{ @$courseSubject->course->name }} '{{@$courseSubject->course_id}}'</td>
                            <td>{{ @$courseSubject->subject->title }} '{{@$courseSubject->subject_id}}'</td>
                            <td><a href="{{ route('course_subject.edit',$courseSubject->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                {{-- | <a href="{{ route('course_subject.delete',$courseSubject->id) }}" class="btn btn-danger" onclick="return window.confirm('are you sure?')"><i class="fa fa-trash"></i></a></td> --}}
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

            {{ $courseSubjects->appends(request()->input())->links() }}

        </div>
    </div>

@endsection
@push('page_scripts')
    <script>
        @if(Session::has('upsuccess'))
        toastr.info('{{ session::get('upsuccess') }}');
        toastr.options.timeOut = 500;
        @endif
        @if(Session::has('deletecourseSubject'))
        toastr.info('{{ session::get('deletecourseSubject') }}');
        toastr.options.timeOut = 500;
        @endif
    </script>

@endpush
