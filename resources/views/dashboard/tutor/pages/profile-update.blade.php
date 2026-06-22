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

         li[aria-selected=true] {
             display: none !important;
         }

    </style>
@endpush
@section('content')
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
                            <a class="mx-2 t-link" style="
                      font-size: 14px;
                      font-weight: 400;
                      line-height: 30px;
                      margin-top: -5px;
                    " href="#" >
                                Tutoring Information
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
                            <span class="green-circle-text">2</span>
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
                                href="{{ route('tutor.education_info') }}"
                            >
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
                            <a
                                class="mx-2 t-link"
                                style="
                      font-size: 14px;
                      font-weight: 400;
                      line-height: 30px;
                      margin-top: -5px;
                    "
                                href="{{ route('tutor.personal_info') }}"
                            >
                              Personal Information
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
                    <p
                        class="money-text"
                        style="line-height: 10px; margin-left: 33px"
                    >
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
                                        <p class="mx-2 mt-2" style=" font-size: 14px; font-weight: 400;line-height: 3px; ">Location</p>
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
                                        <p class="mx-2 mt-2" style=" font-size: 14px; font-weight: 400; line-height: 3px; " >  Tutoring Category  </p>
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
                            <div id="step-3" ></div>

                            <div class="d-flex flex-column pt-2">
                                <div class="d-flex">
                                    <span class="green-circle-text step green-circle"  style="height: 30px; width: 30px; padding-top: 2px">3</span>
                                    <div class="d-flex align-items-center justify-content-center" >
                                        <p class="mx-2 mt-2"  style="
                            font-size: 14px;
                            font-weight: 400;
                            line-height: 3px;
                          " >   Availableity  </p>

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

                    </div>
                </div>
                <div class="col-md-9">
                    <!-- tab 1 starts -->

                    <div class="data-entry mx-2 mt-4 mt-md-0 row tab" id="tab-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label">Country</label>
                                    <select id="country" class="js-states select2 country_name">
                                        <option value="">Choose Country...</option>
                                        @if(isset($countries))
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ ($tutor_info->tutor_personal_info->country_id == $country->id)? 'selected': '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">City</label>
                                    <select id="city" class="js-states select2 city_name">
                                        @if($tutor_info->tutor_personal_info->country_id != null)
                                            @foreach($cities as $city)

                                                <option value="{{ $city->id }}" {{ ($tutor_info->tutor_personal_info->city_id == $city->id)? 'selected': '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label">Location</label>
                                    <select id="location" class="js-states select2 location_name">
                                        @if($tutor_info->tutor_personal_info->city_id != null)
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{ ($tutor_info->tutor_personal_info->location_id == $location->id)? 'selected': '' }}>{{ $location->name }}</option>
                                            @endforeach
                                        @endif


                                    </select>
                                </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        $mlocation = [];
                                    foreach($preferred_locations as $preferred_location)
                                    {
                                        $mlocation[] = $preferred_location->location_id;
                                    }

                                    ?>
                                    <label class="form-label">Your preferred location</label>

                                    <select
                                        id="preferable_location"
                                        class="js-states select2 preferred_location form-control "
                                        multiple ="multiple">
                                        <?php
                                            if ($tutor_info->tutor_personal_info->city_id != null)
                                            {
                                        foreach ($locations as $location)
                                        {?>
                                        <option value="<?= $location->id;?>" <?= in_array($location->id,$mlocation)?  'selected': '';?>><?= $location->name;?></option>
                                            <?php
                                        }
                                            }


                                        ?>

                                    </select>
                                </div>
                            </div>
                            </div>

                        <div class="d-flex justify-content-end align-items-center mt-4">
                            <button class="next-btn px-4 nextbtn nextBtn1" onclick="next(1,2)" {{ (is_active() != true) ? 'disabled':'' }} > Next </button>
                        </div>
                    </div>
                    <!-- tab 1 ends -->
                    <!-- tab 2 starts -->
                    <div class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        $selectCategoies = [];
                                    foreach ($tutor_info->tutor_categories as $selectCategory)
                                    {
                                        $selectCategoies[] = $selectCategory->id;
                                    }
                                    ?>
                                    <label class="form-label">Your Preferred Tutoring Category</label>
                                    <select id="category" name="categories[]" class="js-states tutoring_category select2" multiple>
                                        <option value="">Choose...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" <?= in_array($category->id,$selectCategoies)? 'selected':''?>>{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    $selectcourses = [];
                                    foreach ($tutor_info->tutor_course as $selectcourse)
                                    {
                                        $selectcourses[] = $selectcourse->id;
                                    }
                                    ?>
                                    <label class="form-label">Your Prefrred Tutoring Classes and Course</label>
                                    <select id="tutoring_class_course" class="js-states select2 tutoring_class_course" multiple >
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" <?= in_array($course->id,$selectcourses)? 'selected':''?> >{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <?php
                                    $selectsubjects = [];
                                    foreach ($tutor_info->tutor_subject as $selectsubject)
                                    {
                                        $selectsubjects[] = $selectsubject->id;
                                    }
                                    ?>
                                    <label class="form-label">Select your Fovourite subject for Tutoring</label >
                                    <select id="favourite_subjects" class="js-states chosen-select favourite_subject" multiple  >
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" <?= in_array($subject->id,$selectsubjects)? 'selected':''?> >{{ $subject->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tutoring Experiense</label>
                                    <select id="single6" class="js-states chosen-select tutoring_experiense">
                                        <option value="">Choose...</option>
                                        @for($i =0 ; $i <= 25; $i++)
                                            <option value="{{ $i .' years' }}" {{ ($tutor_info->tutor_personal_info->tutoring_experience == $i .' years')? 'selected': '' }}><?php echo $i ." Years"?></option>
                                        @endfor

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label mt-4">Experiense Details</label>
                                    <textarea
                                        class="form-control experiense_details"
                                        placeholder="Write about your Experiense"
                                        id="floatingTextarea2"  >{{ ($tutor_info->tutor_personal_info->tutoring_experience_details)? $tutor_info->tutor_personal_info->tutoring_experience_details : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-4">
                            <button class="skip-btn px-3 py-0 mx-3 nextbtn"onclick="previous(2,1)"  >  Previous  </button>
                            <button class="next-btn px-4 nextbtn" onclick="next(2,3)"> Next  </button>
                        </div>
                    </div>
                    <!-- tab 2 ends -->
                    <!-- tab 3 starts -->
                    <div class="data-entry row mx-2 mt-4 mt-md-0 tab" id="tab-3" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <?php
                                    $tutor_days = [];
                                    foreach ($tutor_info->tutor_days as $tutor_day)
                                    {
                                        $tutor_days[] = $tutor_day->id;
                                    }
                                    ?>
                                    <label class="form-label">Available Day</label>
                                    <select id="day" class="js-states select2 available_day" multiple>
                                        <option value="">~select day ~ </option>
                                        @foreach($days as $day)
                                            <option value="{{ $day->id }}" <?= in_array($day->id,$tutor_days)? 'selected':''?> >{{ $day->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tutoring Experiense</label>
                                    <select id="single6" class="js-states chosen-select tutoring_experiense">
                                        <option value="">Choose...</option>
                                        @for($i =0 ; $i <= 25; $i++)
                                            <option value="{{ $i .' years' }}" {{ ($tutor_info->tutor_personal_info->tutoring_experience == $i .' years')? 'selected': '' }}><?php echo $i ." Years"?></option>
                                        @endfor

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label">Available Form</label>
                                    <input
                                        class="chosen-select form-control available_from"
                                        type="time" id="birthdaytime" name="birthdaytime" value="{{ ($tutor_info->tutor_personal_info->available_from)?$tutor_info->tutor_personal_info->available_from:'' }}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Available To</label>
                                    <input
                                        class="chosen-select form-control available_to"
                                        type="time" id="birthdaytime" name="birthdaytime"  value="{{ ($tutor_info->tutor_personal_info->available_to)? $tutor_info->tutor_personal_info->available_to :'' }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    $teaching_methods = [];
                                    foreach ($tutor_info->teaching_method as $tutor_teaching_method)
                                    {
                                        $teaching_methods[] = $tutor_teaching_method->id;
                                    }
                                    ?>
                                    <label class="form-label">Preferred Teaching Method</label>
                                    <select id="teaching_method" class="js-states chosen-select preferred_teaching_method" multiple>

                                        <option value="">Choose...</option>
                                        @foreach($tutor_teaching_methods as $tutor_teaching_method)
                                            <option value="{{$tutor_teaching_method->id}}"  <?= in_array($tutor_teaching_method->id,$teaching_methods)? 'selected':''?> >{{$tutor_teaching_method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="form-label " >Expected Salary</label  >
                                    <input
                                        type="number"
                                        class="form-control expected_salary"
                                        id="exampleFormControlInput1" value="{{ ($tutor_info->tutor_personal_info->expected_salary)?$tutor_info->tutor_personal_info->expected_salary:'' }}"
                                        placeholder="00.00"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-4">
                            <button class="skip-btn px-3 py-0 mx-3 nextbtn" onclick="previous(3,2)"> Previous   </button>
                                <button class="next-btn px-4" id="saveBtnTutoringInfo">Save</button>

                        </div>
                    </div>
                    <!-- tab 3 ends -->

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
            y = $(x).find('select')
            // for (i = 0; i < y.length; i++) {
            //     if (y[i].value == '') {
            //
            //         toastr.error('filap this field');
            //         toastr.options.timeOut = 500;
            //         // $(y[i]).css("background", "#ffdddd");
            //         return false;
            //     }
            // }
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

       $("#saveBtnTutoringInfo").on('click',function (){
           var country_name     = $('.country_name').val();
           var city_name        = $('.city_name').val();
           var location_name    = $('.location_name').val();
           var preferred_location = $('.preferred_location').val();
           var tutoring_category  = $('.tutoring_category').val();
           var favourite_subject  = $('.favourite_subject').val();
           var tutoring_experiense= $('.tutoring_experiense').val();
           var experiense_details = $('.experiense_details').val();
           var available_from     = $('.available_from').val();
           var available_to       = $('.available_to').val();
           var available_day       = $('.available_day').val();
           var preferred_teaching_method = $('.preferred_teaching_method').val();
           var expected_salary           = $('.expected_salary').val();
           var tutoring_class_course     = $('.tutoring_class_course').val();

           $.ajax({
              url:"{{ route('tutor.tutoring_info.save') }}",
              type:"post",
              data: {
                  country_name:country_name,
                  city_name:city_name,
                  location_name:location_name,
                  tutoring_experiense:tutoring_experiense,
                  experiense_details:experiense_details,
                  available_from:available_from,
                  available_to:available_to,
                  expected_salary:expected_salary,
                  available_day:available_day,
                  preferred_location:preferred_location,
                  tutoring_category:tutoring_category,
                  favourite_subject:favourite_subject,
                  preferred_teaching_method:preferred_teaching_method,
                  tutoring_class_course:tutoring_class_course


              },
              success:function (data){
                  console.log(data);
                  location.reload();
                  var myToast = toastr.success("Tutoring Info Update Successfully!",  {timeOut:1000});
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
        $('#city').select2({
            width: "100%",
        });
        $("#country").select2({
            width: "100%",
        });
        $("#location").select2({
            width: "100%",
        });
        $("#preferable_location").select2({
            width: "100%",
        });
        $("#category").select2({
            width: "100%",
        });
        $("#tutoring_class_course").select2({
            width: "100%",
        });
        $("#favourite_subjects").select2({
            width: "100%",
        });
        $("#day").select2({
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
        $("#teaching_method").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });
        $("#single9").select2({
            placeholder: "Choose... ",
            allowClear: true,
            width: "100%",
        });

// .............................Start get city and location...........................
        $(document).ready(function (){
            $('#country').change(function (){
                let c_id = $(this).val();
                $.ajax({
                    url:'{{route("get_city")}}',
                    type:'post',
                    data:'c_id='+c_id+'&_token={{ csrf_token() }}',
                    success:function (result){
                        $('#city').html(result);
                    }

                });
            });

            $('#city').change(function (){
                let city_id = $(this).val();
                $.ajax({
                    url:'{{route("get_location")}}',
                    type:'post',
                    data:'city_id='+city_id+'&_token={{ csrf_token() }}',
                    success:function (result){
                        $('#location').html(result);
                        $('#preferable_location').html(result);
                    }


                });
            });

            // .............................Start get Category and course...........................

            $('#category').change(function (){
                let category_id = $(this).val();
                // console.log(category_id);

                    $.ajax({
                        url:'{{route("get_class_course")}}',
                        type:'post',
                        data:{ category_id:category_id},
                        success:function (result){
                            $('#tutoring_class_course').html(result);

                        }

                    });
            });

            $('#tutoring_class_course').change(function (){
                let course_id = $(this).val();
                    $.ajax({
                        url:'{{route("get_course_subject")}}',
                        type:'post',
                        data:{ course_id:course_id},
                        success:function (result){
                             $('#favourite_subjects').html(result)

                        }

                    });
            });
        });

    </script>
    <script>
        $(document).ready(function () {
            $("select.chosen-select").change(function () {
                let selectedItem = $(this).children("option:selected").val();
                $(".nextbtn").removeAttr("disabled");
            });
        });
    </script>
@endpush
