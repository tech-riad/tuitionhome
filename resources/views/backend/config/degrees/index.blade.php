@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Degrees</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('degrees.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{--   Degree import modal start --}}
    <div class="modal fade" id="DegreeImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Degree</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.config.degree.import.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="country_flag">Degree Import CSV FIle</label>
                            <input type="file" class="form-control" name="import_degree" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Degree</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--end Degree import modal--}}

    <div class="content px-3">

        @include('flash::message')
        @if($errors->has('import_curricula'))
            <div class="error text-danger">{{ $errors->first('import_curricula') }}</div>
        @endif
        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#DegreeImport" > <i class="fas fa-plus-circle"></i> Import Degree</a>
            </div>
            <div class="card-body p-0">
                @include('backend.config.degrees.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>
            {{ $degrees->links() }}
        </div>
    </div>

@endsection

