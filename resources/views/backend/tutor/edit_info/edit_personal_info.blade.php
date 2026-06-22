
@if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif
{{-- <h5 style="text-align:center">personal info</h5> --}}
<div class="row row-cols-lg-2">
    <div style="">
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 1080px">

            <form action="{{route('admin.tutor.updatePersonalInfo')}}" method="post" id="updateTutoringInfo">
                @csrf

                <input type="hidden" name="tutor_id" id="tutor_id" value="{{$tutor->id}}">
                <div class="">

                    <div class="mb-3">
                        <label for="gender" class="form-label required">Gender</label>
                        <select name="gender" class="form-select rounded-3 shadow-none"
                            aria-label="Default select " id="gender" style="padding: 14px 18px">
                            <option value="">Select Gender</option>
                            <option value="male" {{ $tutor->gender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $tutor->gender === 'female' ? 'selected' : '' }}>Female</option>


                        </select>
                        <span class="text-danger error-text student_gender_error"></span>
                    </div>




                    <div class="mb-3">
                        <label for="spn" class="form-label">Present Full Address</label>
                        <i class="bi bi-geo-alt-fill text-info ms-1"></i>
                        <textarea name="full_address" id="full_address" class="form-control rounded-3 shadow-none" id="special_note"
                                                            style="
                                        overflow-y: scroll;
                                        resize: none;
                                        height: 65px;
                                    ">{{ old('full_address', $tutor->tutor_personal_info->full_address ?? 'N/A' ) }}

                                    </textarea>
                    </div>




                    <div class="mb-3">
                        <label for="nationality" class="form-label required">Nationality</label>
                        <select name="nationality" class="form-select rounded-3 shadow-none"
                            aria-label="Default select " id="nationality" style="padding: 14px 18px">
                            <option value="">Select </option>
                            <option value="Bangladeshi" {{ @$tutor->tutor_personal_info->nationality === 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi</option>
                            <option value="Pakistani"   {{ @$tutor->tutor_personal_info->nationality === 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                            <option value="Indian"      {{ @$tutor->tutor_personal_info->nationality === 'Indian' ? 'selected' : '' }}>Indian</option>
                            <option value="American"    {{ @$tutor->tutor_personal_info->nationality === 'American' ? 'selected' : '' }}>American</option>
                            <option value="Canadian"    {{ @$tutor->tutor_personal_info->nationality === 'Canadian' ? 'selected' : '' }}>Canadian</option>
                            <option value="Australian"  {{ @$tutor->tutor_personal_info->nationality === 'Australian' ? 'selected' : '' }}>Australian</option>
                            <option value="German"      {{ @$tutor->tutor_personal_info->nationality === 'German' ? 'selected' : '' }}>German</option>
                            <option value="Other"       {{ @$tutor->tutor_personal_info->nationality === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>

                            <span class="text-danger error-text number_of_students_error"></span>

                        </div>

                    <div class="mb-3">
                        <label for="salary" class="form-label required">National Identification Number</label>
                        <input name="nid_number" value="{{ old('nid_number', $tutor->tutor_personal_info->nid_number ?? 'Null') }}" type="number" class="form-control rounded-3 shadow-none"
                            id="nid_number" placeholder="" style="padding: 14px 18px" />
                            <span class="text-danger error-text salary_error"></span>

                    </div>


                    <div class="mb-3">
                        <label for="name" class="form-label">Father's Name</label>
                        <input name="fathers_name" value="{{ old('fathers_name', $tutor->tutor_personal_info->fathers_name ?? 'Null') }}" type="text" class="form-control rounded-3 shadow-none"
                            id="fathers_name" placeholder="Enter name" style="padding: 14px 18px" />
                    </div>

                    <div class="mb-3">
                        <label for="num1" class="form-label required">Father's Phone</label>
                        <input name="fathers_phone" id="fathers_phone"  type="number" value="{{ old('fathers_phone', $tutor->tutor_personal_info->fathers_phone ?? 'Null') }}" class="form-control rounded-3 shadow-none" id="phone"
                            placeholder="01658963122" style="padding: 14px 18px" />
                            <span class="text-danger error-text phone_error"></span>

                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Emergency Contact Name</label>
                        <input name="emergency_name" type="text" value="{{ old('emergency_name', $tutor->tutor_personal_info->emergency_name ?? 'N/A' ) }}
                        " class="form-control rounded-3 shadow-none"
                            id="student_name" placeholder="Enter name" style="padding: 14px 18px" />
                    </div>

                    <div class="mb-3">
                        <label for="num2" class="form-label">Emergency Contact Phone</label>
                        <input name="emergency_phone" type="text" value="{{ old('emergency_phone', $tutor->tutor_personal_info->emergency_phone ?? 'N/A' ) }}" class="form-control rounded-3 shadow-none" id="additional_phone"
                            placeholder="017..." style="padding: 14px 18px" />
                    </div>

                    <div class="mb-3">
                        <label for="staff" class="form-label required">About yourself</label>
                        <textarea  name="about_yourself" id="about_yourself" class="form-control rounded-3 shadow-none" id="staff_note"
                            style="
                        overflow-y: scroll;
                        resize: none;
                        height: 105px;
                        ">{{ old('about_yourself', $tutor->tutor_personal_info->about_yourself ?? 'N/A' ) }}

                        </textarea>

                       </div>
                       <div class="mb-3">
                        <label for="staff" class="form-label required">Reasons For Getting Hired</label>
                        <textarea   name="reason_hired"
                            class="form-control rounded-3 shadow-none" id="personal_opinion"
                            style="
                                overflow-y: scroll;
                                resize: none;
                                height: 75px;
                            ">{{ old('reason_hired', $tutor->tutor_personal_info->reason_hired ?? 'N/A' ) }}
                            </textarea>
                            <span class="text-danger error-text staff_note_error"></span>

                    </div>










            </div>
        </div>
    </div>
    <div>
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 1080px">

            <div class="mb-3">
                <label for="gender" class="form-label required">Blood Group</label>
                <select name="blood_group" class="form-select rounded-3 shadow-none"
                    aria-label="Default select " id="blood_group" style="padding: 14px 18px">
                    <option value="">Select Blood Group</option>
                    <option value="A+" {{ @$tutor->tutor_personal_info->blood_group  == 'A+' ? 'selected' : '' }} >A+</option>
                    <option value="A-"{{ @$tutor->tutor_personal_info->blood_group  == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+"{{ @$tutor->tutor_personal_info->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-"{{ @$tutor->tutor_personal_info->blood_group  == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="O+"{{ @$tutor->tutor_personal_info->blood_group  == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-"{{ @$tutor->tutor_personal_info->blood_group  == 'O-' ? 'selected' : '' }}>O-</option>
                    <option value="AB+"{{ @$tutor->tutor_personal_info->blood_group  == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-"{{ @$tutor->tutor_personal_info->blood_group  == 'AB-' ? 'selected' : '' }}>AB-</option>
                </select>
                <span class="text-danger error-text student_gender_error"></span>
            </div>

            <div class="mb-3">
                <label for="spn" class="form-label">Permanent Full Address</label>
                <i class="bi bi-geo-alt-fill text-info ms-1"></i>
                <textarea name="permanent_full_address" id="permanent_full_address" class="form-control rounded-3 shadow-none" id="special_note"
                                                    style="
                                overflow-y: scroll;
                                resize: none;
                                height: 65px;
                            ">{{ old('permanent_full_address', $tutor->tutor_personal_info->permanent_full_address ?? 'N/A' ) }}

                            </textarea>
            </div>
            <div class="mb-3">
                <label for="hire" class="form-label">Date of birth</label>
                <input  name="date_of_birth" type="date" value="{{ old('date_of_birth', $tutor->tutor_personal_info->date_of_birth ?? 'N/A' ) }}"
                " class="form-control rounded-3 shadow-none"
                    id="date" placeholder="Institute Name" style="padding: 14px 18px" />
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label required">Religion</label>
                <select name="religion" class="form-select rounded-3 shadow-none"
                    aria-label="Default select " id="religion" style="padding: 14px 18px">
                        <option value="">Select Religion</option>
                        <option value="islam" {{ @$tutor->tutor_personal_info->religion == 'islam' ? 'selected' : '' }}>Islam</option>
                        <option value="hinduism" {{ @$tutor->tutor_personal_info->religion  == 'hinduism' ? 'selected' : '' }}>Hinduism</option>
                        <option value="christianity" {{ @$tutor->tutor_personal_info->religion  == 'christianity' ? 'selected' : '' }}>Christianity</option>
                        <option value="buddhism" {{ @$tutor->tutor_personal_info->religion  == 'buddhism' ? 'selected' : '' }}>Buddhism</option>
                        <option value="other" {{ @$tutor->tutor_personal_info->religion  == 'other' ? 'selected' : '' }}>Other</option>
                       </select>
                <span class="text-danger error-text student_gender_error"></span>
            </div>


            <div class="mb-3">
                <label for="name" class="form-label">Facebook Profile Link</label>
                <input name="facebook_link" type="text" value="{{ old('facebook_link', $tutor->tutor_personal_info->facebook_link ?? 'N/A' ) }}" class="form-control rounded-3 shadow-none"
                    id="facebook_link" placeholder="Enter name" style="padding: 14px 18px" />
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Mother's Name</label>
                <input name="mothers_name" type="text" value="{{ old('mothers_name', $tutor->tutor_personal_info->mothers_name ?? 'N/A' ) }}" class="form-control rounded-3 shadow-none"
                    id="mothers_name" placeholder="Enter name" style="padding: 14px 18px" />
            </div>

            <div class="mb-3">
                <label for="num1" class="form-label required">Mother's Phone</label>
                <input name="mothers_phone" type="text" value="{{ old('mothers_phone', $tutor->tutor_personal_info->mothers_phone ?? 'N/A' ) }}" class="form-control rounded-3 shadow-none" id="phone"
                    placeholder="01658963122" style="padding: 14px 18px" />
                    <span class="text-danger error-text phone_error"></span>

            </div>

            <div class="mb-3">
                <label for="staff" class="form-label required">Tuition Job Experience</label>
                <textarea   name="tutoring_experience_details"
                    class="form-control rounded-3 shadow-none" id="tutoring_experience_details"
                    style="
                        overflow-y: scroll;
                        resize: none;
                        height: 75px;
                    ">{{ old('tutoring_experience_details', $tutor->tutor_personal_info->tutoring_experience_details ?? 'N/A') }}"

                    </textarea>
                    <span class="text-danger error-text staff_note_error"></span>

            </div>
            <div class="mb-3">
                <label for="spn" class="form-label">Personal Opinion</label>
                <textarea name="personal_opinion" class="form-control rounded-3 shadow-none" id="special_note"
                    style="
            overflow-y: scroll;
            resize: none;
            height: 105px;
            ">{{ old('personal_opinion', $tutor->tutor_personal_info->personal_opinion ?? 'N/A' ) }}
            </textarea>
            </div>




            {{-- <div class="mb-3">
                <label for="gender" class="form-label required">Campaigner Code</label>
                <select name="campaigner_code" class="form-select rounded-3 shadow-none"
                    aria-label="Default select " id="student_gender" style="padding: 14px 18px">
                    <option data-select2-id="951">Select Campaigner Code</option>
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
                <span class="text-danger error-text student_gender_error"></span>
            </div>  --}}



            <br>
            <br>

            <div class="mb-4 d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary">Save Change</button>
            </div>

        </form>
        </div>
    </div>
</div>



