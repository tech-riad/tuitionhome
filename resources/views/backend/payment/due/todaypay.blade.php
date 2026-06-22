@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />


@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12" style="margin-top: 60px">
        <!-- mini nav starts here -->
        <div class="d-flex gap-4 flex-column flex-md-row p-3">
            <a class="text-decoration-none text-gray-800 {{ Request::is('admin/payment') ? 'active-border' : '' }}" href="{{route('admin.payment')}}">Revenue</a>
            <a class="text-decoration-none text-gray-800 {{ Request::is('admin/payment/due') ? 'active-border' : '' }}" href="{{route('admin.due.payment')}}">Due</a>
            <a class="text-decoration-none text-gray-800 {{ Request::is('admin/payment/employee') ? 'active-border' : '' }}" href="{{route('admin.payment.employee')}}">Employee</a>
            <a class="text-decoration-none text-gray-800 {{ Request::is('admin/payment/sms-recharge') ? 'active-border' : '' }}" href="{{route('admin.sms.recharge')}}">Sms Recharge</a>
            <a class="text-decoration-none text-gray-800 {{ Request::is('admin/payment/sms-recharge-due') ? 'active-border' : '' }}" href="{{route('admin.sms.recharge.due')}}">Sms Recharge Due</a>

        </div>
        <!-- mini nav ends here -->

        <!-- main content section starts here -->
        <!-- header cards starts here -->
        <div class="row gap-4 gap-md-0 ms-1 me-1 mb-4">
            <div class="col-12 col-md-6 col-lg-9">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">{{$refundDue + $smsPaymentDue}}</p>
                    <p class="text-center mb-0">Total Due Pending</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="bg-white text-nowrap shadow-lg rounded-3 p-2 ps-5 ps-lg-4 ps-xl-5 mb-4 text-gray-800">
                    Amount :
                    <span class="ms-1">{{$filtersum ?? $refundPaymentDues ?? 0}}</span>
                </div>
                <div class="bg-white shadow-lg rounded-3 p-2 ps-5 ps-lg-4 ps-xl-5 text-gray-800">
                    Count : <span class="ms-3 ps-1">{{$filtersumcount ?? $refundPaymentDuescount ?? 0}}</span>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 gap-4 row-cols-md-2 row-cols-lg-4 gap-md-0 ms-1 me-1">
            <div class="mb-md-4 mb-lg-0">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">{{$refundDue}}</p>
                    <p class="text-center mb-0">Tutor Refund Pending</p>
                </div>
            </div>
            <div class="mb-md-4 mb-lg-0">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">0</p>
                    <p class="text-center mb-0 text-nowrap">
                        Affiliate Com. Pending
                    </p>
                </div>
            </div>
            <div class="">
                <div class="bg-white shadow-lg rounded-3 px-4" style="padding-top: 24px; padding-bottom: 8px">
                    <p class="text-center fw-bold fs-5 mb-1">{{$smsPaymentDue}}</p>
                    <p class="text-center mb-0">SMS Payment Due</p>
                    <p class="mb-0 text-center mt-1" style="font-size: 8px">
                        (0.25 Cent)
                    </p>
                </div>
            </div>
            <div class="">
                <div class="bg-white shadow-lg rounded-3 p-4">
                    <p class="text-center fw-bold fs-5 mb-1">0</p>
                    <p class="text-center mb-0">Batch Payment Due</p>
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
                    <button class="btn btn-outline-ndark" id="sendSms">Send Bulk SMS</button>
                </div>
                <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                    <a href="{{route('admin.due.payment')}}" class="btn {{ Request::is('admin/due/filter') ? 'btn-gdark' : '' }} {{ Request::is('admin/payment/due') ? 'btn-gdark' : '' }}">All</a>
                    <a href="{{route('admin.setpoint.due')}}" class="btn {{ Request::is('admin/set-point-due') ? 'btn-gdark' : '' }} text-nowrap">
                        Set A Point
                    </a>
                    <a href="{{route('admin.due.todaypay')}}" class="btn {{ Request::is('admin/due/today-payment') ? 'btn-gdark' : '' }} text-nowrap">
                        Today Payment
                    </a>
                    <form action="{{route('admin.due.search')}}" method="post">
                        @csrf
                        <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                            style="border: 1px solid #cfdfdb">

                            <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                                placeholder="Search" style="padding: 12px 18px" id="">
                            <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
                        </div>


                    </form>
                    <form method="GET" action="{{ route($currentRoute) }}">
                        {{-- <input type="hidden" name="revenue_filter" value="{{ request('revenue_filter') }}"> --}}
                        <select name="pagination_limit" class="form-select rounded" style="width: 100px" onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100, 200, 300, 500] as $limit)
                                <option value="{{ $limit }}" {{ $paginationLimit == $limit ? 'selected' : '' }}>{{ $limit }}</option>
                            @endforeach
                        </select>
                    </form>
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
                                        <input class="" type="checkbox" value="" id="select_all" style="margin-right: 12px" />
                                        SL
                                    </th>
                                    <th scope="col" class="text-nowrap">Date</th>
                                    <th scope="col" class="text-nowrap">Id Info :</th>
                                    <th scope="col" class="text-nowrap">User Type</th>
                                    <th scope="col" class="text-nowrap">Name</th>
                                    <th scope="col" class="text-nowrap">
                                        Service Category
                                    </th>
                                    <th scope="col" class="text-nowrap">Amount</th>
                                    <th scope="col" class="text-nowrap">Status</th>
                                    <th scope="col" class="text-nowrap">Payment proof</th>
                                    <th scope="col" class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($duePayments as $item)

                                <tr class="" style="vertical-align: middle">
                                    <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                        <input class="checkboxx" type="checkbox" name="ids" id="{{ $item->tutor_id }}"
                                            value="{{ $item->tutor_id }}" />

                                        {{$loop->iteration}}
                                    </td>
                                    <td class="">
                                            {{$item->created_at}}
                                    </td>
                                    <td class="text-info">
                                        <a type="button" class="text-decoration-none text-info" data-bs-toggle="modal"
                                            data-bs-target="#idInfoModal_{{$item->id}}">ID Info :</a>
                                    </td>
                                    <!-- Id Info model starts here-->
                                    <div class="modal fade" id="idInfoModal_{{$item->id}}" tabindex="-1" aria-labelledby="idInfoModalLabel_{{$item->id}}" aria-hidden="true">
                                        <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                                            <div class="modal-content">
                                                <div class="modal-body pt-4 pb-4 px-5">
                                                    <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                                                        <p class="fw-semibold">Tranaction ID</p>
                                                        <p class="text-info">{{$item->trx_id}}</p>
                                                    </div>
                                                    <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                                                        <p class="fw-semibold">Payment Date</p>
                                                        <p class="">
                                                            <span class="me-4">{{$item->paid_date}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="row row-cols-2 border-bottom border-2 mb-4">
                                                        <p class="fw-semibold">Unique ID</p>
                                                        <p class="text-info">{{$item->tutor->unique_id}}</p>
                                                    </div>
                                                    <div class="row row-cols-2">
                                                        <p class="fw-semibold">Service ID</p>
                                                        <p class="text-info">{{$item->job_id}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Id Info model ends here-->
                                    <td class="">{{$item->user_type}}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('admin.tutor.tutorshow', ['tutor' => $item->tutor_id]) }}">{{$item->name ?? ''}}</a>
                                    </td>
                                    <td>Service Charge</td>
                                    <td class="text-info">
                                        <a type="button" class="p-1 rounded text-info text-decoration-none"
                                            style="background-color: #e6eef7" data-bs-toggle="modal"
                                            data-bs-target="#showAmountModal">
                                            {{$item->amount}}
                                        </a>
                                    </td>
                                    <td class="text-nowrap ">
                                        <a type="button" class="p-1 rounded @if ($item->payment_status == 1) text-info @elseif ($item->payment_status == 0) text-warning

                                    @endif text-decoration-none"
                                        style="background-color: #e6eef7" data-bs-toggle="modal"
                                        data-bs-target="#showStatusModal_{{$item->id}}">
                                        @if ($item->payment_status == 1) Paid @elseif ($item->payment_status == 0) Pending

                                    @endif
                                        </a>
                                    </td>
                                    <td class="">
                                        <a type="button" class="text-decoration-none text-info text-nowrap"
                                            data-bs-toggle="modal" data-bs-target="#proofModal_{{$item->id}}">
                                            Proof
                                        </a>
                                    </td>
                                    <!-- Proof model starts here-->
                                    <div class="modal fade" id="proofModal_{{$item->id}}" tabindex="-1" aria-labelledby="proofModalLabel_{{$item->id}}" aria-hidden="true">
                                        <div class="modal-dialog model-sm modal-dialog-slide-left" style="max-width: 400px">
                                            <div class="modal-content">
                                                <div class="modal-body pt-4 pb-4 px-5">
                                                    <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                                                        <p class="fw-semibold">Render By</p>
                                                        <p class="">{{$item->render->name}}</p>
                                                    </div>
                                                    <div class="row row-cols-2 border-bottom border-2 mb-4">
                                                        <p class="fw-semibold">Ownership By</p>
                                                        <p class="">{{$item->ownerBy->name}}</p>
                                                    </div>
                                                    <div class="row row-cols-2">
                                                        <p class="fw-semibold">Verifyed By</p>
                                                        <p class="">{{$item->verifyBy->name ?? ''}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Proof model ends here-->

                                    <td class="">
                                        <div class="d-flex gap-2">
                                            @if(in_array(Auth::user()->role_id, [1, 6]))
                                                @if ($item->is_verified == 0)
                                                        <button class="btn btn-warning py-1 due-verify-button" data-id="{{ $item->id }}">
                                                            Verify
                                                        </button>
                                                @else
                                                        <button class="btn btn-primary py-1">
                                                            Verified
                                                        </button>
                                                @endif
                                            @endif


                                            @if ($item->payment_status == 0) <button class="btn btn-danger py-1" data-bs-toggle="modal"
                                            data-bs-target="#payModal">
                                            Pay
                                            </button> @elseif ($item->payment_status == 1) <button class="btn btn-info py-1" data-bs-toggle="modal"
                                            data-bs-target="#payModal">
                                            Paid
                                            </button>

                                            @endif

                                            <div class="dropdown">
                                                <button class="btn btn-gdark py-1 px-2" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false" style="
                                  background-color: #6b7280;
                                  color: white;
                                    ">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" style="border: 1px solid #d7dfe9">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="loadNoteDetails({{ $item->id }})">
                                                            Note
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item due-note" id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                                                           Create Note
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#logModal" href="#">Log</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">Cancel</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Note model starts here-->
                                <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel5">
                                                    Note Details
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="noteModalBody">
                                                <!-- Content will be loaded dynamically -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-gdark shadow-lg" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="showStatusModal_{{$item->id}}" tabindex="-1" aria-labelledby="showStatusModal_{{$item->id}}"
                                    aria-hidden="true">
                                    <div class="modal-dialog model-sm modal-dialog-slide-right" style="max-width: 400px">
                                        <div class="modal-content" style="background-color: #c4e3ff">
                                            <div class="modal-body pt-5 pb-4">
                                                <p class="text-center text-info fs-3"> Pending To : <br>{{ \Carbon\Carbon::parse($item->job->refund_date)->format('Y-m-d') }}</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Note model ends here-->
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- pagination starts here -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                        {{ $duePayments->appends(request()->query())->links() }}
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

        <div class="modal fade" id="showAmountModal" tabindex="-1" aria-labelledby="showAmountModalLabel"
            aria-hidden="true">
            <div class="modal-dialog model-sm modal-dialog-slide-right" style="max-width: 400px">
                <div class="modal-content" style="background-color: #c4e3ff">
                    <div class="modal-body px-5 py-5">
                        <div class="row row-cols-2 bg-white mb-4 p-3 rounded-3">
                            <p class="fw-semibold mb-0">Payment :</p>
                            <p class="mb-0">00 TK</p>
                        </div>
                        <div class="row row-cols-2 bg-white p-3 rounded-3">
                            <p class="fw-semibold mb-0">Refund Adj:</p>
                            <p class="mb-0">00 TK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show amount model starts here-->
        <!-- duplicate -->
        <div class="modal fade" id="showAmountModalX" tabindex="-1" aria-labelledby="showAmountModalLabelX"
            aria-hidden="true">
            <div class="modal-dialog model-sm modal-dialog-slide-right" style="max-width: 400px">
                <div class="modal-content" style="background-color: #c4e3ff">
                    <div class="modal-body px-5 py-5">
                        <div class="row row-cols-2 bg-white mb-4 p-3 rounded-3">
                            <p class="fw-semibold mb-0">Payment :</p>
                            <p class="mb-0">2000 TK</p>
                        </div>
                        <div class="row row-cols-2 bg-white p-3 rounded-3">
                            <p class="fw-semibold mb-0">Refund Adj:</p>
                            <p class="mb-0">1000 TK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show amount model ends here-->


        <!-- Id Info model starts here-->
        <!-- duplicate -->
        <div class="modal fade" id="idInfoModalX" tabindex="-1" aria-labelledby="idInfoModalLabelX" aria-hidden="true">
            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                <div class="modal-content">
                    <div class="modal-body pt-4 pb-4 px-5">
                        <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                            <p class="fw-semibold">Tranaction ID</p>
                            <p class="text-info">5412</p>
                        </div>
                        <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                            <p class="fw-semibold">Payment Date</p>
                            <p class="">
                                <span class="me-4">07-06-23</span> 03:00 PM
                            </p>
                        </div>
                        <div class="row row-cols-2 border-bottom border-2 mb-4">
                            <p class="fw-semibold">Unique ID</p>
                            <p class="text-info">37582</p>
                        </div>
                        <div class="row row-cols-2">
                            <p class="fw-semibold">Service ID</p>
                            <p class="text-info">8451</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Id Info model ends here-->


        <!-- Proof model starts here-->
        <!-- duplicate -->
        <div class="modal fade" id="proofModalX" tabindex="-1" aria-labelledby="proofModalLabelX" aria-hidden="true">
            <div class="modal-dialog model-sm modal-dialog-slide-left" style="max-width: 400px">
                <div class="modal-content">
                    <div class="modal-body pt-4 pb-4 px-5">
                        <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                            <p class="fw-semibold">Render By</p>
                            <p class="">Robel Hossen</p>
                        </div>
                        <div class="row row-cols-2 border-bottom border-2 mb-4">
                            <p class="fw-semibold">Ownership By</p>
                            <p class="">Sajid ridoy</p>
                        </div>
                        <div class="row row-cols-2">
                            <p class="fw-semibold">Verifyed By</p>
                            <p class="">Robel Hossen</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Proof model ends here-->
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
        <div class="modal fade" id="createNoteModal" tabindex="-1" aria-labelledby="createNoteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel6">Make A Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="noteForm">
                            @csrf
                            <input type="hidden" name="item_id" id="itemId">
                            <div class="mb-3">
                                <label for="noteTitle" class="form-label text-dark">Note Title</label>
                                <input type="text" name="note_title" class="form-control shadow-none rounded-3" id="noteTitle" placeholder="Maximum 8 words can be given" />
                            </div>
                            <div>
                                <label for="noteDetails" class="form-label text-dark">Note Details</label>
                                <textarea name="note_details" class="form-control shadow-none rounded-3" id="noteDetails" rows="3" placeholder="Maximum 30 words can be given"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-gdark shadow-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnDueSaveNote">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Create Note model ends here-->
        <!-- Pay model starts here-->
        <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-body">
                        <form action="">
                            <div class="mb-3">
                                <label for="holt" class="form-label text-dark">Gateway Payment</label>
                                <input type="text" class="form-control shadow-none rounded-3" id="holt"
                                    placeholder="Input payment" />
                            </div>
                            <div>
                                <label for="lokak" class="form-label text-dark">Refund Adjustment</label>
                                <input class="form-control shadow-none rounded-3" id="lokak" rows="3"
                                    placeholder="Input refund" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pay model ends here-->
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
            <div class="modal-dialog modal-dialog-slide-right" style="max-width: 1100px">
                <div class="modal-content pb-4 pt-3">
                    <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                        <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0" style="padding-left: 40px">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="datef" class="form-label">Date from</label>
                                        <div>
                                            <input type="date" class="form-control shadow rounded-2" id="datef" onchange="inputChange('created_at >=', this.id)" />
                                        </div>
                                    </div>
                                    <div class="pb-3">
                                        <label for="datet" class="form-label">Date To</label>
                                        <input type="date" class="form-control shadow rounded-2" id="datet" onchange="inputChange('created_at <=', this.id)" />
                                    </div>
                                </div>
                                <div class="border-end mt-3" style="height: 125px"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="cntry" class="form-label text-dark">User Type</label>

                                        <select id="cntry" class="shadow rounded-2 form-select"
                                            aria-label="Default select example">
                                            <option selected value="tutor">Tutor</option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="cty" class="form-label text-dark">Service Category</label>

                                        <select id="cty" class="shadow rounded-2 form-select"
                                            aria-label="Default select example">
                                            <option selected value="Batch Payment">
                                                Batch Payment
                                            </option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="border-end mt-3" style="height: 125px"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="cat" class="form-label text-dark">Status</label>

                                        <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('payment_status',this.id)" id="user_id">
                                                    <option value="">Select Employee</option>
                                                    <option value="1">Paid</option>
                                                    <option value="0">Pending</option>

                                            </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="course" class="form-label text-dark">Render By</label>

                                        <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('render_by',this.id)" id="user_id">
                                                    <option value="">Select Employee</option>
                                                    @foreach($employees as $employee)

                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>

                                                    @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="border-end mt-3" style="height: 125px"></div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="am" class="form-label text-dark">Ownership By</label>

                                        <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('ownership_by',this.id)" id="user_id">
                                                    <option value="">Select Employee</option>
                                                    @foreach($employees as $employee)

                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>

                                                    @endforeach

                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="srcid" class="form-label text-dark">Verifyed By</label>

                                        <select name="user" class="form-select rounded-3 shadow-none select2"
                                        aria-label="Default select"
                                        onchange="inputChange('verified_by',this.id)" id="user">
                                        <option value="">Select Employee</option>
                                        @foreach($admin as $adm)

                                        <option value="{{$adm->id}}">{{$adm->name}}</option>

                                        @endforeach


                                </select>
                                    </div>
                                </div>
                            </div>
                            <div class=""></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                        <form action="{{route('admin.due.filter')}}" method="post">
                            @csrf
                            <div>
                                <button type="button" class="btn btn-danger py-1 me-2">
                                    Clear
                                </button>
                                <input type="hidden" id="due_filter" name="due_filter" value="">

                                <button type="submit" class="btn btn-primary py-1">
                                    Apply
                                </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter Model ends here -->
        <!-- main content section ends here -->
    </div>

</div>

<form style="display: none" action="{{ route('admin.tutor.sms-editor') }}" method="POST" id="smsForm">
    @csrf
    <input type="hidden" id="var1" name="all_id" value="" />
</form>
@endsection

@push('page_scripts')
@include('js.swtdeleteMethod_js')
@include('backend.pending_approval.institute_approve.js.index_page_js')
@include('backend.payment.js.duejs')



@endpush
