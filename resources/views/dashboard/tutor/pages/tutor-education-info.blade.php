@extends('dashboard.tutor.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/chosen-custom.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        [x-cloak] {
            display: none !important;
        }
        body{
            background-color: #e3e4e9;
        }

        .green-line-var {
            position: absolute;
            top: 68px;
            left: -16px;
            width: 63.33px;
            height: 0px;
            border: 2px solid #7cb305;
            transform: rotate(-90deg);
        }
        .gray-line-var {
            position: absolute;
            top: 68px;
            left: -16px;
            width: 63.33px;
            height: 0px;
            border: 2px solid #d5d5d5;
            transform: rotate(-90deg);
        }
    </style>
@endpush
@section('content')

    <!-- conent section starts -->
    <div id="success">

    </div>
    <!-- conent section starts -->
    <div class="t-dashboard-contant p-4" style="margin-left: 245px">
        <div class="profile-up-banner">
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">1</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="mx-2 t-link" style=" font-size: 14px;font-weight: 400;line-height: 30px; margin-top: -5px;" href="{{ route('tutor.profile.update') }}">
                           Tutoring Information
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p class="money-text" style="line-height: 10px; margin-left: 33px" > 33% complete </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">2</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="mx-2 t-link" style="
                      font-size: 14px;
                      font-weight: 400;
                      line-height: 30px;
                      margin-top: -5px;
                    " href="#" > Education Information</a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p class="money-text" style="line-height: 10px; margin-left: 33px"> 33% complete </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">3</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="mx-2 t-link"  style="
                      font-size: 14px;
                      font-weight: 400;
                      line-height: 30px;
                      margin-top: -5px;
                    "  href="{{ route('tutor.personal_info') }}"  >  Personal Information  </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p class="money-text"  style="line-height: 10px; margin-left: 33px" >
                    33% complete
                </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">4</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">

                        <a  class="mx-2 t-link"  style="
                      font-size: 14px;
                      font-weight: 400;
                      line-height: 30px;
                      margin-top: -5px;
                    "  href=" {{ route('tutor.crediantial') }}" >
                            Crediantial
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p  class="money-text" style="line-height: 10px; margin-left: 33px"  >
                    33% complete
                </p>
            </div>
        </div>
        <!-- alpine tabs starts here -->
        <div class="row mt-4" x-data="{ tab: 'home'}" x-cloak>
            <div class="col-md-3">
                <div class="data-entry-sidebar">
                    <!-- -------------item starts------------ -->
                    <div class="position-relative mb-4">
                        <div :class="{ 'right-indicator': tab === 'home' }"></div>
                        <div id="step-1" class="gray-line-var"></div>

                        <div class="d-flex flex-column pt-2">
                            <div class="d-flex">
                                <div
                                    :class="[(tab === 'home'|| tab === 'category' || tab === 'avail'|| tab === 'course') ? 'green-circle' : 'gray-circle'] "
                                    style="height: 30px; width: 30px; padding-top: 4px"
                                >
                                    <span class="green-circle-text ">1</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="mx-2 mt-2" style=" font-size: 14px; font-weight: 400;line-height: 3px; ">School</p>
                                </div>
                            </div>
                            <p class="money-text" id="element_add-1" style=" line-height: 10px; margin-left: 38px;font-size: 12px;" >
                                Step Descriptions
                            </p>
                        </div>
                    </div>
                    <!-- -----------item end-------------- -->
                    <!-- -------------item starts------------ -->
                    <div class="position-relative mb-4">
                        <div :class="{ 'right-indicator': tab === 'category' }"></div>

                        <div id="step-2" class="gray-line-var"></div>

                        <div class="d-flex flex-column pt-2">
                            <div class="d-flex">
{{--                                <div  :class="[(tab === 'category' || tab === 'avail'|| tab === 'course') ? 'green-circle' : 'gray-circle'] " style="height: 30px; width: 30px; padding-top: 4px" id="step-2">--}}

