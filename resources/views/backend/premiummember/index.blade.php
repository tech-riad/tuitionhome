@extends('layouts.app')

@push('page_css')


@endpush

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<section class="content-header">
    <h1><i class="fa fa-bars"></i>
        Premium Membership Requests


    </h1>
</section>


<div id="count" style="margin-left: 18px">
    <div class="row">
        <div class="col-md-2">
            <div class="report-card card" style="text-align:center">
                <h2>{{App\Models\Premiummembership::all()->count()}}</h2>
                <span>Total Request</span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="report-card card" style="text-align:center">
                <h2>{{ App\Models\Premiummembership::whereDate('created_at', today())->count() }}
                </h2>
                <span>Today Request</span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="report-card card" style="text-align:center">
                <h2>{{ App\Models\Premiummembership::whereDate('action_at', today())->count() }}
                </h2>
                <span>Today Solve Request</span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="report-card card" style="text-align:center">
                <h2>{{ App\Models\Premiummembership::where('request_status', 'accepted')->count() }}</h2>
                <span>Total Accepted Request</span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="report-card card" style="text-align:center">
                <h2>{{ App\Models\Premiummembership::where('request_status', 'rejected')->count() }}</h2>
                <span>Total Decline Request</span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="report-card card" style="text-align:center">
                <h2>{{ App\Models\Premiummembership::where('request_status', 'waiting')->count() }}</h2>
                <span>Total Waiting Request</span>
            </div>
        </div>

    </div>


</div>

