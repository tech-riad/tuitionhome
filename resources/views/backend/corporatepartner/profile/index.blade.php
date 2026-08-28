@extends('layouts.app')

@push('page_css')
<style>
    body {
        background-color: #f8f9fa;
    }

    .table-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-approved {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-cancel {
        background-color: #f8d7da;
        color: #842029;
    }

</style>
@endpush


@section('content')
<main class="container-custom">
    @include('backend.corporatepartner.menu')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    
                    <h3 class="fw-bold mb-0 ">
                        {{ $totalProfile }}
                    </h3>
                    <h6 class="text-muted">Total Profiles</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- Total Approved --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="fw-bold text-success mb-0">
                        {{ $activeProfile }}
                    </h3>
                    <h6 class="text-muted">Active Profiles</h6>
                </div>
            </div>
        </div>

        {{-- Total Cancel --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="fw-bold text-danger mb-0">
                        {{ $inactiveProfile }}
                    </h3>
                    <h6 class="text-muted">Inactive Profiles</h6>
                </div>
            </div>
        </div>

        {{-- Total Pending --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="fw-bold text-warning mb-0">
                        {{ $maleProfile }}
                    </h3>
                    <h6 class="text-muted">Male Profiles</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="fw-bold text-info mb-0">
                        {{ $femaleProfile }}
                    </h3>
                    <h6 class="text-muted">Female Profiles</h6>
                </div>
            </div>
        </div>

    </div>
    <div class="ps-3" style="padding-right: 13px">

        <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
            <div class="d-flex justify-content-between gap-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    <i class="bi bi-sliders2 me-1"></i>Filter
                </button>
                <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>

                <!-- Filter model starts here -->
                <div class="modal fade font-pop" id="exampleModal" tabindex="" aria-labelledby="">
                    <div class="modal-dialog modal-dialog-centered px-3" style="max-width: 1100px">
                        <div class="modal-content pt-4 pb-4 ps-2">
                            <div class="modal-header pe-5" style="padding-left: 40px">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Filter
                                    <span class="text-muted fw-light" style="font-size: 12">
                                    </span>
                                </h1>

                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-0">
                                <div class="row row-cols-2 row-cols-lg-4 pb-2 ps-4">
                                    <div class="d-flex">
                                        <div>
                                            <div class="pb-3">
                                                <label for="datef" class="form-label">Date from</label>
                                                <div>
                                                    <input type="date" class="form-control shadow rounded-2" id="datef"
                                                        onchange="inputChange('created_at >=', this.id)" />
                                                </div>
                                            </div>
                                            <div class="pb-3">
                                                <label for="datet" class="form-label">Date To</label>
                                                <input type="date" class="form-control shadow rounded-2" id="datet"
                                                    onchange="inputChange('created_at <=', this.id)" />
                                            </div>
                                            <div class="pb-3">
                                                <label for="crby" class="form-label">Created By</label>

                                                <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('created_by',this.id)" id="user_id">
                                                    <option value="">Select Employee</option>


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
                                                <label for="cun" class="form-label ">Country</label>
                                                <select name="country_id" class="form-select rounded-3 shadow-none "
                                                    aria-label="Default select " id="country_id"
                                                    onchange="inputChange('country_id',this.id)">
                                                    <option value="">Select Country</option>
                                                    @foreach (App\Models\Country::OrderBy('name','asc')->get() as
                                                    $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text country_id_error"></span>

                                            </div>

                                            <div class="pb-3">
                                                <label for="cty" class="form-label">City</label>
                                                <br>
                                                <select name="city_id" id="city_id" style="width: 215px"
                                                    class="shadow rounded-2 form-select"
                                                    onchange="inputChange('city_id',this.id)"
                                                    aria-label="Default select example">
                                                    <option selected>Select city</option>


                                                </select>

                                            </div>
                                            <div class="pb-3">
                                                <label for="loc" class="form-label">Location</label>
                                                <br>
                                                <select id="location_id" name="location_id" style="width: 215px"
                                                    class="form-select rounded-3 shadow-none"
                                                    onchange="inputChange('location_id',this.id)"
                                                    aria-label="Default select example">
                                                    <option selected>Select Location</option>

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
                                                <label for="category_id" class="form-label ">Category</label>
                                                <select name="category_id" id="category_id"
                                                    class="form-select rounded-3 shadow-none" style="width: 215px"
                                                    onchange="inputChange('category_id',this.id)">
                                                    <option value="">Select Category</option>
                                                    @foreach(App\Models\Category::OrderBy('created_at','desc')->get() as
                                                    $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text category_id_error"></span>
                                            </div>



                                            <div class="pb-3">
                                                <label for="course_id" class="form-label ">Course</label>
                                                <select name="course_id" class="form-select rounded-3 shadow-none"
                                                    onchange="inputChange('course_id',this.id)" id="course_id"
                                                    style="width: 215px">

                                                </select>
                                                <span class="text-danger error-text course_id_error"></span>

                                            </div>
                                            <div class="pb-3">
                                                <label for="subject_id" class="form-label ">Subjects</label>
                                                <select name="subject_id" class="form-select rounded-3 shadow-none"
                                                    id="subject_id" style="width: 215px">

                                                </select>
                                                <span class="text-danger error-text subject_id_error"></span>

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
                                                <label for="am" class="form-label">Source</label>

                                                <select id="am" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected>Affiliate Marcketing</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="pb-3">
                                                <label for="srcid" class="form-label">Source ID</label>

                                                <select id="srcid" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected>23456</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="pb-3">
                                                <label for="tm" class="form-label">Tutoring Method</label>

                                                <select id="tm" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example"
                                                    onchange="inputChange('teaching_method_id',this.id)">
                                                    @foreach (App\Models\TeachingMethod::OrderBy('name','asc')->get() as
                                                    $teachingM)

                                                    <option value="{{$teachingM->id}}">{{$teachingM->name}}</option>

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
                                                    <label for="salary" class="form-label">Salary</label>

                                                    <input type="text" class="form-control shadow rounded-2" id="salary"
                                                        onchange="inputChange('salary',this.id)" placeholder="5000" />
                                                </div>
                                                <div class="pb-3">
                                                    <label for="channel" class="form-label">Channel</label>

                                                    <select id="channel" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example">
                                                        <option selected>Website</option>
                                                        <option value="1">Facebook</option>
                                                        <option value="2">Twitter</option>
                                                        <option value="3">Three</option>
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
                                                    <label for="genderr" class="form-label">
                                                        Gender Requirement
                                                    </label>

                                                    <select id="genderr" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('tutor_gender',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="others">others</option>

                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="daw" class="form-label">Days and Week</label>

                                                    <select id="days_in_week" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('days_in_week',this.id)"
                                                        aria-label="Default select example">

                                                        <option value="">Select Days</option>
                                                        <option value="2">2 days</option>
                                                        <option value="3">3 days</option>
                                                        <option value="4">4 days</option>
                                                        <option value="5">5 days</option>
                                                        <option value="6">6 days</option>
                                                        <option value="7">7 days</option>


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
                                                    <label for="sgender" class="form-label">Student Gender</label>

                                                    <select id="sgender" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('student_gender',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Gender</option>
                                                        <option selected>Male</option>
                                                        <option value="1">Female</option>
                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="rel" class="form-label">Religion</label>

                                                    <select id="rel" class="shadow rounded-2 form-select"
                                                        onchange="inputChange('tutor_religion',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Religion</option>
                                                        <option value="islam">Islam</option>
                                                        <option value="hindu">Hindu</option>
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
                                                    <label for="in" class="form-label">
                                                        Institute Name
                                                    </label>
                                                    <select class="shadow rounded-2 form-select" style="width: 215px"
                                                        id="institute_id"
                                                        onchange="inputChange('institute_name',this.id)"
                                                        aria-label="Default select example">
                                                        <option value="">Select Institute</option>

                                                        @foreach (App\Models\Institute::where('type',
                                                        'school')->orWhere('type', 'school and
                                                        college')->OrderBy('title','asc')->get() as $institute)

                                                        <option value="{{$institute->title}}">{{$institute->title}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="hoffer" class="form-label">Hide Offer</label>

                                                    <select id="hoffer" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example">
                                                        <option selected>Hide</option>
                                                        <option value="1">Nothing</option>
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
                                    <a data-toggle="collapse" href="#collapseExample" role="button"
                                        aria-expanded="false" aria-controls="collapseExample" class="mb-0">
                                        <i class="bi bi-caret-down-fill"></i>
                                    </a>
                                </div>
                                <form action="{{route('admin.job.search')}}" method="post">
                                    @csrf
                                    <div>
                                        <button type="button" class="btn btn-danger py-1 me-2">
                                            Clear
                                        </button>



                                        <input type="hidden" id="job_search" name="job_search" value="">

                                        <button type="submit" class="btn btn-primary py-1">
                                            Apply
                                        </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter Model ends here -->

            </div>

        </div>





        <div class="d-flex gap-3">

            <form action="{{route('admin.job.search-single-all')}}" method="post">
                @csrf
                <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                    style="border: 1px solid #cfdfdb">

                    <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                        placeholder="Search" style="padding: 12px 18px" id="">
                    <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
                </div>


            </form>






            <form id="paginationLimitForm">
                <select id="cpprofile" name="pagination_limit" class="form-select rounded"
                    style="width: 100px">

                    <option value="1" {{ $paginationLimit == 30 ? 'selected' : '' }}>
                        30
                    </option>

                    <option value="50" {{ $paginationLimit == 50 ? 'selected' : '' }}>
                        50
                    </option>

                    <option value="100" {{ $paginationLimit == 100 ? 'selected' : '' }}>
                        100
                    </option>

                    <option value="200" {{ $paginationLimit == 200 ? 'selected' : '' }}>
                        200
                    </option>

                    <option value="400" {{ $paginationLimit == 400 ? 'selected' : '' }}>
                        400
                    </option>

                    <option value="500" {{ $paginationLimit == 500 ? 'selected' : '' }}>
                        500
                    </option>

                </select>
            </form>





        </div>
    </div>


    <div class=" my-5">
        <div class="card table-card p-3">
            <div class="table-responsive">
                <div id="requestsTable">
                    @include('backend.corporatepartner.partials.partner_table')
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="d-flex justify-content-end mt-3">
        {{ $requests->links() }}
    </div> --}}

</main>

@endsection
@push('page_scripts')
<script>
    $(document).on('click', '.apply-request', function () {

        let button = $(this);
        let url = button.data('url');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this request?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Apply',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            // Disable button
            button.prop('disabled', true);
            button.html('<i class="fas fa-spinner fa-spin"></i> Processing...');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },

                success: function (response) {

                    if (response.status) {

                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {

                            // Remove row if table row exists
                            button.closest('tr').fadeOut(500, function () {
                                $(this).remove();
                            });

                        });

                    } else {

                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });

                        button.prop('disabled', false);
                        button.html('Apply Now');
                    }
                },

                error: function (xhr) {

                    let message = 'Something went wrong. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error'
                    });

                    button.prop('disabled', false);
                    button.html('Apply Now');
                }
            });
        });
    });

