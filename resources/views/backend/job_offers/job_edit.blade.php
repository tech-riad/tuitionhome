@extends('layouts.app')

@push('page_css')

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #11ee24;
        color: black;
    }

</style>

@endpush


@section('content')
<div class="container-fluid">
    <div class="row">

        <main class="container-custom">
            <div class="col-md-12 ms-sm-auto col-lg-12">
                <!-- main content section starts here -->
                <div class="ps-3 py-3 py-lg-4">
                    <div class="row row-cols-lg-2 row-cols-1">

                        <div>

                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4">
                                <p class="mb-4 fw-semibold fs-5">Student Information-1</p>

                                <form action="{{route('admin.job.update')}}" method="post" id="updateJobOffer">
                                    @csrf

                                    <input type="hidden" name="job_id" id="job_id" value="{{$job->id}}">

                                    <input type="hidden" name="reference_id" id="reference_id">

                                    <input type="hidden" name="parent_id" id="parent_id" value="{{$job->parent_id}}">
                                    <div class="">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input name="student_name" type="text"
                                                value="{{ old('student_name', $job->student_name) }}"
                                                class="form-control rounded-3 shadow-none" id="student_name"
                                                placeholder="Enter name" style="padding: 14px 18px" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label required">Gender</label>
                                            <select name="student_gender" class="form-select rounded-3 shadow-none"
                                                aria-label="Default select " id="student_gender"
                                                style="padding: 14px 18px">
                                                <option value="">Select Gender</option>
                                                <option value="male"
                                                    {{ $job->student_gender === 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female"
                                                    {{ $job->student_gender === 'female' ? 'selected' : '' }}>Female
                                                </option>
                                                <option value="3rd Gender"
                                                    {{ $job->student_gender === '3rd Gender' ? 'selected' : '' }}>3rd
                                                    Gender</option>
                                            </select>
                                            <span class="text-danger error-text student_gender_error"></span>
                                        </div>



                                        <div class="mb-3">
                                            <label for="institute" class="form-label">Name of Institute</label>
                                            <input name="institute_name"
                                                value="{{ old('institute_name', $job->institute_name) }}" type="text"
                                                class="form-control rounded-3 shadow-none" id="institute_name"
                                                placeholder="Institute Name" style="padding: 14px 18px" />
                                            <span class="text-danger error-text institute_name_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label required">Category</label>
                                            <select name="category_id" id="category_id"
                                                class="form-select rounded-3 shadow-none" style="padding: 14px 18px">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)

                                                <option value="{{$category->id}}"
                                                    {{$job->category_id == $category->id ? 'selected' : '' }}>
                                                    {{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text category_id_error"></span>
                                        </div>


                                        <div class="mb-3">
                                            <label for="course_id" class="form-label required">Course</label>
                                            <select name="course_id" class="form-select rounded-3 shadow-none"
                                                id="course_id" style="padding: 14px 18px">

                                                <option value="">Select course</option>
                                                @foreach ($courses->where('category_id', $job->category_id) as $course)
                                                <option value="{{$course->id}}"
                                                    {{$job->course_id == $course->id ? 'selected' : '' }}>
                                                    {{$course->name}}</option>
                                                @endforeach


                                            </select>
                                            <span class="text-danger error-text course_id_error"></span>

                                        </div>
                                        <div class="mb-3">
                                            <label for="subject_id" class="form-label required">Subjects</label>

                                            @php
                                            $ocs=$job->job_offer_student_subjects;
                                            @endphp

                                            <select name="subject_id[]" class="form-select rounded-3 shadow-none"
                                                id="subject_id" style="padding: 14px 18px" multiple>

                                                @if ($job->course_id!=null)
                                                @foreach ($courseSubjects->where('course_id', $job->course_id) as $cs)
                                                @php
                                                $isSelected="";
                                                foreach ($ocs as $ocss) {
                                                if($ocss->id==$cs->id){
                                                $isSelected="selected";
                                                break;
                                                }
                                                }
                                                @endphp
                                                <option value="{{$cs->id}}" {{$isSelected}}>
                                                    {{$cs->subject->title ?? 'N/A'}}</option>
                                                @endforeach
                                                @endif


                                            </select>
                                            <span class="text-danger error-text subject_id_error"></span>

                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-4">

                                            <button type="button" class="btn btn-primary py-1 px-2"
                                                data-bs-toggle="modal" data-bs-target="#additionalChildModal">Add New
                                                >
                                            </button>
                                            {{-- <button class="btn btn-primary py-1 px-2">Save</button> --}}
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4">
                                <p class="mb-4 fw-semibold fs-5">Student Information-2</p>

                                <div class="">
                                    <div class="mb-3">
                                        <label for="day" class="form-label required">Days In Week</label>
                                        <select name="days_in_week" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="days_in_week" style="padding: 14px 18px">
                                            <option value="">Select Days</option>
                                            <option value="1" {{ $job->days_in_week === 1 ? 'selected' : '' }}>1 Days
                                            </option>
                                            <option value="2" {{ $job->days_in_week === 2 ? 'selected' : '' }}>2 Days
                                            </option>
                                            <option value="3" {{ $job->days_in_week === 3 ? 'selected' : '' }}>3 Days
                                            </option>
                                            <option value="4" {{ $job->days_in_week === 4 ? 'selected' : '' }}>4 Days
                                            </option>
                                            <option value="5" {{ $job->days_in_week === 5 ? 'selected' : '' }}>5 Days
                                            </option>
                                            <option value="6" {{ $job->days_in_week === 6 ? 'selected' : '' }}>6 Days
                                            </option>
                                            <option value="7" {{ $job->days_in_week === 7 ? 'selected' : '' }}>7 Days
                                            </option>
                                        </select>
                                        <span class="text-danger error-text days_in_week_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label required">Tutoring Time</label>
                                        <input value="{{ old('tutoring_time', $job->tutoring_time) }}"
                                            name="tutoring_time" type="time" class="form-control rounded-3 shadow-none"
                                            id="tutoring_time" placeholder="Bangla" style="padding: 14px 18px" />
                                        <span class="text-danger error-text tutoring_time_error"></span>


                                    </div>
                                    <div class="mb-3">
                                        <label for="due" class="form-label required">Tutoring Duration</label>
                                        <select name="tutoring_duration" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="tutoring_duration"
                                            style="padding: 14px 18px">
                                            <option value="">Select Duration</option>
                                            <option value="1" {{ $job->tutoring_duration === '1' ? 'selected' : '' }}>1
                                                hour</option>
                                            <option value="1.5"
                                                {{ $job->tutoring_duration === '1.5' ? 'selected' : '' }}>1.5 hour
                                            </option>
                                            <option value="2" {{ $job->tutoring_duration === '2' ? 'selected' : '' }}>2
                                                hour</option>
                                            <option value="2.5"
                                                {{ $job->tutoring_duration === '2.5' ? 'selected' : '' }}>2.5 hour
                                            </option>
                                            <option value="3" {{ $job->tutoring_duration === '3' ? 'selected' : '' }}>3
                                                hour</option>
                                            <option value="4" {{ $job->tutoring_duration === '4' ? 'selected' : '' }}>4
                                                hour</option>
                                            <option value="5" {{ $job->tutoring_duration === '5' ? 'selected' : '' }}>5
                                                hour</option>
                                            <option value="6" {{ $job->tutoring_duration === '6' ? 'selected' : '' }}>6
                                                hour</option>
                                            <option value="7" {{ $job->tutoring_duration === '7' ? 'selected' : '' }}>7
                                                hour</option>
                                            <option value="8" {{ $job->tutoring_duration === '8' ? 'selected' : '' }}>8
                                                hour</option>
                                            <option value="9" {{ $job->tutoring_duration === '9' ? 'selected' : '' }}>9
                                                hour</option>
                                            <option value="10" {{ $job->tutoring_duration === '10' ? 'selected' : '' }}>10
                                                hour</option>
                                        </select>
                                        <span class="text-danger error-text tutoring_duration_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label required">Teaching Method</label>
                                        <select name="teaching_method_id" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " teaching_methods id="teaching_method_id"
                                            style="padding: 14px 18px">
                                            <option value="">Select Method</option>
                                            @foreach ($teaching_methods as $teaching_method)
                                            <option value="{{$teaching_method->id}}"
                                                {{$job->teaching_method_id == $teaching_method->id ? 'selected' : '' }}>
                                                {{$teaching_method->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text teaching_method_id_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="salary" class="form-label required">Maximum Salary</label>
                                        <input value="{{ old('salary', $job->salary) }}" name="salary" type="number"
                                            class="form-control rounded-3 shadow-none" id="salary" placeholder=""
                                            style="padding: 14px 18px" />
                                        <span class="text-danger error-text salary_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="snum" class="form-label required">Number Of Students</label>
                                        <input value="{{ old('number_of_students', $job->number_of_students) }}"
                                            name="number_of_students" type="text"
                                            class="form-control rounded-3 shadow-none" id="number_of_students"
                                            style="padding: 14px 18px" />

                                        <span class="text-danger error-text number_of_students_error"></span>

                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        {{-- <button class="btn btn-primary py-1 px-2">Save</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{--  --}}



                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 776px">
                                <p class="mb-4 fw-semibold fs-5">Location</p>

                                <div class="">
                                    <div class="mb-3">
                                        <label for="cun" class="form-label required">Country</label>
                                        <select name="country_id" class="form-select rounded-3 shadow-none "
                                            aria-label="Default select " id="country_id" style="padding: 14px 18px">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{$country->id}}"
                                                {{$job->country_id == $country->id ? 'selected' : '' }}>
                                                {{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text country_id_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="city" class="form-label required">City</label>
                                        <select name="city_id" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="city_id" style="padding: 14px 18px">

                                            <option value="">Select city</option>
                                            {{-- @foreach ($cities as $city)
                                            <option value="{{$city->id}}"
                                                {{$job->city_id == $city->id ? 'selected' : '' }}>{{$city->name}}
                                            </option>
                                            @endforeach --}}

                                        </select>
                                        <span class="text-danger error-text city_id_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="loc" class="form-label required">Location</label>
                                        <select name="location_id" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="location_id" style="padding: 14px 18px">

                                            <option value="">Select location</option>
                                            {{-- @foreach ($locations as $location)
                                            <option value="{{$location->id}}"
                                                {{$job->location_id == $location->id ? 'selected' : '' }}>
                                                {{$location->name}}</option>
                                            @endforeach --}}


                                        </select>
                                        <span class="text-danger error-text location_id_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="lat" class="form-label required">lattitude </label>
                                        <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                                            style="border: 1px solid #1890ff">
                                            <i class="bi bi-geo-alt-fill text-info ms-1"></i>
                                            <input name="lat" id="lat"
                                                value="{{ old('lat', $job->lat) }}" type="text"
                                                class="form-control shadow-none rounded-3 border-0"
                                                placeholder="23.799290, 90.357990" style="padding: 12px 18px"
                                                id="lat" />


                                        </div>
                                        <span class="text-danger error-text lat_error"></span>


                                    </div>
                                    <div class="mb-3">
                                        <label for="long" class="form-label required">
                                            Longitude</label>
                                        <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                                            style="border: 1px solid #1890ff">
                                            <i class="bi bi-geo-alt-fill text-info ms-1"></i>
                                            <input name="long" id="long"
                                                value="{{ old('long', $job->long) }}" type="text"
                                                class="form-control shadow-none rounded-3 border-0"
                                                placeholder="23.799290, 90.357990" style="padding: 12px 18px"
                                                id="long" />


                                        </div>
                                        <span class="text-danger error-text long_error"></span>


                                    </div>
                                    <div class="mb-3">
                                        <label for="add" class="form-label required">Details Address</label>
                                        <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                                            style="border: 1px solid #1890ff">
                                            <i class="bi bi-geo-alt-fill text-info ms-1"></i>
                                            <input value="{{ old('full_address', $job->full_address) }}"
                                                name="full_address" type="text"
                                                class="form-control shadow-none rounded-3 border-0"
                                                placeholder="10/5, Tolarbag, Mirpur-1" style="padding: 12px 18px"
                                                id="full_address" />


                                        </div>
                                        <span class="text-danger error-text full_address_error"></span>


                                    </div>
                                    <!-- Map placeholder -->
                                    <!--<div>-->
                                    <!--    <div style="height: 280px; width: 100%;">-->
                                    <!--        <iframe-->
                                    <!--            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d542.6941077899864!2d90.35233082275596!3d23.790269192747317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c0aee7ab5fdd%3A0x575f61e9d0562027!2sTuition%20Terminal!5e0!3m2!1sen!2sbd!4v1703307203505!5m2!1sen!2sbd"-->
                                    <!--            width="100%" height="100%" style="border:1px solid #fafafa;"-->
                                    <!--            allowfullscreen="" loading="lazy"-->
                                    <!--            referrerpolicy="no-referrer-when-downgrade"></iframe>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        {{-- <button class="btn btn-primary py-1 px-2">Save</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 776px">
                                <p class="mb-4 fw-semibold fs-5">Title Note</p>

                                <div class="">
                                    <div class="mb-3">
                                        <label for="requ" class="form-label required">Tutor Requirement</label>
                                        <textarea required name="tutor_requirement" id="tutor_requirement"
                                            class="form-control rounded-3 shadow-none" style="
                                                    overflow-y: scroll;
                                                    resize: none;
                                                    height: 165px;
                                                ">

                                                {{ old('tutor_requirement', $job->tutor_requirement) }}

                                                </textarea>
                                        <span class="text-danger error-text tutor_requirement_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="spn" class="form-label">Special Note</label>
                                        <textarea name="special_note" class="form-control rounded-3 shadow-none"
                                            id="special_note" style="
                                        overflow-y: scroll;
                                        resize: none;
                                        height: 165px;
                                    ">
                                    {{ old('special_note', $job->special_note) }}
                                    </textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="staff" class="form-label required">Staff Note</label>
                                        <textarea name="staff_note" class="form-control rounded-3 shadow-none"
                                            id="staff_note" style="
                                overflow-y: scroll;
                                resize: none;
                                height: 165px;
                            ">
                            {{ old('staff_note', $job->staff_note) }}
                            </textarea>
                                        <span class="text-danger error-text staff_note_error"></span>

                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        {{-- <button class="btn btn-primary py-1 px-2">Save</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4">
                                <p class="mb-4 fw-semibold fs-5">Tutor Requirement-1</p>

                                <div class="">
                                    <div class="mb-3">
                                        <label for="cat" class="form-label">Preferred Tutoring Category</label>
                                        <select name="tutoring_category_id[]"
                                            class="form-select rounded-3 shadow-none select2" multiple
                                            aria-label="Default select " id="tutoring_category_id"
                                            style="padding: 14px 18px">
                                            <option value="">Select Category</option>

                                            @php
                                            $otc=$job->job_offer_tutor_categories;
                                            @endphp

                                            @if ($otc!=null)
                                            @foreach ($categories as $category)
                                            @php
                                            $isSelected="";
                                            foreach ($otc as $oc) {
                                            if($oc->id==$category->id){
                                            $isSelected="selected";
                                            break;
                                            }
                                            }
                                            @endphp
                                            <option value="{{$category->id}}" {{$isSelected}}>{{$category->name}}
                                            </option>
                                            @endforeach
                                            @endif

                                                                    {{-- @foreach($job->job_offer_tutor_categories as $pcategory)
                                                <option value="{{$pcategory->id}}"selected >{{$pcategory->name}}</option>
                                                                    @endforeach --}}
                                                                    {{-- @foreach($job->job_offer_tutor_categories as $pcategory)

                                            @foreach ($categories as $category)

                                            <option value="{{$category->id}}"{{$pcategory->id == $category->id ? 'selected' : '' }}>{{$category->name}}
                                                                </option>
                                                                @endforeach --}}
                                                                {{-- @php break; @endphp --}}
                                                                {{-- @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course" class="form-label">Course </label>
                                        <select name="tutor_course_id[]"
                                            class="form-select rounded-3 shadow-none select2" multiple
                                            aria-label="Default select " id="tutor_course_id"
                                            style="padding: 14px 18px">

                                            @php
                                            $otcourse=$job->job_offer_tutor_courses;
                                            @endphp

                                            @if ($otcourse!=null)
                                            @foreach ($courses as $course)
                                            @php
                                            $isSelected="";
                                            foreach ($otcourse as $otc) {
                                            if($otc->id==$course->id){
                                            $isSelected="selected";
                                            break;
                                            }
                                            }
                                            @endphp
                                            <option value="{{$course->id}}" {{$isSelected}}>{{$course->name}}</option>
                                            @endforeach
                                            @endif



                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label for="sub" class="form-label">Subjects</label>
                                        <select name="tutor_subject_id[]"
                                            class="form-select rounded-3 shadow-none select2" multiple
                                            id="tutor_subject_id" placeholder="Maths" style="padding: 14px 18px">

                                            @php
                                            $otsubject=$job->job_offer_tutor_subjects;

                                            $ar =[];
                                            foreach($job->job_offer_tutor_subjects as $course){

                                            $ar[] = $course->course_id;
                                            }

                                            @endphp

                                            @if ($otsubject!=null)
                                            @foreach ($courseSubjects->whereIn('course_id', $ar) as $cs)
                                            @php
                                            $isSelectedd="";
                                            foreach ($otsubject as $otcs) {
                                            if($otcs->id==$cs->id){
                                            $isSelectedd="selected";
                                            break;
                                            }
                                            }
                                            @endphp
                                            <option value="{{$cs->id}}" {{$isSelectedd}}>
                                                {{$cs->subject->title ?? 'N/A'}}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label for="due" class="form-label required">Tutor's Gender</label>
                                        <select name="tutor_gender" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="tutor_gender" style="padding: 14px 18px">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ $job->tutor_gender === 'male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="female"
                                                {{ $job->tutor_gender === 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="any" {{ $job->tutor_gender === 'any' ? 'selected' : '' }}>Any
                                            </option>
                                        </select>
                                        <span class="text-danger error-text tutor_gender_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="due" class="form-label">Tutor's Religion
                                        </label>
                                        <select name="tutor_religion" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="tutor_religion" style="padding: 14px 18px">
                                            <option value="">Select Religion</option>
                                            <option value="islam"
                                                {{ $job->tutor_religion     === 'islam' ? 'selected' : '' }}>Islam
                                            </option>
                                            <option value="hinduism"
                                                {{ $job->tutor_religion     === 'hinduism' ? 'selected' : '' }}>Hinduism
                                            </option>
                                            <option value="christianity"
                                                {{ $job->tutor_religion     === 'christianity' ? 'selected' : '' }}>
                                                Christianity</option>
                                            <option value="buddhism"
                                                {{ $job->tutor_religion     === 'buddhism' ? 'selected' : '' }}>Buddhism
                                            </option>
                                            <option value="other"
                                                {{ $job->tutor_religion     === 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        <span class="text-danger error-text tutor_religion_error"></span>

                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        {{-- <button class="btn btn-primary py-1 px-2">Save</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4">
                                <p class="mb-4 fw-semibold fs-5">Tutor Requirement-2</p>
                                <div class="">
                                    <div class="mb-3">
                                        <label for="uni" class="form-label">University</label>
                                        <select name="tutor_university_id[]" id="tutor_university_id"
                                            class="form-control select2" multiple>
                                            <option value="">Select University</option>

                                            @foreach($job->job_offer_tutor_universities as $p_university)
                                            <option value="{{$p_university->id}}" selected>{{$p_university->title}}
                                            </option>
                                            @endforeach

                                            @foreach ($institutes->where('type', "university") as $institute)
                                            <option value="{{$institute->id}}">{{$institute->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('tutor_university_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="utype" class="form-label">University Type</label>
                                        <select name="tutor_university_type"
                                            class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select " id="tutor_university_type"
                                            style="padding: 14px 18px">

                                            <option value="">Select University Type</option>
                                            <option value="National University"
                                                {{ $job->tutor_university_type === 'National University' ? 'selected' : '' }}>
                                                National University</option>
                                            <option value="Private University"
                                                {{ $job->tutor_university_type === 'Private University' ? 'selected' : '' }}>
                                                Private University</option>
                                            <option value="Public University"
                                                {{ $job->tutor_university_type === 'Public University' ? 'selected' : '' }}>
                                                Public University</option>
                                            <option value="7 college"
                                                {{ $job->tutor_university_type === '7 college' ? 'selected' : '' }}>7
                                                college</option>
                                            <option value="Public Medical"
                                                {{ $job->tutor_university_type === 'Public Medical' ? 'selected' : '' }}>
                                                Public Medical</option>
                                            <option value="Private Medical"
                                                {{ $job->tutor_university_type === 'Private Medical' ? 'selected' : '' }}>
                                                Private Medical</option>
                                            <option value="Mardasha"
                                                {{ $job->tutor_university_type === 'Mardasha' ? 'selected' : '' }}>
                                                Mardasha</option>
                                            <option value="Polytechnic Institute"
                                                {{ $job->tutor_university_type === 'Polytechnic Institute' ? 'selected' : '' }}>
                                                Polytechnic Institute</option>
                                            <option value="Other"
                                                {{ $job->tutor_university_type === 'Other' ? 'selected' : '' }}>
                                                Other</option>

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stype" class="form-label">Study Type
                                        </label>
                                        <select name="tutor_study_type_id[]"
                                            class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select " multiple id="tutor_study_type_id"
                                            style="padding: 14px 18px">
                                            <option value="">Select Study</option>

                                            @foreach ($job->job_offer_tutor_study_types as $p_study)
                                            <option value="{{$p_study->id}}" selected>{{$p_study->title ?? 'N/A'}}
                                            </option>
                                            @endforeach
                                            @foreach ($studies as $study)
                                            <option value="{{$study->id}}">{{$study->title}}</option>
                                            @endforeach
                                        </select>

                                        @error('tutor_study_type_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="mb-3">
                                        <label for="due" class="form-label">Departments</label>
                                        <select name="tutor_department_id[]"
                                            class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select " multiple id="tutor_department_id"
                                            style="padding: 14px 18px">
                                            <option value="">Select Department</option>

                                            @foreach ($job->job_offer_tutor_departments as $p_department)
                                            <option value="{{$p_department->id}}" selected>{{$p_department->title}}
                                            </option>
                                            @endforeach
                                            @foreach ($departments as $department)
                                            <option value="{{$department->id}}">{{$department->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year </label>
                                        <select name="year" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="year" style="padding: 14px 18px">
                                            <option value="">Select Year</option>
                                            <option value="first year"
                                                {{ $job->year === 'first year' ? 'selected' : '' }}>First Year</option>
                                            <option value="second year"
                                                {{ $job->year === 'second year' ? 'selected' : '' }}>Second Year
                                            </option>
                                            <option value="third year"
                                                {{ $job->year === 'third year' ? 'selected' : '' }}>Third Year</option>
                                            <option value="fourth year"
                                                {{ $job->year === 'fourth year' ? 'selected' : '' }}>Fourth Year
                                            </option>
                                            <option value="graduation completed"
                                                {{ $job->year === 'graduation completed' ? 'selected' : '' }}>Graduation
                                                Completed</option>
                                            <option value="post graduation running"
                                                {{ $job->year === 'post graduation running' ? 'selected' : '' }}>Post
                                                Graduation Running</option>
                                            <option value="post graduation completed"
                                                {{ $job->year === 'post graduation completed' ? 'selected' : '' }}>Post
                                                Graduation Completed</option>


                                        </select>

                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 635px">
                                <p class="mb-4 fw-semibold fs-5">Tutor Requirement-3</p>

                                <div class="">
                                    <div class="mb-3">
                                        <label for="scl" class="form-label">School</label>
                                        <select name="tutor_school_id" class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select " id="tutor_school_id"
                                            style="padding: 14px 18px">
                                            <option value="">Select School</option>
                                            @foreach ($institutes->whereIn('type', ['school', 'school and college']) as $institute)
                                                <option value="{{ $institute->id }}"
                                                    {{ $job->tutor_school_id == $institute->id ? 'selected' : '' }}>
                                                    {{ $institute->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tutor_school_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="clg" class="form-label">College </label>
                                        <select name="tutor_college_id"
                                            class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select " id="tutor_college_id"
                                            style="padding: 14px 18px">
                                            <option value="">Select College</option>
                                            @foreach ($institutes->whereIn('type', ['college', 'school and college']) as $institute)
                                            <option value="{{$institute->id}}"
                                                {{$job->tutor_college_id == $institute->id ? 'selected' : '' }}>
                                                {{$institute->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('tutor_college_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="board" class="form-label">Board</label>
                                        <select name="tutor_board" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="tutor_board" style="padding: 14px 18px">
                                            <option value="">Select Board</option>
                                            <option value="dhaka" {{ $job->tutor_board === 'dhaka' ? 'selected' : '' }}>
                                                Dhaka</option>
                                            <option value="rajshahi"
                                                {{ $job->tutor_board === 'rajshahi' ? 'selected' : '' }}>Rajshahi
                                            </option>
                                            <option value="comilla"
                                                {{ $job->tutor_board === 'comilla' ? 'selected' : '' }}>Comilla</option>
                                            <option value="jessore"
                                                {{ $job->tutor_board === 'jessore' ? 'selected' : '' }}>Jessore</option>
                                            <option value="chittagong"
                                                {{ $job->tutor_board === 'chittagong' ? 'selected' : '' }}>Chittagong
                                            </option>
                                            <option value="barisal"
                                                {{ $job->tutor_board === 'barisal' ? 'selected' : '' }}>Barisal</option>
                                            <option value="sylhet"
                                                {{ $job->tutor_board === 'sylhet' ? 'selected' : '' }}>Sylhet</option>
                                            <option value="dinajpur"
                                                {{ $job->tutor_board === 'dinajpur' ? 'selected' : '' }}>Dinajpur
                                            </option>
                                            <option value="mymensingh"
                                                {{ $job->tutor_board === 'mymensingh' ? 'selected' : '' }}>Mymensingh
                                            </option>
                                            <option value="cambridge"
                                                {{ $job->tutor_board === 'cambridge' ? 'selected' : '' }}>Cambridge
                                            </option>
                                            <option value="technical"
                                                {{ $job->tutor_board === 'technical' ? 'selected' : '' }}>Technical
                                            </option>
                                            <option value="ed-excel"
                                                {{ $job->tutor_board === 'ed-excel' ? 'selected' : '' }}>Ed-excel
                                            </option>
                                            <option value="ib" {{ $job->tutor_board === 'ib' ? 'selected' : '' }}>Ib
                                            </option>
                                            <option value="canadian"
                                                {{ $job->tutor_board === 'canadian' ? 'selected' : '' }}>Canadian
                                            </option>
                                            <option value="singapore"
                                                {{ $job->tutor_board === 'singapore' ? 'selected' : '' }}>Singapore
                                            </option>
                                            <option value="madrasah"
                                                {{ $job->tutor_board === 'madrasah' ? 'selected' : '' }}>Madrasah
                                            </option>
                                            <option value="other" {{ $job->tutor_board === 'other' ? 'selected' : '' }}>
                                                Other
                                            </option>


                                        </select>
                                        @error('tutor_board')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="group" class="form-label">Group </label>
                                        <select name="tutor_group" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="tutor_group" style="padding: 14px 18px">
                                            <option value="">Select Group</option>
                                            <option value="Science"
                                                {{ $job->tutor_group === 'Science' ? 'selected' : '' }}>Science</option>
                                            <option value="Commerce"
                                                {{ $job->tutor_group === 'Commerce' ? 'selected' : '' }}>Commerce
                                            </option>
                                            <option value="Arts" {{ $job->tutor_group === 'Arts' ? 'selected' : '' }}>
                                                Arts</option>

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bc" class="form-label">Background Curriculum
                                        </label>
                                        <select name="tutor_curriculam_id" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="tutor_curriculam_id"
                                            style="padding: 14px 18px">
                                            <option value="">Select Curriculum</option>
                                            @foreach ($curriculams as $curriculam)
                                            <option value="{{$curriculam->id}}"
                                                {{$job->tutor_curriculam_id == $curriculam->id ? 'selected' : '' }}>
                                                {{$curriculam->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('tutor_curriculam_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        {{-- <button class="btn btn-primary py-1 px-2">Save</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-5" style="height: 635px">
                                <p class="mb-4 fw-semibold fs-5">Others</p>


                                <div class="">
                                    <div class="mb-3">
                                        <label for="hire" class="form-label">When are you looking to hire?</label>
                                        <input value="{{$job->hire_date}}" name="hire_date" type="date"
                                            class="form-control rounded-3 shadow-none" id="hire_date" placeholder=""
                                            style="padding: 14px 18px" />
                                    </div>
                                    <div class="p-4 rounded-3 d-flex justify-content-center align-items-center flex-column"
                                        style="
                                box-shadow: 0px 4px 30px 0px rgba(59, 60, 61, 0.15);
                                height: 380px;
                                ">
                                        <p class="">
                                            Sms Send (Are you sure to send sms to this offer)
                                        </p>
                                        <div class="mt-3 bg-info text-white rounded px-2">
                                            <input type="checkbox" name="is_sms"
                                                {{$job->is_sms_send == 1 ? 'checked' : '' }} value="1">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        {{-- <button class="btn btn-primary py-1 px-2">Save</button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                        </form>

                        @if($additionChild !=null)
                        @foreach ($additionChild as $item)
                            <div>
                                <div class="bg-white rounded-3 shadow-lg p-4 mb-4">
                                    <h5 class="mb-5 ms-4">Student Information-1.{{$loop->iteration}} </h5>
                                    <div class="">
                                        <form id="updateAdditionalChildForm_{{$item->id}}" action="{{route('admin.job.additional-child-update')}}" method="POST">
                                            @csrf
                                            <input name="parent_id" id="add_child_parent_id" type="hidden" value="{{$item->parent_id}}">
                                            <input name="id" id="add_id" type="hidden" value="{{$item->id}}">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input value="{{ old('name', $item->student_name ?? 'N/A') }}" name="student_name" type="text"
                                                    class="form-control rounded-3 shadow-none" id="name" placeholder="Enter Name" style="padding: 14px 18px" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="gender" class="form-label required">Gender</label>
                                                <select name="gender" class="form-select rounded-3 shadow-none" aria-label="Default select" id="gender" style="padding: 14px 18px">
                                                    <option value="">Select Gender</option>
                                                    <option value="male" {{ $item->student_gender == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ $item->student_gender == 'female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                                <span class="text-danger error-text gender_error"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="institute" class="form-label">Name of Institute</label>
                                                <input value="{{ old('institute_name', $item->institute_name ?? 'N/A') }}" name="institute_name" type="text"
                                                    class="form-control rounded-3 shadow-none" id="institute_name" placeholder="Institute Name" style="padding: 14px 18px" />
                                                <span class="text-danger error-text institute_name_error"></span>
                                            </div>
                                            <div class="mb-3" style="display: grid;">
                                                <label for="category_id" class="form-label required">Category</label>
                                                <select name="category" id="category_id_2" class="select2 form-control">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{$category->id}}" {{$item->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text category_error"></span>
                                            </div>
                                            <div class="mb-3" style="display: grid;">
                                                <label for="course_id_2" class="form-label required">Course</label>
                                                <select name="course" class="select2 form-select rounded-3 shadow-none" id="course_id_2" style="padding: 14px 18px">
                                                    <option>Select Course</option>
                                                    @foreach ($courses->where('category_id', $item->category_id) as $course)
                                                    <option value="{{$course->id}}" {{$item->course_id == $course->id ? 'selected' : '' }}>{{$course->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text course_error"></span>
                                            </div>
                                            <div class="mb-3" style="display: grid;">
                                                <label for="subject_id_2" class="form-label required">Subjects</label>
                                                <select name="subject[]" class="select2 form-select rounded-3 shadow-none" multiple id="subject_id_2" style="padding: 14px 18px">
                                                    <option>Select subject</option>
                                                    @foreach ($courseSubjects->where('course_id', $item->course_id) as $cs)
                                                    @php
                                                    $Selected="";
                                                    foreach ($item->job_offer_additional_child_subjects as $ocss) {
                                                    if($ocss->id==$cs->id){
                                                    $Selected="selected";
                                                    break;
                                                    }
                                                    }
                                                    @endphp
                                                    <option value="{{$cs->id}}" {{$Selected}}>{{$cs->subject->title ?? 'N/A'}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text subject_error"></span>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center mt-4">
                                                <button type="button" class="btn btn-primary py-1 px-2 me-3" onclick="refresh();">Reset</button>
                                                <button type="submit" class="btn btn-primary py-1 px-2" id="updateForm">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif

                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <p class="fw-semibold fs-5 mb-0">Parent Note</p>
                                        <p id="guardian_id" class="text-info" style="font-size: 12px">
                                            Guardian ID-31934
                                        </p>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="mb-4 border-bottom border-2">
                                        <div class="bg-light rounded-3 p-3 my-3"
                                            style="height: 150px; overflow-y: scroll">
                                            Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy text ever since the 1500s,
                                            when an unknown printer took a galley of type and
                                            scrambled it to make a type specimen book. industry's
                                            standard dummy text ever since the 1500s, when an
                                            unknown printer took a galley of type and scrambled it
                                            to make a type specimen book.
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <img src="https://th.bing.com/th/id/OIP.VqzttYBT7iSOHw-XV5k5_QHaHx?pid=ImgDet&rs=1"
                                                    alt="map" class="img-fluid rounded-3 mb-3 shadow-lg"
                                                    style="width: 40px; height: 40px" />
                                                <div>
                                                    <p class="fw-semibold mb-0">Yousuf Ali</p>
                                                    <p class="text-muted" style="font-size: 12px">
                                                        Sales & Operation Dep:
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-muted mb-0" style="font-size: 12px">
                                                    Employee ID-32585
                                                </p>
                                                <p class="text-muted" style="font-size: 12px">
                                                    June 6, 2023 at 03:30 PM
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 border-bottom border-2">
                                        <div class="bg-light rounded-3 p-3 my-3"
                                            style="height: 150px; overflow-y: scroll">
                                            Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy text ever since the 1500s,
                                            when an unknown printer took a galley of type and
                                            scrambled it to make a type specimen book. Lorem Ipsum
                                            is simply dummy text of the printing and typesetting
                                            industry. Lorem Ipsum has been the industry's standard
                                            dummy text ever since the 1500s, when an unknown
                                            printer took a galley of type and scrambled it to make
                                            a type specimen book.
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <img src="https://th.bing.com/th/id/OIP.VqzttYBT7iSOHw-XV5k5_QHaHx?pid=ImgDet&rs=1"
                                                    alt="map" class="img-fluid rounded-3 mb-3 shadow-lg"
                                                    style="width: 40px; height: 40px" />
                                                <div>
                                                    <p class="fw-semibold mb-0">Yousuf Ali</p>
                                                    <p class="text-muted" style="font-size: 12px">
                                                        Sales & Operation Dep:
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-muted mb-0" style="font-size: 12px">
                                                    Employee ID-32585
                                                </p>
                                                <p class="text-muted" style="font-size: 12px">
                                                    June 6, 2023 at 03:30 PM
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button class="btn btn-dark me-2 px-2 py-1">
                                            More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-3 shadow-lg p-4 mb-4">
                                <div class="mt-4">
                                    <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
                                        <a class="text-decoration-none text-gray-800 active-border" href="#">Current
                                            Pending</a>
                                        <a class="text-decoration-none text-gray-800" href="#">Closed (2)</a>
                                        <a class="text-decoration-none text-gray-800" href="#" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">Status</a>
                                    </div>
                                    <div class="col bg-white px-4 py-5 mt-4 mb-5 me-1 border rounded-3" style="
                                    box-shadow: 0px 4px 30px 0px rgba(59, 60, 61, 0.15);
                                    ">
                                        <div class="d-flex justify-content-between align-items-start mb-4">
                                            <h4 class="text-gray-800 fs-mobile-8">Class-10</h4>
                                            <div>
                                                <h6 class="text-muted fs-mobile-7">Job ID 23451</h6>

                                                <h6 class="text-muted fs-mobile-7">
                                                    <i class="bi bi-clock-fill me-2"></i>20 minutes
                                                    ago
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex mb-5 align-items-center gap-3">
                                                <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                    style="height: 30px; min-width: 30px">
                                                    <i class="bi bi-geo-alt-fill"></i>
                                                </div>
                                                <span class="fw-600 text-nowrap fs-mobile-7">
                                                    Mirpur-1, Dhaka Mar 28,2023
                                                </span>
                                            </div>

                                            <div class="col-6 d-flex align-items-center mb-5 gap-3">
                                                <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                    style="height: 30px; min-width: 30px">
                                                    <i class="bi bi-file-text-fill"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-600 text-nowrap fs-mobile-7">
                                                        Subjects
                                                    </span>
                                                    <br />
                                                    <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                        All
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-6 d-flex align-items-center mb-5 gap-3">
                                                <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                    style="height: 30px; min-width: 30px">
                                                    <i class="bi bi-calendar-week-fill"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-600 text-nowrap fs-mobile-7">
                                                        Per Week
                                                    </span>
                                                    <br />
                                                    <span class="text-nowrap fs-mobile-7 text-gray-600">
                                                        4 Days
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex align-items-center gap-3 mb-5">
                                                <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                    style="height: 30px; min-width: 30px">
                                                    <i class="bi bi-gender-ambiguous"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-600 text-nowrap fs-mobile-8">
                                                        Tutor Gender
                                                    </span>
                                                    <br />
                                                    <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                        Male
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex align-items-center mb-5 gap-3">
                                                <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                    style="height: 30px; min-width: 30px">
                                                    <i class="bi bi-wallet-fill"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-600 text-nowrap fs-mobile-7">Salary</span>
                                                    <br />
                                                    <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                        BDT 50000 Tk
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button class="btn btn-dark me-2 px-2 py-1" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal1">
                                                View
                                            </button>
                                            <button class="btn btn-primary px-2 py-1">
                                                Restore
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- main content section ends here -->
                <!-- Modal for add parents-->
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-4">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel2">Parents</h5>
                            </div>
                            <div class="modal-body">


                                <form id="addParentForm" action="{{ route('admin.add-new-parent') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label required">Name</label>

                                        <input type="text" class="form-control rounded-3 shadow-none" id="parent_name"
                                            name="name" placeholder="Mehedi Hasan" style="padding: 14px 18px" />
                                        <span class="text-danger error-text name_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control rounded-3 shadow-none"
                                            id="email" placeholder="example@gmail.com" style="padding: 14px 18px" />
                                        <span class="text-danger error-text email_error"></span>


                                    </div>
                                    <div class="mb-3">
                                        <label for="num1" class="form-label required">Number</label>
                                        <input type="text" name="phone" class="form-control rounded-3 shadow-none"
                                            id="parent_phonenumber" {{-- placeholder="01658963122" --}}
                                            style="padding: 14px 18px" />
                                        <span class="text-danger error-text phone_error"></span>


                                    </div>
                                    <div class="mb-3">
                                        <label for="num2" class="form-label">Additional Number</label>
                                        <input type="text" name="phonenumber2" id="parent_phonenumber2"
                                            class="form-control rounded-3 shadow-none" id="num2"
                                            placeholder="01658963122" style="padding: 14px 18px" />
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- modal for additional child --}}


                <div class="modal fade" id="additionalChildModal" aria-labelledby="exampleModalLabel2">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-4">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel2">Student Information-1.1</h5>
                                <button type="button" class="close" data-bs-dismiss="modal fade" aria-label="Close">
                                    <span aria-hidden="false">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form id="updateAdditionalChildForm"
                                    action="{{route('admin.job.additional-child-update')}}" method="POST">
                                    @csrf
                                    <input name="parent_id" id="add_child_parent_id" type="hidden"
                                        value="{{$job->parent_id}}">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input
                                            value="{{ old('name', $job->additional_child_info->student_name ?? 'N/A') }}"
                                            name="student_name" type="text" class="form-control rounded-3 shadow-none"
                                            id="name" placeholder="Enter Name" style="padding: 14px 18px" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label required">Gender</label>
                                        <select name="gender" class="form-select rounded-3 shadow-none"
                                            aria-label="Default select " id="gender" style="padding: 14px 18px">
                                            <option value="">Select Gender</option>

                                            <option value="male"
                                                {{ $job->additional_child_info->student_gender ?? 'N/A' === 'male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="female"
                                                {{ $job->additional_child_info->student_gender ?? 'N/A' === 'female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="3rd Gender"
                                                {{ $job->additional_child_info->student_gender ?? 'N/A' === '3rd Gender' ? 'selected' : '' }}>
                                                3rd Gender</option>


                                        </select>
                                        <span class="text-danger error-text gender_error"></span>
                                    </div>

                                    <div class="mb-3">
                                        <label for="institute" class="form-label">Name of Institute</label>
                                        <input
                                            value="{{ old('institute_name', $job->additional_child_info->institute_name ?? 'N/A') }}"
                                            name="institute_name" type="text" class="form-control rounded-3 shadow-none"
                                            id="institute_name" placeholder="Institute Name"
                                            style="padding: 14px 18px" />
                                        <span class="text-danger error-text institute_name_error"></span>
                                    </div>
                                    <div class="mb-3" style="display: grid;">
                                        <label for="category_id" class="form-label required">Category</label>
                                        <select name="category" id="category_id_2" class="select2 form-control">
                                            <option value="">Select Category</option>

                                            @if($job->additional_child_info !=''){
                                            @foreach ($categories as $category)

                                            <option value="{{$category->id}}"
                                                {{$job->additional_child_info->category_id == $category->id ? 'selected' : '' }}>
                                                {{$category->name}}</option>
                                            @endforeach

                                            }
                                            @else{

                                            @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                            }
                                            @endif



                                        </select>
                                        <span class="text-danger error-text category_error"></span>
                                    </div>
                                    <div class="mb-3" style="display: grid;">
                                        <label for="course_id_2" class="form-label required">Course</label>
                                        <select name="course" class="select2 form-select rounded-3 shadow-none"
                                            id="course_id_2" style="padding: 14px 18px">
                                            <option>Select Course</option>
                                            @if($job->additional_child_info != null)
                                            {
                                            @foreach ($courses->where('category_id',
                                            $job->additional_child_info->category_id) as $course)
                                            <option value="{{$course->id}}"
                                                {{$job->course_id == $course->id ? 'selected' : '' }}>{{$course->name}}
                                            </option>
                                            @endforeach
                                            }
                                            @else
                                            @foreach ($courses as $course)
                                            <option value="{{$course->id}}">{{$course->name}}</option>
                                            @endforeach
                                            @endif

                                        </select>
                                        <span class="text-danger error-text course_error"></span>

                                    </div>
                                    <div class="mb-3" style="display: grid;">
                                        <label for="subject_id_2" class="form-label required">Subjects</label>
                                        <select name="subject[]" class="select2 form-select rounded-3 shadow-none"
                                            multiple id="subject_id_2" style="padding: 14px 18px">

                                            <option>Select subject</option>

                                            @if ($job->additional_child_info !=null)
                                            @foreach ($courseSubjects->where('course_id',
                                            $job->additional_child_info->course_id) as $cs)
                                            @php
                                            $Selected="";
                                            foreach ($xx as $ocss) {
                                            if($ocss->id==$cs->id){
                                            $Selected="selected";
                                            break;
                                            }
                                            }
                                            @endphp
                                            <option value="{{$cs->id}}" {{$Selected}}>{{$cs->subject->title ?? 'N/A'}}
                                            </option>
                                            @endforeach
                                            @endif

                                        </select>
                                        <span class="text-danger error-text subject_error"></span>

                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        <button type="button" class="btn btn-primary py-1 px-2 me-3"
                                            onclick="refresh();">Reset</button>
                                        <button type="submit" class="btn btn-primary py-1 px-2">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    {{-- end modal for additional child --}}


                    <!-- Modal for add ref-->
                    <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-4">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel3">Reference </h5>
                                </div>
                                <div class="modal-body">

                                    <form id="addReferenceForm" action="{{route('admin.add-new-reference')}}"
                                        method="POST">
                                        @csrf

                                        <input type="hidden" name="parents_id" id="reference_parent_id">
                                        <div class="mb-3">
                                            <label for="name" class="form-label required">Name</label>
                                            <input name="name" type="text" class="form-control rounded-3 shadow-none"
                                                id="name" placeholder="Mehedi Hasan" style="padding: 14px 18px" />
                                            <span class="text-danger error-text name_error"></span>

                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input name="email" type="email" class="form-control rounded-3 shadow-none"
                                                id="email" placeholder="example@gmail.com" style="padding: 14px 18px" />
                                            <span class="text-danger error-text email_error"></span>

                                        </div>
                                        <div class="mb-3">
                                            <label for="num1" class="form-label required">Number</label>
                                            <input name="phone" type="text" class="form-control rounded-3 shadow-none"
                                                id="phone" placeholder="01658963122" style="padding: 14px 18px" />
                                            <span class="text-danger error-text phone_error"></span>




                                        </div>
                                        <div class="mb-3">
                                            <label for="num2" class="form-label">Additional Number</label>
                                            <input name="additional_phone" type="text"
                                                class="form-control rounded-3 shadow-none" id="additional_phone"
                                                placeholder="01658963122" style="padding: 14px 18px" />
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for status-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mx-4 mx-lg-auto" style="max-width: 870px">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="rounded-3 shadow-lg mb-3">
                                        <div class="bg-primary text-white rounded-top px-4 py-4">
                                            Profile Status
                                        </div>
                                        <div class="p-4">
                                            <p class="mb-2 text-primary">
                                                Your profile has no issues
                                            </p>
                                            <p class="border-top border-2 pt-2 mb-0">
                                                Your profile is now unlocked, you can update it
                                                whenever you want.
                                            </p>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button class="btn btn-primary px-4">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rounded-3 shadow-lg mb-3">
                                        <div class="bg-warning text-white rounded-top px-4 py-4">
                                            Profile Status
                                        </div>
                                        <div class="p-4">
                                            <p class="mb-2 text-warning">
                                                Your profile has some issues
                                            </p>
                                            <p class="border-top border-2 pt-2 mb-0">
                                                Your profile has been violating our terms & policies,
                                                so be aware of using it features.
                                            </p>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button class="btn btn-warning px-4">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rounded-3 shadow-lg">
                                        <div class="bg-danger text-white rounded-top px-4 py-4">
                                            Profile Status
                                        </div>
                                        <div class="p-4">
                                            <p class="mb-2 text-danger">Your profile is locked</p>
                                            <p class="border-top border-2 pt-2 mb-0">
                                                To unlock your profile, please contact with the
                                                administrator 09678 444477.
                                            </p>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button class="btn btn-danger px-4">Contact</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for job details-->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mx-4 mx-lg-auto" style="max-width: 1100px">
                            <div class="modal-content">
                                <div class="modal-body p-lg-5">
                                    <div class="row">
                                        <div class="col-12 col-lg-8">
                                            <div class="p-4 rounded-3 shadow-lg mb-4">
                                                <p class="text-primary fs-5">Student Information</p>

                                                <div class="row row-cols-lg-3 row-cols-2 mt-5">
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-tags-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Category
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                Bangla Medium
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-file-text-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Course
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                HSC first year
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-file-text-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Subjects
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                All
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-calendar-week-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Days and week
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                4 Days
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-clock-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Tutoring Time
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                1.30 pm
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-hourglass-top"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Tutoring Duration
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                1.50 Hour
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-back"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Tutor Method
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                Online
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-wallet-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Maximum Salary
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                BDT 3000 Tk
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-gender-ambiguous"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Student Gender
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                Male
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-4 rounded-3 shadow-lg mb-4">
                                                <p class="text-primary fs-5">Tutor Requirements</p>

                                                <div class="row mt-5">
                                                    <div class="d-flex align-items-center mb-5 gap-3 col-6 col-lg-4">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-gender-ambiguous"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Tutor Gender
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                ANy
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3 col-6 col-lg-4">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-calendar-date-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Hiring From
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                2023-04-01
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3 col-12">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-palette2"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Other Requirement
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 fs-mobile-7">
                                                                Tutor must be experienced at teaching english
                                                                version student
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-4 rounded-3 shadow-lg mb-4">
                                                <p class="text-primary fs-5">Contact Information</p>

                                                <div class="row row-cols-lg-3 row-cols-2 mt-5">
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-globe"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Country
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                Bangladesh
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-buildings-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                City
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                Dhaka
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-geo-alt-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Location
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                Mirpur 1
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-5 gap-3">
                                                        <div class="text-white bg-primary rounded shadow-lg d-flex justify-content-center align-items-center"
                                                            style="height: 30px; min-width: 30px">
                                                            <i class="bi bi-person-vcard-fill"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-600 text-nowrap fs-mobile-7">
                                                                Full Address
                                                            </span>
                                                            <br />
                                                            <span class="text-gray-600 text-nowrap fs-mobile-7">
                                                                Mirpur, Tolarbarg
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="p-4 rounded-3 flex-column flex-lg-row shadow-lg d-flex justify-content-between align-items-center">
                                                <p class="text-uppercase m-0">job id</p>
                                                <p class="text-uppercase m-0">Total Views-1</p>

                                                <p class="text-uppercase m-0">total applications-23</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12 mt-4 mt-lg-0">
                                            <div class="rounded-3 shadow-lg" style="
                                padding: 30px 70px;
                                opacity: 0.4;
                                pointer-events: none;
                            ">
                                                <div class="d-flex flex-column justify-content-center gap-3">
                                                    <button class="btn btn-dark">Get Direction</button>
                                                    <button class="btn btn-secondary shadow-lg">
                                                        Location
                                                    </button>

                                                    <button class="btn btn-secondary shadow-lg">
                                                        Copy Link
                                                    </button>

                                                    <button class="btn btn-primary">Apply Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
    </div>
</div>
@endsection

@push('page_scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="{{ asset('template/tution-terminal-admin-offer/js/owl/owl.carousel.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyAHdRskLFVhSoxXfLLxVn8ewxUhmdbzBws&callback=initMap"></script> -->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAHdRskLFVhSoxXfLLxVn8ewxUhmdbzBws&libraries=places"></script>

@include('backend.job_offers.js.job_edit_page_js')


<script>
    $(document).ready(function() {
        // Listen for form submissions
        @foreach ($additionChild as $item)
        $("#updateAdditionalChildForm_{{$item->id}}").on("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Serialize form data
            var formData = new FormData($(this)[0]);

            // AJAX request
            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(this).find("span.error-text").text("");
                },
                success: function(data) {
                    if (data.status == false) {
                        $.each(data.error, function(prefix, val) {
                            $("span." + prefix + "_error").text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Data updated successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        window.location.href = "{{ route('admin.job-offer.all-offers') }}";

                    }
                },
                error: function(err) {
                    console.error('Error:', err);
                    alert('Error submitting form');
                }
            });
        });
        @endforeach
    });
</script>


@endpush
