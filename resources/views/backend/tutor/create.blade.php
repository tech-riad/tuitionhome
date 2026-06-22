@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
@section('content')


<div class="content-header">
    <h1><i class="fa fa-bars"></i>
        New Tutor
    </h1>
</div>



<!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">Add New</button> -->

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->


        <div class="modal-content">
            <div class="d-flex justify-content-center align-items-center container">
                <div class="card py-5 px-2">
                    <h5 class="m-0">Mobile phone verification</h5><span class="mobile-text">Enter the code we just send
                        on your mobile phone <b class="text-green">+91 86684833</b></span>
                    <form action="{{route('admin.tutor.verify-phone')}}" method="post" id="otpForm">
                        @csrf
                        <div class="d-flex flex-row mt-3">
                        </div>
                        <div class="form-group mb-3">

                            <input type="hidden" class="form-control" name="tutor_id" id="tutor_id" value="">
                            <input type="text" name="phone_otp" value="" class="form-control">
                            <span class="text-danger error-text otp_error"></span>
                            <span class="text-danger error-text otp_error2"></span>
                        </div>
                        <div class="text-center mt-3"><span class="d-block mobile-text">Don't receive the
                                code?</span><span class="font-weight-bold text-green cursor">Resend</span></div>
                        <br>
                        <button type="submit" class="btn btn-primary form-control" data-dismiss="modal"
                            onclick="">Submit</button>

                    </form>
                </div>

            </div>
        </div>

    </div>
</div>





<div class="row d-flex justify-content-center">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="col-md-6">
        <form action="{{route('tutor.store')}}" method="POST" id="createForm">
            @csrf
            <div class="form-group mb-3">
                <label>Tutor name</label>
                <input type="text" name="name" value="" class="form-control " placeholder="Full name">
                <span class="text-danger error-text name_error"></span>
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="email" name="email" value="" class="form-control " placeholder="Email">
                <span class="text-danger error-text email_error"></span>
            </div>
            <div class="form-group mb-3">
                <label>Phone</label>
                <input type="phone" name="phone" value="" class="form-control " placeholder="phone">
                <span class="text-danger error-text phone_error"></span>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Genger</label>
                <select name="gender" id="" class="form-control">
                    <option value="">Select One</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <span class="text-danger error-text gender_error"></span>

            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <input type="text" name="password" class="form-control" value="" placeholder="Password">
                <span class="text-danger error-text password_error"></span>
            </div>
            <div class="form-group mb-3">
                <label>Confirm Password</label>
                <input type="text" name="confirm_password" class="form-control" value="" placeholder="Password">
                <span class="text-danger error-text confirm_password_error"></span>
            </div>
            <div class="row">

                <div class="col-4">
                    <button id="" type="submit" class="btn btn-primary btn-block" data-target="#myModal">Save
                        Tutor</button>
                </div>

            </div>
        </form>
    </div>
</div>







@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('backend.tutor.js.create_page_js')
