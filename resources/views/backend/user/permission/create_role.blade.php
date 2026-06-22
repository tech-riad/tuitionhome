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
                                <h1>Role Permission</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Role & Permission</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
{{--                role modal Start --}}
                <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create New Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Default box -->
                            <div class="card">
                             @include('errors.message')
                                <div class="card-body">
                                    <form action="{{route('admin.roles.store')}}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="rolename">Role Name</label>
                                                <input type="text" class="form-control" name="rolename" id="rolename" placeholder="Enter Role" required>
                                            </div>


                                            <div class="form-group">
                                                <label>Permissions</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkpermissionAll">
                                                    <label class="form-check-label" for="checkpermissionAll">All</label>
                                                </div>
                                                <hr>
                                                @php $i =1;  @endphp
                                                @foreach($group_permissions as $group)

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="{{ $i }}management" value="{{$group->name}}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox',this)">
                                                                <label class="form-check-label" for="checkpermission">{{$group->name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 role-{{ $i }}-management-checkbox">
                                                            @php
                                                            $permissions = \App\Models\User::getpermissionByGroupName($group->name);
                                                            $j = 1;
                                                            @endphp
                                                            @foreach($permissions as $permission)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" id="permission-{{$permission->id}}" value="{{$permission->name}}">
                                                                    <label class="form-check-label" for="permission-{{$permission->id}}">{{$permission->name}}</label>
                                                                </div>
                                                                @php $j++; @endphp
                                                            @endforeach

                                                        </div>

                                                    </div>

                                                    @php $i++; @endphp

                                                @endforeach


                                            </div>



                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Save Role</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                        </div>
                    </div>
                </div>

                {{--                role modal End --}}

                {{--  Permission modal End --}}

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
                                        <button class="remove float-right" onclick="remove()"><i class="fa fa-minus"></i>Remove</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User List</h3>
                            @if(session()->has('message'))
                                <span style="margin-left: 100px" class="text-success">{{ session()->get('message') }}</span>
                                @endif

                            @if(Auth::user()->role_id == 1)
                            <a href="#" class="btn btn-primary btn-sm float-right" style="margin-left: 10px" data-toggle="modal" data-target="#permissionModal"> <i class="fas fa-plus-circle" style="margin-right: 10px"></i> Add Permission</a>
                            <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-plus-circle"></i> Add Role</a>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$role->name}}</td>
                                        <td>
                                        @foreach($role->permissions as $permission)
                                           <button class="btn btn-info btn-sm mb-1"> {{$permission->name}}</button>
                                        @endforeach
                                        </td>
                                        <td class="btn btn-group">
                                            <a href="{{route('admin.roles.edit',$role->id)}}" class="btn btn-info btn-sm mb-1 "><i class="fa fa-edit"></i></a>
                                            {{-- <a href="{{route('admin.roles.destroy',$role->id)}}" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></a> --}}
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
    @include('backend.user.permission.partial.scripts');
    @include('backend.user.permission.partial.permission_add-js')
    @include('.data_tables.data_table_js')
@endpush