{{--                                </div>--}}
                                <span class="green-circle-text step green-circle"  style="height: 30px; width: 30px; padding-top: 2px">2</span>
                                <div   class="d-flex align-items-center justify-content-center"  >
                                    <p class="mx-2 mt-2" style=" font-size: 14px; font-weight: 400; line-height: 3px; " >  College  </p>
                                </div>
                            </div>
                            <p class="money-text" id="element_add-2" style=" line-height: 10px; margin-left: 38px;  font-size: 12px; "  >
                                Step Descriptions
                            </p>
                        </div>
                    </div>
                    <!-- -----------item end-------------- -->
                    <!-- -------------item starts------------ -->
                    <div class="position-relative mb-4">
                        <div :class="{ 'right-indicator': tab === 'avail' }"></div>
                        <div id="step-3" class="gray-line-var" ></div>

                        <div class="d-flex flex-column pt-2">
                            <div class="d-flex">
{{--                                <div  :class="[(tab === 'avail'|| tab === 'course') ? 'green-circle' : 'gray-circle'] " style="height: 30px; width: 30px; padding-top: 4px"  >--}}
{{--                                   --}}
{{--                                </div>--}}
                                <span class="green-circle-text step green-circle"  style="height: 30px; width: 30px; padding-top: 2px">3</span>
                                <div class="d-flex align-items-center justify-content-center" >
                                    <p class="mx-2 mt-2"  style="
                            font-size: 14px;
                            font-weight: 400;
                            line-height: 3px;
                          " >  Graduation  </p>
                                    <!-- <span class="green-line"></span> -->
                                </div>
                            </div>
                            <p class="money-text" style="
                        line-height: 10px;
                        margin-left: 38px;
                        font-size: 12px;
                      " id="element_add-3" > Step Descriptions  </p>
                        </div>
                    </div>
                    <!-- -----------item end-------------- -->
                    <!-- -------------item starts------------ -->
                    <div class="position-relative mb-4">
                        <div :class="{ 'right-indicator': tab === 'course' }"></div>
                      <div id="step-4" ></div>

                        <div class="d-flex flex-column pt-2">
                            <div class="d-flex">
{{--                                <div :class="[(tab === 'course') ? 'green-circle' : 'gray-circle'] "  style="height: 30px; width: 30px; padding-top: 4px"  >--}}
{{--                                    <span class="green-circle-text" >4</span>--}}
{{--                                </div>--}}
                                <span class="green-circle-text step green-circle"  style="height: 30px; width: 30px; padding-top: 2px">4</span>
                                <div  class="d-flex align-items-center justify-content-center"  >
                                    <p class="mx-2 mt-2"  style="
                            font-size: 14px;
                            font-weight: 400;
                            line-height: 3px;
                          " > Post Graduation  </p>
                                    <!-- <span class="green-line"></span> -->
                                </div>
                            </div>
                            <p class="money-text" style="
                        line-height: 10px;
                        margin-left: 38px;
                        font-size: 12px;
                      "  id="element_add-4"> Step Descriptions </p>
                        </div>
                    </div>
                    <!-- -----------item end-------------- -->
                </div>
            </div>

            <div class="col-md-9">
                <!-- tab 1 starts -->
                <form action="javascript:void(0)">
                <div class="data-entry mx-2 mt-4 mt-md-0 row tab" id="tab-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ins_6">
                                <label class="form-label">School Name</label>
                                <select id="sName" name="institute_name" class="select2_6 form-control shadow" style="border: none" >
                                    <option value="">~Select Your School~</option>

{{--                                    @foreach($schools as $school)--}}
{{--                                        <option value="{{ $school->id }}" {{ ($ssc_tutor->institute_id == $school->id)? 'selected' : '' }}>{{ $school->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Curriculam</label>
                                <select id="scur" class="js-states chosen-select" >
                                    <option value="">~ select curriculam~ </option>
{{--                                    @foreach($curriculas as $curriculam)--}}
{{--                                        <option value="{{ $curriculam->id }}"  {{ ($ssc_tutor->curriculum_id == $curriculam->id)? 'selected' : '' }}>{{ $curriculam->title }}</option>--}}
{{--                                    @endforeach--}}

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">GPA</label>
{{--                                <input type="number" id="sgpa" name="gpa" value="{{ ($ssc_tutor->gpa != null) ? $ssc_tutor->gpa : ''  }}" class="form-control" placeholder="enter your G.P.A" required>--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Group</label>
                                <select id="sgroup" class="js-states chosen-select" >
                                    <option value="">~ Select Group ~</option>
{{--                                    <option value="Arts" {{ ($ssc_tutor->group_or_major == 'Arts') ? 'selected' : ''  }}>Arts</option>--}}
{{--                                    <option value="Commerce" {{ ($ssc_tutor->group_or_major == 'Commerce') ? 'selected' : ''  }}>Commerce</option>--}}
{{--                                    <option value="Science" {{ ($ssc_tutor->group_or_major == 'Science') ? 'selected' : ''  }}>Science</option>--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Board</label>
                                <select id="sBoard" class="form-control select2" >
                                    <option value="">~ Select Board ~</option>
{{--                                    <option value="Barisal" {{ ($ssc_tutor->education_board == 'Barisal') ? 'selected' : ''  }}>Barisal</option>--}}
{{--                                    <option value="Chittagong"  {{ ($ssc_tutor->education_board == 'Chittagong') ? 'selected' : ''  }}>Chittagong</option>--}}
{{--                                    <option value="Comilla"  {{ ($ssc_tutor->education_board == 'Comilla') ? 'selected' : ''  }}>Comilla</option>--}}
{{--                                    <option value="Dhaka"  {{ ($ssc_tutor->education_board == 'Dhaka') ? 'selected' : ''  }}>Dhaka</option>--}}
{{--                                    <option value="Jessore"  {{ ($ssc_tutor->education_board == 'Jessore') ? 'selected' : ''  }}>Jessore</option>--}}
{{--                                    <option value="Mymensingh"  {{ ($ssc_tutor->education_board == 'Mymensingh') ? 'selected' : ''  }}>Mymensingh</option>--}}
{{--                                    <option value="Rajshahi"  {{ ($ssc_tutor->education_board == 'Rajshahi') ? 'selected' : ''  }}>Rajshahi</option>--}}
{{--                                    <option value="Sylhet"  {{ ($ssc_tutor->education_board == 'Sylhet') ? 'selected' : ''  }}>Sylhet</option>--}}
{{--                                    <option value="Dinajpur"  {{ ($ssc_tutor->education_board == 'Dinajpur') ? 'selected' : ''  }}>Dinajpur</option>--}}
{{--                                    <option value="Technical"  {{ ($ssc_tutor->education_board == 'Technical') ? 'selected' : ''  }}>Technical</option>--}}
{{--                                    <option value="Madrasah"  {{ ($ssc_tutor->education_board == 'Madrasah') ? 'selected' : ''  }}>Madrasah</option>--}}
{{--                                    <option value="Cambridge"  {{ ($ssc_tutor->education_board == 'Cambridge') ? 'selected' : ''  }}>Cambridge</option>--}}
{{--                                    <option value="Ed-excel"  {{ ($ssc_tutor->education_board == 'Ed-excel') ? 'selected' : ''  }}>Ed-excel</option>--}}
{{--                                    <option value="IB"  {{ ($ssc_tutor->education_board == 'IB') ? 'selected' : ''  }}>IB</option>--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Passing Year</label>
                                <select id="sYear" class="form-control select2" >
                                    <option value="">~ Choose Year ~</option>
{{--                                    <?php for($i = 1975; $i <= date('Y') ;$i++){ ?>--}}
{{--                                    <option value="{{$i}}" {{ ($ssc_tutor->passing_year == $i) ? 'selected' : ''  }}>{{ $i }}</option>--}}
{{--                                    <?php } ?>--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group ">

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div  class="d-flex justify-content-between align-items-center mt-4" >
                                    <button class="next-btn px-4 nextbtn" onclick="next(1,2);" {{ (is_active() != true) ? 'disabled':'' }} > Next </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- tab 1 ends -->
                <!-- tab 2 starts -->
                <div class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-2">
                    <div class="row" id="hidden">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">College Name</label>
                                <select id="selectcollege" class="js-states form-control select2_5" style="width: 100%;">
                                    <option value="">~ Select College ~ </option>
{{--                                    @foreach($colleges as $college)--}}
{{--                                        <option value="{{ $college->id }}" {{ ($hsc_tutor->institute_id == $college->id)? 'selected' : '' }}>{{ $college->title }}</option>--}}

{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Curriculam </label>
                                <select id="selectCurriculam" class="form-control select2" style="width: 100%;">
                                    <option value="">~ Select Curriculam ~ </option>
{{--                                    @foreach($curriculas as $curriculam)--}}
{{--                                        <option value="{{ $curriculam->id }}" {{ ($hsc_tutor->curriculum_id == $curriculam->id)? 'selected' : '' }}>{{ $curriculam->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">GPA</label>
{{--                                <input type="number" id="clgGpa"  value="{{ ($hsc_tutor->gpa != null) ? $hsc_tutor->gpa : ''  }}" class="form-control" placeholder="Enter Your G.P.A" name="gpa">--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Group</label>
                                <select id="clgG" class="form-control" style="width: 100%;">
                                    <option value="">~ Select Group ~</option>
{{--                                    <option value="Arts" {{ ($hsc_tutor->group_or_major == 'Arts') ? 'selected' : ''  }}>Arts</option>--}}
{{--                                    <option value="Commerce" {{ ($hsc_tutor->group_or_major == 'Commerce') ? 'selected' : ''  }}>Commerce</option>--}}
{{--                                    <option value="Science" {{ ($hsc_tutor->group_or_major == 'Science') ? 'selected' : ''  }}>Science</option>--}}
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Board</label>
                                <select id="clgB" class="form-control select2" style="width: 100%;">
                                    <option value="">~ Select Board ~</option>
{{--                                    <option value="Barisal" {{ ($hsc_tutor->education_board == 'Barisal') ? 'selected' : ''  }}>Barisal</option>--}}
{{--                                    <option value="Chittagong"  {{ ($hsc_tutor->education_board == 'Chittagong') ? 'selected' : ''  }}>Chittagong</option>--}}
{{--                                    <option value="Comilla"  {{ ($hsc_tutor->education_board == 'Comilla') ? 'selected' : ''  }}>Comilla</option>--}}
{{--                                    <option value="Dhaka"  {{ ($hsc_tutor->education_board == 'Dhaka') ? 'selected' : ''  }}>Dhaka</option>--}}
{{--                                    <option value="Jessore"  {{ ($hsc_tutor->education_board == 'Jessore') ? 'selected' : ''  }}>Jessore</option>--}}
{{--                                    <option value="Mymensingh"  {{ ($hsc_tutor->education_board == 'Mymensingh') ? 'selected' : ''  }}>Mymensingh</option>--}}
{{--                                    <option value="Rajshahi"  {{ ($hsc_tutor->education_board == 'Rajshahi') ? 'selected' : ''  }}>Rajshahi</option>--}}
{{--                                    <option value="Sylhet"  {{ ($hsc_tutor->education_board == 'Sylhet') ? 'selected' : ''  }}>Sylhet</option>--}}
{{--                                    <option value="Dinajpur"  {{ ($hsc_tutor->education_board == 'Dinajpur') ? 'selected' : ''  }}>Dinajpur</option>--}}
{{--                                    <option value="Technical"  {{ ($hsc_tutor->education_board == 'Technical') ? 'selected' : ''  }}>Technical</option>--}}
{{--                                    <option value="Madrasah"  {{ ($hsc_tutor->education_board == 'Madrasah') ? 'selected' : ''  }}>Madrasah</option>--}}
{{--                                    <option value="Cambridge"  {{ ($hsc_tutor->education_board == 'Cambridge') ? 'selected' : ''  }}>Cambridge</option>--}}
{{--                                    <option value="Ed-excel"  {{ ($hsc_tutor->education_board == 'Ed-excel') ? 'selected' : ''  }}>Ed-excel</option>--}}
{{--                                    <option value="IB"  {{ ($hsc_tutor->education_board == 'IB') ? 'selected' : ''  }}>IB</option>--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Passing Year</label>
                                <select id="clgY" class="form-control select2" style="width: 100%;">
                                    <option value="">~ Choose Year ~</option>
{{--                                    <?php for($i = 1975; $i <= date('Y') ;$i++){ ?>--}}
{{--                                    <option value="{{$i}}" {{ ($hsc_tutor->passing_year == $i) ? 'selected' : ''  }}>{{ $i }}</option>--}}
{{--                                    <?php } ?>--}}
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4" >
                        <div class="form-check my-3 my-md-0">
                            <input type="checkbox" name="is_diploma_student" id="diplomaStudent" onchange="isDiplomaChanged()">
{{--                            <input class="form-check-input"  type="checkbox" id="diplomaStudent"  name="isDiploma"/>--}}
                            <label class="form-check-label" for="diplomaStudent">
                                I am a Diploma Student
                            </label>
                        </div>
                        <div class="d-flex gap-1">
                            <button  class="skip-btn px-3 py-0 mx-3 nextbtn" onclick="previous(2,1);">  Previous  </button>
                            <button class="next-btn px-4 nextbtn" onclick="next(2,3);" > Next </button>
                        </div>
                    </div>
                </div>
                <!-- tab 2 ends -->

                <!-- tab 3 starts -->
                <div class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-3">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">University Name</label>
                                <select id="guName" class="form-control select2_4" style="width: 100%;">
                                    <option value="">~ Select University ~ </option>
{{--                                    @foreach($universities as $university)--}}
{{--                                        <option value="{{ $university->id }}" {{ ($honours_tutor->institute_id == $university->id) ? 'selected' : ''  }}>{{ $university->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">University Type</label>
                                <select id="gUType" class="form-control select2" style="width: 100%;">
                                    <option value="">Select University Type</option>
{{--                                    <option value="National University"  {{ ($honours_tutor->university_type == 'National University') ? 'selected' : ''  }}>National University</option>--}}
{{--                                    <option value="Private University" {{ ($honours_tutor->university_type == 'Private University') ? 'selected' : ''  }}>Private University</option>--}}
{{--                                    <option value="Public University"  {{ ($honours_tutor->university_type == 'Public University') ? 'selected' : ''  }}>Public University</option>--}}
{{--                                    <option value="7 college"  {{ ($honours_tutor->university_type == '7 college') ? 'selected' : ''  }}>7 college</option>--}}
{{--                                    <option value="Public Medical" {{ ($honours_tutor->university_type == 'Public Medical') ? 'selected' : ''  }}>Public Medical</option>--}}
{{--                                    <option value="Private Medical" {{ ($honours_tutor->university_type == 'Private Medical') ? 'selected' : ''  }}>Private Medical</option>--}}
{{--                                    <option value="Mardasha"  {{ ($honours_tutor->university_type == 'Mardasha') ? 'selected' : ''  }}>Mardasha</option>--}}
{{--                                    <option value="Polytechnic Institute" {{ ($honours_tutor->university_type == 'Polytechnic Institute') ? 'selected' : ''  }}>Polytechnic Institute</option>--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">CGPA</label>
{{--                                <input type="number" class="form-control" value="{{ ($honours_tutor->gpa != null) ? $honours_tutor->gpa : ''  }}" id="gucgpa" name="cgpa" placeholder="enter C.G.P.A">--}}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Year</label>
                                <select id="guY" class="form-control select2" style="width: 100%;">
                                    <option value="">~ Choose Year ~</option>
{{--                                    <?php for($i = 1975; $i <= date('Y') ;$i++){ ?>--}}
{{--                                    <option value="{{$i}}" {{ ($honours_tutor->passing_year == $i) ? 'selected' : ''  }}>{{ $i }}</option>--}}
{{--                                    <?php } ?>--}}
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Department</label>
                                <select id="gudmt" class="form-control select2" style="width: 100%;">
                                    <option value="">~ Select Department ~ </option>
{{--                                    @foreach( $departments as $department )--}}
{{--                                        <option value="{{ $department->id }}" {{ ($honours_tutor->department_id == $department->id) ? 'selected' : ''  }}>{{ $department->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Study Type</label>
                                <select id="gust" class="form-control select2" style="width: 100%;">
                                    <option value=""> ~Select Study Type ~</option>
{{--                                    @foreach($studies as $study)--}}
{{--                                        <option value="{{ $study->id }}" {{ ($honours_tutor->study_type_id == $study->id) ? 'selected' : ''  }}>{{ $study->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between flex-column flex-md-row align-items-center mt-4">
                        <div class="form-check my-3 my-md-0">
                            <input type="checkbox" name="vehicle2" id="HscAlimStudent" value="1">
                            <label class="form-check-label" for="HscAlimStudent">
                                I'am Running HSC/A level/Alim Student
                            </label>

                        </div>
                        <div class="d-flex gap-1">
                            <button class="skip-btn px-3 py-0 mx-3 nextbtn" onclick="previous(3,2);"> Previous</button>
                            <button  class="next-btn px-4 nextbtn"  onclick="next(3,4);"> Next </button>
                        </div>
                    </div>
                </div>
                <!-- tab 3 ends -->
                <!-- tab 4 starts -->
                <div class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-4" >

                    <div class="row" id="postHidden">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">University Name</label>
                                <select id="puName" class="form-control select2_3" style="width: 100%;" required>
                                    <option value=""> ~ Select University name ~ </option>
{{--                                    @foreach($universities as $university)--}}
{{--                                        <option value="{{$university->id}}" {{ ($masters_tutor->institute_id == $university->id) ? 'selected' : ''  }}> {{ $university->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">University Type</label>
                                <select id="puType" class="form-control select2" style="width: 100%;" required>
                                    <option value="">Select University Type</option>
{{--                                    <option value="National University"  {{ ($masters_tutor->university_type == 'National University') ? 'selected' : ''  }}>National University</option>--}}
{{--                                    <option value="Private University" {{ ($masters_tutor->university_type == 'Private University') ? 'selected' : ''  }}>Private University</option>--}}
{{--                                    <option value="Public University"  {{ ($masters_tutor->university_type == 'Public University') ? 'selected' : ''  }}>Public University</option>--}}
{{--                                    <option value="7 college"  {{ ($masters_tutor->university_type == '7 college') ? 'selected' : ''  }}>7 college</option>--}}
{{--                                    <option value="Public Medical" {{ ($masters_tutor->university_type == 'Public Medical') ? 'selected' : ''  }}>Public Medical</option>--}}
{{--                                    <option value="Private Medical" {{ ($masters_tutor->university_type == 'Private Medical') ? 'selected' : ''  }}>Private Medical</option>--}}
{{--                                    <option value="Mardasha"  {{ ($masters_tutor->university_type == 'Mardasha') ? 'selected' : ''  }}>Mardasha</option>--}}
{{--                                    <option value="Polytechnic Institute" {{ ($masters_tutor->university_type == 'Polytechnic Institute') ? 'selected' : ''  }}>Polytechnic Institute</option>--}}
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">CGPA</label>
{{--                                <input type="number" id="puCgpa" required class="form-control" value="{{ ($masters_tutor->gpa != null) ? $masters_tutor->gpa : ''  }}" name="cgpa" placeholder="Enter C.G.P.A">--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select id="puDept" class="form-control select2" style="width: 100%;" required>
                                    <option value="">~ Select Department ~ </option>
{{--                                    @foreach( $departments as $department )--}}
{{--                                        <option value="{{ $department->id }}" {{ ($masters_tutor->department_id == $department->id) ? 'selected' : ''  }}>{{ $department->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Study Type</label>
                                <select id="puStudy" class="form-control select2" style="width: 100%;" required>
                                    <option value=""> ~Select Study Type ~</option>
{{--                                    @foreach($studies as $study)--}}
{{--                                        <option value="{{ $study->id }}"  {{ ($masters_tutor->study_type_id == $study->id) ? 'selected' : ''  }}>{{ $study->title }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Year</label>
                                <select id="puYear" class="form-control select2"  style="width: 100%;" required>
                                    <option value="">~ Choose Year ~</option>
{{--                                    <?php for($i = 1975; $i <= date('Y') ;$i++){ ?>--}}
{{--                                    <option value="{{$i}}" {{ ($masters_tutor->passing_year == $i) ? 'selected' : ''  }}>{{ $i }}</option>--}}
{{--                                    <?php } ?>--}}
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-lg-6"></div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4" >
                        <div class="form-check my-3 my-md-0">
                            <input type="checkbox"  name="isnotApplicable" id="GraduationApplicable">
                            <label class="form-check-label" for="GraduationApplicable">
                                If Not Applicable
                            </label>
{{--                            <input  class="form-check-input"  type="checkbox"  id="GraduationApplicable"  name="isnotApplicable"/>--}}
{{--                            <label class="form-check-label" for="GraduationApplicable">   </label>--}}
                        </div>
                        <div class="d-flex gap-1">
                            <button class="skip-btn px-3 py-0 mx-3 nextbtn" onclick="previous(4,3);" >Previous </button>
                            <button class="next-btn px-4 nextbtn" id="saveEducationBtn">Save</button>
                        </div>
                    </div>
                </div>
                <!-- tab 4 ends -->
                </form>
            </div>
        </div>
    </div>

    <!-- conent section ends -->
    <!-- conent section ends -->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{------------------------------------ tutoring info save  ----------------------------------------}}
    {{------------------------------------ tutoring info save End ----------------------------------------}}
    <script>

        ////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////// Education Data Save Here ///////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////

        $(document).ready(function (){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveEducationBtn').on('click',function (){
               var sName = $('#sName').val();
               var scur = $('#scur').val();
               var sgpa = $('#sgpa').val();
               var sgroup = $('#sgroup').val();
               var sBoard = $('#sBoard').val();
               var sYear = $('#sYear').val();
               var selectcollege = $('#selectcollege').val();
               var selectCurriculam = $('#selectCurriculam').val();
               var clgGpa = $('#clgGpa').val();
               var clgG = $('#clgG').val();
               var clgB = $('#clgB').val();
               var clgY = $('#clgY').val();
               var guName = $('#guName').val();
               var gUType = $('#gUType').val();
               var gucgpa = $('#gucgpa').val();
               var gudmt = $('#gudmt').val();
               var gust = $('#gust').val();
               var guY = $('#guY').val();
               var puName = $('#puName').val();
               var puType = $('#puType').val();
               var puCgpa = $('#puCgpa').val();
               var puDept = $('#puDept').val();
               var puStudy = $('#puStudy').val();
               var puYear = $('#puYear').val();

                $.ajax({
                    url:"{{ route('tutor.tutoreducation_info.save') }}",
                    type:"post",
                    data: {
                        sName:sName, scur:scur,  sgpa:sgpa,  sgroup:sgroup,  sBoard:sBoard, sYear:sYear, selectcollege:selectcollege,
                        selectCurriculam:selectCurriculam, clgGpa:clgGpa, clgG:clgG,  clgB:clgB, clgY:clgY, guName:guName, gUType:gUType,
                        gucgpa:gucgpa, gudmt:gudmt, gust:gust,  guY:guY,  puName:puName,  puType:puType,  puCgpa:puCgpa,  puDept:puDept,
                        puStudy:puStudy, puYear:puYear,
                    },
                    success:function (data){
                        console.log(data);
                        location.reload();
                        var myToast = toastr.success("Education Info Update Successfully!",  {timeOut:1000});
                        $('#success').innerHTML= myToast;

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
        });



        ////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////// Education Data Save End  Here //////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////


        ////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////// display tab option js //////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////

        $(".tab").css("display", "none");
        $("#tab-1").css("display", "block");

        function next(hideTab, showTab) {
            if (hideTab < showTab) { // If not press previous button
                // Validation if press next button

                var currentTab = 0;
                x = $('#tab-' + hideTab);
                y = $(x).find('select');
                for (i = 0; i < y.length; i++) {
                    // if (y[i].value == '') {
                    //
                    //     toastr.error('filap this field');
                    //     toastr.options.timeOut = 500;
                    //     // $(y[i]).css("background", "#ffdddd");
                    //     return false;
                    // }
                }
                for (i = 1; i < showTab; i++) {
                    $("#step-" + i).removeClass("gray-line-var");
                    $("#step-" + i).addClass("green-line-var");

                }
                // Switch tab
                $("#tab-" + hideTab).css("display", "none");
                $("#tab-" + showTab).css("display", "block");
                $("input").css("background", "#fff");
            }
        }


        function previous(pre,next)
        {
            if(pre > next)
            {
                $("#tab-" + pre).css("display", "none");
                $("#tab-" + next).css("display", "block");

            }


        }

        ////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////// display tab option js End Here//////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////


        //....................................................................................
        //......................... new schoole add ...........................................
        //.....................................................................................

        function otherClicked(obj,num){
            var el=$($(".ins_"+num)[0]);
            el.html(`
          <label>Institute</label>
          <input required type="text" name="school" placeholder="Please Enter the University Name"  class="form-control">
          `);
            $(obj).closest(".select2-container").remove();
        }

        function schSelect2(num){
            $('.select2_'+num).select2({
                language: {
                    noResults: function(){
                        return `
                <button class="btn btn-secondary" onclick="otherClicked(this,`+num+`)">Others</a>
                `;
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });
        }
        $(function(){
            //Initialize Select2 Elements
            $('.select2').select2();
            var arr=[6,5,4,3];
            for(var n of arr){
                schSelect2(n);
            }

            //Initialize Select2 Elements
        });

        //....................................................................................
        //......................... new schoole add End here...................................
        //.....................................................................................


        //.....................................................................................
        // ...................check button disabled start here................................
        //....................................................................................

        function isDiplomaChanged(){
            if(document.getElementById('diplomaStudent').checked==false){
                $("#hidden").html(hsc_html);
                $(".selectcollege").select2();
                $(".selectCurriculam").select2();
                $(".clgY").select2();
                $(".clgB").select2();
                schSelect2(n);
            }else{
                $("#hidden").empty();
            }
        }

        $(function(){

            masters_html=$("#masters").html();
            hsc_html=$("#hidden").html();
            var arr=[6,5,4,3];
            for(var n of arr){
                schSelect2(n);
            }
            hasMasterChanged();
            isDiplomaChanged();


        });
        $(document).ready(function () {



            // $('#diplomaStudent').on('click',function (){
            //
            //     var hsc_html =$("#hidden").html();
            //
            //     // $('input[type="checkbox"]').click(function(){});
            //         if($('input[type="checkbox"]').prop("checked") == true){
            //
            //             $('#hidden').css("display", "none");
            //            $("#hidden").empty();
            //
            //
            //             // $('#selectcollege').prop( "disabled", true );
            //             // $('#selectCurriculam').prop( "disabled", true );
            //             // $('#clgGpa').prop( "disabled", true );
            //             // $('#clgG').prop( "disabled", true );
            //             // $('#clgB').prop( "disabled", true );
            //             // $('#clgY').prop( "disabled", true );
            //         }
            //         else if($('input[type="checkbox"]').prop("checked") == false){
            //             $('#hidden').css("display", "flex");
            //             $('#hidden').html(hsc_html);
            //
            //             console.log(hsc_html)
            //
            //             // $('#selectcollege').prop( "disabled", false );
            //             // $('#selectCurriculam').prop( "disabled", false );
            //             // $('#clgGpa').prop( "disabled", false );
            //             // $('#clgG').prop( "disabled", false );
            //             // $('#clgB').prop( "disabled", false );
            //             // $('#clgY').prop( "disabled", false );
            //         }
            //
            //
            // });
            $('#GraduationApplicable').on('click',function (){
                postHidden
                // $().click(function(){ });
                if($('input[name="isnotApplicable"]').prop("checked") == true){

                    $('#postHidden').css("display", "none");

                    // $('#puName').prop( "disabled", true );
                    // $('#puType').prop( "disabled", true );
                    // $('#puCgpa').prop( "disabled", true );
                    // $('#puDept').prop( "disabled", true );
                    // $('#puStudy').prop( "disabled", true );
                    // $('#puYear').prop( "disabled", true );
                }
                else if($('input[name="isnotApplicable"]').prop("checked") == false){

                    $('#postHidden').css("display", "flex");
                    // $('#puName').prop( "disabled", false );
                    // $('#puType').prop( "disabled", false );
                    // $('#puCgpa').prop( "disabled", false );
                    // $('#puDept').prop( "disabled", false );
                    // $('#puStudy').prop( "disabled", false );
                    // $('#puYear').prop( "disabled", false );
                }

            });

        });

        //.....................................................................................
        // ...................check button disabled End here................................
        //....................................................................................


        $("#clgB").select2({
            width: "100%",
        });
        $("#clgY").select2({
            width: "100%",
        });


        $("#single11").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single12").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });

    </script>
@endpush
