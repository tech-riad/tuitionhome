{{-- <h1>educational info </h1> --}}


@php

$ssc = $tutor->tutor_education->where('degree_name', 'ssc')->first();

$hsc = $tutor->tutor_education->where('degree_name', 'hsc')->first();

$graduation=$tutor->tutor_education->where('degree_name', 'honours')->first();

$post_graduation =$tutor->tutor_education->where('degree_name', 'masters')->first();;

@endphp




<div class="row row-cols-lg-2">
    <div style="">
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 960px">

             <form action="{{route('admin.tutor.updateEducationalInfo')}}" method="post" id="updateSscEducationalInfo">
                @csrf

                <input type="hidden" name="ssc_tutor_id" id="tutor_id" value="{{$tutor->id}}">
                <div class="">

                    {{-- <div class="card card-default"> --}}

                        <!-- /.card-header -->
                        {{-- <div class="card-body"> --}}

                            <div class="card border-primary">

                                <div class="card-header bg-success">
                                        Secondary / SSC / 0-level / Dakhil
                                    </div>

                                <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ssc_institute_id" class="form-label required">Institute</label>
                                            <br>
                                            <select name="ssc_institute_id" id="ssc_institute_id" class="form-control select2-red rounded-3 shadow-none" style="width: 285px"
                                                 style="padding: 14px 18px" required>
                                                <option value="">Select Institute</option>
                                                @foreach (App\Models\Institute::where('type', 'school')->orWhere('type', 'school and college')->OrderBy('title','asc')->get() as $institute)
                                                @php
                                                    $selected="";
                                                    if($ssc!=null && $ssc->institute_id==$institute->id){
                                                        $selected="selected";
                                                    }else{
                                                        $selected="";
                                                    }
                                                @endphp
                                                <option {{$selected}} value="{{$institute->id}}" data-select2-id="{{$institute->id}}">{{$institute->title}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text ssc_institute_id_error"></span>
                                        </div>

                                            <div class="mb-3">
                                                <label for="gender" class="form-label required">Board</label>
                                                <select name="ssc_board" class="form-select rounded-3 shadow-none"
                                                    style="padding: 14px 18px" required>
                                                    <option value="">Select Board</option>
                                                    <option value="Dhaka" {{ $ssc!=null && $ssc->education_board === "Dhaka" ? 'selected' : '' }}>Dhaka</option>
                                                    <option value="Rajshahi" {{ $ssc!=null && $ssc->education_board   === 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                                    <option value="Mymensingh" {{ $ssc!=null && $ssc->education_board   === 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                                                    <option value="Comilla" {{ $ssc!=null && $ssc->education_board   === 'Comilla' ? 'selected' : '' }}>Comilla</option>
                                                    <option value="Jessore" {{ $ssc!=null && $ssc->education_board   === 'Jessore' ? 'selected' : '' }}>Jessore</option>
                                                    <option value="Chittagong" {{ $ssc!=null && $ssc->education_board  === 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                                                    <option value="Barisal" {{ $ssc!=null && $ssc->education_board  === 'Barisal' ? 'selected' : '' }}>Barisal</option>
                                                    <option value="Sylhet" {{ $ssc!=null && $ssc->education_board  === 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                                                    <option value="Khulna" {{ $ssc!=null && $ssc->education_board  === 'Khulna' ? 'selected' : '' }}>khulna</option>
                                                    <option value="Dinajpur" {{ $ssc!=null && $ssc->education_board  === 'Dinajpur' ? 'selected' : '' }}>Dinajpur</option>
                                                    <option value="Madrasah" {{ $ssc!=null && $ssc->education_board  === 'Madrasah' ? 'selected' : '' }}>Madrasah</option>
                                                    <option value="Singapore" {{ $ssc!=null && $ssc->education_board   === 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                                    <option value="Canadian" {{ $ssc!=null && $ssc->education_board   === 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                                    <option value="Ib" {{ $ssc!=null && $ssc->education_board   === 'Ib' ? 'selected' : '' }}>IB</option>
                                                    <option value="Ed-excel" {{ $ssc!=null && $ssc->education_board   === 'Ed-excel' ? 'selected' : '' }}>Ed-Excel</option>
                                                    <option value="Cambridge" {{ $ssc!=null && $ssc->education_board   === 'Cambridge' ? 'selected' : '' }}>Cambridge</option>
                                                    <option value="Other" {{ $ssc!=null && $ssc->education_board   === 'Other' ? 'selected' : '' }}>Other</option>


                                                </select>
                                                <span class="text-danger error-text gender_error"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ssc_passing_year" class="form-label required">Passing Year</label>
                                                <select name="ssc_passing_year" class="form-select rounded-3 shadow-none"
                                                     style="padding: 14px 18px" required>
                                                    <option value="">Select Year</option>
                                                    <?php for($i = 1975; $i <= date('Y') ;$i++){ ?>
                                                        <option value="{{$i}}" @if(isset($ssc->passing_year) && $ssc->passing_year == $i) selected @endif>{{ $i }}</option>
                                                        <?php } ?>


                                                </select>
                                                <span class="text-danger error-text ssc_passing_year_error"></span>
                                            </div>
                                      </div>

                                      <div class="col-md-6">


                                        <div class="mb-3">
                                            <label for="gender" class="form-label required">Curriculum</label>
                                            <select name="ssc_curriculum_id" class="form-select rounded-3 shadow-none"
                                                required style="padding: 14px 18px">
                                                <option value="">Select Curriculum</option>
                                                    @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as $curriculum)
                                                    @php
                                                        $selectedd="";
                                                        if($ssc != null && $ssc->curriculum_id  === $curriculum->id){
                                                            $selectedd="selected";
                                                        }else{
                                                            $selectedd="";
                                                        }
                                                    @endphp
                                                    <option {{$selectedd}} value="{{$curriculum->id}}">{{$curriculum->title}}</option>
                                                    @endforeach
                                                </select>
                                            <span class="text-danger error-text student_gender_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label required">Group</label>
                                            <select name="ssc_group" class="form-select rounded-3 shadow-none"
                                                required style="padding: 14px 18px">
                                                <option value="">Select Group</option>
                                                <option value="Science" {{$ssc!=null && $ssc->group_or_major  == 'Science' ? 'selected' : '' }}>Science</option>
                                                <option value="Commerce" {{$ssc!=null && $ssc->group_or_major  == 'Commerce' ? 'selected' : '' }}>Commerce</option>
                                                <option value="Arts" {{$ssc!=null && $ssc->group_or_major  == 'Arts' ? 'selected' : '' }}>Arts</option>
                                                {{-- <option value="humanities" {{$ssc!=null && $ssc->group_or_major  == 'humanities' ? 'selected' : '' }}>Humanities</option> --}}

                                            </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="gender" class="form-label required">Result</label>
                                                <input name="ssc_result" type="text" value="{{ old('ssc_result', $ssc->gpa ?? '')}}" class="form-control rounded-3 shadow-none"
                                                  required placeholder="e.g 3.5" style="padding: 14px 18px" />

                                            </div>

                                  </div>



                                  </div>
                                  <div class="mb-4 d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                                </div>

                            </div>







                            <div class="card border-primary">

                                {{-- <form action="{{route('admin.tutor.updateEducationalInfo')}}" method="post" id="updateEducationalInfo">
                                    @csrf

                                    <input type="hidden" name="hsc_tutor_id" id="tutor_id" value="{{$tutor->id}}"> --}}

                                    <form action="{{route('admin.tutor.updateEducationalInfo')}}" method="post" id="updateHscEducationalInfo">
                                        @csrf

                                        <input type="hidden" name="hsc_tutor_id" id="tutor_id" value="{{$tutor->id}}">


                                <div class="card-header bg-success">
                                    Higher secondary / HSC / A level / alim

                                    <div class="custom-control custom-checkbox checkbox-lg align-middle">
                                        <input  type="checkbox" onchange="isDiploma()" value="1" class="custom-control-input" name="is_diploma_student" id="has_diploma">
                                        <label class="custom-control-label" for="has_diploma">Diploma holder</label>
                                      </div>

                                    </div>

                                    <div class="card-body" id="hscDiv">
                                        <div class="row">
                                          <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">Institute</label>
                                                    <br>
                                                    <select name="hsc_institute_id" id="hsc_institute_id" class="form-control select2-red rounded-3 shadow-none" style="width: 285px"
                                                        required style="padding: 14px 18px">
                                                        <option value="">Select Institute</option>
                                                        @foreach (App\Models\Institute::where('type', 'college')->orWhere('type', 'school and college')->OrderBy('title','asc')->get() as $institute)
                                                        @php
                                                            $selected="";
                                                            if($hsc !=null && $hsc->institute_id==$institute->id){
                                                                $selected="selected";
                                                            }else{
                                                                $selected="";
                                                            }
                                                        @endphp
                                                        <option {{$selected}} value="{{$institute->id}}" data-select2-id="{{$institute->id}}">{{$institute->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text student_gender_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">Board</label>
                                                    <select name="hsc_board" class="form-select rounded-3 shadow-none"
                                                       required style="padding: 14px 18px">
                                                        <option value="">Select Board</option>
                                                        <option value="Dhaka" {{$hsc!=null && $hsc->education_board  === 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                                                        <option value="Rajshahi" {{$hsc!=null && $hsc->education_board  === 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                                        <option value="Comilla" {{$hsc!=null && $hsc->education_board  === 'Comilla' ? 'selected' : '' }}>Comilla</option>
                                                        <option value="Jessore" {{$hsc!=null && $hsc->education_board  === 'Jessore' ? 'selected' : '' }}>Jessore</option>
                                                        <option value="Chittagong" {{$hsc!=null && $hsc->education_board  === 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                                                        <option value="Barisal" {{$hsc!=null && $hsc->education_board  === 'Barisal' ? 'selected' : '' }}>Barisal</option>
                                                        <option value="Sylhet" {{$hsc!=null && $hsc->education_board  === 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                                                        <option value="Khulna" {{$hsc!=null && $hsc->education_board  === 'Khulna' ? 'selected' : '' }}>khulna</option>
                                                        <option value="Dinajpur" {{$hsc!=null && $hsc->education_board  === 'Dinajpur' ? 'selected' : '' }}>Dinajpur</option>
                                                        <option value="Madrasah" {{$hsc!=null && $hsc->education_board  === 'Madrasah' ? 'selected' : '' }}>Madrasah</option>
                                                        <option value="Mymensingh" {{ $hsc!=null && $hsc->education_board   === 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                                                        <option value="Singapore" {{ $hsc!=null && $hsc->education_board   === 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                                        <option value="Canadian" {{ $hsc!=null && $hsc->education_board   === 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                                        <option value="Ib" {{ $hsc!=null && $hsc->education_board   === 'Ib' ? 'selected' : '' }}>IB</option>
                                                                                                            <option value="Ed-excel" {{ $ssc!=null && $ssc->education_board   === 'Ed-excel' ? 'selected' : '' }}>Ed-Excel</option>

                                                        <option value="Cambridge" {{ $hsc!=null && $hsc->education_board   === 'Cambridge' ? 'selected' : '' }}>Cambridge</option>
                                                        <option value="Other" {{ $hsc!=null && $hsc->education_board   === 'Other' ? 'selected' : '' }}>Other</option>


                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">Passing Year</label>
                                                    <select name="hsc_passing_year" class="form-select rounded-3 shadow-none"
                                                        required style="padding: 14px 18px">
                                                        <option value="">Select Year</option>
                                                        <?php for($i = 1975; $i <= date('Y') ;$i++){ ?>
                                                        <option value="{{$i}}" @if(isset($hsc->passing_year) && $hsc->passing_year == $i) selected @endif>{{ $i }}</option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="text-danger error-text student_gender_error"></span>
                                                </div>
                                          </div>

                                          <div class="col-md-6">

                                            <div class="mb-3">
                                                <label for="gender" class="form-label required">Curriculum</label>
                                                <select name="hsc_curriculum_id" class="form-select rounded-3 shadow-none"
                                                    required style="padding: 14px 18px">
                                                    <option value="">Select Curriculum</option>
                                                        @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as $curriculum)
                                                        @php
                                                            $selected="";
                                                            if($hsc != null && $hsc->curriculum_id ==$curriculum->id){
                                                                $selected="selected";
                                                            }else{
                                                                $selected="";
                                                            }
                                                        @endphp
                                                        <option {{$selected}} value="{{$curriculum->id}}" data-select2-id="{{$curriculum->id}}">{{$curriculum->title}}</option>
                                                        @endforeach
                                                    </select>
                                                <span class="text-danger error-text student_gender_error"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="gender" class="form-label required">Group</label>
                                                <select name="hsc_group" class="form-select rounded-3 shadow-none"
                                                    required style="padding: 14px 18px">
                                                    <option value="">Select Group</option>
                                                    <option value="Science" {{$hsc!=null && $hsc->group_or_major  === 'Science' ? 'selected' : '' }}>Science</option>
                                                    <option value="Commerce" {{$hsc!=null && $hsc->group_or_major  === 'Commerce' ? 'selected' : '' }}>Commerce</option>
                                                    <option value="Arts" {{$hsc!=null && $hsc->group_or_major  === 'Arts' ? 'selected' : '' }}>Arts</option>
                                                    {{-- <option value="Humanities" {{$hsc!=null && $hsc->group_or_major === 'humanities' ? 'selected' : '' }}>Humanities</option> --}}

                                                </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">Result</label>
                                                    <input name="hsc_result" type="text" value="{{ old('hsc_result', $hsc->gpa ?? '' )}}" class="form-control rounded-3 shadow-none"
                                                      required placeholder="e.g 3.5" style="padding: 14px 18px" />

                                                </div>

                                      </div>

                                      </div>
                                      <div class="mb-4 d-flex justify-content-end align-items-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                                    </div>



                                </div>








            </div>
        </div>
    </div>



    <div style="">
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 960px">

            {{-- <form action="" method="post" id="updateTutoringInfo">
                @csrf --}}

                <div class="">


                                <div class="card border-primary">

                                    <form action="{{route('admin.tutor.updateEducationalInfo')}}" method="post" id="updateHonoursEducationalInfo">
                                        @csrf

                                        <input type="hidden" name="gra_tutor_id" id="tutor_id" value="{{$tutor->id}}">


                                     <div class="card-header bg-success">
                                    Graduation / Bachelor / Diploma / Honours
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                          <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">Institute</label>
                                                    <br>
                                                    <select name="gra_institute_id" id="gra_institute_id" class="form-control select2-red rounded-3 shadow-none" style="width: 285px"
                                                        required style="padding: 14px 18px">
                                                        <option value="">Select Institute</option>
                                                        @foreach (App\Models\Institute::where('type', 'university')->OrderBy('title','asc')->get() as $institute)
                                                        @php
                                                            $selected="";
                                                            if($graduation !=null && $graduation->institute_id==$institute->id){
                                                                $selected="selected";
                                                            }else{
                                                                $selected="";
                                                            }
                                                        @endphp
                                                        <option {{$selected}} value="{{$institute->id}}">{{$institute->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">Study Type</label>
                                                    <select name="gra_study_id" class="form-select rounded-3 shadow-none"
                                                        required style="padding: 14px 18px">
                                                        <option value="">Select Study</option>


                                                        {{-- @foreach ($job->job_offer_tutor_study_types as $p_study)
                                                        <option value="{{$p_study->id}}" selected>{{$p_study->title ?? 'N/A'}}</option>
                                                        @endforeach --}}
                                                        @foreach (App\Models\Study::OrderBy('title','asc')->get() as $study)

                                                        @php
                                                        $selected="";
                                                        if($graduation !=null && $graduation->study_type_id == $study->id){
                                                            $selected="selected";
                                                        }else{
                                                            $selected="";
                                                        }
                                                        @endphp

                                                        <option {{$selected}} value="{{$study->id}}">{{$study->title}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">Semester/Year</label>
                                                    <select name="gra_passing_year" class="form-select rounded-3 shadow-none"
                                                    required style="padding: 14px 18px">
                                                    <option value="">Select Year</option>
                                                    <option value="First Year" {{$graduation !=null && $graduation->year_or_semester  === 'First Year' ? 'selected' : '' }}>First Year</option>
                                                    <option value="Second Year" {{$graduation !=null && $graduation->year_or_semester  === 'Second Year' ? 'selected' : '' }} >Second Year</option>
                                                    <option value="Third Year" {{$graduation !=null && $graduation->year_or_semester  === 'Third Year' ? 'selected' : '' }} >Third Year</option>
                                                    <option value="Fourth Year" {{$graduation !=null && $graduation->year_or_semester  === 'Fourth Year' ? 'selected' : '' }}>Fourth Year</option>
                                                    <option value="Fifth Year" {{$graduation !=null && $graduation->year_or_semester  === 'Fifth Year' ? 'selected' : '' }} >Fifth Year</option>
                                                    <option value="Graduation Completed" {{$graduation !=null && $graduation->year_or_semester  === 'Graduation Completed' ? 'selected' : '' }} >Graduation Completed</option>


                                              </select>
                                                </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label required">University Type</label>
                                                <select name="gra_university_type" class="form-select rounded-3 shadow-none select2" required style="padding: 14px 18px">

                                                        <option value="">Select University Type</option>
                                                        <option value="National University" {{$graduation !=null && $graduation->university_type  === 'National University' ? 'selected' : '' }}>National University</option>
                                                        <option value="Private University" {{$graduation !=null && $graduation->university_type  === 'Private University' ? 'selected' : '' }}>Private University</option>
                                                        <option value="Public University" {{$graduation !=null && $graduation->university_type  === 'Public University' ? 'selected' : '' }}>Public University</option>
                                                        <option value="7 college" {{$graduation !=null && $graduation->university_type  === '7 college' ? 'selected' : '' }}>7 college</option>
                                                        <option value="Public Medical" {{$graduation !=null && $graduation->university_type  === 'Public Medical' ? 'selected' : '' }}>Public Medical</option>
                                                        <option value="Private Medical" {{$graduation !=null && $graduation->university_type  === 'Private Medical' ? 'selected' : '' }}>Private Medical</option>
                                                        <option value="Mardasha" {{$graduation !=null && $graduation->university_type  === 'Mardasha' ? 'selected' : '' }}>Mardasha</option>
                                                        <option value="Polytechnic Institute" {{$graduation !=null && $graduation->university_type  === 'Polytechnic Institute' ? 'selected' : '' }}>Polytechnic Institute</option>
                                                        <option value="Other" {{$graduation !=null && $graduation->university_type  === 'Other' ? 'selected' : '' }}>Other</option>

                                                    </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="gender" class="form-label required">Department</label>
                                                <select name="gra_dept_id" class="form-select rounded-3 shadow-none"
                                                    required style="padding: 14px 18px">
                                                    <option value="">Select Group</option>
                                                    @foreach (App\Models\Department::OrderBy('title','asc')->get() as $department)

                                                    @php
                                                    $selected="";
                                                    if($graduation !=null && $graduation->department_id==$department->id){
                                                        $selected="selected";
                                                    }else{
                                                        $selected="";
                                                    }
                                                    @endphp


                                                    <option {{$selected}} value="{{$department->id}}">{{$department->title}}</option>
                                                        @endforeach
                                                </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label required">CGPA / current CGPA</label>
                                                    <input name="gra_result" type="text" value="{{ old('graduation_result', $graduation->gpa ?? '' )}}" class="form-control rounded-3 shadow-none"
                                                    id="result" placeholder="Enter name" style="padding: 14px 18px" />

                                                    <span class="text-danger error-text student_gender_error"></span>
                                                </div>
                                      </div>

                                      </div>
                                      <div class="mb-4 d-flex justify-content-end align-items-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                                    </div>

                                </div>

                                <div class="card border-primary">

                                    <form action="{{route('admin.tutor.updateEducationalInfo')}}" method="post" id="updateMastersEducationalInfo">
                                        @csrf

                                        <input type="hidden" name="post_gra_tutor_id" id="tutor_id" value="{{$tutor->id}}">


                                    <div class="card-header bg-success">
                                        Postgraduate / Masters

                                        <div class="custom-control custom-checkbox checkbox-lg align-middle">

                                            <input @if($post_graduation!=null)  @endif onchange="isGraduation()" type="checkbox" value="1" class="custom-control-input" name="has_masters" id="has_masters">
                                            <label class="custom-control-label" for="has_masters">If Applicable</label>


                                        </div>

                                        </div>

                                        <div class="card-body" id="postGraduationDiv" style="display: none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                          <label for="gender" class="form-label required">Institute</label>
                                                          <br>
                                                          <select name="post_gra_institute_id" id="post_gra_institute_id" class="form-control select2-red rounded-3 shadow-none" style="width: 285px"
                                                              required style="padding: 14px 18px">
                                                              <option value="">Select Institute</option>
                                                              @foreach (App\Models\Institute::where('type', 'university')->OrderBy('title','asc')->get() as $institute)
                                                              @php
                                                                  $selected="";
                                                                  if($post_graduation !=null && $post_graduation->institute_id==$institute->id){
                                                                      $selected="selected";
                                                                  }else{
                                                                      $selected="";
                                                                  }
                                                              @endphp
                                                              <option {{$selected}} value="{{$institute->id}}">{{$institute->title}}</option>
                                                              @endforeach
                                                          </select>
                                                          <span class="text-danger error-text student_gender_error"></span>
                                                      </div>
                                                      <div class="mb-3">
                                                          <label for="gender" class="form-label required">Study Type</label>
                                                          <select name="post_gra_study_id" class="form-select rounded-3 shadow-none"
                                                              required style="padding: 14px 18px">
                                                              <option value="">Select Study</option>


                                                              {{-- @foreach ($job->job_offer_tutor_study_types as $p_study)
                                                              <option value="{{$p_study->id}}" selected>{{$p_study->title ?? 'N/A'}}</option>
                                                              @endforeach --}}
                                                              @foreach (App\Models\Study::OrderBy('title','asc')->get() as $study)

                                                              @php
                                                              $selected="";
                                                              if($post_graduation !=null && $post_graduation->study_type_id==$study->id){
                                                                  $selected="selected";
                                                              }else{
                                                                  $selected="";
                                                              }
                                                              @endphp

                                                              <option {{$selected}} value="{{$study->id}}">{{$study->title}}</option>
                                                              @endforeach

                                                          </select>
                                                          <span class="text-danger error-text student_gender_error"></span>
                                                      </div>
                                                      <div class="mb-3">
                                                        <label for="gender" class="form-label required">Semester/Year</label>
                                                        <select name="post_gra_passing_year" class="form-select rounded-3 shadow-none"
                                                        required style="padding: 14px 18px">
                                                        <option value="">Select Year</option>
                                                        <option value="Post Graduation Running" {{$post_graduation !=null && $post_graduation->year_or_semester  === 'Post Graduation Running' ? 'selected' : '' }} >Post Graduation Running</option>
                                                        <option value="Post Graduation Completed" {{$post_graduation !=null && $post_graduation->year_or_semester  === 'Post Graduation Completed' ? 'selected' : '' }} >Post Graduation Completed</option>
                                                  </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label for="gender" class="form-label required">University Type</label>
                                                      <select name="post_gra_university_type" class="form-select rounded-3 shadow-none select2" required style="padding: 14px 18px">

                                                              <option value="">Select University Type</option>
                                                              <option value="National University" {{$post_graduation !=null && $post_graduation->university_type  === 'National University' ? 'selected' : '' }}>National University</option>
                                                              <option value="Private University" {{$post_graduation !=null && $post_graduation->university_type  === 'Private University' ? 'selected' : '' }}>Private University</option>
                                                              <option value="Public University" {{$post_graduation !=null && $post_graduation->university_type  === 'Public University' ? 'selected' : '' }}>Public University</option>
                                                              <option value="7 college" {{$post_graduation !=null && $post_graduation->university_type  === '7 college' ? 'selected' : '' }}>7 college</option>
                                                              <option value="Public Medical" {{$post_graduation !=null && $post_graduation->university_type  === 'Public Medical' ? 'selected' : '' }}>Public Medical</option>
                                                              <option value="Private Medical" {{$post_graduation !=null && $post_graduation->university_type  === 'Private Medical' ? 'selected' : '' }}>Private Medical</option>
                                                              <option value="Mardasha" {{$post_graduation !=null && $post_graduation->university_type  === 'Mardasha' ? 'selected' : '' }}>Mardasha</option>
                                                              <option value="Polytechnic Institute" {{$post_graduation !=null && $post_graduation->university_type  === 'Polytechnic Institute' ? 'selected' : '' }}>Polytechnic Institute</option>
                                                              <option value="Other" {{$post_graduation !=null && $post_graduation->university_type  === 'Other' ? 'selected' : '' }}>Other</option>

                                                          </select>
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="gender" class="form-label required">Department</label>
                                                      <select name="post_gra_dept_id" class="form-select rounded-3 shadow-none" required style="padding: 14px 18px">
                                                          <option value="">Select Group</option>
                                                          @foreach (App\Models\Department::OrderBy('title','asc')->get() as $department)

                                                          @php
                                                          $selected="";
                                                          if($post_graduation !=null && $post_graduation->department_id==$department->id){
                                                              $selected="selected";
                                                          }else{
                                                              $selected="";
                                                          }
                                                          @endphp


                                                          <option {{$selected}} value="{{$department->id}}">{{$department->title}}</option>
                                                              @endforeach
                                                      </select>
                                                      </div>
                                                      <div class="mb-3">
                                                        <label for="gender" class="form-label required">CGPA / current CGPA</label>
                                                        <input name="post_gra_result" type="text" value="{{ old('post_gra_result', $post_graduation->gpa ?? '')}}" class="form-control rounded-3 shadow-none"
                                                        required placeholder="Enter name" style="padding: 14px 18px" />

                                                        <span class="text-danger error-text student_gender_error"></span>
                                                    </div>
                                            </div>



                                          </div>
                                          <div class="mb-4 d-flex justify-content-end align-items-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                         </form>
                                        </div>
                                </div>




            </div>

        </div>
    </div>



</div>