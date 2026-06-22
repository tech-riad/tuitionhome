@extends('layouts.app')

@push('page_css')
@endpush


@section('content')
    <main class="container-custom">
        <div class="col-md-9 ms-sm-auto col-lg-12" style="">
            <!-- main content section starts here -->
            <div class="py-4 ps-3" style="padding-right: 13px">
                <div class="d-flex justify-content-between bg-white p-4 rounded-3 shadow-lg align-items-center mb-4">
                    <p class="fs-3 m-0 fw-bold">Total Applications List-{{ count($total_applicants) }}</p>
                    <button class="btn btn-info text-nowrap assign_tutor" data-id="{{ $job_offer->id }}">
                        + Add New
                    </button>
                </div>
                <div class="bg-white p-4 rounded-3 shadow-lg">
                    <div class="row row-cols-1 row-cols-lg-2 pt-2">
                        <div class="">
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Job ID</p>
                                <p class="text-info">
                                    <a href="{{ route('admin.job-details', ['job' => $job_offer->id]) }}"
                                        class="text-decoration-none text-info">{{ $job_offer->id }}</a>
                                </p>
                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Category</p>
                                <p class="">{{ $job_offer->category->name ?? ''}}</p>
                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Course</p>
                                <p class="">{{ $job_offer->course->name ?? ''}}</p>
                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Subjects</p>

                                @php
                                    $subjects = [];
                                @endphp

                                @foreach ($job_offer->job_offer_student_subjects as $subject)
                                    @php

                                        $subjects[] = $subject->subject->title ?? '';
                                    @endphp

                                @endforeach

                                {{-- {{$subjects}} --}}

                                <p class="">{{ implode(', ', $subjects) }}</p>

                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Salary</p>
                                <p class="">{{ $job_offer->salary }}</p>
                            </div>
                        </div>
                        <div class="">
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Country</p>
                                <p class="">{{ $job_offer->country->name ?? ''}}</p>
                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">City</p>
                                <p class="">{{ $job_offer->city->name ?? ''}}</p>
                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Location</p>
                                <p class="">{{ $job_offer->location->name ?? ''}}</p>
                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Number Of Student's</p>
                                <p class="">{{ $job_offer->number_of_students ?? ''}}</p>
                            </div>
                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0">
                                <p class="fw-semibold">Phone</p>
                                <p class="">{{ $job_offer->parent->phone ?? ''}}</p>
                                <input type="hidden" value="{{ $job_offer->id}}" class="offer_id">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-outline-ndark" id="sendBulkSmsApplicant">Send Bulk SMS</button>
                        <select class="form-select rounded" style="width: 100px">
                            <option selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        </select>
                    </div>
                    <div class="mt-4 table-responsive">
                        <table class="table table-hover bg-white shadow-none" id="application_table"
                            style="border-collapse: collapse; width: 100%">
                            <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                <tr>
                                    <th scope="col" class="text-nowrap ms-0" style="padding-left: 0px">
                                        <input class="form-check-input me-2" type="checkbox"
                                            id="check-All" />Date
                                    </th>
                                    <th scope="col" class="text-nowrap">Job ID</th>
                                    <th class="text-nowrap">Apply ID</th>
                                    <th class="text-nowrap">Tutor Name</th>
                                    <th class="text-nowrap">Tutor ID</th>
                                    <th class="text-nowrap">Match</th>
                                    <th class="text-nowrap">Taken By</th>
                                    <th class="text-nowrap">Shortlisted By</th>
                                    <th class="text-nowrap">Applicant First Seen By</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($total_applicants as $applicant)
                                    <tr class="" style="vertical-align: middle">
                                        <td scope="row " class="text-center text-nowrap" style="padding: 30px 0px">
                                            <input class="form-check-input me-2 check-row" type="checkbox"
                                                data-id="{{ $applicant->tutor_id }}" />
                                            <a class="text-decoration-none text-gray-700 btn"
                                                id="{{ $applicant->created_at }}" onclick="dateTime(this.id)"
                                                data-bs-toggle="modal" data-time="{{ $applicant->created_at }}"
                                                data-bs-target="#exampleModal2">


                                                @php
                                                    $input = $applicant->created_at;
                                                    $format1 = 'd-m-Y';
                                                    $format2 = 'H:i:s';
                                                    $date = Carbon\Carbon::parse($input)->format($format1);
                                                    // $time = Carbon\Carbon::parse($input)->format($format2);
                                                @endphp
                                                {{ $date }}
                                            </a>
                                        </td>
                                        <td class="">
                                            <a href="{{ route('admin.job-details', ['job' => $job_offer->id]) }}"
                                                class="text-decoration-none text-info"
                                                target="_blank">{{ $job_offer->id }}</a>
                                        </td>
                                        <td class="">{{ $applicant->id }}</td>

                                        @php
                                        $tAduTotalElements = count($applicant->tutor->tutor_education ?? []) ?? 'n/a';
                                    @endphp

                                        <td class="text-info text-nowrap">
                                            <a href="{{ route('admin.application.seen.tutor', ['tutor_id' => $applicant->tutor_id , 'app_id'=> $applicant->id]) }}"
                                                target="_blank">
                                                {{ $applicant->tutor->name ?? ''}}
                                                @if(@$applicant->tutor->is_premium == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-regular-9c7ea3fd.svg" alt="">
                                                @endif
                                                @if(@$applicant->tutor->is_premium_pro == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-pro-fc790c7d.svg" alt="">
                                                @endif
                                                @if(@$applicant->tutor->is_premium_advance == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-advance-4b8e47d2.svg" alt="">
                                                @endif
                                                @if($applicant->tutor->is_verified == 1)
                                                <i style="color:#007BFF" class="far fa-check-circle"></i>
                                                @endif
                                                @if(@$applicant->tutor->is_internal_verify == 1 && $applicant->tutor->is_verified == 0)
                                                <i style="color:#ed228b" class="far fa-check-circle"></i>
                                                @endif
                                                @if(@$applicant->tutor->is_featured == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/featured-icon-0c358655.svg" alt="">

                                                @endif
                                                @if(@$applicant->tutor->is_boost == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/boost-icon-d47ce3c5.svg"
                                                    alt="">

                                                @endif
                                             </a>
                                             <br>

                                             @if (!empty($applicant->Tutor->tutor_education) && $tAduTotalElements > 0)
                                             <p class="m-0 fw-light text-nowrap">
                                                 {{ Str::limit($applicant->Tutor->tutor_education[$tAduTotalElements - 1]->institutes->title ?? 'N/A', 30) }}
                                             </p>
                                         @else
                                             <p class="m-0 fw-light text-nowrap">N/A</p>
                                         @endif
                                             @if (!empty($applicant->Tutor->tutor_education) && $tAduTotalElements > 0)
                                             <p class="m-0 fw-light text-nowrap">
                                                {{-- {{$applicant->Tutor->tutor_education[$tAduTotalElements - 1]}} --}}
                                                 {{ Str::limit($applicant->Tutor->tutor_education[$tAduTotalElements - 1]->departments->title ?? 'N/A', 30) }}
                                             </p>
                                         @else
                                             <p class="m-0 fw-light text-nowrap">N/A</p>
                                         @endif
                                        </td>
                                        <td>
                                            @if($applicant->is_tutor_seen == 1)
                                            <span>{{ $applicant->tutor_id ?? '' }}</span>
                                        @else
                                            <span class="green-border">{{ $applicant->tutor_id ?? '' }}</span>
                                        @endif

                                        </td>





                                            <td class="count-cell" data-parameter="{{$applicant->job_offer_id}}" data-parameter2="{{$applicant->tutor_id}}"></td>



                                            {{-- <script>document.write(matchingRate({{$applicant->job_offer_id}},{{$applicant->tutor_id}}))</script> --}}


                                            {{-- <script>
                                            matchingRate({{$applicant->job_offer_id}},{{$applicant->tutor_id}});

                                            </script> --}}


                                        <td class="text-nowrap">
                                            {{ $applicant->taken_by_id ? $applicant->user->name : '' }} </td>

                                            <td class="text-nowrap">
                                                {{ $applicant->shortlisted_by ? $applicant->stortlistedByUser->name : '' }} </td>
                                            <td class="text-nowrap">
                                                {{ $applicant->seen_by ? $applicant->seenBy->name : ''  }} </td>
                                        <td class="text-nowrap">
                                            @if ($applicant->taken_by_id == null)
                                                <button class="btn btn-ndark  py-1 px-2 applicant_take myButton_take "  onclick="applicantTake(this.id ,{{$applicant->job_offer_id}})"
                                                    id="{{ $applicant->id }}">Take</button>
                                            @else
                                                <button class="btn btn-ndark  py-1 px-2" disabled>Taken</button>
                                            @endif




                                            @if ($applicant->shortlisted_by == null)
                                                <button class="btn btn-pink py-1 px-2"  onclick="applicantShortlist(this.id ,{{$applicant->job_offer_id}})"
                                                    id="{{ $applicant->id }}">Shortlist</button>
                                            @else
                                                <button class="btn btn-pink py-1 px-2"
                                                disabled  >Shortlisted</button>
                                            @endif


                                            <button type="button" class="btn btn-primary py-1 px-2"
                                            id="{{ @$applicant->id }}"
                                            onclick="btnNote(this.id)"
                                            data-bs-toggle="modal"
                                            data-bs-target="#noteModal">
                                            Update Note
                                           </button>



                                            {{-- <button class="btn btn-info py-1 px-2">
                                                Create A Note
                                            </button> --}}

                                            <button class="btn btn-warning py-1 px-2 note_log"
                                                data-id="{{ @$applicant->id }}">Log</button>
                                            @if(in_array(Auth::user()->role_id, [1, 6]))
                                            <a class="btn btn-warning py-1 px-2 " href="{{route('admin.job.applicant-list.restore',$applicant->id)}}">Restore</a>
                                            @endif

                                            {{-- @if (Auth::user()->role_id == 1)
                                                <button class="btn btn-danger py-1 px-2 delete_applied_tutor"
                                                    data-id="{{ $applicant->id }}">Delete</button>
                                            @endif --}}


                                             {{-- <button class="btn btn-primary py-1 px-2"
                                                onclick="matchingRate({{$applicant->job_offer_id}},{{$applicant->tutor_id}})" >
                                                Match Rate
                                            </button> --}}

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No Applicant Here</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- main content section ends here -->
            <!--Date model starts here-->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="dateModalLabel"
                aria-hidden="true">
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

            <!-- Add AplicationModal -->
            <div class="modal fade" id="assign_tutor_new" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Add New Aplication
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tutor Id/Phone</label>
                                <input type="text" class="form-control mb-3 shadow-none rounded-2 assign_input"
                                    placeholder="Ex : 23467" />
                                <input type="hidden" class="offer_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light shadow-lg" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-primary assign_tutor_submit_btn">
                                Assign Tutor
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- note modal --}}
            <div class="modal fade" id="note_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Create Note
                            </h5>
                        </div>
                        <div class="modal-body">
                            <textarea name="note" class="note_description form-control"></textarea>
                            <input type="hidden" class="taken_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light shadow-lg" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-primary note_submit">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- log  note modal --}}
            <div class="modal fade" id="log_note_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered  modal-lg">
                    <div class="modal-content p-4">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Note History
                            </h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="taken_id">
                            <div class="note_table">

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- bulk sms form  --}}

            <form action="{{ route('admin.application.list.bulksms') }} " method="POST" id="bulkSmsForm">
                @csrf
                <input type="hidden" class="job_id" name="job_id">
                <input type="hidden" class="tutor_id" name="tutor_ids">
            </form>

        </div>
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
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function applicantTake(app_id , job_id){


            // console.log(job_id);
            var id = app_id;
                $.ajax({

                    type: 'POST',
                    url: "{{ route('admin.job_offers.application-take') }}",
                    data: {
                        id: id,
                        job_id: job_id,
                    },
                    success: function(response) {

                        // console.log(response);

                        if (response.status == 'success') {
                            toastr.success('Taken Successfully','', { timeOut: 300 });


                            $('#application_table').load(location.href+' #application_table');

                            // location.reload();
                        }
                        if (response.status == 'false') {
                            toastr.warning(response.error);
                            // location.reload();
                        }

                    },
                });




        }


        function applicantShortlist(app_id , job_id){


            // console.log(job_id);
            var id = app_id;
                $.ajax({

                    type: 'POST',
                    url: "{{ route('admin.job_offers.application-shortlist') }}",
                    data: {
                        id: id,
                        job_id: job_id,
                    },
                    success: function(response) {

                        // console.log(response);

                        if (response.status == 'success') {
                            toastr.success('Shortlisted Successfully','', { timeOut: 300 });


                            $('#application_table').load(location.href+' #application_table');

                            // location.reload();
                        }
                        if (response.status == 'false') {
                            toastr.warning('Already shortlisted');
                            // location.reload();
                        }

                    },
                });




            }

        $(document).ready(function() {

            // taken script


            //  create note script

            $('.taken_note').on('click', function(e) {

                var id = $(this).data('id');
                $('#note_modal').modal('show');
                $('.taken_id').val(id);
                $.ajax({

                    type: 'POST',
                    url: "{{ route('admin.applied_tutor.note.get') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 'success') {
                            $('.note_description').text(response.message);
                        }
                        if (response.status == 'error') {
                            $('.note_description').text('');
                        }

                    },
                });


            });

            $('.note_submit').on('click', function() {

                var note_description = $('.note_description').val();
                var id = $('.taken_id').val();
                $.ajax({

                    type: 'POST',
                    url: "{{ route('admin.applied_tutor.note') }}",
                    data: {
                        id: id,
                        description: note_description
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 'success') {
                            toastr.success("note saved successfully");
                            $('#note_modal').modal('hide');
                            location.reload();

                        }

                    },
                });


            });


            // note log script

            $('.note_log').on('click', function(e) {

                var id = $(this).data('id');
                $('#log_note_modal').modal('show');
                $('.taken_id').val(id);
                $.ajax({

                    type: 'POST',
                    url: "{{ route('admin.applied_tutor.note.log') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('.note_table').html(response.data);
                        }
                        if (response.status == 'error') {
                            $('.note_table').text(response.message);
                        }

                    },
                });


            });
            // new assign tutor this job offer script

            $('.assign_tutor').on('click', function(e) {
                var id = $(this).data('id');
                $('#assign_tutor_new').modal('show');
                $('.offer_id').val(id);

            });
            $('.assign_tutor_submit_btn').on('click', function (e) {
                var id = $('.offer_id').val();
                var tutor_id = $('.assign_input').val();

                if (tutor_id == '') {
                    toastr.warning('Tutor ID or Phone Required');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.new.tutor.assign') }}",
                    data: {
                        id: id,
                        tutor_id: tutor_id
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            $('#assign_tutor_new').modal('hide');
                            location.reload();
                        }
                        if (response.status == 'error') {
                            toastr.warning(response.message);
                        }
                    },
                });
            });

            // delete applied tutor from application


            $('.delete_applied_tutor').on('click', function(e) {
                var id = $(this).data('id');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User clicked "OK", proceed with the AJAX request
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('admin.applied_tutor.delete') }}",
                            data: {
                                id: id
                            },
                            success: function(response) {

                                // console.log(response);

                                if (response.status == 'success') {
                                    toastr.success(response.message,'', { timeOut: 300 })
                                    $('#application_table').load(location.href+' #application_table');


                                }

                            },
                        });
                    }
                });
            });


        });

        function dateTime(dateTime) {

            let xx = dateTime;
            const myArray = xx.split(" ");

            let date = new Date(myArray[0]);
            let year = new Intl.DateTimeFormat('en', {
                year: 'numeric'
            }).format(date);
            let month = new Intl.DateTimeFormat('en', {
                month: 'short'
            }).format(date);
            let day = new Intl.DateTimeFormat('en', {
                day: '2-digit'
            }).format(date);

            let time = myArray[1];

            var hour = parseInt(time.split(":")[0]) % 12;
            var timeInAmPm = (hour == 0 ? "12" : hour) + ":" + time.split(":")[1] + " " + (parseInt(parseInt(time.split(
                ":")[0]) / 12) < 1 ? "am" : "pm");

            $("#date").text(`${day} ${month} ${year}`);
            $("#time").text(timeInAmPm);

        }

        // checkall js

        $(document).ready(function() {
            // Check all checkboxes
            $("#check-All").change(function() {
                var atLeastOneChecked = $(".check-row:checked").length > 0;
                $(".check-row").prop('checked', $(this).prop("checked"));
                //   $('#go_invoice').prop('disabled', false);

            });

            // Check individual checkbox
            $(".check-row").change(function() {
                var atLeastOneChecked = $(".check-row:checked").length > 0;
                if (!$(this).prop("checked")) {

                    $("#check-All").prop("checked", false);

                }

            });


            $('#sendBulkSmsApplicant').on('click',function(e){
                e.preventDefault();
                var offer_id = $('.offer_id').val();

                var listingCheckedRows = $(".check-row:checked");
                var ListingSelectedData = [];
                listingCheckedRows.each(function() {
                    var id = $(this).data("id");
                    ListingSelectedData.push(id);
                });
                if (Object.keys(ListingSelectedData).length === 0) {

                toastr.warning('Opps! select at least one item.');
                return;
                // Do not proceed with the AJAX request
                }

                $('.job_id').val(offer_id);
                    $('.tutor_id').val(ListingSelectedData);
                    $('#bulkSmsForm').submit();


            });




        });


    </script>

<script>
    function handleClick() {
        // Disable the button to prevent double-click

        document.getElementsByClassName("myButton_take").disabled = true;

    }
</script>
@include('backend.taken_offer.js.index_page_js');

@include('backend.job_offers.js.all_offer_page_js')
@endpush
