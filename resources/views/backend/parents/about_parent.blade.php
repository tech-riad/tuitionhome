@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')

<main class="">
    <div class="col-md-12 ms-sm-auto col-lg-12 px-3" style="margin-top: 62px">
        <!-- tab like button group (it should be tab) -->
        <div class="pt-4 row row-cols-2">
            <div>
                <a href="{{route('admin.view.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid #669ad1;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">View</a>
            </div>
            <div>
                <a href="{{route('admin.edit.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid white;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">Edit</a>
            </div>
        </div>
        <!-- tab like button group ends -->
        <!-- mini nav starts here -->
        <div class="d-flex gap-4 flex-wrap flex-column flex-md-row py-4 align-items-center">
            <a class="text-decoration-none text-gray-800 active-border text-nowrap"
                href="{{route('admin.view.parent',$parent->id)}}">About Me</a>
            <a class="text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.view.parent',$parent->id)}}">Dashboard
                Details</a>

            <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.parent.posted.job',$parent->id)}}">Posted
                Jobs</a>
            <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.parent.job.status',$parent->id)}}">Status</a>
            <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.parent.basic.log',$parent->id)}}">Basic Log</a>
                <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.parent.advance.log',$parent->id)}}">Advance Log</a>
                <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.parent.category.request.status',$parent->id)}}">T & C Request</a>
        </div>
        <!-- mini nav ends here -->

        <!-- contents starts here -->
        <div class="">
            <div class="bg-white rounded-3 shadow-lg p-4">
                <div class="d-flex flex-column flex-xl-row gap-4 gap-md-5 mx-md-3 my-md-4 my-xl-5">
                    <div class="p-2 rounded-2 shadow-lg" style="width: fit-content">
                        <img class="mx-auto profile-img-two" src="/images/boy.jpg" alt="profile_photo" />
                    </div>
                    <div class="w-100 pt-1">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h5 class="fs-18">Name :</h5>
                            </div>
                            <div class="col-md-8">
                                <p class="m-0 fw-500 text-muted fs-18">{{$parent->name ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h5 class="fs-18">Phone :</h5>
                            </div>
                            <div class="col-md-8">
                                <p class="fs-18 m-0 fw-500 text-muted">{{$parent->phone ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h5 class="fs-18">Email :</h5>
                            </div>
                            <div class="col-md-8">
                                <p class="fs-18 m-0 fw-500 text-muted">
                                    {{$parent->email ?? 'n/a'}}
                                </p>
                            </div>
                        </div>

                        <div class="row mt-5 pt-3">
                            <div class="col-7 col-md-8" style="
                          background-color: #99bbe1;
                          height: 22px;
                          margin-left: 11px;
                        "></div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-7 col-md-8" style="
                          background-color: #99bbe1;
                          height: 22px;
                          margin-left: 11px;
                        "></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-lg-2 gap-4 gap-lg-0 my-4">
            <div>
                <div class="bg-white p-4 shadow-lg rounded-3 h-100 d-flex flex-column justify-content-between">
                    <h5 class="mb-3">Contact Information</h5>
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Country</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->country->name ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">City</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->city->name ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Location</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->location->name ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Address Details</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->address_details ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Additional Number</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->additional_phone ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Whatsapp Number</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->whats_up_phone ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Facebook Profile Link</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->facebook_profile ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 pt-3">
                            <div>
                                <p class="fw-semibold m-0">Your Personal Opinion</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->personal_opinion ?? 'n/a'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <div class="bg-white p-4 shadow-lg rounded-3 mb-4">
                        <h5 class="mb-3">Personal Information</h5>

                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Gender</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->gender ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Profession</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->profession ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Date Of Birth</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->date_of_birth ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 pt-3">
                            <div>
                                <p class="fw-semibold m-0">
                                    How did You know about us ?
                                </p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->about_us ?? 'n/a'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-lg rounded-3">
                        <h5 class="mb-3">Kids Information</h5>

                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Number Of Childern</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->children_number ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Category</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->category ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 border-bottom py-3">
                            <div>
                                <p class="fw-semibold m-0">Class</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->class ?? 'n/a'}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-2 pt-3">
                            <div>
                                <p class="fw-semibold m-0">Institute Name</p>
                            </div>
                            <div>
                                <p class="m-0">{{$parent->parents_personalInfo->institute_name ?? 'n/a'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white px-4 pt-4 pb-1 rounded-3 shadow-lg mb-4">
            <div class="bg-white shadow-lg mb-4" style="border-radius: 8px">
                <div style="
                    height: 64px;
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                  " class="d-flex justify-content-start pt-3 align-items-center px-4 bg-primary text-white">
                    <p class="">Account Status</p>
                </div>
                <div class="px-4 py-4">
                    <div class="">
                        <div class="">
                            <p class="fw-600 m-0 fw-light text-primary">
                                Your profile has no issues
                            </p>
                            <div class="bg-gray-300 w-100 my-2" style="height: 1px"></div>
                            <p class="fw-ligh m-0 fw-light">
                                Your profile is now unlocked, and you can edit it
                                whenever you want.
                            </p>
                        </div>
                    </div>
                    <!-- <div class="d-flex justify-content-end align-items-center">
                    <button class="btn btn-primary shadow-lg px-5 rounded-3">
                      Update
                    </button>
                  </div> -->
                </div>
            </div>
        </div>
        <!-- contents ends here -->
    </div>
</main>

@endsection
