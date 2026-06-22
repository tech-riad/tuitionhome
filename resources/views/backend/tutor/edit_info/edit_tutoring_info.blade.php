@if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif
{{-- <h5>Tutoring Information</h5> --}}
<div class="row row-cols-lg-2">
    <div style="">
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 800px">

            <form action="{{route('admin.tutor.updateTutoringInfo')}}" method="post" id="updateTutoringInfo">
                @csrf

                <input type="hidden" name="tutor_id" id="tutor_id" value="{{$tutor->id}}">
                <div class="">

                    <div class="mb-3">
                        <label for="category_id" class="form-label required">Category</label>
                        <select name="category_id[]" id="category_id" class="form-select rounded-3 shadow-none" style="padding: 14px 18px" multiple>
                            <option value="">Select Category</option>
                            @php
                            $otc=$tutor->tutor_categories;
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
                                <option value="{{$category->id}}" {{$isSelected}} >{{$category->name}}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="text-danger error-text category_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="course_id" class="form-label required">Course</label>
                        <select name="course_id[]" class="form-select rounded-3 shadow-none" id="course_id" style="padding: 14px 18px" multiple>
                            @php
                                $otcourse = $tutor->tutor_course;
                                $catear = [];
                                foreach ($tutor->tutor_categories as $category) {
                                    $catear[] = $category->id;
                                }
                            @endphp

                            @if ($otcourse != null)
                                @foreach ($courses->whereIn('category_id', $catear) as $course)
                                    @php
                                        $isSelected = "";
                                        foreach ($otcourse as $otc) {
                                            if ($otc->id == $course->id) {
                                                $isSelected = "selected";
                                                break;
                                            }
                                        }
                                    @endphp
                                    <option value="{{ $course->id }}" {{ $isSelected }}>
                                        {{ $course->name }} ({{ $course->category->name }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger error-text course_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label required">Subjects</label>
                        <select name="subject_id[]" class="form-select rounded-3 shadow-none" id="subject_id" style="padding: 14px 18px" multiple>
                            @php
                                $otsubject = $tutor->course_subjects;
                                $ar = [];
                                foreach ($tutor->course_subjects as $course) {
                                    $ar[] = $course->course_id;
                                }
                            @endphp

                            @if ($otsubject != null)
                                @foreach ($courseSubjects->whereIn('course_id', $ar) as $cs)
                                    @php
                                        $isSelectedd = "";
                                        foreach ($otsubject as $otcs) {
                                            if ($otcs->id == $cs->id) {
                                                $isSelectedd = "selected";
                                                break;
                                            }
                                        }
                                    @endphp
                                    <option value="{{ $cs->id }}" {{ $isSelectedd }}>
                                        {{ $cs->subject->title ?? 'N/A' }} ({{ $cs->course->name ?? 'N/A' }} - {{ $cs->category->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger error-text subject_id_error"></span>
                    </div>

                   {{-- Important  --}}

                    {{-- <div class="mb-3">
                        <label for="category_id" class="form-label required">Category</label>
                        <select name="category_id[]" id="category_id" class="form-select rounded-3 shadow-none" style="padding: 14px 18px" multiple>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text category_id_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="course_id" class="form-label required">Course</label>
                        <select name="course_id[]" class="form-select rounded-3 shadow-none" id="course_id" style="padding: 14px 18px" multiple disabled>
                            <option value="">Select Course</option>
                        </select>
                        <span class="text-danger error-text course_id_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="subject_id" class="form-label required">Subjects</label>
                        <select name="subject_id[]" class="form-select rounded-3 shadow-none" id="subject_id" style="padding: 14px 18px" multiple disabled>
                            <option value="">Select Subject</option>
                        </select>
                        <span class="text-danger error-text subject_id_error"></span>
                    </div> --}}

                  {{-- Important  --}}




                        <div class="mb-3">
                            <label for="cun" class="form-label required">Country</label>
                            <select name="country_id" class="form-select rounded-3 shadow-none " aria-label="Default select " id="countryy_id" style="padding: 14px 18px">
                                @if ($tutor->tutor_personal_info !=null)
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}"{{$tutor->tutor_personal_info->country_id == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                @endforeach
                                @else
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger error-text country_id_error"></span>
                        </div>
                            <div class="mb-3">
                                <label for="course_id" class="form-label required">City</label>
                                <select name="city_id" class="form-select rounded-3 shadow-none"
                                 id="cityy_id" style="padding: 14px 18px" >
                                 @if ($tutor->tutor_personal_info !=null)
                                 <option value="">Select city</option>
                                 @foreach ($cities->where('country_id', $tutor->tutor_personal_info->country_id) as $city)
                                 <option value="{{$city->id}}"{{$tutor->tutor_personal_info->city_id == $city->id ? 'selected' : '' }}>{{$city->name}}</option>
                                 @endforeach




                                 @endif

                                </select>
                                <span class="text-danger error-text course_id_error"></span>

                            </div>
                            <div class="mb-3">
                                <label for="course_id" class="form-label required">Location</label>
                                <select name="location_id" class="form-select rounded-3 shadow-none"
                                 id="locationn_id" style="padding: 14px 18px" >
                                 @if ($tutor->tutor_personal_info!=null)

                                 @foreach($locations->where('city_id', $tutor->tutor_personal_info->city_id) as $location)
                                 <option value="{{$location->id}}"{{$tutor->tutor_personal_info->location_id == $location->id ? 'selected' : '' }}>{{$location->name}}</option>

                                 @endforeach



                                 @endif
                                </select>
                                <span class="text-danger error-text course_id_error"></span>

                            </div>



                    <div class="mb-3">
                        <label for="course_id" class="form-label required">Prefered Location</label>
                        <select name="p_location_id[]" class="form-select rounded-3 shadow-none"
                         id="p_locationn_id" style="padding: 14px 18px" multiple>



                         @php
                         $tp_location=$tutor->tutor_prefered_locations;
                        @endphp

                         @if ($tutor->tutor_personal_info!=null)

                         @if ($tp_location!=null)
                         @foreach ($locations->where('city_id', $tutor->tutor_personal_info->city_id) as $location)
                             @php
                                 $isSelected="";
                                 foreach ($tp_location as $tpl) {
                                     if($tpl->id==$location->id){
                                         $isSelected="selected";
                                     break;
                                     }
                                 }
                             @endphp
                             <option value="{{$location->id}}" {{$isSelected}} >{{$location->name}}</option>
                         @endforeach
                         @endif
                         @endif



                        </select>
                        <span class="text-danger error-text course_id_error"></span>

                    </div>
                    <div class="mb-3">
                        <label for="course_id" class="form-label required">Availablity</label>
                        <select name="days_id[]" class="form-select rounded-3 shadow-none"
                         id="days_id" style="padding: 14px 18px" multiple>

                         @php
                                 $t_days=$tutor->tutor_days;
                                @endphp

                                 @if ($t_days!=null)
                                 @foreach ($days as $day)
                                     @php
                                         $isSelected="";
                                         foreach ($t_days as $td) {
                                             if($td->id==$day->id){
                                                 $isSelected="selected";
                                             break;
                                             }
                                         }
                                     @endphp
                                     <option value="{{$day->id}}" {{$isSelected}} >{{$day->title}}</option>
                                 @endforeach
                                 @endif


                        </select>
                        <span class="text-danger error-text course_id_error"></span>

                    </div>




            </div>
        </div>
    </div>
    <div>
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 800px">



            <div class="mb-3">

                <label for="course_id" class="form-label required">Prefered Teaching Method</label>
                <select name="tecahing_method_id[]" class="form-select rounded-3 shadow-none"
                 id="tecahing_method_id" style="padding: 14px 18px" multiple>

                 @php
                 $ottm=$tutor->teaching_method;
                @endphp

                 @if ($t_days!=null)
                 @foreach ($teaching_methods as $teaching_method)
                     @php
                         $isSelected="";
                         foreach ($ottm as $otm) {
                             if($otm->id==$teaching_method->id){
                                 $isSelected="selected";
                             break;
                             }
                         }
                     @endphp
                     <option value="{{$teaching_method->id}}" {{$isSelected}} >{{$teaching_method->name}}</option>
                 @endforeach
                 @endif


                </select>
                <span class="text-danger error-text course_id_error"></span>

            </div>


                    <div class="mb-3">
                        <label for="" class="form-label required">Tutoring Experience</label>
                        <select name="experience" class="form-select rounded-3 shadow-none"
                        aria-label="Default select " id="experience" >
                        <option value="">Select Days</option>

                        <option value="0" {{ @$tutor->tutor_personal_info->tutoring_experience == 0 ? 'selected' : '' }}>0 Years
                        </option>
                        <option value="1" {{ @$tutor->tutor_personal_info->tutoring_experience == 1 ? 'selected' : '' }}>1 Years
                        </option>
                        <option value="2" {{ @$tutor->tutor_personal_info->tutoring_experience == 2 ? 'selected' : '' }}>2 Years
                        </option>
                        <option value="3" {{ @$tutor->tutor_personal_info->tutoring_experience == 3 ? 'selected' : '' }}>3 Years
                        </option>
                        <option value="4" {{ @$tutor->tutor_personal_info->tutoring_experience == 4 ? 'selected' : '' }}>4 Years
                        </option>
                        <option value="5" {{ @$tutor->tutor_personal_info->tutoring_experience == 5 ? 'selected' : '' }}>5 Years
                        </option>
                        <option value="6" {{ @$tutor->tutor_personal_info->tutoring_experience == 6 ? 'selected' : '' }}>6 Years
                        </option>
                        <option value="7" {{ @$tutor->tutor_personal_info->tutoring_experience == 7 ? 'selected' : '' }}>7 Years
                        </option>
                        <option value="8" {{ @$tutor->tutor_personal_info->tutoring_experience == 8 ? 'selected' : '' }}>8 Years
                        </option>
                        <option value="9" {{ @$tutor->tutor_personal_info->tutoring_experience == 9 ? 'selected' : '' }}>9 Years
                        </option>
                        <option value="10+" {{ @$tutor->tutor_personal_info->tutoring_experience == 10 ? 'selected' : '' }}>10+ Years
                        </option>
                    </select>



                    {{-- <option value="1" {{ $job->days_in_week === 1 ? 'selected' : '' }}>1 Days
                    </option> --}}





                        {{-- <input name="experience" type="text" value="{{ old('experience', $tutor->tutor_personal_info->tutoring_experience ?? 'N/A') }}" class="form-control rounded-3 shadow-none"
                           id="experience"  style="padding: 14px 18px" /> --}}

                    </div>



                    <div class="mb-3">
                        <label for="salary" class="form-label required">Expected Salary</label>



                        <select name="expected_salary" class="form-select rounded-3 shadow-none"
                        aria-label="Default select " id="expected_salary" >
                        <option value="">Select Expected Salary</option>

                        <option value="2000" {{ @$tutor->tutor_personal_info->expected_salary == 2000 ? 'selected' : '' }}>BDT 2000
                        </option>
                        <option value="2500" {{ @$tutor->tutor_personal_info->expected_salary == 2500 ? 'selected' : '' }}>BDT 2500
                        </option>
                        <option value="3000" {{ @$tutor->tutor_personal_info->expected_salary == 3500 ? 'selected' : '' }}>BDT 3000
                        </option>
                        <option value="4000" {{ @$tutor->tutor_personal_info->expected_salary == 4000 ? 'selected' : '' }}>BDT 3500
                        </option>
                        <option value="4500" {{ @$tutor->tutor_personal_info->expected_salary == 4500 ? 'selected' : '' }}>BDT 4000
                        </option>
                        <option value="5000" {{ @$tutor->tutor_personal_info->expected_salary == 5000 ? 'selected' : '' }}>BDT 4500
                        </option>
                        <option value="5500" {{ @$tutor->tutor_personal_info->expected_salary == 5500 ? 'selected' : '' }}>BDT 5000
                        </option>
                        <option value="6000" {{ @$tutor->tutor_personal_info->expected_salary == 6000 ? 'selected' : '' }}>BDT 5500
                        </option>
                        <option value="6500" {{ @$tutor->tutor_personal_info->expected_salary == 6500 ? 'selected' : '' }}>BDT 6000
                        </option>
                        <option value="7000" {{ @$tutor->tutor_personal_info->expected_salary == 7000 ? 'selected' : '' }}>BDT 6500
                        </option>
                        <option value="7500" {{ @$tutor->tutor_personal_info->expected_salary ==7500 ? 'selected' : '' }}>BDT 7000
                        </option>
                        <option value="8000" {{ @$tutor->tutor_personal_info->expected_salary == 8000 ? 'selected' : '' }}>BDT 7500
                        </option>
                        <option value="8500" {{ @$tutor->tutor_personal_info->expected_salary == 8500 ? 'selected' : '' }}>BDT 8000
                        </option>
                        <option value="9000" {{ @$tutor->tutor_personal_info->expected_salary == 9000 ? 'selected' : '' }}>BDT 8500
                        </option>
                        <option value="9500" {{ @$tutor->tutor_personal_info->expected_salary == 9500 ? 'selected' : '' }}>BDT 9000
                        </option>
                        <option value="10000" {{ @$tutor->tutor_personal_info->expected_salary ==10000 ? 'selected' : '' }}>BDT 10000
                        </option>
                        <option value="10500" {{ @$tutor->tutor_personal_info->expected_salary == 10500 ? 'selected' : '' }}>BDT 10500
                        </option>
                        <option value="11000" {{ @$tutor->tutor_personal_info->expected_salary ==11000 ? 'selected' : '' }}>BDT 11000
                        </option>
                        <option value="11500" {{ @$tutor->tutor_personal_info->expected_salary == 11500 ? 'selected' : '' }}>BDT 11500
                        </option>
                        <option value="11500" {{ @$tutor->tutor_personal_info->expected_salary == 11500 ? 'selected' : '' }}>BDT 11500
                        </option>
                        <option value="12000" {{ @$tutor->tutor_personal_info->expected_salary == 12000 ? 'selected' : '' }}>BDT 12000
                        </option>
                        <option value="12500" {{ @$tutor->tutor_personal_info->expected_salary == 12500 ? 'selected' : '' }}>BDT 12500
                        </option>
                        <option value="13000" {{ @$tutor->tutor_personal_info->expected_salary == 13000 ? 'selected' : '' }}>BDT 13000
                        </option>
                        <option value="13500" {{ @$tutor->tutor_personal_info->expected_salary == 13500 ? 'selected' : '' }}>BDT 13500
                        </option>
                        <option value="14000" {{ @$tutor->tutor_personal_info->expected_salary == 14000 ? 'selected' : '' }}>BDT 14000
                        </option>
                        <option value="14500" {{ @$tutor->tutor_personal_info->expected_salary == 14500 ? 'selected' : '' }}>BDT 14500
                        </option>
                        <option value="15000" {{ @$tutor->tutor_personal_info->expected_salary == 15000 ? 'selected' : '' }}>BDT 15000
                        </option>
                        <option value="15500" {{ @$tutor->tutor_personal_info->expected_salary == 15500 ? 'selected' : '' }}>BDT 15500
                        </option>
                        <option value="16000" {{ @$tutor->tutor_personal_info->expected_salary == 16000 ? 'selected' : '' }}>BDT 16000
                        </option>
                        <option value="16500" {{ @$tutor->tutor_personal_info->expected_salary == 16500 ? 'selected' : '' }}>BDT 16500
                        </option>
                        <option value="17000" {{ @$tutor->tutor_personal_info->expected_salary == 17000 ? 'selected' : '' }}>BDT 17000
                        </option>
                        <option value="17500" {{ @$tutor->tutor_personal_info->expected_salary == 17500 ? 'selected' : '' }}>BDT 17500
                        </option>
                        <option value="18000" {{ @$tutor->tutor_personal_info->expected_salary == 18000 ? 'selected' : '' }}>BDT 18000
                        </option>
                        <option value="18500" {{ @$tutor->tutor_personal_info->expected_salary == 18500 ? 'selected' : '' }}>BDT 18500
                        </option>
                        <option value="19000" {{ @$tutor->tutor_personal_info->expected_salary == 19000 ? 'selected' : '' }}>BDT 19000
                        </option>
                        <option value="19500" {{ @$tutor->tutor_personal_info->expected_salary == 19500 ? 'selected' : '' }}>BDT 19500
                        </option>
                        <option value="20000" {{ @$tutor->tutor_personal_info->expected_salary == 20000 ? 'selected' : '' }}>BDT 20000
                        </option>
                        <option value="20500" {{ @$tutor->tutor_personal_info->expected_salary == 20500 ? 'selected' : '' }}>BDT 20500
                        </option>
                        <option value="21000" {{ @$tutor->tutor_personal_info->expected_salary == 21000 ? 'selected' : '' }}>BDT 21000
                        </option>
                        <option value="21500" {{ @$tutor->tutor_personal_info->expected_salary == 21500 ? 'selected' : '' }}>BDT 21500
                        </option>
                        <option value="22000" {{ @$tutor->tutor_personal_info->expected_salary == 22000 ? 'selected' : '' }}>BDT 22000
                        </option>
                        <option value="22500" {{ @$tutor->tutor_personal_info->expected_salary == 22500 ? 'selected' : '' }}>BDT 22500
                        </option>
                        <option value="23000" {{ @$tutor->tutor_personal_info->expected_salary == 23000 ? 'selected' : '' }}>BDT 23000
                        </option>
                        <option value="23500" {{ @$tutor->tutor_personal_info->expected_salary == 23500 ? 'selected' : '' }}>BDT 23500
                        </option>
                        <option value="24000" {{ @$tutor->tutor_personal_info->expected_salary == 24000 ? 'selected' : '' }}>BDT 24000
                        </option>
                        <option value="24500" {{ @$tutor->tutor_personal_info->expected_salary == 24500 ? 'selected' : '' }}>BDT 24500
                        </option>
                        <option value="25000" {{ @$tutor->tutor_personal_info->expected_salary == 25000 ? 'selected' : '' }}>BDT 25000
                        </option>
                    </select>




                        {{-- <input name="expected_salary" type="number"value="{{ old('expected_salary', $tutor->tutor_personal_info->expected_salary ?? 'N/A') }}" class="form-control rounded-3 shadow-none"
                         id="expected_salary " placeholder="" style="padding: 14px 18px" /> --}}

                    </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="course_id" class="form-label required">Available From</label>
                        <input  name="available_from" type="time" value="{{ old('available_from', $tutor->tutor_personal_info->available_from ?? '') }}" class="form-control rounded-3 shadow-none"
                        id="available_from" placeholder="Institute Name" style="padding: 14px 18px" />

                    </div>
                </div>
                

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="course_id" class="form-label required">Available To</label>
                        <input name="available_to" type="time" value="{{ old('available_to', $tutor->tutor_personal_info->available_to ?? '') }}" class="form-control rounded-3 shadow-none"
                       id="available_to" style="padding: 14px 18px" />
                    </div>
                </div>

            </div>
            <br>
            <div class="mb-4 d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary">Save Change</button>
            </div>

        </form>
        </div>
    </div>
</div>
