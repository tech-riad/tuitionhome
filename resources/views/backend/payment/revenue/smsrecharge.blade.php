@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

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
                        <p class="text-center fw-bold fs-5 mb-1">{{$totalTutorRecharge}}</p>
                        <p class="text-center mb-0">Total Tutor Recharge</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="bg-white text-nowrap shadow-lg rounded-3 p-2 ps-5 ps-lg-4 ps-xl-5 mb-4 text-gray-800">
                        Amount :
                        <span class="ms-1">00000</span>
                    </div>
                    <div class="bg-white shadow-lg rounded-3 p-2 ps-5 ps-lg-4 ps-xl-5 text-gray-800">
                        Count : <span class="ms-3 ps-1">00</span>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 gap-4 row-cols-md-2 row-cols-lg-4 gap-md-0 ms-1 me-1">
                <div class="mb-md-4 mb-lg-0">
                    <div class="bg-white shadow-lg rounded-3 p-4">
                        <p class="text-center fw-bold fs-5 mb-1">{{$smsRechargeSum ?? 0}}</p>
                        <p class="text-center mb-0">Total Taka Recharge</p>
                    </div>
                </div>
                <div class="mb-md-4 mb-lg-0">
                    <div class="bg-white shadow-lg rounded-3 p-4">
                        <p class="text-center fw-bold fs-5 mb-1">{{$todaySmsRechargeSum}}</p>
                        <p class="text-center mb-0 text-nowrap">Today Taka Recharge</p>
                    </div>
                </div>
                <div class="">
                    <div class="bg-white shadow-lg rounded-3 p-4">
                        <p class="text-center fw-bold fs-5 mb-1">{{$totalCount ?? ''}}</p>
                        <p class="text-center mb-0">Total Count</p>
                    </div>
                </div>
                <div class="">
                    <div class="bg-white shadow-lg rounded-3 p-4">
                        <p class="text-center fw-bold fs-5 mb-1">{{$todayCount}}</p>
                        <p class="text-center mb-0">Today Count</p>
                    </div>
                </div>
            </div>
            <!-- header cards ends here -->
            <!-- table starts here -->
            <div class="ps-3 mt-4" style="padding-right: 13px">
                <div
                    class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
                    <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-sliders2 me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-ndark">Send Bulk SMS</button>
                        @if(in_array(Auth::user()->role_id, [1, 6]))
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                            <i class="bi bi-currency-dollar"></i>Recharge Sms
                        </button>

                        @endif
                    </div>

                    <div class="modal fade font-pop" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-slide-right" style="max-width: 600px">
                            <div class="modal-content pb-4 pt-3">
                                <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                                    <h4 class="modal-title" id="exampleModalLabel">Sms Recharge</h4>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.sms.recharge.add') }}" method="POST">
                                    @csrf
                                    <div class="modal-body py-0" style="padding-left: 40px">
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-8">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 pe-4">
                                                    <div class="pb-3">
                                                        <label for="trx_id" class="form-label required">Transction Id</label>
                                                        <div>
                                                            <input type="text" class="form-control shadow rounded-2" name="trx_id" required/>
                                                        </div>
                                                    </div>

                                                    <div class="pb-3">
                                                        <label for="datet" class="form-label required">Tutor Phone</label>
                                                        <input type="number" class="form-control shadow rounded-2" required
                                                            name="tutor_phone" />

                                                    </div>
                                                </div>
                                                <div class="border-end mt-3" style="height: 125px"></div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 pe-4">
                                                    <div class="pb-3">
                                                        <label for="trx_id" class="form-label required">Amount</label>
                                                        <div>
                                                            <input type="number" class="form-control shadow rounded-2" name="amount" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="border-end mt-3" style="height: 125px"></div>
                                            </div>


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
                            <div class=""></div>
                        </div>
                    </div>


                    <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                        <a href="{{route('admin.sms.recharge')}}" class="btn {{ Request::is('admin/payment/sms-recharge') ? 'btn-gdark' : '' }}">All</a>
                        <a href="{{route('admin.revenue.setpoint.smsrecharge')}}" class="btn {{ Request::is('admin/set-point-sms-recharge') ? 'btn-gdark' : '' }} text-nowrap">
                            Set A Point
                        </a>
                        <form action="{{route('admin.sms.recharge.search')}}" method="post">
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
                                            <input class="form-check-input ms-3" type="checkbox" value=""
                                                id="flexCheckDefault" style="margin-right: 12px" />#SL
                                        </th>
                                        <th scope="col" class="text-nowrap">Date</th>
                                        <th scope="col" class="text-nowrap">ID Info :</th>
                                        <th scope="col" class="text-nowrap">User Type</th>
                                        <th scope="col" class="text-nowrap">Name</th>
                                        <th scope="col" class="text-nowrap">
                                            Service Category
                                        </th>
                                        <th scope="col" class="text-nowrap">Amount</th>
                                        <th scope="col" class="text-nowrap">Affiliate</th>
                                        <th scope="col" class="text-nowrap">Payment proof</th>
                                        <th scope="col" class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($smsrecharges as $item)
                                    <tr class="" style="vertical-align: middle">
                                        <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                            <input class="form-check-input me-2" type="checkbox" value=""
                                                id="flexCheckDefault" />

                                                {{$loop->iteration}}
                                        </td>
                                        <td class="">
                                            <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                                data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                {{ isset($item->created_at) ? $item->created_at->format('Y-m-d') : '' }}
                                                    <br>
                                                {{ isset($item->created_at) ? $item->created_at->format('g:i A') : '' }}

                                            </a>
                                        </td>
                                        <!-- Show Date time model starts here-->
                                        <div class="modal fade" id="showDateTimeModal" tabindex="-1" aria-labelledby="showDateTimeModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                                                <div class="modal-content">
                                                    <div class="modal-body pt-5 pb-4">
                                                        <p class="text-center text-info fs-3">{{ isset($item->created_at) ? $item->created_at->format('Y-m-d') : '' }}</p>
                                                        <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                                            {{ isset($item->created_at) ? $item->created_at->format('g:i A') : '' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Show Date time model ends here-->
                                        <td class="text-info">
                                            <a type="button" class="text-decoration-none text-info"
                                                data-bs-toggle="modal" data-bs-target="#idInfoModal_{{$item->id}}">ID Info :</a>
                                        </td>

                                        <div class="modal fade" id="idInfoModal_{{$item->id}}" tabindex="-1" aria-labelledby="idInfoModalLabel_{{$item->id}}"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-sm modal-dialog-slide-left" style="max-width: 400px">
                                                <div class="modal-content">
                                                    <div class="modal-body pt-4 pb-4 px-5">
                                                        <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                                                            <p class="fw-semibold">Tranaction ID</p>
                                                            <p class="text-info">{{$item->invoice_no ?? ''}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-2 mb-4">
                                                            <p class="fw-semibold">Unique ID</p>
                                                            <p class="text-info">{{$item->tutor->unique_id ?? ''}}</p>
                                                        </div>
                                                        {{-- <div class="row row-cols-2">
                                                            <p class="fw-semibold">Service ID</p>
                                                            <p class="text-info">{{$item->job_offer_id ?? ''}}</p>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <td class="">Tutor</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('admin.tutor.tutorshow', ['tutor' => $item->tutor_id]) }}">{{$item->tutor->name ?? ''}}</a>
                                        </td>
                                        <td>{{$item->recharge_title ?? ''}}</td>
                                        <td class="text-info">
                                            <a type="button" class="p-1 rounded text-info text-decoration-none"
                                                style="background-color: #e6eef7" data-bs-toggle="modal"
                                                data-bs-target="#showAmountModal">
                                                {{$item->amount ?? ''}}
                                            </a>
                                        </td>
                                        <!-- Show editable Date time model ends here-->
                                        <!-- Show amount model starts here-->
                                        {{-- <div class="modal fade" id="showAmountModal" tabindex="-1" aria-labelledby="showAmountModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-sm modal-dialog-slide-right" style="max-width: 400px">
                                                <div class="modal-content" style="background-color: #c4e3ff">
                                                    <div class="modal-body px-5 py-5">
                                                        <div class="row row-cols-2 bg-white mb-4 p-3 rounded-3">
                                                            <p class="fw-semibold mb-0">Payment :</p>
                                                            <p class="mb-0">2000 TK</p>
                                                        </div>
                                                        <div class="row row-cols-2 bg-white p-3 rounded-3">
                                                            <p class="fw-semibold mb-0">Refund :</p>
                                                            <p class="mb-0">1000 TK</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- Show amount model ends here-->
                                        <!-- Id Info model starts here-->
                                        <td class="text-nowrap">No</td>
                                        <td class="">
                                            <a type="button" class="text-decoration-none text-info text-nowrap"
                                                data-bs-toggle="modal" data-bs-target="#proofModal_{{$item->id}}">
                                                Proof
                                            </a>
                                        </td>

                                        <!-- Proof model starts here-->
                                        <div class="modal fade" id="proofModal_{{$item->id}}" tabindex="-1" aria-labelledby="proofModalLabel_{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                                                <div class="modal-content">
                                                    <div class="modal-body pt-4 pb-4 px-5">
                                                        {{-- <div class="row row-cols-2 mt-3 border-bottom border-2 mb-4">
                                                            <p class="fw-semibold">Render By</p>
                                                            <p class="">{{$item->application->taken_at ?? ''}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-2 mb-4">
                                                            <p class="fw-semibold">Ownership By</p>
                                                            <p class="">{{$item->application->user->name ?? ''}}</p>
                                                        </div> --}}
                                                        <div class="row row-cols-2">
                                                            <p class="fw-semibold">Verifyed By</p>
                                                            <p class="">{{$item->verified_by ?? ''}}</p>
                                                        </div>
                                                        <div class="row row-cols-2">
                                                            <p class="fw-semibold">Render By</p>
                                                            <p class="">{{$item->render->name ?? ''}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Proof model ends here-->


                                        <td class="">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning py-1">
                                                    Verify
                                                </button>
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
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#noteModal" href="#">Note</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#createNoteModal" href="#">Create a
                                                                Note</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#logModal" href="#">Log</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- pagination starts here -->
                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                            {{ $smsrecharges->appends(request()->query())->links() }}

                        </div>
                        <!-- pagination ends here -->
                    </div>
                </div>
            </div>
            <!-- table ends here -->

            <!-- Show  editable Date time model starts here-->
            <div class="modal fade" id="showEditableDateTimeModal" tabindex="-1"
                aria-labelledby="showEditableDateTimeModalLabel" aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-centered" style="max-width: 400px">
                    <div class="modal-content">
                        <div class="modal-body pt-5 pb-4">
                            <form action="{{route('admin.revenue.setpoint.smsrecharge')}}">

                                <div class="pb-3">
                                    <label for="datef" class="form-label">Date from</label>
                                    <div>
                                        <input type="date" class="form-control shadow rounded-2" name="datefr"  />
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary py-1">
                                        Apply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Proof model starts here-->
            <!-- duplicate -->
            <div class="modal fade" id="proofModalX" tabindex="-1" aria-labelledby="proofModalLabelX"
                aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
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
                                    <label for="exampleFormControlInput1" class="form-label text-dark">Note
                                        Title</label>
                                    <input type="text" class="form-control shadow-none rounded-3"
                                        id="exampleFormControlInput1" placeholder="Maximum 8 words can be given " />
                                </div>
                                <div>
                                    <label for="exampleFormControlTextarea1" class="form-label text-dark">Note
                                        Details</label>
                                    <textarea class="form-control shadow-none rounded-3"
                                        id="exampleFormControlTextarea1" rows="3"
                                        placeholder="Maximum 30 words can be given"></textarea>
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
                                            <label for="datef" class="form-label text-dark">Date from</label>
                                            <div class="">
                                                <input type="date" class="form-control shadow rounded-2" id="datef" />
                                            </div>
                                        </div>
                                        <div class="pb-3">
                                            <label for="datet" class="form-label text-dark">Date To</label>
                                            <input type="date" class="form-control shadow rounded-2" id="datet" />
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
                                            <label for="cat" class="form-label text-dark">Affiliate</label>

                                            <select id="cat" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="course" class="form-label text-dark">Render By</label>

                                            <select id="course" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="Sajid Riyad">
                                                    Sajid Riyad
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
                                            <label for="am" class="form-label text-dark">Ownership By</label>

                                            <select id="am" class="shadow rounded-2 form-select"
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
                                        <div class="pb-3">
                                            <label for="srcid" class="form-label text-dark">Verifyed By</label>

                                            <select id="srcid" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="Sajid Riyad">
                                                    Sajid Riyad
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
                        <div class="modal-footer d-flex justify-content-end align-items-center"
                            style="padding-right: 27px">
                            <div class="pe-2">
                                <button type="button" class="btn btn-danger py-1 me-2">
                                    Clear
                                </button>
                                <a href="index-filter-apply.html" type="button" class="btn btn-primary py-1">
                                    Apply
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filter Model ends here -->
            <!-- main content section ends here -->
        </div>
</div>

@endsection

@push('page_scripts')
@include('js.swtdeleteMethod_js')
@include('backend.pending_approval.institute_approve.js.index_page_js')

@endpush
