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
                    @if (Route::currentRouteName() == 'admin.due.payment')
                        <p class="mb-0 text-center mt-1" style="font-size: 10px">
                            All
                        </p>
                    @endif
                    @if (Route::currentRouteName() == 'admin.setpoint.due')
                        <p class="mb-0 text-center mt-1" style="font-size: 10px">
                            After Set Point
                        </p>
                    @endif


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
                    <a class="btn text-nowrap"  data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                        Pending Date Filter
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
                                    <th scope="col" class="text-nowrap">Payment Amount</th>
                                    <th scope="col" class="text-nowrap"> Paid Amount</th>
                                    <th scope="col" class="text-nowrap">Status</th>
                                    <th scope="col" class="text-nowrap">Payment Proof</th>
                                    <th scope="col" class="text-nowrap">Payment Option</th>
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
                                    <td class="text-red">{{$item->service_category}}</td>
                                    <td class="text-info">
                                        <a type="button" class="p-1 rounded text-info text-decoration-none"
                                            style="background-color: #e6eef7" data-bs-toggle="modal"
                                            data-bs-target="#">

                                                {{$item->amount}}

                                        </a>
                                    </td>
                                    <td class="text-info">
                                        <a type="button" class="p-1 rounded text-info text-decoration-none"
                                            style="background-color: #e6eef7" data-bs-toggle="modal"
                                            data-bs-target="#showAmountModal_{{$item->id}}">
                                                {{$item->payment_amount + $item->refund_coin}}

                                        </a>
                                    </td>
                                    <div class="modal fade" id="showAmountModal_{{$item->id}}" tabindex="-1" aria-labelledby="showAmountModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog model-sm modal-dialog-slide-right" style="max-width: 400px">
                                            <div class="modal-content" style="background-color: #c4e3ff">
                                                <div class="modal-body px-5 py-5">
                                                    <div class="row row-cols-2 bg-white mb-4 p-3 rounded-3">
                                                        <p class="fw-semibold mb-0">Payment :</p>
                                                        <p class="mb-0">{{$item->payment_amount}} Tk</p>
                                                    </div>
                                                    <div class="row row-cols-2 bg-white p-3 rounded-3">
                                                        <p class="fw-semibold mb-0">Refund Adj:</p>
                                                        <p class="mb-0">{{$item->refund_coin}} Tk</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    {{-- Payment Option --}}
                                    <td class="">
                                        <a type="button" class="text-decoration-none text-info text-nowrap"
                                            data-bs-toggle="modal" data-bs-target="#paymentOption_{{$item->id}}">
                                            Payment Option
                                        </a>
                                    </td>
                                    <!-- Payment Option model starts here-->
                                    <div class="modal fade" id="paymentOption_{{$item->id}}" tabindex="-1" aria-labelledby="paymentOptionLabel_{{$item->id}}" aria-hidden="true">
                                        <div class="modal-dialog model-sm modal-dialog-slide-left" style="max-width: 400px">
                                            <div class="modal-content">
                                                @php
                                                    $tutorAccount = App\Models\TutorAccount::where('tutor_id',$item->tutor_id)->first();

                                                @endphp
                                                <div class="modal-body pt-4 pb-4 px-5">
                                                    <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                                                        <p class="fw-semibold">Account Name</p>
                                                        <p class="">{{$tutorAccount->tutor->name ?? 'n/a'}}</p>
                                                    </div>
                                                    <div class="row row-cols-2 border-bottom border-2 mb-4">
                                                        <p class="fw-semibold">Account Type</p>
                                                        <p class="">{{$tutorAccount->account_type ?? 'n/a'}}</p>
                                                    </div>
                                                    <div class="row row-cols-2">
                                                        <p class="fw-semibold">Account Number</p>
                                                        <p class="">{{$tutorAccount->number ?? 'n/a'}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Payment Option model ends here-->

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
                                            data-bs-target="#payModal_{{$item->id}}">
                                            Pay
                                            </button>
                                            @elseif ($item->payment_status == 1 && $item->payment_amount + $item->refund_coin != $item->amount) <button class="btn btn-info py-1" data-bs-toggle="modal"
                                            data-bs-target="#payModal_{{$item->id}}">
                                            Partial payment
                                            </button>
                                            @elseif ($item->payment_status == 1 && $item->payment_amount + $item->refund_coin == $item->amount) <button class="btn btn-info py-1" data-bs-toggle="modal"
                                            data-bs-target="#payModal_{{$item->id}}">
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


                                <!-- Note model ends here-->
                                <!-- Pay model starts here-->
                                <div class="modal fade" id="payModal_{{$item->id}}" tabindex="-1" aria-labelledby="payLabel_{{$item->id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">

                                            <form action="{{route('admin.due.paid')}}" method="post">
                                                @csrf

                                                <input type="hidden" name="application_id" value="{{$item->application_id}}">
                                                <input type="hidden" name="due_id" value="{{$item->id}}">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="holt" class="form-label text-dark">Payment Method</label>
                                                         <input type="text" name="payment_method" value="{{$item->sending_method}}" class="form-control shadow-none rounded-3" id="holt"
                                                            placeholder="Input method" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="holt" class="form-label text-dark">Transaction ID</label>
                                                        <input type="text" name="trx_id" value="{{$item->trx_id}}" class="form-control shadow-none rounded-3" id="holt"
                                                            placeholder="trx id" />
                                                    </div>
                                                    <div>
                                                        <label for="lokak" class="form-label text-dark">Payment Amount</label>
                                                        <input type="number" name="payment_amount" value="{{$item->payment_amount}}" class="form-control shadow-none rounded-3" id="lokak" rows="3"
                                                            placeholder="Input refund" />
                                                    </div>
                                                    <div>
                                                        <label for="lokak" class="form-label text-dark">Refund Coin</label>
                                                        <input type="number" name="refund_coin" value="{{$item->refund_coin}}" class="form-control shadow-none rounded-3" id="lokak" rows="3"
                                                            placeholder="Input refund" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                                        <textarea class="form-control" id="exampleFormControlTextarea1"  name="refund_complete_note" rows="3" placeholder="Enter Note">{{$item->refund_complete_note ?? ''}} </textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        Submit
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!-- Pay model ends here-->

                                <div class="modal fade" id="showStatusModal_{{$item->id}}" tabindex="-1" aria-labelledby="showStatusModal_{{$item->id}}"
                                    aria-hidden="true">
                                    <div class="modal-dialog model-sm modal-dialog-slide-right" style="max-width: 400px">
                                        <div class="modal-content" style="background-color: #c4e3ff">
                                            <div class="modal-body pt-5 pb-4">
                                                <p class="text-center text-info fs-3">
                                                    Pending To: <br>{{ optional($item->job)->refund_date ? \Carbon\Carbon::parse($item->job->refund_date)->format('Y-m-d') : '' }}
                                                </p>


                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        <div class="modal fade" id="showDateTimeModal" tabindex="-9999" aria-labelledby="showDateTimeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                <div class="modal-content">
                    <div class="modal-body pt-5 pb-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 pe-4">
                                <div class="pb-3">
                                    <label for="pendinf" class="form-label">Pending Due from</label>
                                    <div>
                                        <input type="date" class="form-control shadow rounded-2" id="pendinf" onchange="inputChange('refund_date >=', this.id)" />
                                    </div>
                                </div>
                                <div class="pb-3">
                                    <label for="pendingt" class="form-label">Pending Due To</label>
                                    <input type="date" class="form-control shadow rounded-2" id="pendingt" onchange="inputChange('refund_date <=', this.id)" />
                                </div>
                            </div>
                            <div class="border-end mt-3" style="height: 125px"></div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                            <form action="{{route('admin.due.filter.pendingdate')}}" method="post">
                                @csrf
                                <div>
                                    <button type="button" class="btn btn-danger py-1 me-2">
                                        Clear
                                    </button>
                                    <input type="hidden" id="due_filter_pending_date" name="due_filter_pending_date" value="">

                                    <button type="submit" class="btn btn-primary py-1">
                                        Apply
                                    </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter model starts here -->

    </div>

</div>
<div class="modal fade font-pop" id="filterModal" tabindex="-2" aria-labelledby="filterModalLabel"
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

                                        <select name="service_category" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('service_category',this.id)" id="service_category">
                                                    <option value="">Select </option>
                                                    <option value="Refund">Refund</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="border-end mt-3" style="height: 125px"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="cat" class="form-label text-dark">Status</label>

                                        <select name="payment_status" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('payment_status',this.id)" id="payment_status">
                                                    <option value="">Select Employee</option>
                                                    <option value="1">Paid</option>
                                                    <option value="0">Pending</option>

                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="course" class="form-label text-dark">Render By</label>

                                        <select name="render" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('render_by',this.id)" id="render">
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

                                        <select name="ownership" class="form-select rounded-3 shadow-none select2"
                                                    aria-label="Default select"
                                                    onchange="inputChange('ownership_by',this.id)" id="ownership">
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
