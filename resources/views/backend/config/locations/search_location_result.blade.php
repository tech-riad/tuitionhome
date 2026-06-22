@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Locations</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('locations.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{--   Location import modal start --}}
    <div class="modal fade" id="LocationImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.config.location.import.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="country_flag">Location Import CSV FIle</label>
                            <input type="file" class="form-control" name="import_location" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--end Location import modal--}}
    <div class="content px-3">

        @include('flash::message')
        @if($errors->has('import_location'))
            <div class="error text-danger">{{ $errors->first('import_location') }}</div>
        @endif
        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header">
                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#LocationImport" > <i class="fas fa-plus-circle"></i> Import Location</a>
            </div>
            <div class="card-body p-0">
                <div class="card-body p-0">
                    <div class="card-footer clearfix">
                        <form action="{{route('locationSearch')}}" method="post">
                            @csrf
                            <div class="float-right">
                                <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                                    style="border: 1px solid #cfdfdb">
                                    <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                                        placeholder="Search" style="padding: 12px 18px" id="searchInput">
                                    <button type="submit" class="btn btn-link" ><i
                                            class="bi bi-search text-muted ms-1"></i></button>
                                </div>
                            </div>
                        </form>



                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="locations-table">
                        <thead>
                        <tr>
                            <th>Country Name</th>
                        <th>City Name</th>
                        <th>Name</th>
                            <th colspan="3">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($location as $item)
                            <tr>
                            <td>{{ $item->country->name }}</td>
                            <td>{{ $item->city->name }}</td>
                            <td>{{ $item->name }}</td>
                                <td width="120">
                                    {!! Form::open(['route' => ['locations.destroy', $item->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a href="{{ route('locations.show', [$item->id]) }}"
                                           class='btn btn-default btn-xs'>
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('locations.edit', [$item->id]) }}"
                                           class='btn btn-default btn-xs'>
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </div>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
            @if($location->count() > 0)
                <div class="card-footer clearfix">
                    <div class="float-left">
                        {{ $location->appends(request()->input())->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection



