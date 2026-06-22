@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')
<main class="container-custom">
    @if(session('message'))
        <p class="alert alert-success">{{ session('message') }}</p>
        @endif

    <div class="col-md-12 ms-sm-auto col-lg-12" style="margin-top: 62px">
        <!-- mini nav starts here -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
                <a class="text-decoration-none text-gray-800 text-nowrap active-border" href="{{route('parent.index')}}">Parents
                    Profile</a>
            </div>
            <button class="btn btn-info mx-3 py-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#addProfileModal"
                style="background: #3378c2">
                Add profile
            </button>
        </div>
        <!-- mini nav ends here -->
        <!-- main content section starts here -->
        <!-- header cards starts here -->

        <div class="row row-cols-1 gap-4 row-cols-md-2 row-cols-lg-4 gap-md-0 ms-1 me-1">

            <div class="mb-md-4 mb-lg-0">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">{{$active_parent_count}}</p>
                    <p class="text-center mb-0">Active Profile</p>
                </div>
            </div>
            <div class="mb-md-4 mb-lg-0">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">{{$deactive_parent_count}}</p>
                    <p class="text-center mb-0 text-nowrap">Inactive Profile</p>
                </div>
            </div>
            <div class="">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">{{$male_parent_count}}</p>
                    <p class="text-center mb-0">Male Profile</p>
                </div>
            </div>
            <div class="">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">{{$female_parent_count}}</p>
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
                    <a href="{{route('admin.inactive.parent')}}" class="btn btn-warning grayed">Inactive Profile</a>
                </div>
                <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                    <form action="{{route('admin.parent.search')}}" method="POST">
                        @csrf
                        <input name="search" type="text" class="form-control rounded" placeholder="Search" />
                       {{-- <i class="bi bi-search text-muted ms-1"></i> --}}
                       {{-- <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                           placeholder="Search" style="padding: 12px 18px" id="" />
                       <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button> --}}
                   </form>
                    <select class="form-select rounded" style="width: 100px">
                        <option selected value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="300">300</option>
                        <option value="500">500</option>
                    </select>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                <div class="bg-white pb-4 mb-b">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover bg-white shadow-none"
                            style="border-collapse: collapse">
                            <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                <tr>
                                    <th scope="col" class="text-nowrap">
                                        <input class="form-check-input ms-3 ms-xxl-4" type="checkbox" value=""
                                            id="flexCheckDefault" style="margin-right: 12px" />#SL
                                    </th>
                                    <th scope="col" class="text-nowrap">Date</th>
                                    <th scope="col" class="text-nowrap">Parents ID</th>
                                    <th scope="col" class="text-nowrap">Name</th>
                                    <th scope="col" class="text-nowrap">Phone</th>
                                    <th scope="col" class="text-nowrap">Location</th>
                                    <th scope="col" class="text-nowrap">Gender</th>
                                    <th scope="col" class="text-nowrap">Channel</th>
                                    <th scope="col" class="text-nowrap">Status</th>
                                    <th scope="col" class="text-nowrap">Sms</th>
                                    <th scope="col" class="text-nowrap">Action By</th>
                                    <th scope="col" class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parents as $parentt)
                                <tr class="align-middle">
                                    <td scope="row" class="text-center text-nowrap" style="padding: 30px 18px">
                                        <input class="checkboxx" type="checkbox" name="ids" id="{{ $parentt->id }}" value="{{ $parentt->id }}" />
                                        <a class="text-decoration-none text-gray-700 btn" id="{{$parentt->created_at}}" onclick="dateTime(this.id)" data-bs-toggle="modal" data-time="{{ $parentt->created_at->diffForHumans() }}"
                                          data-bs-target="#exampleModal2">


                                        </a>
                                    </td>
                                    <td class="">
                                        <a type="button" class="text-decoration-none text-gray-800 text-nowrap" data-bs-toggle="modal"
                                          data-bs-target="#showDateTimeModal">
                                          @php
                                                $input  = $parentt->created_at;
                                                $format1 = 'd-m-Y';
                                                $format2 = 'H:i:s';
                                                $date = Carbon\Carbon::parse($input)->format($format1);
                                                // $time = Carbon\Carbon::parse($input)->format($format2);
                                            @endphp
                                          {{$date}}
                                        </a>
                                      </td>
                                    <td class="text-info">
                                        <a href="/log-files/view/aboutme.html"
                                            class="text-decoration-none text-info">{{$parentt->id}}</a>
                                        <div style="display: inline-block">
                                            @if ($parentt->is_verified == 1)

                                            <img src="{{ asset('images/blue-tick-mark.svg') }}" alt="blue-tick" />
                                            @endif
                                            @if ($parentt->is_super == 1)
                                            <img src="{{asset('images/green-star.svg')}}" alt="green-star" />
                                            @endif
                                            @if ($parentt->is_unplesant == 1)
                                            <img src="{{asset('images/red-face.svg')}}" alt="red-face" />
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">{{$parentt->name}}</td>
                                    <td>{{$parentt->phone}}</td>
                                    <td class="text-nowrap">{{$parentt->ParentPersonalInfo->address_details ?? 'n/a'}}</td>
                                    <td>{{$parentt->ParentPersonalInfo->gender ?? 'n/a'}}</td>
                                    <td class="text-nowrap">Web</td>
                                    <td scope="col" class="text-nowrap">
                                        <!-- Status Modal -->
                                        <div class="modal fade" id="statusModal_{{$parentt->id}}" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="statusModalLabel">Change Tutor Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="statusForm_{{$parentt->id}}">
                                                            <!-- Status Selection -->
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select name="status" class="form-select" aria-label="Default select example">
                                                                    <option value="1" @if ($parentt->is_active == 1) selected @endif>Active</option>
                                                                    <option value="0" @if ($parentt->is_active == 0) selected @endif>Inactive</option>
                                                                </select>
                                                            </div>
                                                            <!-- Reason for Status Change -->
                                                            <div class="mb-3">
                                                                <label for="changed_note" class="form-label">Reason for Status Change</label>
                                                                <textarea name="changed_note" class="form-control" id="changed_note_{{$parentt->id}}" rows="3"></textarea>
                                                            </div>

                                                            <!-- Fetch and Display Status Change Notes -->
                                                            @php
                                                            $tutor_status_changed_notes = \App\Models\ParentDeactivateNote::where('parent_id', $parentt->id)->orderBy('id','desc')->get();
                                                            @endphp

                                                            @if ($tutor_status_changed_notes->isNotEmpty())
                                                            <h4>Tutor Status Change Notes:</h4>
                                                            <table class="table table-responsive-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Date</th>
                                                                        <th scope="col" style="min-width: 60px;">Reason</th>
                                                                        <th scope="col">Action</th>
                                                                        <th scope="col">Changed By</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($tutor_status_changed_notes as $note)
                                                                    <tr>
                                                                        <td>{{ \Carbon\Carbon::parse($note->created_at)->format('d-m-Y H:i:s') }}</td>
                                                                        <td>{{ $note->note }}</td>
                                                                        <td>
                                                                            @if ($note->action == 1)
                                                                            <a href="#" class="btn btn-primary py-1">Active</a>
                                                                            @elseif ($note->action == 0)
                                                                            <a href="#" class="btn btn-danger py-1">Inactive</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $note->action_by }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            @else
                                                            <p>No status change notes found for this tutor.</p>
                                                            @endif
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <!-- Save changes button with AJAX -->
                                                        <button id="saveChanges_{{$parentt->id}}" type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Button to Trigger Modal -->
                                        @if (Auth::user()->role_id == 1)
                                        <button class="btn @php echo $parentt->is_active == 1 ? 'btn-primary' : 'btn-danger'; @endphp py-1"
                                            data-bs-toggle="modal" data-bs-target="#statusModal_{{$parentt->id}}">
                                            @if ($parentt->is_active == 1) Active @endif
                                            @if ($parentt->is_active == 0) Inactive @endif
                                        </button>
                                        @else
                                        <button class="btn @php echo $parentt->is_active == 1 ? 'btn-primary' : 'btn-danger'; @endphp py-1">
                                            @if ($parentt->is_active == 1) Active @endif
                                            @if ($parentt->is_active == 0) Inactive @endif
                                        </button>
                                        @endif

                                        <!-- AJAX Script to Handle Status Change -->
                                        <script>
                                            $(document).ready(function () {
                                                // Set up CSRF token for all AJAX requests
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });

                                                $('#saveChanges_{{$parentt->id}}').on('click', function () {
                                                    var formData = $('#statusForm_{{$parentt->id}}').serialize();

                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '{{ route("admin.deactivate.parent", ["id" => $parentt->id]) }}', // Ensure this has the correct dynamic $parentt->id
                                                        data: formData,
                                                        dataType: 'json',
                                                        success: function (data) {
                                                            Swal.fire({
                                                                position: "top-end",
                                                                icon: "success",
                                                                title: "Status Changed successfully",
                                                                showConfirmButton: false,
                                                                timer: 1500,
                                                            });
                                                            $('#statusModal_{{$parentt->id}}').modal('hide');
                                                            setTimeout(function () {
                                                                location.reload();
                                                            }, 2000);
                                                        },
                                                        error: function (xhr, status, error) {
                                                            console.error(xhr.responseText);
                                                            alert('Error updating tutor status. Please try again.');
                                                        }
                                                    });
                                                });
                                            });
                                        </script>


                                    </td>
                                    <td>
                                        <div class="switch-toggle">
                                            <div class="button-check" id="button-check" data-id="{{$parentt->id}}"
                                                onclick="liveChange({{$parentt->id}})">
                                                <input type="checkbox" class="checkbox" @if($parentt->is_sms == 1) checked @endif
                                                />
                                                <span class="switch-btn"></span>
                                                <span class="layer"></span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="">
                                        <button type="button" class="btn btn-outline-primary px-2 py-1 text-dark"
                                            data-bs-toggle="modal" data-bs-target="#viewModal_{{$parentt->id}}">
                                            <i class="bi bi-eye-fill"></i>
                                            View
                                        </button>
                                    </td>
                                     <!-- view model starts here-->
                                    <div class="modal fade" id="viewModal_{{$parentt->id}}" tabindex="-1" aria-labelledby="idInfoModalLabel_{{$parentt->id}}" aria-hidden="true">
                                        <div class="modal-dialog model-sm modal-dialog-slide-left" style="max-width: 400px">
                                            <div class="modal-content">
                                                <div class="modal-body pt-2 pb-4 px-5">
                                                    <div class="row row-cols-2 mt-3 border-bottom border-2 pb-3 align-items-center">
                                                        <p class="fw-semibold mb-0">Super Parents</p>
                                                        <div>
                                                            <p class="mb-0">{{$parentt->superer->name ?? ''}}</p>
                                                            <small>{{$parentt->super_date ?? ''}}</small>
                                                        </div>
                                                    </div>
                                                    <div class="row row-cols-2 border-bottom border-2 py-3 align-items-center">
                                                        <p class="fw-semibold mb-0">Unpleasant P..</p>
                                                        <div>
                                                            <p class="mb-0">{{$parentt->unpleaser->name ?? ''}}</p>
                                                            <small>{{$parentt->unplesant_date ?? ''}}</small>
                                                        </div>
                                                    </div>
                                                    <div class="row row-cols-2 border-bottom border-2 py-3 align-items-center">
                                                        <p class="fw-semibold mb-0">Verifyed By</p>
                                                        <div>
                                                            <p class="mb-0">{{$parentt->verify->name ?? ''}}</p>
                                                            <small>{{$parentt->verify_date ?? ''}}</small>
                                                        </div>
                                                    </div>
                                                    <div class="row row-cols-2 pt-3 align-items-center">
                                                        <p class="fw-semibold mb-0">Deactived By</p>
                                                        <div>
                                                            <p class="mb-0">{{$parentt->deactivate->name ?? ''}}</p>
                                                            <small>{{$parentt->deactive_date ?? ''}}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <td class="">
                                        <div class="d-flex gap-2">
                                            <div class="dropdown">
                                                <button class="btn shadow-none py-1 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" style="border: 1px solid #d7dfe9">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.make.super.parent', $parentt->id) }}">Super Parents</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.make.unplesant.parent', $parentt->id) }}">Unpleasant Parents</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.verify.parent', $parentt->id) }}">Verify Parents</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#alertModal" href="#">Alert</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#noteModal_{{$parentt->id}}" href="#">Note</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createNoteModal_{{$parentt->id}}" href="#">Create a Note</a>
                                                    </li>
                                                    {{-- <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logModal" href="#">Log</a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Modal for Deactivation -->
                                    <!-- Modal for Deactivation -->
                                    <!-- Modal for Deactivation -->


                                </tr>

                                <!-- Note model starts here-->
                                <!-- Note Modal -->
                                <div class="modal fade" id="noteModal_{{$parentt->id}}" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel5">Note Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div id="noteContent_{{$parentt->id}}" class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                                                    <p>Loading...</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="py-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $('[data-bs-target="#noteModal_{{$parentt->id}}"]').on('click', function () {
                                            var parentId = {{$parentt->id}};

                                            $.ajax({
                                                type: 'GET',
                                                url: '{{ route("admin.fetch.note.parent", ["id" => $parentt->id]) }}',  // Adjust the route as necessary
                                                dataType: 'json',
                                                success: function (response) {
                                                    if (response.success) {
                                                        $('#noteContent_' + parentId).empty();

                                                        response.notes.forEach(function(note) {
                                                            var noteHtml = `
                                                                <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <p class="mb-0 text-dark fs-5">${note.created_by}</p>
                                                                            <p class="text-info" style="font-size: 12px">ID-${note.created_by_id}</p>
                                                                        </div>
                                                                        <div>
                                                                            <p>${note.created_at}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <p class="fw-bold" style="font-size: 16px; color: #3b3c3d">${note.title}</p>
                                                                        <p>${note.details}</p>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <p style="font-size: 16px; color: #3b3c3d">Read More</p>
                                                                        </div>
                                                                        <div>
                                                                            <button class="btn btn-primary py-1">Edit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            `;

                                                            $('#noteContent_' + parentId).append(noteHtml);
                                                        });
                                                    } else {
                                                        $('#noteContent_' + parentId).html('<p>No notes available for this parent.</p>');
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                    $('#noteContent_' + parentId).html('<p>Error fetching the notes. Please try again later.</p>');
                                                }
                                            });
                                        });
                                    });
                                </script>


                                <!-- Note model ends here-->
                                <!-- Create Note model starts here-->
                                <div class="modal fade" id="createNoteModal_{{$parentt->id}}" tabindex="-1" aria-labelledby="createNoteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel6">Make A Note</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="createNoteForm_{{$parentt->id}}">
                                                    <div class="mb-3">
                                                        <label for="noteTitle_{{$parentt->id}}" class="form-label text-dark">Note Title</label>
                                                        <input type="text" class="form-control shadow-none rounded-3" id="noteTitle_{{$parentt->id}}" name="note_title" placeholder="Maximum 8 words can be given" />
                                                    </div>
                                                    <div>
                                                        <label for="noteDetails_{{$parentt->id}}" class="form-label text-dark">Note Details</label>
                                                        <textarea class="form-control shadow-none rounded-3" id="noteDetails_{{$parentt->id}}" name="note_details" rows="3" placeholder="Maximum 30 words can be given"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary shadow-lg" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="saveNote_{{$parentt->id}}">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $('#saveNote_{{$parentt->id}}').on('click', function () {
                                            // Collect the form data
                                            var formData = {
                                                note_title: $('#noteTitle_{{$parentt->id}}').val(),
                                                note_details: $('#noteDetails_{{$parentt->id}}').val(),
                                                _token: '{{ csrf_token() }}'
                                            };

                                            $.ajax({
                                                type: 'POST',
                                                url: '{{ route("admin.cretae.note.parent", ["id" => $parentt->id]) }}',  // Correct route
                                                data: formData,
                                                dataType: 'json',
                                                success: function (response) {
                                                    if (response.success) {
                                                        Swal.fire({
                                                            position: 'top-end',
                                                            icon: 'success',
                                                            title: 'Note saved successfully',
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        });
                                                        // Close the modal
                                                        $('#createNoteModal_{{$parentt->id}}').modal('hide');
                                                        setTimeout(function () {
                                                            location.reload();
                                                        }, 1500);
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: response.message
                                                        });
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: 'There was an error saving the note. Please try again.'
                                                    });
                                                }
                                            });
                                        });
                                    });
                                </script>


                                <!-- Create Note model ends here-->



                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- pagination starts here -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                        {{$parents->links()}}
                    </div>
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
        <div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="payLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slide-top" style="max-width: 600px">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                            Create Parents Profile
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createParentForm">
                        <div class="modal-body pt-0">
                            @csrf
                            <div class="row row-cols-md-2">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-dark text-sm required">Name</label>
                                    <input id="name" name="name" class="shadow-none rounded-3 form-control" placeholder="Enter your name" />
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label text-dark text-sm required">Phone</label>
                                    <input id="phone" name="phone" class="shadow-none rounded-3 form-control" placeholder="Enter your phone" />
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-dark text-sm">Email</label>
                                    <input id="email" name="email" class="shadow-none rounded-3 form-control" placeholder="Enter your email" />
                                </div>
                                <div class="mb-3">
                                    <label for="gndr" class="form-label text-dark text-sm required">Gender</label>
                                    <select id="gndr" name="gender" class="shadow-none rounded-3 form-select">
                                        <option selected value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3 mb-md-0">
                                    <label for="pass" class="form-label text-dark text-sm required">Password</label>
                                    <input id="Password" name="password" class="shadow-none rounded-3 form-control bg-light" placeholder="12345678 / By Default" disabled />
                                </div>
                                <div class="mb-3 mb-md-0">
                                    <label for="pass" class="form-label text-dark text-sm required">Re-Password</label>
                                    <input id="rePassword" class="shadow-none rounded-3 form-control bg-light" placeholder="12345678 / By Default" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--  Alert model starts here-->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertNoteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1100px">
                <div class="modal-content px-2 pb-2">
                    <div class="modal-body pb-0">
                        <form action="">
                            <div>
                                <label for="exampleFormControlTextarea1" class="form-label text-dark">Alert Note</label>
                                <textarea class="form-control shadow-none rounded-3" id="exampleFormControlTextarea1"
                                    rows="3" placeholder="Enter a note here..."></textarea>
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-warning rounded-3">
                                        Alert
                                    </button>
                                </div>
                                <div class="mt-4">
                                    <p class="text-center mb-4">Alert Note Details</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered shadow-none" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col" style="min-width: 300px !important">
                                                        Reason
                                                    </th>
                                                    <th scope="col" class="text-nowrap">
                                                        Alert By
                                                    </th>
                                                    <th scope="col" class="text-nowrap"
                                                        style="min-width: 300px !important">
                                                        Restore Note
                                                    </th>
                                                    <th scope="col" class="text-nowrap">
                                                        Restored By
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="vertical-align: middle">
                                                    <td>
                                                        <p class="mb-0 text-nowrap">2022-01-01</p>
                                                        <p class="mb-0 text-muted text-nowrap">
                                                            47: 15: 12 PM
                                                        </p>
                                                    </td>
                                                    <td>
                                                        It is a long established fact that a reader
                                                        will be distracted by the readable content.
                                                    </td>
                                                    <td class="text-nowrap">Super Admin</td>
                                                    <td>
                                                        It is a long established fact that a reader
                                                        will be distracted by the readable content.
                                                    </td>
                                                    <td class="text-nowrap">Super Admin</td>
                                                </tr>
                                                <tr style="vertical-align: middle">
                                                    <td>
                                                        <p class="mb-0 text-nowrap">2022-01-01</p>
                                                        <p class="mb-0 text-muted text-nowrap">
                                                            47: 15: 12 PM
                                                        </p>
                                                    </td>
                                                    <td>
                                                        It is a long established fact that a reader
                                                        will be distracted by the readable content.
                                                    </td>
                                                    <td class="text-nowrap">Super Admin</td>
                                                    <td>
                                                        It is a long established fact that a reader
                                                        will be distracted by the readable content.
                                                    </td>
                                                    <td class="text-nowrap">Super Admin</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alert model ends here-->
        <!--  Deactive model starts here-->


        <!-- Deactive model ends here-->
        <!-- main content section ends here -->
    </div>
