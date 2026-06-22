@extends('layouts.app')

@push('page_css')
@endpush


@section('content')
<main class="container-custom">
    @php

                            $startSerial = ($all_jobs->currentPage() - 1) * $paginationLimit + 1;
                        @endphp
    {{-- <div class="col-md-9 ms-sm-auto col-lg-10" style="margin-top: 60px"> --}}
    <!-- mini nav starts here -->
    <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/all-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.all-offers') }}">All offers</a>
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/available-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.available-offers') }}">Available offers</a>
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/available-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.available-offers') }}">Schedule offers</a>
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/application-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.application-offers') }}">Applications</a>
        <a class="text-decoration-none text-gray-800" href="{{ route('admin.job-offer.index') }}">Add New offers</a>
    </div>

    @if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif

   
    <!-- mini nav ends here -->
    <!-- main content section starts here -->
    <div class="ps-3" style="padding-right: 13px">

        <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
            <div class="d-flex justify-content-between gap-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    <i class="bi bi-sliders2 me-1"></i>Filter
                </button>
                <!-- Filter model starts here -->
                <div class="modal fade font-pop" id="exampleModal" tabindex="" aria-labelledby="">
                    <div class="modal-dialog modal-dialog-centered px-3" style="max-width: 1100px">
                        <div class="modal-content pt-4 pb-4 ps-2">
                            <div class="modal-header pe-5" style="padding-left: 40px">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Filter
                                    <span class="text-muted fw-light" style="font-size: 12">
                                    </span>
                                </h1>

                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-0">
                                <div class="row row-cols-2 row-cols-lg-4 pb-2 ps-4">
                                    <div class="d-flex">
                                        <div>
                                            <div class="pb-3">
                                                <label for="datef" class="form-label">Date from</label>
                                                <div>
                                                    <input type="date" class="form-control shadow rounded-2" id="datef"
                                                        onchange="inputChange('created_at <',this.id)" />
                                                </div>
                                            </div>
                                            <div class="pb-3">
                                                <label for="datet" class="form-label">Date To</label>
                                                <input type="date" class="form-control shadow rounded-2" id="datet"
                                                    onchange="inputChange('created_at >',this.id)" />
                                            </div>
                                            <div class="pb-3">
                                                <label for="crby" class="form-label">Created By</label>

                                                <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('created_by',this.id)" id="user_id">
                                                    <option value="">Select Employee</option>
                                                    @foreach($employees as $employee)

                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>

                                                    @endforeach


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
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1">
                                            <div class="pb-3">
                                                <label for="cun" class="form-label ">Country</label>
                                                <select name="country_id" class="form-select rounded-3 shadow-none "
                                                    aria-label="Default select " id="country_id"
                                                    onchange="inputChange('country_id',this.id)">
                                                    <option value="">Select Country</option>
                                                    @foreach (App\Models\Country::OrderBy('name','asc')->get() as
                                                    $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text country_id_error"></span>

                                            </div>

                                            <div class="pb-3">
                                                <label for="cty" class="form-label">City</label>
                                                <br>
                                                <select name="city_id" id="city_id" style="width: 215px"
                                                    class="shadow rounded-2 form-select"
                                                    onchange="inputChange('city_id',this.id)"
                                                    aria-label="Default select example">
                                                    <option selected>Select city</option>


                                                </select>

                                            </div>
                                            <div class="pb-3">
                                                <label for="loc" class="form-label">Location</label>
                                                <br>
                                                <select id="location_id" name="location_id" style="width: 215px"
                                                    class="form-select rounded-3 shadow-none"
                                                    onchange="inputChange('location_id',this.id)"
                                                    aria-label="Default select example">
                                                    <option selected>Select Location</option>

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
                                                <label for="category_id" class="form-label ">Category</label>
                                                <select name="category_id" id="category_id"
                                                    class="form-select rounded-3 shadow-none" style="width: 215px"
                                                    onchange="inputChange('category_id',this.id)">
                                                    <option value="">Select Category</option>
                                                    @foreach(App\Models\Category::OrderBy('name','asc')->get() as
                                                    $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text category_id_error"></span>
                                            </div>



                                            <div class="pb-3">
                                                <label for="course_id" class="form-label ">Course</label>
                                                <select name="course_id" class="form-select rounded-3 shadow-none"
                                                    onchange="inputChange('course_id',this.id)" id="course_id"
                                                    style="width: 215px">

                                                </select>
                                                <span class="text-danger error-text course_id_error"></span>

                                            </div>
                                            <div class="pb-3">
                                                <label for="subject_id" class="form-label ">Subjects</label>
                                                <select name="subject_id" class="form-select rounded-3 shadow-none"
                                                    id="subject_id" style="width: 215px">

                                                </select>
                                                <span class="text-danger error-text subject_id_error"></span>

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
                                                <label for="am" class="form-label">Source</label>

                                                <select id="am" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected>Affiliate Marcketing</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="pb-3">
                                                <label for="srcid" class="form-label">Source ID</label>

                                                <select id="srcid" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected>23456</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="pb-3">
                                                <label for="tm" class="form-label">Tutoring Method</label>

                                                <select id="tm" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example"
                                                    onchange="inputChange('teaching_method_id',this.id)">
                                                    @foreach (App\Models\TeachingMethod::OrderBy('name','asc')->get() as
                                                    $teachingM)

                                                    <option value="{{$teachingM->id}}">{{$teachingM->name}}</option>

                                                    @endforeach
                                                </select>


                                            </div>
                                        </div>
                                        <!-- Dont remove this unnessary wrapper flex div -->
                                    </div>
                                </div>

                                <div class="collapse" id="collapseExample">
                                    <div class="border-top border-2 pt-1 mx-4"></div>
                                    <div class="row row-cols-2 row-cols-lg-4 pb-2 ps-4 pt-2">
                                        <div class="d-flex">
                                            <div>
                                                <div class="pb-3">
                                                    <label for="salary" class="form-label">Salary</label>

                                                    <input type="text" class="form-control shadow rounded-2" id="salary"
                                                        onchange="inputChange('salary',this.id)" placeholder="5000" />
                                                </div>
                                                <div class="pb-3">
                                                    <label for="channel" class="form-label">Channel</label>

                                                    <select id="channel" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example">
                                                        <option selected>Website</option>
                                                        <option value="1">Facebook</option>
                                                        <option value="2">Twitter</option>
                                                        <option value="3">Three</option>
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
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <div class="pb-3">
                                                    <label for="genderr" class="form-label">
                                                        Gender Requirement
                                                    </label>

                                                    <select id="genderr" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('tutor_gender',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="others">others</option>

                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="daw" class="form-label">Days and Week</label>

                                                    <select id="days_in_week" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('days_in_week',this.id)"
                                                        aria-label="Default select example">

                                                        <option value="">Select Days</option>
                                                        <option value="2">2 days</option>
                                                        <option value="3">3 days</option>
                                                        <option value="4">4 days</option>
                                                        <option value="5">5 days</option>
                                                        <option value="6">6 days</option>
                                                        <option value="7">7 days</option>


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
                                                    <label for="sgender" class="form-label">Student Gender</label>

                                                    <select id="sgender" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('student_gender',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Gender</option>
                                                        <option selected>Male</option>
                                                        <option value="1">Female</option>
                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="rel" class="form-label">Religion</label>

                                                    <select id="rel" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('tutor_religion',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Religion</option>
                                                        <option value="islam">Islam</option>
                                                        <option value="hindu">Hindu</option>
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
                                            <div>
                                                <div class="pb-3">
                                                    <label for="in" class="form-label">
                                                        Institute Name
                                                    </label>
                                                    <select class="shadow rounded-2 form-select" style="width: 215px"
                                                        id="institute_id"
                                                        onchange="inputChange('institute_name',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Institute</option>

                                                        @foreach (App\Models\Institute::where('type',
                                                        'school')->orWhere('type', 'school and
                                                        college')->OrderBy('title','asc')->get() as $institute)

                                                        <option value="{{$institute->title}}">{{$institute->title}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="hoffer" class="form-label">Hide Offer</label>

                                                    <select id="hoffer" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example">
                                                        <option selected>Hide</option>
                                                        <option value="1">Nothing</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Dont remove this unnessary wrapper flex div -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between align-items-center pe-5"
                                style="padding-left: 35px">
                                <div>
                                    <a data-toggle="collapse" href="#collapseExample" role="button"
                                        aria-expanded="false" aria-controls="collapseExample" class="mb-0">
                                        <i class="bi bi-caret-down-fill"></i>
                                    </a>
                                </div>
                                <form action="{{route('admin.job.search')}}" method="post">
                                    @csrf
                                    <div>
                                        <button type="button" class="btn btn-danger py-1 me-2">
                                            Clear
                                        </button>
                                        <input type="hidden" id="job_search" name="job_search" value="">

                                        <button type="submit" class="btn btn-primary py-1">
                                            Apply
                                        </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter Model ends here -->

                {{-- <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button> --}}
            </div>

            <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>
        </div>





        <div class="d-flex gap-3">

            <form action="{{route('admin.job.search-single-available')}}" method="post">
                @csrf
                <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                    style="border: 1px solid #cfdfdb">

                    <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                        placeholder="Search" style="padding: 12px 18px" id="">
                    <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
                </div>
            </form>

            <form id="paginationForm" action="{{ route('admin.job-offer.available-offers') }}" method="GET">
                <select id="paginationLimit" name="pagination_limit" class="form-select rounded" style="width: 100px">
                    <option value="50" {{ $paginationLimit == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $paginationLimit == 100 ? 'selected' : '' }}>100</option>
                    <option value="200" {{ $paginationLimit == 200 ? 'selected' : '' }}>200</option>
                    <option value="400" {{ $paginationLimit == 400 ? 'selected' : '' }}>400</option>
                    <option value="500" {{ $paginationLimit == 500 ? 'selected' : '' }}>500</option>
                </select>
            </form>

        </div>
    </div>
    <div class="bg-white shadow-lg rounded-3 p-2 my-4">
        <div class="bg-white pb-4 mb-b">
            <div class="table-responsive">
                <table id="example1" class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                        <tr>
                            <th scope="col" class="text-nowrap" width="5%">Sl</th>
                            <th scope="col" class="text-nowrap" width="5%">
                                <input class="form-check-input  ms-1" type="checkbox" value="" id="select_all"
                                    style="margin-right: 12px;" /> &nbsp &nbsp &nbsp &nbsp &nbsp Date
                            </th>
                            <th scope="col" class="text-nowrap" width="5%">Parents ID</th>
                            <th scope="col" class="text-nowrap" width="5%">Job ID</th>
                            <th scope="col" class="text-nowrap" width="10%">Course</th>
                            <th scope="col" class="text-nowrap" width="15%">Location</th>
                            <th scope="col" class="text-nowrap" width="10%">Salary</th>
                            <th scope="col">EM</th>
                            <th scope="col" class="text-nowrap" width="10%">Created By</th>
                            <th scope="col" class="text-nowrap" width="5%">
                                applied Tutors
                            </th>
                            <th scope="col" class="text-nowrap" width="5%">Live</th>
                            <th scope="col" class="text-nowrap" width="30%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($all_jobs as $index => $job)

                        <tr class="" style="vertical-align: middle; @if ($job->hire_date > now()) background-color:rgb(0, 0, 0,0.5);color:rgb(0, 0, 0);   @endif ">
                            <td>{{ $startSerial++ }}</td>
                            <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                <input class="checkboxx" type="checkbox" name="ids" id="{{ $job->id }}"
                                    value="{{ $job->id }}" />
                                <a class="text-decoration-none text-gray-700 btn" id="{{ $job->created_at }}"
                                    onclick="dateTime(this.id)" data-bs-toggle="modal"
                                    data-time="{{ $job->created_at }}" data-bs-target="#exampleModal2">


                                    @php
                                    $input = $job->created_at;
                                    $format1 = 'd-m-Y';
                                    $format2 = 'H:i:s';
                                    $date = Carbon\Carbon::parse($input)->format($format1);
                                    // $time = Carbon\Carbon::parse($input)->format($format2);
                                    @endphp
                                    {{ $date }}
                                </a>
                            </td>
                            <td class="text-info">
                                <a href="#" class="text-decoration-none text-info">{{ $job->parent->unique_id }} </a>
                            </td>
                            <td class="text-info">
                                <a target="_blank" href="{{ route('admin.job-details', ['job' => $job->id]) }}"
                                    class="p-1 rounded text-info text-decoration-none"
                                    style="background-color: #e6eef7">{{ $job->id }}</a>
                            </td>
                            <td class="">{{ $job->course->name ?? 'N/A' }}
                                @if ($job->additionalChild)
                                @foreach ($job->additionalChild as $item)&
                                {{$item->course->name}}
                                @endforeach

                                @endif
                                <b>({{$job->category->name ?? 'N/A'}})</b>
                            </td>
                            <td class="text-wrap">{{ $job->location->name ?? 'N/A' }} ,<br>
                                {{ $job->city->name ?? 'N/A' }}
                            <td>{{ $job->salary }}</td>
                            <td class="text-info">
                                <a type="button" class="text-decoration-none text-info" data-bs-toggle="modal"
                                    data-bs-target="#emModel_{{$job->id}}">
                                    EM
                                </a>
                            </td>
                            <!--ME model starts here-->
                            <div class="modal fade" id="emModel_{{$job->id}}" tabindex="-1"
                                aria-labelledby="emModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="row row-cols-2 g-0">
                                                @php
                                                $takenByFirstUser = App\Models\User::where('id',
                                                $job->taken_by_1)->first();
                                                $takenBySecondUser = App\Models\User::where('id',
                                                $job->taken_by_2)->first();
                                                @endphp
                                                @if ($takenByFirstUser && $takenBySecondUser)
                                                {{-- Display details for both users --}}
                                                <div class="d-flex flex-column border-end">
                                                    <div class="text-white px-4" style="
                                                                    border-radius: 7px 0 0 0;
                                                                    padding: 35px 0;
                                                                    background-color: #3378c2;
                                                                ">
                                                        EM-1
                                                    </div>
                                                    <div class="px-4 pt-4 pb-3">
                                                        <p class="mb-0 fw-semibold">{{$takenByFirstUser->name}}</p>
                                                        <p style="font-size: 12px">{{$job->taken_by_1_date}}</p>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-column border-end">
                                                    <div class="text-white px-4" style="
                                                                    border-radius: 7px 0 0 0;
                                                                    padding: 35px 0;
                                                                    background-color: #3378c2;
                                                                ">
                                                        EM-2
                                                    </div>
                                                    <div class="px-4 pt-4 pb-3">
                                                        <p class="mb-0 fw-semibold">{{$takenBySecondUser->name}}</p>
                                                        <p style="font-size: 12px">{{$job->taken_by_2_date}}</p>
                                                    </div>
                                                </div>
                                                @elseif ($takenByFirstUser)
                                                <div class="d-flex flex-column border-end">
                                                    <div class="text-white px-4" style="
                                                                border-radius: 7px 0 0 0;
                                                                padding: 35px 0;
                                                                background-color: #3378c2;
                                                            ">
                                                        EM-1
                                                    </div>
                                                    <div class="px-4 pt-4 pb-3">
                                                        <p class="mb-0 fw-semibold">{{$takenByFirstUser->name}}</p>
                                                        <p style="font-size: 12px">{{$job->taken_by_1_date}}</p>
                                                    </div>
                                                </div>
                                                @elseif ($takenBySecondUser)
                                                <div class="d-flex flex-column border-end">
                                                    <div class="text-white px-4" style="
                                                                border-radius: 7px 0 0 0;
                                                                padding: 35px 0;
                                                                background-color: #3378c2;
                                                            ">
                                                        EM-2
                                                    </div>
                                                    <div class="px-4 pt-4 pb-3">
                                                        <p class="mb-0 fw-semibold">{{$takenBySecondUser->name}}</p>
                                                        <p style="font-size: 12px">{{$job->taken_by_2_date}}</p>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="d-flex ">
                                                    <div class="px-4 pt-4 pb-3">
                                                        <h2>No One Take</h2>
                                                    </div>

                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--ME model ends here-->
                            <td class="text-nowrap">{{ $job->user->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.job.applicant-list', $job->id) }}"
                                    target="_blank"><span>{{ count($job->applications) }}</span> <span
                                        class="badge badge-pill badge-info">{{ $job->applications->where('is_seen', 0)->count() }}</span></a>

                            </td>
                            <td>
                                <div class="switch-toggle">
                                    <div class="button-check" id="button-check" data-id="{{$job->id}}"
                                        onclick="liveChange({{$job->id}})">
                                        <input type="checkbox" class="checkbox" @if($job->is_active == 1) checked @endif
                                        />
                                        <span class="switch-btn"></span>
                                        <span class="layer"></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <!--Action model starts here-->
                                <div class="modal fade" id="allOfferAction_{{$job->id}}" tabindex="-1"
                                    aria-labelledby="dateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width: fit-content">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">

                                                <div class="d-flex justify-content-center align-items-center gap-3">
                                                    <a class="btn btn-ndark"
                                                        href="{{ route('admin.job.see-condition',$job->id) }}">See
                                                        Condition</a>

                                                    <a class="btn btn-ndark"
                                                        href="{{route('admin.job.status-log',$job->id)}}">Status
                                                        Log</a>
                                                    {{-- "{{ route('admin.sms_template.show', ['template' => $template->id]) }}"
                                                    --}}

                                                    <a class="btn btn btn-warning"
                                                        href="{{ route('admin.job.edit', ['id' => $job->id]) }}">Edit</a>

                                                    <button class="btn btn-pink">Hide</button>

                                                    <a class="btn btn-ndark" onclick="searchTutor({{$job->id}})"
                                                        {{-- data-dismiss="actionModal" --}}> Search Tutor</a>
                                                    <a class="btn btn-ndark"
                                                        {{-- {{ route('admin.job.edit', ['id' => $job->id]) }} --}}
                                                        href="{{ route('admin.job.sms-log', ['job' => $job->id]) }}">SMS
                                                        Log</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Action model ends here-->

                                <button class="btn btn-primary py-1" data-bs-toggle="modal"
                                    data-bs-target="#allOfferAction_{{$job->id}}">
                                    Action
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center gap-2">
            {{$all_jobs->appends(['pagination_limit' => $paginationLimit])->links()}}
        </div>
    </div>
    </div>
    </div>
    <!-- main content section ends here -->
    </div>







    <!--Date model starts here-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog model-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body pt-5 pb-4">
                    <p id="date" class="text-center text-info fs-3">7 June 2023</p>

                    {{-- <p>{{data}}</p> --}}
                    <p id="time" class="text-center text-gray-700 border-top fs-1 pt-1">
                        03:30 PM
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--Date model ends here-->


</main>





<div class="modal" tabindex="-1" role="dialog" id="tamim">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- add Search model starts here -->
<div class="modal fade font-pop" id="SearchTutorModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered px-4" style="max-width: 800px">
        <div class="modal-content pt-4 pb-4 ps-1">
            <div class="modal-header pe-5">

                <h5>
                    Search Tutor
                </h5>
                ( <h4 id="countingAll"></h4> )
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>



            <div class="px-lg">
                {{-- <div class="shadow-lg rounded-3 bg-white p-3 p-lg-5 mx-lg-1">
                      <div
                        class="d-flex justify-content-between align-items-start flex-column flex-lg-row align-items-lg-center"
                      >
                        <p class="text-nowrap">Search Tutors</p>
                        <div class="d-flex gap-3">
                          <button
                            class="btn btn-outline-primary py-1"
                            style="
                              box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                            "
                          >
                            <p class="p-0 m-0">SMS Ranges</p>
                            <p class="p-0 m-0">5</p>
                          </button>
                          <button
                            class="btn btn-outline-info py-1"
                            style="
                              box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                            "
                          >
                            <p class="p-0 m-0">SMS Send</p>
                            <p class="p-0 m-0">50</p>
                          </button>
                          <button class="btn btn-ndark" style="height: 52px">
                            Reset
                          </button>
                        </div>
                      </div>
                      <div class="mt-5">
                        <select class="form-select shadow-none rounded-3">
                          <option value="Latest Created Tutor">
                            Latest Created Tutor
                          </option>
                          <option value="2nd Latest Created Tutor">
                            2nd Latest Created Tutor
                          </option>
                          <option value="Random Tutor">Random Tutor</option>
                          <option value="Bottom Tutor">Bottom Tutor</option>
                          <option value="2nd Bottom Tutor">2nd Bottom Tutor</option>
                        </select>
                      </div>
                      <!-- result box -->
                      <div class="mt-4">
                        <!-- Here gose the result box -->
                      </div>
                    </div> --}}
                <div class="shadow-lg rounded-3 bg-white p-3 p-lg-5 mx-lg-1">
                    <div
                        class="d-flex justify-content-between align-items-start flex-column flex-lg-row align-items-lg-center">
                        <p class="text-nowrap">Search Tutors</p>
                        <div class="d-flex gap-3">
                            <button class="btn btn-outline-primary py-1" style="
                              box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                            ">
                                <p class="p-0 m-0">SMS Ranges</p>
                                <p class="p-0 m-0">{{$smsLimit->latest_created_input}}</p>
                            </button>
                            @if (Auth::user()->role_id == 1)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#limitModal">
                                Limit Sms
                            </button>
                            <form method="POST" action="{{route('admin.sms.limit')}}" id="limitForm">
                                @csrf
                                <div class="modal fade" id="limitModal" tabindex="-1" role="dialog"
                                    aria-labelledby="limitModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="limitModalLabel">Sms Limit</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="">
                                                    <div class="mb-3">
                                                        <label for="latest_created_input" class="form-label">Latest
                                                            Created Tutor</label>
                                                        <input name="latest_created_input" type="number"
                                                            class="form-control rounded-3 shadow-none"
                                                            id="latest_created_input" placeholder="Enter number"
                                                            style="padding: 14px 18px"
                                                            value="{{ old('latest_created_input', optional($smsLimit)->latest_created_input) }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="second_latest_created" class="form-label">2nd Latest
                                                            Created</label>
                                                        <input name="second_latest_created" type="number"
                                                            class="form-control rounded-3 shadow-none"
                                                            id="second_latest_created" placeholder="Enter number"
                                                            style="padding: 14px 18px"
                                                            value="{{ old('second_latest_created', optional($smsLimit)->second_latest_created) }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="random" class="form-label">Random</label>
                                                        <input name="random" type="number"
                                                            class="form-control rounded-3 shadow-none" id="random"
                                                            placeholder="Enter number" style="padding: 14px 18px"
                                                            value="{{ old('random', optional($smsLimit)->random) }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="bottom" class="form-label">Bottom</label>
                                                        <input name="bottom" type="text"
                                                            class="form-control rounded-3 shadow-none" id="bottom"
                                                            placeholder="Enter number" style="padding: 14px 18px"
                                                            value="{{ old('bottom', optional($smsLimit)->bottom) }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="second_bottom" class="form-label">2nd Bottom</label>
                                                        <input name="second_bottom" type="number"
                                                            class="form-control rounded-3 shadow-none"
                                                            id="second_bottom" placeholder="Enter number"
                                                            style="padding: 14px 18px"
                                                            value="{{ old('second_bottom', optional($smsLimit)->second_bottom) }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="premium" class="form-label">Premium</label>
                                                        <input name="premium" type="number"
                                                            class="form-control rounded-3 shadow-none" id="premium"
                                                            placeholder="Enter number" style="padding: 14px 18px"
                                                            value="{{ old('premium', optional($smsLimit)->premium) }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="send_sms_range" class="form-label">Sms Send
                                                            Range</label>
                                                        <input name="send_sms_range" type="number"
                                                            class="form-control rounded-3 shadow-none"
                                                            id="send_sms_range" placeholder="Enter number"
                                                            style="padding: 14px 18px"
                                                            value="{{ old('send_sms_range', optional(@$smsLimit)->send_sms_range) }}">
                                                    </div>


                                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            @endif

                            <button class="btn btn-outline-info py-1" style="
                              box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                            ">
                                <p class="p-0 m-0">SMS Send</p>
                                <p class="p-0 m-0" id="SendSmsCount"></p>
                            </button>
                            @if (Auth::user()->role_id == 1)
                            <form action="{{route('admin.job.sms.delete')}}">
                                @csrf
                                <input type="hidden" name="job_id" id="sms_job_id">
                                <button class="btn btn-ndark" type="submit" style="height: 52px">
                                    Reset
                                </button>
                            </form>

                            @endif
                        </div>
                    </div>
                    <div class="mt-5">
                        <select id="classifytutor" class="form-select shadow-none rounded-3"
                            onchange="classifyTutor(this.id)">
                            <option value="All_tutor">ALL Tutor</option>
                            <option value="Latest_created_tutor">
                                Latest Created Tutor <b>{{$smsLimit->latest_created_input}}</b>
                            </option>
                            <option value="2nd_latest_created_tutor">
                                2nd Latest Created Tutor <b>{{$smsLimit->second_latest_created}}</b>
                            </option>
                            <option value="Random_tutor">Random Tutor <b>{{$smsLimit->random}}</b></option>
                            <option value="Bottom_tutor">Bottom Tutor <b>{{$smsLimit->bottom}}</b></option>
                            <option value="Premium_tutor">premium Tutor <b>{{$smsLimit->second_bottom}}</b></option>

                            <option value="2nd_bottom_tutor">2nd Bottom Tutor <b>{{$smsLimit->premium}}</b></option>
                        </select>
                    </div>
                    <!-- result box -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>Search Result Tutors</p>

                            <div class="checkbox-wrapper-13">

                                <input class="" type="checkbox" value="" id="selectAllTutor"
                                    style="margin-right: 12px" />
                            </div>
                            {{-- <button  class="btn btn-primary" onclick="selectAllTutor()" >Mark All</button> --}}
                        </div>
                        <div>
                            <div id="tutorsDiv">



                                {{-- <div class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3">
                              <div class="">
                                <p class="text-info mb-0 fw-semibold">
                                  Abdul Hatem<i class="bi bi-patch-check ms-1"></i
                                  ><i class="bi bi-star-fill ms-1 text-warning"></i>
                                </p>
                                <p class="mb-0 text-muted">
                                  Stamford University Bangladesh
                                </p>
                                <div class="d-flex gap-1">
                                  <i class="bi bi-star-fill text-warning"></i
                                  ><i class="bi bi-star-fill text-warning"></i
                                  ><i class="bi bi-star-fill text-warning"></i
                                  ><i class="bi bi-star-fill text-warning"></i
                                  ><i class="bi bi-star-fill text-gray-500"></i>
                                </div>
                              </div>
                              <p class="text-muted mb-0">Mirpur , Dhaka</p>
                              <p
                                class="rounded px-1 text-muted mb-0"
                                style="border: 2px solid #8a8f98"
                              >
                                100%
                              </p>

                              <div class="checkbox-wrapper-13">

                                <input class="checkboxxx" type="checkbox" name="t_ids" id="" value="" />

                              </div>
                            </div>




                            <div class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3">
                                <div class="">
                                  <p class="text-info mb-0 fw-semibold">
                                    mehedi Hatem<i class="bi bi-patch-check ms-1"></i
                                    ><i class="bi bi-star-fill ms-1 text-warning"></i>
                                  </p>
                                  <p class="mb-0 text-muted">
                                    Stamford University Bangladesh
                                  </p>
                                  <div class="d-flex gap-1">
                                    <i class="bi bi-star-fill text-warning"></i
                                    ><i class="bi bi-star-fill text-warning"></i
                                    ><i class="bi bi-star-fill text-warning"></i
                                    ><i class="bi bi-star-fill text-warning"></i
                                    ><i class="bi bi-star-fill text-gray-500"></i>
                                  </div>
                                </div>
                                <p class="text-muted mb-0">Mirpur , Dhaka</p>
                                <p
                                  class="rounded px-1 text-muted mb-0"
                                  style="border: 2px solid #8a8f98"
                                >
                                  100%
                                </p>

                                <div class="checkbox-wrapper-13">

                                  <input class="checkboxxx" type="checkbox" name="t_ids" id="" value="" />

                                </div>
                              </div> --}}





                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <form action="{{ route('admin.job.tutor.sms') }}" target="_blank" method="post"
                                id="tutorSendSms">
                                @csrf
                                <input type="hidden" id="sms_job_id" name="sms_job_id">

                                <input type="hidden" id="all_t_ids" name="all_t_ids">


                                <button class="btn btn-primary">Send SMS</button>

                            </form>

                            <button class="btn btn-danger border shadow-lg">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>
</div>
@endsection







@push('page_scripts')
{{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


@include('backend.job_offers.js.all_offer_page_js')
@include('data_tables.data_table_js')


@endpush
