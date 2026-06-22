@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')

<!-- sidebar ends here -->
<main class="">
    <div class="col-lg-12 ms-sm-auto col-lg-12 px-3" style="margin-top: 62px">
        <!-- tab like button group (it should be tab) -->
        <div class="pt-4 row row-cols-2">
            <div>
                <a href="{{route('admin.view.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid white;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">View</a>
            </div>
            <div>
                <a href="{{route('admin.edit.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid #669ad1;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">Edit</a>
            </div>
        </div>
        <!-- tab like button group ends -->
        <!-- contents starts here -->
        <div class="row gx-1 gx-lg-4 my-lg-4 mt-4 mt-lg-4">
            <div class="col-12 col-xl-3 col-lg-4">
                <div class="bg-white rounded-3 shadow-lg" style="max-height: 400">
                    <ul class="ps-0 d-flex flex-lg-column justify-content-between px-2">
                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link  d-none d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent',$parent->id)}}">
                                <i class="bi bi-person-fill mx-2"></i>Sign-up
                                Information
                            </a>
                            <a class="t-link d-lg-none d-block" href="{{route('admin.edit.parent',$parent->id)}}">
                                <i class="bi bi-person-fill mx-2 fs-1"></i>
                            </a>
                        </li>

                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link d-none text-primary d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent.other.info',$parent->id)}}">
                                <i class="bi bi-person-vcard-fill mx-2"></i>Others
                                Information
                            </a>
                            <a class="t-link d-lg-none d-block"
                                href="{{route('admin.edit.parent.other.info',$parent->id)}}">
                                <i class="bi bi-bell-fill mx-2 fs-1"></i>
                            </a>
                        </li>

                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link d-none d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent.password',$parent->id)}}">
                                <i class="bi bi-shield-lock-fill mx-2"></i>Password &
                                Security
                            </a>
                            <a class="t-link d-lg-none d-block" href="{{route('admin.edit.parent.password',$parent->id)}}">
                                <i class="bi bi-shield-lock-fill mx-2 fs-1"></i>
                            </a>
                        </li>

                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link d-none d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent.account.status',$parent->id)}}">
                                <i class="bi bi-gear-fill mx-2"></i>Accounts Status
                            </a>
                            <a class="t-link d-lg-none d-block" href="{{route('admin.edit.parent.account.status',$parent->id)}}">
                                <i class="bi bi-gear-fill mx-2 fs-1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-xl-9 col-lg-8">
                <!-- settings content starts here -->

                <div class="bg-white shadow-lg rounded-3 p-4 mb-4">
                    <div class="m-2">
                        <h4 class="m-0 text-center mb-5">Contact Information</h4>
                        <form id="personalDetailsForm">
                            @csrf
                            <div class="row row-cols-lg-2 gap-4 gap-lg-0 mb-4">
                                <div class="border-end pe-lg-5">
                                    <label for="cun" class="form-label required">Country</label>
                                    <select name="country_id" class="form-select rounded-3 shadow-none"
                                        id="country_id" style="padding: 14px 18px">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                        <option value="{{$country->id}}" @if ($parent->parents_personalInfo->country_id == $country->id)
                                            selected
                                        @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text country_id_error"></span>
                                </div>
                                <div class="ps-lg-5">
                                    <label class="mb-2 form-label dark-semibold-label">Additional Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white rounded-start" id="adp-addon">
                                            <i class="bi bi-telephone-plus-fill text-primary"></i>
                                        </span>
                                        <input type="text" name="additional_phone" value="{{ old('additional_phone', $parent->parents_personalInfo->additional_phone ?? '') }}"
                                            class="form-control rounded-end shadow-none input-lg"
                                            placeholder="Enter your number" />
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-lg-2 gap-4 gap-lg-0 mb-4">
                                <div class="border-end pe-lg-5">
                                    <label for="city" class="form-label required">City</label>
                                    <select name="city_id" class="form-select rounded-3 shadow-none"
                                        id="city_id" style="padding: 14px 18px">
                                        @foreach ($cities as $city)
                                        <option value="{{$city->id}}" @if ($parent->parents_personalInfo->city_id == $city->id)
                                            selected
                                        @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text city_id_error"></span>
                                </div>
                                <div class="ps-lg-5">
                                    <label class="mb-2 form-label dark-semibold-label">Whatsapp Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white rounded-start" style="color: #25d366">
                                            <i class="bi bi-whatsapp"></i>
                                        </span>
                                        <input type="text" name="whats_up_phone" value="{{ old('whats_up_phone', $parent->parents_personalInfo->whats_up_phone ?? '') }}"
                                            class="form-control rounded-end shadow-none input-lg"
                                            placeholder="Enter your number" />
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-lg-2 gap-4 gap-lg-0 mb-4">
                                <div class="border-end pe-lg-5">
                                    <label for="loc" class="form-label required">Location</label>
                                            <select name="location_id" class="form-select rounded-3 shadow-none"
                                                aria-label="Default select " id="location_id" style="padding: 14px 18px">

                                                @foreach ($locations as $location)
                                                <option value="{{$location->id}}" @if ($parent->parents_personalInfo->location_id == $location->id)
                                                    selected
                                                @endif>{{$location->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text location_id_error"></span>
                                </div>
                                <div class="ps-lg-5">
                                    <label class="mb-2 form-label dark-semibold-label">
                                        Facebook Profile Link
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white rounded-start" id="facebook_profile"
                                            style="color: #1877f2">
                                            <i class="bi bi-facebook"></i>
                                        </span>
                                        <input type="text" id="facebook_profile" name="facebook_profile" value="{{ old('facebook_profile', $parent->parents_personalInfo->facebook_profile ?? '') }}"
                                            class="form-control rounded-end shadow-none input-lg"
                                            placeholder="Enter your profile" />
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-lg-2 gap-4 gap-lg-0">
                                <div class="border-end pe-lg-5">
                                    <label for="address_details" class="form-label dark-semibold-label">Address Details</label>
                                    <textarea class="form-control shadow-none rounded-2" name="address_details"
                                        rows="3" placeholder="Maximum 200 characters">{{ old('address_details', $parent->parents_personalInfo->address_details ?? '') }}</textarea>
                                </div>
                                <div class="ps-lg-5">
                                    <label for="personal_opinion" class="form-label dark-semibold-label">Your Personal Opinion</label>
                                    <textarea class="form-control shadow-none rounded-2" name="personal_opinion"
                                        rows="3" placeholder="Maximum 300 characters">{{ old('personal_opinion', $parent->parents_personalInfo->personal_opinion ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end pt-4 mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>



                <div class="bg-white shadow-lg rounded-3 p-4 mb-4">
                    <div class="m-2">
                        <h4 class="m-0 text-center mb-5">Personal Information</h4>
                        <form id="personalInfoForm">
                            @csrf
                            <div class="row row-cols-lg-2 gap-4 gap-lg-0 mb-4">
                                <div class="border-end pe-lg-5">
                                    <label class="form-label dark-semibold-label">Gender</label>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" value="male" id="male" @if ($parent->parents_personalInfo->gender == 'male')
                                            checked
                                            @endif/>
                                            <label class="form-check-label" for="male"> Male </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" value="female" id="female" @if ($parent->parents_personalInfo->gender == 'female')
                                            checked
                                            @endif />
                                            <label class="form-check-label" for="female"> Female </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="ps-lg-5">
                                    <label class="form-label dark-semibold-label">Date Of Birth</label>
                                    <input type="date" name="date_of_birth"
                                           class="form-control shadow-none rounded-2 input-lg"
                                           value="{{ optional($parent->parents_personalInfo)->date_of_birth }}" />
                                </div>

                            </div>
                            <div class="row row-cols-lg-2 gap-4 gap-lg-0">
                                <div class="border-end pe-lg-5">
                                    <label class="form-label dark-semibold-label">Profession</label>
                                    <select class="form-select shadow-none rounded-2 input-lg" name="profession">
                                        <option value="">Select your profession</option>
                                        <option value="student" {{ $parent->parents_personalInfo->profession == 'student' ? 'selected' : '' }}>Student</option>
                                        <option value="teacher" {{ $parent->parents_personalInfo->profession == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                        <option value="doctor" {{ $parent->parents_personalInfo->profession == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                        <option value="engineer" {{ $parent->parents_personalInfo->profession == 'engineer' ? 'selected' : '' }}>Engineer</option>
                                        <option value="housewife" {{ $parent->parents_personalInfo->profession == 'housewife' ? 'selected' : '' }}>Housewife</option>
                                        <option value="job holder" {{ $parent->parents_personalInfo->profession == 'job holder' ? 'selected' : '' }}>Job Holder</option>
                                        <option value="businessman" {{ $parent->parents_personalInfo->profession == 'businessman' ? 'selected' : '' }}>Businessman</option>
                                        <option value="freelancer" {{ $parent->parents_personalInfo->profession == 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                                        <option value="lawyer" {{ $parent->parents_personalInfo->profession == 'lawyer' ? 'selected' : '' }}>Lawyer</option>
                                        <option value="others" {{ $parent->parents_personalInfo->profession == 'others' ? 'selected' : '' }}>Others</option>
                                    </select>




                                </div>
                                <div class="ps-lg-5">
                                    <label class="form-label dark-semibold-label">How did You know about us?</label>
                                    <select class="form-select shadow-none rounded-2 input-lg" name="about_us">
                                        <option value="">Select your about us?</option>
                                        <option value="facebook" {{ $parent->parents_personalInfo->about_us == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                        <option value="google" {{ $parent->parents_personalInfo->about_us == 'google' ? 'selected' : '' }}>Google</option>
                                        <option value="newspaper" {{ $parent->parents_personalInfo->about_us == 'newspaper' ? 'selected' : '' }}>Newspaper</option>
                                        <option value="friends" {{ $parent->parents_personalInfo->about_us == 'friends' ? 'selected' : '' }}>Friends</option>
                                        <option value="relatives" {{ $parent->parents_personalInfo->about_us == 'relatives' ? 'selected' : '' }}>Relatives</option>
                                        <option value="word of mouth" {{ $parent->parents_personalInfo->about_us == 'word of mouth' ? 'selected' : '' }}>Word of Mouth</option>
                                        <option value="television" {{ $parent->parents_personalInfo->about_us == 'television' ? 'selected' : '' }}>Television</option>
                                        <option value="radio" {{ $parent->parents_personalInfo->about_us == 'radio' ? 'selected' : '' }}>Radio</option>
                                        <option value="billboard" {{ $parent->parents_personalInfo->about_us == 'billboard' ? 'selected' : '' }}>Billboard</option>
                                        <option value="others social media" {{ $parent->parents_personalInfo->about_us == 'others social media' ? 'selected' : '' }}>Others Social Media</option>
                                        <option value="others" {{ $parent->parents_personalInfo->about_us == 'others' ? 'selected' : '' }}>Others</option>
                                    </select>


                                </div>
                            </div>
                            <div class="d-flex justify-content-end pt-4 mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>



                <div class="bg-white shadow-lg rounded-3 p-4 mb-4">
                    <div class="m-2">
                        <h4 class="m-0 text-center mb-5">Kids Information</h4>
                        <form id="kidsInfoForm">
                            @csrf
                            <div>
                                <div class="row row-cols-lg-2 gap-4 gap-lg-0 mb-4">
                                    <div class="border-end pe-lg-5">
                                        <label class="form-label dark-semibold-label">Number Of Children</label>
                                        <select class="form-select shadow-none rounded-2 input-lg" name="children_number">
                                            <option value="3" {{ $parent->parents_personalInfo->children_number == '3' ? 'selected' : '' }}>3</option>
                                            <option value="2" {{ $parent->parents_personalInfo->children_number == '2' ? 'selected' : '' }}>2</option>
                                            <option value="1" {{ $parent->parents_personalInfo->children_number == '1' ? 'selected' : '' }}>1</option>
                                        </select>
                                    </div>
                                    <div class="ps-lg-5">
                                        <label class="form-label dark-semibold-label">Class</label>
                                        <select id="course_id" class="form-select shadow-none rounded-2 input-lg" name="class">
                                            <option value="">Select Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->name }}" {{ $parent->parents_personalInfo->class == $course->name ? 'selected' : '' }}>{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-cols-lg-2 gap-4 gap-lg-0">
                                    <div class="border-end pe-lg-5">
                                        <label class="form-label dark-semibold-label">Category</label>
                                        <select id="category_id" class="form-select shadow-none rounded-2 input-lg" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $parent->parents_personalInfo->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ps-lg-5">
                                        <label class="form-label dark-semibold-label">Institute Name</label>
                                        <select class="form-select shadow-none rounded-2 input-lg" name="institute_name">
                                            <option value="">Select Institute</option>
                                            @foreach ($institutes as $institute)
                                                <option value="{{ $institute->title }}" {{ $parent->parents_personalInfo->institute_name == $institute->title ? 'selected' : '' }}>{{ $institute->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end pt-4 mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>



                <!-- settings content ends here -->
            </div>
        </div>
        <!-- contents ends here -->
    </div>
</main>
@endsection
@push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('backend.job_offers.js.add_offer_page_js')

<script>
    $(document).ready(function () {
        $('#personalDetailsForm').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let parentId = '{{ $parent->id }}';

        $.ajax({
            url: `/admin/parent/personal-details/${parentId}`,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $('span.error-text').text('');
            },
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Details updated successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Something went wrong!',
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else if (xhr.status === 404) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Not Found',
                        text: 'Parent record not found.',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again.',
                    });
                }
            }
        });
    });

});

</script>

<script>
    $(document).ready(function () {
        $('#personalInfoForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let parentId = '{{ $parent->id }}';

            $.ajax({
                url: `/admin/parent/contact-info/${parentId}`,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Information updated successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message || 'Something went wrong!',
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred. Please try again.',
                        });
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#kidsInfoForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let parentId = '{{ $parent->id }}';

            $.ajax({
                url: `/admin/parent/kid-info/${parentId}`,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Kids information updated successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: value[0],
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred. Please try again.',
                        });
                    }
                }
            });
        });
    });
</script>

@endpush
