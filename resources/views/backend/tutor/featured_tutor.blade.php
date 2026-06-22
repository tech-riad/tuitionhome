@extends('layouts.app')

@push('page_css')
<style>
.report-card{
    padding: 20px;
}
</style>

@endpush
{{-- <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" /> --}}

@section('content')
    <main class="container-custom">
        <div class="col-md-9 ms-sm-auto col-lg-12" style="">
            <!-- mini nav starts here -->
            <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
                <a class="text-decoration-none text-gray-800" href="{{route('tutor.index')}}">All Tutors</a>
                <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.premium')}}">Premium Tutor</a>
                <a class="text-decoration-none text-gray-800 active-border" href="{{route('admin.tutor.featured')}}">Featured Tutor</a>
            </div>

            <div id="count" style="margin-left: 18px">
                <div class="row">
                    <div class="col-md-2">
                        <div class="report-card card" style="text-align:center">
                            <h2>{{ App\Models\Tutor::whereDate('featured_date', today())->count() }}
                            </h2>
                            <span>Today Featured Tutors</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="report-card card" style="text-align:center">
                            <h2>{{ $male_featured_tutor_count }}</h2>
                            <span>Male Featured Tutors</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="report-card card" style="text-align:center">
                            <h2>{{ $female_featured__tutor_count }}</h2>
                            <span>Female Featured Tutors</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="report-card card" style="text-align:center">
                            <h2>{{ $verified_tutor_count }}</h2>
                            <span>Verified Tutors</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="report-card card" style="text-align:center">
                            <h2>{{ $male_verified_tutor_count }}</h2>
                            <span>Male Verified Tutors</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="report-card card" style="text-align:center">
                            <h2>{{ $female_verified_tutor_count }}</h2>
                            <span>Female Verified Tutors</span>
                        </div>
                    </div>
                    {{-- <div class="col-md-2">
                        <div class="report-card card" style="text-align:center">
                            <h2>{{ $featured_tutor_count }}</h2>
                            <span>Featured Tutors</span>
                        </div>
                    </div> --}}
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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-sliders2 me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>

                        <form action="{{route('admin.tutor.search')}}" method="POST">
                            @csrf
                      </div>


                    <div class="d-flex gap-3">

                        <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                        style="border: 1px solid #cfdfdb">
                        {{-- <i class="bi bi-search text-muted ms-1"></i> --}}
                        <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                            placeholder="Search" style="padding: 12px 18px" id="parentsSearch" />
                      <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>

                    </div>
            </form>


                        <select class="form-select rounded" style="width: 100px">
                            <option selected>50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="400">400</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                    <div class="bg-white pb-4 mb-b">
                        <div class="table-responsive">
                            <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse" id="tutor_data_table">
                                <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                    <tr>
                                        <th scope="col" class="text-nowrap">


                                            <input class="" type="checkbox" value=""
                                                id="select_all" style="margin-right: 12px" />     &nbsp  &nbsp &nbsp Date
                                        </th>
                                        <th scope="col" class="text-nowrap">Tutor ID</th>

                                        <th scope="col" class="text-nowrap">Name</th>
                                        <th scope="col" class="text-nowrap">Rating</th>

                                        <th scope="col" class="text-nowrap">University</th>
                                        <th scope="col" class="text-nowrap">Department</th>
                                        <th scope="col" class="text-nowrap">gender</th>
                                        <th scope="col" class="text-nowrap">Address</th>
                                        <th scope="col" class="text-nowrap">Phone</th>

                                        <th scope="col" class="text-nowrap">SMS</th>
                                        <th  scope="col" class="text-nowrap">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Action &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  @foreach ($tutors as $tutor)
                                    <tr class="" style="vertical-align: middle">


                                      <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                        <input class="checkboxx" type="checkbox" name="ids" id="{{ $tutor->id }}" value="{{ $tutor->id }}" />
                                        <a class="text-decoration-none text-gray-700 btn" id="{{$tutor->created_at}}" onclick="dateTime(this.id)" data-bs-toggle="modal" data-time="{{ $tutor->created_at }}"
                                          data-bs-target="#exampleModal2">


                                        @php
                                      $input  = $tutor->created_at;
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
                                            <a href="{{route('admin.tutor.tutorshow' , ['tutor' => $tutor->id])}}" class="p-1 rounded text-info text-decoration-none"
                                            style="background-color: #e6eef7">{{$tutor->id}}</a>                                        </td>


                                            <td class="text-nowrap">{!! nl2br(e(Str::limit($tutor->name ?? 'NA', 7))) !!}
                                                @if(@$tutor->is_premium == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-regular-9c7ea3fd.svg" alt="">
                                                @endif
                                                @if(@$tutor->is_premium_pro == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-pro-fc790c7d.svg" alt="">
                                                @endif
                                                @if(@$tutor->is_premium_advance == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-advance-4b8e47d2.svg" alt="">
                                                @endif
                                                @if($tutor->is_verified == 1)
                                                <i style="color:#007BFF" class="far fa-check-circle"></i>
                                                @endif
                                                @if(@$tutor->is_internal_verify == 1 && $tutor->is_verified == 0)
                                                <i style="color:#ed228b" class="far fa-check-circle"></i>
                                                @endif
                                                @if(@$tutor->is_featured == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/featured-icon-0c358655.svg" alt="">

                                                @endif
                                                @if(@$tutor->is_boost == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/boost-icon-d47ce3c5.svg"
                                                    alt="">

                                                @endif
                                            </td>
                                        <td class="text-nowrap">

                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked "></span>
                                            <span class="fa fa-star"></span>
                                            <style>
                                                .checked {
                                                  color: orange;
                                                }
                                             </style>

                                        </td>

                                        @php
                                              $totalElements = count($tutor->tutor_education);

                                        @endphp

                                        {{-- {{$totalElements}} --}}

                                        <td class="text-nowrap">{{Str::limit($tutor->tutor_education[$totalElements-1]->institutes->title ?? 'NA', 20)}}</td>
                                        <td class="text-nowrap">{{Str::limit($tutor->tutor_education[$totalElements-1]->departments->title ?? 'NA', 15)}}</td>
                                        <td class="text-nowrap">{{$tutor->gender}}</td>

                                        {{Str::limit( $tutor->tutor_personal_info->location->name ?? 'NA', 10) }}</td>
                                        <th scope="col" class="text-nowrap">{{$tutor->phone}}</th>



                                        <td>
                                            <div class="switch-toggle">
                                                <div class="button-check" id="button-check">
                                                    <input type="checkbox" class="checkbox" id="cbSingle" checked />
                                                    <span class="switch-btn"></span>
                                                    <span class="layer"></span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>

                                          <a href="{{ route('admin.tutor.tutorshow', ['tutor' => $tutor->id]) }}"><button
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


                                         <a href="{{route('admin.tutor.edit-info', ['tutor' => $tutor->id])}}"> <button
                                            class="btn btn-primary btn-sm" >
                                            <i class="fa fa-edit"></i>Edit Info
                                        </button></a>


                                          {{-- <form id="btndelete{{ $tutor->id }}"
                                              action="{{ route('tutor.destroy', ['tutor' => $tutor->id]) }}" method="POST"
                                              style="display:inline">
                                              @csrf
                                              @method('delete')
                                              <button type="button" class="btn btn-danger btn-sm " id="{{ $tutor->id }}"
                                                  onclick="btnDelete(this, this.id)"><i class="fa fa-trash"></i></button>
                                          </form> --}}

                                          {{-- <a class="btn btn-info" href="{{ route('tutor.make.premium', ['tutor' => $tutor->id]) }}">Make Premium</a> --}}
                                          {{-- <a  href="{{ route('tutor.make.featured', ['tutor' => $tutor->id]) }}">Make Featured</a> --}}


                                          <form style="font-size: 0" id="btnConfirmFeatured{{ $tutor->id }}"
                                              action="{{ route('tutor.undo.featured', ['tutor' => $tutor->id]) }}"
                                              method="POST">
                                              @csrf
                                              <button id="{{ $tutor->id }}" type="button" class="btn btn-info btn-sm"
                                                  onclick="btnConfirmFeatured(this, this.id)">Undo Featured</button>
                                          </form>

                                          <form style="display:inline" id="verifyTutor{{ $tutor->id }}"
                                              action="{{ route('admin.tutor.verify', ['tutor' => $tutor->id]) }}" method="POST">
                                              @csrf
                                              <button id="{{ $tutor->id }}" type="button" class="btn btn-sm btn-primary"
                                                  onclick="verifyTutor(this, this.id)">Verify</button>
                                          </form>

                                          <button id="{{ $tutor->id }}" onclick="btnNote(this.id)"
                                              class="btn btn-sm btn-primary" data-toggle="modal"
                                              data-target="#noteModal">note</button>


                                      </td>
                                    </tr>
                                  @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center align-items-center gap-2">



                            {{$tutors->links()}}

                            {{-- <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                                1
                            </button>

                            <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                                2
                            </button>
                            <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                                ..
                            </button>

                            <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                                34
                            </button>

                            <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
                                <i class="bi bi-chevron-right"></i>
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- main content section ends here -->

        </div>
             <!-- Filter model starts here -->
             <form action="{{route('admin.tutor.filter')}}" method="post">
                @csrf
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
                                                    <option selected value="">Select city</option>


                                                </select>
                                            </div>
                                            <div class="pb-3">
                                                <label for="loc" class="form-label">Location</label>
                                                <br>
                                                <select id="location_id" name="location_id" style="width: 215px"
                                                    class="shadow rounded-2 form-select" aria-label="Default select example">
                                                    <option selected value="">Select Location</option>

                                                </select>
                                            </div>


                                            <div class="pb-3">
                                                <label for="daw" class="form-label">Teaching Method</label>
                                                <select id="method_id" name="method_id" class="shadow rounded-2 form-select"
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
                                                    <input name="datef" type="date" class="form-control shadow rounded-2"
                                                        id="datef" />
                                                </div>
                                            </div>
                                            <div class="pb-3">
                                                <label for="datet" class="form-label">Date To</label>
                                                <input name="datet" type="date" class="form-control shadow rounded-2"
                                                    id="datet" />
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

                                                <select multiple name="category_id[]" id="category_id"
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



                                                <select multiple name="course_id[]" class="form-select rounded-3 shadow-none"
                                                    style="width: 215px" id="course_id">

                                                </select>
                                                <span class="text-danger error-text course_id_error"></span>



                                            </div>
                                            <div class="mb-3">
                                                <label for="subject_id" class="form-label ">Subjects</label>
                                                <select name="subject_id[]" class="select2 form-select rounded-3 shadow-none" multiple id="subject_id" style="padding: 14px 10px; height: auto;">

                                                </select>
                                                <span class="text-danger error-text subject_id_error"></span>
                                            </div>


                                            <div class="pb-3">
                                                <label for="study" class="form-label">Study Type</label>
                                                <select multiple name="study_type_id[]" id="study_type_id"
                                                    class="shadow rounded-2 form-select" aria-label="Default select example">
                                                    <option value=''>select Type</option>
                                                    @foreach (App\Models\Study::OrderBy('title','asc')->get() as $study)

                                                    <option value="{{$study->id}}">{{$study->title}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text course_id_error"></span>
                                            </div>




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
                                                <select name="tutor_university_type"
                                                    class="form-select rounded-3 shadow-none select2"
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

                                                <select multiple name="honours_institute_id[]"
                                                    class="shadow rounded-2 form-select" style="width: 215px" id="institute_id"
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

                                                <select multiple name="department_id[]" style="width: 215px"
                                                    class="shadow rounded-2 form-select" id="department_id"
                                                    onchange="filterChange('department_id',this.id)"
                                                    aria-label="Default select example">
                                                    <option value="">Select Department</option>
                                                    @foreach (App\Models\Department::OrderBy('title','asc')->get() as
                                                    $department)

                                                    <option value="{{$department->id}}">{{$department->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="pb-3">
                                                <label for="sub" class="form-label">Curriculam(HSC)</label>

                                                <select id="hsc_curriculum_id" name="hsc_curriculum_id"
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

                                        </div>
                                        <!-- Dont remove this unnessary wrapper flex div -->
                                    </div>
                                </div>

                                <div class="collapse" id="collapseExample">
                                    <div class="border-top border-2 pt-1 mx-4"></div>
                                    <div class="row row-cols-2 row-cols-lg-4 pb-2 ps-4 pt-2">
                                        <div class="d-flex">
                                            <div>



                                                <div class="pb-3" style="width: 215px">
                                                    <label for="loc" class="form-label">Prefered Location</label>
                                                    <br>
                                                    <select multiple id="pre_location_id" name="pre_location_id[]"
                                                        style="width: 215px" class="shadow rounded-2 form-select"
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
                                                        <option selected value="">select experience</option>
                                                        <option value="1">1 year</option>
                                                        <option value="2">2 year</option>
                                                        <option value="3">3 year</option>
                                                        <option value="4">4 year</option>
                                                        <option value="5">5 year</option>
                                                        <option value="6">6 year</option>
                                                        <option value="7">7 year</option>


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
                                                        <option selected value="">Select Religion</option>
                                                        <option value="islam">Islam</option>
                                                        <option value="hinduism">Hinduism</option>
                                                        <option value="christianity">Christianity</option>
                                                        <option value="buddhism">Buddhism</option>
                                                        <option value="other">Other</option>

                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="channel" class="form-label">Blood Group</label>

                                                    <select id="blood_group" name="blood_group"
                                                        class="shadow rounded-2 form-select"
                                                        onchange="filterChange('blood_group',this.id)"
                                                        aria-label="Default select example">
                                                        <option selected value="">Select Blood Group</option>
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

                                                    <select name="expected_salary" class="form-select rounded-3 shadow-none"
                                                        aria-label="Default select " id="expected_salary">
                                                        <option value="">Select Expected Salary</option>

                                                        <option value="2000">
                                                            BDT 2000
                                                        </option>
                                                        <option value="2500">
                                                            BDT 2500
                                                        </option>
                                                        <option value="3000">
                                                            BDT 3000
                                                        </option>
                                                        <option value="4000">
                                                            BDT 3500
                                                        </option>
                                                        <option value="4500">
                                                            BDT 4000
                                                        </option>
                                                        <option value="5000">
                                                            BDT 4500
                                                        </option>
                                                        <option value="5500">
                                                            BDT 5000
                                                        </option>
                                                        <option value="6000">
                                                            BDT 5500
                                                        </option>
                                                        <option value="6500">
                                                            BDT 6000
                                                        </option>
                                                        <option value="7000">
                                                            BDT 6500
                                                        </option>
                                                        <option value="7500">
                                                            BDT 7000
                                                        </option>
                                                        <option value="8000">
                                                            BDT 7500
                                                        </option>
                                                        <option value="8500">
                                                            BDT 8000
                                                        </option>
                                                        <option value="9000">
                                                            BDT 8500
                                                        </option>
                                                        <option value="9500">
                                                            BDT 9000
                                                        </option>
                                                        <option value="10000">
                                                            BDT 10000
                                                        </option>
                                                        <option value="10500">
                                                            BDT 10500
                                                        </option>
                                                        <option value="11000">
                                                            BDT 11000
                                                        </option>
                                                        <option value="11500">
                                                            BDT 11500
                                                        </option>
                                                        <option value="11500">
                                                            BDT 11500
                                                        </option>
                                                        <option value="12000">
                                                            BDT 12000
                                                        </option>
                                                        <option value="12500">
                                                            BDT 12500
                                                        </option>
                                                        <option value="13000">
                                                            BDT 13000
                                                        </option>
                                                        <option value="13500">
                                                            BDT 13500
                                                        </option>
                                                        <option value="14000">
                                                            BDT 14000
                                                        </option>
                                                        <option value="14500">
                                                            BDT 14500
                                                        </option>
                                                        <option value="15000">
                                                            BDT 15000
                                                        </option>
                                                        <option value="15500">
                                                            BDT 15500
                                                        </option>
                                                        <option value="16000">
                                                            BDT 16000
                                                        </option>
                                                        <option value="16500">
                                                            BDT 16500
                                                        </option>
                                                        <option value="17000">
                                                            BDT 17000
                                                        </option>
                                                        <option value="17500">
                                                            BDT 17500
                                                        </option>
                                                        <option value="18000">
                                                            BDT 18000
                                                        </option>
                                                        <option value="18500">
                                                            BDT 18500
                                                        </option>
                                                        <option value="19000">
                                                            BDT 19000
                                                        </option>
                                                        <option value="19500">
                                                            BDT 19500
                                                        </option>
                                                        <option value="20000">
                                                            BDT 20000
                                                        </option>
                                                        <option value="20500">
                                                            BDT 20500
                                                        </option>
                                                        <option value="21000">
                                                            BDT 21000
                                                        </option>
                                                        <option value="21500">
                                                            BDT 21500
                                                        </option>
                                                        <option value="22000">
                                                            BDT 22000
                                                        </option>
                                                        <option value="22500">
                                                            BDT 22500
                                                        </option>
                                                        <option value="23000">
                                                            BDT 23000
                                                        </option>
                                                        <option value="23500">
                                                            BDT 23500
                                                        </option>
                                                        <option value="24000">
                                                            BDT 24000
                                                        </option>
                                                        <option value="24500">
                                                            BDT 24500
                                                        </option>
                                                        <option value="25000">
                                                            BDT 25000
                                                        </option>
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
                                                    <label for="am" class="form-label">School</label>

                                                    <select name="ssc_institute_id" class="shadow rounded-2 form-select"
                                                        style="width: 215px" id="ssc_institute_id"
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

                                                    <select name="ssc_group_or_major" id="ssc_group_or_major"
                                                        class="shadow rounded-2 form-select"
                                                        onchange="filterChange('group_or_major',this.id)"
                                                        aria-label="Default select example">
                                                        <option selected value=''>Select Group</option>
                                                        <option value="Science">Science</option>
                                                        <option value="Commerce">Commerce</option>
                                                        <option value="Arts">Arts</option>

                                                    </select>
                                                </div>

                                                <div class="pb-3">
                                                    <label for="am" class="form-label">SSC board</label>

                                                    <select name="education_board_ssc" id="education_board"
                                                        class="shadow rounded-2 form-select"
                                                        onchange="filterChange('education_board',this.id)"
                                                        aria-label="Default select example" id="gender">
                                                        <option value="">~ select board ~</option>
                                                        <option value="Dhaka">Dhaka</option>
                                                        <option value="Rajshahi">Rajshahi</option>
                                                        <option value="Mymensingh">Mymensingh</option>
                                                        <option value="Comilla">Comilla</option>
                                                        <option value="Jessore">Jessore</option>
                                                        <option value="Chittagong">Chittagong</option>
                                                        <option value="Barisal">Barisal</option>
                                                        <option value="Sylhet">Sylhet</option>
                                                        <option value="Khulna">khulna</option>
                                                        <option value="Dinajpur">Dinajpur</option>
                                                        <option value="Madrasah">Madrasah</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Canadian">Canadian</option>
                                                        <option value="Ib">IB</option>
                                                        <option value="Ed-excel">Ed-Excel</option>
                                                        <option value="Cambridge">Cambridge</option>
                                                        <option value="Other">Other</option>



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

                                                    <select name="hsc_group_or_major" id="hsc_group_or_major"
                                                        class="shadow rounded-2 form-select"
                                                        onchange="filterChange('group_or_major',this.id)"
                                                        aria-label="Default select example">
                                                        <option selected value=''>Select Group</option>
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
                                                        <option value="">~ select board ~</option>
                                                        <option value="Dhaka">Dhaka</option>
                                                        <option value="Rajshahi">Rajshahi</option>
                                                        <option value="Mymensingh">Mymensingh</option>
                                                        <option value="Comilla">Comilla</option>
                                                        <option value="Jessore">Jessore</option>
                                                        <option value="Chittagong">Chittagong</option>
                                                        <option value="Barisal">Barisal</option>
                                                        <option value="Sylhet">Sylhet</option>
                                                        <option value="Khulna">khulna</option>
                                                        <option value="Dinajpur">Dinajpur</option>
                                                        <option value="Madrasah">Madrasah</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Canadian">Canadian</option>
                                                        <option value="Ib">IB</option>
                                                        <option value="Ed-excel">Ed-Excel</option>
                                                        <option value="Cambridge">Cambridge</option>
                                                        <option value="Other">Other</option>

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

                                    {{-- <input name="searchInput" type="hidden" value="" id="searchInput"> --}}
                                    <button type="button" class="btn btn-danger py-1 me-2">
                                        Clear
                                    </button>






                                    <button type="submit" class="btn btn-primary py-1">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Filter Model ends here -->

            <!--Date model starts here-->
      <div class="modal fade"  id="exampleModal2" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog model-sm modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body pt-5 pb-4">
              <p id="date" class="text-center text-info fs-3">7 June 2023</p>

              {{-- <p>{{data}}</p> --}}
              <p  id="time" class="text-center text-gray-700 border-top fs-1 pt-1">
                03:30 PM
              </p>
            </div>
          </div>
        </div>
      </div>
      <!--Date model ends here-->
        <!--ME model starts here-->

        <!--ME model ends here-->
        <!--Action model starts here-->
        {{-- <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: fit-content">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <a class="btn btn-ndark" href="see-condition.html">See Condition</a>
                            <a class="btn btn-ndark" href="status-log.html">Status Log</a>
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-pink">Hide</button>

                            <a class="btn btn-ndark" href="search-tutor.html">Search Tutor</a>
                            <a class="btn btn-ndark" href="sms-log.html">SMS Log</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--Action model ends here-->
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
                        <input type="text" value="" class="form-control name" name="name"
                            id="name" required>
                        <label style="" class="form-labal">Email</label><br>
                        <input type="text" value="" class="form-control name" name="email"
                            id="email" required>
                        <label style="" class="form-labal">Phone</label><br>
                        <input type="text" value="" class="form-control name" name="phone"
                            id="phone" required>

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
                        <input type="hidden" value="{{ route('admin.tutor.note-create') }}"
                            id="tutor_note_create_route" />

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



<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    @include('backend.tutor.js.swtdeleteMethod_js')
    @include('backend.tutor.js.index_page_js')

@endpush

<style>

</style>
