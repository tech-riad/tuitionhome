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
                            <h1> User Activity </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">User Activity</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>


            {{--  Add Permission Model  End--}}

            <!-- Main content -->
            <section class="content">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Activity</h3>
                        @if(session()->has('message'))
                        <span style="margin-left: 100px" class="text-success">{{ session()->get('message') }}</span>
                        @endif


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Name</th>
                                    <th>Login At</th>
                                    <th>Desk Agent</th>
                                    <th>Logout At</th>
                                    <th>Logout Reason</th>
                                    <th>Approxomate Duration</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($activities as $item)
                                <tr>
                                    <td>{{$loop->iteration ?? ''}}</td>
                                    <td>{{$item->name ?? ''}}({{$item->user_id ?? ''}})</td>
                                    <td>{{ $item->login_at ? \Carbon\Carbon::parse($item->login_at)->format('Y-m-d h:i:s A') : '' }}</td>
                                    <td>{{$item->user_agent ?? ''}}</td>
                                    <td>{{ $item->logout_at ? \Carbon\Carbon::parse($item->logout_at)->format('Y-m-d h:i:s A') : '' }}</td>
                                    <td class=" @if ($item->logout_reason == 'Inactive')
                                        text-red
                                    @endif ">{{$item->logout_reason ?? ''}}</td>
                                    <td>{{$item->logout_duration_apx ?? ''}}</td>

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
