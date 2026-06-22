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
                                <h1> Role Permission</h1>
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

                <!-- Main content -->
                <section class="content">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit '{{$role->name}}'</h3>
                            <a href="{{route('admin.roles.index')}}" class="btn btn-primary btn-sm float-right" > <i class="fas fa-list"></i> All Role</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                                @include('errors.message')
                                    <form action="{{route('admin.roles.update',$role->id)}}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="rolename">Role Name</label>
                                                <input type="text" class="form-control" name="rolename" value="{{$role->name}}" id="rolename" placeholder="Enter Role" required>
                                            </div>


                                            <div class="form-group">
                                                <label>Permissions</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkpermissionAll" {{  \App\Models\User::roleHasPermission($role,$All_permissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="checkpermissionAll">All</label>
                                                </div>
                                                <hr>
                                                @php $i =1;  @endphp
                                                @foreach($group_permissions as $group)
                                                @php
                                                    $permissions = \App\Models\User::getpermissionByGroupName($group->name);
                                                    $j = 1;
                                                @endphp

                                                @if($group->name !== 'Role Permission' || Auth::user()->role_id == 1)
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="{{ $i }}management" value="{{$group->name}}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox',this)" {{ \App\Models\User::roleHasPermission($role, $permissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="checkpermission">{{$group->name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 role-{{ $i }}-management-checkbox">
                                                            @foreach($permissions as $permission)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                                        type="checkbox" name="permissions[]" id="permission-{{$permission->id}}" value="{{$permission->name}}"
                                                                        onclick="checkSinglePermission('role-{{ $i }}-management-checkbox','{{ $i }}management',{{count($permissions)}})">
                                                                    <label class="form-check-label" for="permission-{{$permission->id}}">{{$permission->name}}</label>
                                                                </div>
                                                                @php $j++; @endphp
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @php $i++; @endphp
                                            @endforeach



                                            </div>



                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Update Role</button>
                                        </div>
                                    </form>
                                </div>

                    </div>

                </section>
                <!-- /.content -->
            </div>
        </div>
    </div>


@endsection
@push('page_scripts')
@include('backend.user.permission.partial.scripts');

@endpush
