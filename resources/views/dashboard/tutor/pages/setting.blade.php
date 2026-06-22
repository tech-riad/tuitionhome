@extends('dashboard.tutor.layout')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endpush

@section('content')

    <div class="t-dashboard-contant  px-2 py-md-3 " style="margin-left: 245px">
        <div class="d-flex justify-content-start  ">

            @include('dashboard.tutor.pages.src.setting_menu')
            <!-- nav ends -->
            <div class="mx-1 mx-md-3 flex-fill rounded-2" style="background-color: white">
                <div class="mx-auto w-100 ">

                    <div
                        style="background-color: #fbfff6; height: 68px"
                        class="d-flex justify-content-start align-items-center px-3 rounded-2"
                    >

                    </div>
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-12">
                                    @if(session()->has('message'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session()->get('message') }}
                                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                  <div style="margin-bottom: 20px;text-align: center">
                                        <span
                                            style="border: 1px solid #9ECE66;
                                          background-color: #9ECE66;
                                          color: white;
                                          font-weight: bold;
                                          font-size: 17px;
                                          border-radius: 107px;
                                          padding: 10px;
                                          ">1</span>
                                  </div>
                                    <div class="info-box">
                                        <span class="info-box-icon " style="background-color: #9ECE66;color: white"><i class="fa fa-user"></i></span>
                                        <div class="info-box-content">
                                            <span data-bs-toggle="modal" data-bs-target="#tutor_name" style="cursor: pointer">
                                            <span class="info-box-text">Name</span>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                        <div class="modal fade" id="tutor_name" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Change Name </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('change.name') }}" method="post">
                                                            @csrf
                                                            <div class="form-group row">
                                                                <label for="phone" class="col-sm-2 col-form-label">Name</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" value="{{ ($tutor_info->name !=null )? $tutor_info->name :'' }}" class="form-control-plaintext" name="name" id="name" placeholder="Enter Name" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" {{ (is_active() != true) ? 'disabled':'' }}>Update</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div style="margin-bottom: 20px;text-align: center">
                                        <span
                                            style="border: 1px solid #9ECE66;
                                          background-color: #9ECE66;
                                          color: white;
                                          font-weight: bold;
                                          font-size: 17px;
                                          border-radius: 107px;
                                          padding: 10px;
                                          ">2</span>
                                    </div>
                                    <div class="info-box">
                                        <span class="info-box-icon " style="background-color: #9ECE66;color: white"><i class="fas fa-phone"></i></span>

                                        <div class="info-box-content">
                                            <span data-bs-toggle="modal" data-bs-target="#tutor_phone" style="cursor: pointer">
                                            <span class="info-box-text">Phone</span>
                                            </span>
                                        </div>
                                        <div class="modal fade" id="tutor_phone" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Change Phone </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('change.phone') }}" method="post">
                                                            @csrf
                                                            <div class="form-group row">
                                                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                                                <div class="col-sm-10">
                                                                    <input type="tel" value="{{ ($tutor_info->phone !=null )? $tutor_info->phone :'' }}" class="form-control-plaintext" name="phone" id="phone" placeholder="Enter Number" ng-pattern="/^(?:\+88|01)?\d{11}\r?$/" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" {{ (is_active() != true) ? 'disabled':'' }}>Update</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div style="margin-bottom: 20px;text-align: center">
                                        <span
                                            style="border: 1px solid #9ECE66;
                                          background-color: #9ECE66;
                                          color: white;
                                          font-weight: bold;
                                          font-size: 17px;
                                          border-radius: 107px;
                                          padding: 10px;
                                          ">3</span>
                                    </div>
                                    <div class="info-box">
                                        <span class="info-box-icon" style="background-color: #9ECE66;color: white"><i class="fas fa-envelope"></i></span>
                                        <div class="info-box-content" >
                                            <span data-bs-toggle="modal" data-bs-target="#tutor_email" style="cursor: pointer">
                                            <span class="info-box-text">Email</span>
                                            </span>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="tutor_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">E-mail Change</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('change.email') }}" method="post">
                                                            @csrf
                                                            <div class="form-group row">
                                                                <label for="staticEmail" class="col-sm-2 col-form-label">E-mail</label>
                                                                <div class="col-sm-10">
                                                                    <input type="email" value="{{ ($tutor_info->email !=null )? $tutor_info->email :'' }}" class="form-control-plaintext" name="email" id="staticEmail" placeholder="email@example.com" required  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" {{ (is_active() != true) ? 'disabled':'' }}>Update</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>

                            </div>
                            <!-- /.row -->

                        </div><!-- /.container-fluid -->
                    </section>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('js')

@endpush
