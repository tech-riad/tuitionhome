@extends('dashboard.tutor.layout')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="t-dashboard-contant p-4">
        <!-- top section -->
        <div class="row">
            <div class="col-md-8 t-d-welcome-section mb-4 mb-md-0 row">
                <div class="col-md-8">
                    <h4 class="t-text-gray">
                        <span class="mx-1">Hi, </span> {{ Auth::guard('tutor')->user()->name }}
                    </h4>
                    <h1 class="t-text-gray-big">Welcome to tution tarminal</h1>
                    <div class="t-text-intro mt-4">
                        <p class="">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit.sit
                            amet consectetur adipisicing elit. Praesentium, quidem!
                            Voluptates in nam corporis accusamus, explicabo ex
                            voluptatibus vitae dolorum!
                        </p>
                    </div>
                </div>
                <div class="col-md-3 d-none d-md-block">
                    <img src="{{ asset('/dashboard/tutor') }}/assets/boy-with-laptop.svg" alt="boy-with-laptop" />
                </div>
            </div>
            <div class="col-md-4 t-d-member">
                <p class="mx-3" style="font-size: 18px; font-weight: 400">
                    Member Since
                </p>
                <div class="t-date-box mx-auto w-100">
                    <div class="t-logo-container mx-3">
                        <img
                            style="margin-left: -3px; margin-top: -2px"
                            src="{{ asset('/dashboard/tutor') }}/assets/profile-icon-white.svg"
                            alt="home-icon"
                        />
                        <p class="t-sidebar-item-text fs-5">12 Feb 2023</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- after top section ends -->
        <!-- top section -->
        <div class="row mt-4">
            <div class="col-md-6 mb-4 mb-md-0 t-d-card p-4 position-relative">
                <div class="d-flex text-white align-items-center">
                    <h1 class="fs-2">Membership</h1>
                    <button class="mx-4 t-save-btn px-4">Save 400</button>
                </div>
                <p class="text-white">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi
                    sequi saepe enim tempora. Illum obcaecati voluptate odio? In
                    recusandae ex rerum quam eius tempora tempore.
                </p>
                <div class="d-flex justify-content-between">
                    <p class="text-white fw-bold fs-4">
                        450<span class="fs-5 fw-light t-gray">/months</span>
                    </p>
                    <button class="t-save-btn-fill fs-5 px-5">Try 6 months</button>
                </div>
            </div>

            <div class="col-md-6 t-d-card-white p-4">
                <h3 class="fs-5 fw-400">Notice Board</h3>
                <div class="t-text-intro mt-4">
                    <p class="t-normal-text notice">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit.sit
                        amet consectetur adipisicing elit. Praesentium, quidem!
                        Voluptates in nam corporis accusamus, explicabo ex
                        voluptatibus vitae dolorum!voluptatibus vitae dolorum!
                    </p>
                </div>
                <p class="fw-light mt-4 date">5 Feb 2023</p>
            </div>
        </div>
        <!-- after top section ends -->
        <!-- profile cards section -->
        <div class="row mt-4 mx-auto">
            <!-- Card -->
            <div
                class="t-d-md-card position-relative ml-cut-4 col-md-5 margin-right col-12 mb-4 mb-md-0"
            >
                <div class="row pb-4">
                    <div class="t-icon-container-big col-2">
                        <img class="" src="{{ asset('/dashboard/tutor') }}/assets/profile-icon.svg" />
                    </div>
                    <div class="col-10">
                        @php($complated =  auth()->guard('tutor')->user()->getProfileComplete())
                        <h2>{{ $complated }} %</h2>
                        <div>
                            @if($complated < 80)
                                <span>To get better response, complete your tutor profile at least 80% & grab the opportunities now! </span>
                            @else
                                <span>Congratulations!  Your tutor profile is now completed with 80% informations. Well organized profile may help to get more benefits. </span>
                            @endif
                        </div>
                    </div>
                </div>
                <button
                    class="t-text-btn position-absolute"
                    style="
                  bottom: 20px;
                  right: 20px;
                  font-size: 12px;
                  font-weight: 500;
                "
                >
                    <a href="{{ route('tutor.profile.update') }}"> Update profile</a>
                    <img class="mx-3" src="{{ asset('/dashboard/tutor') }}/assets/right-arrow.svg" />
                </button>
            </div>
            <!-- Card end -->
            <!-- Card -->
            <div
                class="t-d-md-card position-relative margin-right col-md-4 col-12 mb-4 mb-md-0"
            >
                <div class="row pb-4">
                    <div class="t-fake col-2">
                        <img class="" src="{{ asset('/dashboard/tutor') }}/assets/Location.svg" />
                    </div>
                    <div class="col-10 width-c">
                        <h1>09</h1>
                        <p class="t-gray">doloremque unde magni quo accusantium</p>
                    </div>
                </div>
                <button
                    class="t-text-btn position-absolute"
                    style="
                  bottom: 20px;
                  right: 20px;
                  font-size: 12px;
                  font-weight: 500;
                "
                >
                    Update profile
                    <img class="mx-3" src="{{ asset('/dashboard/tutor') }}/assets/right-arrow.svg" />
                </button>
            </div>
            <!-- Card end -->

            <div class="col-md-3 col-12 t-resume">
                <p class="" style="font-size: 18px; font-weight: 500">Resume</p>
                <div class="mx-auto">
                    <!-- <div class="t-logo-container mx-3">
                    <img
                      style="margin-left: -3px; margin-top: -2px"
                      src="assets/profile-icon-white.svg"
                      alt="home-icon"
                    />
                    <p class="t-sidebar-item-text fs-5">12 Feb 2023</p>
                  </div> -->
                    <div class="t-user-resume px-2">
                        <div class="t-icon-container-mid">
                            <img class="" src="{{ asset('/dashboard/tutor') }}/assets/sms.svg" />
                        </div>
                        <div class="mt-3">
                            <p>MyResume.pdf</p>
                        </div>
                        <div>
                            <img src="{{ asset('/dashboard/tutor') }}/assets/arrow-down.svg" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile cards section end-->
        <!-- mini card section -->
        <div class="row ml-cut-4">
            <!-- mini card -->
            <div
                class="t-mini-card mt-4 d-flex col-5 col-md-2 ml-cut-4 mx-auto mx-md-1"
            >
                <div
                    class="t-mini-card-icon-container"
                    style="background-color: #1890ff"
                >
                    <img class="" src="{{ asset('/dashboard/tutor') }}/assets/home-trend-down.svg" />
                </div>
                <div class="mini-card-detail">
                    <h4>8</h4>
                    <p class="t-gray">Jop Aplied</p>
                </div>
            </div>
            <!-- mini card end -->
            <!-- mini card -->
            <div class="t-mini-card mt-4 d-flex col-5 col-md-2 mx-auto mx-md-1">
                <div
                    class="t-mini-card-icon-container"
                    style="background-color: #1890ff"
                >
                    <img class="" src="{{asset('/dashboard/tutor')}}/assets/home-trend-down.svg" />
                </div>
                <div class="mini-card-detail">
                    <h4>6</h4>
                    <p class="t-gray">Shortlisted</p>
                </div>
            </div>
            <!-- mini card end -->
            <!-- mini card -->
            <div class="t-mini-card mt-4 d-flex col-5 col-md-2 mx-auto mx-md-1">
                <div
                    class="t-mini-card-icon-container"
                    style="background-color: #f4a118"
                >
                    <img class="" src="{{ asset('/dashboard/tutor') }}/assets/home-trend-down.svg" />
                </div>
                <div class="mini-card-detail">
                    <h4>12</h4>
                    <p class="t-gray">Appointed</p>
                </div>
            </div>
            <!-- mini card end -->
            <!-- mini card -->
            <div class="t-mini-card mt-4 d-flex col-5 col-md-2 mx-auto mx-md-1">
                <div
                    class="t-mini-card-icon-container"
                    style="background-color: #7cb305"
                >
                    <img class="" src="{{ asset('/dashboard/tutor') }}/assets/home-trend-down.svg" />
                </div>
                <div class="mini-card-detail">
                    <h4>10</h4>
                    <p class="t-gray">Jop Confarm</p>
                </div>
            </div>
            <!-- mini card end -->
            <!-- mini card -->
            <div class="t-mini-card mt-4 d-flex col-5 col-md-2 mx-auto mx-md-1">
                <div
                    class="t-mini-card-icon-container"
                    style="background-color: #7cb305"
                >
                    <img class="" src="{{ asset('/dashboard/tutor') }}/assets/home-trend-down.svg" />
                </div>
                <div class="mini-card-detail">
                    <h4>5</h4>
                    <p class="t-gray">Payment</p>
                </div>
            </div>
            <!-- mini card end -->
            <!-- mini card -->
            <div class="t-mini-card mt-4 d-flex col-5 col-md-2 mx-auto mx-md-1">
                <div
                    class="t-mini-card-icon-container"
                    style="background-color: #e73f3f"
                >
                    <img class="" src="{{ asset('/dashboard/tutor') }}/assets/home-trend-down.svg" />
                </div>
                <div class="mini-card-detail">
                    <h4>12</h4>
                    <p class="t-gray">Cancel</p>
                </div>
            </div>
            <!-- mini card end -->
        </div>
        <!-- mini card section end -->
    </div>

    <!-- conent section ends -->
    </div>

    <!-- Button trigger modal -->


    <!-- Required Modal SHow -->
    <div class="modal fade" id="exampleModalCenter" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Registration Process</h5>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" method="post" autocomplete ="off" id="register_data">
                    <div class="container">
                        <div class="profile-up-banner mt-4">
                            <div class="d-flex flex-column pt-2">
                                <div class="d-flex">
                                    <div class="green-circle">
                                        <span class="green-circle-text">✓</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a class="mx-2 mt-2" style=" font-size: 14px;font-weight: 400; line-height: 30px;margin-top: -5px;text-decoration: none; color: inherit;">
                                            Finished
                                        </a>
                                        <span class="green-line"></span>
                                    </div>
                                </div>
                                <p class="money-text" style="line-height: 10px; margin-left: 33px">
                                    Registration Completed
                                </p>
                            </div>
                            <div class="d-flex flex-column pt-2">
                                <div class="d-flex">
                                    <div class="green-circle">
                                        <span class="step green-circle-text" id = "step-1">2</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a class="mx-2" style="font-size: 14px;font-weight: 400;line-height: 30px; margin-top: -5px;text-decoration: none; color: inherit;" id="element_add">
                                            In Progress
                                        </a>
                                        <span class="green-line"></span>
                                    </div>
                                </div>
                                <p class="money-text" style="line-height: 10px; margin-left: 33px">
                                    Tutoring Location
                                </p>
                            </div>
                            <div class="d-flex flex-column pt-2">
                                <div class="d-flex">
                                    <div class="green-circle">
                                        <span class="step green-circle-text" id ="step-2">3</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a class="mx-2 mt-2" style="font-size: 14px; font-weight: 400; line-height: 30px; margin-top: -5px;text-decoration: none; color: inherit;" id="element_add2" >
                                            Waiting
                                        </a>
                                        <span class="green-line"></span>
                                    </div>
                                </div>
                                <p class="money-text" style="line-height: 10px; margin-left: 33px">
                                    Education Information
                                </p>
                            </div>
                        </div>

                        <div class="tab row bg-white my-5 p-md-5 p-2 mx-1 mx-md-0 rounded-3 shadow-lg" id ="tab-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Country Name</label><br/>
                                        <select name="country_name" class="form-control select2" id="country" style=" width: 100% !important; height: 10% !important;padding: 10px !important;">
                                            <option value="">~select country~</option>
                                            @if(isset($countries))
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Your Tutoring City</label><br/>
                                        <select name="city_name" class="form-control select2" id="city" style=" width: 100% !important; height: 10% !important;padding: 10px !important;">
                                            <option value="">~select City~</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Your Location</label><br>
                                        <select name="location" class="form-control select2" id="location" style=" width: 100% !important; height: 10% !important;padding: 10px !important;">
                                            <option value="">~select Location~</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Your Preferable Location</label><br>
                                        <select name="preferable_locations[]" class="form-control select2" id="preferable_location" multiple style=" width: 100% !important; height: 10% !important;padding: 10px !important;">
                                            <option value="">~select Preferable location~</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center justify-content-md-end my-3">
                                <button class="btn btn-primary px-4" onclick="next(1,2);" id="nextBtn">Next</button>
                            </div>
                        </div>
                        <div class="tab row bg-white my-5 p-md-5 p-2 mx-1 mx-md-0 rounded-3 shadow-lg" id = "tab-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ins_6">
                                        <label for="">University Name</label>
                                        <select name="institute_name" class="select2_6 form-control" id="institute_name" required style=" width: 100% !important; height: 10% !important;padding: 10px !important;">
                                            <option value="">~Select Your University~</option>
                                            @foreach($institutes as $institute)
                                                <option value="{{ $institute->id }}">{{ $institute->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="">Department</label>
                                        <select name="department" class="form-control select2" required id="department" style=" width: 100% !important; height: 10% !important;padding: 10px !important;">
                                            <option value="">~Select Department~</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex my-3 justify-content-center justify-content-md-end my-3">
                                <button class="btn btn-primary px-4 mr-4" onclick="previous(2,1);">previous</button>
                                <button class="btn btn-primary px-4 float-right" type="submit">submit</button>
                            </div>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{--    End required modal--}}

@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('dashboard.tutor.js.tutor_dsb_js')
@endpush
