@extends('welcome')
@section('content')
    <div class="col-md-8 offset-md-2 py-5">
        <div class="card shadow">
            <div class="card-header">
                <h3>Tutor Register</h3>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                    <span class="text-danger">{{ Session::get('message') }}</span>
                @endif
                <form action="{{ route('tutor.register.store') }}" method="post">
                    @csrf
                        <div class="col-md-12">
                            <div class="form-row mb-3">
                                <div class="col">
                                    <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder=" Enter Your Name" name="name" required>
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="number" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Your Number"
                                           name="phone" required>
                                    @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row mb-3">
                                <div class="col">
                                    <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Your E-mail"
                                           name="email" required>
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <select name="gender" id="" class="form-control @error('gender') is-invalid @enderror" required>
                                        <option value="">~Select Gender~</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    @error('gender')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row mb-3">
                                <div class="col password-container" id="show_hide_password">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                           name="password" required autocomplete="false">
                                    <div class="input-group-addon">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col password-container" id="show_hide_password">
                                    <input type="password" class="form-control @error('cpassword') is-invalid @enderror" placeholder="Re-type password"
                                           name="cpassword" required>
                                    <div class="input-group-addon">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                    @error('cpassword')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn text-white  px-md-5" style="background-color: #7CB305"> Create Account</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
