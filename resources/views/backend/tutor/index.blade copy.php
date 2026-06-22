                     @extends('layouts.app')
@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }
</style>


<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #11ee24;
        color: black;
    }
    </style>
@endpush
{{-- <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" /> --}}

@section('content')
<main class="">
    <div class="col-md-9 ms-sm-auto col-lg-12" style="">
        <!-- mini nav starts here -->
        <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
            <a class="text-decoration-none text-gray-800 active-border" href="{{route('tutor.index')}}">All Tutors</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.premium')}}">Premium Tutor</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.featured')}}">Featured Tutor</a>
        </div>

        <div id="count" style="margin-left: 18px">
            <div class="row">
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $all_tutor_count ?? ''}}</h2>
                        <span>All Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $male_tutor_count ?? ''}}</h2>
                        <span>Male Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $female_tutor_count ?? ''}}</h2>
                        <span>Female Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $premium_tutor_count ?? ''}}</h2>
                        <span>Premium Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $featured_tutor_count ?? ''}}</h2>
                        <span>Featured Tutors</span>
                    </div>
                </div>

                {{-- @if (session('message'))
                    <br>
                    <p class="alert alert-success">{{ session('message') }}</p>
                @endif --}}
            </div>


        </div>






        <!-- mini nav ends here -->
        <!-- main content section starts here -->
        <div class="ps-3" style="padding-right: 13px">



            <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">

                <div class="d-flex justify-content-between gap-3">

                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="bi bi-sliders2 me-1"></i>Filter
                    </button>
                    <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>

                    <a href="{{ route('tutor.create') }}" class="btn btn-outline-ndark">Add New Tutor</a>
                    <a href="{{ route('admin.tutors.trash') }}" class="btn btn-outline btn-warning">Trash List</a>

                    <form action="{{route('admin.tutor.search')}}" method="POST">
                        @csrf
                </div>


                <div class="d-flex gap-3">
                    <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                        style="border: 1px solid #cfdfdb">
                        {{-- <i class="bi bi-search text-muted ms-1"></i> --}}
                        <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                            placeholder="Search" style="padding: 12px 18px" id="" />
                        <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
                        </form>

                    </div>
                    {{-- </form> --}}


                    <form action="{{route('admin.tutor.paginate')}}" method="post" id="paginate_limit_form">
                        @csrf
                        <input type="hidden" name="paginate_limit" id="paginate_limit">
                    </form>


                    {{-- <input type="text" class="form-control rounded" placeholder="Search" /> --}}

                    <select class="form-select rounded" style="width: 100px" id="paginate_input" onchange="paginateValue(this.id)">



                            <option
                            @if($input == 20) selected @endif
                            value="20">20</option>
                            <option @if($input == 50) selected @endif value="50">50</option>
                            <option @if($input == 100) selected @endif value="100">100</option>
                            <option @if($input == 200) selected @endif value="200">200</option>
                            <option @if($input == 400) selected @endif value="400">400</option>
                            <option @if($input == 500) selected @endif value="500">500</option>
                    </select>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                        <table id="example1" class="table table-responsive table-hover bg-white shadow-none" style="border-collapse: collapse"
                            id="tutor_data_table">
                            <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                <tr>
                                    <th scope="col" class="text-nowrap">


                                        <input class="" type="checkbox" value="" id="select_all"
                                            style="margin-right: 12px" /> &nbsp &nbsp &nbsp Date
                                    </th>
                                    <th scope="col" style="width: 10px" class="text-nowrap">Tutor ID</th>

                                    <th scope="col" class="text-nowrap">Name</th>
                                    {{-- <th scope="col" class="text-nowrap">Rating</th> --}}

                                    <th scope="col" class="text-nowrap">University</th>
                                    <th scope="col" class="text-nowrap">Department</th>
                                    <th scope="col" class="text-nowrap">gender</th>
                                    <th scope="col" class="text-nowrap">Address</th>
                                    <th scope="col" class="text-nowrap">Verified By</th>
                                    <th scope="col" class="text-nowrap">Phone</th>
                                    <th scope="col" class="text-nowrap">Completion</th>

                                    <th scope="col" class="text-nowrap">SMS</th>
                                    <th scope="col" class="text-nowrap">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Action
                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($tutors as $tutor)
                                <tr class="" style="vertical-align: middle">


                                    <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                        <input class="checkboxx" type="checkbox" name="ids" id="{{ $tutor->id }}"
                                            value="{{ $tutor->id }}" />
                                        <a class="text-decoration-none text-gray-700 btn" id="{{$tutor->created_at}}"
                                            onclick="dateTime(this.id)" data-bs-toggle="modal"
                                            data-time="{{ $tutor->created_at }}" data-bs-target="#exampleModal2">


                                            @php
                                            $input = $tutor->created_at;
                                            $format1 = 'd-m-Y';
                                            $format2 = 'H:i:s';
                                            $date = Carbon\Carbon::parse($input)->format($format1);
                                            // $time = Carbon\Carbon::parse($input)->format($format2);
                                            @endphp
                                            {{$date}}
                                        </a>
                                    </td>

                                    <td class="text-info">

                                        {{-- <input class="form-check-input me-2" type="checkbox" value=""
                                            id="flexCheckDefault" /> --}}
                                        <a href="{{route('admin.tutor.show' , ['tutor' => $tutor->id])}}"
                                            class="p-1 rounded text-info text-decoration-none"
                                            style="background-color: #e6eef7">{{$tutor->unique_id}}</a> </td>

                                    <td class="text-nowrap">{!! nl2br(e(Str::limit($tutor->name ?? 'NA', 7))) !!}
                                        @if($tutor->is_premium == 1)
                                            <i style="color:orange;" class="fas fa-star"></i> @endif
                                            @if($tutor->is_verified == 1)
                                            <i style="color:#007BFF" class="far fa-check-circle"></i>
                                            @endif
                                            @if($tutor->is_featured == 1)
                                            <i style="color:#112374" class="fas fa-asterisk"></i></h3>

                                        @endif
                                    </td>


                                    @php
                                    $totalElements = count($tutor->tutor_education);
                                    // dd($tutor->tutor_education->toarray());
                                    $graduation=$tutor->tutor_education->where('degree_name', 'honours')->first();
                                    // dd($graduation->institutes->title);


                                    @endphp

                                    {{-- {{$totalElements}} --}}

                                    <td class="text-nowrap">
                                        {{Str::limit($graduation->institutes->title ?? 'NA', 12)}}
                                    </td>
                                    <td class="text-nowrap">
                                        {{Str::limit($graduation->department ?? $graduation->departments->title ?? 'NA', 10)}}
                                    </td>
                                    <td class="text-nowrap">{{$tutor->gender}}</td>

                                    <td style="width: 10px" class="text-wrap">{{Str::limit( $tutor->tutor_personal_info->full_address ?? 'NA', 10) }}</td>
                                    <th scope="col" class="text-nowrap">{{ optional($tutor->verifier)->name }}</th>
                                    <td scope="col" class="text-nowrap">{{$tutor->phone}}</td>
                                    <th scope="col" class="text-nowrap">@php($complated =
                                        $tutor->getProfileComplete()){{ $complated }} %</th>



                                    <td>
                                        <div class="switch-toggle">
                                            <div class="button-check" id="button-check" data-id="{{$tutor->id}}"
                                                onclick="liveChange({{$tutor->id}})">
                                                <input type="checkbox" class="checkbox" @if($tutor->is_sms == 1) checked @endif
                                                />
                                                <span class="switch-btn"></span>
                                                <span class="layer"></span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.tutor.show', ['tutor' => $tutor->id]) }}"><button
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </button></a>
                                        <a href="{{ route('admin.tutor.single-sms', ['tutor' => $tutor->id]) }}">
                                            <button class="btn btn-info btn-sm">
                                                <i class="fa fa-envelope"></i>
                                            </button></a>

                                        <button id="{{ $tutor->id }}" onclick="btnEdit(this.id)"
                                            class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal">
                                            <i class="fa fa-edit"></i>
                                        </button>


                                        <br>
                                        <a href="{{route('admin.tutor.edit-info', ['tutor' => $tutor->id])}}"> <button
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>Edit Info
                                            </button></a>


                                            @if (Auth::user()->id == 1)
                                            <form id="btndelete{{ $tutor->id }}"
                                                action="{{ route('tutor.destroy', ['tutor' => $tutor->id]) }}" method="POST"
                                                style="display:inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-danger btn-sm " id="{{ $tutor->id }}"
                                                    onclick="btnDelete(this, this.id)"><i class="fa fa-trash"></i></button>
                                            </form>

                                            @endif


                                        {{-- <a class="btn btn-info" href="{{ route('tutor.make.premium', ['tutor' => $tutor->id]) }}">Make
                                        Premium</a> --}}
                                        {{-- <a  href="{{ route('tutor.make.featured', ['tutor' => $tutor->id]) }}">Make
                                        Featured</a> --}}

                                        <form style="font-size: 0" id="btnConfirmPremium{{ $tutor->id }}"
                                            action="{{ route('tutor.make.premium', ['tutor' => $tutor->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button id="{{ $tutor->id }}" type="button" class="btn btn-success btn-sm"
                                                onclick="btnConfirmPremium(this, this.id)">Make Premium</button>
                                        </form>
                                        <form style="font-size: 0" id="btnConfirmFeatured{{ $tutor->id }}"
                                            action="{{ route('tutor.make.featured', ['tutor' => $tutor->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button id="{{ $tutor->id }}" type="button" class="btn btn-info btn-sm"
                                                onclick="btnConfirmFeatured(this, this.id)">Make Featured</button>
                                        </form>

                                        <form style="display:inline" id="verifyTutor{{ $tutor->id }}"
                                            action="{{ route('admin.tutor.verify', ['tutor' => $tutor->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button id="{{ $tutor->id }}" type="button" class="btn btn-sm btn-primary"
                                                onclick="verifyTutor(this, this.id)">Verify</button>
                                        </form>

                                        <button class="btn btn-sm btn-primary" id="{{ $tutor->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal"
                                            data-bs-target="#tutorNoteModal">
                                            Note
                                        </button>

                                        {{-- <button id="{{ $tutor->id }}" onclick="btnNote(this.id)"
                                        class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#noteModal">note</button> --}}


                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    <div class="d-flex justify-content-center align-items-center gap-2">

                        {{$tutors->links()}}

                    </div>
            </div>
        </div>
        <!-- main content section ends here -->

    </div>



    <!-- Filter model starts here -->
    <div class="modal fade font-pop" id="exampleModal" tabindex="" aria-labelledby="">
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
                                        aria-label="Default select " id="country_id"
                                        onchange="filterChange('country_id',this.id)">
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
                                        class="shadow rounded-2 form-select" onchange="filterChange('city_id',this.id)"
                                        aria-label="Default select example">
                                        <option selected>Select city</option>


                                    </select>
                                </div>
                                <div class="pb-3">
                                    <label for="loc" class="form-label">Location</label>
                                    <br>
                                    <select id="location_id" name="location_id" style="width: 215px"
                                        class="shadow rounded-2 form-select"
                                        onchange="filterChange('location_id',this.id)"
                                        aria-label="Default select example">
                                        <option selected>Select Location</option>

                                    </select>
                                </div>


                                <div class="pb-3">
                                    <label for="daw" class="form-label">Teaching Method</label>
                                    <select id="method_id" name="method_id" class="shadow rounded-2 form-select"
                                        onchange="filterChange('method_id',this.id)"
                                        aria-label="Default select example">
                                        <option selected>select Teaching Method</option>

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
                                        <input type="date" class="form-control shadow rounded-2" id="datef"
                                            onchange="filterChange('created_at <',this.id)" />
                                    </div>
                                </div>
                                <div class="pb-3">
                                    <label for="datet" class="form-label">Date To</label>
                                    <input type="date" class="form-control shadow rounded-2" id="datet"
                                        onchange="filterChange('created_at >',this.id)" />
                                </div>


                                <div class="pb-3">
                                    <label for="cty" class="form-label">Year</label>
                                    <br>
                                    <select name="hsc_board" class="shadow rounded-2 form-select"
                                        aria-label="Default select example" id="year">
                                        <option selected>Select Year</option>
                                        <?php
                                        for($i =2000; $i<=2050; $i++)
                                        {
                                            ?>
                                        <option value="{{$i}}">{{$i}}</option>
                                        <?php

                                        }
                                        ?>

                                    </select>
                                </div>


                                <div class="pb-3">
                                    <label for="tm" class="form-label">Gender</label>

                                    <select id="gender" class="shadow rounded-2 form-select"
                                        onchange="filterChange('gender',this.id)" aria-label="Default select example">
                                        <option selected>select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
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
                            <div class="flex-grow-1" >
                                <div class="pb-3">
                                    <label for="cat" class="form-label">Category</label>

                                    <select id="category_id" class="shadow rounded-2 form-select" style="width: 215px ; height: 50px"
                                        onchange="filterChange('category_id',this.id)"
                                        aria-label="Default select example">
                                        <option selected>Bangla Medium</option>
                                        @foreach(App\Models\Category::OrderBy('name','asc')->get() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="pb-3" >
                                    <label for="course" class="form-label">Course</label>



                                        <select  name="course_id" class="form-select rounded-3 shadow-none" style="width: 215px"
                                            id="course_id" >

                                        </select>
                                        <span class="text-danger error-text course_id_error"></span>



                                </div>

                                <div class="pb-3">
                                    <label for="course" class="form-label">Study Type</label>

                                    <select id="study_type_id" class="shadow rounded-2 form-select"
                                        onchange="filterChange('study_type_id',this.id)"
                                        aria-label="Default select example">
                                        <option selected>select Type</option>
                                        @foreach (App\Models\Study::OrderBy('title','asc')->get() as $study)

                                        <option value="{{$study->id}}">{{$study->title}}</option>
                                        @endforeach
                                    </select>
                                </div>




                                {{-- <div class="pb-3">
                                    <label for="sub" class="form-label">Curriculam(SSC)</label>

                                    <select id="curriculum_id" name="curriculum_id" class="shadow rounded-2 form-select"
                                        onchange="filterChange('curriculum_id',this.id)"
                                        aria-label="Default select example">
                                        <option selected>select curriculam</option>
                                        @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as $curriculam)

                                        <option value="{{$curriculam->id}}">{{$curriculam->title}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
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
                                    <label for="utype" class="form-label">University Type</label>
                                    <select name=""
                                        class="form-select rounded-3 shadow-none select2"
                                        aria-label="Default select " id="tutor_university_type"
                                        style="width: 220px" onchange="filterChange('university_type',this.id)" >

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

                                    <select class="shadow rounded-2 form-select" style="width: 215px" id="institute_id"
                                        onchange="filterChange('degree_name=\'honours\' and institute_id',this.id)"
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

                                    <select style="width: 215px" class="shadow rounded-2 form-select" id="department_id"
                                        onchange="filterChange('department_id',this.id)"
                                        aria-label="Default select example">
                                        <option value="">Select Group</option>
                                        @foreach (App\Models\Department::OrderBy('title','asc')->get() as $department)

                                        <option value="{{$department->id}}">{{$department->title}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="pb-3">
                                    <label for="sub" class="form-label">Curriculam(HSC)</label>

                                    <select id="curriculum_id" name="curriculum_id" class="shadow rounded-2 form-select"
                                        onchange="filterChange('curriculum_id',this.id)"
                                        aria-label="Default select example">
                                        <option selected>select curriculam</option>
                                        @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as $curriculam)

                                        <option value="{{$curriculam->id}}">{{$curriculam->title}}</option>
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



                                    <div class="pb-3" style="width: 215px" >
                                        <label for="loc" class="form-label">Prefered Location</label>
                                        <br>
                                        <select multiple id="pre_location_id" name="pre_location_id" style="width: 215px"
                                            class="shadow rounded-2 form-select"
                                            onchange="filterChange('pre_location_id',this.id)"
                                            aria-label="Default select example">

                                        </select>
                                    </div>



                                    <div class="pb-3">
                                        <label for="daw" class="form-label">Experience</label>

                                        <select id="daw" name="tutoring_experience" id="tutoring_experience"
                                            class="shadow rounded-2 form-select"
                                            onchange="filterChange('tutoring_experience',this.id)"
                                            aria-label="Default select example">
                                            <option selected>select experience</option>
                                            <option value="1 year">1 year</option>
                                            <option value="2 year">2 year</option>
                                            <option value="3 year">3 year</option>
                                            <option value="4 year">4 year</option>
                                            <option value="5 year">5 year</option>
                                            <option value="6 year">6 year</option>
                                            <option value="7 year">7 year</option>


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
                                        <label for="gender" class="form-label">
                                            Religion
                                        </label>

                                        <select id="religion" name="religion" class="shadow rounded-2 form-select"
                                            onchange="filterChange('religion',this.id)"
                                            aria-label="Default select example">
                                            <option selected>Select Religion</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Christianity">Christianity</option>
                                            <option value="Buddhism">Buddhism</option>
                                            <option value="Other">Other</option>

                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="channel" class="form-label">Blood Group</label>

                                        <select id="blood_group" name="blood_group" class="shadow rounded-2 form-select"
                                            onchange="filterChange('blood_group',this.id)"
                                            aria-label="Default select example">
                                            <option selected>Select Blood Group</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>

                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="salary" class="form-label">Expected Salary</label>

                                        <input type="text" class="form-control shadow rounded-2" id="expected_salary"
                                            onchange="filterChange('expected_salary',this.id)" placeholder="5000" />
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
                                        <label for="am" class="form-label">School</label>

                                        <select class="shadow rounded-2 form-select" style="width: 215px"
                                            id="ssc_institute_id"
                                            onchange="filterChange('degree_name=\'ssc\' and institute_id',this.id)"
                                            aria-label="Default select example">
                                            <option value="">Select Institute</option>

                                            @foreach (App\Models\Institute::where('type', 'school')->orWhere('type',
                                            'school and college')->OrderBy('title','asc')->get() as $institute)

                                            <option value="{{$institute->id}}">{{$institute->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="pb-3">
                                        <label for="in" class="form-label">
                                            SSC Group
                                        </label>

                                        <select id="ssc_group_or_major" class="shadow rounded-2 form-select"
                                            onchange="filterChange('group_or_major',this.id)"
                                            aria-label="Default select example">
                                            <option selected>Select Group</option>
                                            <option value="Science">Science</option>
                                            <option value="Commerce">Commerce</option>
                                            <option value="Arts">Arts</option>
<<<<<<< HEAD

=======
>>>>>>> e941c944b52fa15c0c9fce85b4b782f7b922e696
                                        </select>
                                    </div>

                                    <div class="pb-3">
                                        <label for="am" class="form-label">SSC board</label>

                                        <select name="education_board" id="education_board"
                                            class="shadow rounded-2 form-select"
                                            onchange="filterChange('education_board',this.id)"
                                            aria-label="Default select example" id="gender">
                                             <option  value="">~ select board ~</option>
                                            <option  value="Barisal">Barisal</option>
                                            <option  value="Chittagong">Chittagong</option>
                                            <option  value="Comilla">Comilla</option>
                                            <option  value="Dhaka">Dhaka</option>
                                            <option  value="Jessore">Jessore</option>
                                            <option  value="Mymensingh">Mymensingh</option>
                                            <option  value="Rajshahi">Rajshahi</option>
                                            <option  value="Sylhet">Sylhet</option>
                                            <option  value="Dinajpur">Dinajpur</option>
                                            <option  value="Technical">Technical</option>
                                            <option  value="Madrasah">Madrasah</option>
                                            <option  value="Cambridge">Cambridge</option>
                                            <option  value="Ed-excel">Ed-excel</option>
                                            <option  value="IB">IB</option>


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
                                        <label for="am" class="form-label">College</label>

                                        <select id="hsc_institute_id" style="width: 215px" name="hsc_institute_id"
                                            class="shadow rounded-2 form-select" id="institute_id"
                                            onchange="filterChange('degree_name=\'hsc\' and institute_id',this.id)"
                                            aria-label="Default select example">
                                            <option value="">Select Institute</option>

                                            @foreach (App\Models\Institute::where('type', 'school')->orWhere('type',
                                            'school and college')->OrderBy('title','asc')->get() as $institute)

                                            <option value="{{$institute->id}}">{{$institute->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="in" class="form-label">
                                            HSC Group
                                        </label>

                                        <select id="hsc_group_or_major" class="shadow rounded-2 form-select"
                                            onchange="filterChange('group_or_major',this.id)"
                                            aria-label="Default select example">
                                            <option selected>Select Group</option>
                                            <option value="Science">Science</option>
                                            <option value="Commerce">Commerce</option>
                                            <option value="Arts">Arts</option>

                                        </select>
                                    </div>

                                    <div class="pb-3">
                                        <label for="am" class="form-label">HSC board</label>

                                        <select name="hsc_education_board" id="hsc_education_board"
                                            class="shadow rounded-2 form-select"
                                            onchange="filterChange('education_board',this.id)"
                                            aria-label="Default select example" id="">

                                        <option  value="">~ select board ~</option>
                                        <option  value="Barisal">Barisal</option>
                                        <option  value="Chittagong">Chittagong</option>
                                        <option  value="Comilla">Comilla</option>
                                        <option  value="Dhaka">Dhaka</option>
                                        <option  value="Jessore">Jessore</option>
                                        <option  value="Mymensingh">Mymensingh</option>
                                        <option  value="Rajshahi">Rajshahi</option>
                                        <option  value="Sylhet">Sylhet</option>
                                        <option  value="Dinajpur">Dinajpur</option>
                                        <option  value="Technical">Technical</option>
                                        <option  value="Madrasah">Madrasah</option>
                                        <option  value="Cambridge">Cambridge</option>
                                        <option  value="Ed-excel">Ed-excel</option>
                                        <option  value="IB">IB</option>

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
                        <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                            aria-controls="collapseExample" class="mb-0">
                            <i class="bi bi-caret-down-fill"></i>
                        </a>
                    </div>
                    <div>
                        <form action="{{route('admin.tutor.filter')}}" method="post">
                            @csrf
                            <input name="searchInput" type="hidden" value="" id="searchInput">
                            <button type="button" class="btn btn-danger py-1 me-2">
                                Clear
                            </button>






                            <button type="submit" class="btn btn-primary py-1">
                                Apply
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter Model ends here -->


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
    <!--ME model starts here-->

    <!--ME model ends here-->

</main>



{{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p>Edit & Update tutors</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="" method="post" action="{{ route('tutor.update', 'tutor') }}">
                    @csrf

                    <input type="hidden" name="_method" value="put" />
                    <input class="form-control" type="hidden" id="tutor_id" name="tutor_id" value="">
                    <label style="" class="form-labal">Full Name</label><br>
                    <input type="text" value="" class="form-control name" name="name" id="name" required>
                    <label style="" class="form-labal">Email</label><br>
                    <input type="text" value="" class="form-control name" name="email" id="email" required>
                    <label style="" class="form-labal">Phone</label><br>
                    <input type="text" value="" class="form-control name" name="phone" id="phone" required>

                    <label for="category_id" class="form-label">Genger</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Select One</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="btnEdit()">Update tutor</button>
            </div>
            </form>

        </div>

    </div>
</div>
{{-- end Edit Modal --}}


<!-- Note model -->
<div class="modal fade" id="tutorNoteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Note Details </h5>

            </div>
            <div class="modal-body">
                <div>


                    <div id="allNote">
                        <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                            <div class="d-flex justify-content-between align-items-center" id="singleNote">
                                <div>
                                    <p class="mb-0 text-dark fs-5">Sohag Sarkar</p>
                                    <p class="text-info" style="font-size: 12px">ID-23456</p>
                                </div>
                                <div>
                                    <p>June 17, 2023</p>
                                </div>
                            </div>
                            <p>note body</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Read More</p>
                                </div>
                                <div>
                                    <button class="btn btn-primary py-1">Edit</button>
                                </div>
                            </div>
                        </div>




                    </div>




                    <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                        <div class="d-flex justify-content-between align-items-center">

                        </div>

                        <form action="{{route('admin.tutor.note')}}" method="POST" id="tutorNote">

                            @csrf

                            <input type="hidden" name="tutor_id" id="note_tutor_id">
                            <div class="form-group">
                                <label>Add Note</label>
                                <textarea name="note" class="form-control" rows="5" id="tutor_note"
                                    required=""></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    {{-- <button class="btn btn-primary py-1">Save</button> --}}
                                </div>
                                <div>
                                    <button class="btn btn-primary py-1">Save</button>
                                </div>
                        </form>
                    </div>
                </div>




            </div>
        </div>



        <div class="modal-footer">
            <div class="py-2"></div>
        </div>
    </div>
</div>
</div>


{{-- end note modal --}}




{{-- start Note modal --}}
<div class="modal fade" id="noteModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add Note for </h5> &nbsp<h5 id="tutor_name"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="" method="post" action="route('admin.tutor.note-create')">
                    @csrf

                    <input type="hidden" name="_method" value="put" />
                    <input class="form-control" type="hidden" id="tutor_id" name="tutor_id" value="">
                    <input type="hidden" value="{{ route('admin.tutor.note-create') }}" id="tutor_note_create_route" />

                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="8" id="tutor_note" required=""></textarea>
                    </div>

                    {{--
            <textarea name="long_description" class="form-control" rows="8" id="long_description" required>
            </textarea> --}}

                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="btnCreateNote(event)">Save Note</button>
            </div>
            </form>

        </div>

    </div>
</div>

{{-- end note modal --}}

<form style="display: none" action="{{ route('admin.tutor.sms-editor') }}" method="POST" id="smsForm">
    @csrf
    <input type="hidden" id="var1" name="all_id" value="" />
</form>
@endsection



@push('page_scripts')



{{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script> --}}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


@include('backend.tutor.js.swtdeleteMethod_js')
@include('backend.tutor.js.index_page_js')
@include('data_tables.data_table_js')



@endpush

<style>

</style>
