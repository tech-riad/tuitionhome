@extends('layouts.app')
@include('.data_tables.data_table_css')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1> Permission List </h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Permission List</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                {{--                Edit user  modal--}}
                <div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.permission.update') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="username">Group Name</label>
                                        <input type="text" class="form-control" name="permission_group_name" id="permission_group_name"
                                               placeholder="permission group name">
                                        <input type="hidden" name="permission_group_id" id="permission_group_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Permission Name</label>
                                        <input type="text" class="form-control" name="permission_name" id="permission_name"
                                               placeholder="permission name">
                                    </div>


                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            {{--               End Edit user modal--}}

            {{--  Add Permission Model  start--}}

                <div class="modal fade " id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create Permission</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Default box -->
                            <div class="card">
                                @include('errors.message')
                                <div class="card-body">
                                    <form action="{{route('admin.permission.store')}}" method="post">
                                        @csrf
                                        <div class="card-body" id="formfield">
                                            <div class="form-group">
                                                <label for="rolename">Permission Group Name</label>
                                                <input type="text" class="form-control" name="permission_group_name" placeholder="Permission Group" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="rolename">Permission Name</label>
                                                <input type="text" class="form-control" name="permission_name[]"  placeholder=" Permission Name" required>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit " style="margin-left: 20px" class="btn btn-primary">Save Permission</button>
                                        </div>
                                    </form>
                                    <div class="controls">
                                        <button class="add float-left" onclick="add()"><i class="fa fa-plus"></i>Add</button>
                                        {{-- <button class="remove float-right" onclick="remove()"><i class="fa fa-minus"></i>Remove</button> --}}
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                        </div>
                    </div>
                </div>

            {{--  Add Permission Model  End--}}

            <!-- Main content -->
                <section class="content">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Permission List</h3>
                            @if(session()->has('message'))
                                <span style="margin-left: 100px" class="text-success">{{ session()->get('message') }}</span>
                            @endif
                            <a href="#" class="btn btn-primary btn-sm float-right" style="margin-left: 10px" data-toggle="modal" data-target="#permissionModal"> <i class="fas fa-plus-circle" style="margin-right: 10px"></i> Add Permission</a>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group Name</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$permission->group_name}}</td>
                                        <td>{{$permission->name}} </td>
                                        <td class="btn btn-group">
                                            <a href="javascript:void(0);" data-id ="{{$permission->id}} " class="btn btn-info btn-sm editPermissionBtn"><i class="fa fa-edit"></i></a>
{{--                                            <a href="{{route('admin.permission.edit',$permission->id)}}" class="btn btn-info btn-sm mb-1 "><i class="fa fa-edit"></i></a>--}}

                                            {{-- <form id="btndelete{{$permission->id}}" action="{{route('admin.permission.destroy',$permission->id)}}" method="POST"
                                                  style="display:inline">
                                                @csrf
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" id ="{{ $permission->id }}" onclick="btnPermissionDelete(this.id)"><i class="fa fa-trash"></i></a>
                                            </form> --}}

                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </section>
                <!-- /.content -->
            </div>
        </div>
    </div>


@endsection
@push('page_scripts')
    @include('.data_tables.data_table_js')
    @include('backend.user.user_related_js')
    @include('backend.user.permission.partial.permission_add-js')
@endpush


