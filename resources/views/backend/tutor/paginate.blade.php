@extends('layouts.app')
@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>


<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #11ee24;
        color: black;
    }

</style>
@endpush
{{-- <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" /> --}}

@section('content')
<main class="">
    <div class="col-md-9 ms-sm-auto col-lg-12" style="">
        <!-- mini nav starts here -->
        <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
            <a class="text-decoration-none text-gray-800 active-border" href="{{route('tutor.index')}}">All Tutors</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.premium')}}">Premium Tutor</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.featured')}}">Featured Tutor</a>
        </div>

        @if(session('message'))
        <p class="alert alert-success">{{ session('message') }}</p>
        @endif

        <div id="count" style="margin-left: 18px">
            <div class="row">
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $all_tutor_count + 1450 ?? ''}}</h2>
                        <span>All Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ App\Models\Tutor::whereDate('created_at', today())->count() }}
                        </h2>
                        <span>Today New Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $male_tutor_count + 820?? ''}}</h2>
                        <span>Male Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $female_tutor_count + 630?? ''}}</h2>
                        <span>Female Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $premium_tutor_count ?? ''}}</h2>
                        <span>Premium Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ $featured_tutor_count ?? ''}}</h2>
                        <span>Featured Tutors</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ App\Models\TutorEducation::where('degree_name', 'ssc')
                        ->where('curriculum_id',2)
                        ->count() }}
                        </h2>
                        <span>English Medium(S.S.C)</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ App\Models\TutorEducation::where('degree_name', 'hsc')
                        ->where('curriculum_id',2)
                        ->count() }}
                        </h2>
                        <span>English Medium(H.S.C)</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ App\Models\TutorEducation::where('degree_name', 'ssc')
                        ->where('curriculum_id',3)
                        ->count() }}
                        </h2>
                        <span>English Version(S.S.C)</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ App\Models\TutorEducation::where('degree_name', 'hsc')
                        ->where('curriculum_id',3)
                        ->count() }}
                        </h2>
                        <span>English Version(H.S.C)</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="report-card card" style="text-align:center">
                        <h2>{{ App\Models\TutorCourse::where('course_id', 80)
                        ->count() }}
                        </h2>
                        <span>Islamic Studies Tutor</span>
                    </div>
                </div>

                {{-- @if (session('message'))
                    <br>
                    <p class="alert alert-success">{{ session('message') }}</p>
                @endif --}}
            </div>


        </div>






        <!-- mini nav ends here -->
        <!-- main content section starts here -->
        <div class="ps-3" style="padding-right: 13px">



            <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">

                <div class="d-flex justify-content-between gap-3">

                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="bi bi-sliders2 me-1"></i>Filter
                    </button>
                    <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>

                    <a href="{{ route('tutor.create') }}" class="btn btn-outline-ndark">Add New Tutor</a>
                    @if (Auth::user()->role_id == 1)
                    <a href="{{ route('admin.tutors.trash') }}" class="btn btn-outline btn-warning">Trash List</a>
                    @endif

                    <form action="{{route('admin.tutor.search')}}" method="POST">
                        @csrf
                </div>


                <div class="d-flex gap-3">
                    <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                        style="border: 1px solid #cfdfdb">
                        {{-- <i class="bi bi-search text-muted ms-1"></i> --}}
                        <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                            placeholder="Search" style="padding: 12px 18px" id="" />
                        <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
                        </form>
                    </div>
                    <form id="paginationLimitForm" action="{{ route('tutor.index') }}" method="GET">
                        <input type="hidden" name="pagination_limit" id="paginationLimitInput" value="{{ $input }}">
                        <select id="paginationLimit" class="form-select rounded" style="width: 100px">
                            <option value="50" {{ $input == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $input == 100 ? 'selected' : '' }}>100</option>
                            <option value="200" {{ $input == 200 ? 'selected' : '' }}>200</option>
                            <option value="300" {{ $input == 300 ? 'selected' : '' }}>300</option>
                            {{-- <option value="500" {{ $input == 500 ? 'selected' : '' }}>500</option> --}}
                        </select>
                    </form>

                </div>
            </div>
            <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                <table id="example1" class="table table-responsive table-hover bg-white shadow-none"
                    style="border-collapse: collapse" id="tutor_data_table">
                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                        <tr>
                            <th scope="col" class="text-nowrap">


                                <input class="" type="checkbox" value="" id="select_all" style="margin-right: 12px" />
                                &nbsp &nbsp &nbsp Date
                            </th>
                            <th scope="col" style="width: 10px" class="text-nowrap">Tutor ID</th>

                            <th scope="col" class="text-nowrap">Name</th>
                            {{-- <th scope="col" class="text-nowrap">Rating</th> --}}

                            <th scope="col" class="text-nowrap">University</th>
                            <th scope="col" class="text-nowrap">Department</th>
                            <th scope="col" class="text-nowrap">gender</th>
                            <th scope="col" class="text-nowrap">Address</th>
                            <th scope="col" class="text-nowrap">Verified By</th>
                            <th scope="col" class="text-nowrap">Phone</th>
                            <th scope="col" class="text-nowrap">Status</th>
                            <th scope="col" class="text-nowrap">Completion</th>

                            <th scope="col" class="text-nowrap">SMS</th>
                            <th scope="col" class="text-nowrap">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Action
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($tutors as $tutor)
                        <tr class="" style="vertical-align: middle">


                            <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                <input class="checkboxx" type="checkbox" name="ids" id="{{ $tutor->id }}"
                                    value="{{ $tutor->id }}" />
                                <a class="text-decoration-none text-gray-700 btn" id="{{$tutor->created_at}}"
                                    onclick="dateTime(this.id)" data-bs-toggle="modal"
                                    data-time="{{ $tutor->created_at }}" data-bs-target="#exampleModal2">


                                    @php
                                    $input = $tutor->created_at;
                                    $format1 = 'd-m-Y';
                                    $format2 = 'H:i:s';
                                    $date = Carbon\Carbon::parse($input)->format($format1);
                                    // $time = Carbon\Carbon::parse($input)->format($format2);
                                    @endphp
                                    {{$date}}
                                </a>
                            </td>

                            <td class="text-info">

                                {{-- <input class="form-check-input me-2" type="checkbox" value=""
                                            id="flexCheckDefault" /> --}}
                                <a href="{{route('admin.tutor.tutorshow' , ['tutor' => $tutor->id])}}"
                                    class="p-1 rounded text-info text-decoration-none"
                                    style="background-color: #e6eef7">{{$tutor->unique_id}}</a> </td>

                                    <td class="text-nowrap">{!! nl2br(e(Str::limit($tutor->name ?? 'NA', 7))) !!}
                                        @if(@$tutor->is_premium == 1)
                                        <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-regular-9c7ea3fd.svg" alt="">
                                        @endif
                                        @if(@$tutor->is_premium_pro == 1)
                                        <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-pro-fc790c7d.svg" alt="">
                                        @endif
                                        @if(@$tutor->is_premium_advance == 1)
                                        <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-advance-4b8e47d2.svg" alt="">
                                        @endif
                                        @if($tutor->is_verified == 1)
                                        <i style="color:#007BFF" class="far fa-check-circle"></i>
                                        @endif
                                        @if(@$tutor->is_internal_verify == 1 && $tutor->is_verified == 0)
                                        <i style="color:#ed228b" class="far fa-check-circle"></i>
                                        @endif
                                        @if(@$tutor->is_featured == 1)
                                        <img height="30px" src="https://tuitionterminal.com.bd/assets/featured-icon-0c358655.svg" alt="">

                                        @endif
                                        @if(@$tutor->is_boost == 1)
                                        <img height="30px" src="https://tuitionterminal.com.bd/assets/boost-icon-d47ce3c5.svg"
                                            alt="">

                                        @endif
                                    </td>


                            @php
                            $totalElements = count($tutor->tutor_education);
                            $graduation=$tutor->tutor_education->where('degree_name', 'honours')->first();


                            @endphp


                            <td class="text-nowrap">
                                {{Str::limit($graduation->institutes->title ?? 'NA', 12)}}
                            </td>
                            <td class="text-nowrap">
                                {{Str::limit($graduation->department ?? $graduation->departments->title ?? 'NA', 10)}}
                            </td>
                            <td class="text-nowrap">{{$tutor->gender}}</td>

                            <td style="width: 10px" class="text-wrap">
                                {{Str::limit( $tutor->tutor_personal_info->location->name ?? 'NA', 10) }}</td>
                            <th scope="col" class="text-nowrap">{{ optional($tutor->verifier)->name }}</th>
                            <td scope="col" class="text-nowrap">{{$tutor->phone}}</td>
                            <td scope="col" class="text-nowrap">
                                <!-- Status Modal -->
                                <div class="modal  fade" id="statusModal_{{$tutor->id}}" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Change Tutor Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="statusForm_{{$tutor->id}}">
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select name="status" class="form-select" aria-label="Default select example">
                                                            <option value="1" @if ($tutor->is_active == 0) selected @endif>Active</option>
                                                            <option value="0" @if ($tutor->is_active == 1) selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="changed_note" class="form-label">Reason Changed</label>
                                                        <textarea name="changed_note" class="form-control" id="changed_note_{{$tutor->id}}" rows="3"></textarea>
                                                    </div>
                                                    @php
                                                        $tutor_status_changed_notes = \App\Models\TutorStatusNote::where('tutor_id', $tutor->id)->get();
                                                    @endphp

                                                    @if ($tutor_status_changed_notes->isNotEmpty())
                                                        <h4>Tutor Status Change Notes:</h4>
                                                        <table class="table table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Date</th>
                                                                    <th scope="col" style="max-width: 60px;">Reason</th>
                                                                    <th scope="col">Action</th>
                                                                    <th scope="col">Changed By</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tutor_status_changed_notes as $note)
                                                                    <tr>
                                                                        <td>{{$note->created_at}}</td>
                                                                        <td >
                                                                            {{$note->changed_note}}
                                                                        </td>
                                                                        <td>
                                                                            <td>
                                                                                @if ($note->status == 1)
                                                                                    <a href="#" class="btn btn-primary py-1">Active</a>
                                                                                @elseif ($note->status == 0)
                                                                                    <a href="#" class="btn btn-primary py-1">Inactive</a>
                                                                                @endif
                                                                            </td>
                                                                        </td>
                                                                        <td>{{$note->changed_by}}</td>
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
                                                <button id="saveChanges_{{$tutor->id}}" type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(in_array(Auth::user()->role_id, [1, 6]))
                                    <button class="btn @php echo $tutor->is_active == 1 ? 'btn-primary' : 'btn-danger'; @endphp py-1"
                                            data-bs-toggle="modal" data-bs-target="#statusModal_{{$tutor->id}}">
                                        @if ($tutor->is_active == 1) Active @endif
                                        @if ($tutor->is_active == 0) Inactive @endif
                                    </button>
                                @else
                                    <button class="btn @php echo $tutor->is_active == 1 ? 'btn-primary' : 'btn-danger'; @endphp py-1">
                                        @if ($tutor->is_active == 1) Active @endif
                                        @if ($tutor->is_active == 0) Inactive @endif
                                    </button>
                                @endif

                                <!-- AJAX Script -->
                                <script>
                                    $(document).ready(function () {
                                        $('#saveChanges_{{$tutor->id}}').on('click', function () {
                                            var formData = $('#statusForm_{{$tutor->id}}').serialize();

                                            $.ajax({
                                                type: 'POST',
                                                url: '{{ route("update-tutor-status", $tutor->id) }}',
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
                                                    $('#statusModal_{{$tutor->id}}').modal('hide');
                                                    setTimeout(function() {
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


                            <th scope="col" class="text-nowrap">
                               {{ $tutor->getProfileComplete() }}% </th>



                            <td>
                                <div class="switch-toggle">
                                    <div class="button-check" id="button-check" data-id="{{$tutor->id}}"
                                        onclick="liveChange({{$tutor->id}})">
                                        <input type="checkbox" class="checkbox" @if($tutor->is_sms == 1) checked @endif
                                        />
                                        <span class="switch-btn"></span>
                                        <span class="layer"></span>
                                    </div>
                                </div>
                            </td>

                            <td>

                                <a href="{{ route('admin.tutor.tutorshow', ['tutor' => $tutor->id]) }}"><button
                                        class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </button></a>
                                <a href="{{ route('admin.tutor.single-sms', ['tutor' => $tutor->id]) }}">
                                    <button class="btn btn-info btn-sm">
                                        <i class="fa fa-envelope"></i>
                                    </button></a>

                                <button id="{{ $tutor->id }}" onclick="btnEdit(this.id)" class="btn btn-warning btn-sm"
                                    data-toggle="modal" data-target="#editModal">
                                    <i class="fa fa-edit"></i>
                                </button>


                                <br>
                                <a href="{{route('admin.tutor.edit-info', ['tutor' => $tutor->id])}}"> <button
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>Edit Info
                                    </button></a>


                                {{-- @if (Auth::user()->role_id == 1)
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteNoteModal_{{$tutor->id}}"><i class="fa fa-trash"></i></button>
                                @endif --}}
                                {{-- <div class="modal fade" id="deleteNoteModal_{{$tutor->id}}" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content text-center">
                                            <form id="btndelete{{ $tutor->id }}" action="{{ route('tutor.destroy', ['tutor' => $tutor->id]) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('delete')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="tutor_delete_note{{$tutor->id}}" class="form-label">Enter your note here:</label>
                                                        <input type="text" class="form-control" id="tutor_delete_note{{$tutor->id}}" name="tutor_delete_note" placeholder="Enter your note here...">
                                                    </div>
                                                </div>
                                                <div class="modal-footer text-center">
                                                    <button type="button" class="btn btn-danger btn-lg" id="{{ $tutor->id }}" onclick="tutorDeleteBtn(this.id)">Delete Tutor</button>
                                                </div>
                                            </form>

                                            <div class="modal-body">
                                                @php
                                                        $tutor_delete = \App\Models\TutorDeleteNote::where('tutor_id', $tutor->id)->get();
                                                    @endphp
                                                @if ($tutor_delete->isNotEmpty())
                                                    <h4>Tutor Delete Restore Notes:</h4>
                                                    <table class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Date</th>
                                                                <th scope="col" style="max-width: 60px;">Reason</th>
                                                                <th scope="col">Deleted By</th>
                                                                <th scope="col">Restored Note</th>
                                                                <th scope="col">Restored By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($tutor_delete as $deletenote)
                                                                <tr>
                                                                    <td>{{$deletenote->created_at ?? ''}}</td>
                                                                    <td>{{$deletenote->delete_note ?? ''}}</td>
                                                                    <td>{{$deletenote->deleteuser->name ?? ''}}</td>
                                                                    <td>{{$deletenote->restore_note ?? ''}}</td>
                                                                    <td>{{$deletenote->restoreuser->name ?? ''}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <p>No status change notes found for this tutor.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}



                                {{-- <a class="btn btn-info" href="{{ route('tutor.make.premium', ['tutor' => $tutor->id]) }}">Make
                                Premium</a> --}}
                                {{-- <a  href="{{ route('tutor.make.featured', ['tutor' => $tutor->id]) }}">Make
                                Featured</a> --}}

                                @if ($tutor->is_alerted == 1)

                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#alertModalUndo_{{$tutor->id}}"><i class="fa fa-bell"></i></button>


                                        <div class="modal fade" id="alertModalUndo_{{$tutor->id}}" tabindex="-1"
                                            aria-labelledby="dateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content text-center">
                                                    <form id="btnalertundo{{ $tutor->id }}"
                                                        action="{{ route('tutor.undo.alert', ['tutor' => $tutor->id]) }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="changed_noteUndo_{{$tutor->id}}"
                                                                    class="form-label">Alert Undo Note Enter:</label>
                                                                <input required type="text" class="form-control"
                                                                    id="changed_noteUndo_{{$tutor->id}}"
                                                                    name="changed_note"
                                                                    placeholder="Enter your note here...">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="submit" class="btn btn-danger btn-lg">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                @foreach($tutors as $tutor)
                                                document.getElementById('btnalertundo{{ $tutor->id }}').addEventListener('submit', function (event) {
                                                    event.preventDefault();
                                                    var form = this;

                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: "You are about to undo this alert!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Yes, send it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            form.submit();
                                                        }
                                                    });
                                                });
                                                @endforeach
                                            });
                                        </script>
                                @elseif($tutor->is_alerted == Null)
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#alertModal_{{$tutor->id}}"><i class="fa fa-bell"></i></button>

                                <div class="modal fade" id="alertModal_{{$tutor->id}}" tabindex="-1"
                                    aria-labelledby="dateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content text-center">
                                            <form id="btnalert{{ $tutor->id }}"
                                                action="{{ route('tutor.make.alert', ['tutor' => $tutor->id]) }}"
                                                method="POST" style="display:inline">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="changed_note_{{$tutor->id}}"
                                                            class="form-label">Make Alert note here:</label>
                                                        <input required type="text" class="form-control"
                                                            id="changed_note_{{$tutor->id}}"
                                                            name="changed_note"
                                                            placeholder="Enter your note here...">
                                                    </div>
                                                </div>
                                                <div class="modal-footer text-center">
                                                    <button type="submit" class="btn btn-danger btn-lg">Submit</button>
                                                </div>
                                            </form>

                                            <div class="modal-body">
                                                @php
                                                $tutor_alert = \App\Models\TutorAlertNote::where('tutor_id',
                                                $tutor->id)->get();
                                                @endphp
                                                @if ($tutor_alert->isNotEmpty())
                                                <h4>Tutor Alert Notes:</h4>
                                                <table class="table table-responsive-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Date</th>
                                                            <th scope="col" style="max-width: 60px;">Reason</th>
                                                            <th scope="col">Changed By</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tutor_alert as $alert_note)
                                                        <tr>
                                                            <td>{{$alert_note->created_at ?? ''}}</td>
                                                            <td>{{$alert_note->changed_note ?? ''}}</td>
                                                            <td>
                                                                @if ($alert_note->changed_by != null)
                                                                {{$alert_note->changedByUser->name ?? ''}}

                                                                @elseif ($alert_note->undo_by != null)
                                                                {{$alert_note->undoByUser->name ?? ''}}

                                                                @endif
                                                            </td>
                                                            <td>


                                                                @if ($alert_note->status == 0)
                                                                <button type="button" class="btn btn-success btn-sm"
                                                                    >Undo</button>

                                                                @elseif($alert_note->status == 1)
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    >Alerted</button>

                                                                @endif

                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                <p>No status change notes found for this tutor.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        @foreach($tutors as $tutor)
                                        document.getElementById('btnalert{{ $tutor->id }}').addEventListener('submit', function (event) {
                                            event.preventDefault();
                                            var form = this;

                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You are about to send this alert!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, send it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    form.submit();
                                                }
                                            });
                                        });
                                        @endforeach
                                    });
                                </script>
                                @endif





                                @if ($tutor->is_premium == 0)
                                <form style="font-size: 0" id="btnConfirmPremium{{ $tutor->id }}"
                                    action="{{ route('tutor.make.premium', ['tutor' => $tutor->id]) }}" method="POST">
                                    @csrf
                                    <button id="{{ $tutor->id }}" type="button" class="btn btn-success btn-sm"
                                        onclick="btnConfirmPremium(this, this.id)">Make Premium</button>
                                </form>

                                @endif

                                @if ($tutor->is_featured == 0)
                                <form style="font-size: 0" id="btnConfirmFeatured{{ $tutor->id }}"
                                    action="{{ route('tutor.make.featured', ['tutor' => $tutor->id]) }}" method="POST">
                                    @csrf
                                    <button id="{{ $tutor->id }}" type="button" class="btn btn-info btn-sm"
                                        onclick="btnConfirmFeatured(this, this.id)">Make Featured</button>
                                </form>

                                @endif


                                @if ($tutor->is_verified == 0)
                                <form style="display:inline" id="verifyTutor{{ $tutor->id }}"
                                    action="{{ route('admin.tutor.verify', ['tutor' => $tutor->id]) }}" method="POST">
                                    @csrf
                                    <button id="{{ $tutor->id }}" type="button" class="btn btn-sm btn-primary"
                                        onclick="verifyTutor(this, this.id)">Verify</button>
                                </form>

                                @endif

                                <button class="btn btn-sm btn-primary" id="{{ $tutor->id }}" onclick="btnNote(this.id)"
                                    data-bs-toggle="modal" data-bs-target="#tutorNoteModal">
                                    Note
                                </button>


                                @if ($tutor->is_alerted == null)
                                <form style="font-size: 0" id="btnConfirmAlert{{ $tutor->id }}"
                                    action="{{ route('tutor.make.alert', ['tutor' => $tutor->id]) }}" method="POST">
                                    @csrf

                                    <button class="btn btn-sm btn-primary" type="button" id="{{ $tutor->id }}" onclick="btnConfirmAlert(this, this.id)"
                                        >
                                        <i class="fa fa-bell"></i>
                                    </button>
                                </form>

                                @endif
                                {{-- @if ($tutor->is_alerted == 1)
                                <form style="font-size: 0" id="btnUndoAlert{{ $tutor->id }}"
                                    action="{{ route('tutor.undo.alert', ['tutor' => $tutor->id]) }}" method="POST">
                                    @csrf

                                    <button class="btn btn-sm btn-danger" type="button" id="{{ $tutor->id }}" onclick="btnUndoAlert(this, this.id)"
                                        >
                                        <i class="fa fa-bell "></i>
                                    </button>
                                </form>

                                @endif --}}
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="d-flex justify-content-center align-items-center gap-2">

                    {{ $tutors->appends(request()->except('page'))->links() }}

                </div>
            </div>
        </div>
        <!-- main content section ends here -->

    </div>


    <form action="{{route('admin.tutor.filter')}}" method="post">
        @csrf
        <!-- Filter model starts here -->
        <div class="modal fade font-pop" id="exampleModal" tabindex="" aria-labelledby="">
            <div class="modal-dialog modal-dialog-centered px-3" style="max-width: 1100px">
                <div class="modal-content pt-4 pb-4 ps-2">
                    <div class="modal-header pe-5" style="padding-left: 40px">
                        <h1 class="modal-title fs-5" id="">
                            Filter
                            <span class="text-muted fw-light" style="font-size: 12">
                            </span>
                        </h1>

                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <div class="row row-cols-2 row-cols-lg-4 pb-2 ps-4">
                            <div class="d-flex">
                                <div style="width: 220px">
                                    <div class="pb-3">
                                        <label for="cun" class="form-label required">Country</label>
                                        <select name="country_id" class="form-select rounded-3 shadow-none "
                                            aria-label="Default select " id="country_id">
                                            <option value="">Select Country</option>
                                            @foreach (App\Models\Country::OrderBy('name','asc')->get() as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text country_id_error"></span>

                                    </div>

                                    <div class="pb-3">
                                        <label for="cty" class="form-label">City</label>
                                        <br>
                                        <select name="city_id" id="city_id" style="width: 215px"
                                            class="shadow rounded-2 form-select" aria-label="Default select example">
                                            <option selected value="">Select city</option>


                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="loc" class="form-label">Location</label>
                                        <br>
                                        <select id="location_id" name="location_id" style="width: 215px"
                                            class="shadow rounded-2 form-select" aria-label="Default select example">
                                            <option selected value="">Select Location</option>

                                        </select>
                                    </div>


                                    <div class="pb-3">
                                        <label for="daw" class="form-label">Teaching Method</label>
                                        <select id="method_id" name="method_id" class="shadow rounded-2 form-select"
                                            aria-label="Default select example">
                                            <option selected>select Teaching Method</option>

                                            @foreach (App\Models\TeachingMethod::OrderBy('name','asc')->get() as
                                            $teachingM)

                                            <option value="{{$teachingM->id}}">{{$teachingM->name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 ms-4" style="
                                    margin-top: 34px;
                                    width: 1px;
                                    background-color: #f0f1f2;">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="pb-3">
                                        <label for="datef" class="form-label">Date from</label>
                                        <div>
                                            <input name="datef" type="date" class="form-control shadow rounded-2"
                                                id="datef" />
                                        </div>
                                    </div>
                                    <div class="pb-3">
                                        <label for="datet" class="form-label">Date To</label>
                                        <input name="datet" type="date" class="form-control shadow rounded-2"
                                            id="datet" />
                                    </div>
                                    <div class="pb-3">
                                        <label for="cty" class="form-label">Year</label>
                                        <br>
                                        <select name="year" class="shadow rounded-2 form-select"
                                            aria-label="Default select example" id="year">
                                            <option selected>Select Year</option>
                                            <option value="First Year">First Year</option>
                                            <option value="Second Year">Second Year</option>
                                            <option value="Third Year">Third Year</option>
                                            <option value="Fourth Year">Fourth Year</option>
                                            <option value="Fifth Year">Fifth Year</option>
                                            <option value="Graduation Completed">Graduation Completed</option>
                                        </select>
                                    </div>


                                    <div class="pb-3">
                                        <label for="tm" class="form-label">Gender</label>
                                        <select name="gender" id="gender" class="shadow rounded-2 form-select"
                                            aria-label="Default select example">
                                            <option selected value=''>select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
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
                                        <label for="cat" class="form-label">Category</label>

                                        <select multiple name="category_id[]" id="category_id"
                                            class="shadow rounded-2 form-select" style="width: 215px ; height: 50px"
                                            aria-label="Default select example">
                                            <option value=''>Select Category</option>
                                            @foreach(App\Models\Category::OrderBy('name','asc')->get() as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="course" class="form-label">Course</label>



                                        <select multiple name="course_id[]" class="form-select rounded-3 shadow-none"
                                            style="width: 215px" id="course_id">

                                        </select>
                                        <span class="text-danger error-text course_id_error"></span>



                                    </div>
                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label ">Subjects</label>
                                        <select name="subject_id[]" class="select2 form-select rounded-3 shadow-none" multiple id="subject_id" style="padding: 14px 10px; height: auto;">

                                        </select>
                                        <span class="text-danger error-text subject_id_error"></span>
                                    </div>


                                    <div class="pb-3">
                                        <label for="study" class="form-label">Study Type</label>
                                        <select multiple name="study_type_id[]" id="study_type_id"
                                            class="shadow rounded-2 form-select" aria-label="Default select example">
                                            <option value=''>select Type</option>
                                            @foreach (App\Models\Study::OrderBy('title','asc')->get() as $study)

                                            <option value="{{$study->id}}">{{$study->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text course_id_error"></span>
                                    </div>




                                    <div class="pb-3">
                                        <label for="sub" class="form-label">Curriculam(SSC)</label>

                                        <select id="ssc_curriculum_id" name="ssc_curriculum_id"
                                            class="shadow rounded-2 form-select"
                                            onchange="filterChange('curriculum_id',this.id)"
                                            aria-label="Default select example">
                                            <option value=''>select curriculam</option>
                                            @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as
                                            $curriculam)

                                            <option value="{{$curriculam->id}}">{{$curriculam->title}}</option>
                                            @endforeach
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
                            <div class="d-flex justify-content-start">
                                <div>



                                    <div class="pb-3">
                                        <label for="utype" class="form-label">University Type</label>
                                        <select name="tutor_university_type"
                                            class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select " id="tutor_university_type">

                                            <option value="">Select University Type</option>
                                            <option value="National University">National University</option>
                                            <option value="Private University">Private University</option>
                                            <option value="Public University">Public University</option>
                                            <option value="7 college">7 college</option>
                                            <option value="Public Medical">Public Medical</option>
                                            <option value="Private Medical">Private Medical</option>
                                            <option value="Mardasha">Mardasha</option>
                                            <option value="Polytechnic Institute">Polytechnic Institute</option>
                                        </select>

                                    </div>
                                    <div class="pb-3">
                                        <label for="am" class="form-label">University</label>

                                        <select multiple name="honours_institute_id[]"
                                            class="shadow rounded-2 form-select" style="width: 215px" id="institute_id"
                                            onchange="filterChange('degree_name=\'honours\' and institute_id',this.id)"
                                            aria-label="Default select example">
                                            <option value="">Select Institute</option>

                                            @foreach (App\Models\Institute::where('type',
                                            'university')->OrderBy('title','asc')->get() as $institute)

                                            <option value="{{$institute->id}}">{{$institute->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="srcid" class="form-label">Department</label>

                                        <select multiple name="department_id[]" style="width: 215px"
                                            class="shadow rounded-2 form-select" id="department_id"
                                            onchange="filterChange('department_id',this.id)"
                                            aria-label="Default select example">
                                            <option value="">Select Department</option>
                                            @foreach (App\Models\Department::OrderBy('title','asc')->get() as
                                            $department)

                                            <option value="{{$department->id}}">{{$department->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="pb-3">
                                        <label for="sub" class="form-label">Curriculam(HSC)</label>

                                        <select id="hsc_curriculum_id" name="hsc_curriculum_id"
                                            class="shadow rounded-2 form-select"
                                            onchange="filterChange('curriculum_id',this.id)"
                                            aria-label="Default select example">
                                            <option value=''>select curriculam</option>
                                            @foreach (App\Models\Curriculam::OrderBy('title','asc')->get() as
                                            $curriculam)

                                            <option value="{{$curriculam->id}}">{{$curriculam->title}}</option>
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



                                        <div class="pb-3" style="width: 215px">
                                            <label for="loc" class="form-label">Prefered Location</label>
                                            <br>
                                            <select multiple id="pre_location_id" name="pre_location_id[]"
                                                style="width: 215px" class="shadow rounded-2 form-select"
                                                onchange="filterChange('pre_location_id',this.id)"
                                                aria-label="Default select example">

                                            </select>
                                        </div>



                                        <div class="pb-3">
                                            <label for="daw" class="form-label">Experience</label>

                                            <select id="daw" name="tutoring_experience" id="tutoring_experience"
                                                class="shadow rounded-2 form-select"
                                                onchange="filterChange('tutoring_experience',this.id)"
                                                aria-label="Default select example">
                                                <option selected value="">select experience</option>
                                                <option value="1">1 year</option>
                                                <option value="2">2 year</option>
                                                <option value="3">3 year</option>
                                                <option value="4">4 year</option>
                                                <option value="5">5 year</option>
                                                <option value="6">6 year</option>
                                                <option value="7">7 year</option>


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
                                            <label for="gender" class="form-label">
                                                Religion
                                            </label>

                                            <select id="religion" name="religion" class="shadow rounded-2 form-select"
                                                onchange="filterChange('religion',this.id)"
                                                aria-label="Default select example">
                                                <option selected value="">Select Religion</option>
                                                <option value="islam">Islam</option>
                                                <option value="hinduism">Hinduism</option>
                                                <option value="christianity">Christianity</option>
                                                <option value="buddhism">Buddhism</option>
                                                <option value="other">Other</option>

                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="channel" class="form-label">Blood Group</label>

                                            <select id="blood_group" name="blood_group"
                                                class="shadow rounded-2 form-select"
                                                onchange="filterChange('blood_group',this.id)"
                                                aria-label="Default select example">
                                                <option selected value="">Select Blood Group</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>

                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="salary" class="form-label">Expected Salary</label>

                                            <select name="expected_salary" class="form-select rounded-3 shadow-none"
                                                aria-label="Default select " id="expected_salary">
                                                <option value="">Select Expected Salary</option>

                                                <option value="2000">
                                                    BDT 2000
                                                </option>
                                                <option value="2500">
                                                    BDT 2500
                                                </option>
                                                <option value="3000">
                                                    BDT 3000
                                                </option>
                                                <option value="4000">
                                                    BDT 3500
                                                </option>
                                                <option value="4500">
                                                    BDT 4000
                                                </option>
                                                <option value="5000">
                                                    BDT 4500
                                                </option>
                                                <option value="5500">
                                                    BDT 5000
                                                </option>
                                                <option value="6000">
                                                    BDT 5500
                                                </option>
                                                <option value="6500">
                                                    BDT 6000
                                                </option>
                                                <option value="7000">
                                                    BDT 6500
                                                </option>
                                                <option value="7500">
                                                    BDT 7000
                                                </option>
                                                <option value="8000">
                                                    BDT 7500
                                                </option>
                                                <option value="8500">
                                                    BDT 8000
                                                </option>
                                                <option value="9000">
                                                    BDT 8500
                                                </option>
                                                <option value="9500">
                                                    BDT 9000
                                                </option>
                                                <option value="10000">
                                                    BDT 10000
                                                </option>
                                                <option value="10500">
                                                    BDT 10500
                                                </option>
                                                <option value="11000">
                                                    BDT 11000
                                                </option>
                                                <option value="11500">
                                                    BDT 11500
                                                </option>
                                                <option value="11500">
                                                    BDT 11500
                                                </option>
                                                <option value="12000">
                                                    BDT 12000
                                                </option>
                                                <option value="12500">
                                                    BDT 12500
                                                </option>
                                                <option value="13000">
                                                    BDT 13000
                                                </option>
                                                <option value="13500">
                                                    BDT 13500
                                                </option>
                                                <option value="14000">
                                                    BDT 14000
                                                </option>
                                                <option value="14500">
                                                    BDT 14500
                                                </option>
                                                <option value="15000">
                                                    BDT 15000
                                                </option>
                                                <option value="15500">
                                                    BDT 15500
                                                </option>
                                                <option value="16000">
                                                    BDT 16000
                                                </option>
                                                <option value="16500">
                                                    BDT 16500
                                                </option>
                                                <option value="17000">
                                                    BDT 17000
                                                </option>
                                                <option value="17500">
                                                    BDT 17500
                                                </option>
                                                <option value="18000">
                                                    BDT 18000
                                                </option>
                                                <option value="18500">
                                                    BDT 18500
                                                </option>
                                                <option value="19000">
                                                    BDT 19000
                                                </option>
                                                <option value="19500">
                                                    BDT 19500
                                                </option>
                                                <option value="20000">
                                                    BDT 20000
                                                </option>
                                                <option value="20500">
                                                    BDT 20500
                                                </option>
                                                <option value="21000">
                                                    BDT 21000
                                                </option>
                                                <option value="21500">
                                                    BDT 21500
                                                </option>
                                                <option value="22000">
                                                    BDT 22000
                                                </option>
                                                <option value="22500">
                                                    BDT 22500
                                                </option>
                                                <option value="23000">
                                                    BDT 23000
                                                </option>
                                                <option value="23500">
                                                    BDT 23500
                                                </option>
                                                <option value="24000">
                                                    BDT 24000
                                                </option>
                                                <option value="24500">
                                                    BDT 24500
                                                </option>
                                                <option value="25000">
                                                    BDT 25000
                                                </option>
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
                                            <label for="am" class="form-label">School</label>

                                            <select name="ssc_institute_id" class="shadow rounded-2 form-select"
                                                style="width: 215px" id="ssc_institute_id"
                                                onchange="filterChange('degree_name=\'ssc\' and institute_id',this.id)"
                                                aria-label="Default select example">
                                                <option value="">Select Institute</option>

                                                @foreach (App\Models\Institute::where('type', 'school')->orWhere('type',
                                                'school and college')->OrderBy('title','asc')->get() as $institute)

                                                <option value="{{$institute->id}}">{{$institute->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="pb-3">
                                            <label for="in" class="form-label">
                                                SSC Group
                                            </label>

                                            <select name="ssc_group_or_major" id="ssc_group_or_major"
                                                class="shadow rounded-2 form-select"
                                                onchange="filterChange('group_or_major',this.id)"
                                                aria-label="Default select example">
                                                <option selected value=''>Select Group</option>
                                                <option value="Science">Science</option>
                                                <option value="Commerce">Commerce</option>
                                                <option value="Arts">Arts</option>

                                            </select>
                                        </div>

                                        <div class="pb-3">
                                            <label for="am" class="form-label">SSC board</label>

                                            <select name="education_board_ssc" id="education_board"
                                                class="shadow rounded-2 form-select"
                                                onchange="filterChange('education_board',this.id)"
                                                aria-label="Default select example" id="gender">
                                                <option value="">~ select board ~</option>
                                                <option value="Dhaka">Dhaka</option>
                                                <option value="Rajshahi">Rajshahi</option>
                                                <option value="Mymensingh">Mymensingh</option>
                                                <option value="Comilla">Comilla</option>
                                                <option value="Jessore">Jessore</option>
                                                <option value="Chittagong">Chittagong</option>
                                                <option value="Barisal">Barisal</option>
                                                <option value="Sylhet">Sylhet</option>
                                                <option value="Khulna">khulna</option>
                                                <option value="Dinajpur">Dinajpur</option>
                                                <option value="Madrasah">Madrasah</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Canadian">Canadian</option>
                                                <option value="Ib">IB</option>
                                                <option value="Ed-excel">Ed-Excel</option>
                                                <option value="Cambridge">Cambridge</option>
                                                <option value="Other">Other</option>



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
                                            <label for="am" class="form-label">College</label>

                                            <select id="hsc_institute_id" style="width: 215px" name="hsc_institute_id"
                                                class="shadow rounded-2 form-select" id="institute_id"
                                                onchange="filterChange('degree_name=\'hsc\' and institute_id',this.id)"
                                                aria-label="Default select example">
                                                <option value="">Select Institute</option>

                                                @foreach (App\Models\Institute::where('type', 'school')->orWhere('type',
                                                'school and college')->OrderBy('title','asc')->get() as $institute)

                                                <option value="{{$institute->id}}">{{$institute->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="in" class="form-label">
                                                HSC Group
                                            </label>

                                            <select name="hsc_group_or_major" id="hsc_group_or_major"
                                                class="shadow rounded-2 form-select"
                                                onchange="filterChange('group_or_major',this.id)"
                                                aria-label="Default select example">
                                                <option selected value=''>Select Group</option>
                                                <option value="Science">Science</option>
                                                <option value="Commerce">Commerce</option>
                                                <option value="Arts">Arts</option>

                                            </select>
                                        </div>

                                        <div class="pb-3">
                                            <label for="am" class="form-label">HSC board</label>

                                            <select name="hsc_education_board" id="hsc_education_board"
                                                class="shadow rounded-2 form-select"
                                                onchange="filterChange('education_board',this.id)"
                                                aria-label="Default select example" id="">
                                                <option value="">~ select board ~</option>
                                                <option value="Dhaka">Dhaka</option>
                                                <option value="Rajshahi">Rajshahi</option>
                                                <option value="Mymensingh">Mymensingh</option>
                                                <option value="Comilla">Comilla</option>
                                                <option value="Jessore">Jessore</option>
                                                <option value="Chittagong">Chittagong</option>
                                                <option value="Barisal">Barisal</option>
                                                <option value="Sylhet">Sylhet</option>
                                                <option value="Khulna">khulna</option>
                                                <option value="Dinajpur">Dinajpur</option>
                                                <option value="Madrasah">Madrasah</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Canadian">Canadian</option>
                                                <option value="Ib">IB</option>
                                                <option value="Ed-excel">Ed-Excel</option>
                                                <option value="Cambridge">Cambridge</option>
                                                <option value="Other">Other</option>

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
                            <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                aria-controls="collapseExample" class="mb-0">
                                <i class="bi bi-caret-down-fill"></i>
                            </a>
                        </div>
                        <div>

                            {{-- <input name="searchInput" type="hidden" value="" id="searchInput"> --}}
                            <button type="button" class="btn btn-danger py-1 me-2">
                                Clear
                            </button>






                            <button type="submit" class="btn btn-primary py-1">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Filter Model ends here -->


    <!--Date model starts here-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog model-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body pt-5 pb-4">
                    <p id="date" class="text-center text-info fs-3">7 June 2023</p>

                    {{-- <p>{{data}}</p> --}}
                    <p id="time" class="text-center text-gray-700 border-top fs-1 pt-1">
                        03:30 PM
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--Date model ends here-->
    <!--ME model starts here-->

    <!--ME model ends here-->

</main>



{{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p>Edit & Update tutors</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="" method="post" action="{{ route('tutor.update', 'tutor') }}">
                    @csrf

                    <input type="hidden" name="_method" value="put" />
                    <input class="form-control" type="hidden" id="tutor_id" name="tutor_id" value="">
                    <label style="" class="form-labal">Full Name</label><br>
                    <input type="text" value="" class="form-control name" name="name" id="name" required>
                    <label style="" class="form-labal">Email</label><br>
                    <input type="text" value="" class="form-control name" name="email" id="email" required>
                    <label style="" class="form-labal">Phone</label><br>
                    <input type="text" value="" class="form-control name" name="phone" id="phone" required>

                    <label for="category_id" class="form-label">Genger</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Select One</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="btnEdit()">Update tutor</button>
            </div>
            </form>

        </div>

    </div>
</div>
{{-- end Edit Modal --}}


<!-- Note model -->
<div class="modal fade" id="tutorNoteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Note Details </h5>

            </div>
            <div class="modal-body">
                <div>


                    <div id="allNote">
                        <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                            <div class="d-flex justify-content-between align-items-center" id="singleNote">
                                <div>
                                    <p class="mb-0 text-dark fs-5">Sohag Sarkar</p>
                                    <p class="text-info" style="font-size: 12px">ID-23456</p>
                                </div>
                                <div>
                                    <p>June 17, 2023</p>
                                </div>
                            </div>
                            <p>note body</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p>Read More</p>
                                </div>
                                <div>
                                    <button class="btn btn-primary py-1">Edit</button>
                                </div>
                            </div>
                        </div>




                    </div>




                    <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
                        <div class="d-flex justify-content-between align-items-center">

                        </div>

                        <form action="{{route('admin.tutor.note')}}" method="POST" id="tutorNote">

                            @csrf

                            <input type="hidden" name="tutor_id" id="note_tutor_id">
                            <div class="form-group">
                                <label>Add Note</label>
                                <textarea name="note" class="form-control" rows="5" id="tutor_note"
                                    required=""></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    {{-- <button class="btn btn-primary py-1">Save</button> --}}
                                </div>
                                <div>
                                    <button class="btn btn-primary py-1">Save</button>
                                </div>
                        </form>
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


{{-- end note modal --}}




{{-- start Note modal --}}
<div class="modal fade" id="noteModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add Note for </h5> &nbsp<h5 id="tutor_name"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="" method="post" action="route('admin.tutor.note-create')">
                    @csrf

                    <input type="hidden" name="_method" value="put" />
                    <input class="form-control" type="hidden" id="tutor_id" name="tutor_id" value="">
                    <input type="hidden" value="{{ route('admin.tutor.note-create') }}" id="tutor_note_create_route" />

                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="8" id="tutor_note" required=""></textarea>
                    </div>

                    {{--
            <textarea name="long_description" class="form-control" rows="8" id="long_description" required>
            </textarea> --}}

                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="btnCreateNote(event)">Save Note</button>
            </div>
            </form>

        </div>

    </div>
</div>

{{-- end note modal --}}

<form style="display: none" action="{{ route('admin.tutor.sms-editor') }}" method="POST" id="smsForm">
    @csrf
    <input type="hidden" id="var1" name="all_id" value="" />
</form>
@endsection



@push('page_scripts')



{{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script> --}}


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


@include('backend.tutor.js.swtdeleteMethod_js')
@include('backend.tutor.js.index_page_js')
@include('data_tables.data_table_js')
<script>
   document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('paginationLimit').addEventListener('change', function () {
        var limit = this.value;
        var urlParams = new URLSearchParams(window.location.search);
        urlParams.set('pagination_limit', limit);
        window.location.href = window.location.pathname + '?' + urlParams.toString();
    });
});
</script>
<script>
    function statusChanged(element) {
        var tutorId = $(element).data('id');
        var status = $(element).val();
        var url = $(element).data('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Status Changed successfully",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        title: "Status Can't Change",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
            },
            error: function () {
                alert('Internal Server Error');
            }
        });
    }

    $('.status-selector').change(function () {
        statusChanged(this);
    });

</script>



@endpush