<section id="content_section" class="content">
    <div class="card box-default">
        <div class="card-header with-border">
            <h1 class="card-title"><i class="fa fa-eye"></i> All Premium Membership Requests</h1>
        </div>
        <br>
        <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
            <div class="ml-3 d-flex justify-content-between gap-3">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-sliders2 me-1"></i>Filter
                </button>
                <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addPremiumRequest">
                    Add Request
                </button>

            </div>


            <div class="d-flex gap-3 mr-3">
                <form action="{{ route('admin.premium.member.search') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                        style="border: 1px solid #cfdfdb">

                        <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                            placeholder="Search" style="padding: 12px 18px" id="">
                        <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
                    </div>
                </form>
                <form id="premiumMembership" action="{{ route('admin.premium.membership') }}" method="GET">
                    <select id="premiumMember" name="pagination_limit" class="form-select rounded" style="width: 100px">
                        <option value="50" {{ $paginationLimit == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $paginationLimit == 100 ? 'selected' : '' }}>100</option>
                        <option value="200" {{ $paginationLimit == 200 ? 'selected' : '' }}>200</option>
                        <option value="400" {{ $paginationLimit == 400 ? 'selected' : '' }}>400</option>
                        <option value="500" {{ $paginationLimit == 500 ? 'selected' : '' }}>500</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th scope="col" class="text-nowrap">
                            <input class="" type="checkbox" value="" id="select_all" style="margin-right: 12px" />
                        </th>
                        <th>Date</th>
                        <th>Tutor Id</th>
                        <th>Name</th>
                        <th>Package Name</th>
                        <th>Taka</th>
                        <th>Transction Id</th>
                        <th>Payment Status</th>
                        <th>Channel Name</th>
                        <th>Action By</th>
                        <th>Request Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($memberships)
                    @foreach ($memberships as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                            <input class="checkboxx" type="checkbox" name="ids" id="{{ $item->tutor_id }}"
                                value="{{ $item->tutor_id }}" />
                        </td>
                        <form style="display: none" action="{{ route('admin.tutor.sms-editor') }}" method="POST"
                            id="smsForm">
                            @csrf
                            <input type="hidden" id="var1" name="all_id" value="" />
                        </form>

                        <td>{{ $item->created_at->format('Y-m-d') }}
                            <br>
                            {{ $item->created_at->format('h:i A') }}
                        </td>
                        <td>
                            <a target="_blank"
                                href="{{route('admin.tutor.tutorshow',$item->tutor_id)}}">{{$item->tutor->unique_id}}</a>
                        </td>
                        <td>{{$item->name}}

                            @if(@$item->tutor->is_premium == 1)
                            <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-regular-9c7ea3fd.svg"
                                alt="">
                            @endif
                            @if(@$item->tutor->is_premium_pro == 1)
                            <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-pro-fc790c7d.svg"
                                alt="">
                            @endif
                            @if(@$item->tutor->is_premium_advance == 1)
                            <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-advance-4b8e47d2.svg"
                                alt="">
                            @endif
                            @if($item->tutor->is_verified == 1)
                            <i style="color:#007BFF" class="far fa-check-circle"></i>
                            @endif
                            @if(@$item->tutor->is_internal_verify == 1 && $item->tutor->is_verified == 0)
                            <i style="color:#ed228b" class="far fa-check-circle"></i>
                            @endif
                            @if(@$item->tutor->is_featured == 1)
                            <img height="30px" src="https://tuitionterminal.com.bd/assets/featured-icon-0c358655.svg"
                                alt="">

                            @endif
                            @if(@$item->tutor->is_boost == 1)
                            <img height="30px" src="https://tuitionterminal.com.bd/assets/boost-icon-d47ce3c5.svg"
                                alt="">

                            @endif
                        </td>
                        <td>{{$item->package_name}}</td>
                        <td>{{$item->taka}}</td>
                        <td>{{$item->transction_id}}</td>
                        <td @if ($item->payment_status == 'paid') class="text-green" @endif>
                            {{$item->payment_status}}
                        </td>
                        <td class="rounded text-bold @if($item->channel_name == 'Website')
                            text-red
                        @else
                            text-info
                        @endif text-decoration-none">{{$item->channel_name ?? ''}}</td>
                        <td>{{$item->user->name ?? ''}} <br> {{$item->action_at ?? ''}}</td>
                        <td>{{$item->request_status}}</td>
                        <td>
                            @if ($item->request_status == 'pending'||$item->request_status == 'waiting')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#grantModal_{{$item->id}}">
                                Grant
                            </button>

                            <div class="modal fade" id="grantModal_{{$item->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Grant Modal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('admin.grant.membership.application')}}" method="post">
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="grant_id" value="{{$item->id}}">
                                                <div class="mb-3">
                                                    <label for="transction_id" class="form-label required">Transction
                                                        ID</label>
                                                    <input required name="transction_id" type="text"
                                                        class="form-control rounded-3 shadow-none" id="transction_id"
                                                        value="{{$item->transction_id}}" placeholder=""
                                                        style="padding: 14px 18px" />
                                                    <span class="text-danger error-text transction_id_error"></span>

                                                </div>
                                                <div class="pb-3">
                                                    <label for="crby" class="form-label">Package Name</label>
                                                    <select name="package_name"
                                                        class="form-select rounded-3 shadow-none select2"
                                                        aria-label="Default select" id="package_name">
                                                        <option value="">Select Package Name</option>
                                                        <option @if ($item->package_name == 'regular') selected @endif
                                                            value="regular">Regular</option>
                                                        <option @if ($item->package_name == 'pro') selected @endif
                                                            value="pro">Pro</option>
                                                        <option @if ($item->package_name == 'advance') selected @endif
                                                            value="advance">Advance</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="taka" class="form-label required">Taka</label>
                                                    <input required name="taka" type="text"
                                                        class="form-control rounded-3 shadow-none" id="taka"
                                                        placeholder="" value="{{$item->taka}}"
                                                        style="padding: 14px 18px" />
                                                    <span class="text-danger error-text taka_error"></span>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#declineModal_{{$item->id}}">
                                Decline
                            </button>

                            <div class="modal fade" id="declineModal_{{$item->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Decline Modal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('admin.decline.membership.application')}}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="decline_id" value="{{$item->id}}">
                                                <div class="mb-3">
                                                    <label for="decline_note" class="form-label required">Decline
                                                        Note</label>
                                                    <textarea name="decline_note" type="text"
                                                        class="form-control rounded-3 shadow-none" id="decline_note"
                                                        placeholder="" style="padding: 14px 18px"
                                                        required>{{$item->decline_note}}</textarea>
                                                    <span class="text-danger error-text decline_note_error"></span>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @endif

                            @if ($item->request_status == 'rejected')
                            <button class="btn btn-danger" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#declinedModal_{{$item->id}}">
                                Declined
                            </button>

                            <div class="modal fade" id="declinedModal_{{$item->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Declined Reason</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="decline_id" value="{{$item->id}}">
                                            <div class="mb-3">
                                                <label for="decline_note" class="form-label required">Decline
                                                    Note</label>
                                                <textarea name="decline_note" type="text"
                                                    class="form-control rounded-3 shadow-none" id="decline_note"
                                                    placeholder="" style="padding: 14px 18px"
                                                    required>{{$item->decline_note}}</textarea>
                                                <span class="text-danger error-text decline_note_error"></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($item->request_status == 'accepted')
                            <button class="btn btn-primary">
                                Granted
                            </button>
                            @endif

                            @if ($item->request_status == 'pending')
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#waitingModal_{{$item->id}}">
                                Waiting
                            </button>

                            @endif
                            @if ($item->request_status == 'waiting')
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                data-bs-target="#waitingModal_{{$item->id}}">
                                In Waiting
                            </button>

                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#noteModal_{{$item->id}}">
                                Note
                            </button>

                            <div class="modal fade" id="noteModal_{{$item->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Note Modal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('admin.premium.membership.note')}}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="application_id" value="{{$item->id}}">
                                                <div class="mb-3">
                                                    <label for="note" class="form-label required">
                                                        Note</label>
                                                    <textarea name="note" type="text"
                                                        class="form-control rounded-3 shadow-none" id="note"
                                                        placeholder="" style="padding: 14px 18px"
                                                        required>{{$item->note}}</textarea>
                                                    <span class="text-danger error-text note_error"></span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="waitingModal_{{$item->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Waiting Modal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('admin.waiting.membership.application')}}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="waiting_id" value="{{$item->id}}">
                                                <div class="mb-3">
                                                    <label for="waiting_note" class="form-label required">Waiting
                                                        Note</label>
                                                    <textarea name="waiting_note" type="text"
                                                        class="form-control rounded-3 shadow-none" id="waiting_note"
                                                        placeholder="" style="padding: 14px 18px"
                                                        required>{{$item->waiting_note}}</textarea>
                                                    <span class="text-danger error-text waiting_note_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="expected_waiting_date" class="form-label">Expected Date
                                                        and Time</label> <br>
                                                    <input type="datetime-local" name="expected_waiting_date"
                                                        value="{{ old('expected_waiting_date') ? old('expected_waiting_date') : $item->expected_waiting_date }}">
                                                </div>



                                                <div class="mb-3">
                                                    <label for="waiting_note" class="form-label">Waiting
                                                        Note Update Date</label> <br>
                                                    <h3>{{$item->waiting_note_update_date ?? ''}}</h3>

                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </td>



                    </tr>
                    @endforeach
                    @else
                    <h4>No Request Found</h4>
                    @endif


                </tbody>
            </table>
            <div id="paginationLinks">
                {{ $memberships->appends(['pagination_limit' => $paginationLimit])->links() }}

            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.filter.membership.application') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="pb-3">
                        <label for="datef" class="form-label">Date from</label>
                        <div>
                            <input name="datef" type="date" class="form-control shadow rounded-2" id="datef" />
                        </div>
                    </div>
                    <div class="pb-3">
                        <label for="datet" class="form-label">Date To</label>
                        <input name="datet" type="date" class="form-control shadow rounded-2" id="datet" />
                    </div>
                    <div class="pb-3">
                        <label for="crby" class="form-label">Action By</label>
                        <select name="user_id" class="form-select rounded-3 shadow-none select2"
                            aria-label="Default select" id="user_id">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pb-3">
                        <label for="crby" class="form-label">Request Status</label>
                        <select name="status" class="form-select rounded-3 shadow-none select2"
                            aria-label="Default select" id="user_id">
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                            <option value="waiting">Waiting</option>

                        </select>
                    </div>
                    <div class="pb-3">
                        <label for="crby" class="form-label">Channel Name</label>
                        <select name="channel_name" class="form-select rounded-3 shadow-none select2"
                            aria-label="Default select" id="user_id">
                            <option value="">Select Channel</option>
                            <option value="Admin">Admin</option>
                            <option value="Website">Website</option>

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade font-pop" id="addPremiumRequest" tabindex="-1" aria-labelledby="addPremiumRequestLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-slide-right" style="max-width: 1100px">
        <div class="modal-content pb-4 pt-3">
            <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                <h4 class="modal-title" id="exampleModalLabel">Membership Request Add</h4>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.add.membership.application') }}" method="POST">
                @csrf
                <div class="modal-body py-0" style="padding-left: 40px">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 pe-4">
                                <div class="pb-3">
                                    <label for="datet" class="form-label required">Tutor Phone</label>
                                    <input type="number" class="form-control shadow rounded-2" required
                                        name="phone" />
                                </div>
                            </div>
                            <div class="border-end mt-3" style="height: 125px"></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 pe-4">
                                <div class="pb-3">
                                    <label for="crby" class="form-label">Package Name</label>
                                    <select name="package_name"
                                        class="form-select rounded-3 shadow-none select2"
                                        aria-label="Default select" id="package_name" required>
                                        <option value="">Select Package Name</option>
                                        <option
                                            value="regular">Regular</option>
                                        <option
                                            value="pro">Pro</option>
                                        <option
                                            value="advance">Advance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="border-end mt-3" style="height: 125px"></div>
                        </div>
                        <div class=""></div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">

                    <div>
                        <button type="submit" class="btn btn-primary py-1">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    @endsection


    @push('page_scripts')
    @include('backend.tutor.js.swtdeleteMethod_js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('paginationLimit').addEventListener('change', function () {
                document.getElementById('paginationForm').submit();
            });
        });

    </script>


    <script>
        $(document).ready(function () {
            $('#premiumMember').change(function () {
                $('#premiumMembership').submit();
            });
        });

    </script>

    <script>
        $(function (e) {
            $("#select_all").click(function () {
                $('.checkboxx').prop('checked', $(this).prop('checked'));
            });

            $("#sendSms").click(function (e) {
                e.preventDefault();
                var all_ids = [];

                $('input:checkbox[name=ids]:checked').each(function () {
                    all_ids.push($(this).val());
                });

                $("#var1").val(all_ids.join(',')); // Convert array to comma-separated string
                if (all_ids.length === 0) {
                    alert("Please select at least one tutor.");
                } else {
                    $("#smsForm").submit();
                }
            });
        });

    </script>
    @endpush
