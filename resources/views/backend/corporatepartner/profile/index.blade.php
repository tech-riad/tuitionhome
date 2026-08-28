@extends('backend.corporatepartner.layouts.app')


@section('content')
<div class="col-md-9 ms-sm-auto col-lg-10" style="margin-top: 62px">
    <!-- mini nav starts here -->
    @include('backend.corporatepartner.layouts.menu')

    <!-- mini nav ends here -->
    <!-- main content section starts here -->
    <!-- header cards starts here -->
    <div class="row gap-4 gap-md-0 ms-1 me-1 mb-4">
        <div class="col-12">
            <div class="bg-white shadow-lg rounded-3 p-4">
                <p class="text-center fw-bold fs-5 mb-1">{{ $activeProfile }}</p>
                <p class="text-center mb-0">Active Profile</p>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 gap-4 row-cols-md-2 row-cols-lg-4 gap-md-0 ms-1 me-1">
        <div class="mb-md-4 mb-lg-0">
            <div class="bg-white shadow-lg rounded-3 p-4">
                <p class="text-center fw-bold fs-5 mb-1">{{ $inactiveProfile }}</p>
                <p class="text-center mb-0">Inactive Profile</p>
            </div>
        </div>
        <div class="mb-md-4 mb-lg-0">
            <div class="bg-white shadow-lg rounded-3 p-4">
                <p class="text-center fw-bold fs-5 mb-1">{{ $tutorProfile }}</p>
                <p class="text-center mb-0 text-nowrap">Tutor Profile</p>
            </div>
        </div>
        <div class="">
            <div class="bg-white shadow-lg rounded-3 p-4">
                <p class="text-center fw-bold fs-5 mb-1">{{ $maleProfile }}</p>
                <p class="text-center mb-0">Male Profile</p>
            </div>
        </div>
        <div class="">
            <div class="bg-white shadow-lg rounded-3 p-4">
                <p class="text-center fw-bold fs-5 mb-1">{{ $femaleProfile }}</p>
                <p class="text-center mb-0">Female Profile</p>
            </div>
        </div>
    </div>
    <!-- header cards ends here -->
    <!-- table starts here -->
    <div class="ps-3 mt-4" style="padding-right: 13px">
        <div class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
            <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="bi bi-sliders2 me-1"></i>Filter
                </button>
                <button class="btn btn-outline-ndark">Send Bulk SMS</button>
                <a href="/affiliate-profile-inactive.html" class="btn btn-warning grayed">Inactive Profile</a>
            </div>
            <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                <input type="text" class="form-control rounded" placeholder="Search" />
                <select id="all_offer_paginationLimit" name="pagination_limit" class="form-select rounded"
                    style="width: 100px">

                    <option value="30" {{ $paginationLimit == 30 ? 'selected' : '' }}>30</option>
                    <option value="50" {{ $paginationLimit == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $paginationLimit == 100 ? 'selected' : '' }}>100</option>
                    <option value="200" {{ $paginationLimit == 200 ? 'selected' : '' }}>200</option>
                    <option value="400" {{ $paginationLimit == 400 ? 'selected' : '' }}>400</option>
                    <option value="500" {{ $paginationLimit == 500 ? 'selected' : '' }}>500</option>

                </select>
                <script>
                    $(document).on('change', '#all_offer_paginationLimit', function () {

                        let limit = $(this).val();

                        let url = new URL(window.location.href);

                        url.searchParams.set('pagination_limit', limit);
                        url.searchParams.set('page', 1);

                        $.ajax({

                            url: url.toString(),
                            type: 'GET',

                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },

                            beforeSend: function () {

                                $('#partnerTable').css({
                                    'opacity': '0.5',
                                    'pointer-events': 'none'
                                });

                            },

                            success: function (response) {

                                $('#partnerTable').html(response.html);

                                $('#partnerPagination').html(response.pagination);

                                window.history.pushState({},
                                    '',
                                    url.toString()
                                );

                            },

                            error: function (xhr) {

                                console.log(xhr.responseText);

                            },

                            complete: function () {

                                $('#partnerTable').css({
                                    'opacity': '1',
                                    'pointer-events': 'auto'
                                });

                            }

                        });

                    });

                </script>
            </div>
        </div>
        <div class="bg-white shadow-lg rounded-3 p-2 my-4">
            <div class="bg-white pb-4 mb-b">

                <div id="partnerTable">
                    @include('backend.corporatepartner.partials.partner_table')
                </div>

                <div id="partnerPagination">
                    @include('backend.corporatepartner.partials.pagination')
                </div>

                <!-- pagination starts here -->

                <!-- pagination ends here -->
            </div>
        </div>
    </div>
    <!-- table ends here -->
    <!-- Show Date time model starts here-->
    <div class="modal fade" id="showDateTimeModal" tabindex="-1" aria-labelledby="showDateTimeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
            <div class="modal-content">
                <div class="modal-body pt-5 pb-4">
                    <p class="text-center text-info fs-3">7 June 2023</p>
                    <p class="text-center text-gray-700 border-top fs-1 pt-1">
                        03:30 PM
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Show Date time model ends here-->

    <!-- view model starts here-->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="idInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog model-sm modal-dialog-slide-left" style="max-width: 400px">
            <div class="modal-content">
                <div class="modal-body pt-2 pb-4 px-5">
                    <div class="row row-cols-2 mt-3 border-bottom border-2 pb-3 align-items-center">
                        <p class="fw-semibold mb-0">SLH</p>
                        <div>
                            <p class="mb-0">Sajid HDY</p>
                            <small>04-04-23</small>
                        </div>
                    </div>
                    <div class="row row-cols-2 border-bottom border-2 py-3 align-items-center">
                        <p class="fw-semibold mb-0">ALH</p>
                        <div>
                            <p class="mb-0">Saikat Ullah</p>
                            <small>09-04-23</small>
                        </div>
                    </div>
                    <div class="row row-cols-2 border-bottom border-2 py-3 align-items-center">
                        <p class="fw-semibold mb-0">Verifyed By</p>
                        <div>
                            <p class="mb-0">Afnun Polash</p>
                            <small>08-04-23</small>
                        </div>
                    </div>
                    <div class="row row-cols-2 pt-3 align-items-center">
                        <p class="fw-semibold mb-0">Deactived By</p>
                        <div>
                            <p class="mb-0">Robel Hossen</p>
                            <small>07-04-23</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Note model starts here-->
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel5">
                        Note Details
                    </h5>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0 text-dark fs-5">Fahmida Tayba</p>
                                    <p class="text-info" style="font-size: 12px">
                                        ID-34582
                                    </p>
                                </div>
                                <div>
                                    <p>Nov 14, 2023</p>
                                </div>
                            </div>
                            <div>
                                <p class="" style="font-size: 16px; color: #3b3c3d">
                                    Note Title
                                </p>
                                <p>
                                    doloremque dolorem dolor, delectus repellendus
                                    expedita modi distinctio voluptate voluptas impedit.
                                    Corrupti est expedita non qui accusamus illum quam,
                                    cum cumque saepe excepturi rem.
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p style="font-size: 16px; color: #3b3c3d">
                                        Read More
                                    </p>
                                </div>
                                <div>
                                    <button class="btn btn-primary py-1">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0 fs-5">Sajid HDY</p>
                                    <p class="text-info" style="font-size: 12px">
                                        ID-31934
                                    </p>
                                </div>
                                <div>
                                    <p>Nov 29, 2023</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-gay-900" style="font-size: 16px">
                                    Note Title
                                </p>
                                <p>
                                    doloremque dolorem dolor, delectus repellendus
                                    expedita modi distinctio voluptate voluptas impedit.
                                    Corrupti est expedita non qui accusamus illum quam,
                                    cum cumque saepe excepturi rem.
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Read More</p>
                                </div>
                                <div>
                                    <button class="btn btn-primary py-1">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0 text-dark fs-5">Fahmida Tayba</p>
                                    <p class="text-info" style="font-size: 12px">
                                        ID-34582
                                    </p>
                                </div>
                                <div>
                                    <p>Nov 30, 2023</p>
                                </div>
                            </div>
                            <div>
                                <p class="" style="font-size: 16px; color: #3b3c3d">
                                    Note Title
                                </p>
                                <p>
                                    doloremque dolorem dolor, delectus repellendus
                                    expedita modi distinctio voluptate voluptas impedit.
                                    Corrupti est expedita non qui accusamus illum quam,
                                    cum cumque saepe excepturi rem.
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Read More</p>
                                </div>
                                <div>
                                    <button class="btn btn-warning py-1">Edited</button>
                                </div>
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
    <!-- Note model ends here-->

    <!-- Create Note model starts here-->
    <div class="modal fade" id="createNoteModal" tabindex="-1" aria-labelledby="createNoteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel6">
                        Make A Note
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label text-dark">Note Title</label>
                            <input type="text" class="form-control shadow-none rounded-3" id="exampleFormControlInput1"
                                placeholder="Maximum 8 words can be given " />
                        </div>
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label text-dark">Note Details</label>
                            <textarea class="form-control shadow-none rounded-3" id="exampleFormControlTextarea1"
                                rows="3" placeholder="Maximum 30 words can be given"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gdark shadow-lg" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Create Note model ends here-->
    <!-- Log model starts here -->
    <div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
            <div class="modal-content mx-4">
                <div class="modal-body p-0">
                    <table class="table shadow-none">
                        <thead class="text-white" style="background-color: #3378c2">
                            <tr class="">
                                <th scope="col" class="border-end border-1" style="border-top-left-radius: 8px">
                                    Name
                                </th>
                                <th scope="col" class="text-nowrap border-end border-1">
                                    Em ID
                                </th>
                                <th scope="col" class="border-end border-1">Date</th>
                                <th scope="col" class="text-nowrap" style="border-top-right-radius: 8px">
                                    Note Before Edit
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="" style="vertical-align: middle">
                                <th scope="row" class="text-nowrap border-end border-1">
                                    Fahmida Tayba
                                </th>
                                <td class="text-info border-end border-1">56123</td>
                                <td class="text-nowrap border-end border-1">
                                    <p class="mb-0">14-07-2023</p>
                                    <p class="mb-0 text-muted">47: 15: 12 PM</p>
                                </td>
                                <td>
                                    <p class="border border-info p-2 rounded-3">
                                        Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. Reprehenderit molestias magnam doloribus
                                        impedit sunt ducimus inventore voluptas numquam
                                        eum ad corporis aperiam harum quo, explicabo
                                        officiis suscipit, reiciendis architecto veniam
                                        amet sequi, facere placeat illo veritatis.
                                        Dignissimos eius quibusdam tempora!
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Log model ends here -->
    <!-- Filter model starts here -->
    <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slide-right" style="max-width: 900px">
            <div class="modal-content pb-4 pt-3">
                <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                    <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0" style="padding-left: 40px">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 pe-4">
                                <div class="pb-3">
                                    <label for="datef" class="form-label text-dark text-sm">Date from</label>
                                    <div class="">
                                        <input type="date" class="form-control shadow rounded-3" id="datef" />
                                    </div>
                                </div>
                                <div class="pb-3">
                                    <label for="datet" class="form-label text-dark text-sm">Date To</label>
                                    <input type="date" class="form-control shadow rounded-3" id="datet" />
                                </div>
                                <div class="pb-3">
                                    <label for="Status" class="form-label text-dark text-sm">Verify Status</label>

                                    <select id="Status" class="shadow rounded-3 form-select"
                                        aria-label="Default select example">
                                        <option selected value="Verified">
                                            Verified
                                        </option>
                                        <option value="Option 1">Option 1</option>
                                        <option value="Option 2">Option 2</option>
                                        <option value="Option 3">Option 3</option>
                                        <option value="Option 4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="border-end mt-3" style="height: 210px"></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 pe-4">
                                <div class="pb-3">
                                    <label for="cntry" class="form-label text-dark text-sm">Country</label>

                                    <select id="cntry" class="shadow rounded-3 form-select"
                                        aria-label="Default select example">
                                        <option selected value="bangladesh">
                                            Bangladesh
                                        </option>
                                        <option value="Option 1">Option 1</option>
                                        <option value="Option 2">Option 2</option>
                                        <option value="Option 3">Option 3</option>
                                        <option value="Option 4">Option 4</option>
                                    </select>
                                </div>
                                <div class="pb-3">
                                    <label for="cty" class="form-label text-dark text-sm">City</label>

                                    <select id="cty" class="shadow rounded-3 form-select"
                                        aria-label="Default select example">
                                        <option selected value="dhaka">Dhaka</option>
                                        <option value="Option 1">Option 1</option>
                                        <option value="Option 2">Option 2</option>
                                        <option value="Option 3">Option 3</option>
                                        <option value="Option 4">Option 4</option>
                                    </select>
                                </div>
                                <div class="pb-3">
                                    <label for="loc" class="form-label text-dark text-sm">Location</label>

                                    <select id="loc" class="shadow rounded-3 form-select"
                                        aria-label="Default select example">
                                        <option selected value="mirpur 1">
                                            Mirpur 1
                                        </option>
                                        <option value="Option 1">Option 1</option>
                                        <option value="Option 2">Option 2</option>
                                        <option value="Option 3">Option 3</option>
                                        <option value="Option 4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="border-end mt-3" style="height: 210px"></div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 pe-4">
                                <div class="pb-3">
                                    <label for="Featured" class="form-label text-dark text-sm">Featured</label>

                                    <select id="Featured" class="shadow rounded-3 form-select"
                                        aria-label="Default select example">
                                        <option selected value="SLH">SLH</option>
                                        <option value="Option 1">Option 1</option>
                                        <option value="Option 2">Option 2</option>
                                        <option value="Option 3">Option 3</option>
                                        <option value="Option 4">Option 4</option>
                                    </select>
                                </div>
                                <div class="pb-3">
                                    <label for="Other" class="form-label text-dark text-sm">Channel</label>

                                    <select id="Tutor Request" class="shadow rounded-3 form-select"
                                        aria-label="Default select example">
                                        <option selected value="Tutor Request">
                                            Tutor Request
                                        </option>
                                        <option value="Option 1">Option 1</option>
                                        <option value="Option 2">Option 2</option>
                                        <option value="Option 3">Option 3</option>
                                        <option value="Option 4">Option 4</option>
                                    </select>
                                </div>
                                <div class="pb-3">
                                    <label for="am" class="form-label text-dark text-sm">Action By</label>

                                    <select id="am" class="shadow rounded-3 form-select"
                                        aria-label="Default select example">
                                        <option selected value="Robel Hosssen">
                                            Robel Hosssen
                                        </option>
                                        <option value="Option 1">Option 1</option>
                                        <option value="Option 2">Option 2</option>
                                        <option value="Option 3">Option 3</option>
                                        <option value="Option 4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class=""></div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                    <div class="pe-2">
                        <button type="button" class="btn btn-danger grayed py-1 me-2">
                            Clear
                        </button>
                        <a href="employee-filter-apply.html" type="button" class="btn btn-primary py-1">
                            Apply
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter Model ends here -->
    <div class="modal fade"
    id="addProfileModal"
    tabindex="-1"
    aria-labelledby="addProfileModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-slide-top" style="max-width: 600px">

        <div class="modal-content p-3">

            <div class="modal-header">

                <h1 class="modal-title fs-5" id="addProfileModalLabel">
                    Create CP Profile
                </h1>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            <div class="modal-body pt-0">

                <form id="addProfileForm"
                    action="{{ route('admin.cpprofile.store') }}"
                    method="POST">

                    @csrf

                    <div class="row row-cols-md-2">

                        {{-- Name --}}
                        <div class="mb-3">

                            <label for="cp_name"
                                class="form-label text-dark text-sm required">
                                Name
                            </label>

                            <input type="text"
                                name="name"
                                id="cp_name"
                                class="shadow-none rounded-3 form-control"
                                placeholder="Enter your name"
                                required>

                        </div>


                        {{-- Phone --}}
                        <div class="mb-3">

                            <label for="cp_phone"
                                class="form-label text-dark text-sm required">
                                Phone
                            </label>

                            <input type="text"
                                name="phone"
                                id="cp_phone"
                                class="shadow-none rounded-3 form-control"
                                placeholder="Enter your phone"
                                required>

                        </div>


                        {{-- Email --}}
                        <div class="mb-3">

                            <label for="cp_email"
                                class="form-label text-dark text-sm">
                                Email
                            </label>

                            <input type="email"
                                name="email"
                                id="cp_email"
                                class="shadow-none rounded-3 form-control"
                                placeholder="Enter your email">

                        </div>


                        {{-- Gender --}}
                        <div class="mb-3">

                            <label for="cp_gender"
                                class="form-label text-dark text-sm required">
                                Gender
                            </label>

                            <select name="gender"
                                id="cp_gender"
                                class="shadow-none rounded-3 form-select"
                                required>

                                <option value="Male">
                                    Male
                                </option>

                                <option value="Female">
                                    Female
                                </option>

                            </select>

                        </div>


                        {{-- Country --}}
                        <div class="mb-3">

                            <label for="country_id"
                                class="form-label text-dark text-sm required">
                                Country
                            </label>

                            <select name="country_id"
                                id="country_id"
                                class="shadow-none rounded-3 form-select"
                                required>

                                <option value="">
                                    Select Country
                                </option>

                                @foreach ($countries as $country)

                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- City --}}
                        <div class="mb-3">

                            <label for="city_id"
                                class="form-label text-dark text-sm required">
                                City
                            </label>

                            <select name="city_id"
                                id="city_id"
                                class="shadow-none rounded-3 form-select"
                                required>

                                <option value="">
                                    Select City
                                </option>

                            </select>

                        </div>


                        {{-- Location --}}
                        <div class="mb-3">

                            <label for="location_id"
                                class="form-label text-dark text-sm required">
                                Location
                            </label>

                            <select name="location_id"
                                id="location_id"
                                class="shadow-none rounded-3 form-select"
                                required>

                                <option value="">
                                    Select Location
                                </option>

                            </select>

                        </div>


                        {{-- Password --}}
                        <div class="mb-3 mb-md-0">

                            <label class="form-label text-dark text-sm required">
                                Password
                            </label>

                            <input type="text"
                                class="shadow-none rounded-3 form-control bg-light"
                                value="12345678"
                                disabled>

                        </div>


                        {{-- Re Password --}}
                        <div class="mb-3 mb-md-0">

                            <label class="form-label text-dark text-sm required">
                                Re-Password
                            </label>

                            <input type="text"
                                class="shadow-none rounded-3 form-control bg-light"
                                value="12345678"
                                disabled>

                        </div>

                    </div>

                </form>

            </div>


            <div class="modal-footer">

                <button type="submit"
                    form="addProfileForm"
                    id="submitProfileBtn"
                    class="btn btn-primary w-100">

                    Submit

                </button>

            </div>

        </div>

    </div>

