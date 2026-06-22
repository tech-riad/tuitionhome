
@extends('layouts.app')
@include('.data_tables.data_table_css')
@include('show_js_message.tostar_css')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Country</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Country</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                {{--                add user modal--}}
                <div class="modal fade" id="CountryAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create New Country</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('admin.config.country.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="country_name">Country Name</label>
                                        <input type="text" class="form-control" name="country_name" id="country_name"
                                               placeholder="Enter Country Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_email">Nationality</label>
                                        <input type="text" class="form-control" name="nationality" id="nationality"
                                               placeholder="Nationality">
                                    </div>
                                    <div class="form-group">
                                        <label for="country_flag">Country Flag</label>
                                        <input type="file" class="form-control" name="flag_img" id="country_flag">
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Country</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

{{--                Country          modal start --}}
                <div class="modal fade" id="CountryImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Country</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('admin.config.country.import.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="country_flag">Country CSV FIle</label>
                                         <input type="file" class="form-control" name="import_country" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Import Country</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{--                end country import modal--}}


                <!-- Main content -->
                <section class="content">

                    @if($errors->has('import_country'))
                        <div class="error text-danger">{{ $errors->first('import_country') }}</div>
                    @endif

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#CountryImport" > <i class="fas fa-plus-circle"></i> Import Country</a>
                            <a href="" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#CountryAddModal"> <i class="fas fa-plus-circle"></i> Add Country</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(Session::has('message'))
                                <span class="text-success">{{ session::get('message') }}</span>
                            @endif
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Nationality</th>
                                    <th>Flag</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($countries as $country)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$country->name}}</td>
                                        <td>{{$country->nationality}}</td>
                                        <td><img src="{{asset($country->flag)}}" alt="" height="100" width="100"></td>
                                        <td>
                                            <a href="{{route('admin.config.country.edit',$country->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
{{--                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" data-id ="{{ $country->id }}"  id="deleteBtn"><i class="fa fa-trash"></i></a>--}}
                                            {{-- <a href="{{route('admin.config.country.delete',$country->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure? ')"><i class="fa fa-trash"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card-body -->

                    <!-- /.card -->

                </section>
                <!-- /.content -->
            </div>
        </div>
    </div>
@endsection

@include('data_tables.data_table_js')




