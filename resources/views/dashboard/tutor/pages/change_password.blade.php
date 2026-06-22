@extends('dashboard.tutor.layout')
@push('css')

@endpush

@section('content')
    <div class="t-dashboard-contant  px-2 py-md-3 " style="margin-left: 245px">
        <div class="d-flex justify-content-start  ">
            @include('dashboard.tutor.pages.src.setting_menu')
            <!-- nav ends -->
            <form action="{{ route('tutor.change.password') }}" method="post">
                @csrf

            <div class="mx-1 mx-md-3 flex-fill rounded-2" style="background-color: white">
                @if(session()->has('message'))
                    <span class="text-success">{{ session()->get('message') }}</span>
                @endif
                    @if(session()->has('error'))
                        <span class="text-danger">{{ session()->get('error') }}</span>
                    @endif
                <div class="mx-auto w-100">
                    <div
                        style="background-color: #fbfff6; height: 68px"
                        class="d-flex justify-content-start align-items-center px-3 rounded-2"
                    >
                        <h6>Change Password</h6>
                    </div>
                    <div class="mx-0 mx-md-5 mt-3 mt-md-5">
                        <div
                            class="d-flex flex-wrap  justify-content-evenly"
                        >
                            <div class="form-floating mt-3 mb-3 w-75">
                                <input
                                    type="password"
                                    class="form-control t-shadow"
                                    id="pwd"
                                    placeholder="Enter Old password"
                                    name="current_pass"
                                />
                                <label for="phone" class="money-text">Current Password</label>
                                @if($errors->has('current_pass'))
                                    <div class="text-danger">{{ $errors->first('current_pass') }}</div>
                                @endif
                            </div>
                            <div class="form-floating mt-3 mb-3  w-75">
                                <input
                                    type="password"
                                    class="form-control t-shadow"
                                    id="pwd"
                                    placeholder="Enter New password"
                                    name="new_pass"
                                />
                                <label for="phone" class="money-text">New Password</label>
                                @if($errors->has('confirm_pass'))
                                    <div class="text-danger">{{ $errors->first('confirm_pass') }}</div>
                                @endif
                            </div>
                            <div class="form-floating mt-3 mb-3  w-75">
                                <input
                                    type="password"
                                    class="form-control t-shadow"
                                    id="pwd"
                                    placeholder="Enter Confirm password"
                                    name="confirm_pass"
                                />
                                <label for="phone" class="money-text">Re-Type Password</label>
                                @if($errors->has('confirm_pass'))
                                    <div class="text-danger">{{ $errors->first('confirm_pass') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="my-4 d-flex justify-content-center mb-md-5">
                            <button class="t-btn-primary btn px-5 shadow mx-3" {{ (is_active() != true) ? 'disabled':'' }}>Update</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>



@endsection
@push('js')

@endpush
