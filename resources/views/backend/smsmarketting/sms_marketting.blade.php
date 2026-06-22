@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

    .form-select {
        width: 215px !important;
    }
    #loading-spinner {
    position: fixed;
    top: 50%;
    left: 50%;
    z-index: 9999;
    transform: translate(-50%, -50%);
    }

</style>

@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div id="loading-spinner" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ms-sm-auto col-lg-12" style="margin-top: 62px">
            <!-- mini nav starts here -->
            <div class="d-flex flex-wrap mb-4 mb-md-0 justify-content-between align-items-center">
                <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
                    <a class="text-decoration-none text-gray-800" href="{{route('admin.all.notice')}}">All Notice
                        Dashboard</a>
                    <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.all.popupimage')}}">All Popup Images</a>
                    <a class="text-decoration-none text-gray-800 text-nowrap active-border" href="{{route('admin.sms.marketting')}}">SMS
                        Marketing</a>
                    <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.sms.marketing.unit')}}">SMS
                            Marketing Unit</a>
                            <a class="text-decoration-none text-gray-800 text-nowrap " href="{{route('admin.popup.image')}}">Popup
                        Image</a>
                </div>
                <div class="bg-white shadow-lg rounded-3 px-3 py-2 mx-3">
                    <p class="mb-0" style="font-weight: 500">Audience : 000</p>
                </div>
            </div>
            <!-- mini nav ends here -->
            <!-- main content section starts here -->
            <!-- submit form starts here -->
            <div class="mx-3 bg-white shadow-lg p-4 rounded-3 mb-4 px-lg-5 py-lg-4">
                <div class="py-4">
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="mb-4">
                            <label class="mb-2" style="font-weight: 500">Select Users</label>
                            <select id="userType" class="form-control">
                                <option value="">Select Users</option>
                                <option value="tutor">Tutors</option>
                                <option value="parent">parents</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tutor Filter model starts here -->
                    <div class="modal fade font-pop" id="filterTutorsModal" tabindex="" aria-labelledby="">
                        <div class="modal-dialog modal-dialog-centered px-3" style="max-width: 1100px">
                            <div class="modal-content pt-4 pb-4 ps-2">
                                <div class="modal-header pe-5" style="padding-left: 40px">
                                    <h1 class="modal-title fs-5" id="">
                                        Filter
                                        <span class="text-muted fw-light" style="font-size: 12">
                                        </span>
                                    </h1>

                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-0">
                                    <div class="row row-cols-2 row-cols-lg-4 pb-2 ps-4">
                                        <div class="d-flex">
                                            <div style="width: 220px">
                                                <div class="pb-3">
                                                    <label for="cun" class="form-label required">Country</label>
                                                    <select name="country_id" class="form-select rounded-3 shadow-none "
                                                        aria-label="Default select " id="country_id">
                                                        <option value="">Select Country</option>
                                                        @foreach (App\Models\Country::OrderBy('name','asc')->get() as $country)
                                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text country_id_error"></span>

                                                </div>

                                                <div class="pb-3">
                                                    <label for="cty" class="form-label">City</label>
                                                    <br>
                                                    <select name="city_id" id="city_id" style="width: 215px"
                                                        class="shadow rounded-2 form-select" aria-label="Default select example">



                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="loc" class="form-label">Location</label>
                                                    <br>
                                                    <select id="location_id" name="location_id" style="width: 215px"
                                                        class="shadow rounded-2 form-select" aria-label="Default select example">


                                                    </select>
                                                </div>


                                                <div class="pb-3">
                                                    <label for="daw" class="form-label">Teaching Method</label>


                                                    <select name="method_id" class="form-select rounded-3 shadow-none "
                                                        aria-label="Default select " id="method_id">
                                                        <option value="">Select Method</option>
                                                        @foreach (App\Models\TeachingMethod::OrderBy('name','asc')->get() as
                                                        $teachingM)
                                                        <option value="{{$teachingM->id}}">{{$teachingM->name}}</option>
                                                        @endforeach
                                                    </select>



                                                </div>
                                            </div>
                                            <div class="mb-3 ms-4" style="
                                                                                margin-top: 34px;
                                                                                width: 1px;
                                                                                background-color: #f0f1f2;">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <div class="pb-3">
                                                    <label for="datef" class="form-label">Date from</label>
                                                    <div>
                                                        <input name="datef" type="date" class="form-control shadow rounded-2" id="datef" />
                                                    </div>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="datet" class="form-label">Date To</label>
                                                    <input name="datet" type="date" class="form-control shadow rounded-2" id="datet" />
                                                </div>
                                                <div class="pb-3">
                                                    <label for="cty" class="form-label">Year</label>
                                                    <br>
                                                    <select name="year" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example" id="year">
                                                        <option selected>Select Year</option>
                                                        <option value="First Year">First Year</option>
                                                        <option value="Second Year">Second Year</option>
                                                        <option value="Third Year">Third Year</option>
                                                        <option value="Fourth Year">Fourth Year</option>
                                                        <option value="Fifth Year">Fifth Year</option>
                                                        <option value="Graduation Completed">Graduation Completed</option>
                                                    </select>
                                                </div>


                                                <div class="pb-3">
                                                    <label for="tm" class="form-label">Gender</label>
                                                    <select name="gender" id="gender" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example">
                                                        <option selected value=''>select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 ms-4" style="
                                                                                margin-top: 34px;
                                                                                width: 1px;
                                                                                background-color: #f0f1f2;
                                                                                ">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="pb-3">
                                                    <label for="cat" class="form-label">Category</label>

                                                    <select  name="category_id" id="category_id"
                                                        class="shadow rounded-2 form-select" style="width: 215px ; height: 50px"
                                                        aria-label="Default select example">
                                                        <option value=''>Select Category</option>
                                                        @foreach(App\Models\Category::OrderBy('name','asc')->get() as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="course" class="form-label">Course</label>



                                                    <select  name="course_id" class="form-select rounded-3 shadow-none"
                                                        style="max-width: 15px" id="course_id">
                                                        <option value=''>Select Category</option>

                                                    </select>
                                                    <span class="text-danger error-text course_id_error"></span>



                                                </div>
                                                <div class="mb-3">
                                                    <label for="subject_id" class="form-label ">Subjects</label>
                                                    <select name="subject_id" class="select2 form-select rounded-3 shadow-none"
                                                        id="subject_id" style="padding: 14px 10px; height: auto;">
                                                        <option value=''>Select Category</option>

                                                    </select>
                                                    <span class="text-danger error-text subject_id_error"></span>
                                                </div>


                                                <div class="pb-3">
                                                    <label for="study" class="form-label">Study Type</label>
                                                    <select name="study_type_id" id="study_type_id" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example">
                                                        <option value=''>select Type</option>
                                                        @foreach (App\Models\Study::OrderBy('title','asc')->get() as $study)

                                                        <option value="{{$study->id}}">{{$study->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text course_id_error"></span>
                                                </div>





                                            </div>

                                            <div class="mb-3 ms-4" style="
                                                                                margin-top: 34px;
                                                                                width: 1px;
                                                                                background-color: #f0f1f2;
                                                                                ">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start">
                                            <div>

                                                <div class="pb-3">
                                                    <label for="sub" class="form-label">Curriculam(SSC)</label>

                                                    <select id="ssc_curriculum_id" name="ssc_curriculum_id"
                                                        class="shadow rounded-2 form-select"
                                                        onchange="filterChange('curriculum_id',this.id)"
                                                        aria-label="Default select example">
                                                        <option value=''>select curriculam</option>
                                                        @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as
                                                        $curriculam)

                                                        <option value="{{$curriculam->id}}">{{$curriculam->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>



                                                <div class="pb-3">
                                                    <label for="utype" class="form-label">University Type</label>
                                                    <select name="tutor_university_type" class="form-select rounded-3 shadow-none select2"
                                                        aria-label="Default select " id="tutor_university_type">

                                                        <option value="">Select University Type</option>
                                                        <option value="National University">National University</option>
                                                        <option value="Private University">Private University</option>
                                                        <option value="Public University">Public University</option>
                                                        <option value="7 college">7 college</option>
                                                        <option value="Public Medical">Public Medical</option>
                                                        <option value="Private Medical">Private Medical</option>
                                                        <option value="Mardasha">Mardasha</option>
                                                        <option value="Polytechnic Institute">Polytechnic Institute</option>
                                                    </select>

                                                </div>
                                                <div class="pb-3">
                                                    <label for="am" class="form-label">University</label>

                                                    <select  name="tutor_university_id"
                                                        class="shadow rounded-2 form-select" style="width: 215px" id="tutor_university_id"
                                                        onchange="filterChange('degree_name=\'honours\' and tutor_university_id',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Institute</option>

                                                        @foreach (App\Models\Institute::where('type',
                                                        'university')->OrderBy('title','asc')->get() as $institute)

                                                        <option value="{{$institute->id}}">{{$institute->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="srcid" class="form-label">Department</label>

                                                    <select name="department_id" style="width: 215px" class="shadow rounded-2 form-select"
                                                        id="department_id" onchange="filterChange('department_id',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Department</option>
                                                        @foreach (App\Models\Department::OrderBy('title','asc')->get() as
                                                        $department)

                                                        <option value="{{$department->id}}">{{$department->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <!-- Dont remove this unnessary wrapper flex div -->
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer d-flex justify-content-between align-items-center pe-5" style="padding-left: 35px">
                                    <div>
                                        <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                            aria-controls="collapseExample" class="mb-0">
                                            <i class="bi bi-caret-down-fill"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                                            <button type="button" class="btn btn-pink" id="clearFilter">Clear</button>
                                            <button type="button" class="btn btn-primary" id="applyFilter">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade font-pop" id="filterParentsModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-slide-right" style="max-width: 900px">
                            <div class="modal-content pb-4 pt-3">
                                <!-- Modal Header -->
                                <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                                    <h4 class="modal-title" id="filterModalLabel">Filter Parents</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body py-0" style="padding-left: 40px">
                                    <form id="parentFilterForm">
                                        <div class="row">
                                            <!-- Date Filters -->
                                            <div class="col-md-4">
                                                <label for="datefp" class="form-label">Date from</label>
                                                <input name="datefp" type="date" class="form-control shadow rounded-2" id="datefp" />

                                                <label for="datetp" class="form-label mt-3">Date To</label>
                                                <input name="datetp" type="date" class="form-control shadow rounded-2" id="datetp" />

                                                <div class="pb-3">
                                                    <label for="loc" class="form-label">Verified Status</label>
                                                    <br>
                                                    <select id="verified" name="is_verified" style="width: 215px"
                                                        class="shadow rounded-2 form-select" aria-label="Default select example">
                                                        <option value="1">Verified</option>
                                                        <option value="0">Unverified</option>


                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Location Filters -->
                                            <div class="col-md-4">
                                                <div class="pb-3">
                                                    <label for="cun" class="form-label required">Country</label>
                                                    <select name="country_id" class="form-select rounded-3 shadow-none "
                                                        aria-label="Default select " id="country_id_2">
                                                        <option value="">Select Country</option>
                                                        @foreach (App\Models\Country::OrderBy('name','asc')->get() as $country)
                                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text country_id_error"></span>

                                                </div>

                                                <div class="pb-3">
                                                    <label for="cty" class="form-label">City</label>
                                                    <br>
                                                    <select name="city_id" id="city_id_2" style="width: 215px"
                                                        class="shadow rounded-2 form-select" aria-label="Default select example">



                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="loc" class="form-label">Location</label>
                                                    <br>
                                                    <select id="location_id_2" name="location_id" style="width: 215px"
                                                        class="shadow rounded-2 form-select" aria-label="Default select example">


                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                                    <button type="button" class="btn btn-secondary" id="clearParentFilter">Clear</button>
                                    <button type="button" class="btn btn-primary" id="applyParentFilter">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tutor Filter Model ends here -->

                    <form id="smsForm" action="{{route('admin.sms.marketting.tutor.filter')}}" method="POST">
                        @csrf
                        <input type="hidden" name="send_now" id="sendNow">
                        <input type="hidden" name="recurring" id="recurring">
                        <input type="hidden" name="send_later_time" id="sendLaterTime">
                        <input type="hidden" name="query" id="query">
                        <input type="hidden" name="user_type" id="usertype">
                        <div class="mb-4">
                            <label class="mb-2" style="font-weight: 500">SMS Title</label>
                            <input id="title" name="title" class="form-control rounded-2 shadow-none py-3" placeholder="Maximum 30 Character" />
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label required">Group SMS Body</label>
                            <textarea
                                name="sms_body"
                                class="form-control"
                                placeholder="SMS Body"
                                id="description"
                                style="overflow-y: scroll; height: 195px;"></textarea>
                            <span class="text-danger error-text description_error"></span>
                        </div>

                        <div id="char-left-message" class="text-danger"></div>

                        <div class="">
                            <div id="char">0/320</div>
                            <div>Remaining: <span id="rem">320</span></div>
                            <div>Message: <span id="msg">0</span></div>
                        </div>




                        <div class="d-flex justify-content-end gap-4">
                            <button type="button" class="btn btn-primary" id="sendNowBtn">Send Now</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendModal">Send Later</button>
                        </div>

                        <!-- Send Later Modal -->
                        <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <label>Select Time</label>
                                        <input type="datetime-local" class="form-control" id="sendLaterInput">
                                        <div class="mt-3">
                                            <label for="sendRecurringInput" class="form-label text-dark text-sm">Recurring</label>
                                            <select  id="sendRecurringInput" class="shadow rounded-2 form-select" aria-label="Default select example">
                                              <option selected value="">Select</option>
                                              <option value="3">3 Days</option>
                                              <option value="7">7 Days</option>
                                              <option value="15">15 Days</option>
                                              <option value="30">1 Month</option>
                                              <option value="60">2 Months</option>
                                              <option value="90">3 Months</option>
                                            </select>
                                          </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-primary" id="sendLaterBtn">Save & Send Later</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- submit form ends here -->
            <!-- table starts here -->
            <div class="ps-3" style="padding-right: 13px">
                <div
                    class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
                    <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-sliders2 me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-ndark">Send Bulk SMS</button>
                    </div>
                    <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                        <input type="text" class="form-control rounded shadow-none" placeholder="Search" />
                        <select class="form-select rounded shadow-none" style="width: 100px">
                            <option selected value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                    <div class="bg-white pb-4 mb-b">
                        <div class="table-responsive">
                            <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                                <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                    <tr>
                                        <th scope="col" class="text-nowrap">
                                            <input class="form-check-input me-2" type="checkbox"
                                                id="flexCheckDefault" />#SL
                                        </th>
                                        <th scope="col" class="text-nowrap">Date</th>
                                        <th scope="col" class="text-nowrap">User</th>
                                        <th scope="col" class="text-nowrap">Title</th>
                                        <th scope="col" class="text-nowrap">Audience</th>
                                        <th scope="col" class="text-nowrap">Status</th>
                                        <th scope="col" class="text-nowrap">
                                            Recurring Loop
                                        </th>
                                        <th scope="col" class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($smsMarketing as $item)
                                        <tr class="align-middle">
                                            <td scope="row" class="text-nowrap">
                                                <input class="form-check-input me-2" type="checkbox"
                                                    id="flexCheckDefault" />
                                                    {{$loop->iteration}}
                                            </td>
                                            <td class="">
                                                <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                                    data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                    {{$item->created_at}}
                                                </a>
                                            </td>
                                            <td>{{$item->user_type}}</td>
                                            <td class="text-truncate" style="max-width: 200px;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->title }}">
                                                {{ Str::limit($item->title, 20, '...') }}
                                            </td>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                                    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                                        return new bootstrap.Tooltip(tooltipTriggerEl);
                                                    });
                                                });
                                            </script>
                                            <td class="text-nowrap text-info">{{$item->updated_audience}}</td>

                                            @if (!is_null($item->send_latter) && \Carbon\Carbon::parse($item->send_latter)->gt(now()))
                                            <td class="text-nowrap text-warning" data-bs-toggle="modal"
                                                data-bs-target="#pendingDateTimeModal_{{$item->id}}" style="cursor: pointer">
                                                Pending
                                            </td>
                                            @else
                                            <td>
                                                <div class="switch-toggle">
                                                    <div class="button-check" id="button-check" data-id="{{$item->id}}"
                                                        onclick="liveChange({{$item->id}})">
                                                        <input type="checkbox" class="checkbox" @if($item->status == 1) checked @endif
                                                        />
                                                        <span class="switch-btn"></span>
                                                        <span class="layer"></span>
                                                    </div>
                                                </div>
                                            </td>


                                            @endif
                                            <td>{{ $item->recurring ? $item->recurring . ' days' : 'n/a' }}</td>

                                            <td class="">
                                                <div class="d-flex gap-4">
                                                    <a href="javascript:void(0);" class="btn btn-pink rounded-3 deleteSms" data-id="{{ $item->id }}">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="pendingDateTimeModal_{{$item->id}}" tabindex="-1" aria-labelledby="pendingDateTimeModalLabel_{{$item->id}}"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                                                <div class="modal-content">
                                                    <div class="modal-body pt-5 pb-4">
                                                        <p class="text-center text-warning fs-3">
                                                            {{ $item->send_latter ? \Carbon\Carbon::parse($item->send_latter)->format('Y-m-d') : '' }}
                                                        </p>
                                                        <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                                            {{ $item->send_latter ? \Carbon\Carbon::parse($item->send_latter)->format('h:i A') : '' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        @endforeach


                                </tbody>
                            </table>
                        </div>
                        <!-- pagination starts here -->
                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                            {{$smsMarketing->links()}}
                        </div>
                        <!-- pagination ends here -->
                    </div>
                </div>
            </div>
            <!-- table ends here -->
            <!-- Show Date time model starts here-->
            <div class="modal fade" id="showDateTimeModal" tabindex="-1" aria-labelledby="showDateTimeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                    <div class="modal-content">
                        <div class="modal-body pt-5 pb-4">
                            <p class="text-center text-info fs-3">7 June 2023</p>
                            <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                03:30 PM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Show Date time model ends here-->
            <!-- Pending Date time model starts here-->
            <div class="modal fade" id="pendingDateTimeModal" tabindex="-1" aria-labelledby="pendingDateTimeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                    <div class="modal-content">
                        <div class="modal-body pt-5 pb-4">
                            <p class="text-center text-warning fs-3">01 Aug 2023</p>
                            <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                03:30 PM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Date time model ends here-->
            <!-- Filter model starts here -->
            <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-slide-right" style="max-width: 650px">
                    <div class="modal-content pb-4 pt-3">
                        <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                            <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-0" style="padding-left: 40px">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label for="datef" class="form-label text-dark text-sm">Date from</label>
                                            <div class="">
                                                <input type="date" class="form-control shadow rounded-2" id="datef" />
                                            </div>
                                        </div>
                                        <div class="pb-3">
                                            <label for="datet" class="form-label text-dark text-sm">Date To</label>
                                            <input type="date" class="form-control shadow rounded-2" id="datet" />
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Start Date</label>
                                            <input type="date" class="form-control shadow rounded-2" />
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label for="gndr" class="form-label text-dark text-sm">User</label>

                                            <select id="gndr" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="Tutor">Tutor</option>
                                                <option value="Option 1">Option 1</option>
                                                <option value="Option 2">Option 2</option>
                                                <option value="Option 3">Option 3</option>
                                                <option value="Option 4">Option 4</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="src" class="form-label text-dark text-sm">Status</label>

                                            <select id="src" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="On">On</option>
                                                <option value="Option 1">Option 1</option>
                                                <option value="Option 2">Option 2</option>
                                                <option value="Option 3">Option 3</option>
                                                <option value="Option 4">Option 4</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="gndr" class="form-label text-dark text-sm">Recurring
                                                Loop</label>

                                            <select id="gndr" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="">15 Days</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end align-items-center"
                            style="padding-right: 27px">
                            <div class="pe-2 d-flex gap-3">
                                <button type="button" class="btn btn-pink">Clear</button>
                                <button type="button" class="btn btn-primary">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filter Model ends here -->

            <!-- main content section ends here -->
        </div>
    </div>
</div>


@endsection
@push('page_scripts')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@include('backend.smsmarketting.js.sms_markettingjs');

@endpush
