@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cities</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('cities.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{--   City import modal start --}}
    <div class="modal fade" id="CityImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import City</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.config.city.import.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="country_flag">City Import CSV FIle</label>
                            <input type="file" class="form-control" name="import_city" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import City</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--end City import modal--}}

    <div class="content px-3">

        @include('flash::message')
        @if($errors->has('import_city'))
            <div class="error text-danger">{{ $errors->first('import_city') }}</div>
        @endif

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#CityImport"> <i class="fas fa-plus-circle"></i> Import City</a>
            </div>
            <form action="{{route('citiesSearch')}}" method="post">
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
                @include('backend.config.cities.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

            {{ $cities->links() }}

        </div>
    </div>

@endsection

