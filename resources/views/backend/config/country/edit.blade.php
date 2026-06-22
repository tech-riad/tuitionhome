
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
                                <h1>Users</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Country edit</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>



                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Country List</h3>
                            <a href="{{route('admin.config.country.index')}}" class="btn btn-primary btn-sm float-right"> <i class="fas fa-list"></i> ALl Country</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{route('admin.config.country.update',$country->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="country_name">Country Name</label>
                                        <input type="text" class="form-control" name="country_name" value="{{$country->name}}" id="country_name"
                                               placeholder="Enter Country Name">
                                        <input type="hidden" id="country_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_email">Nationality</label>
                                        <input type="text" class="form-control" name="nationality" value="{{$country->nationality}}" id="nationality"
                                               placeholder="Nationality">
                                    </div>
                                    <div class="form-group">
                                        <label for="country_flag">Country Flag</label>
                                        <input type="file" class="form-control" name="flag_img" value="{{$country->flag}}" id="country_flag">
                                        <img src="{{asset($country->flag)}}" alt="" height="100" width="100">
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Country</button>
                                </div>
                            </form>
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




