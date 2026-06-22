@php
    use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.app')
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
                                    <li class="breadcrumb-item active">User View</li>
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
                            <h3 class="card-title">Single User</h3>
                            <a href="" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-plus-circle"></i> All User</a>
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    {{-- <th>Role</th>
                                    <th>Action</th> --}}
                                </tr>
                                </thead>
                                <tbody>



                                    <tr>
                                        <td>{{$users->name ?? ''}}</td>
                                        <td>{{$users->email}}</td>
                                        <td>{{$users->phone}}</td>
                                        <td>{{$users->role_id}}</td>
                                        {{-- <td>
                                            <a href="javascript:void(0);" data-id ="{{$users->id}}" class="btn btn-info btn-sm editBtn"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('admin.user.view',$users->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>

                                            <a href="{{route('admin.user.delete',$users->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure? ')"><i class="fa fa-trash"></i></a>
                                        </td> --}}
                                    </tr>


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
    @include('backend.user.user_related_js')
    @include('data_tables.data_table_js')
    @include('show_js_message.show_js')
@endsection




