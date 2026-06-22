@extends('layouts.app')

{{-- <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" /> --}}

<style>
    .active-button {
        border: 10px solid red;
        /* Adjust the border properties as needed */
    }

</style>
@section('content')
@if(session('message'))
<p class="alert alert-success">{{ session('message') }}</p>
@endif
<div class="container-fluid">
    <div class="row">
        <!-- sidebar starts here -->
        <!-- sidebar ends here -->
        <main class="container-custom">
            <div class="col-md-12 ms-sm-auto col-lg-12 col-xl-12 p-md-4" {{-- style="margin-top: 70px" --}}>
                <!-- tab nav starts here -->
                <div class="tabholder bg-white">
                    <ul class="nav nav-pills mb-3 d-flex justify-content-start" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">

                            <button class="nav-link pe-3" id="pills-dashboard-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-dashboard" type="button" role="tab"
                                aria-controls="pills-dashboard" aria-selected="true">
                                Dashboard
                            </button>
                        </li>
                        @php
                                    $user_id = Auth::user()->role_id;
                                    // if ($user_id == 2) {
                                    // # code...
                                    // }
                                    @endphp
                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'assign')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'assign')->count() }}
                                    @endif
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link active pe-2 ps-2" id="pills-assign-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-assign" type="button" role="tab" aria-controls="pills-assign"
                                aria-selected="false">
                                Assign
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">







                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-waiting-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-waiting" type="button" role="tab" aria-controls="pills-waiting"
                                aria-selected="false">
                                Waiting
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">


                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'waiting')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'waiting')->count() }}
                                    @endif

                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-meeting-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-meeting" type="button" role="tab" aria-controls="pills-meeting"
                                aria-selected="false">
                                Meeting
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">

                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'meet')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'meet')->count() }}
                                    @endif

                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-trail-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-trail" type="button" role="tab" aria-controls="pills-trail"
                                aria-selected="false">
                                Trail
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">


                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'trial')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'trial')->count() }}
                                    @endif



                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-problem-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-problem" type="button" role="tab" aria-controls="pills-trail"
                                aria-selected="false">
                                problem
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">


                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'problem')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'problem')->count() }}
                                    @endif

                                </span>
                            </button>
                        </li> --}}

                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-repost-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-repost" type="button" role="tab" aria-controls="pills-repost"
                                aria-selected="false">
                                Repost
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">



                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'repost')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'repost')->count() }}
                                    @endif

                                </span>
                            </button>
                        </li> --}}
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-closed-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-closed" type="button" role="tab" aria-controls="pills-closed"
                                aria-selected="false">
                                Closed
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">



                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'closed')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'closed')->count() }}
                                    @endif


                                </span>
                            </button>
                        </li> --}}
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-confirm-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-confirm" type="button" role="tab" aria-controls="pills-confirm"
                                aria-selected="false">
                                Confirm
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">


                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('current_stage', 'confirm')
                                            ->where('payment_status', null)
                                            ->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('current_stage', 'confirm')
                                             ->where('payment_status', null)
                                            ->count() }}
                                    @endif
                                </span>
                            </button>
                        </li> --}}


                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-payment-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-payment" type="button" role="tab" aria-controls="pills-payment"
                                aria-selected="false">
                                Payment
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">
                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('payment_status', 'paid')
                                         ->orWhere('payment_status', 'Partial_paid')
                                         ->orWhere('payment_status', 'due')
                                        ->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('payment_status', 'paid')
                                      ->orWhere('payment_status', 'Partial_paid')
                                      ->orWhere('payment_status', 'due')
                                        ->count() }}
                                    @endif

                                </span>
                            </button>
                        </li> --}}

                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-due-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-due" type="button" role="tab" aria-controls="pills-due"
                                aria-selected="false">
                                Due
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">
                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('payment_status', 'Partial_paid')
                                        ->orWhere('payment_status', 'due')
                                        ->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('payment_status', 'Partial_paid')
                                         ->orWhere('payment_status', 'due')
                                        ->count() }}
                                    @endif
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link pe-3" id="pills-refund-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-refund" type="button" role="tab" aria-controls="pills-refund"
                                aria-selected="false">
                                Refund
                                <span class="badge rounded-pill text-gray-700 bg-light fw-normal">
                                    @if ($user_id == 2)
                                    {{ App\Models\JobApplication::where('payment_status', 'refund')->where('taken_by_id', Auth::id())->count() }}
                                    @else
                                    {{ App\Models\JobApplication::where('payment_status', 'refund')->count() }}
                                    @endif

                                </span>
                            </button>
                        </li> --}}
                    </ul>
                </div>

                <!-- tab nav ends here -->
                <!-- main content section starts here -->

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-dashboard" role="tabpanel"
                        aria-labelledby="pills-dashboard-tab" tabindex="0">
                        <!-- this is dashboard tab  -->
                        Nothing Here!
                    </div>

                    <div class="tab-pane fade show active" id="pills-assign" role="tabpanel"
                        aria-labelledby="pills-assign-tab" tabindex="0">
                        <!-- this is assign tab  -->

                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>

                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <form action="{{ route('admin.application.assign.search') }}" method="POST">
                                    @csrf
                                    <div class="input-group" style="width: fit-content">
                                        <input name="assignSearch" type="text"
                                            class="form-control shadow-none rounded-start"
                                            placeholder="Search here..." />

                                        <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @if (@$taken_job_search)
                            <div class="table-responsive">
                                <table class="table table-sm bg-white shadow-none border border-1" id="payment_table">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col" class="text-nowrap">Tution ID</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col" class="text-nowrap">Tutor Name</th>
                                            <th scope="col" class="text-nowrap">Tutor ID</th>
                                            <th scope="col" class="text-nowrap">charge</th>
                                            <th scope="col" class="text-nowrap">Payment</th>
                                            <th scope="col">Due Amount</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>




                                        @foreach ($taken_job_search as $payment_application)
                                        @php
                                        $input = $payment_application->panding_to;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $problem_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $problem_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp


                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $problem_a_date }}</p>
                                                    <p class="m-0 fw-light">{{ $problem_a_time ?? 'n/a' }}</p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $payment_application->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $payment_application->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $payment_application->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $payment_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $payment_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$payment_application->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>

                                                @php
                                                $tAduTotalElements = count($payment_application->tutor->tutor_education
                                                ?? []);
                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $payment_application->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $payment_application->Tutor->name }}

                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $payment_application->Tutor->phone ?? 'n/a' }} </p>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $payment_application->tutor_id }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b> {{ $payment_application->charge }} </b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $payment_application->received_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $payment_application->due_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">

                                                {{ $payment_application->payment_status ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $payment_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $payment_application->id }},'waitingOffcanvas')"
                                                                    type="button" class="dropdown-item"
                                                                    {{-- data-bs-toggle="offcanvas" --}}
                                                                    {{-- data-bs-target="#changeStageModal" --}}>
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>

                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $payment_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $payment_application->id }}"
                                                                    onclick="stageJobId(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#paymentTabRefundModal">
                                                                    Refund
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $payment_applications->links() }}

                                </div>
                            </div>
                            @else
                            <div class="table-responsive">
                                <table class="table bg-white shadow-none border border-1" id="takenApplicationTable">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Job Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($taken_jobs as $taken_job)
                                        @php
                                        $input = $taken_job->taken_at;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $taken_date = Carbon\Carbon::parse($input)->format($format1);
                                        $taken_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $taken_date }}</p>
                                                    <p class="m-0 fw-light">{{ $taken_time }}</p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    {{-- <p class="m-0 text-nowrap">abdul</p> --}}

                                                    <a
                                                        href="{{ route('admin.job-details', $taken_job->jobOffer->id) }}">
                                                        <p class="m-0 fw-light">ID:{{ $taken_job->jobOffer->id }}
                                                        </p>
                                                    </a>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $taken_job->job_offer->course->name ?? 'n\a' }}</p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $taken_job->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $taken_job->job_offer->location->name ?? 'n/a' }}</p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$taken_job->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            {{-- <td></td> --}}


                                            @php
                                            $tAduTotalElements = count($taken_job->tutor->tutor_education ?? []) ??
                                            'n/a';
                                            @endphp
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    @if($taken_job->Tutor)
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $taken_job->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $taken_job->Tutor->name ?? 'n/a' }}
                                                                @if($taken_job->Tutor->isVerified)
                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                                @endif
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $taken_job->Tutor->phone ?? 'n/a' }}
                                                        </p>
                                                    </div>
                                                    @else
                                                    <!-- Handle the case where $taken_job->Tutor is not available -->
                                                    <p class="m-0 text-nowrap">Tutor information not available</p>
                                                    @endif
                                                </div>
                                            </td>

                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $taken_job->current_stage }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @php
                                                if ($taken_job->taken_by_id == Auth::user()->id) {
                                                $assign_my_stage = $taken_job->current_stage;
                                                }

                                                @endphp

                                                {{ $assign_my_stage ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', $taken_job->id ?? '') }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $taken_job->id }},'waitingOffcanvas')"
                                                                    type="button" class="dropdown-item"
                                                                    {{-- data-bs-toggle="offcanvas" --}}
                                                                    {{-- data-bs-target="#changeStageModal" --}}>
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $taken_job->id }}" onclick="btnNote(this.id)"
                                                                    data-bs-toggle="modal" data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $taken_jobs->links() }}

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>








                    <div class="tab-pane fade" id="pills-waiting" role="tabpanel" aria-labelledby="pills-waiting-tab"
                        tabindex="0">
                        <!-- this is meeting tab  -->

                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="delay">Delay</option>
                                    <option value="long time">Long Time</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>

                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Hot</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Tag</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>



                                <form action="{{ route('admin.application.waiting.search') }}" method="POST">
                                    @csrf
                                    <div class="input-group" style="width: fit-content">
                                        <input name="waitingSearch" type="text"
                                            class="form-control shadow-none rounded-start"
                                            placeholder="Search here..." />

                                        <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>



                                {{-- <div class="input-group" style="width: fit-content">
                                        <input type="text" class="form-control shadow-none rounded-start"
                                        placeholder="Search here..."
                                        aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default" />
                                        <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div> --}}
                            </div>
                            <div class="table-responsive" id="waitingApplicationTable">
                                <table class="table bg-white shadow-none border border-1">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($waiting_applications as $w_application)
                                        @php
                                        $input = $w_application->waiting_date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $waiting_date = Carbon\Carbon::parse($input)->format($format1);
                                        $waiting_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $waiting_date }}</p>
                                                    <p class="m-0 fw-light">
                                                        {{ date('h:i A', strtotime($w_application->waiting_time)) ?? 'n/a' }}
                                                    </p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    {{-- <p class="m-0 text-nowrap">abdul</p> --}}

                                                    <a
                                                        href="{{ route('admin.job-details', $w_application->jobOffer->id) }}">
                                                        <p class="m-0 fw-light">
                                                            ID:{{ $w_application->jobOffer->id }}
                                                        </p>
                                                    </a>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $w_application->job_offer->course->name ?? 'n\a' }}</p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $w_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $w_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$w_application->job_offer->city->name }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                $tAduTotalElements = count($w_application->tutor->tutor_education ??
                                                []);
                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $w_application->Tutor->id ?? '') }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $w_application->Tutor->name ?? 'n/a' }}
                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $w_application->Tutor->phone ?? 'n/a' }}
                                                        </p>
                                                        {{-- Display tutor_education information --}}
                                                        @if (!empty($w_application->Tutor->tutor_education) &&
                                                        $tAduTotalElements > 0)
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ Str::limit($w_application->Tutor->tutor_education[$tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                                        </p>
                                                        @else
                                                        <p class="m-0 fw-light text-nowrap">N/A</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $w_application->current_stage }}
                                            </td>
                                            <td class="" style="vertical-align: middle">
                                                {{ $w_application->condition }} gfrgr
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @php
                                                if ($w_application->taken_by_id == Auth::user()->id) {
                                                $waiting_my_stage = $w_application->current_stage;
                                                }

                                                @endphp

                                                {{ $waiting_my_stage ?? 'NA' }}
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', $w_application->id ?? '') }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $w_application->id }},'meetOffcanvas')"
                                                                    type="button" class="dropdown-item"
                                                                    {{-- data-bs-toggle="offcanvas"
                                                                            data-bs-target="#changeMeetingStageModal" --}}>
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $w_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $waiting_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="tab-pane fade" id="pills-trail" role="tabpanel" aria-labelledby="pills-trail-tab"
                        tabindex="0">
                        <!-- this is trail tab  -->
                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="delay">Delay</option>
                                    <option value="long time">Long Time</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>
                                {{-- <input type="text" name="daterange" value=" Today Trial In :{{$todayTrial ?? 0}}"
                                    class="form-control shadow-none rounded" readonly style="width: fit-content" /> --}}

                                {{-- <select style="width: fit-content" class="form-select shadow-none rounded"
                                        aria-label="Default select example">
                                        <option selected>Today
                                            <h2 class="text-bold">


                                            </h2>
                                        </option>

                                    </select> --}}
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Hot</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Tag</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default" />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" id="trialApplicationTable">
                                <table class="table bg-white shadow-none border border-1">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>






                                        @foreach ($trial_applications as $t_application)
                                        @php
                                        $input = $t_application->trial_date_1st;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $trial_date = Carbon\Carbon::parse($input)->format($format1);
                                        $trial_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <tr>


                                            {{-- this is tril table --}}

                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $trial_date }}</p>
                                                    <p class="m-0 fw-light">
                                                        {{ date('h:i A', strtotime($t_application->trial_time_1st)) ?? 'n/a' }}
                                                    </p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $t_application->job_offer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            {{ $t_application->job_offer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $t_application->job_offer->course->name ?? 'n\a' }}</p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $t_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            {{-- <td>{{ $t_application->id }}</td> --}}

                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $t_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        <b> {{ @$t_application->job_offer->city->name }} </b>
                                                    </p>
                                                </div>
                                            </td>


                                            @php
                                            $tAduTotalElements = count($t_application->tutor->tutor_education ?? []);
                                            @endphp

                                            <td>
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        @if ($t_application->tutor)
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $t_application->tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $t_application->tutor->name }}
                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $t_application->tutor->phone ?? 'n/a' }}
                                                        </p>
                                                        {{-- Display tutor_education information --}}
                                                        @if (!empty($t_application->tutor->tutor_education) &&
                                                        $tAduTotalElements > 0)
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ Str::limit($t_application->tutor->tutor_education[$tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                                        </p>
                                                        @else
                                                        <p class="m-0 fw-light text-nowrap">N/A</p>
                                                        @endif
                                                        @else
                                                        <p class="m-0 fw-light text-nowrap">Tutor not found</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>


                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $t_application->current_stage }}
                                            </td>
                                            <td class="" style="vertical-align: middle">
                                                {{ $t_application->condition ?? 'n/a'}}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @php
                                                if ($t_application->taken_by_id == Auth::user()->id) {
                                                $meet_my_stage = $t_application->current_stage;
                                                }

                                                @endphp

                                                {{ $meet_my_stage ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">

                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $t_application->id]) }}">Manage</a>
                                                            </li>


                                                            <li>
                                                                <button type="button"
                                                                    onclick="stageJobId({{ $t_application->id }},'problemOffcanvas')"
                                                                    class="dropdown-item" {{-- data-bs-toggle="offcanvas"
                                                                            data-bs-target="#problemOffcanvas" --}}>
                                                                    Change Stage trial
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">Stage
                                                                    Line</a>
                                                            </li>
                                                            <li>

                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $t_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $trial_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- meeting tab --}}



                    <div class="tab-pane fade" id="pills-meeting" role="tabpanel" aria-labelledby="pills-meeting-tab"
                        tabindex="0">
                        <!-- this is meeting tab  -->

                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="delay">Delay</option>
                                    <option value="long time">Long Time</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>

                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Hot</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Tag</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default" />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" id="meetApplicationTable">
                                <table class="table bg-white shadow-none border border-1">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($meeting_applications as $m_application)
                                        @php
                                        $input = $m_application->meeting_date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $meeting_datee = Carbon\Carbon::parse($input)->format($format1);
                                        $meeting_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <tr>
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $meeting_datee ?? 'n/a' }}</p>
                                                    <p class="m-0 fw-light">
                                                        {{ date('h:i A', strtotime($m_application->meeting_time)) ?? 'n/a' }}
                                                    </p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $m_application->job_offer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $m_application->job_offer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $m_application->job_offer->course->name ?? 'n\a' }}</p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $m_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $m_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$m_application->job_offer->city->name }}</p>
                                                </div>
                                            </td>



                                            <td>
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $m_application->Tutor->id ?? '') }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $m_application->Tutor->name  ?? '' }}

                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $m_application->Tutor->phone ?? 'n/a' }} </p>


                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $m_application->current_stage  ?? ''}}
                                            </td>
                                            <td class="" style="vertical-align: middle">Hot</td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">

                                                @php
                                                if ($m_application->taken_by_id == Auth::user()->id) {
                                                $meet_my_stage = $m_application->current_stage;
                                                }

                                                @endphp

                                                {{ $meet_my_stage ?? 'NA' }}


                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $m_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $m_application->id }},'trailOffcanvas')"
                                                                    type="button" class="dropdown-item" {{-- data-bs-toggle="offcanvas"
                                                                            data-bs-target="#trailOffcanvas" --}}>
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">Stage
                                                                    Line</a>
                                                            </li>
                                                            <li>


                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $m_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $meeting_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="tab-pane fade" id="pills-trail" role="tabpanel" aria-labelledby="pills-trail-tab"
                        tabindex="0">
                        <!-- this is trail tab  -->

                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="delay">Delay</option>
                                    <option value="long time">Long Time</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>

                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Hot</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Tag</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default" />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table bg-white shadow-none border border-1">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr style="
                        border-bottom: 1px solid #dee2e6;
                        background-color: #f5ffd9;
                      ">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0">Sep 20, 2023</p>
                                                    <p class="m-0 fw-light">7: 30 am</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0">Abdul Karim</p>
                                                    <p class="m-0 fw-light">ID:2467e4</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0">Class 10</p>
                                                    <p class="m-0 fw-light">Bangla Medium</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0">Mirpur 10</p>
                                                    <p class="m-0 fw-light">Dhaka</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <p class="m-0">
                                                            Sujon Islam
                                                            <span>
                                                                <i class="bi bi-check-circle-fill text-info"></i>
                                                            </span>
                                                        </p>
                                                        <p class="m-0 fw-light">University of Dhaka</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                Meeting
                                            </td>
                                            <td class="" style="vertical-align: middle">Cold</td>

                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                Assign
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false" style="
                              background-color: transparent;
                              border: none;
                            ">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="dropdown-item" href="#">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#trailchangestageModal">
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">Stage
                                                                    Line</a>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal" data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-problem" role="tabpanel" aria-labelledby="pills-problem-tab"
                        tabindex="0">



                        <!-- this is problem tab  -->

                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="delay">Delay</option>
                                    <option value="long time">Long Time</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>

                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Hot</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Tag</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default" />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" id="problemApplicationTable">
                                <table class="table bg-white shadow-none border border-1">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>









                                        @foreach ($problem_applications as $problem_application)
                                        @php
                                        $input = $problem_application->panding_to;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $problem_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $problem_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp


                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $problem_a_date }}</p>
                                                    <p class="m-0 fw-light">{{ $problem_a_time ?? 'n/a' }}</p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $problem_application->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $problem_application->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $problem_application->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $problem_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $problem_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$problem_application->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>

                                                @php
                                                $tAduTotalElements = count($problem_application->tutor->tutor_education
                                                ?? []);
                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $problem_application->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $problem_application->Tutor->name }}

                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $problem_application->Tutor->phone ?? 'n/a' }} </p>

                                                        {{-- {{ Str::limit($tutor->tutor_education[$tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                                        --}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $problem_application->current_stage }}
                                            </td>
                                            <td>{{ $problem_application->condition }}</td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @php
                                                if ($problem_application->taken_by_id == Auth::user()->id) {
                                                $problem_my_stage = $problem_application->current_stage;
                                                }

                                                @endphp

                                                {{ $problem_my_stage ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $problem_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $problem_application->id }},'repostOffcanvas')"
                                                                    type="button" class="dropdown-item" {{-- data-bs-toggle="offcanvas"
                                                                        data-bs-target="#repostOffcanvas" --}}>
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $problem_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $problem_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="tab-pane fade" id="pills-repost" role="tabpanel" aria-labelledby="pills-repost-tab"
                        tabindex="0">
                        <!-- this is repost tab  -->



                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="delay">Delay</option>
                                    <option value="long time">Long Time</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>

                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Hot</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Tag</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default" />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" id="repostApplicationTable">
                                <table class="table bg-white shadow-none border border-1">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($repost_applications as $repost_application)
                                        @php
                                        $input = $repost_application->repost_date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $repost_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $repost_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $repost_a_date }}</p>
                                                    <p class="m-0 fw-light">{{ $repost_a_time }}</p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    {{-- <p class="m-0 text-nowrap">abdul</p> --}}
                                                    <a
                                                        href="{{ route('admin.job-details', $repost_application->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $repost_application->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $repost_application->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $repost_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $repost_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$repost_application->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>

                                                @php
                                                $repost_tAduTotalElements =
                                                count($repost_application->tutor->tutor_education ?? []);

                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        @if ($repost_application->tutor &&
                                                        $repost_application->tutor->id !== null)
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $repost_application->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $repost_application->Tutor->name }}
                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        @endif
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $repost_application->Tutor->phone ?? 'n/a' }} </p>

                                                        {{-- {{ Str::limit($tutor->tutor_education[$repost_tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                                        --}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $repost_application->current_stage }}
                                            </td>
                                            <td>{{ $repost_application->condition }}</td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @php
                                                if ($repost_application->taken_by_id == Auth::user()->id) {
                                                $repost_my_stage = $repost_application->current_stage;
                                                }

                                                @endphp

                                                {{ $repost_my_stage ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $repost_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $repost_application->id }},'closedOffcanvas')"
                                                                    type="button" class="dropdown-item" {{-- data-bs-toggle="offcanvas"
                                                                        data-bs-target="#repostOffcanvas" --}}>
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $repost_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $repost_applications->links() }}

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-closed" role="tabpanel" aria-labelledby="pills-closed-tab"
                        tabindex="0">
                        <!-- this is closed tab  -->

                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="delay">Delay</option>
                                    <option value="long time">Long Time</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>

                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Hot</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Tag</option>
                                    <option value="1">foo</option>
                                    <option value="2 ">ber</option>
                                </select>
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default" />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" id="closedApplicationTable">
                                <table class="table bg-white shadow-none border border-1">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Ot Stage</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($closed_applications ?? [] as $closed_application)
                                        @php
                                        $input = $closed_application->closed_date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $closed_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $closed_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $closed_a_date }}</p>
                                                    <p class="m-0 fw-light">{{ $closed_a_time }}</p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $closed_application->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $closed_application->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $closed_application->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $closed_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $closed_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$closed_application->job_offer->city->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>




                                            <td>
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    @if($closed_application->Tutor)
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $closed_application->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $closed_application->Tutor->name ?? '' }}
                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>

                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $closed_application->Tutor->phone ?? 'n/a' }}
                                                        </p>

                                                        @if(isset($closed_application->Tutor->tutor_education))
                                                        @php
                                                        $closed_tAduTotalElements =
                                                        count($closed_application->Tutor->tutor_education);
                                                        @endphp
                                                        <p>
                                                            {{ Str::limit($closed_application->Tutor->tutor_education[$closed_tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    @else
                                                    <!-- Handle the case where $closed_application->Tutor is not available -->
                                                    <p class="m-0 text-nowrap">Tutor information not available</p>
                                                    @endif
                                                </div>
                                            </td>


                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $closed_application->current_stage }}
                                            </td>
                                            <td>{{ $closed_application->condition }}</td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @php
                                                if ($closed_application->taken_by_id == Auth::user()->id) {
                                                $closed_my_stage = $closed_application->current_stage;
                                                }

                                                @endphp

                                                {{ $closed_my_stage ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $closed_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $closed_application->id }} ,'confirmOffcanvas')"
                                                                    type="button" class="dropdown-item" {{-- data-bs-toggle="offcanvas"
                                                                        data-bs-target="#closedOffcanvas" --}}>
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $closed_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $closed_applications->links() }}

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-confirm" role="tabpanel" aria-labelledby="pills-confirm-tab"
                        tabindex="0">
                        <!-- this is confirm tab  -->

                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascendingg</option>
                                    <option value="descending">Descending</option>
                                    <option value="By Date">By Date</option>
                                    <option value="By Name">By Name</option>
                                </select>


                                {{-- <input type="text" name="daterange" value="Today Confirm : {{$todayConfirm ?? ''}}"
                                    class="form-control shadow-none rounded" style="width: fit-content" /> --}}
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        placeholder="Search here..." />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" id="confirmApplicationTable">
                                <table class="table bg-white shadow-none border border-1" id="comfirmApplicationTable">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Confirm Date
                                            </th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Tutor</th>
                                            <th scope="col" class="text-nowrap">Job Status</th>
                                            <th scope="col" class="text-nowrap">Pay Date</th>
                                            <th scope="col" class="text-nowrap">Charge</th>
                                            <th scope="col" class="text-nowrap">Pay Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($confirm_applications as $confirm_application)
                                        @php
                                        $input = $confirm_application->confirm_date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $confirm_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $confirm_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <p class="m-0 text-nowrap">{{ $confirm_a_date }}</p>
                                            </th>

                                            <td> {{ date('d-m-Y', strtotime($confirm_application->tutoring_start_date)) ?? 'n/a' }}
                                            </td>

                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $confirm_application->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $confirm_application->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $confirm_application->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $confirm_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $confirm_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$confirm_application->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                $confirm_tAduTotalElements = $confirm_application->tutor ?
                                                count($confirm_application->tutor->tutor_education) : 0;
                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        @if ($confirm_application->Tutor)
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $confirm_application->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $confirm_application->Tutor->name ?? '' }}
                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $confirm_application->Tutor->phone ?? 'n/a' }}
                                                        </p>

                                                        {{-- Display tutor_education information --}}
                                                        @if (!empty($confirm_application->Tutor->tutor_education) &&
                                                        $confirm_tAduTotalElements > 0)
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ Str::limit($confirm_application->Tutor->tutor_education[$confirm_tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                                        </p>
                                                        @else
                                                        <p class="m-0 fw-light text-nowrap">N/A</p>
                                                        @endif
                                                        @else
                                                        <p class="m-0 fw-light text-nowrap">Tutor not found
                                                        </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @if ($confirm_application->jobOffer->is_active == 1)
                                                Live On
                                                @else
                                                Live Off
                                                @endif

                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ date('d/m/Y', strtotime($confirm_application->payment_date)) }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                @php
                                                // if ($confirm_application->taken_by_id == Auth::user()->id)
                                                $charge = $confirm_application->charge;

                                                @endphp

                                                {{ $charge ?? 'NA' }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">

                                                @if($confirm_application->payment_status == 'paid')

                                                <b style="color:green"> Completed </b>

                                                @elseif($confirm_application->payment_status == 'due')
                                                <b style="color: red"> due </b>
                                                @else
                                                pending
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $confirm_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="stageJobId({{ $confirm_application->id }})"
                                                                    type="button" class="dropdown-item"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#repostOffcanvas">
                                                                    Change Stage
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $confirm_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $confirm_application->id }}"
                                                                    onclick="stageJobId(this.id, 2,{{$charge}})"
                                                                    {{-- onclick="stageJobId({{ $closed_application->id }}
                                                                    ,'confirmOffcanvas')" --}} data-bs-toggle="modal"
                                                                    data-bs-target="#confirmTabPaymentModal">
                                                                    Payment
                                                                </button>
                                                            </li>

                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $confirm_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}



                    {{-- payment Pills --}}

                    <div class="tab-pane fade show" id="pills-payment" role="tabpanel"
                        aria-labelledby="pills-payment-tab" tabindex="0">
                        <!-- this is payment tab  -->
                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="option1 ">Option 1</option>
                                    <option value="option1 ">Option 1</option>
                                    <option value="option1 ">Option 1</option>
                                </select>
                                <button class="btn bg-white shadow-none"
                                    style="border: 1px solid #d7dfe9; font-weight: 400">
                                    Today
                                </button>
                                <button class="btn bg-white shadow-none"
                                    style="border: 1px solid #d7dfe9; font-weight: 400">
                                    Yesterday
                                </button>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        placeholder="Search here..." />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm bg-white shadow-none border border-1" id="payment_table">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col" class="text-nowrap">Tution ID</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col" class="text-nowrap">Tutor Name</th>
                                            <th scope="col" class="text-nowrap">Tutor ID</th>
                                            <th scope="col" class="text-nowrap">charge</th>
                                            <th scope="col" class="text-nowrap">Payment</th>
                                            <th scope="col">Due Amount</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>




                                        @foreach ($payment_applications as $payment_application)
                                        @php
                                        $input = $payment_application->panding_to;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $problem_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $problem_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp


                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $problem_a_date }}</p>
                                                    <p class="m-0 fw-light">{{ $problem_a_time ?? 'n/a' }}</p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $payment_application->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $payment_application->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $payment_application->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $payment_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $payment_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$payment_application->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>

                                                @php
                                                $tAduTotalElements = count($payment_application->tutor->tutor_education
                                                ?? []);
                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $payment_application->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $payment_application->Tutor->name }}

                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $payment_application->Tutor->phone ?? 'n/a' }} </p>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $payment_application->tutor_id }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b> {{ $payment_application->charge }} </b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $payment_application->received_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $payment_application->due_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">

                                                {{ $payment_application->payment_status ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $payment_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>

                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $payment_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $payment_application->id }}"
                                                                    onclick="stageJobId(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#paymentTabRefundModal">
                                                                    Refund
                                                                </button>
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $payment_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}


                    <div class="tab-pane fade show" id="pills-due" role="tabpanel" aria-labelledby="pills-due-tab"
                        tabindex="0">
                        <!-- this is due tab  -->
                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="option1 ">Option 1</option>
                                    <option value="option1 ">Option 1</option>
                                    <option value="option1 ">Option 1</option>
                                </select>
                                <button class="btn bg-white shadow-none"
                                    style="border: 1px solid #d7dfe9; font-weight: 400">
                                    Today
                                </button>
                                <button class="btn bg-white shadow-none"
                                    style="border: 1px solid #d7dfe9; font-weight: 400">
                                    Yesterday
                                </button>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        placeholder="Search here..." />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm bg-white shadow-none border border-1" id="due_table">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Date
                                            </th>
                                            <th scope="col" class="text-nowrap">Tution ID</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col" class="text-nowrap">Tutor Name</th>
                                            <th scope="col" class="text-nowrap">Due Pay Date</th>
                                            <th scope="col" class="text-nowrap">Tutor ID</th>
                                            <th scope="col" class="text-nowrap">charge</th>
                                            <th scope="col" class="text-nowrap">payment</th>
                                            <th scope="col">Due Amount</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        {{-- due table  --}}


                                        @foreach ($due_applications as $due_application)
                                        @php
                                        $input = $due_application->due_payment_date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $problem_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $problem_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp


                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $problem_a_date }}</p>
                                                    <p class="m-0 fw-light">{{ $problem_a_time ?? 'n/a' }}</p>
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    <a
                                                        href="{{ route('admin.job-details', $due_application->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $due_application->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $due_application->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $due_application->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $due_application->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$due_application->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>

                                                @php
                                                $tAduTotalElements = count($due_application->tutor->tutor_education ??
                                                []);
                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $due_application->Tutor->id) }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $due_application->Tutor->name }}

                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $due_application->Tutor->phone ?? 'n/a' }} </p>

                                                        {{-- {{ Str::limit($tutor->tutor_education[$tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                                        --}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ \Carbon\Carbon::parse($due_application->due_payment_date)->format('Y-m-d') }}

                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $due_application->tutor_id }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b> {{ $due_application->charge }} </b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $due_application->received_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $due_application->due_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">

                                                {{ $due_application->payment_status ?? 'NA' }}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $due_application->id]) }}">Manage</a>
                                                            </li>
                                                            <li>
                                                                {{-- <button
                                                                        onclick="stageJobId({{ $due_application->id }},'repostOffcanvas')"
                                                                type="button" class="dropdown-item"
                                                                >
                                                                Change Stage
                                                                </button> --}}
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $due_application->id }}"
                                                                    onclick="btnNote(this.id)" data-bs-toggle="modal"
                                                                    data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>

                                                            {{-- <li>
                                                                    <button type="button" class="dropdown-item"
                                                                    id="{{ $confirm_application->id }}"
                                                            onclick="stageJobId(this.id, 2,{{$charge}})"



                                                            data-bs-toggle="modal"
                                                            data-bs-target="#confirmTabPaymentModal">
                                                            Payment
                                                            </button>
                                                            </li> --}}

                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $due_application->id }}"
                                                                    onclick="stageJobId(this.id, 2,4,{{$due_application->due_amount}})"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#dueTabPaymentModal">
                                                                    Payment
                                                                </button>
                                                            </li>
                                                            {{-- <li>
                                                                    <button type="button" class="dropdown-item"
                                                                    id="{{ $due_application->id }}"
                                                            onclick="stageJobId(this.id)"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#paymentTabRefundModal">
                                                            Refund
                                                            </button>
                                                            </li> --}}
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach




                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $due_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Refund-Pills --}}
                    <div class="tab-pane fade show" id="pills-refund" role="tabpanel" aria-labelledby="pills-refund-tab"
                        tabindex="0">
                        <!-- this is due tab  -->
                        <div class="my-5">
                            <div
                                class="d-flex justify-content-end gap-3 align-items-center mb-4 flex-column flex-md-row">
                                <select style="width: fit-content" class="form-select shadow-none rounded"
                                    aria-label="Default select example">
                                    <option selected>Ascending</option>
                                    <option value="option1 ">Option 1</option>
                                    <option value="option1 ">Option 1</option>
                                    <option value="option1 ">Option 1</option>
                                </select>
                                <button class="btn bg-white shadow-none"
                                    style="border: 1px solid #d7dfe9; font-weight: 400">
                                    Today
                                </button>
                                <button class="btn bg-white shadow-none"
                                    style="border: 1px solid #d7dfe9; font-weight: 400">
                                    Yesterday
                                </button>
                                <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                                    class="form-control shadow-none rounded" style="width: fit-content" />
                                <div class="input-group" style="width: fit-content">
                                    <input type="text" class="form-control shadow-none rounded-start"
                                        placeholder="Search here..." />
                                    <button class="input-group-text rounded-end" id="inputGroup-sizing-default">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm bg-white shadow-none border border-1" id="due_table">
                                    <thead>
                                        <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                                            <th scope="col">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                Pending to Date
                                            </th>
                                            <th scope="col" class="text-nowrap">Tution ID</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Location</th>
                                            <th scope="col" class="text-nowrap">Tutor Name</th>
                                            <th scope="col" class="text-nowrap">Tutor ID</th>
                                            <th scope="col" class="text-nowrap">charge</th>
                                            <th scope="col" class="text-nowrap">payment</th>
                                            <th scope="col">Refund Amount</th>
                                            <th scope="col" class="text-nowrap">My Stage</th>
                                            <th scope="col" class="text-nowrap">Refund Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        {{-- due table  --}}


                                        @foreach ($refund_applications as $refund)
                                        @php
                                        $input = $refund->refund_date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $problem_a_date = Carbon\Carbon::parse($input)->format($format1);
                                        $problem_a_time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp


                                        <tr style="border-bottom: 1px solid #dee2e6">
                                            <th scope="row" class="d-flex align-items-center gap-4 border-0">
                                                <input class="form-check-input me-2" type="checkbox" value="" />
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">{{ $problem_a_date }}</p>
                                                    {{-- <p class="m-0 fw-light">{{ $problem_a_time ?? 'n/a' }}</p> --}}
                                                </div>
                                            </th>


                                            <td>
                                                <div class="fw-normal">
                                                    <a href="{{ route('admin.job-details', $refund->jobOffer->id) }}">

                                                        <p class="m-0 fw-light">
                                                            ID:{{ $refund->jobOffer->id }}</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $refund->job_offer->course->name ?? 'n\a' }}
                                                    </p>
                                                    <p class="m-0 fw-light text-nowrap">
                                                        {{ $refund->job_offer->category->name ?? 'n\a' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-normal">
                                                    <p class="m-0 text-nowrap">
                                                        {{ $refund->job_offer->location->name ?? 'n/a' }}
                                                    </p>
                                                    <p class="m-0 fw-light">
                                                        {{ @$refund->job_offer->city->name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>

                                                @php
                                                $tAduTotalElements = count($refund->tutor->tutor_education ?? []);
                                                @endphp

                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img height="45" width="45" class="rounded-3"
                                                        src="/images/avatar.svg" alt="" />
                                                    <div class="fw-semibold">
                                                        <a
                                                            href="{{ route('admin.tutor.tutorshow', $refund->Tutor->id ?? '') }}">
                                                            <p class="m-0 text-nowrap">
                                                                {{ $refund->Tutor->name ?? ''}}

                                                                <span>
                                                                    <i class="bi bi-check-circle-fill text-info"></i>
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <p class="m-0 fw-light text-nowrap">
                                                            {{ $refund->Tutor->phone ?? 'n/a' }} </p>


                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                {{ $refund->tutor_id }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b> {{ $refund->charge }} </b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $refund->received_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">
                                                <b>{{ $refund->refund_amount }}</b>
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">

                                                {{ $refund->payment_status ?? 'NA' }}
                                            </td>
                                            <td class="fw-bold text-info" style="vertical-align: middle">

                                                <button type="button" class="btn @if($refund->refund_status == 0)
                                                        btn-danger
                                                    @elseif($refund->refund_status == 1 && $refund->refund_complete_amount == $refund->refund_amount)
                                                        btn-primary
                                                    @elseif($refund->refund_status == 1 && $refund->refund_complete_amount != $refund->refund_amount)
                                                        btn-warning
                                                    @endif " data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal_{{$refund->id}}">
                                                    @if($refund->refund_status == 0 )
                                                    Unpaid
                                                    @elseif($refund->refund_status == 1 &&
                                                    $refund->refund_complete_amount == $refund->refund_amount)
                                                    Paid
                                                    @elseif($refund->refund_status == 1 &&
                                                    $refund->refund_complete_amount != $refund->refund_amount)
                                                    Not Full Paid
                                                    @endif
                                                </button>

                                                <form id="refundCompleteForm_{{$refund->id}}" method="post">
                                                    @csrf

                                                    <div class="modal fade" id="exampleModal_{{$refund->id}}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Refund Complete Form</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="refund_id"
                                                                        value="{{$refund->id}}">
                                                                    <div class="mb-3">
                                                                        <label for="exampleFormControlInput2"
                                                                            class="form-label">Transction Id</label>
                                                                        <input name="trx_id" value="" type="text"
                                                                            class="form-control"
                                                                            id="exampleFormControlInput2"
                                                                            placeholder="Enter Paid Amount">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Paid Amount</label>
                                                                        <input name="refund_payment"
                                                                            value="{{ old('refund_payment', $refund->refund_payment ?? 'n/a' )}}"
                                                                            type="number" class="form-control"
                                                                            id="exampleFormControlInput1"
                                                                            placeholder="Enter Paid Amount">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Refund Amount</label>
                                                                        <input name="refund_coin"
                                                                            value="{{ old('refund_coin', $refund->refund_coin ?? 'n/a' )}}"
                                                                            type="number" class="form-control"
                                                                            id="exampleFormControlInput1"
                                                                            placeholder="Enter Paid Amount">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="exampleFormControlTextarea1"
                                                                            class="form-label">Note</label>
                                                                        <textarea class="form-control"
                                                                            id="exampleFormControlTextarea1"
                                                                            name="refund_complete_note" rows="3"
                                                                            placeholder="Enter Note">{{$refund->refund_complete_note ?? ''}} </textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    {{-- @if (Auth::user()->role_id == 1)
                                                                        <button type="button" class="btn btn-primary" onclick="submitRefundCompleteForm({{$refund->id}},
                                                                    this)">Save changes</button>
                                                                    @endif --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <script>
                                                    function submitRefundCompleteForm(refundId, button) {
                                                        var form = document.getElementById('refundCompleteForm_' +
                                                            refundId);
                                                        var formData = new FormData(form);

                                                        // Disable the button to prevent multiple submissions
                                                        button.disabled = true;

                                                        $.ajax({
                                                            url: '{{ route("admin.taken_offer.refundPaymentComplete") }}',
                                                            method: 'POST',
                                                            data: formData,
                                                            processData: false,
                                                            contentType: false,
                                                            success: function (response) {
                                                                Swal.fire({
                                                                    position: "top-end",
                                                                    icon: "success",
                                                                    title: "Refund Complete",
                                                                    showConfirmButton: false,
                                                                    timer: 1000,
                                                                });
                                                                location.reload();
                                                            },
                                                            error: function (xhr, status, error) {
                                                                console.error(xhr.responseText);
                                                                // Re-enable the button if there's an error
                                                                button.disabled = false;
                                                            }
                                                        });
                                                    }

                                                </script>



                                            </td>
                                            <td style="vertical-align: middle">
                                                <div class="btn-group" id="stageButton">
                                                    <button type="button" class="btn btn-secondary shadow-none"
                                                        onclick="toggleButtonClass(this)" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false"
                                                        style="background-color: green; border: none;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                        <div class="rounded-2 text-white-on-hover"
                                                            style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="btn dropdown-item"
                                                                    href="{{ route('admin.taken_offer.manage', ['application' => $refund->id]) }}">Manage</a>
                                                            </li>
                                                            <li>

                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#followupModal">
                                                                    Follow Up
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mustdoModal">
                                                                    Must Do (Only Admin)
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonex">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item window-open-btn"
                                                                    data-window-target="#windowonexx">
                                                                    Stage Line
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item"
                                                                    id="{{ $refund->id }}" onclick="btnNote(this.id)"
                                                                    data-bs-toggle="modal" data-bs-target="#noteModal">
                                                                    Note
                                                                </button>
                                                            </li>

                                                            {{-- <li>
                                                                    <button type="button" class="dropdown-item"
                                                                    id="{{ $confirm_application->id }}"
                                                            onclick="stageJobId(this.id, 2,{{$charge}})"



                                                            data-bs-toggle="modal"
                                                            data-bs-target="#confirmTabPaymentModal">
                                                            Payment
                                                            </button>
                                                            </li> --}}

                                                            {{-- <li>
                                                                    <button type="button" class="dropdown-item"

                                                                    id="{{ $refund->id }}"
                                                            onclick="stageJobId(this.id, 2,4,{{$refund->due_amount}})"

                                                            data-bs-toggle="modal" data-bs-target="#dueTabPaymentModal">
                                                            Payment
                                                            </button>
                                                            </li> --}}
                                                        </div>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach




                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    {{ $due_applications->links() }}

                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <!-- main content section ends here -->
                        <!-- all the modles are here -->

                        <!-- follow up model -->
                        <div class="modal fade" id="followupModal" tabindex="-1" aria-labelledby="followupModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                                <div class="modal-content p-2">
                                    <div class="modal-header">
                                        <div clas="d-flex justify-content-start">
                                            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="bg-light p-3 rounded-2">
                                            <div class="form-check form-switch mb-4">
                                                <input class="form-check-input" type="checkbox" id="fup" />
                                                <label class="form-check-label fw-500 fs-14" for="fup">Follow-Up</label>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-3 px-2 py-2"
                                                style="font-size: 15px; background-color: #f0f0f0">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value="" id="new" />
                                                    <label class="form-check-label fw-500 fs-14" for="new">
                                                        New
                                                    </label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="oneday" />
                                                    <label class="form-check-label fw-500 fs-14" for="oneday">
                                                        1 Day Before
                                                    </label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="twoday" />
                                                    <label class="form-check-label fw-500 fs-14" for="twoday">
                                                        2 Day Before
                                                    </label>
                                                </div>
                                                <input type="date"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    style="width: fit-content" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary shadow-lg"
                                            data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- must do model -->
                        <div class="modal fade" id="mustdoModal" tabindex="-1" aria-labelledby="mustdoModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                                <div class="modal-content p-2">
                                    <div class="modal-header">
                                        <div clas="d-flex justify-content-start">
                                            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <p class="mb-1 text-dark">
                                                <span class="text-muted">Current Stage : </span>Assign
                                            </p>
                                            <p class="text-muted" style="font-size: 12px">
                                                Form : Sep 20, 2023
                                            </p>
                                        </div>
                                        <div class="bg-light p-3 rounded-2">
                                            <div class="mb-4">
                                                <label for="instructions " class="form-label fw-500 fs-14">Instructions
                                                </label>
                                                <textarea class="form-control shadow-none rounded-2" id="instructions "
                                                    rows="3" placeholder="Write your instructions here..."></textarea>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-3 px-2 py-2"
                                                style="font-size: 15px; background-color: #f0f0f0">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="new2" />
                                                    <label class="form-check-label fw-500 fs-14" for="new2">
                                                        New
                                                    </label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="nextday" />
                                                    <label class="form-check-label fw-500 fs-14" for="nextday">
                                                        Next Day
                                                    </label>
                                                </div>

                                                <input type="date"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    style="width: 300px" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary shadow-lg"
                                            data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                                                <input type="hidden" name="note_application_id"
                                                    id="note_application_id">
                                                <div class="mb-3">
                                                    <label for="notet" class="form-label fw-500 fs-14">Note</label>
                                                    <textarea name="application_note"
                                                        placeholder="Write your note here..."
                                                        class="form-control shadow-none rounded-2" id="application_note"
                                                        rows="4"></textarea>

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
                        <!-- Modal for change stage(Trail) -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="trailOffcanvas"
                            aria-labelledby="trailOffcanvasRightLabel" style="z-index: 3000; width: 600px">
                            <div class="offcanvas-header">
                                <h5 id="trailOffcanvasRightLabel">Change Stage</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div>

                                    <form action="{{ route('admin.application.stage.trial') }}" method="post"
                                        id="trialStageChangeForm">

                                        @csrf

                                        <input type="hidden" name="application_id" id="trial_application_id">


                                        <div>
                                            <p class="mb-1 text-dark">
                                                <span class="text-muted">Current Stage : </span>Meeting
                                            </p>
                                            <p class="text-muted" style="font-size: 12px">
                                                Form : Sep 20, 2023
                                            </p>
                                        </div>
                                        <div>
                                            <p class="mb-1 fw-500 fs-14">Move To</p>
                                            <select name="stage" id="trial_stage"
                                                class="form-select shadow-none rounded-2"
                                                onchange="stageChange(this.id, true)">
                                                <option value="trial">trial</option>
                                                <option value="meet">meet</option>
                                                <option value="waiting">waiting</option>
                                                <option value="confirm">confirm</option>
                                                <option value="repost">repost</option>
                                                <option value="closed">closed</option>
                                                <option value="problem">problem</option>
                                            </select>

                                            <span class="text-danger error-text stage_error"></span>


                                        </div>
                                        <div class="bg-light p-3 rounded-2 mt-4">
                                            <div class="d-flex gap-4 justify-content-start mb-2">
                                                <div class="mb-3 w-50">
                                                    <label for="datef" class="form-label fw-500"
                                                        style="font-size: 14px">1st
                                                        Trail Date</label>
                                                    <input type="date" name="trial_date_1st"
                                                        class="form-control shadow-none rounded-2 form-control-sm"
                                                        id="trial_date_1st" />

                                                    <span class="text-danger error-text trial_date_1st_error"></span>

                                                </div>
                                                <div class="mb-3 w-50">
                                                    <label for="timef" class="form-label fw-500"
                                                        style="font-size: 14px">Time
                                                    </label>
                                                    <input type="time" name="trial_time_1st"
                                                        class="form-control shadow-none rounded-2 form-control-sm"
                                                        id="trial_time_1st" />


                                                    <span class="text-danger error-text trial_time_1st_error"></span>

                                                </div>
                                            </div>
                                            <div class="d-flex gap-4 justify-content-end mb-2">
                                                <div>
                                                    <p class="mb-1 text-end fw-500" style="font-size: 14px">
                                                        Notify
                                                    </p>
                                                    <select class="form-select shadow-none rounded-2 form-select-sm">
                                                        <option selected>1 Day Before</option>
                                                        <option value="3">3 Hour Before</option>
                                                        <option value="6">6 Day Before</option>
                                                        <option value="12">12 Day Before</option>

                                                        <option value="2">2 Day Before</option>
                                                    </select>
                                                    <div class="dropdown">
                                                        <p class="text-end" type="button" id="cno"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            style="font-size: 12px">
                                                            Custom
                                                        </p>
                                                        <ul class="dropdown-menu p-0" aria-labelledby="cno"
                                                            style="border: none; width: 300px">
                                                            <div class="p-4 rounded-3"
                                                                style="border: 1px solid #d7dfe9">
                                                                <input type="number"
                                                                    class="form-control shadow-none rounded-2 form-control-md mb-3"
                                                                    placeholder="Enter Number" />
                                                                <select
                                                                    class="form-select shadow-none rounded-2 form-select-md">
                                                                    <option>Day</option>
                                                                    <option>Hour</option>
                                                                </select>
                                                                <div
                                                                    class="d-flex justify-content-end align-items-center gap-3">
                                                                    <button
                                                                        class="btn btn-primary btn-sm px-2 py-1 mt-3">
                                                                        Confirm
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-4 justify-content-start mb-2">
                                                <div class="mb-3 w-50">
                                                    <label for="datef" class="form-label fw-500"
                                                        style="font-size: 14px">2nd
                                                        Trail Date</label>
                                                    <input type="date" name="trial_date_2nd"
                                                        class="form-control shadow-none rounded-2 form-control-sm"
                                                        id="trial_date_2nd" />

                                                    <span class="text-danger error-text trial_date_2nd_error"></span>

                                                </div>
                                                <div class="mb-3 w-50">
                                                    <label for="timef" class="form-label fw-500"
                                                        style="font-size: 14px">Time
                                                    </label>
                                                    <input type="time" name="trial_time_2nd"
                                                        class="form-control shadow-none rounded-2 form-control-sm"
                                                        id="trial_time_2nd" />

                                                    <span class="text-danger error-text trial_time_2nd_error"></span>

                                                </div>
                                            </div>
                                            <div class="d-flex gap-4 justify-content-end mb-2">
                                                <div>
                                                    <p class="mb-1 text-end fw-500" style="font-size: 14px">
                                                        Notify
                                                    </p>
                                                    <select class="form-select shadow-none rounded-2 form-select-sm">
                                                        <option selected>1 Day Before</option>
                                                        <option value="3">3 Hour Before</option>
                                                        <option value="6">6 Day Before</option>
                                                        <option value="12">12 Day Before</option>

                                                        <option value="2">2 Day Before</option>
                                                    </select>
                                                    <div class="dropdown">
                                                        <p class="text-end" type="button" id="cno"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            style="font-size: 12px">
                                                            Custom
                                                        </p>
                                                        <ul class="dropdown-menu p-0" aria-labelledby="cno"
                                                            style="border: none; width: 300px">
                                                            <div class="p-4 rounded-3"
                                                                style="border: 1px solid #d7dfe9">
                                                                <input type="number"
                                                                    class="form-control shadow-none rounded-2 form-control-md mb-3"
                                                                    placeholder="Enter Number" />
                                                                <select
                                                                    class="form-select shadow-none rounded-2 form-select-md">
                                                                    <option>Day</option>
                                                                    <option>Hour</option>
                                                                </select>
                                                                <div
                                                                    class="d-flex justify-content-end align-items-center gap-3">
                                                                    <button
                                                                        class="btn btn-primary btn-sm px-2 py-1 mt-3">
                                                                        Confirm
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-4 justify-content-end mb-2">
                                                <button class="btn btn-outline-info px-2 py-1">
                                                    Add New Trail
                                                </button>
                                            </div>

                                            <div class="mb-3">
                                                <label for="await" class="form-label fw-500 fs-14">About Trail
                                                    Class</label>
                                                <textarea name="trial_about" class="form-control shadow-none rounded-2"
                                                    id="trial_about" rows="3"
                                                    placeholder="Write about trail class here..."></textarea>
                                            </div>
                                            <span class="text-danger error-text trial_about_error"></span>

                                        </div>
                                        <div>
                                            <div class="d-flex gap-4 justify-content-start my-4">
                                                <div class="w-50">
                                                    <p class="mb-1 fw-500 fs-14">Condition</p>
                                                    <select name="condition" class="form-select shadow-none rounded-2">
                                                        <option value="">Select Condition</option>
                                                        <option value="hot">Hot</option>
                                                        <option value="cold">Cold</option>
                                                        <option value="average">Average</option>
                                                    </select>
                                                    <span class="text-danger error-text condition_error"></span>
                                                </div>
                                                <div class="w-50">
                                                    <p class="mb-1 fw-500 fs-14">Tag</p>
                                                    <select name="tag" class="form-select shadow-none rounded-2">
                                                        <option value="">Select Tag</option>
                                                        <option value="problemetic_parent">Problemetic Parent</option>
                                                        <option value="2">Another 1</option>
                                                        <option value="3">Another 2</option>
                                                    </select>
                                                    <span class="text-danger error-text tag_error"></span>

                                                </div>
                                            </div>
                                            <div class="bg-light p-3 rounded-2 mb-4">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="fup3" />
                                                    <label class="form-check-label fw-500 fs-14"
                                                        for="fup3">Follow-Up</label>
                                                </div>
                                            </div>

                                            <div class="bg-light p-3 rounded-2">
                                                <div class="form-check form-switch mb-4">
                                                    <input class="form-check-input" type="checkbox" id="fup2" />
                                                    <label class="form-check-label fw-500 fs-14"
                                                        for="fup2">Follow-Up</label>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center gap-3 px-2 py-2"
                                                    style="font-size: 15px; background-color: #f0f0f0">
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="new2" />
                                                        <label class="form-check-label fw-500 fs-14" for="new2">
                                                            New
                                                        </label>
                                                    </div>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="oneday2" />
                                                        <label class="form-check-label fw-500 fs-14" for="oneday2">
                                                            1 Day Before
                                                        </label>
                                                    </div>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="twoday2" />
                                                        <label class="form-check-label fw-500 fs-14" for="twoday2">
                                                            2 Day Before
                                                        </label>
                                                    </div>
                                                    <input type="date" name="trial_follow_up" id="trial_follow_up"
                                                        class="form-control shadow-none rounded-2 form-control-sm"
                                                        style="width: fit-content" />

                                                </div>
                                                <span class="text-danger error-text trial_follow_up_error"></span>

                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer p-4">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>

                            </form>
                        </div>
                    </div>
                    <!-- Modal for change stage(problem) -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="problemOffcanvas"
                        aria-labelledby="problemOffcanvasRightLabel" style="z-index: 3000; width: 600px">
                        <div class="offcanvas-header">
                            <h5 id="problemOffcanvasRightLabel">Change Stage</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                <div>

                                    <form action="{{ route('admin.application.stage.problem') }}" method="post"
                                        id="problemStageChangeForm">

                                        @csrf


                                        <input type="hidden" name="problem_application_id" id="problem_application_id">
                                        <p class="mb-1 text-dark">
                                            <span class="text-muted">Current Stage : </span>Trail
                                        </p>
                                        <p class="text-muted" style="font-size: 12px">
                                            Form : Sep 20, 2023
                                        </p>
                                </div>
                                <div>
                                    <p class="mb-1 fw-500 fs-14">Move To</p>
                                    <select name="stage" id="problem_stage" class="form-select shadow-none rounded-2"
                                        onchange="stageChange(this.id, true)">
                                        <option value="problem">problem</option>
                                        <option value="trial">trial</option>
                                        <option value="waiting">waiting</option>
                                        <option value="meet">meet</option>
                                        <option value="confirm">confirm</option>
                                        <option value="repost">repost</option>
                                        <option value="closed">closed</option>
                                    </select>
                                    <span class="text-danger error-text stage_error"></span>

                                </div>
                                <div class="bg-light p-3 rounded-2 mt-4">
                                    <div class="d-flex gap-4 justify-content-start">
                                        <div class="mb-3 w-50">
                                            <label for="datef" class="form-label fw-500" style="font-size: 14px">Pending
                                                to</label>
                                            <input name="panding_to" id="panding_to" type="date"
                                                class="form-control shadow-none rounded-2 form-control-sm" id="datef" />
                                            <span class="text-danger error-text panding_to_error"></span>

                                        </div>
                                        <div class="w-50">
                                            <div>
                                                <p class="text-end fw-500" style="font-size: 14px; margin-bottom: 10px">
                                                    Notify
                                                </p>
                                                <select class="form-select shadow-none rounded-2 form-select-sm">
                                                    <option selected>1 Day Before</option>
                                                    <option value="3">3 Hour Before</option>
                                                    <option value="6">6 Day Before</option>
                                                    <option value="12">12 Day Before</option>

                                                    <option value="2">2 Day Before</option>
                                                </select>
                                                <div class="dropdown">
                                                    <p class="text-end" type="button" id="cno" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="font-size: 12px">
                                                        Custom
                                                    </p>
                                                    <ul class="dropdown-menu p-0" aria-labelledby="cno"
                                                        style="border: none; width: 300px">
                                                        <div class="p-4 rounded-3" style="border: 1px solid #d7dfe9">
                                                            <input type="number"
                                                                class="form-control shadow-none rounded-2 form-control-md mb-3"
                                                                placeholder="Enter Number" />
                                                            <select
                                                                class="form-select shadow-none rounded-2 form-select-md">
                                                                <option>Day</option>
                                                                <option>Hour</option>
                                                            </select>
                                                            <div
                                                                class="d-flex justify-content-end align-items-center gap-3">
                                                                <button class="btn btn-primary btn-sm px-2 py-1 mt-3">
                                                                    Confirm
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="await" class="form-label fw-500 fs-14">
                                            Details about problems
                                        </label>
                                        <textarea name="about_problem" id="about_problem"
                                            class="form-control shadow-none rounded-2" id="await" rows="3"
                                            placeholder="Write about problems here..."></textarea>
                                    </div>
                                    <span class="text-danger error-text about_problem_error"></span>

                                </div>
                                <div>
                                    <div class="d-flex gap-4 justify-content-start my-4">
                                        <div class="w-50">
                                            <p class="mb-1 fw-500 fs-14">Condition</p>
                                            <select name="condition" id="problem_condition"
                                                class="form-select shadow-none rounded-2">
                                                <option selected>Hot</option>
                                                <option value="2">Another 1</option>
                                                <option value="3">Another 2</option>
                                            </select>
                                            <span class="text-danger error-text condition_error"></span>

                                        </div>
                                        <div class="w-50">
                                            <p class="mb-1 fw-500 fs-14">Tag</p>
                                            <select name="tag" id="problem_tag"
                                                class="form-select shadow-none rounded-2">
                                                <option selected>Problemetic Parent</option>
                                                <option value="2">Another 1</option>
                                                <option value="3">Another 2</option>
                                            </select>
                                            <span class="text-danger error-text tag_error"></span>

                                        </div>
                                    </div>
                                    <div class="bg-light p-3 rounded-2 mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="fup34" />
                                            <label class="form-check-label fw-500 fs-14" for="fup34">Follow-Up</label>
                                        </div>
                                    </div>

                                    <div class="bg-light p-3 rounded-2">
                                        <div class="form-check form-switch mb-4">
                                            <input class="form-check-input" type="checkbox" id="fup24" />
                                            <label class="form-check-label fw-500 fs-14" for="fup24">Follow-Up</label>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center gap-3 px-2 py-2"
                                            style="font-size: 15px; background-color: #f0f0f0">
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" value="" id="new28" />
                                                <label class="form-check-label fw-500 fs-14" for="new28">
                                                    New
                                                </label>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="oneday28" />
                                                <label class="form-check-label fw-500 fs-14" for="oneday28">
                                                    1 Day Before
                                                </label>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="twoday28" />
                                                <label class="form-check-label fw-500 fs-14" for="twoday28">
                                                    2 Day Before
                                                </label>
                                            </div>
                                            <input name="problem_follow_up" id="problem_follow_up" type="date"
                                                class="form-control shadow-none rounded-2 form-control-sm"
                                                style="width: fit-content" />
                                            <span class="text-danger error-text problem_follow_up_error"></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-4">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>

                        </form>
                    </div>
                    <!-- Modal for change stage(closed) -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="closedOffcanvas"
                        aria-labelledby="closedOffcanvasRightLabel" style="z-index: 3000; width: 600px">
                        <div class="offcanvas-header">
                            <h5 id="closedOffcanvasRightLabel">Change Stage</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>

                                <form action="{{ route('admin.application.stage.closed') }}" method="post"
                                    id="closedStageChangeForm">

                                    @csrf


                                    <input type="hidden" name="closed_application_id" id="closed_application_id">

                                    <div>
                                        <p class="mb-1 text-dark">
                                            <span class="text-muted">Current Stage : </span>Problem
                                        </p>
                                        <p class="text-muted" style="font-size: 12px">
                                            Form : Sep 20, 2023
                                        </p>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-500 fs-14">Move To</p>

                                        <select name="stage" id="closed_stage" class="form-select shadow-none rounded-2"
                                            onchange="stageChange(this.id, true)">
                                            <option value="closed">closed</option>
                                            <option value="repost">repost</option>
                                            <option value="problem">problem</option>
                                            <option value="waiting">waiting</option>
                                            <option value="meet">meet</option>
                                            <option value="trial">trial</option>
                                            <option value="confirm">confirm</option>

                                        </select>
                                        <span class="text-danger error-text stage_error"></span>
                                    </div>
                                    <div class="bg-light p-3 rounded-2 mt-4">
                                        <div class="d-flex gap-4 justify-content-start mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="tpro" />
                                                <label class="form-check-label fw-500 fs-14" for="tpro">
                                                    Confirm Others
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="gpro" />
                                                <label class="form-check-label fw-500 fs-14" for="gpro">
                                                    Guardian Issue
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="await" class="form-label fw-500 fs-14">
                                                Details about closed
                                            </label>
                                            <textarea name="closed_about" id="closed_about"
                                                class="form-control shadow-none rounded-2" id="await" rows="3"
                                                placeholder="Write about closed here..."></textarea>
                                            <span class="text-danger error-text closed_about_error"></span>

                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer p-4">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                        </form>
                    </div>
                    <!-- Modal for change stage(repost) -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="repostOffcanvas"
                        aria-labelledby="repostOffcanvasRightLabel" style="z-index: 3000; width: 600px">
                        <div class="offcanvas-header">
                            <h5 id="repostOffcanvasRightLabel">Change Stage</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>

                                <form action="{{ route('admin.application.stage.repost') }}" method="post"
                                    id="repostStageChangeForm">

                                    @csrf


                                    <input type="hidden" name="repost_application_id" id="repost_application_id">
                                    <div>
                                        <p class="mb-1 text-dark">
                                            <span class="text-muted">Current Stage : </span>Problem
                                        </p>
                                        <p class="text-muted" style="font-size: 12px">
                                            Form : Sep 20, 2023
                                        </p>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-500 fs-14">Move To</p>
                                        <select name="stage" id="repost_stage" class="form-select shadow-none rounded-2"
                                            onchange="stageChange(this.id, true)">
                                            <option value="repost">repost</option>
                                            <option value="problem">problem</option>
                                            <option value="waiting">waiting</option>
                                            <option value="meet">meet</option>
                                            <option value="trial">trial</option>
                                            <option value="confirm">confirm</option>
                                            <option value="closed">closed</option>
                                        </select>
                                        <span class="text-danger error-text stage_error"></span>
                                    </div>
                                    <div class="bg-light p-3 rounded-2 mt-4">
                                        <div class="d-flex gap-4 justify-content-start mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="tpro45" />
                                                <label class="form-check-label fw-500 fs-14" for="tpro45">
                                                    Tutor Problem
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="gpro45" />
                                                <label class="form-check-label fw-500 fs-14" for="gpro45">
                                                    Guardian Problem
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="await" class="form-label fw-500 fs-14">
                                                Details about repost
                                            </label>
                                            <textarea name="repost_about" id="repost_about"
                                                class="form-control shadow-none rounded-2" id="await" rows="3"
                                                placeholder="Write about repost here..."></textarea>

                                            <span class="text-danger error-text repost_about_error"></span>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer p-4">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                        </form>
                    </div>
                    <!-- Modal waiting for change stage -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="waitingOffcanvas"
                        aria-labelledby="changeStageOffcanvasRightLabel" style="z-index: 3000; width: 600px">
                        <div class="offcanvas-header">
                            <h5 id="changeStageOffcanvasRightLabel">Change Stage</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                <div>
                                    <p class="mb-1 text-dark">
                                        <span class="text-muted">Current Stage : </span>Assign
                                    </p>
                                    <p class="text-muted" style="font-size: 12px">
                                        Form : Sep 20, 2023
                                    </p>
                                </div>
                                <div>
                                    <form action="{{ route('admin.application.stage.change') }}" method="post"
                                        id="applicationStageChangeForm">
                                        @csrf
                                        <input type="hidden" name="application_id" id="waiting_application_id">

                                        <p class="mb-1 fw-500 fs-14" style="font-size: 14px">
                                            Move To
                                        </p>



                                        <select name="stage" id="waiting_stage"
                                            class="form-select shadow-none rounded-2"
                                            onchange="stageChange(this.id, true)">
                                            {{-- <option value= "assign">assign</option> --}}
                                            <option value="waiting">waiting</option>
                                            <option value="meet">meet</option>
                                            <option value="trial">trial</option>
                                            <option value="confirm">confirm</option>
                                            <option value="repost">repost</option>
                                            <option value="closed">closed</option>
                                            <option value="problem">problem</option>
                                        </select>

                                        <span class="text-danger error-text stage_error"></span>

                                </div>


                                <div>

                                    <div class="bg-light p-3 rounded-2 mt-4" id="assignStageBody">


                                        <div class="d-flex gap-4 justify-content-start mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="delay" value=""
                                                    id="dly" />
                                                <label class="form-check-label fw-500 fs-14" for="dly">
                                                    Delay
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" name="long"
                                                    id="ltime" />
                                                <label class="form-check-label fw-500 fs-14" for="ltime">
                                                    Long Time
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 justify-content-start mb-2">
                                            <div class="mb-3 w-50">
                                                <label for="datef" class="form-label fw-500"
                                                    style="font-size: 14px">Waiting
                                                    Date</label>
                                                <input name="waiting_date" id="waiting_date" type="date"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    id="datef" />
                                                <span class="text-danger error-text waiting_date_error"></span>

                                            </div>
                                            <div class="mb-3 w-50">
                                                <label for="timef" class="form-label fw-500"
                                                    style="font-size: 14px">Time
                                                </label>
                                                <input name="waiting_time" id="waiting_time" type="time"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    id="timef" />
                                                <span class="text-danger error-text waiting_time_error"></span>

                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 justify-content-end mb-2">
                                            <div>
                                                <p class="mb-1 text-end fw-500" style="font-size: 14px">
                                                    Notify
                                                </p>
                                                <select name="notify"
                                                    class="form-select shadow-none rounded-2 form-select-sm">
                                                    <option selected>1 Day Before</option>
                                                    <option value="3">3 Hour Before</option>
                                                    <option value="6">6 Day Before</option>
                                                    <option value="12">12 Day Before</option>
                                                </select>
                                                <span class="text-danger error-text notify_error"></span>

                                                <div class="dropdown">
                                                    <p class="text-end" type="button" id="cno" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="font-size: 12px">
                                                        Custom
                                                    </p>
                                                    <ul class="dropdown-menu p-0" aria-labelledby="cno"
                                                        style="border: none; width: 300px">
                                                        <div class="p-4 rounded-3" style="border: 1px solid #d7dfe9">
                                                            <input type="number"
                                                                class="form-control shadow-none rounded-2 form-control-md mb-3"
                                                                placeholder="Enter Number" />
                                                            <select
                                                                class="form-select shadow-none rounded-2 form-select-md">
                                                                <option>Day</option>
                                                                <option>Hour</option>
                                                            </select>
                                                            <div
                                                                class="d-flex justify-content-end align-items-center gap-3">
                                                                <button class="btn btn-primary btn-sm px-2 py-1 mt-3">
                                                                    Confirm
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="await" class="form-label fw-500 fs-14">About
                                                Waiting</label>
                                            <textarea name="waiting_about" class="form-control shadow-none rounded-2"
                                                id="await" rows="3"
                                                placeholder="Write about waiting here..."></textarea>
                                        </div>
                                        <span class="text-danger error-text waiting_about_error"></span>

                                    </div>
                                    <div>
                                        <div class="d-flex gap-4 justify-content-start my-4">
                                            <div class="w-50">
                                                <p class="mb-1 fw-500 fs-14">Condition</p>
                                                <select name="condition" class="form-select shadow-none rounded-2">
                                                    <option value="">Select Condition</option>
                                                    <option value="hot">Hot</option>
                                                    <option value="cold">Cold</option>
                                                    <option value="average">Average</option>
                                                </select>
                                                <span class="text-danger error-text condition_error"></span>

                                            </div>
                                            <div class="w-50">
                                                <p class="mb-1 fw-500 fs-14">Tag</p>
                                                <select name="tag" class="form-select shadow-none rounded-2">
                                                    <option value="">Select Tag</option>
                                                    <option value="problemetic_parent">Problemetic Parent</option>
                                                    <option value="2">Another 1</option>
                                                    <option value="3">Another 2</option>
                                                </select>
                                                <span class="text-danger error-text tag_error"></span>

                                            </div>
                                        </div>
                                        <div class="bg-light p-3 rounded-2 mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="fupc" />
                                                <label class="form-check-label fw-500 fs-14"
                                                    for="fupc">Follow-Up</label>
                                            </div>

                                        </div>

                                        <div class="bg-light p-3 rounded-2">
                                            <div class="form-check form-switch mb-4">
                                                <input class="form-check-input" type="checkbox" id="fup2r" />
                                                <label class="form-check-label fw-500 fs-14"
                                                    for="fup2r">Follow-Up</label>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-3 px-2 py-2"
                                                style="font-size: 15px; background-color: #f0f0f0">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="new23" />
                                                    <label class="form-check-label fw-500 fs-14" for="new23">
                                                        New
                                                    </label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="oneday23" />
                                                    <label class="form-check-label fw-500 fs-14" for="oneday23">
                                                        1 Day Before
                                                    </label>

                                                </div>

                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="twoday23" />
                                                    <label class="form-check-label fw-500 fs-14" for="twoday23">
                                                        2 Day Before
                                                    </label>
                                                </div>
                                                <input name="follow_up_date" type="date"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    style="width: fit-content" />
                                            </div>
                                            <span class="text-danger error-text follow_up_date_error"></span>

                                        </div>
                                    </div>
                                </div>

                                closed

                            </div>
                            <div class="modal-footer p-4">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>

                            </form>

                        </div>

                    </div>
                    {{-- meeting stage change offcanvas --}}
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="meetOffcanvas"
                        aria-labelledby="changeStageOffcanvasRightLabel" style="z-index: 3000; width: 600px">
                        <div class="offcanvas-header">
                            <h5 id="changeStageOffcanvasRightLabel">Change Stage</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                <div>
                                    <p class="mb-1 text-dark">
                                        <span class="text-muted">Current Stage : </span>Waiting
                                    </p>
                                    <p class="text-muted" style="font-size: 12px">
                                        Form : Sep 20, 2023
                                    </p>
                                </div>
                                <div>
                                    <form action="{{ route('admin.application.stage.meeting') }}" method="post"
                                        id="meetingStageChangeForm">
                                        @csrf

                                        <input type="hidden" name="application_id" id="meeting_application_id">

                                        <p class="mb-1 fw-500 fs-14" style="font-size: 14px">
                                            Move To
                                        </p>




                                        <select name="stage" id="meet_stage" class="form-select shadow-none rounded-2"
                                            onchange="stageChange(this.id, true)">
                                            <option value="meet">meet</option>
                                            <option value="waiting">waiting</option>
                                            <option value="trial">trial</option>
                                            <option value="confirm">confirm</option>
                                            <option value="repost">repost</option>
                                            <option value="closed">closed</option>
                                            <option value="problem">problem</option>
                                        </select>

                                        <span class="text-danger error-text stage_error"></span>

                                </div>
                                <div class="bg-light p-3 rounded-2 mt-4">
                                    <div class="d-flex gap-4 justify-content-start mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="delay" value=""
                                                id="dly" />
                                            <label class="form-check-label fw-500 fs-14" for="dly">
                                                Delay
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="long"
                                                id="ltime" />
                                            <label class="form-check-label fw-500 fs-14" for="ltime">
                                                Long Time
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-4 justify-content-start mb-2">
                                        <div class="mb-3 w-50">
                                            <label for="datef" class="form-label fw-500" style="font-size: 14px">Meeting
                                                Date</label>
                                            <input name="meeting_date" id="meeting_date" type="date"
                                                class="form-control shadow-none rounded-2 form-control-sm" id="datef" />
                                            <span class="text-danger error-text meeting_date_error"></span>

                                        </div>
                                        <div class="mb-3 w-50">
                                            <label for="timef" class="form-label fw-500" style="font-size: 14px">Time
                                            </label>
                                            <input name="meeting_time" id="meeting_time" type="time"
                                                class="form-control shadow-none rounded-2 form-control-sm" id="timef" />
                                            <span class="text-danger error-text meeting_time_error"></span>

                                        </div>
                                    </div>
                                    <div class="d-flex gap-4 justify-content-end mb-2">
                                        <div>
                                            <p class="mb-1 text-end fw-500" style="font-size: 14px">
                                                Notify
                                            </p>
                                            <select name="notify"
                                                class="form-select shadow-none rounded-2 form-select-sm">
                                                <option selected>1 Day Before</option>
                                                <option value="3">3 Hour Before</option>
                                                <option value="6">6 Day Before</option>
                                                <option value="12">12 Day Before</option>
                                            </select>
                                            <span class="text-danger error-text notify_error"></span>

                                            <div class="dropdown">
                                                <p class="text-end" type="button" id="cno" data-bs-toggle="dropdown"
                                                    aria-expanded="false" style="font-size: 12px">
                                                    Custom
                                                </p>
                                                <ul class="dropdown-menu p-0" aria-labelledby="cno"
                                                    style="border: none; width: 300px">
                                                    <div class="p-4 rounded-3" style="border: 1px solid #d7dfe9">
                                                        <input type="number"
                                                            class="form-control shadow-none rounded-2 form-control-md mb-3"
                                                            placeholder="Enter Number" />
                                                        <select
                                                            class="form-select shadow-none rounded-2 form-select-md">
                                                            <option>Day</option>
                                                            <option>Hour</option>
                                                        </select>
                                                        <div
                                                            class="d-flex justify-content-end align-items-center gap-3">
                                                            <button class="btn btn-primary btn-sm px-2 py-1 mt-3">
                                                                Confirm
                                                            </button>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="await" class="form-label fw-500 fs-14">About Meeting</label>
                                        <textarea name="meeting_about" class="form-control shadow-none rounded-2"
                                            id="await" rows="3" placeholder="Write about meeting here..."></textarea>
                                    </div>
                                    <span class="text-danger error-text meeting_about_error"></span>

                                </div>
                                <div>
                                    <div class="d-flex gap-4 justify-content-start my-4">
                                        <div class="w-50">
                                            <p class="mb-1 fw-500 fs-14">Condition</p>
                                            <select name="condition" class="form-select shadow-none rounded-2">
                                                <option value="">Select Condition</option>
                                                <option value="hot">Hot</option>
                                                <option value="cold">Cold</option>
                                                <option value="average">Average</option>
                                            </select>
                                            <span class="text-danger error-text condition_error"></span>

                                        </div>
                                        <div class="w-50">
                                            <p class="mb-1 fw-500 fs-14">Tag</p>
                                            <select name="tag" class="form-select shadow-none rounded-2">
                                                <option value="">Select Tag</option>
                                                <option value="problemetic_parent">Problemetic Parent</option>
                                                <option value="2">Another 1</option>
                                                <option value="3">Another 2</option>
                                            </select>
                                            <span class="text-danger error-text tag_error"></span>

                                        </div>
                                    </div>
                                    <div class="bg-light p-3 rounded-2 mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="fupc" />
                                            <label class="form-check-label fw-500 fs-14" for="fupc">Follow-Up</label>
                                        </div>

                                    </div>

                                    <div class="bg-light p-3 rounded-2">
                                        <div class="form-check form-switch mb-4">
                                            <input class="form-check-input" type="checkbox" id="fup2r" />
                                            <label class="form-check-label fw-500 fs-14" for="fup2r">Follow-Up</label>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center gap-3 px-2 py-2"
                                            style="font-size: 15px; background-color: #f0f0f0">
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" value="" id="new23" />
                                                <label class="form-check-label fw-500 fs-14" for="new23">
                                                    New
                                                </label>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="oneday23" />
                                                <label class="form-check-label fw-500 fs-14" for="oneday23">
                                                    1 Day Before
                                                </label>

                                            </div>

                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="twoday23" />
                                                <label class="form-check-label fw-500 fs-14" for="twoday23">
                                                    2 Day Before
                                                </label>
                                            </div>
                                            <input name="meeting_follow_up_date" type="date"
                                                class="form-control shadow-none rounded-2 form-control-sm"
                                                style="width: fit-content" />
                                        </div>
                                        <span class="text-danger error-text meeting_follow_up_date_error"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-4">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>

                        </form>
                    </div>
                    <!--stage line model -->
                    <div class="modal fade" id="stagelineModal" tabindex="-1" aria-labelledby="stagelineModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                            <div class="modal-content p-2">
                                <div class="modal-header">
                                    <div clas="d-flex justify-content-start">
                                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="bg-light p-2 rounded-2">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                        Numquam nesciunt minus consequuntur expedita optio quibusdam
                                        officia odit, provident, repellendus ea libero! Nulla error
                                        voluptates fugit, rem officiis quia neque numquam!
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary shadow-lg" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- confirm offcanvas -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="confirmOffcanvas"
                        aria-labelledby="confirmOffcanvasRightLabel" style="z-index: 3000; width: 600px">
                        <div class="offcanvas-header">
                            <h5 id="confirmOffcanvasRightLabel">Confirm Stage</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>


                                <form action="{{ route('admin.application.stage.confirm') }}" method="post"
                                    id="confirmStageChangeForm">

                                    @csrf

                                    <input type="hidden" name="confirm_application_id" id="confirm_application_id">
                                    <div>
                                        <p class="mb-1 text-dark">
                                            <span class="text-muted">Current Stage : </span>Confirm
                                        </p>
                                        <p class="text-muted" style="font-size: 12px">
                                            Form : Sep 20, 2023
                                        </p>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-500 fs-14" style="font-size: 14px">
                                            Move To
                                        </p>

                                        <select name="stage" id="confirm_stage"
                                            class="form-select shadow-none rounded-2"
                                            onchange="stageChange(this.id, true)">
                                            {{-- <option value="assign">assign</option> --}}
                                            <option value="confirm">confirm</option>
                                            <option value="waiting">waiting</option>
                                            <option value="meet">meet</option>
                                            <option value="trial">trial</option>
                                            <option value="repost">repost</option>
                                            <option value="closed">closed</option>
                                            <option value="problem">problem</option>
                                        </select>

                                        <span class="text-danger error-text stage_error"></span>

                                    </div>
                                    <div class="bg-light p-3 rounded-2 mt-4">
                                        <div class="d-flex gap-4 justify-content-between mb-2">
                                            <div class="mb-3">
                                                <label for="datef" class="form-label fw-500"
                                                    style="font-size: 14px">Tutoring
                                                    Start Date</label>
                                                <input type="date" name="tutoring_start_date"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    id="tutoring_start_date" required />
                                                <span class="text-danger error-text tutoring_start_date_error"></span>

                                            </div>
                                            <div>
                                                <label for="timef" class="form-label fw-500"
                                                    style="font-size: 14px">After</label>
                                                <select class="form-select shadow-none rounded-2 form-select-sm"
                                                    style="width: 100px">
                                                    <option>7 Day</option>
                                                    <option>8 Day</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="datef45" class="form-label fw-500"
                                                    style="font-size: 14px">Payment
                                                    Date</label>
                                                <input name="payment_date" type="date"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    id="payment_date" required />
                                                <span class="text-danger error-text payment_date_error"></span>

                                            </div>
                                        </div>
                                        <div class="my-3 p-2 bg-white rounded-2">
                                            <p class="m-0 fs-14">
                                                Monthly Salary 7000 as per as Client Support
                                            </p>
                                        </div>
                                        <div class="d-flex gap-4 justify-content-between mb-2">
                                            <div class="mb-3">
                                                <label for="datef" class="form-label fw-500"
                                                    style="font-size: 14px">Salary</label>
                                                <input name="tution_salary" id="tution_salary" type="text"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    onkeyup="updateCharge()" id="datef" placeholder="Enter Amount" />
                                                <span class="text-danger error-text tution_salary_error"></span>

                                            </div>
                                            <div>
                                                <label for="timef" class="form-label fw-500" style="font-size: 14px">Job
                                                    Duration</label>
                                                <select name="duration" id="duration"
                                                    class="form-select shadow-none rounded-2 form-select-sm"
                                                    style="width: 100px">
                                                    <option value="continue">Continue</option>
                                                    <option value="completed">Completed</option>
                                                    <option value="3 mounth">3 month</option>
                                                    <option value="6 mounth">6 month</option>
                                                </select>

                                                <span class="text-danger error-text duration_error"></span>

                                            </div>
                                            <div>
                                                <label for="timef" class="form-label fw-500"
                                                    style="font-size: 14px">Percentage</label>
                                                <select name="percentage" id="percentage"
                                                    class="form-select shadow-none rounded-2 form-select-sm"
                                                    style="width: 100px">
                                                    <option value="60%">60%</option>
                                                    <option value="50%">50%</option>
                                                    <option value="40%">40%</option>
                                                    <option value="35%">35%</option>
                                                    <option value="30%">30%</option>
                                                    <option value="25%">25%</option>
                                                    <option value="20%">20%</option>

                                                </select>
                                                <span class="text-danger error-text percentage_error"></span>

                                            </div>
                                            <div class="mb-3">
                                                <label for="datef45" class="form-label fw-500"
                                                    style="font-size: 14px">Carge</label>
                                                <input name="charge" id="charge" type="text"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    id="datef45" placeholder="Enter Amount" />
                                                <span class="text-danger error-text charge_error"></span>

                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 justify-content-end mb-2">
                                            <div>
                                                <p class="mb-1 text-end fw-500" style="font-size: 14px">
                                                    Notify
                                                </p>
                                                <select class="form-select shadow-none rounded-2 form-select-sm">
                                                    <option selected>1 Day Before</option>
                                                    <option value="3">3 Hour Before</option>
                                                    <option value="6">6 Day Before</option>
                                                    <option value="12">12 Day Before</option>

                                                    <option value="2">2 Day Before</option>
                                                </select>
                                                <div class="dropdown">
                                                    <p class="text-end" type="button" id="cno" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="font-size: 12px">
                                                        Custom
                                                    </p>
                                                    <ul class="dropdown-menu p-0" aria-labelledby="cno"
                                                        style="border: none; width: 300px">
                                                        <div class="p-4 rounded-3" style="border: 1px solid #d7dfe9">
                                                            <input type="number"
                                                                class="form-control shadow-none rounded-2 form-control-md mb-3"
                                                                placeholder="Enter Number" />
                                                            <select
                                                                class="form-select shadow-none rounded-2 form-select-md">
                                                                <option>Day</option>
                                                                <option>Hour</option>
                                                            </select>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="await" class="form-label fw-500 fs-14">About
                                                Confirm</label>
                                            <textarea name="confirm_about" id="confirm_about"
                                                class="form-control shadow-none rounded-2" rows="3"
                                                placeholder="Write about waiting here..."></textarea>

                                            <span class="text-danger error-text confirm_about_error"></span>

                                        </div>
                                    </div>
                                    <div>
                                        <div class="bg-light p-3 rounded-2 mt-4">
                                            <div class="form-check form-switch mb-4">
                                                <input class="form-check-input" type="checkbox" id="fup2r" />
                                                <label class="form-check-label fw-500 fs-14"
                                                    for="fup2r">Follow-Up</label>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-3 px-2 py-2"
                                                style="font-size: 15px; background-color: #f0f0f0">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="new23" />
                                                    <label class="form-check-label fw-500 fs-14" for="new23">
                                                        New
                                                    </label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="oneday23" />
                                                    <label class="form-check-label fw-500 fs-14" for="oneday23">
                                                        1 Day Before
                                                    </label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="twoday23" />
                                                    <label class="form-check-label fw-500 fs-14" for="twoday23">
                                                        2 Day Before
                                                    </label>
                                                </div>
                                                <input name="confirm_follow_up" id="confirm_follow_up" type="date"
                                                    class="form-control shadow-none rounded-2 form-control-sm"
                                                    style="width: fit-content" />


                                            </div>
                                            <span class="text-danger error-text confirm_follow_up_error"></span>

                                        </div>
                                        <div class="bg-light p-3 rounded-2 my-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="fupsdfghjc" />
                                                <label class="form-check-label fw-500 fs-14" for="fupsdfghjc">Collect
                                                    Tutor
                                                    Salary
                                                </label>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex mt-4 bg-light justify-content-between align-items-center p-3">
                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <img height="35" width="35" class="rounded-3" src="/images/avatar.svg"
                                                    alt="" />
                                                <div class="fw-semibold">
                                                    <p class="m-0 text-nowrap fs-14">Rubel</p>
                                                    <p class="m-0 fw-light text-nowrap fs-12">
                                                        Sales Manager
                                                    </p>
                                                </div>
                                            </div>

                                            <p class="m-0 fs-14 fw-500">
                                                Percentage : <span class="text-muted">12%</span>
                                            </p>
                                            <p class="m-0 fs-14 fw-500">
                                                Affiliate Commotion : :
                                                <span class="text-muted">500</span>
                                            </p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer p-4">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                        </form>
                    </div>

                    <!-- Due tab payment modal -->
                    <div class="modal fade" id="confirmTabPaymentModal" tabindex="-1"
                        aria-labelledby="confirmTabPaymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                            <div class="modal-content p-2">
                                <div class="modal-header">
                                    <p class="mb-0 fs-5 text-dark">Payment</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.taken_offer.payment') }}" method="post" id="payment_form">


                                    <input type="hidden" name="p_app_id" id="p_app_id">
                                    @php
                                    $application = \App\Models\JobApplication::where('id',)
                                    @endphp

                                    @csrf
                                    <div class="modal-body pb-2">
                                        <div class="row row-cols-1 row-cols-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Payment Method</label>
                                                <select id="p_method" name="p_method"
                                                    class="form-select shadow-none rounded-2">
                                                    <option selected value="">Select payment Method</option>
                                                    <option value="Bkash">Bkash</option>
                                                    <option value="nagad">nagad</option>
                                                    <option value="SureCash">SureCash</option>
                                                    <option value="Rocket">Rocket</option>

                                                </select>
                                                <span class="text-danger error-text p_method_error"></span>

                                            </div>
                                            <div class="mb-3">

                                                <label class="form-label">Recevied Number</label>


                                                <select id="received_number" name="received_number"
                                                    class="form-select shadow-none rounded-2">
                                                    <option selected value="">Select payment Method</option>
                                                    <option value="BK-M-01757444477">BK-M-01757444477</option>
                                                    <option value="BK-P-01715930910">BK-P-01715930910</option>
                                                    <option value="BK-P-01631631808">BK-P-01631631808</option>
                                                    <option value="NA-01715930910">NA-01715930910</option>
                                                    <option value="RO-01715930910">RO-01715930910</option>


                                                </select>
                                                <span class="text-danger error-text received_number_error"></span>


                                                {{-- <input id="received_number" name="received_number" type="number"
                                                        class="form-control shadow-none rounded-2"
                                                        placeholder="Enter here" />
                                                        <span class="text-danger error-text received_number_error"></span> --}}

                                            </div>

                                            <div class="mb-3">
                                                <label for="fieldonw" class="form-label">Net Recevied Amount</label>
                                                <input name="net_amount" type="number" id="net_amount"
                                                    class="form-control shadow-none rounded-2 bg-gray-300" value=""
                                                    disabled />
                                                <span class="text-danger error-text net_amount_error"></span>

                                            </div>
                                            <div class="mb-3">
                                                <label for="fieldonw3" class="form-label">Recevied Amount</label>
                                                <input name="received_amount" type="number"
                                                    onkeyup="paymentAdjust(this.id)"
                                                    class="form-control shadow-none rounded-2" id="received_amount"
                                                    placeholder="Enter here" />
                                                <span class="text-danger error-text received_amount_error"></span>

                                            </div>

                                            <div class="mb-3">
                                                <label for="fieldonw" class="form-label">Transaction Id</label>
                                                <input name="trx_id" type="text" id="trx_id"
                                                    class="form-control shadow-none rounded-2 bg-gray-300" required />
                                                <span class="text-danger error-text trx_id_error"></span>

                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <p class="mb-0 fs-5 text-dark">Refund Adjusment</p>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDue" data-bs-toggle="collapse"
                                                        data-bs-target="#refundadj" aria-expanded="false"
                                                        aria-controls="refundadj" />
                                                </div>
                                            </div>
                                            <div class="collapse pt-2" id="refundadj">
                                                <div class="row row-cols-1 row-cols-md-2">
                                                    <div class="mb-3">
                                                        <label for="fieldonw456" class="form-label">Amount</label>
                                                        <input type="text" name="refund_coin"
                                                            class="form-control shadow-none rounded-2" id="fieldonw456"
                                                            placeholder="" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="field45onw3" class="form-label">Reason</label>
                                                        <input type="text" class="form-control shadow-none rounded-2"
                                                            id="field45onw3" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-bottom pb-3 border-2">
                                            <div class="mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <p class="mb-0 fs-5 text-dark">Due</p>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="checkbox_due" data-bs-toggle="collapse"
                                                            data-bs-target="#collapsedue" aria-expanded="false"
                                                            aria-controls="collapsedue" />
                                                    </div>
                                                </div>
                                                <div class="collapse pt-2" id="collapsedue">
                                                    <div class="row row-cols-1 row-cols-md-2">
                                                        <div class="mb-3">
                                                            <label for="fieldonw456" class="form-label">Due
                                                                Amount</label>
                                                            <input type="number" name="due_amount"
                                                                class="form-control shadow-none rounded-2"
                                                                id="due_amount" placeholder="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="field45onw3" class="form-label">Due Payment
                                                                Date</label>
                                                            <input type="date" name="due_payment_date"
                                                                class="form-control shadow-none rounded-2"
                                                                id="due_payment_date" />

                                                            <span
                                                                class="text-danger error-text due_payment_date_error"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <p class="mb-0 fs-5 text-dark">Turn off payment</p>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDue" data-bs-toggle="collapse"
                                                            data-bs-target="#collapsepay" aria-expanded="false"
                                                            aria-controls="collapsepay" />
                                                    </div>
                                                </div>
                                                <div class="collapse pt-2" id="collapsepay">
                                                    <div class="row row-cols-1 row-cols-md-2">
                                                        <div class="mb-3">
                                                            <label for="fieldonw456" class="form-label">Amount</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="fieldonw456" placeholder="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="field45onw3" class="form-label">Reason</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="field45onw3" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <p class="mb-0 fs-5 text-dark">Reference</p>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDue" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseref" aria-expanded="false"
                                                            aria-controls="collapseref" />
                                                    </div>
                                                </div>
                                                <div class="gap-2">
                                                    <p class="mb-0 fs-5 text-dark">Online Payment</p>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="online_payment" id="inlineRadio1" value="1" required>
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="online_payment" id="inlineRadio2" value="0" required>
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                </div>
                                                <div class="collapse pt-2" id="collapseref">
                                                    <div class="row row-cols-1 row-cols-md-3">
                                                        <div class="mb-3">
                                                            <label for="fieldonw456" class="form-label">Name</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="fieldonw456" placeholder="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="field45onw3" class="form-label">Phone</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="field45onw3" placeholder="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="field45onw3" class="form-label">Amount</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="field45onw3" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light shadow-lg" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Save Change
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- due tab payment modal -->
                    <div class="modal fade" id="dueTabPaymentModal" tabindex="-1"
                        aria-labelledby="dueTabPaymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                            <div class="modal-content p-2">
                                <div class="modal-header">
                                    <p class="mb-0 fs-5 text-dark">Payment</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>


                                <form action="{{ route('admin.taken_offer.due_payment') }}" method="post"
                                    id="due_payment_form">


                                    <input type="hidden" name="due_app_id" id="due_app_id">

                                    @csrf
                                    <div class="modal-body pb-2">
                                        <div class="row row-cols-1 row-cols-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Payment Method</label>
                                                <select id="p_method" name="p_method"
                                                    class="form-select shadow-none rounded-2">
                                                    <option selected value="">Select payment Method</option>
                                                    <option value="Bkash">Bkash</option>
                                                    <option value="nagad">nagad</option>
                                                    <option value="SureCash">SureCash</option>
                                                    <option value="Rocket">Rocket</option>

                                                </select>
                                                <span class="text-danger error-text p_method_error"></span>

                                            </div>
                                            <div class="mb-3">

                                                <label class="form-label">Recevied Number</label>



                                                <select id="received_number" name="received_number"
                                                    class="form-select shadow-none rounded-2">
                                                    <option selected value="">Select payment Method</option>
                                                    <option value="BM-01757444477">BM-01757444477</option>
                                                    <option value="BP-01715930910">BP-01715930910</option>
                                                    <option value="BP-01631631808">BP-01631631808</option>
                                                    <option value="N-01715930910">N-01715930910</option>
                                                    <option value="R-01715930910">R-01715930910</option>


                                                </select>
                                                <span class="text-danger error-text received_number_error"></span>


                                                {{-- <input id="received_number" name="received_number" type="number"
                                                        class="form-control shadow-none rounded-2"
                                                        placeholder="Enter here" />
                                                        <span class="text-danger error-text received_number_error"></span> --}}

                                            </div>

                                            <div class="mb-3">
                                                <label for="fieldonw" class="form-label">Net Recevied Amount</label>
                                                <input name="due_net_amount" type="number" id="due_net_amount"
                                                    class="form-control shadow-none rounded-2 bg-gray-300" value=""
                                                    disabled />
                                                <span class="text-danger error-text due_net_amount_error"></span>

                                            </div>
                                            <div class="mb-3">
                                                <label for="fieldonw3" class="form-label">Recevied Amount</label>
                                                <input name="received_amount" type="number" onkeyup="dueAdjust(this.id)"
                                                    class="form-control shadow-none rounded-2" id="due_received_amount"
                                                    placeholder="Enter here" />
                                                <span class="text-danger error-text received_amount_error"></span>

                                            </div>
                                            <div class="mb-3">
                                                <label for="fieldonw" class="form-label">Transaction Id</label>
                                                <input name="trx_id" type="text" id="trx_id"
                                                    class="form-control shadow-none rounded-2 bg-gray-300" required />
                                                <span class="text-danger error-text trx_id_error"></span>

                                            </div>
                                        </div>
                                        <div class="border-bottom pb-3 border-2">
                                            <div class="mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <p class="mb-0 fs-5 text-dark">Due</p>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="due_checkbox_due" data-bs-toggle="collapse"
                                                            data-bs-target="#duecollapsedue" aria-expanded="false"
                                                            aria-controls="duecollapsedue" />
                                                    </div>
                                                </div>
                                                <div class="collapse pt-2" id="duecollapsedue">
                                                    <div class="row row-cols-1 row-cols-md-2">
                                                        <div class="mb-3">
                                                            <label for="fieldonw456" class="form-label">Due
                                                                Amount</label>
                                                            <input type="number" name="due_due_amount"
                                                                class="form-control shadow-none rounded-2"
                                                                id="due_due_amount" placeholder="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="field45onw3" class="form-label">Due Payment
                                                                Date</label>
                                                            <input type="date" name="due_due_payment_date"
                                                                class="form-control shadow-none rounded-2"
                                                                id="due_due_payment_date" />

                                                            <span
                                                                class="text-danger error-text due_due_payment_date_error"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <p class="mb-0 fs-5 text-dark">Turn off payment</p>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="turn_off_payment" id="inlineRadio1" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <p class="mb-0 fs-5 text-dark">Reference</p>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDue" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseref" aria-expanded="false"
                                                            aria-controls="collapseref" />
                                                    </div>
                                                </div>
                                                <div class="collapse pt-2" id="collapseref">
                                                    <div class="row row-cols-1 row-cols-md-3">
                                                        <div class="mb-3">
                                                            <label for="fieldonw456" class="form-label">Name</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="fieldonw456" placeholder="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="field45onw3" class="form-label">Phone</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="field45onw3" placeholder="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="field45onw3" class="form-label">Amount</label>
                                                            <input type="text"
                                                                class="form-control shadow-none rounded-2"
                                                                id="field45onw3" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="gap-2">
                                                <p class="mb-0 fs-5 text-dark">Online Payment</p>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="online_payment"
                                                        id="inlineRadio1" value="1" required>
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="online_payment"
                                                        id="inlineRadio2" value="0" required>
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light shadow-lg" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Save Change
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- payment tab refund modal -->
                    <div class="modal fade" id="paymentTabRefundModal" tabindex="-1"
                        aria-labelledby="paymentTabRefundModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                            <div class="modal-content p-2">
                                <div class="modal-header">
                                    <p class="mb-0 fs-5 text-dark">Payment Refund</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="refundCompleteForm" action="{{ route('admin.taken_offer.refundPayment') }}"
                                    method="post">
                                    <input type="hidden" name="refund_app_id" value="" id="refund_app_id">
                                    @csrf
                                    <div class="modal-body pb-2">
                                        <div class="">
                                            <div class="mb-3">
                                                <label for="refund_amount" class="form-label">Refund Amount</label>
                                                <input type="number" class="form-control shadow-none rounded-2"
                                                    id="refund_amount" name="refund_amount" placeholder="Enter Here" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="refund_reason" class="form-label">Refund Reason</label>
                                                <textarea id="refund_reason" type="text"
                                                    class="form-control shadow-none rounded-2" name="refund_reason"
                                                    placeholder="Enter here"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="refund_date" class="form-label">Refund Date</label>
                                                <input type="date" class="form-control shadow-none rounded-2"
                                                    id="refund_date" name="refund_date" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="account_name" class="form-label">Payment Method</label>
                                                <select id="account_name" name="account_name"
                                                    class="form-select shadow-none rounded-2">
                                                    <option selected value="">Select payment Method</option>
                                                    <option value="Bkash">Bkash</option>
                                                    <option value="Rocket">Rocket</option>
                                                    <option value="Nagad">Nagad</option>
                                                    <option value="Upai">Upai</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="account_type" class="form-label">Account Type</label>
                                                <select id="account_type" name="account_type"
                                                    class="form-select shadow-none rounded-2">
                                                    <option selected value="">Select payment Method</option>
                                                    <option value="Marchant">Marchant</option>
                                                    <option value="Personal">Personal</option>
                                                    <option value="Agent">Agent</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="number" class="form-label">Account number</label>
                                                <input type="number" class="form-control shadow-none rounded-2"
                                                    id="number" name="number" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light shadow-lg"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="submitButton">Save
                                            Changes</button>
                                    </div>
                                </form>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var form = document.getElementById('refundCompleteForm');
                                        var submitButton = document.getElementById('submitButton');

                                        form.addEventListener('submit', function (event) {
                                            event.preventDefault();

                                            var formData = new FormData(form);

                                            submitButton.disabled = true;

                                            $.ajax({
                                                url: form.action,
                                                method: 'POST',
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function (response) {
                                                    Swal.fire({
                                                        position: "top-end",
                                                        icon: "success",
                                                        title: "Refund Complete",
                                                        showConfirmButton: false,
                                                        timer: 1000,
                                                    });
                                                    location.reload();
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error(xhr.responseText);

                                                    submitButton.disabled = false;
                                                }
                                            });
                                        });
                                    });

                                </script>


                            </div>
                        </div>
                    </div>

        </main>
    </div>
</div>
@endsection


@push('page_scripts')
@include('backend.tutor.js.swtdeleteMethod_js')
@include('backend.taken_offer.js.index_page_js')
<script>
    function toggleButtonClass(button) {
        button.classList.toggle('active-button');
        var allButtons = document.querySelectorAll('#stageButton .btn-secondary');
        allButtons.forEach(function (btn) {
            if (btn !== button) {
                btn.classList.remove('active-button');
            }
        });
    }

</script>
<script>
    function toggleButtonClass(button) {
        button.classList.toggle('active-button');

        var isActive = button.classList.contains('active-button');

        if (isActive) {
            button.style.border = '2px solid red';
        } else {
            button.style.border = 'none';
        }

        var allButtons = document.querySelectorAll('#stageButton .btn-secondary');
        allButtons.forEach(function (btn) {
            if (btn !== button) {
                btn.classList.remove('active-button');
                btn.style.border = 'none';
            }
        });
    }

</script>
@endpush