</main>


{{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p>Edit & Update Parents</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="" method="post" action="{{route('parent.update','parent')}}">
                    @csrf

                    <input type="hidden" name="_method" value="put" />
                    <input class="form-control" type="hidden" id="parent_id" name="parent_id" value="">
                    <label style="" class="form-labal">Full Name</label><br>
                    <input type="text" value="" class="form-control name" name="name" id="name" required>
                    <label style="" class="form-labal">Email</label><br>
                    <input type="text" value="" class="form-control name" name="email" id="email">
                    <label style="" class="form-labal">Phone</label><br>
                    <input type="text" value="" class="form-control name" name="phone" id="phone" required>
                    <label style="" class="form-labal">Additional Phone</label><br>
                    <input type="text" value="" class="form-control name" name="additional_phone" id="additional_phone">
                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="btnEdit()">Update Parent</button>
            </div>
            </form>

        </div>

    </div>
</div>


{{-- end Edit Modal --}}



{{-- start sms modal  --}}
<div class="modal" id="smsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- end sms modal --}}


<form style="display: none" action="{{route('admin.parent.sms-editor')}}" method="POST" id="smsForm">
    @csrf
    <input type="hidden" id="var1" name="all_id" value="" />
</form>

@endsection


@push('page_scripts')

@include('js.swtdeleteMethod_js')
@include('backend.parents.js.index_page_js')

<script>
    function stageJobId(buttonId, param2, param3, parentId) {
        // Assuming param2 and param3 might be needed for something else
        $('#deactivate_parent_id').val(parentId); // Set parent ID in the hidden input field
    }
</script>

<script>
    $(document).ready(function() {
        $('#createParentForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Gather form data
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route("admin.create.parent") }}',  // URL of the form action
                type: 'POST',
                data: formData,  // Send serialized form data
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#createParentForm')[0].reset();
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Error: " + response.message,
                            showConfirmButton: true
                        });
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "An error occurred.";
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: errorMessage,
                        showConfirmButton: true
                    });
                }
            });
        });
    });

    function liveChange(id){
        var isChecked = $(".checkbox").is(":checked");
                var newState = isChecked ? 1 : 0;
                $.ajax({
                    url: "{{ route('admin.parent.sms.status')}}",
                    type: "POST",
                    data: { state: newState,id:id },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                    }
                });


        }
</script>

@endpush
