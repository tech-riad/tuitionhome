

@extends('layouts.app')

@push('page_css')
<style>
.report-card{
    padding: 20px;
}
</style>

@endpush

@section('content')
<main class="container-custom">
  <div class="col-md-9 ms-sm-auto col-lg-12" style="">
      <!-- mini nav starts here -->
      <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
          <a class="text-decoration-none text-gray-800 active-border" href="{{route('parent.index')}}">All Parents</a>
          {{-- <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.premium')}}">Premium Tutor</a>
          <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.featured')}}">Featured Tutor</a> --}}
      </div>
      @if(session('message'))
<p class="alert alert-success">{{ session('message') }}</p>
@endif

      <div id="count" style="margin-left: 18px">
          <div class="row">
              <div class="col-md-2">
                  <div class="report-card card" style="text-align:center">
                      <h2 >{{ $all_parent_count }}</h2>
                      <span>All Parents</span>
                  </div>
              </div>
              <div class="col-md-2">
                  <div class="report-card card" style="text-align:center">
                      <h2>{{ $male_parent_count }}</h2>
                      <span>Male Parents</span>
                  </div>
              </div>
              <div class="col-md-2">
                  <div class="report-card card" style="text-align:center">
                      <h2>{{ $female_parent_count }}</h2>
                      <span>Female Parents</span>
                  </div>
              </div>


          </div>


      </div>




      <!-- mini nav ends here -->
      <!-- main content section starts here -->
      <div class="ps-3" style="padding-right: 13px">



        <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">

         <div class="d-flex justify-content-between gap-3">


             <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>

             <a href="{{route('parent.create')}}" class="btn btn-outline-ndark">Add New Parent</a>

            </div>


            <div class="d-flex gap-3">
             <form action="{{route('admin.parent.search')}}" method="POST">
                 @csrf


                <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                style="border: 1px solid #cfdfdb">
                {{-- <i class="bi bi-search text-muted ms-1"></i> --}}
                <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                    placeholder="Search" style="padding: 12px 18px" id="" />
                <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
            </form>

         </div>
      {{-- </form> --}}


             {{-- <input type="text" class="form-control rounded" placeholder="Search" /> --}}

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
                                     id="select_all" style="margin-right: 12px" />     &nbsp  &nbsp &nbsp Created_at
                             </th>
                             <th scope="col" class="text-nowrap">Parent ID</th>

                             <th scope="col" class="text-nowrap">Name</th>

                             <th scope="col" class="text-nowrap">phone</th>
                             <th scope="col" class="text-nowrap">Hired From</th>
                             <th scope="col" class="text-nowrap">gender</th>
                             <th scope="col" class="text-nowrap">Address</th>
                             <th scope="col" class="text-nowrap">additional Phone</th>

                             <th scope="col" class="text-nowrap">SMS</th>
                             <th  scope="col" class="text-nowrap">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Action &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                         </tr>
                     </thead>
                     <tbody>

                       @foreach ($parents as $parentt)
                         <tr class="" style="vertical-align: middle">


                           <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                             <input class="checkboxx" type="checkbox" name="ids" id="{{ $parentt->id }}" value="{{ $parentt->id }}" />
                             <a class="text-decoration-none text-gray-700 btn" id="{{$parentt->created_at}}" onclick="dateTime(this.id)" data-bs-toggle="modal" data-time="{{ $parentt->created_at->diffForHumans() }}"
                               data-bs-target="#exampleModal2">


                             @php
                           $input  = $parentt->created_at;
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
                                 <a href="#" class="p-1 rounded text-info text-decoration-none"
                                 style="background-color: #e6eef7">{{$parentt->id}}</a>                                        </td>

                             <td class="text-nowrap">{{$parentt->name}}</td>

                             <th scope="col" class="text-nowrap">{{$parentt->phone}}</th>
                             <td>Facebook</td>
                             <td class="text-nowrap">{{$parentt->ParentPersonalInfo->gender ?? 'n/a'}}</td>

                             <td class="text-nowrap">{{$parentt->ParentPersonalInfo->address_details ?? 'n/a'}}</td>

                             <th class="text-nowrap">{{$parentt->additional_phone ?? 'n/a'}}</th>


                             <td>

                                 <div class="switch-toggle">
                                     <div class="button-check" id="button-check">
                                        <input type="checkbox" class="checkbox" checked name="checkbox" id="checkbox"/>                                         <span class="switch-btn"></span>
                                         <span class="layer"></span>
                                     </div>
                                 </div>
                             </td>

                             <td>

                                <button class="btn btn-primary py-1 px-2" id="{{ $parentt->id }}" onclick="btnNote(this.id)"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal1">
                                Note
                              </button>

                              {{-- <button id="{{ $tutor->id }}" onclick="btnNote(this.id)"
                                class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#noteModal">note</button> --}}


                              <a href="{{ route('admin.parent.show', ['parent' => $parentt->id]) }}"><button class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i>
                                </button></a>
                                <a href="{{ route('admin.parent.single-sms', ['parent' => $parentt->id]) }}">
                                  <button class="btn btn-info btn-sm">
                                      <i class="fa fa-envelope"></i>
                                      </button></a>

                           <button id="{{$parentt->id}}" onclick="btnEdit(this.id)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModal">
                                <i class="fa fa-edit btn btn-success"></i>
                                </button>


                            {{-- <form id="btndelete{{$parentt->id}}" action="{{ route('parent.destroy', ['parent' => $parentt->id]) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger btn-sm " id="{{$parentt->id}}" onclick="btnDelete(this, this.id)" ><i class="fa fa-trash"></i></button>
                            </form> --}}


                           </td>
                         </tr>
                       @endforeach

                     </tbody>
                 </table>
             </div>
             <div class="d-flex justify-content-center align-items-center gap-2">

                {{$parents->links()}}

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



    <!-- Note model -->
    <div
      class="modal fade"
      id="exampleModal1"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
      >
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLabel">Note Details </h5>

          </div>
          <div class="modal-body">
            <div  >


               <div id="allNote">
                  <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3" >
                    <div class="d-flex justify-content-between align-items-center" id="singleNote">
                        <div>
                          <p class="mb-0 text-dark fs-5">Sohag Sarkar</p>
                          <p class="text-info" style="font-size: 12px">ID-23456</p>
                        </div>
                        <div><p>June 17, 2023</p></div>
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

                <form action="{{route('admin.parent.note')}}" method="POST" id="parentNote">

                 @csrf

                 <input type="hidden" name="parent_id" id="note_parent_id">
                <div class="form-group">
                    <label>Add Note</label>
                    <textarea name="note" class="form-control" rows="5" id="tutor_note" required=""></textarea>
                </div>

                <div
                  class="d-flex justify-content-between align-items-center"
                >

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




    {{-- create note modal end hare  --}}



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
                        <form id="" method="post" action="">
                            @csrf

                            <input type="hidden" name="_method" value="put" />
                            <input class="form-control" type="hidden" id="tutor_id" name="tutor_id" value="">
                            <input type="hidden" value=""
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













   <!-- Filter model starts here -->
   <div class="modal fade font-pop" id="exampleModal" tabindex="" aria-labelledby="">
      <div class="modal-dialog px-3" style="max-width: 1100px">
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
                              <div class="mb-3">
                                  <label for="cun" class="form-label required">Country</label>
                                  <br>
                                  <select name="country_id" class="form-select rounded-3 shadow-none " aria-label="Default select " id="country_id" onchange="filterChange('country_id',this.id)">

                                  {{-- <select name="country_id" style="width: 215px" class="form-select rounded-3 shadow-none " aria-label="Default select " id="country_id" style="padding: 14px 18px"> --}}
                                      <option selected >Select Country</option>
                                      @foreach (App\Models\Country::OrderBy('name','asc')->get() as $country)
                                      <option value="{{$country->id}}">{{$country->name}}</option>
                                      @endforeach
                                  </select>
                                  <span class="text-danger error-text country_id_error"></span>

                              </div>

                               <div class="pb-3">
                                  <label for="cty" class="form-label">City</label>
                                  <br>
                                  <select name="city_id" id="city_id" style="width: 215px" class="shadow rounded-2 form-select" onchange="filterChange('city_id',this.id)"
                                      aria-label="Default select example">
                                      <option selected >Select city</option>


                                  </select>
                              </div>
                              <div class="pb-3">
                                  <label for="loc" class="form-label">Location</label>
                                  <br>
                                  <select id="location_id" name="location_id" style="width: 215px" class="shadow rounded-2 form-select" onchange="filterChange('location_id',this.id)"
                                      aria-label="Default select example">
                                      <option selected >Select Location</option>

                                  </select>
                              </div>
                          </div>
                          <div class="mb-3 ms-4"
                              style="
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
                                      <input  type="date" class="form-control shadow rounded-2" id="datef"  onchange="filterChange('created_at <',this.id)" />
                                  </div>
                              </div>
                              <div class="pb-3">
                                  <label for="datet" class="form-label">Date To</label>
                                  <input type="date" class="form-control shadow rounded-2" id="datet" onchange="filterChange('created_at >',this.id)" />
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

                          </div>
                          <div class="mb-3 ms-4"
                              style="
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

                                  <select id="category_id" class="shadow rounded-2 form-select" onchange="filterChange('category_id',this.id)"
                                      aria-label="Default select example">
                                      <option selected>Bangla Medium</option>
                                      @foreach(App\Models\Category::OrderBy('name','asc')->get() as $category)
                                      <option value="{{$category->id}}">{{$category->name}}</option>

                                      @endforeach
                                  </select>
                              </div>
                              <div class="pb-3">
                                  <label for="course" class="form-label">Study Type</label>

                                  <select id="study_type_id" class="shadow rounded-2 form-select" onchange="filterChange('study_type_id',this.id)"
                                      aria-label="Default select example">
                                      <option selected>select Type</option>
                                      @foreach (App\Models\Study::OrderBy('title','asc')->get() as $study)

                                      <option value="{{$study->id}}" >{{$study->title}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="pb-3">
                                  <label for="sub" class="form-label">Curriculam</label>

                                  <select id="curriculum_id" name="curriculum_id" class="shadow rounded-2 form-select" onchange="filterChange('curriculum_id',this.id)"
                                      aria-label="Default select example">
                                      <option selected>select curriculam</option>
                                      @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as $curriculam)

                                      <option value="{{$curriculam->id}}" >{{$curriculam->title}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="mb-3 ms-4"
                              style="
            margin-top: 34px;
            width: 1px;
            background-color: #f0f1f2;
          ">
                          </div>
                      </div>
                      <div class="d-flex justify-content-start">
                          <div>

                              <div class="pb-3">
                                  <label for="tm" class="form-label">Gender</label>

                                  <select id="gender" class="shadow rounded-2 form-select" onchange="filterChange('gender',this.id)"
                                      aria-label="Default select example">
                                      <option selected>select Gender</option>
                                      <option value="male">Male</option>
                                      <option value="female">Female</option>
                                      <option value="others">Others</option>
                                  </select>
                              </div>
                              <div class="pb-3">
                                  <label for="am" class="form-label">University</label>

                                  <select  class="shadow rounded-2 form-select" style="width: 215px" id="institute_id" onchange="filterChange('degree_name=\'honours\' and institute_id',this.id)"
                                      aria-label="Default select example">
                                      <option value="">Select Institute</option>

                                      @foreach (App\Models\Institute::where('type', 'university')->OrderBy('title','asc')->get() as $institute)

                                      <option  value="{{$institute->id}}">{{$institute->title}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="pb-3">
                                  <label for="srcid" class="form-label">Department</label>

                                  <select style="width: 215px" class="shadow rounded-2 form-select" id="department_id" onchange="filterChange('department_id',this.id)"
                                      aria-label="Default select example">
                                      <option value="">Select Group</option>
                                              @foreach (App\Models\Department::OrderBy('title','asc')->get() as $department)

                                              <option value="{{$department->id}}">{{$department->title}}</option>
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
                                      <label for="salary" class="form-label">Expected Salary</label>

                                      <input type="text" class="form-control shadow rounded-2" id="expected_salary" onchange="filterChange('expected_salary',this.id)"
                                          placeholder="5000" />
                                  </div>


                                  <div class="pb-3">
                                      <label for="daw" class="form-label">Experience</label>

                                      <select id="daw" name="tutoring_experience" id="tutoring_experience" class="shadow rounded-2 form-select" onchange="filterChange('tutoring_experience',this.id)"
                                          aria-label="Default select example">
                                          <option selected>select experience</option>
                                          <option value="1 year">1 year</option>
                                          <option value="2 year">2 year</option>
                                          <option value="3 year">3 year</option>
                                          <option value="4 year">4 year</option>
                                          <option value="5 year">5 year</option>
                                          <option value="6 year">6 year</option>

                                      </select>
                                  </div>


                                  <div class="pb-3">
                                      <label for="daw" class="form-label">Teaching Method</label>
                                      <select id="method_id" name="method_id" class="shadow rounded-2 form-select" onchange="filterChange('method_id',this.id)"
                                      aria-label="Default select example">
                                      <option selected>select Teaching Method</option>

                                      @foreach (App\Models\TeachingMethod::OrderBy('name','asc')->get() as $teachingM)

                                      <option value="{{$teachingM->id}}" >{{$teachingM->name}}</option>

                                      @endforeach
                                  </select>
                                  </div>



                              </div>
                              <div class="mb-3 ms-4"
                                  style="
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
                                          Religion
                                      </label>

                                      <select id="religion" name="religion" class="shadow rounded-2 form-select" onchange="filterChange('religion',this.id)"
                                          aria-label="Default select example">
                                          <option selected>Select Religion</option>
                                          <option value="Islam">Islam</option>
                                          <option value="Hinduism">Hinduism</option>
                                          <option value="Christianity" >Christianity</option>
                                          <option value="Buddhism">Buddhism</option>
                                          <option value="Other">Other</option>

                                      </select>
                                  </div>
                                  <div class="pb-3">
                                      <label for="channel" class="form-label">Blood Group</label>

                                      <select id="blood_group" name="blood_group" class="shadow rounded-2 form-select" onchange="filterChange('blood_group',this.id)"
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
                                      <label for="channel" class="form-label">Campaigner Code</label>

                                      <select id="channel" class="shadow rounded-2 form-select"
                                          aria-label="Default select example">
                                          <option selected>Select Campaigner Code</option>
                                          <option value="CAP-1202" data-select2-id="997">CAP-1202</option>
                                          <option value="CAP-1203" data-select2-id="998">CAP-1203</option>
                                          <option value="CA-1204" data-select2-id="999">CA-1204</option>
                                          <option value="CAP-1204" data-select2-id="1000">CAP-1204</option>
                                          <option value="CA-1205" data-select2-id="1001">CA-1205</option>
                                          <option value="CAP-1205" data-select2-id="1002">CAP-1205</option>
                                          <option value="CA-1206" data-select2-id="1003">CA-1206</option>
                                          <option value="CAP-1206" data-select2-id="1004">CAP-1206</option>
                                          <option value="CA-1207" data-select2-id="1005">CA-1207</option>
                                          <option value="CA-1209" data-select2-id="1006">CA-1209</option>
                                          <option value="CAP-1209" data-select2-id="1007">CAP-1209</option>
                                          <option value="CA-1210" data-select2-id="1008">CA-1210</option>
                                          <option value="CAP-1210" data-select2-id="1009">CAP-1210</option>
                                          <option value="CA-1211" data-select2-id="1010">CA-1211</option>
                                          <option value="CAP-1211" data-select2-id="1011">CAP-1211</option>
                                          <option value="CA-1212" data-select2-id="1012">CA-1212</option>
                                          <option value="CAP-1212" data-select2-id="1013">CAP-1212</option>
                                          <option value="CA-1213" data-select2-id="1014">CA-1213</option>
                                          <option value="CAP-1213" data-select2-id="1015">CAP-1213</option>
                                          <option value="CA-1214" data-select2-id="1016">CA-1214</option>
                                          <option value="CAP-1214" data-select2-id="1017">CAP-1214</option>
                                          <option value="CA-1201" data-select2-id="1018">CA-1201</option>
                                          <option value="CAP-1201" data-select2-id="1019">CAP-1201</option>

                                      </select>
                                  </div>




                              </div>
                              <div class="mb-3 ms-4"
                                  style="
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

                                      <select  class="shadow rounded-2 form-select" style="width: 215px" id="ssc_institute_id" onchange="filterChange('degree_name=\'ssc\' and institute_id',this.id)"
                                          aria-label="Default select example">
                                          <option value="">Select Institute</option>

                                          @foreach (App\Models\Institute::where('type', 'school')->orWhere('type', 'school and college')->OrderBy('title','asc')->get() as $institute)

                                          <option  value="{{$institute->id}}">{{$institute->title}}</option>
                                          @endforeach
                                      </select>
                                  </div>

                                  <div class="pb-3">
                                      <label for="in" class="form-label">
                                          SSC Group
                                      </label>

                                      <select id="ssc_group_or_major" class="shadow rounded-2 form-select" onchange="filterChange('group_or_major',this.id)"
                                          aria-label="Default select example">
                                          <option selected >Select Group</option>
                                          <option value="science" >Science</option>
                                          <option value="commerce">Commerce</option>
                                          <option value="arts">Arts</option>
                                          <option value="humanities">Humanities</option>

                                      </select>
                                  </div>

                                  <div class="pb-3">
                                      <label for="am" class="form-label">SSC board</label>

                                      <select name="education_board" id="education_board" class="shadow rounded-2 form-select" onchange="filterChange('education_board',this.id)"
                                      aria-label="Default select example" id="gender">
                                                  <option selected >Select Board</option>
                                                  <option value="dhaka">Dhaka</option>
                                                  <option value="rajshahi">Rajshahi</option>
                                                  <option value="comilla">Comilla</option>
                                                  <option value="jessore">Jessore</option>
                                                  <option value="chittagong">Chittagong</option>
                                                  <option value="barisal">Barisal</option>
                                                  <option value="sylhet">Sylhet</option>
                                                  <option value="khulna">khulna</option>
                                                  <option value="dinajpur">Dinajpur</option>
                                                  <option value="madrasah">Madrasah</option>


                                              </select>
                                  </div>
                              </div>
                              <div class="mb-3 ms-4"
                                  style="
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

                                      <select id="hsc_institute_id" style="width: 215px" name="hsc_institute_id" class="shadow rounded-2 form-select" id="institute_id" onchange="filterChange('degree_name=\'hsc\' and institute_id',this.id)"
                                          aria-label="Default select example">
                                          <option value="">Select Institute</option>

                                          @foreach (App\Models\Institute::where('type', 'school')->orWhere('type', 'school and college')->OrderBy('title','asc')->get() as $institute)

                                          <option  value="{{$institute->id}}">{{$institute->title}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="pb-3">
                                      <label for="in" class="form-label">
                                          HSC Group
                                      </label>

                                      <select id="hsc_group_or_major" class="shadow rounded-2 form-select" onchange="filterChange('group_or_major',this.id)"
                                          aria-label="Default select example">
                                          <option selected >Select Group</option>
                                          <option value="science" >Science</option>
                                          <option value="commerce">Commerce</option>
                                          <option value="arts">Arts</option>
                                          <option value="humanities">Humanities</option>

                                      </select>
                                  </div>

                                  <div class="pb-3">
                                      <label for="am" class="form-label">HSC board</label>

                                      <select name="hsc_education_board" id="hsc_education_board" class="shadow rounded-2 form-select" onchange="filterChange('education_board',this.id)"
                                                  aria-label="Default select example" id="gender">
                                                  <option selected >Select Board</option>
                                                  <option value="dhaka">Dhaka</option>
                                                  <option value="rajshahi">Rajshahi</option>
                                                  <option value="comilla">Comilla</option>
                                                  <option value="jessore">Jessore</option>
                                                  <option value="chittagong">Chittagong</option>
                                                  <option value="barisal">Barisal</option>
                                                  <option value="sylhet">Sylhet</option>
                                                  <option value="khulna">khulna</option>
                                                  <option value="dinajpur">Dinajpur</option>
                                                  <option value="madrasah">Madrasah</option>


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
                      <form action="{{route('admin.tutor.filter')}}" method="post" >
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

</main>


{{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         <p>Edit & Update Parents</p>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <form id="" method="post" action="{{route('parent.update','parent')}}" >
            @csrf

            <input type="hidden" name="_method" value="put" />
            <input class="form-control" type="hidden" id="parent_id" name="parent_id" value="">
          <label style="" class="form-labal">Full Name</label><br>
          <input type="text" value="" class="form-control name" name="name" id="name" required>
          <label style="" class="form-labal">Email</label><br>
          <input type="text" value="" class="form-control name" name="email" id="email">
          <label style="" class="form-labal">Phone</label><br>
          <input type="text" value="" class="form-control name" name="phone" id="phone" required>
          <label style="" class="form-labal">Additional Phone</label><br>
          <input type="text" value="" class="form-control name" name="additional_phone" id="additional_phone">
          {{-- <p>Some text in the modal.</p> --}}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"  onclick="btnEdit()">Update Parent</button>
        </div>
      </form>

      </div>

    </div>
  </div>


  {{-- end Edit Modal --}}



  {{-- start sms modal  --}}
  <div class="modal" id="smsModal" tabindex="-1" role="dialog">
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

  {{-- end sms modal --}}


  <form style="display: none" action="{{route('admin.parent.sms-editor')}}" method="POST" id="smsForm">
   @csrf
    <input type="hidden" id="var1" name="all_id" value=""/>
  </form>

  @endsection


@push('page_scripts')

@include('js.swtdeleteMethod_js')
@include('backend.parents.js.index_page_js')

@endpush



