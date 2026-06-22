@extends('welcome')
@push('css')

@endpush
@section('content')

    <div class="col-md-4 offset-md-4 py-5">
        <div class="card shadow">
            <div class="card-header">
                <h3>Tutor Login</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tutor.login.check') }}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-row mb-3">
                            <div class="col">
                                @if(Session::has('passwordError'))
                                    <span class="text-danger">{{ Session::get('passwordError') }}</span>
                                @endif
                                @if(Session::has('user_nameError'))
                                    <span class="text-danger">{{ Session::get('user_nameError') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                        <div class="col-md-12">
                            <div class="form-row mb-3">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Enter Your E-mail or Phone"
                                           name="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row mb-3">
                                <div class="col password-container" id="show_hide_password">
                                    <input type="password" class="form-control" placeholder="Password-23232^$#*"
                                           name="password">
                                    <div class="input-group-addon">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn text-white px-md-5" style="background-color: #7CB305">Login</button>
                        </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
