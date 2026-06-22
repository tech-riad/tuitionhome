@extends('dashboard.tutor.layout')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endpush

@section('content')
    <div class="t-dashboard-contant  px-2 py-md-3 " style="margin-left: 245px">
        <div class="d-flex justify-content-start  ">
            @include('dashboard.tutor.pages.src.setting_menu')
            <!-- nav ends -->
            <div
                class="mx-1 mx-md-3 flex-fill rounded-2"
                style="background-color: #ffffff"
            >
                <div class="mx-auto w-100">
                    <div
                        style="background-color: #fbfff6; height: 68px"
                        class="d-flex justify-content-start align-items-center px-3 rounded-2"
                    >
                        <h6>Deactivate Your Account</h6>
                    </div>
                    <div class="mx-2 mt-5 mx-md-5 mt-md-5">
                        <div class="p-1">
                            @if(session()->has('message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session()->get('message') }}</strong>
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <p class="t-text-gray">
                                When you delete your account, you lose access to Front
                                account services, and we permanently delete your personal
                                data. You can cancel the deletion for 14 days.
                            </p>
                        </div>
                        @if($current_user->is_active == 0 )
                            <form action="{{ route('tutor.account.deactive') }}" method="post">
                                @csrf
                                <div class="form-check form-switch mt-5 mt-md-4">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="flexSwitchCheckDefault" style="cursor: pointer" name="activate" required
                                    />
                                    <label
                                        class="form-check-label t-text-gray"
                                        for="flexSwitchCheckDefault"style="cursor: pointer"
                                    >Confirm that you want to Activate your account.</label
                                    >
                                </div>

                                <div
                                    class="d-flex flex-column flex-md-row justify-content-md-end justify-content-center mt-5"
                                >

                                    <button
                                        class="t-btn-primary btn px-3 m-3   shadow"
                                        style="background-color: #cb0a0a"
                                    >
                                        Active Again
                                    </button>


                                </div>
                            </form>
                        @else
                            <form action="{{ route('tutor.account.deactive') }}" method="post">
                                @csrf
                                <div class="form-check form-switch mt-5 mt-md-4">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="flexSwitchCheckDefault" style="cursor: pointer" name="deactivate" required
                                    />
                                    <label
                                        class="form-check-label t-text-gray"
                                        for="flexSwitchCheckDefault"style="cursor: pointer"
                                    >Confirm that you want to Deactivate your account.</label
                                    >
                                </div>

                                <div
                                    class="d-flex flex-column flex-md-row justify-content-md-end justify-content-center mt-5"
                                >

                                    <button
                                        class="t-btn-primary btn px-3 m-3   shadow"
                                        style="background-color: #cb0a0a"
                                    >
                                       Deactive
                                    </button>


                                </div>
                            </form>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('js')

@endpush