</script>

<script>
    $(document).on('click', '.cancel-request', function () {

        let button = $(this);
        let url = button.data('url');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to cancel this request?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Cancel',
            cancelButtonText: 'No'
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            button.prop('disabled', true);
            button.html('<i class="fas fa-spinner fa-spin"></i> Processing...');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },

                success: function (response) {

                    if (response.status) {

                        Swal.fire({
                            title: 'Cancelled!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {

                            button
                                .removeClass('btn-outline-danger')
                                .addClass('btn-danger')
                                .prop('disabled', true)
                                .html(
                                    '<i class="fas fa-times-circle"></i> Cancelled'
                                );

                        });

                    } else {

                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });

                        button
                            .prop('disabled', false)
                            .html('Cancel');
                    }
                },

                error: function (xhr) {

                    let message = 'Something went wrong. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error'
                    });

                    button
                        .prop('disabled', false)
                        .html('Cancel');
                }
            });
        });
    });

</script>

{{-- Pagination --}}
<script>
    $(document).on('change', '#cpprofile', function () {

        let limit = $(this).val();

        $.ajax({
            url: "{{ route('admin.cpprofile.index') }}",
            type: "GET",
            data: {
                pagination_limit: limit
            },

            beforeSend: function () {

                $('#requestsTable').css({
                    'opacity': '0.5',
                    'pointer-events': 'none'
                });

            },

            success: function (response) {

                $('#requestsTable').html(response.html);

            },

            error: function () {

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.'
                });

            },

            complete: function () {

                $('#requestsTable').css({
                    'opacity': '1',
                    'pointer-events': 'auto'
                });

            }
        });

    });

</script>

@endpush
