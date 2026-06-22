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
    </style>
@endpush
@section('content')

    <div id="success"></div>
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
                        <span class="green-line"></span>
                    </div>
                </div>
                <p
                    class="money-text"
                    style="line-height: 10px; margin-left: 33px"
                >
                    33% complete
                </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">2</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="mx-2 t-link" style="font-size: 14px; font-weight: 400;line-height: 30px; margin-top: -5px;" href="{{ route('tutor.education_info') }}">
                            Education Information
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p
                    class="money-text"
                    style="line-height: 10px; margin-left: 33px"
                >
                    33% complete
                </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">3</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="mx-2 t-link" style="font-size: 14px; font-weight: 400;line-height: 30px; margin-top: -5px;" href="#">
                            Personal Information
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p class="money-text" style="line-height: 10px; margin-left: 33px">
                    33% complete
                </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">4</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a
                            class="mx-2 t-link"
                            style="
                      font-size: 14px;
                      font-weight: 400;
                      line-height: 30px;
                      margin-top: -5px;
                    "
                            href=" {{ route('tutor.crediantial') }}"
                        >
                            Crediantial
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p class="money-text" style="line-height: 10px; margin-left: 33px" >
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
                                    <p class="mx-2 mt-2" style=" font-size: 14px; font-weight: 400;line-height: 3px; ">Personal</p>
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
                                <span class="green-circle-text step green-circle"  style="height: 30px; width: 30px; padding-top: 2px">2</span>
                                <div   class="d-flex align-items-center justify-content-center"  >
                                    <p class="mx-2 mt-2" style=" font-size: 14px; font-weight: 400; line-height: 3px; " >  Parents details  </p>
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
                        <div id="step-3" class="gray-line-var"></div>

                        <div class="d-flex flex-column pt-2">
                            <div class="d-flex">
                                <span class="green-circle-text step green-circle"  style="height: 30px; width: 30px; padding-top: 2px">3</span>
                                <div class="d-flex align-items-center justify-content-center" >
                                    <p class="mx-2 mt-2"  style="
                            font-size: 14px;
                            font-weight: 400;
                            line-height: 3px;
                          " >  Socials  </p>
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
                        <div id="step-4"></div>

                        <div class="d-flex flex-column pt-2">
                            <div class="d-flex">
                                <span class="green-circle-text step green-circle"  style="height: 30px; width: 30px; padding-top: 2px">4</span>
                                <div  class="d-flex align-items-center justify-content-center"  >
                                    <p class="mx-2 mt-2"  style="
                            font-size: 14px;
                            font-weight: 400;
                            line-height: 3px;
                          " > Others </p>
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
                <div  class="data-entry mx-2 mt-4 mt-md-0 row tab" id="tab-1" >

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Blood Group </label>
                                <select id="blood_group" class="form-select chosen-select" aria-label="Default select example"required >
                                    <option value="">Choose...</option>
                                    <option value="A+" {{ ($tutor_personal_info->blood_group =='A+')? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ ($tutor_personal_info->blood_group =='A-')? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ ($tutor_personal_info->blood_group =='B+')? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ ($tutor_personal_info->blood_group =='B-')? 'selected' : '' }}>B-</option>
                                    <option value="O+" {{ ($tutor_personal_info->blood_group =='O+')? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ ($tutor_personal_info->blood_group =='O-')? 'selected' : '' }}>O-</option>
                                    <option value="AB+" {{ ($tutor_personal_info->blood_group =='AB+')? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ ($tutor_personal_info->blood_group =='AB-')? 'selected' : '' }}>AB-</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Religion </label>
                                <select id="religion" class="form-select chosen-select"  aria-label="Default select example" required>
                                    <option value="">Choose...</option>
                                    <option value="Islam" {{ ($tutor_personal_info->religion =='Islam')? 'selected' : '' }}>Islam</option>
                                    <option value="Hinduism" {{ ($tutor_personal_info->religion =='Hinduism')? 'selected' : '' }}>Hinduism</option>
                                    <option value="Christianity" {{ ($tutor_personal_info->religion =='Christianity')? 'selected' : '' }}>Christianity</option>
                                    <option value="Buddhism" {{ ($tutor_personal_info->religion =='Buddhism')? 'selected' : '' }}>Buddhism</option>
                                    <option value="Other" {{ ($tutor_personal_info->religion =='Other')? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="present_address" class="form-label">Present Address</label >
                                <input
                                    type="text"
                                    class="form-control chosen-select"
                                    id="present_address"
                                    value=" {{ ($tutor_personal_info->full_address != null)? $tutor_personal_info->full_address : '' }}"
                                    placeholder="Address"
                                />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="permanent_address" class="form-label"
                                >Parmanant Address</label  >
                                <input type="text"
                                       value=" {{ ($tutor_personal_info->permanent_full_address != null)? $tutor_personal_info->permanent_full_address : '' }}"
                                       class="form-control chosen-select" id="permanent_address" placeholder="Address" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nationality</label>
                                <select id="nationality" class="form-select"  aria-label="Default select example" required  >
                                    <option value="">Choose...</option>
                                    <option value="Bangladeshi" {{ ($tutor_personal_info->nationality =='Bangladeshi')? 'selected' : '' }}>Bangladeshi</option>
                                    <option value="American" {{ ($tutor_personal_info->nationality =='American')? 'selected' : '' }}>American</option>
                                    <option value="Indian" {{ ($tutor_personal_info->nationality =='Indian')? 'selected' : '' }}>Indian</option>
                                    <option value="Nepali" {{ ($tutor_personal_info->nationality =='Nepali')? 'selected' : '' }}>Nepali</option>
                                    <option value="Sri Lankan" {{ ($tutor_personal_info->nationality =='Sri Lankan')? 'selected' : '' }}>Sri Lankan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="date_of_birth" class="form-label" >Date of Birth </label>
                                <input
                                    type="date"
                                    class="form-control chosen-select"
                                    value="{{ ($tutor_personal_info->date_of_birth != null)? $tutor_personal_info->date_of_birth : '' }}"
                                    id="date_of_birth"
                                    placeholder="Date of Birth"
                                />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nid" class="form-label" >NID NO </label>
                                <input
                                    type="number"
                                    class="form-control chosen-select"
                                    value="{{ ($tutor_personal_info->nid_number != null)? $tutor_personal_info->nid_number : '' }}"
                                    id="nid"
                                    placeholder="NID"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center mt-4">
                        <button class="next-btn px-4 nextbtn" onclick="next(1,2)" {{ (is_active() != true) ? 'disabled':'' }}>  Next </button>
                    </div>
                </div>
                <!-- tab 1 ends -->
                <!-- tab 2 starts -->
                <div class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="father_name" class="form-label"
                                >Fathers Name</label >
                                <input
                                    type="text"
                                    class="form-control chosen-select"
                                    id="father_name"
                                    value=" {{ ($tutor_personal_info->fathers_name != null)? $tutor_personal_info->fathers_name : '' }}"
                                    placeholder="Fathers Name"
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="father_phone" class="form-label"
                                >Mother's Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control chosen-select"
                                    value="{{($tutor_personal_info->mothers_name != null)? $tutor_personal_info->mothers_name : ''}}"
                                    id="mother_name"
                                    placeholder="Mothers Name"
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="father_phone" class="form-label"
                                >Fathers Phone</label
                                >
                                <input
                                    type="number"
                                    class="form-control chosen-select"
                                    value="{{($tutor_personal_info->fathers_phone != null)? $tutor_personal_info->fathers_phone : ''}}"
                                    id="father_phone"
                                    placeholder="Phone "
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="mother_phone" class="form-label"
                                >Mothers Phone</label
                                >
                                <input
                                    type="number"
                                    class="form-control chosen-select"
                                    value="{{($tutor_personal_info->mothers_phone != null)? $tutor_personal_info->mothers_phone : ''}}"
                                    id="mother_phone"
                                    placeholder="Phone "
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="emargency_contact_name" class="form-label"
                                >Emergency Contact Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control chosen-select"
                                    id="emargency_contact_name"
                                    value="{{($tutor_personal_info->emargency_name != null)? $tutor_personal_info->emargency_name : ''}}"
                                    placeholder="Emargency name"
                                />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emargency_contact_phone" class="form-label"
                                >Emergency Contact Phone</label
                                >
                                <input
                                    type="number"
                                    class="form-control chosen-select"
                                    value="{{($tutor_personal_info->emargency_phone != null)? $tutor_personal_info->emargency_phone : ''}}"
                                    id="emargency_contact_phone"
                                    placeholder="Phone "
                                />
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center mt-4">
                        <div class="d-flex gap-1">
                            <button class="skip-btn px-3 py-0 mx-3 nextbtn" onclick="previous(2,1)"  >  Previous   </button>
                            <button   class="next-btn px-4 nextbtn" onclick="next(2,3)"> Next  </button>
                        </div>
                    </div>

                </div>
                <!-- tab 2 ends -->
                <!-- tab 3 starts -->
                <div class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-3" >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Facebook Link</label>
                                <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-facebook text-primary"></i>
                      </span>
                                    <input
                                        type="text"
                                        id="facebook_link"
                                        class="form-control"
                                        placeholder="Account Link"
                                        value=" {{ ($tutor_personal_info->facebook_link != null)? $tutor_personal_info->facebook_link : '' }}"
                                        aria-label="Account Link"
                                        aria-describedby="basic-addon1"
                                    />
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Linkedin Link</label>
                                <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-linkedin text-primary"></i>
                      </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="linkedin_link"
                                        placeholder="Account Link"
                                        value=" {{ ($tutor_personal_info->linkedin_link != null)? $tutor_personal_info->linkedin_link : '' }}"
                                        aria-label="Account Link"
                                        aria-describedby="basic-addon1"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Twitter Link</label>
                                <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-twitter text-primary"></i>
                      </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="twitter_link"
                                        placeholder="Account Link"
                                        value=" {{ ($tutor_personal_info->twitter_link != null)? $tutor_personal_info->twitter_link : '' }}"
                                        aria-label="Account Link"
                                        aria-describedby="basic-addon1"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Instagram Link</label>
                                <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-instagram text-primary"></i>
                      </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="instagram_link"
                                        placeholder="Account Link"
                                        value=" {{ ($tutor_personal_info->instagram_link != null)? $tutor_personal_info->instagram_link : '' }}"
                                        aria-label="Account Link"
                                        aria-describedby="basic-addon1"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-4">
                        <div class="d-flex gap-1">
                            <button class="skip-btn px-3 py-0 mx-3 nextbtn" onclick="previous(3,2)">  Previous </button>
                            <button  class="next-btn px-4 nextbtn" onclick="next(3,4)">   Next </button>
                        </div>
                    </div>
                </div>
                <!-- tab 3 ends -->
                <!-- tab 4 starts -->
                <div  class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-4"  >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="about_yourself" class="form-label"
                                >About Yourself
                                </label>
                                <textarea
                                    type="text"
                                    class="form-control chosen-select"
                                    id="about_yourself"
                                    placeholder="Write Something... "
                                    style="height: 200px"
                                >{{ ($tutor_personal_info->about_yourself != null)? $tutor_personal_info->about_yourself : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reason_hired" class="form-label"
                                >Reason To Be Getting Hired
                                </label>
                                <textarea
                                    type="text"
                                    class="form-control chosen-select"
                                    id="reason_hired"
                                    placeholder="Write Something... "
                                    style="height: 200px"
                                >{{ ($tutor_personal_info->reason_hired != null)? $tutor_personal_info->reason_hired : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="job_experience" class="form-label"
                                >Tution Job Experience
                                </label>
                                <textarea
                                    type="text"
                                    class="form-control chosen-select"
                                    id="job_experience"
                                    placeholder="Write Something... "
                                    style="height: 200px"
                                >{{ ($tutor_personal_info->tutoring_experience != null)? $tutor_personal_info->tutoring_experience : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="personal_opinion" class="form-label"
                                >Your Personal Opinion
                                </label>
                                <textarea
                                    type="text"
                                    class="form-control chosen-select"
                                    id="personal_opinion"
                                    placeholder="Write Something... "
                                    style="height: 200px"
                                >{{ ($tutor_personal_info->personal_opinion != null)? $tutor_personal_info->personal_opinion : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6"></div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4"  >
                        <div class="form-check my-3 my-md-0">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value="yes"
                                id="if_campus_ambassador"
                            />
                            <label class="form-check-label" for="if_campus_ambassador">
                                If Aplicable( Campus Ambassador Program)
                            </label>
                        </div>
                        <div class="d-flex gap-1">
                            <button class="skip-btn px-3 py-0 mx-3 nextbtn" onclick="previous(4,3)"> Previous  </button>
                            <button class="next-btn px-4 nextbtn" id="personalInfoSaveBtn">Save</button>
                        </div>
                    </div>
                </div>
                <!-- tab 4 ends -->

            </div>
        </div>
    </div>

    <!-- conent section ends -->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{------------------------------------ tutoring info save  ----------------------------------------}}
    <script type="text/javascript">
        // display tab option js
        $(".tab").css("display", "none");
        $("#tab-1").css("display", "block");

        function next(hideTab, showTab) {
            if (hideTab < showTab) { // If not press previous button
                // Validation if press next button

                var currentTab = 0;
                x = $('#tab-' + hideTab);
                y = $(x).find('input')
                for (i = 0; i < y.length; i++) {
                    if (y[i].value == '') {

                        // toastr.error('filap this field');
                        // toastr.options.timeOut = 500;
                        $(y[i]).css("background", "#ffdddd");
                        return false;
                    }
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
        //................ display tab option js end.............................


        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#personalInfoSaveBtn").on('click',function (){
                var blood_group     = $('#blood_group').val();
                var religion        = $('#religion').val();
                var nationality     = $('#nationality').val();
                var present_address = $('#present_address').val();
                var permanent_address  = $('#permanent_address').val();
                var nid             = $('#nid').val();
                var date_of_birth   = $('#date_of_birth').val();
                var father_name     = $('#father_name').val();
                var mother_name     = $('#mother_name').val();
                var father_phone    = $('#father_phone').val();
                var mother_phone    = $('#mother_phone').val();
                var emargency_contact_name      = $('#emargency_contact_name').val();
                var emargency_contact_phone     = $('#emargency_contact_phone').val();
                var facebook_link               = $('#facebook_link').val();
                var linkedin_link               = $('#linkedin_link').val();
                var twitter_link                = $('#twitter_link').val();
                var instagram_link              = $('#instagram_link').val();
                var about_yourself              = $('#about_yourself').val();
                var reason_hired                = $('#reason_hired').val();
                var job_experience              = $('#job_experience').val();
                var personal_opinion            = $('#personal_opinion').val();
                var if_campus_ambassador        = $('#if_campus_ambassador').val();

                $.ajax({
                    url:"{{ route('tutor.personal_info_save') }}",
                    type:"post",
                    data: {
                        name:name, gender:gender,blood_group:blood_group,nationality:nationality, religion:religion,  present_address:present_address,  permanent_address:permanent_address, nid:nid,date_of_birth:date_of_birth, phone:phone,
                        father_name:father_name, mother_name:mother_name, father_phone:father_phone,  mother_phone:mother_phone, emargency_contact_name:emargency_contact_name, emargency_contact_phone:emargency_contact_phone, facebook_link:facebook_link,
                        linkedin_link:linkedin_link, twitter_link:twitter_link, instagram_link:instagram_link,  about_yourself:about_yourself,  reason_hired:reason_hired,  job_experience:job_experience,  personal_opinion:personal_opinion,  if_campus_ambassador:if_campus_ambassador,

                    },
                    success:function (data){
                        console.log(data);
                        location.reload();
                        var myToast = toastr.success("Personal Info Update Successfully!",  {timeOut:2000});
                        $('#success').innerHTML= myToast;
                    },
                    error: function(data){
                        console.log(data);
                    }
                });


            })
        });
    </script>
    {{------------------------------------ tutoring info save End ----------------------------------------}}
    <script>
        $("#single").select2({
            placeholder: "Choose...",
            allowClear: true,
            width: "100%",
        });
        $("#multiple").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single2").select2({
            placeholder: "Choose...",
            allowClear: true,
            width: "100%",
        });
        $("#single4").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single5").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single6").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single7").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single8").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single9").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single10").select2({
            placeholder: "Choose... ",
            allowClear: true,
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
        $("#single13").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single14").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single15").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single16").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single17").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single18").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single19").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single20").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single21").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single22").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single23").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single24").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single25").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single26").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single27").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single28").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single29").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single30").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
    </script>
    <script>
        $(document).ready(function () {
            $("select.chosen-select").change(function () {
                let selectedItem = $(this).children("option:selected").val();
                $(".nextbtn").removeAttr("disabled");
            });
            $(".chosen-select").change(function () {
                let selectedItem = $(this).children("option:selected").val();
                $(".nextbtn").removeAttr("disabled");
            });
        });
    </script>
@endpush
