@php
use Illuminate\Support\Facades\Session;
@endphp
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
                                <li class="breadcrumb-item active">User Create</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            {{--                add user modal--}}
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('admin.users.store')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="username">Name</label>
                                    <input type="text" class="form-control" name="user_name" id="username"
                                        placeholder="Enter User Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_email">Email</label>
                                    <input type="email" class="form-control" name="user_email" id="userEmail"
                                        placeholder="Enter User E-mail" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_phone">Phone</label>
                                    <input type="number" class="form-control" name="user_phone" id="userPhone"
                                        placeholder="Enter User Phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_password">Password</label>
                                    <input type="password" class="form-control" name="user_password" id="userPassword"
                                        placeholder="Enter User Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_password">User Role</label>
                                    <select name="user_role" id="userRole" class="form-control" required>
                                        <option value="">~Select Role~</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Add Modal --}}
            <div class="modal fade" id="RoleModal" tabindex="-1" role="dialog" aria-labelledby="RoleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="RoleModalLabel">Create New Role Model</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('admin.model.role.setup')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="user_password">User Role</label>
                                    <select name="role_id" id="userRole" class="form-control" required>
                                        <option value="">~Select Role~</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{--               End add user modal--}}


            {{--                Edit user  modal--}}
            <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('admin.user.update')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="username">Name</label>
                                    <input type="text" class="form-control" name="user_name" id="user_name"
                                        placeholder="Enter User Name">
                                    <input type="hidden" name="user_id" id="us_id">
                                </div>
                                <div class="form-group">
                                    <label for="user_email">Email</label>
                                    <input type="email" class="form-control" name="user_email" id="user_email"
                                        placeholder="Enter User E-mail">
                                </div>
                                <div class="form-group">
                                    <label for="user_phone">Phone</label>
                                    <input type="number" class="form-control" name="user_phone" id="user_phone"
                                        placeholder="Enter User Phone">
                                </div>
                                <div class="form-group">
                                    <label for="user_password">Password</label>
                                    <input type="text" class="form-control" name="user_password" id="user_password"
                                        placeholder="Enter User Password">
                                </div>
                                <div class="form-group">
                                    <label for="user_password">User Role</label>
                                    <select name="user_role" id="user_role" class="form-control">
                                        <option value="">~Select Role~</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{--               End Edit user modal--}}

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">User List <span class="p-4"></span> <a href=""
                                class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#RoleModal">
                                <i class="fas fa-plus-circle"></i> Add Model</a>
                        </h3>

                        <a href="{{route('admin.user.change.password')}}" class="btn btn-danger btn-sm float-right ml-2" > <i class="fas fa-plus-circle"></i> Password Reset</a>
                        <a href="" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#exampleModal"> <i class="fas fa-plus-circle"></i> Add User</a>
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
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->role_id}}</td>
                                    <td>
                                        <a href="javascript:void(0);" data-id="{{$user->id}}"
                                            class="btn btn-info btn-sm editBtn"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('admin.user.view',$user->id)}}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                        {{-- <form id="btndelete{{$user->id}}"
                                        action="{{ route('admin.user.delete',$user->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="{{ $user->id }}"
                                            onclick="btnDelete(this.id)"><i class="fa fa-trash"></i></a>
                                        </form> --}}
                                        {{--                                            <a href="{{route('admin.user.delete',$user->id)}}"
                                        class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure? ')"><i
                                            class="fa fa-trash"></i></a>--}}
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
{!! JsValidator::formRequest('App\Http\Requests\CreateUserRequest') !!}
@endsection
@push('third_party_scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@endpush
@include('backend.user.user_related_js')
@include('data_tables.data_table_js')
@include('show_js_message.show_js')
