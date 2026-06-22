@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
@section('content')


{{-- <div class="card-header">
  <i class="fas fa-table me-1"></i>
  <a class="btn btn-sm btn-info" href="{{route('tutor.index')}}">List</a>
</div> --}}
{{-- <div class="card mb-4">
    <div class="card-body"> --}}

<br>
@if(session('message'))


<p class="alert alert-success">{{ session('message') }}</p>
@endif
<!-- {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}} -->
<div class="ps-3" style="padding-right: 13px">
    <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
        <div class="d-flex justify-content-between gap-3">

            <a href="{{route('tutor.index')}}" class="btn btn-outline btn-primary">Tutor List</a>


            {{-- <div class="box-tools pull-left" style="position: relative;margin-top: 5px;margin-left: 10px">
    <button onclick="" class="btn btn-primary btn-sm" id="sendSms">Send Bulk SMS</button>
    <a href="{{route('tutor.create')}}" class="btn btn-primary btn-sm">Add New Tutor</a>
            <a href="{{route('admin.tutors.trash')}}" class="btn btn-warning btn-sm">Trash List</a>
            <button onclick="filterButton()" class="btn btn-primary btn-sm float-right" id="sendSms">Filter</button>
        </div> --}}


    </div>
    <div class="d-flex gap-3">
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
<div class="bg-white shadow-lg rounded-3 p-2 my-4">
    <div class="bg-white pb-4 mb-b">
        <div class="table-responsive">
            <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                    <tr>
                        <th scope="col" class="text-nowrap">
                            <input class="" type="checkbox" value="" id="select_all" style="margin-right: 12px" /> &nbsp
                            &nbsp &nbsp Date
                        </th>
                        <th scope="col" class="text-nowrap">Tutor ID</th>

                        <th scope="col" class="text-nowrap">Name</th>
                        <th scope="col" class="text-nowrap">Note</th>

                        <th scope="col" class="text-nowrap">University</th>
                        <th scope="col" class="text-nowrap">Department</th>
                        <th scope="col" class="text-nowrap">gender</th>
                        <th scope="col" class="text-nowrap">Address</th>
                        <th scope="col" class="text-nowrap">Phone</th>

                        <th scope="col" class="text-nowrap">SMS</th>
                        <th scope="col" class="text-nowrap">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Action &nbsp;
                            &nbsp; &nbsp; &nbsp; &nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($tutors as $tutor)
                    <tr class="" style="vertical-align: middle">


                        <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                            <input class="checkboxx" type="checkbox" name="ids" id="{{ $tutor->id }}"
                                value="{{ $tutor->id }}" />
                            <a class="text-decoration-none text-gray-700 btn" id="{{$tutor->created_at}}"
                                onclick="dateTime(this.id)" data-bs-toggle="modal" data-time="{{ $tutor->created_at }}"
                                data-bs-target="#exampleModal2">


                                @php
                                $input = $tutor->created_at;
                                $format1 = 'd-m-Y';
                                $format2 = 'H:i:s';
                                $date = Carbon\Carbon::parse($input)->format($format1);
                                @endphp
                                {{$date}}
                            </a>
                        </td>
                        <td class="text-info">
                            <a href="job.html" class="p-1 rounded text-info text-decoration-none"
                                style="background-color: #e6eef7">{{$tutor->id}}</a> </td>

                        <td class="text-nowrap">{{$tutor->name}}
                            @if($tutor->is_premium == 1)
                            <i style="color:orange;" class="fas fa-star"></i> @endif
                            @if($tutor->is_verified == 1)
                            <i style="color:#007BFF" class="far fa-check-circle"></i>
                            @endif
                            @if($tutor->is_featured == 1)
                            <i style="color:#112374" class="fas fa-asterisk"></i></h3>
                            @endif

                        </td>
                        <td style="max-width: 220px">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$tutor->id}}">
                                Note
                              </button>
                              <div class="modal fade" id="exampleModal_{{$tutor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel_{{$tutor->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Note</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Delete Note</th>
                                                    <th scope="col">Deleted By</th>
                                                    <th scope="col">Restore Note</th>
                                                    <th scope="col">Restored By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($tutor->tutor_delete_note ?? [] as $index => $note)
                                                    <tr>
                                                        <td>
                                                            <div>{{ $note->created_at->format('M d, Y') }}</div>
                                                            <div>{{ $note->created_at->format('h:i A') }}</div>
                                                        </td>
                                                        <td class="text-danger">{{ $note->delete_note ?? ''}}</td>
                                                        <td class="text-danger">{{ $note->deleteuser->name ?? ''}}</td>
                                                        <td>{{ $note->restore_note ?? ''}}</td>
                                                        <td>{{ $note->restoreuser->name ?? ''}}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">No delete notes found for this tutor.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                        </td>
                        <td class="text-nowrap">University</td>
                        <td class="text-nowrap">Department</td>
                        <td class="text-nowrap">{{$tutor->gender}}</td>

                        {{Str::limit( $tutor->tutor_personal_info->location->name ?? 'NA', 10) }}</td>
                        <th scope="col" class="text-nowrap">{{$tutor->phone}}</th>



                        @if (Auth::user()->id == 1)
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

                        @endif

                        {{-- @if (Auth::user()->role_id == 1)

                                    @endif --}}


                        @if (Auth::user()->id == 1)

                        <td>

                            <form id="btnrestore{{ $tutor->id }}"
                                action="{{ route('admin.tutor.restore', ['tutor' => $tutor->id]) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="restore_note" id="tutor_restore_note{{ $tutor->id }}"
                                    value="">
                                <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                                <button type="button" class="btn btn-danger btn-sm" id="{{ $tutor->id }}"
                                    onclick="tutorRestoreBtn(this, this.id)">Restore</button>
                            </form>

                        </td>
                        @endif

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center align-items-center gap-2">

            {{$tutors->links()}}


            {{-- <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
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
                        </button> --}}
        </div>
    </div>
</div>
</div>




@endsection

@push('page_scripts')

<script src="{{asset('js/swtdeleteMethod.js')}}"></script>
<script>
    function tutorRestoreBtn(element, id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to restore this tutor!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!',
            input: 'text',
            inputPlaceholder: 'Enter your note here...',
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to enter a note!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#tutor_restore_note' + id).val(result.value);
                $('#btnrestore' + id).submit();
            }
        });
    }

</script>
<script>
    function btnDelete(ev, id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                $('#btndelete' + id).submit();
            };
        });
    }

</script>


@endpush
