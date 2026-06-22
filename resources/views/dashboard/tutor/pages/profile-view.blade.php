@extends('dashboard.tutor.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/chosen-custom.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('backend/dist/js/ijaboCropTool.min.css') }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
        body{
            background-color: #e3e4e9;
        }
    </style>
@endpush
@section('content')

    <!-- conent section starts -->
    <div class="t-dashboard-contant p-4" style="margin-left: 245px;">
        <div class="profile-banner-card">
            <div class="d-flex align-content-center">
                <div style="position: relative">
                    <?php
                     if (isset($tutor))
                    {
                    if ($tutor->pic != null)
                    {?>
                    <img
                        style="height: 80px; border-radius: 50%"
                        src="{{ asset('files/profile') }}/{{$tutor->pic}}" class="profile_image_view"
                        alt="user"
                    />
                   <?php }elseif ($tutor->t_user->gender == 'male')
                   {?>
                       <img
                            style="height: 80px; border-radius: 50%"
                            src="{{ asset('dashboard/tutor') }}/assets/user.svg"
                            alt="user"
                                />

                  <?php }elseif ($tutor->t_user->gender == 'female')
                  {?>
                    <img
                        style="height: 80px; border-radius: 50%"
                        src="{{ asset('dashboard/tutor') }}/assets/default_female.png"
                        alt="user"
                    />
                 <?php
                  }
                 }
                    ?>
                        <input type="file" name="profile_pic" style="display: none" id="selectProfile" {{ (is_active() != true) ? 'disabled':'' }}>
                    <a class="t-link pe-auto" href="#" onclick="$('#selectProfile').trigger( 'click' )" >
                        <img
                            style="position: absolute; right: 0px; bottom: -7px"
                            src="{{ asset('dashboard/tutor') }}/assets/profile/upload.svg"
                            alt="upload"
                        />
                    </a>
                </div>

                <div class="mt-2 mx-2">
                    <div class="fw-bold fs-4 d-flex">
                        <div>{{ $tutor->t_user->name }}</div>
                        <div class="d-flex mx-2">
                            <img src="{{ asset('dashboard/tutor') }}/assets/profile/bookmark.svg" />
                            <img src="{{ asset('dashboard/tutor') }}/assets/profile/heart.svg" />
                            <img src="{{ asset('dashboard/tutor') }}/assets/profile/star.svg" />
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="tfw-light">Tutor ID: {{ $tutor->t_user->id }}</div>
                        <div
                            class="d-flex justify-content-between align-items-center mx-3"
                        >
                            <div class="ratings">
                                <i class="star bi bi-star-fill rated"></i>
                                <i class="star bi bi-star-fill"></i>
                                <i class="star bi bi-star-fill"></i>
                                <i class="star bi bi-star-fill"></i>
                                <i class="star bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex mt-4">
                <button class="view-btn money-text mx-3">
                    <i class="bi bi-eye fs-2"></i> View As Guardian
                </button>
                <button class="balance-btn">
                    <i class="bi bi-cloud-arrow-down fs-2"></i> Download CV
                </button>
            </div>
        </div>
        <!-- ---- ---------------------------------------->
        <div
            class="profile-update-banner mx-auto mt-4 d-flex py-3 align-items-center"
        >
            <div class="w-50">
                <div class="progress" style="height: 8px">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
            </div>
            <div> @php($complated =  auth()->guard('tutor')->user()->getProfileComplete()){{ $complated }} %</div>

            <div class="up-btn">
                <img src="{{ asset('dashboard/tutor') }}/assets/profile/edit.svg" />
                <a href="{{ route('tutor.profile.update') }}" class="text-btn t-link mt-2 mx-1"> Update Profile</a>
            </div>
        </div>
        <!-- ---- ---------------------------------------->
        <!-- ---- ---------------------------------------->
        <div
            class="slider-student-info d-flex flex-wrap mb-3 pb-5 mx-auto mt-4 py-3 personal-info"
            style="background-color: white; border-left: 10px solid #7cb305"
        >
            <div class="row mx-auto t-card-body px-4">
                <div>
                    <p class="fs-4 fw-bolder">Personal Information</p>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;" >
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->date_of_birth }}</span>
                            <br />
                            <span class="key text-nowrap">Date of Birth</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3 "style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->t_user->phone }}</span>
                            <br />
                            <span class="key text-nowrap">Phone</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;" >
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->nationality }}</span>
                            <br />
                            <span class="key text-nowrap">Nationality</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->blood_group }}</span>
                            <br />
                            <span class="key text-nowrap">Blood Group</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->religion }}</span>
                            <br />
                            <span class="key text-nowrap">Religion</span>
                        </p>
                    </div>
                </div>

                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->nid_number }} </span>
                            <br />
                            <span class="key text-nowrap">NID NO</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->t_user->gender }}</span>
                            <br />
                            <span class="key text-nowrap">Gender</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                    <span class="fs-custom text-wrap"
                    >{{ $tutor->permanent_full_address }}</span
                    >
                            <br />
                            <span class="key text-nowrap">Parmanent Address </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                    <span class="fs-custom text-wrap"
                    >{{ $tutor->full_address }}</span
                    >
                            <br />
                            <span class="key text-nowrap">Present Address </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- --------------------------------------- -->
        <!-- ---- ---------------------------------------->
        <div
            class="slider-student-info d-flex flex-wrap mb-3 pb-5 mx-auto mt-4 py-3 personal-info"
            style="background-color: white; border-left: 10px solid #7cb305"
        >
            <div class="row mx-auto t-card-body px-4">
                <div>
                    <p class="fs-4 fw-bolder">Parents Information</p>
                </div>
                <div class="col d-flex  ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->fathers_name }}</span>
                            <br />
                            <span class="key text-nowrap">Fathers  Name</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->mothers_name }}</span>
                            <br />
                            <span class="key text-nowrap">Mothers Name</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->emargency_name }} </span>
                            <br />
                            <span class="key text-nowrap">Em Contact Name</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->fathers_phone }} </span>
                            <br />
                            <span class="key text-nowrap">Fathers Number</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->mothers_phone }}</span>
                            <br />
                            <span class="key text-nowrap">Mothers Number</span>
                        </p>
                    </div>
                </div>

                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->emargency_phone }}</span>
                            <br />
                            <span class="key text-nowrap">Em Number</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- --------------------------------------- -->
        <!-- ---- ---------------------------------------->
        <div
            class="slider-student-info d-flex flex-wrap mb-3 pb-5 mx-auto mt-4 py-3 personal-info"
            style="background-color: white; border-left: 10px solid #7cb305"
        >
            <div class="row mx-auto t-card-body px-4">
                <div>
                    <p class="fs-4 fw-bolder">Tutoring Information</p>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" >
                        <p>
                    <span class="fs-custom text-wrap"
                    >Friday, Saturday, Saturday, Saturday, Saturday, Saturday,
                      Monday</span
                    >
                            <br />
                            <span class="key text-nowrap">Availablity</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" >
                        <p>
                    <span class="fs-custom text-nowrap"
                    >Students Home, Online , My Home</span
                    >
                            <br />
                            <span class="key text-nowrap">Tutoring Method </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->tutoring_experience }}</span>
                            <br />
                            <span class="key text-nowrap">Tutoring Experiences</span>
                        </p>
                    </div>
                </div>

                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->available_from }} to {{ $tutor->available_to }} </span>
                            <br />
                            <span class="key text-nowrap">Availablity(Time)</span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex ">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $tutor->expected_salary }}</span>
                            <br />
                            <span class="key text-nowrap">Expected Salary </span>
                        </p>
                    </div>
                </div>

            </div>
            <div class="ex-detail w-100 px-4">
                <h6 class="mt-2">Tutoring Experience Details</h6>
                <p class="money-text">
                    {{ $tutor->tutoring_experience_details }}
                </p>
            </div>
        </div>

        <!-- --------------------------------------- -->
        <!-- ---- ---------------------------------------->
        <div
            class="slider-student-info d-flex flex-wrap mb-3 pb-5 mx-auto mt-4 py-3 personal-info"
            style="background-color: white; border-left: 10px solid #7cb305"
        >
            <div class="row mx-auto t-card-body px-4">
                <div>
                    <p class="fs-4 fw-bolder mb-5">Tutoring Locations</p>
                </div>

                <h5 class="money-text ">Tutoring Location</h5>

                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">  {{ $tutor->country->name }}</span>
                            <br />
                            <span class="key text-nowrap">Country </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">  {{ $tutor->city->name }}</span>
                            <br />
                            <span class="key text-nowrap">City </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $tutor->location->name }}</span>
                            <br />
                            <span class="key text-nowrap">Location </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-100 px-3">
                <h5 class="money-text mb-4 mx-4">Tutoring Location</h5>
                <div class="d-flex flex-wrap">
                    @foreach($preferred_locations as $preferred_location)
                        <div class="location-btn mb-2 mx-2 bg-sky">{{ $preferred_location->preferred_location->name }}</div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- --------------------------------------- -->
        <!-- ---- ---------------------------------------->
        <div  class="slider-student-info d-flex flex-wrap mb-3 pb-5 mx-auto mt-4 py-3 personal-info"  style="background-color: white; border-left: 10px solid #7cb305" >
            <div class="row w-100 t-card-body px-4">
                <div>
                    <p class="fs-4 fw-bolder mb-5">Course & Subjects</p>
                </div>

                <div class="accordion mx-auto"  id="accordionPanelsStayOpenExample" style="border: none"  >
                    <!-- --------------------------------------- -->
                    <div class="accordion-item mb-3"  style="
                    background-color: #f5f5f5;
                    border-radius: 20px 20px 0 0;
                    border: none;
                  " >

                        @foreach($tutor->t_user->tutor_categories as $tutor_category)
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">

                                <button
                                    class="accordion-button"
                                    style="
                        border: none;
                        background-color: #f5f5f5;
                        border-radius: 20px 20px 0 0;
                        color: black;
                        font-size: 20px;
                      "
                                    type="button "
                                    data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne{{$tutor_category->id}}"
                                    aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne"
                                >
                                    {{ $tutor_category->name}}
                                </button>


                            </h2>
                            @foreach( $tutor->t_user->tutorcourse($tutor_category->id)->get() as $tutor_course)


                        <div id="panelsStayOpen-collapseOne{{$tutor_category->id}}" class="accordion-collapse collapse"  aria-labelledby="panelsStayOpen-headingOne"  >
                            <div  class="accordion-body p-0 justify-content-between align-items-center" >
                                <!-- --------------------------------------- -->
                                <div class="d-flex pt-3" style="background-color: #d9d9d9" >

                                    <div class="mx-4 text-nowrap">{{ $tutor_course->name }}</div>

                                    @foreach( $tutor->t_user->coursesubjects($tutor_course->id)->get() as $coursesubject)
                                    <div class="d-flex flex-wrap money-text"  style="font-size: 12px; line-height: 5px"  >
                                        <p class="mx-1">{{ $coursesubject->subject->title }} <soan class="fw-bold">|</soan></p>

                                    </div>
                                    @endforeach
                                </div>
                                <!-- --------------------------------------- -->
                            </div>
                        </div>

                            @endforeach
                        @endforeach
                    </div>
                </div>
                <!-- new accord -->

            </div>
        </div>

        <!-- --------------------------------------- -->
        <div
            class="slider-student-info d-flex flex-wrap mb-3 pb-5 mx-auto mt-4 py-3 personal-info"
            style="background-color: white; "
        >
            <div class="row mx-auto t-card-body px-4">
                <div style="color: #272727">
                    <p class="fs-4 fw-bolder mb-5">Education Information</p>
                </div>
                <!-- ---------------- Education detail------------------- -->

                <div class="p-2 pt-3 px-3 mb-2" style="background: #f5f5f5">
                    <h5 class="money-text" style="color: #272727">
                        SECONDARY / SSC / 0-LEVEL / DAKHIL
                    </h5>
                </div>

                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ ($ssc_tutor->institutes->title != null)? $ssc_tutor->institutes->title: '' }}</span>
                            <br />
                            <span class="key text-nowrap">Institute </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ ($ssc_tutor->curriculam->title != null) ? $ssc_tutor->curriculam->title : '' }}</span>
                            <br />
                            <span class="key text-nowrap">Curriculum </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $ssc_tutor->education_board }}</span>
                            <br />
                            <span class="key text-nowrap">Board </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $ssc_tutor->group_or_major }}</span>
                            <br />
                            <span class="key text-nowrap">Group </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $ssc_tutor->passing_year }}</span>
                            <br />
                            <span class="key text-nowrap">Passing Year </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $ssc_tutor->gpa }}</span>
                            <br />
                            <span class="key text-nowrap">Result </span>
                        </p>
                    </div>
                </div>

                <!-- ---------------- Education detail end------------------- -->
                <div class="my-3"></div>
                <!-- ---------------- Education detail------------------- -->

                <div class="p-2 pt-3 px-3 mb-2" style="background: #f5f5f5">
                    <h5 class="money-text" style="color: #272727">
                        HIGHER SECONDARY / HSC / A LEVEL / ALIM
                    </h5>
                </div>

                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $hsc_tutor->institutes->title }}</span>
                            <br />
                            <span class="key text-nowrap">Institute </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $hsc_tutor->curriculam->title }}</span>
                            <br />
                            <span class="key text-nowrap">Curriculum </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $hsc_tutor->education_board }}</span>
                            <br />
                            <span class="key text-nowrap">Board </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $hsc_tutor->group_or_major }}</span>
                            <br />
                            <span class="key text-nowrap">Group </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $hsc_tutor->passing_year }}</span>
                            <br />
                            <span class="key text-nowrap">Passing Year </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $hsc_tutor->gpa }}</span>
                            <br />
                            <span class="key text-nowrap">Result </span>
                        </p>
                    </div>
                </div>
                <!-- ---------------- Education detail end------------------- -->
                <div class="my-3"></div>
                <!-- ---------------- Education detail------------------- -->

                <div class="p-2 pt-3 px-3 mb-2" style="background: #f5f5f5">
                    <h5 class="money-text" style="color: #272727">
                        GRADUATION / BACHELOR / DIPLOMA
                    </h5>
                </div>

                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ substr($honours_tutor->institutes->title, 0, 33) }}</span>
                            <br />
                            <span class="key text-nowrap">Institute </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $honours_tutor->studyType->title }}</span>
                            <br />
                            <span class="key text-nowrap">Study Type </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $honours_tutor->university_type }}</span>
                            <br />
                            <span class="key text-nowrap">University Type </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ substr($honours_tutor->departments->title, 0, 33) }}</span>
                            <br />
                            <span class="key text-nowrap">Department </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $honours_tutor->passing_year }}</span>
                            <br />
                            <span class="key text-nowrap">Passing Year </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $honours_tutor->gpa }}</span>
                            <br />
                            <span class="key text-nowrap">CGPA </span>
                        </p>
                    </div>
                </div>
                <!-- ---------------- Education detail end------------------- -->
                <div class="my-3"></div>
                <!-- ---------------- Education detail------------------- -->

                <div class="p-2 pt-3 px-3 mb-2" style="background: #f5f5f5">
                    <h5 class="money-text" style="color: #272727">
                        POSTGRADUATE / MASTERS
                    </h5>
                </div>

                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ substr($masters_tutor->institutes->title, 0, 33) }}</span>
                            <br />
                            <span class="key text-nowrap">Institute </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $masters_tutor->university_type }}</span>
                            <br />
                            <span class="key text-nowrap">University Type </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $masters_tutor->studyType->title }}</span>
                            <br />
                            <span class="key text-nowrap">Study Type </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ substr($masters_tutor->departments->title, 0, 33) }}</span>
                            <br />
                            <span class="key text-nowrap">Department </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap">{{ $masters_tutor->passing_year }}</span>
                            <br />
                            <span class="key text-nowrap">Passing Year </span>
                        </p>
                    </div>
                </div>
                <div class="col d-flex">
                    <img
                        style="height: 36px; margin-top: 20px"
                        src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                    />
                    <div class="mx-3 mt-3" style="width: 110px;">
                        <p>
                            <span class="fs-custom text-nowrap"> {{ $masters_tutor->gpa }}</span>
                            <br />
                            <span class="key text-nowrap">CGPA </span>
                        </p>
                    </div>
                </div>

                <!-- ---------------- Education detail end------------------- -->
                <div class="my-3"></div>
            </div>
        </div>
    </div>
    <!-- conent section ends -->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('backend/dist/js/ijaboCropTool.min.js') }}"></script>
    {{------------------------------------ tutoring info save  ----------------------------------------}}

    <script>
        $('#selectProfile').ijaboCropTool({
            preview : '.profile_image_view',
            setRatio:1.5,
            allowedExtensions: ['jpg','jpeg','png'],
            buttonsText:['CROP & Upload','CANCEL'],
            processUrl:'{{ route("crop-profile-image") }}',
            withCSRF:['_token','{{ csrf_token() }}'],
            onSuccess:function(message, element, status){

               alert(message);
            },
            onError:function(message, element, status){
                alert(message);
            }
        });

    </script>
@endpush