</div>
    <!-- main content section ends here -->
</div>

@endsection
@push('page_scripts')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" /> --}}

<script>
    $(document).on('click', '.pagination-link', function (e) {

        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({

            url: url,
            type: 'GET',

            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },

            beforeSend: function () {

                $('#partnerTable').css({
                    'opacity': '0.5',
                    'pointer-events': 'none'
                });

            },

            success: function (response) {

                $('#partnerTable').html(response.html);

                $('#partnerPagination').html(response.pagination);

                window.history.pushState({}, '', url);

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Unable to load data.'
                });

            },

            complete: function () {

                $('#partnerTable').css({
                    'opacity': '1',
                    'pointer-events': 'auto'
                });

            }

        });

    });

</script>

<script>
$(document).ready(function () {

    console.log('CP Profile JS Loaded');
    console.log('jQuery version:', $.fn.jquery);


    // =====================================================
    // SELECT2 INITIALIZATION
    // =====================================================

    $('#country_id').select2({
        width: '100%',
        dropdownParent: $('#addProfileModal')
    });

    $('#city_id').select2({
        width: '100%',
        dropdownParent: $('#addProfileModal')
    });

    $('#location_id').select2({
        width: '100%',
        dropdownParent: $('#addProfileModal')
    });


    // =====================================================
    // COUNTRY -> CITY
    // =====================================================

    $('#country_id').on('change', function () {

        let c_id = $(this).val();

        console.log('Country ID:', c_id);


        // Reset city
        $('#city_id')
            .empty()
            .append('<option value="">Loading...</option>')
            .val('')
            .trigger('change');


        // Reset location
        $('#location_id')
            .empty()
            .append('<option value="">Select Location</option>')
            .val('')
            .trigger('change');


        if (!c_id) {

            $('#city_id')
                .empty()
                .append('<option value="">Select City</option>')
                .val('')
                .trigger('change');

            return;
        }


        $.ajax({

            url: '{{ route("get_city") }}',

            type: 'POST',

            data: {
                c_id: c_id,
                _token: '{{ csrf_token() }}'
            },

            beforeSend: function () {

                $('#city_id').prop('disabled', true);

            },

            success: function (result) {

                console.log('City response:', result);


                $('#city_id')
                    .empty()
                    .html(result)
                    .val('')
                    .trigger('change');


                $('#city_id').prop('disabled', false);

            },

            error: function (xhr) {

                console.log('City Error:', xhr.responseText);


                $('#city_id')
                    .empty()
                    .append(
                        '<option value="">Select City</option>'
                    )
                    .val('')
                    .trigger('change');


                $('#city_id').prop('disabled', false);


                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Unable to load cities.'
                });

            }

        });

    });



    // =====================================================
    // CITY -> LOCATION
    // =====================================================

    $('#city_id').on('change', function () {

        let city_id = $(this).val();

        console.log('City ID:', city_id);


        $('#location_id')
            .empty()
            .append('<option value="">Loading...</option>')
            .val('')
            .trigger('change');


        if (!city_id) {

            $('#location_id')
                .empty()
                .append(
                    '<option value="">Select Location</option>'
                )
                .val('')
                .trigger('change');

            return;
        }


        $.ajax({

            url: '{{ route("get_location") }}',

            type: 'POST',

            data: {
                city_id: city_id,
                _token: '{{ csrf_token() }}'
            },

            beforeSend: function () {

                $('#location_id').prop('disabled', true);

            },

            success: function (result) {

                console.log('Location response:', result);


                $('#location_id')
                    .empty()
                    .html(result)
                    .val('')
                    .trigger('change');


                $('#location_id').prop('disabled', false);

            },

            error: function (xhr) {

                console.log(
                    'Location Error:',
                    xhr.responseText
                );


                $('#location_id')
                    .empty()
                    .append(
                        '<option value="">Select Location</option>'
                    )
                    .val('')
                    .trigger('change');


                $('#location_id').prop('disabled', false);


                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Unable to load locations.'
                });

            }

        });

    });



    // =====================================================
    // CREATE CP PROFILE
    // =====================================================

    $('#addProfileForm').on('submit', function (e) {

        e.preventDefault();


        let form = $(this);

        let submitBtn = $('#submitProfileBtn');


        submitBtn
            .prop('disabled', true)
            .html(
                '<span class="spinner-border spinner-border-sm me-1"></span> Saving...'
            );


        $.ajax({

            url: form.attr('action'),

            type: 'POST',

            data: form.serialize(),


            success: function (response) {



                $('#addProfileModal').modal('hide');


                Swal.fire({

                    icon: 'success',

                    title: 'Success!',

                    text: response.message ||
                        'CP Profile created successfully.',

                    timer: 1800,

                    showConfirmButton: false

                });


                form[0].reset();


                // Reset country
                $('#country_id')
                    .val('')
                    .trigger('change');


                // Reset city
                $('#city_id')
                    .empty()
                    .append(
                        '<option value="">Select City</option>'
                    )
                    .val('')
                    .trigger('change');


                // Reset location
                $('#location_id')
                    .empty()
                    .append(
                        '<option value="">Select Location</option>'
                    )
                    .val('')
                    .trigger('change');


                setTimeout(function () {

                    location.reload();

                }, 1000);

            },


            error: function (xhr) {



                let message =
                    'Something went wrong. Please try again.';


                if (
                    xhr.status === 422 &&
                    xhr.responseJSON &&
                    xhr.responseJSON.errors
                ) {

                    message = Object.values(
                        xhr.responseJSON.errors
                    )
                    .flat()
                    .join('<br>');

                }


                Swal.fire({

                    icon: 'error',

                    title: 'Validation Error!',

                    html: message

                });

            },


            complete: function () {

                submitBtn
                    .prop('disabled', false)
                    .html('Submit');

            }

        });

    });

});
</script>
@endpush
