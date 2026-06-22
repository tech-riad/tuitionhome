@extends('layouts.app')

@push ('page_css')

@endpush

@section('content')
<main class="container-custom">
    <!-- mini nav starts here -->
    <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/all-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.all-offers') }}">All offers</a>
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/available-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.available-offers') }}">Available offers</a>
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/schedule-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.schedule-offers') }}">Schedule Offer</a>
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/job-offer/application-offer') ? 'active-border' : '' }}"
            href="{{ route('admin.job-offer.application-offers') }}">Applications</a>
        <a class="text-decoration-none text-gray-800" href="{{ route('admin.job-offer.index') }}">Add New offers</a>
    </div>
    <!-- mini nav ends here -->
    <!-- main content section starts here -->
    <div class="ps-3 pe-2">
        <div class="owl-carousel">

            <div class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">

                    <p class="fw-bold fs-5 mb-1 mt-3">{{ $unique_tutors_applied->unique_tutors_applied ?? 0 }}
                    </p>
                    <p>Total Applied Tutor</p>

            </div>
            <div class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">{{App\Models\JobOffer::all()->count()}}</p>
                <p class="">All offer</p>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">{{ App\Models\JobOffer::whereDate('live_off_date', today())->count() }}</p>

                <p class="">Today Live Off Offer</p>
            </div>

            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{ App\Models\JobOffer::whereDate('created_at', now()->format('Y-m-d'))->count() }}</p>

                <p class="">Todays Offer</p>
            </div>
        </div>
        <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
            <div class="d-flex gap-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-sliders2 me-1"></i>Filter
                </button>
                {{-- <button class="btn btn-outline-dark "  id="sendBulkSmsApplicant">Send Bulk SMS</button> --}}
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-info text-nowrap" data-bs-toggle="modal" data-bs-target="#exampleModal4">
                    + Add New
                </button>
                <input type="text" class="form-control rounded" placeholder="Search" />
                <select class="form-select rounded" style="width: 100px">
                    <option selected>50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="400">400</option>
                    <option value="500">500</option>
                </select>
            </div>
        </div>
        <div class="bg-white pb-4 mb-b shadow-lg rounded-3 p-2 my-4">
            <div class="table-responsive">
                <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse" id="application_table">
                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                        <tr>
                            <th scope="col" class="text-nowrap">
                                <input class="form-check-input me-2 ms-2" type="checkbox" value="" id="check-All" />Date
                            </th>
                            <th scope="col" class="text-nowrap">Job ID</th>
                            <th scope="col" class="text-nowrap">Category</th>
                            <th scope="col" class="text-nowrap">Course</th>
                            <th scope="col" class="text-nowrap">Location</th>
                            <th scope="col">EM</th>
                            <th scope="col" class="text-nowrap">
                                Total applications
                            </th>
                            <th scope="col" class="text-nowrap">New applications</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobApplications as $item)
                        <tr class="" style="vertical-align: middle">
                            <td scope="row" class="text-center text-nowrap" style="padding: 30px 7px">
                                <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" />
                                <a type="button" class="text-decoration-none text-gray-700" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal2">
                                    @php
                                    $input = $item->first()->created_at;
                                    $format1 = 'd-m-Y';
                                    $format2 = 'H:i:s';
                                    $date = Carbon\Carbon::parse($input)->format($format1);
                                    // $time = Carbon\Carbon::parse($input)->format($format2);
                                    @endphp
                                    {{ $date }}
                                </a>
                            </td>
                            <td class="text-info">
                                <a href="{{ route('admin.job-details', ['job' => $item->first()->job_offer_id]) }}"
                                    class="text-decoration-none text-info">{{ $item->first()->job_offer_id ?? '' }}</a>
                            </td>
                            <td class="text-nowrap">{{ $item->first()->jobOffer->category->name ?? '' }}</td>
                            <td>{{ $item->first()->jobOffer->course->name ?? '' }}</td>
                            <td class="text-wrap">{{ $item->first()->jobOffer->city->name ?? '' }},
                                {{ $item->first()->jobOffer->location->name ?? '' }}</td>
                            <td class="text-info">
                                <a type="button" class="text-decoration-none text-info" data-bs-toggle="modal"
                                    data-bs-target="#exampleModa_{{$item->first()->id}}">
                                    {{-- {{$item->where('taken_by_id', 1)->count() ?? ''}} --}}
                                    EM
                                </a>
                            </td>

                            <div class="modal fade" id="exampleModa_{{$item->first()->id}}" tabindex="-1"
                                aria-labelledby="emModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="row row-cols-2 g-0">
                                                @php
                                                $takenByFirstUser = App\Models\User::where('id', $item->first()->jobOffer->taken_by_1)->first();
                                                $takenBySecondUser = App\Models\User::where('id', $item->first()->jobOffer->taken_by_2)->first();

                                                @endphp


                                                @if ($takenByFirstUser && $takenBySecondUser)
                                                    {{-- Display details for both users --}}
                                                    <div class="d-flex flex-column border-end">
                                                        <div class="text-white px-4" style="
                                                                    border-radius: 7px 0 0 0;
                                                                    padding: 35px 0;
                                                                    background-color: #3378c2;
                                                                ">
                                                            EM-1
                                                        </div>
                                                        <div class="px-4 pt-4 pb-3">
                                                            <p class="mb-0 fw-semibold">{{$takenByFirstUser->name}}</p>
                                                            <p style="font-size: 12px">14-06-2023</p>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-column border-end">
                                                        <div class="text-white px-4" style="
                                                                    border-radius: 7px 0 0 0;
                                                                    padding: 35px 0;
                                                                    background-color: #3378c2;
                                                                ">
                                                            EM-2
                                                        </div>
                                                        <div class="px-4 pt-4 pb-3">
                                                            <p class="mb-0 fw-semibold">{{$takenBySecondUser->name}}</p>
                                                            <p style="font-size: 12px">14-06-2023</p>
                                                        </div>
                                                    </div>
                                                @elseif ($takenByFirstUser)
                                                <div class="d-flex flex-column border-end">
                                                    <div class="text-white px-4" style="
                                                                border-radius: 7px 0 0 0;
                                                                padding: 35px 0;
                                                                background-color: #3378c2;
                                                            ">
                                                        EM-1
                                                    </div>
                                                    <div class="px-4 pt-4 pb-3">
                                                        <p class="mb-0 fw-semibold">{{$takenByFirstUser->name}}</p>
                                                        <p style="font-size: 12px">14-06-2023</p>
                                                    </div>
                                                </div>
                                                @elseif ($takenBySecondUser)
                                                <div class="d-flex flex-column border-end">
                                                    <div class="text-white px-4" style="
                                                                border-radius: 7px 0 0 0;
                                                                padding: 35px 0;
                                                                background-color: #3378c2;
                                                            ">
                                                        EM-2
                                                    </div>
                                                    <div class="px-4 pt-4 pb-3">
                                                        <p class="mb-0 fw-semibold">{{$takenBySecondUser->name}}</p>
                                                        <p style="font-size: 12px">14-06-2023</p>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="d-flex ">
                                                    <div class="px-4 pt-4 pb-3">
                                                        <h2>No One Take</h2>
                                                    </div>

                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <td class="text-nowrap">{{ $item->first()->tutors->count() ?? ''}}</td>
                            <td>
                                <a class="bg-primary text-white rounded-pill text-decoration-none border border-primary"
                                    style="padding: 0px 5px 0px 5px"
                                    href="{{ route('admin.job.applicant-list', $item->first()->job_offer_id) }}">
                                    {{$item->where('is_seen', 0)->count() ?? ''}}
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-2">
                <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                    1
                </button>

                <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                    2
                </button>
                <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                    ..
                </button>

                <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                    34
                </button>

                <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- main content section ends here -->

    <!-- Filter model starts here -->
    <div class="modal fade font-pop" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered px-3" style="max-width: 900px">
            <div class="modal-content pt-4 pb-4 ps-2">
                <div class="modal-header pe-5" style="padding-left: 40px">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Filter
                        <span class="text-muted fw-light" style="font-size: 12">
                        </span>
                    </h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="row row-cols-2 row-cols-lg-3 pb-2 ps-4 pt-2">
                        <div class="d-flex ">
                            <div class="flex-grow-1">
                                <div class="pb-3">
                                    <label for="datef" class="form-label">Date From</label>

                                    <input type="date" class="form-control shadow rounded-2" id="datef" />
                                </div>
                                <div class="pb-3">
                                    <label for="datet" class="form-label">Date From</label>

                                    <input type="date" class="form-control shadow rounded-2" id="datet" />
                                </div>
                                <div class="pb-3">
                                    <label for="jobid" class="form-label">Job ID</label>

                                    <input type="text" class="form-control shadow rounded-2" id="jobid"
                                        placeholder="2345" />
                                </div>
                            </div>
                            <div class="mb-3 ms-4" style="
                    margin-top: 34px;
                    width: 1px;
                    background-color: #f0f1f2;
                  "></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="cat" class="form-label">Category</label>

                                    <select id="cat" class="shadow rounded-2 form-select"
                                        aria-label="Default select example">
                                        <option selected>Bangla Medium</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="crs" class="form-label">Course</label>

                                    <select id="crs" class="shadow rounded-2 form-select"
                                        aria-label="Default select example">
                                        <option selected>Class 8</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="coun" class="form-label">Country</label>

                                    <select id="coun" class="shadow rounded-2 form-select"
                                        aria-label="Default select example">
                                        <option selected>Bangladesh</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 ms-4" style="
                    margin-top: 34px;
                    width: 1px;
                    background-color: #f0f1f2;
                  "></div>
                        </div>

                        <div class="d-flex justify-content-start">
                            <div class="flex-grow-1" style="padding-right: 30px">
                                <div class="mb-3">
                                    <label for="cty" class="form-label">City</label>

                                    <select id="cty" class="shadow rounded-2 form-select"
                                        aria-label="Default select example">
                                        <option selected>Dhaka</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="loc" class="form-label">Location</label>

                                    <select id="loc" class="shadow rounded-2 form-select"
                                        aria-label="Default select example">
                                        <option selected>Mirpur-1</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="loc" class="form-label">Application Views</label>

                                    <select id="loc" class="shadow rounded-2 form-select"
                                        aria-label="Default select example">
                                        <option selected>Seen</option>
                                        <option value="1">Unseen</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Dont remove this unnessary wrapper flex div -->
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-end align-items-center me-3">
                        <div>
                            <button type="button" class="btn btn-danger py-1 me-2">
                                Clear
                            </button>
                            <button type="button" class="btn btn-primary py-1">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter Model ends here -->

    <!--Date model starts here-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog model-sm modal-dialog-centered">
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
    <!--Date model ends here-->
    <!--ME model starts here-->

    <!--ME model ends here-->
    <!-- Add AplicationModal -->
    <form id="jobApplicationForm" action="">
        <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Add New Application
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tutor Id/Phone</label>
                            <input type="text" name="tutor_id" class="form-control mb-3 shadow-none rounded-2"
                                placeholder="Ex : 23467" />
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Job Id </label>
                            <input type="text" name="job_id" class="form-control mb-3 shadow-none rounded-2"
                                placeholder="Ex : A000005" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-lg" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" id="submitBtn">
                            Save change
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</main>




 <!--  note model  -->
 <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel"
 aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
     <div class="modal-content p-2">
         <div class="modal-body py-0 mt-2">
             <div class="mb-4">

                 <form action="{{ route('admin.application.setnote') }}" id="applicationNote"
                     method="post">
                     @csrf

                     <input type="hidden" name="note_application_id" id="note_application_id">
                     <div class="mb-3">
                         <label for="notet" class="form-label fw-500 fs-14">Note</label>
                         <textarea name="application_note" placeholder="Write your note here..." class="form-control shadow-none rounded-2"
                             id="application_note" rows="4"></textarea>

                     </div>
                     <span class="text-danger error-text application_note_error"></span>

                     <div class="d-flex justify-content-end align-items-center">
                         <button type="submit" class="btn btn-primary px-2 py-1">
                             Create
                         </button>
                     </div>

                 </form>
             </div>
             <div class="mb-4" id="allNote">

             </div>
             {{-- <div class="mb-4">
                 <div class="border-bottom border-1 pb-3">
                     <div class="bg-light rounded-2 p-2" style="font-size: 14px">
                         Lorem ipsum dolor sit amet consectetur adipisicing
                         elit. Perspiciatis, dignissimos.
                     </div>
                 </div>
                 <div class="d-flex justify-content-between align-items-center mt-3">
                     <div class="d-flex justify-content-start align-items-center gap-3">
                         <img height="45" width="45" class="rounded-3"
                             src="/images/avatar.svg" alt="" />
                         <div class="">
                             <p class="m-0" style="font-size: 14; font-weight: 500">
                                 Kaji Polash
                             </p>
                             <p class="m-0 fw-light" style="font-size: 12px">
                                 Sales & Operation Dep:
                             </p>
                         </div>
                     </div>
                     <div>
                         <p style="font-size: 12px">12:30 PM 21-01-2023</p>
                     </div>
                 </div>
             </div> --}}
         </div>
     </div>
 </div>
</div>


@endsection

@push('page_scripts')



@include('backend.job_offers.js.all_offer_page_js');


@include('backend.taken_offer.js.index_page_js');




<!-- jquery -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<!-- owl carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endpush
