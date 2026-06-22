@extends('layouts.app')



@section('content')
<main class="container-custom">
    <div class="col-md-12 ms-sm-auto col-lg-9 col-xl-12 p-md-4">
        <div
            class="d-flex justify-content-md-between justify-content-start gap-4 gap-md-0 align-items-md-center flex-column flex-md-row bg-white p-4 rounded-3 mb-3">
            <div class="d-flex justify-content-start align-items-center gap-3">
                <img height="45" width="45" class="rounded-3" src="/images/avatar.svg" alt="" />
                <div class="fw-semibold">
                    <a href="{{route('admin.tutor.tutorshow',$application->tutor->id)}}">
                        <p class="m-0 text-nowrap">
                            {{ $application->tutor->name ?? ''}}
                            <span>
                                <i class="bi bi-check-circle-fill text-info" style="font-size: 0.8rem"></i>
                            </span>
                        </p>

                    </a>


                    @php
                    $tAduTotalElements = count($application->tutor->tutor_education ?? []);

                    @endphp

                    <p class="m-0 fw-light text-nowrap">
                        {{ $application->tutor->phone ?? ''}}    </p>
                </div>
            </div>
            <div class="d-flex justify-content-start align-items-center gap-3">
                <img height="45" width="45" class="rounded-3" src="/images/avatar.svg" alt="" />
                <div class="fw-semibold">
                    <p class="m-0 text-nowrap">
                        {{ $application->job_offer->parent->name ?? ''}}
                        <span>
                            <i class="bi bi-check-circle-fill text-info" style="font-size: 0.8rem"></i>
                        </span>
                    </p>
                    <p class="m-0 fw-light text-nowrap">{{ $application->job_offer->parent->phone ?? ''}}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-3 mb-4">
            <div class="row row-cols-3 row-cols-lg-6 row-cols-md-4 gap-4 gap-lg-0 border-bottom border-1 pb-3">
                <div class="fw-normal">
                    <p class="mb-1 text-nowrap fw-500 fs-14">Job ID</p>
                    <a href="{{route('admin.job-details',$application->job_offer_id)}}">

                        <p class="m-0 fw-light fs-14">{{ $application->job_offer_id }}</p>
                    </a>
                </div>
                <div class="fw-normal">
                    <p class="mb-1 text-nowrap fw-500 fs-14">Job Status</p>
                    <p class="m-0 fw-light fs-14">
                        @if ($application->jobOffer->is_active == 1)
                        Live On
                        @else
                        Live Off
                        @endif
                    </p>
                </div>
                <div class="fw-normal">
                    <p class="mb-1 text-nowrap fw-500 fs-14">Deal ID</p>
                    <p class="m-0 fw-light fs-14">{{$application->id}}</p>
                </div>
                <div class="fw-normal">
                    <p class="mb-1 text-nowrap fw-500 fs-14">Status</p>
                    <p class="m-0 fw-light fs-14">{{$application->current_stage}}</p>
                </div>
                <div class="fw-normal">
                    <p class="mb-1 text-nowrap fw-500 fs-14">Tutor Assign</p>
                    @php
                    $id = $application->job_offer_id;
                    $count = App\Models\JobApplication::where('job_offer_id',$id)->where('taken_by_id', !Null)->count();
                    @endphp
                    <p class="m-0 fw-light fs-14">{{$count}}</p>
                </div>
                <div class="fw-normal">
                    <p class="mb-1 text-nowrap fw-500 fs-14">Current Assign</p>
                    <p class="m-0 fw-light fs-14">{{ $application->employee->name }}</p>
                </div>
            </div>
            <div class="pt-3 d-flex justify-content-start align-items-center gap-3">
                <div>
                    <p class="fs-14 m-0">
                        Condition : <span class="text-gray-600">{{ $application->condition }}</span>
                    </p>
                </div>
                <div class="badge bg-light text-primary fw-light">Tag</div>
                <div class="badge bg-light text-primary fw-light">{{ $application->tag }}</div>
                <div class="badge bg-light text-primary fw-light">Tag3</div>
            </div>
        </div>
        <div>
            <div class="tabholder bg-white mb-4">
                <ul class="nav nav-pills mb-3 d-flex justify-content-start" id="pills-tab" role="tablist">
                    <!-- tab navigations starts here -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-update-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-update" type="button" role="tab" aria-controls="pills-update"
                            aria-selected="true">
                            Update
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-jobdetails-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-jobdetails" type="button" role="tab" aria-controls="pills-jobdetails"
                            aria-selected="false">
                            Job Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-tutordetails-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-tutordetails" type="button" role="tab"
                            aria-controls="pills-tutordetails" aria-selected="false">
                            Tutor Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-condition-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-condition" type="button" role="tab" aria-controls="pills-condition"
                            aria-selected="false">
                            Condition
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-editlog-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-editlog" type="button" role="tab" aria-controls="pills-editlog"
                            aria-selected="false">
                            Edit log
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-assign-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-assign" type="button" role="tab" aria-controls="pills-assign"
                            aria-selected="false">
                            Assign
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" id="{{ $application->id }}" onclick="btnNote(this.id)"
                            data-bs-toggle="modal" data-bs-target="#noteModal">
                            All Notes
                        </button>
                    </li>
                </ul>
            </div>
            <div>
                <div class="tab-content" id="pills-tabContent">





                    <!-- All tabs gose here  -->
                    <div class="tab-pane fade show active" id="pills-update" role="tabpanel"
                        aria-labelledby="pills-update-tab" tabindex="0">
                        <!-- this is update tab -->
                        <div class="" style="padding-left: 12px; padding-right: 12px">
                            @foreach ($other_application as $item)


                            <hr>
                            {{-- my application --}}


                                <div class="row bg-white rounded-3 p-3 gap-4 justify-content-start align-items-center">
                                    <div class="d-flex justify-content-start align-items-center col col-lg-1 col-md-1"
                                        style="width: fit-content">
                                        <i class="bi bi-2-square-fill fs-3 text-primary"></i>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center col-lg-1 col-md-2">
                                        <p class="m-0 text-gray-600">{{ $item->id }}</p>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-3 col-lg-3 col-md-3">
                                        <img height="45" width="45" class="rounded-3" src="/images/avatar.svg" alt="" />
                                        <div class="fw-semibold">
                                            <p class="m-0 text-nowrap">
                                                {{ $item->tutor->name ?? ''}}
                                                <span>
                                                    <i class="bi bi-check-circle-fill text-info"
                                                        style="font-size: 0.8rem"></i>
                                                </span>
                                            </p>
                                            <p class="m-0 fw-light text-nowrap fs-14">
                                                {{ Str::limit($item->tutor->tutor_education[$tAduTotalElements - 1]->institutes->title ?? 'N/A', 20) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                        <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                        <div class="fw-semibold">
                                            <p class="m-0 text-nowrap fs-14">{{ $item->employee->name ?? ''}}
                                            </p>
                                            <p class="m-0 fw-light text-nowrap fs-12">
                                                @if ($item->employee->role_id === 1)
                                                Super Admin
                                                @else
                                                Employee
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center col-lg-2 col-md-1">
                                        <p class="m-0 text-info">{{ $item->current_stage }}
                                        </p>
                                    </div>

                                    <div class="d-flex justify-content-between gap-4 col-lg-2 g-0">
                                        <div class="d-flex justify-content-start align-items-start flex-column">

                                            @php
                                            $input = $item->taken_at;
                                            $format1 = 'd-m-Y';
                                            $format2 = 'h:i A';
                                            $taken_date = Carbon\Carbon::parse($input)->format($format1);
                                            $taken_time = Carbon\Carbon::parse($input)->format($format2);
                                            @endphp

                                            <p class="m-0 text-muted fs-14 text-nowrap">
                                                {{ $taken_date }}
                                            </p>
                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                {{ $taken_time }}
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                data-bs-target="#collapseone_{{$item->id}}">
                                                <i class="bi bi-chevron-expand"></i>
                                            </button>
                                        </div>

                                        {{-- Collapse --}}

                                    </div>

                                    @if ($item->current_stage == 'waiting')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Waiting</p>

                                                <p class="m-0 text-muted fs-12">
                                                    {{ \Carbon\Carbon::parse($item->waiting_date)->format('d/m/Y') }}


                                                </p>
                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                           Time
                                                        </p>

                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->waiting_time)->format('h:i a') }}
                                                            {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Notify</p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            ??
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Condition</p>
                                                        <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Tag</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Follow Up
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->waiting_follow_up_date)->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_waiting_old">
                                                            <i class="bi bi-chevron-expand"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collapse_waiting_old" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row justify-content-end">
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Note</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Waiting Note
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                <p class="fw-semibold fs-14 mb-2">
                                                                    {{ $item->waiting_about }}
                                                                </p>

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @elseif($item->current_stage == 'assign')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Assign</p>

                                                <p class="m-0 text-muted fs-12">
                                                    {{ \Carbon\Carbon::parse($item->taken_at)->format('d/m/Y') }}
                                                </p>

                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Time
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->taken_at)->format('h:i a') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @elseif($item->current_stage == 'meeting')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Meeting</p>

                                                <p class="m-0 text-muted fs-12">
                                                    {{ \Carbon\Carbon::parse($item->meeting_date)->format('d/m/Y') }}


                                                </p>
                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                           Time
                                                        </p>

                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->meeting_time)->format('h:i a') }}
                                                            {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Notify</p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            ??
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Condition</p>
                                                        <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Tag</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Follow Up
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->meeting_follow_up_date)->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_meeting_old">
                                                            <i class="bi bi-chevron-expand"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapse_meeting_old" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row justify-content-end">
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Note</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Meeting Note
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                <p class="fw-semibold fs-14 mb-2">
                                                                    {{ $item->meeting_about }}
                                                                </p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @elseif($item->current_stage == 'trial')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Trial</p>

                                                <p class="m-0 text-muted fs-12">
                                                    {{ \Carbon\Carbon::parse($item->trial_date)->format('d/m/Y') }}

                                                </p>
                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                           Time
                                                        </p>

                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->trial_time)->format('h:i a') }}
                                                            {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Notify</p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            ??
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Condition</p>
                                                        <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Tag</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Follow Up
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->trial_follow_up)->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_{{$item->current_stage}}">
                                                            <i class="bi bi-chevron-expand"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collapse_{{$item->current_stage}}" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row justify-content-end">
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Note</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Trial Note
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                <p class="fw-semibold fs-14 mb-2">
                                                                    {{ $item->trial_about }}
                                                                </p>

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($item->trial_date_1st !=null)
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">First Trial</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                First Trial Date & Time
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                <p class="fw-semibold fs-14 mb-2">
                                                                    {{ \Carbon\Carbon::parse($item->trial_date_1st)->format('d/m/Y') }}
                                                                    <br>
                                                                    {{ \Carbon\Carbon::parse($item->trial_time_1st)->format('h:i a') }}
                                                                </p>

                                                            </p>
                                                        </div>
                                                        {{-- <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Trial Note
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                <p class="fw-semibold fs-14 mb-2">
                                                                    {{ $item->trial_about }}
                                                                </p>

                                                            </p>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                @endif

                                                @if ($item->trial_date_2nd !=null)
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Second Trial</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Second Trial Date & Time
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                <p class="fw-semibold fs-14 mb-2">
                                                                    {{ \Carbon\Carbon::parse($item->trial_date_1st)->format('d/m/Y') }}
                                                                    <br>
                                                                    {{ \Carbon\Carbon::parse($item->trial_time_1st)->format('h:i a') }}
                                                                </p>

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            {{-- <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">
                                                            Call Tutor
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            Sep 21, 2023
                                                        </p>
                                                        <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div>
                                                            <p class="fw-500 fs-14 mb-1">Duration</p>
                                                            <p class="m-0 text-muted fs-12">1 Minute</p>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Meeting Note
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {{ $item->meeting_about }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">
                                                            Follow Up
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            Sep 21, 2023
                                                        </p>
                                                        <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div>
                                                            <p class="fw-500 fs-14 mb-1">Follow Up</p>
                                                            <p class="m-0 text-muted fs-12">1 Minute</p>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div> --}}
                                        </div>
                                        {{-- custom application_information --}}
                                        {{-- <div class="row row-cols-lg-2">


                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Waiting Stage</h5>

                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold"> {{$item->current_stage ?? 'N/A'}} Stage
                                                                From</p>
                                                            <p class="">
                                                                {{date('Y-m-d', strtotime($item->waiting_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->waiting_follow_up_date ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->waiting_about, 40) ?? 'N/A' }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->waiting_about ?? 'N/A'}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">meeting Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>


                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold"> {{$item->current_stage}} Stage From</p>
                                                            <p class="">{{$item->meeting_date}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->meeting_follow_up_date ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->meeting_about, 40) }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->meeting_about}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Trial Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">1st Trial Date Time</p>
                                                            <p class="">
                                                                {{date('Y-m-d', strtotime($item->trial_date_1st)) ?? 'N/A'}}
                                                                |{{$item->trial_time_1st ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">2nd Trial Date Time</p>
                                                            <p class="">
                                                                {{date('Y-m-d', strtotime($item->trial_date_2nd)) ?? 'N/A'}}
                                                                |{{$item->trial_time_2nd ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Condition</p>
                                                            <p class="">{{$item->condition}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Tag</p>
                                                            <p class="">{{$item->tag}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->trial_follow_up ?? 'N/A'}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->trial_about, 40) ?? 'N/A' }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->trial_about ?? 'N/A'}}">
                                                                    •••
                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Confirm Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Confirm Stage From</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->confirm_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Tutoring Start Date</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->tutoring_start_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">payment Date</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->payment_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Salary</p>
                                                            <p class="">{{$item->tution_salary ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Job Duration</p>
                                                            <p class="">{{$item->duration ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Percentage | Charge</p>
                                                            <p class="">{{$item->percentage ?? 'N/A'}} |
                                                                {{$item->charge ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->confirm_follow_up ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->confirm_about, 10) }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->confirm_about}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Repost Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Repost Stage From</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->repost_date)) ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->repost_follow_up ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->repost_about, 40) ?? 'N/A'}}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->repost_about ?? 'N/A'}}">
                                                                    •••
                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Closed Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Closed Stage From</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->closed_date)) ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->closed_follow_up ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->closed_about, 40) ?? 'N/A'}}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->closed_about ?? 'N/A'}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                application all note

                                            </div>
                                        </div> --}}
                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @elseif($item->current_stage == 'problem')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Problem</p>

                                                <p class="m-0 text-muted fs-12">
                                                    {{ \Carbon\Carbon::parse($item->problem_date)->format('d/m/Y') }}

                                                </p>

                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Time
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->problem_date)->format('h:i a') }}

                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Notify</p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            ??
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Condition</p>
                                                        <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Tag</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Follow Up
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">

                                                            {{ \Carbon\Carbon::parse($item->problem_follow_up)->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_{{$item->current_stage}}">
                                                            <i class="bi bi-chevron-expand"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collapse_{{$item->current_stage}}" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row justify-content-end">
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Note</p>

                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Problem About
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {{ $item->problem_about }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- custom application_information --}}
                                        {{-- <div class="row row-cols-lg-2">


                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Waiting Stage</h5>

                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold"> {{$item->current_stage ?? 'N/A'}} Stage
                                                                From</p>
                                                            <p class="">
                                                                {{date('Y-m-d', strtotime($item->waiting_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->waiting_follow_up_date ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->waiting_about, 40) ?? 'N/A' }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->waiting_about ?? 'N/A'}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">meeting Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>


                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold"> {{$item->current_stage}} Stage From</p>
                                                            <p class="">{{$item->meeting_date}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->meeting_follow_up_date ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->meeting_about, 40) }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->meeting_about}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Trial Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">1st Trial Date Time</p>
                                                            <p class="">
                                                                {{date('Y-m-d', strtotime($item->trial_date_1st)) ?? 'N/A'}}
                                                                |{{$item->trial_time_1st ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">2nd Trial Date Time</p>
                                                            <p class="">
                                                                {{date('Y-m-d', strtotime($item->trial_date_2nd)) ?? 'N/A'}}
                                                                |{{$item->trial_time_2nd ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Condition</p>
                                                            <p class="">{{$item->condition}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Tag</p>
                                                            <p class="">{{$item->tag}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->trial_follow_up ?? 'N/A'}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->trial_about, 40) ?? 'N/A' }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->trial_about ?? 'N/A'}}">
                                                                    •••
                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Confirm Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Confirm Stage From</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->confirm_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Tutoring Start Date</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->tutoring_start_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">payment Date</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->payment_date)) ?? 'N/A'}}
                                                            </p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Salary</p>
                                                            <p class="">{{$item->tution_salary ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Job Duration</p>
                                                            <p class="">{{$item->duration ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Percentage | Charge</p>
                                                            <p class="">{{$item->percentage ?? 'N/A'}} |
                                                                {{$item->charge ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->confirm_follow_up ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->confirm_about, 10) }}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->confirm_about}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Repost Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Repost Stage From</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->repost_date)) ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->repost_follow_up ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->repost_about, 40) ?? 'N/A'}}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->repost_about ?? 'N/A'}}">
                                                                    •••
                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="bg-white py-4 shadow-lg rounded-3">
                                                    <h5 class="mb-5 ms-4">Closed Stage</h5>
                                                    <div class="">
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">current Stage</p>
                                                            <p class="">{{$item->current_stage}}</p>
                                                        </div>

                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Closed Stage From</p>
                                                            <p class="">
                                                                {{date('d-m-Y', strtotime($item->closed_date)) ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Follow Up</p>
                                                            <p class="">{{$item->closed_follow_up ?? 'N/A'}}</p>
                                                        </div>
                                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                            <p class="fw-semibold">Stage About</p>
                                                            <p class="">
                                                                {{ Str::limit($item->closed_about, 40) ?? 'N/A'}}
                                                                <button tabindex="0" style="border: none"
                                                                    class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                    data-bs-toggle="popover" data-bs-trigger="focus"
                                                                    title="Details Address"
                                                                    data-bs-content="{{$item->closed_about ?? 'N/A'}}">

                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                application all note

                                            </div>
                                        </div> --}}
                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @elseif($item->current_stage == 'repost')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Repost</p>

                                                <p class="m-0 text-muted fs-12">
                                                    {{ \Carbon\Carbon::parse($item->repost_date)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Dtae & Time
                                                        </p>

                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->repost_date)->format('h:i a') }}
                                                            {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}


                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Notify</p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            ??
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Condition</p>
                                                        <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Tag</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Follow Up
                                                        </p>

                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_repost_old">
                                                            <i class="bi bi-chevron-expand"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collapse_repost_old" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row justify-content-end">
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Noted</p>

                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Repost About
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {{ $item->repost_about }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @elseif($item->current_stage == 'closed')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Closed</p>

                                                <p class="m-0 text-muted fs-12">

                                                    {{ \Carbon\Carbon::parse($item->closed_date)->format('d/m/Y') }}


                                                </p>

                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Time
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->closed_date)->format('h:i a') }}
                                                            {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Notify</p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            ??
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Condition</p>
                                                        <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Tag</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Follow Up
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">



                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_old_closed">
                                                            <i class="bi bi-chevron-expand"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collapse_old_closed" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row justify-content-end">
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Noted</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Closed Note
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {{ $item->closed_about }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @elseif($item->current_stage == 'confirm')
                                    <div class="" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row p-3 my-4 bg-white rounded-3">
                                            <div class="col-lg-2 col-10 pt-5">
                                                <p class="fw-semibold fs-14 mb-2">Move To
                                                    Confirm</p>

                                                <p class="m-0 text-muted fs-12">
                                                    {{ \Carbon\Carbon::parse($item->confirm_date)->format('d/m/Y') }}

                                                </p>
                                                <p class="m-0 text-muted fs-12">


                                                </p>
                                            </div>
                                            <div
                                                class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                            </div>
                                            <div class="col-lg-9 col-12">
                                                {{-- <div class="mt-4 mt-lg-0">
                                                    <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                    <p class="m-0 text-muted fs-12">
                                                        {{ $item->meeting_about }}
                                                    </p>
                                                </div> --}}
                                                <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Time
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->confirm_date)->format('h:i a') }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Notify</p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            ??
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Condition</p>
                                                        <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1">Tag</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                            Follow Up
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->confirm_follow_up)->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_old_confirm">
                                                            <i class="bi bi-chevron-expand"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collapse_old_confirm" style="padding-left: 12px; padding-right: 12px">
                                        <div class="row justify-content-end">
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">Noted</p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div class="flex-grow-1">
                                                            <p class="fw-500 fs-14 mb-1">
                                                                Confirm Note
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {{ $item->confirm_about }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">
                                                            Tutoring Stat
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">

                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div>
                                                            <p class="fw-500 fs-14 mb-1">Date</p>
                                                            <p class="fw-500 fs-14 mb-1">
                                                                {{ \Carbon\Carbon::parse($item->tutoring_start_date)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">
                                                            Tutoring Salary
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">

                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div>
                                                            <p class="fw-500 fs-14 mb-1">Salary</p>
                                                            <p class="fw-500 fs-14 mb-1">
                                                                {{$item->tuition_salary}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">
                                                            Payment Date
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">

                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div>
                                                            <p class="fw-500 fs-14 mb-1">Date</p>
                                                            <p class="fw-500 fs-14 mb-1">
                                                                {{$item->payment_date}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                <div class="row">
                                                    <div class="col-10 col-md-2">
                                                        <p class="fw-semibold fs-14 mb-2">
                                                            Charge
                                                        </p>
                                                        <p class="m-0 text-muted fs-12 text-nowrap">

                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                        <div style="margin-top: -4px">
                                                            <i class="bi bi-check-square-fill text-info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div>
                                                            <p class="fw-500 fs-14 mb-1">Charge</p>
                                                            <p class="fw-500 fs-14 mb-1">
                                                                {{$item->charge}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                        <div>
                                                            <p class="fw-500 fs-14 mb-1">Percentage</p>
                                                            <p class="fw-500 fs-14 mb-1">
                                                                {{$item->percentage}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                            onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                            All Notes
                                        </button>
                                    </div>
                                    @endif




                                    {{-- Old Data --}}
                                    <div class="collapse p-4" id="collapseone_{{$item->id}}">
                                        <div class="p-4 bg-white rounded-3 d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1 text-dark">
                                                    <span class="text-muted">Current Stage :
                                                    </span>{{ $item->current_stage }}
                                                </p>
                                                <p class="text-muted m-0" style="font-size: 12px">
                                                    Form :

                                                    @if ($item->current_stage == 'meet')
                                                    {{ \Carbon\Carbon::parse($item->meeting_date)->format('d/m/Y') }}
                                                    @elseif($item->current_stage == 'trial')
                                                    {{ \Carbon\Carbon::parse($item->trial_date)->format('d/m/Y') }}
                                                    @elseif($item->current_stage == 'confirm')
                                                    {{ \Carbon\Carbon::parse($item->confirm_date)->format('d/m/Y') }}
                                                    @elseif($item->current_stage == 'payment')
                                                    {{ \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y') }}
                                                    @elseif($item->current_stage == 'repost')
                                                    {{ \Carbon\Carbon::parse($item->repost_date)->format('d/m/Y') }}
                                                    @elseif($item->current_stage == 'problem')
                                                    {{ \Carbon\Carbon::parse($item->problem_date)->format('d/m/Y') }}
                                                    @endif


                                                </p>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary shadow-none" data-bs-toggle="dropdown"
                                                    data-bs-display="static" aria-expanded="false" style="
                                                            background-color: transparent;
                                                            border: none;
                                                            ">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-lg-end border-0 p-0 m-0">
                                                    <div class="rounded-2 text-white-on-hover" style="border: 1px solid #d7dfe9">
                                                        <li>
                                                            <a class="dropdown-item" href="#">Manage</a>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#trailchangestageModal">
                                                                Change Stage
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#followupModal">
                                                                Follow Up
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#mustdoModal">
                                                                Must Do (Only Admin)
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">Stage Line</a>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#noteModal">
                                                                Note
                                                            </button>
                                                        </li>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        @if ($item->taken_at !== null)
                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Assign</p>

                                                    <p class="m-0 text-muted fs-12">
                                                        {{ \Carbon\Carbon::parse($item->taken_at)->format('d/m/Y') }}
                                                    </p>

                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Time
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->taken_at)->format('h:i a') }}

                                                            </p>
                                                        </div>
                                                        {{-- <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">

                                                                @if ($item->current_stage == 'waiting')
                                                                {{ \Carbon\Carbon::parse($item->waiting_follow_up_date)->format('d/m/Y') }}
                                                                @elseif($item->current_stage == 'meet')
                                                                {{ \Carbon\Carbon::parse($item->meeting_follow_up_date)->format('d/m/Y') }}
                                                                @elseif($item->current_stage == 'trial')
                                                                {{ \Carbon\Carbon::parse($item->trial_follow_up)->format('d/m/Y') }}
                                                                @elseif($item->current_stage == 'confirm')
                                                                {{ \Carbon\Carbon::parse($item->confirm_follow_up)->format('d/m/Y') }}
                                                                @elseif($item->current_stage == 'payment')
                                                                {{ \Carbon\Carbon::parse($item->payment_follow_up)->format('d/m/Y') }}

                                                                @elseif($item->current_stage == 'repost')

                                                                {{ \Carbon\Carbon::parse($item->repost_follow_up)->format('d/m/Y') }}

                                                                @elseif($item->current_stage == 'problem')
                                                                {{ \Carbon\Carbon::parse($item->problem_follow_up)->format('d/m/Y') }}


                                                                @endif


                                                            </p>
                                                        </div> --}}
                                                        {{-- <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_{{$item->current_stage}}">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($item->waiting_date !== null)
                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Waiting</p>

                                                    <p class="m-0 text-muted fs-12">
                                                        {{ \Carbon\Carbon::parse($item->waiting_date)->format('d/m/Y') }}


                                                    </p>
                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                               Time
                                                            </p>

                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->waiting_time)->format('h:i a') }}
                                                                {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->waiting_follow_up_date)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_waiting_old">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse_waiting_old" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row justify-content-end">
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Note</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Waiting Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    <p class="fw-semibold fs-14 mb-2">
                                                                        {{ $item->waiting_about }}
                                                                    </p>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Call Tutor
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                Sep 21, 2023
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Duration</p>
                                                                <p class="m-0 text-muted fs-12">1 Minute</p>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Meeting Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    {{ $item->meeting_about }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                Sep 21, 2023
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Follow Up</p>
                                                                <p class="m-0 text-muted fs-12">1 Minute</p>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div> --}}
                                            </div>
                                            {{-- custom application_information --}}
                                            {{-- <div class="row row-cols-lg-2">


                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Waiting Stage</h5>

                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage ?? 'N/A'}} Stage
                                                                    From</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->waiting_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->waiting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->waiting_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->waiting_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">meeting Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>


                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage}} Stage From</p>
                                                                <p class="">{{$item->meeting_date}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->meeting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->meeting_about, 40) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->meeting_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Trial Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">1st Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_1st)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_1st ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">2nd Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_2nd)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_2nd ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Condition</p>
                                                                <p class="">{{$item->condition}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tag</p>
                                                                <p class="">{{$item->tag}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->trial_follow_up ?? 'N/A'}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->trial_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->trial_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Confirm Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Confirm Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->confirm_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tutoring Start Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->tutoring_start_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">payment Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->payment_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Salary</p>
                                                                <p class="">{{$item->tution_salary ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Job Duration</p>
                                                                <p class="">{{$item->duration ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Percentage | Charge</p>
                                                                <p class="">{{$item->percentage ?? 'N/A'}} |
                                                                    {{$item->charge ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->confirm_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->confirm_about, 10) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->confirm_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Repost Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Repost Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->repost_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->repost_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->repost_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->repost_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Closed Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Closed Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->closed_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->closed_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->closed_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->closed_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    application all note

                                                </div>
                                            </div> --}}
                                            <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                                onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                All Notes
                                            </button>
                                        </div>
                                        @endif

                                        @if($item->meeting_date !== null)
                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Meeting</p>

                                                    <p class="m-0 text-muted fs-12">
                                                        {{ \Carbon\Carbon::parse($item->meeting_date)->format('d/m/Y') }}


                                                    </p>
                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                               Time
                                                            </p>

                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->meeting_time)->format('h:i a') }}
                                                                {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->meeting_follow_up_date)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_meeting_old">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse_meeting_old" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row justify-content-end">
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Note</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Meeting Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    <p class="fw-semibold fs-14 mb-2">
                                                                        {{ $item->meeting_about }}
                                                                    </p>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Call Tutor
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                Sep 21, 2023
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Duration</p>
                                                                <p class="m-0 text-muted fs-12">1 Minute</p>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Meeting Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    {{ $item->meeting_about }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                Sep 21, 2023
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Follow Up</p>
                                                                <p class="m-0 text-muted fs-12">1 Minute</p>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div> --}}
                                            </div>
                                            {{-- custom application_information --}}
                                            {{-- <div class="row row-cols-lg-2">


                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Waiting Stage</h5>

                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage ?? 'N/A'}} Stage
                                                                    From</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->waiting_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->waiting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->waiting_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->waiting_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">meeting Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>


                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage}} Stage From</p>
                                                                <p class="">{{$item->meeting_date}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->meeting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->meeting_about, 40) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->meeting_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Trial Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">1st Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_1st)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_1st ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">2nd Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_2nd)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_2nd ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Condition</p>
                                                                <p class="">{{$item->condition}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tag</p>
                                                                <p class="">{{$item->tag}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->trial_follow_up ?? 'N/A'}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->trial_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->trial_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Confirm Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Confirm Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->confirm_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tutoring Start Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->tutoring_start_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">payment Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->payment_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Salary</p>
                                                                <p class="">{{$item->tution_salary ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Job Duration</p>
                                                                <p class="">{{$item->duration ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Percentage | Charge</p>
                                                                <p class="">{{$item->percentage ?? 'N/A'}} |
                                                                    {{$item->charge ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->confirm_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->confirm_about, 10) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->confirm_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Repost Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Repost Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->repost_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->repost_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->repost_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->repost_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Closed Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Closed Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->closed_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->closed_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->closed_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->closed_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    application all note

                                                </div>
                                            </div> --}}
                                            <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                                onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                All Notes
                                            </button>
                                        </div>
                                        @endif

                                        @if($item->trial_date !== null)

                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Trial</p>

                                                    <p class="m-0 text-muted fs-12">
                                                        {{ \Carbon\Carbon::parse($item->trial_date)->format('d/m/Y') }}

                                                    </p>
                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                               Time
                                                            </p>

                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->trial_time)->format('h:i a') }}
                                                                {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->trial_follow_up)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_trial_old">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse_trial_old" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row justify-content-end">
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Note</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Trial Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    <p class="fw-semibold fs-14 mb-2">
                                                                        {{ $item->trial_about }}
                                                                    </p>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($item->trial_date_1st !=null)
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">First Trial</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    First Trial Date & Time
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    <p class="fw-semibold fs-14 mb-2">
                                                                        {{ \Carbon\Carbon::parse($item->trial_date_1st)->format('d/m/Y') }}
                                                                        <br>
                                                                        {{ \Carbon\Carbon::parse($item->trial_time_1st)->format('h:i a') }}
                                                                    </p>

                                                                </p>
                                                            </div>
                                                            {{-- <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Trial Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    <p class="fw-semibold fs-14 mb-2">
                                                                        {{ $item->trial_about }}
                                                                    </p>

                                                                </p>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if ($item->trial_date_2nd !=null)
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Second Trial</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Second Trial Date & Time
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    <p class="fw-semibold fs-14 mb-2">
                                                                        {{ \Carbon\Carbon::parse($item->trial_date_1st)->format('d/m/Y') }}
                                                                        <br>
                                                                        {{ \Carbon\Carbon::parse($item->trial_time_1st)->format('h:i a') }}
                                                                    </p>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                {{-- <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Call Tutor
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                Sep 21, 2023
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Duration</p>
                                                                <p class="m-0 text-muted fs-12">1 Minute</p>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Meeting Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    {{ $item->meeting_about }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                Sep 21, 2023
                                                            </p>
                                                            <p class="m-0 text-muted fs-12">12: 30 am</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Follow Up</p>
                                                                <p class="m-0 text-muted fs-12">1 Minute</p>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div> --}}
                                            </div>
                                            {{-- custom application_information --}}
                                            {{-- <div class="row row-cols-lg-2">


                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Waiting Stage</h5>

                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage ?? 'N/A'}} Stage
                                                                    From</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->waiting_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->waiting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->waiting_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->waiting_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">meeting Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>


                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage}} Stage From</p>
                                                                <p class="">{{$item->meeting_date}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->meeting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->meeting_about, 40) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->meeting_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Trial Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">1st Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_1st)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_1st ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">2nd Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_2nd)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_2nd ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Condition</p>
                                                                <p class="">{{$item->condition}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tag</p>
                                                                <p class="">{{$item->tag}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->trial_follow_up ?? 'N/A'}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->trial_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->trial_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Confirm Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Confirm Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->confirm_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tutoring Start Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->tutoring_start_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">payment Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->payment_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Salary</p>
                                                                <p class="">{{$item->tution_salary ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Job Duration</p>
                                                                <p class="">{{$item->duration ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Percentage | Charge</p>
                                                                <p class="">{{$item->percentage ?? 'N/A'}} |
                                                                    {{$item->charge ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->confirm_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->confirm_about, 10) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->confirm_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Repost Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Repost Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->repost_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->repost_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->repost_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->repost_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Closed Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Closed Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->closed_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->closed_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->closed_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->closed_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    application all note

                                                </div>
                                            </div> --}}
                                            <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                                onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                All Notes
                                            </button>
                                        </div>
                                        @endif

                                        @if($item->problem_date !== null)

                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Problem</p>

                                                    <p class="m-0 text-muted fs-12">
                                                        {{ \Carbon\Carbon::parse($item->problem_date)->format('d/m/Y') }}

                                                    </p>

                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Time
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->problem_date)->format('h:i a') }}

                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">

                                                                {{ \Carbon\Carbon::parse($item->problem_follow_up)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_problem_old">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse_problem_old" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row justify-content-end">
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Note</p>

                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Problem About
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    {{ $item->problem_about }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- custom application_information --}}
                                            {{-- <div class="row row-cols-lg-2">


                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Waiting Stage</h5>

                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage ?? 'N/A'}} Stage
                                                                    From</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->waiting_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->waiting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->waiting_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->waiting_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">meeting Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>


                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold"> {{$item->current_stage}} Stage From</p>
                                                                <p class="">{{$item->meeting_date}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->meeting_follow_up_date ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->meeting_about, 40) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->meeting_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Trial Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">1st Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_1st)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_1st ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">2nd Trial Date Time</p>
                                                                <p class="">
                                                                    {{date('Y-m-d', strtotime($item->trial_date_2nd)) ?? 'N/A'}}
                                                                    |{{$item->trial_time_2nd ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Condition</p>
                                                                <p class="">{{$item->condition}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tag</p>
                                                                <p class="">{{$item->tag}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->trial_follow_up ?? 'N/A'}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->trial_about, 40) ?? 'N/A' }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->trial_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Confirm Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Confirm Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->confirm_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Tutoring Start Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->tutoring_start_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">payment Date</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->payment_date)) ?? 'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Salary</p>
                                                                <p class="">{{$item->tution_salary ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Job Duration</p>
                                                                <p class="">{{$item->duration ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Percentage | Charge</p>
                                                                <p class="">{{$item->percentage ?? 'N/A'}} |
                                                                    {{$item->charge ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->confirm_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->confirm_about, 10) }}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->confirm_about}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Repost Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Repost Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->repost_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->repost_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->repost_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->repost_about ?? 'N/A'}}">
                                                                        •••
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="bg-white py-4 shadow-lg rounded-3">
                                                        <h5 class="mb-5 ms-4">Closed Stage</h5>
                                                        <div class="">
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">current Stage</p>
                                                                <p class="">{{$item->current_stage}}</p>
                                                            </div>

                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Closed Stage From</p>
                                                                <p class="">
                                                                    {{date('d-m-Y', strtotime($item->closed_date)) ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Follow Up</p>
                                                                <p class="">{{$item->closed_follow_up ?? 'N/A'}}</p>
                                                            </div>
                                                            <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                <p class="fw-semibold">Stage About</p>
                                                                <p class="">
                                                                    {{ Str::limit($item->closed_about, 40) ?? 'N/A'}}
                                                                    <button tabindex="0" style="border: none"
                                                                        class="badge rounded-pill text-gray-700 ms-1" role="button"
                                                                        data-bs-toggle="popover" data-bs-trigger="focus"
                                                                        title="Details Address"
                                                                        data-bs-content="{{$item->closed_about ?? 'N/A'}}">

                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    application all note

                                                </div>
                                            </div> --}}
                                            <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                                onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                All Notes
                                            </button>
                                        </div>
                                        @endif

                                        @if($item->repost_date !== null)
                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Repost</p>

                                                    <p class="m-0 text-muted fs-12">
                                                        {{ \Carbon\Carbon::parse($item->repost_date)->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Dtae & Time
                                                            </p>

                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->repost_date)->format('h:i a') }}
                                                                {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}


                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>

                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_repost_old">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse_repost_old" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row justify-content-end">
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Noted</p>

                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Repost About
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    {{ $item->repost_about }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                                onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                All Notes
                                            </button>
                                        </div>
                                        @endif

                                        @if($item->closed_date !== null)
                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Closed</p>

                                                    <p class="m-0 text-muted fs-12">

                                                        {{ \Carbon\Carbon::parse($item->closed_date)->format('d/m/Y') }}


                                                    </p>

                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Time
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->closed_date)->format('h:i a') }}
                                                                {{-- {{ \Carbon\Carbon::parse($item->payment_date)->format('h:i a') }} --}}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">



                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_old_closed">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse_old_closed" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row justify-content-end">
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Noted</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Closed Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    {{ $item->closed_about }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                                onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                All Notes
                                            </button>
                                        </div>
                                        @endif

                                        @if ($item->confirm_date !== null)
                                        <div class="" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row p-3 my-4 bg-white rounded-3">
                                                <div class="col-lg-2 col-10 pt-5">
                                                    <p class="fw-semibold fs-14 mb-2">Move To
                                                        Confirm</p>

                                                    <p class="m-0 text-muted fs-12">
                                                        {{ \Carbon\Carbon::parse($item->confirm_date)->format('d/m/Y') }}

                                                    </p>
                                                    <p class="m-0 text-muted fs-12">


                                                    </p>
                                                </div>
                                                <div
                                                    class="col-lg-1 col-2 d-flex flex-column justify-content-center align-items-center px-0">
                                                    <div class="bg-gray-500 flex-grow-1" style="width: 1px"></div>
                                                    <span style="margin-top: -10px" class="text-gray-500">●</span>

                                                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                                                </div>
                                                <div class="col-lg-9 col-12">
                                                    {{-- <div class="mt-4 mt-lg-0">
                                                        <p class="fw-500 fs-14 mb-1">Meeting Note</p>
                                                        <p class="m-0 text-muted fs-12">
                                                            {{ $item->meeting_about }}
                                                        </p>
                                                    </div> --}}
                                                    <div class="row row-cols-lg-6 row-cols-3 rw-cols-md-4 gap-3 gap-lg-0 mt-3">
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Time
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->confirm_date)->format('h:i a') }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Notify</p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                ??
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Condition</p>
                                                            <p class="m-0 text-muted fs-12">{{ $item->condition }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1">Tag</p>
                                                            <p class="m-0 text-muted fs-12">
                                                                {!! Str::limit($item->tag, 10, ' ...') !!}</p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-500 fs-12 mb-1 text-nowrap">
                                                                Follow Up
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">
                                                                {{ \Carbon\Carbon::parse($item->confirm_follow_up)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center col-12 col-lg-2">
                                                            <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_old_confirm">
                                                                <i class="bi bi-chevron-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse_old_confirm" style="padding-left: 12px; padding-right: 12px">
                                            <div class="row justify-content-end">
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">Noted</p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    Confirm Note
                                                                </p>
                                                                <p class="m-0 text-muted fs-12">
                                                                    {{ $item->confirm_about }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Tutoring Stat
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">

                                                            </p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Date</p>
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    {{ \Carbon\Carbon::parse($item->tutoring_start_date)->format('d/m/Y') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Tutoring Salary
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">

                                                            </p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Salary</p>
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    {{$item->tuition_salary}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Payment Date
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">

                                                            </p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Date</p>
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    {{$item->payment_date}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 p-3 rounded-2 mb-3" style="background-color: #f6f6f6">
                                                    <div class="row">
                                                        <div class="col-10 col-md-2">
                                                            <p class="fw-semibold fs-14 mb-2">
                                                                Charge
                                                            </p>
                                                            <p class="m-0 text-muted fs-12 text-nowrap">

                                                            </p>
                                                        </div>
                                                        <div
                                                            class="col-2 col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                            <div class="bg-info flex-grow-1" style="width: 2px"></div>

                                                            <div style="margin-top: -4px">
                                                                <i class="bi bi-check-square-fill text-info"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Charge</p>
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    {{$item->charge}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8 d-flex gap-4 pt-2">
                                                            <div>
                                                                <p class="fw-500 fs-14 mb-1">Percentage</p>
                                                                <p class="fw-500 fs-14 mb-1">
                                                                    {{$item->percentage}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary" id="{{ $item->id }}"
                                                onclick="btnNote(this.id)" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                All Notes
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>


                            @endforeach
                    <!-- collaps content here  -->

                </div>


            </div>






            <div class="tab-pane fade" id="pills-jobdetails" role="tabpanel" aria-labelledby="pills-jobdetails-tab"
                tabindex="0">
                <!-- this is job details tab -->
                <div class="d-flex justify-content-between align-items-center bg-white rounded-3 p-3 mb-4">
                    <div class="d-flex flex-wrap gap-4 gap-lg-0">
                        <div class="px-3 py-0" style="border-right: 1px solid #666">
                            <p class="m-0">
                                ID : <span class="text-gray-600">{{ $application->job_offer_id }}</span>
                            </p>
                        </div>
                        <div class="px-3 py-0" style="border-right: 1px solid #666">
                            <p class="m-0">
                                Hiring Dtae :
                                <span class="text-gray-600">{{ $application->jobOffer->date }}</span>
                            </p>
                        </div>
                        <div class="px-3 py-0" style="border-right: 1px solid #666">
                            <p class="m-0">
                                Receive Date :
                                <span class="text-gray-600">10-20am, 20 Feb, 2023</span>
                            </p>
                        </div>
                        <div class="px-3 py-0">
                            <p class="m-0">
                                Receive By :
                                <span class="text-gray-600">{{ $application->jobOffer->user->name }}</span>
                            </p>
                        </div>
                    </div>
                    <button class="btn shadow-none py-0 px-2">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </button>
                </div>
                <div class="" style="padding-left: 12px; padding-right: 12px">
                    <div class="bg-white rounded-3 px-4 pt-4 pb-2 row mb-4">
                        <div class="border-lg-end border-1 pe-xl-5 col-12 col-lg-6">

                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Salary :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->jobOffer->salary }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Name :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->jobOffer->student_name }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Gender :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->jobOffer->student_gender }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Birthday :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">20 Jan 2020</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Age :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">20</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Institute :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->jobOffer->institute_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Category :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->jobOffer->category->name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Class :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->jobOffer->course->name }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Subjects :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="">



                                        @foreach ($application->jobOffer->job_offer_student_subjects as $subject)
                                        {{ $subject->subject->title ?? ''}}
                                        @endforeach


                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3 px-4 pt-4 pb-2 row row-cols-1 row-cols-lg-2 mb-4">
                        <div class="">
                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Teach on :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->job_offer->teachingMethod->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Days :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->job_offer->days_in_week }} Days
                                    </p>
                                </div>
                            </div>

                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Tutoring Time :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->job_offer->tutoring_time }}</p>
                                </div>
                            </div>

                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">T Duration :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->job_offer->tutoring_duration }}
                                    </p>
                                </div>
                            </div>

                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Total Students :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->job_offer->number_of_students }}
                                    </p>
                                </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Job Duration :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">Continue</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-3 px-4 pt-4 pb-2 row row-cols-1 row-cols-lg-2 mb-4">
                        <div class="">
                            <div class="row">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Tutor Gender :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->job_offer->tutor_gender }} Tutor
                                        Needed</p>
                                </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">University :</p>
                                </div>
                                <div class="col-xl-8 col-6">


                                    <p class="text-nowrap">
                                        @foreach ($application->job_offer->job_offer_tutor_universities as $university)
                                        {{ $university->title ?? 'N/A' }},&nbsp;
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Department :</p>
                                </div>
                                <div class="col-xl-8 col-6">

                                    <p class="">
                                        @foreach ($application->job_offer->job_offer_tutor_departments as $department)
                                        {{ $department->title ?? 'N/A' }},&nbsp;&nbsp;
                                        @endforeach
                                    </p>
                                    {{-- <p class="text-nowrap">Marketing</p> --}}
                                </div>
                            </div>

                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Background :</p>
                                </div>
                                <div class="col-xl-8 col-6">

                                    <p class="">
                                        @foreach ($application->job_offer->job_offer_tutor_study_types as $studyType)
                                        {{ $studyType->title ?? 'N/A' }},&nbsp;&nbsp;
                                        @endforeach
                                    </p>
                                    {{-- <p class="text-nowrap">Science</p> --}}
                                </div>
                            </div>
                            <div class="row row-cols-2">
                                <div class="col-xl-4 col-6">
                                    <p class="fw-500">Other Requierment :</p>
                                </div>
                                <div class="col-xl-8 col-6">
                                    <p class="text-nowrap">{{ $application->job_offer->tutor_requirement }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-4 mt-4 bg-white rounded-3" style="padding-left: 38px; padding-right: 38px">
                    <div></div>
                    <p class="fw-500 fs-5">Location</p>
                    <div class="rounded-3 pt-4 pt-lg-5 pb-2 border px-lg-5 px-3 mt-4">
                        <div class="mb-4 row row-cols-lg-3 row-cols-2">
                            <div class="mb-3 mb-lg-4">
                                <p class="fw-500 mb-1">City</p>
                                <p class="m-0">{{ $application->job_offer->city->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3 mb-lg-4">
                                <p class="fw-500 mb-1">Location</p>
                                <p class="m-0">{{ $application->job_offer->location->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3 mb-lg-4">
                                <p class="fw-500 mb-1 text-nowrap">
                                    Details Address
                                </p>
                                <p class="m-0">{{ $application->job_offer->full_address }}</p>
                            </div>
                            <div class="mb-3 mb-lg-4">
                                <p class="fw-500 mb-1">Flat/House</p>
                                <p class="m-0">7a</p>
                            </div>
                            <div class="mb-3 mb-lg-4">
                                <p class="fw-500 mb-1">Road</p>
                                <p class="m-0">11</p>
                            </div>
                            <div class="mb-3 mb-lg-4">
                                <p class="fw-500 mb-1">Area</p>
                                <p class="m-0">tolarbagh</p>
                            </div>
                        </div>
                        <div>
                            <!-- google map placeholder image -->
                            <img src="/images/map.png" alt="map" class="rounded-3" width="100%" height="250px"
                                style="object-fit: cover" />
                            <p class="text-end mt-2">
                                Mohammadpur, Dhaka, Bangladesh
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-3 mt-4" style="background-color: #f6f6f6">
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing
                        elit. Non odio veniam, neque nihil doloribus
                        consequuntur numquam assumenda error asperiores,
                        expedita sunt? Sint nesciunt asperiores dolor magnam
                        labore, doloremque laudantium non!
                    </p>
                    <p class="py-3 m-0 fs-12">Feb 5, 2023 at 2:20 AM</p>
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                        <div class="fw-semibold">
                            <p class="m-0 text-nowrap fs-14">Kazi Polash</p>
                            <p class="m-0 fw-light text-nowrap fs-12">
                                Sales Manager
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="fw-500 fs-5">Staff Note</p>
                    <textarea name="" rows="5" class="form-control shadow-none rounded-3"
                        placeholder="Enter a description..."></textarea>
                    <button class="btn btn-primary mt-3 rounded-3">
                        Create
                    </button>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-tutordetails" role="tabpanel" aria-labelledby="pills-tutordetails-tab"
                tabindex="0">
                <!-- this is job tutor details tab -->
                <div class="bg-white p-4 rounded-3">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Education Information
                    </p>




                    @foreach ($application->tutor->tutor_education ?? [] as $tutor_edu)
                    <div class="mb-4 px-4">
                        <p class="fw-500">{{ $tutor_edu->degree_name ?? 'N/A' }}</p>
                        <div class="px-4 row row-cols-1 row-cols-md-2">
                            <div>
                                <p class="fw-500 fs-14 mb-2">
                                    Exam Title :
                                    <span class="text-gray-600 fw-light">{{ $tutor_edu->degree_name ?? 'N/A' }}</span>
                                </p>
                                <p class="fw-500 fs-14 mb-2">
                                    Group :
                                    <span
                                        class="text-gray-600 fw-light">{{ $tutor_edu->group_or_major ?? 'N/A' }}</span>
                                </p>
                                <p class="fw-500 fs-14 mb-2">
                                    Institute :
                                    <span
                                        class="text-gray-600 fw-light">{{ $tutor_edu->institutes->title ?? 'N/A' }}</span>
                                </p>
                                <p class="fw-500 fs-14 mb-2">
                                    Board :
                                    <span class="text-gray-600 fw-light">{{ $tutor_edu->education_board }}</span>
                                </p>
                            </div>
                            <div>
                                <p class="fw-500 fs-14 mb-2">
                                    Result :
                                    <span class="text-gray-600 fw-light">{{ $tutor_edu->gpa ?? 'N/A' }}</span>
                                </p>
                                <p class="fw-500 fs-14 mb-2">
                                    Curriculum :
                                    <span
                                        class="text-gray-600 fw-light">{{ $tutor_edu->curriculam->title ?? 'N/A' }}</span>
                                </p>
                                <p class="fw-500 fs-14 mb-2">
                                    Passing Year :
                                    <span class="text-gray-600 fw-light">
                                        {{ $tutor_edu->passing_year ?? 'N/A' }}</span>
                                </p>
                                <p class="fw-500 fs-14 mb-2">
                                    Current Institute :
                                    <span class="text-gray-600 fw-light">No</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>





                <div class="bg-white p-4 rounded-3 mb-4 mt-4">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Tutoring Information
                    </p>
                    <div class="px-4">
                        <p class="fw-500 fs-14 mb-2">
                            Preferred Categories :


                            @foreach ($application->tutor->tutor_categories ?? [] as $category)
                            <span class="badge badge-success">{{ $category->name }}</span>
                            @endforeach


                            {{-- <span class="text-gray-600 fw-light"
                      >Bangla Medium, English Medium, Religious
                      Studies</span
                    > --}}
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Preferred Classes :


                            @foreach ($application->tutor->tutor_course ?? [] as $course)
                            <span class="badge badge-success">{{ $course->name }}</span>
                            @endforeach

                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Preferred Subjects :


                            @foreach ($application->tutor->tutor_subject ?? [] as $subject)
                            <span class="badge badge-success">{{ $subject->title ?? 'N/A' }}</span>
                            @endforeach
                            {{-- <span class="text-gray-600 fw-light"
                      >Bangla, English, General Maths, Religious Studies,
                      General Science, Bangla, General Maths, General
                      Science, Religious Studies</span> --}}

                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Tutoring Location :

                            @foreach ($application->tutor->tutor_prefered_locations ?? [] as $location)
                            <span class="badge badge-success">{{ $location->name }}</span>
                            @endforeach

                            {{-- <span class="text-gray-600 fw-light"
                      >Mohammadpur,Dhanmondi,ghulshan,Mirpur-1,Kollanpur</span
                    > --}}
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Availability :
                            @foreach ($application->tutor->tutor_days ?? [] as $day)
                            <span class="badge badge-success">{{ $day->title }}</span>
                            @endforeach
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Place of Tutoring :


                            @foreach ($application->tutor->teaching_method ?? [] as $teaching_method)
                            <span class="badge badge-success">{{ $teaching_method->name }}</span>
                            @endforeach


                            {{-- <span class="text-danger fw-light">Not Given</span> --}}
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Expected Salary Monthly :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->expected_salary }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Expected Salary Per Hour :
                            <span class="text-gray-600 fw-light">250 Taka</span>
                        </p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-3 mb-4">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Parents Information
                    </p>
                    <div class="px-4">
                        <p class="fw-500 fs-14 mb-2">
                            Father's Name :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->fathers_name }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Father's Number :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->fathers_phone }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Mother's Name :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->mothers_name }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Mother's Number :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->mothers_phone }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Emergency Contact Person Name :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->emergency_name }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Number :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->emergency_phone }}</span>
                        </p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-3 mb-4 mt-4">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Location
                    </p>
                    <div class="px-4">
                        <p class="fw-500 fs-14 mb-2">
                            Present Address :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->full_address ?? 'N/A' }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Permanent Address :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->permanent_full_address ?? 'N/A' }}</span>
                        </p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-3 mb-4 mt-4">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Personal Information
                    </p>
                    <div class="px-4">
                        <p class="fw-500 fs-14 mb-2">
                            Additional Contact number :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->emergency_phone ?? 'N/A' }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Date of Birth :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->date_of_birth ?? 'N/A' }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Birth Certificate No :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->nid_number ?? 'N/A' }}</span>
                        </p>
                        <p class="fw-500 fs-14 mb-2">
                            Religion :
                            <span
                                class="text-gray-600 fw-light">{{ @$application->tutor->tutor_personal_info->religion ?? 'N/A' }}</span>
                        </p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-3 mb-4 mt-4">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Availability
                    </p>
                    <div class="">
                        <div class="table-responsive">
                            <table class="table shadow-none bg-white" style="width: 100%">
                                <colgroup>
                                    <col span="1" style="width: 35%" />
                                    <col span="1" style="width: 10%" />
                                    <col span="1" style="width: 10%" />
                                    <col span="1" style="width: 10%" />
                                    <col span="1" style="width: 35%" />
                                </colgroup>
                                <thead>
                                    <tr style="background-color: #fafafa">
                                        <th scope="col" class="text-end fw-bold">

                                            <p class="me-5 mb-0">দিন</p>
                                        </th>
                                        <th scope="col" class="fw-bold">সকাল</th>
                                        <th scope="col" class="fw-bold">দুপুর</th>
                                        <th scope="col" class="fw-bold">বিকাল</th>
                                        <th scope="col" class="fw-bold">সন্ধা</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid #dee2e6">
                                        <th scope="row" class="text-end">
                                            <p class="me-5">শনি</p>
                                        </th>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" checked />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6">
                                        <th scope="row" class="text-end">
                                            <p class="me-5">রবি</p>
                                        </th>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6">
                                        <th scope="row" class="text-end">
                                            <p class="me-5">সোম</p>
                                        </th>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6">
                                        <th scope="row" class="text-end">
                                            <p class="me-5">মঙ্গল</p>
                                        </th>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" checked value="" />
                                        </td>
                                        <td class="text-info">
                                            <input style="transform: scale(1.5)" class="form-check-input" checked
                                                type="checkbox" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6">
                                        <th scope="row" class="text-end">
                                            <p class="me-5">বুধ</p>
                                        </th>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" checked type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6">
                                        <th scope="row" class="text-end">
                                            <p class="me-5">বৃহস্পতি</p>
                                        </th>
                                        <td class="text-info">
                                            <input class="form-check-input" checked type="checkbox"
                                                style="transform: scale(1.5)" value="" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" checked />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" checked />
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6">
                                        <th scope="row" class="text-end">
                                            <p class="me-5">শুক্র</p>
                                        </th>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value="" checked
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" checked type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                        <td class="text-info">
                                            <input class="form-check-input" type="checkbox" value=""
                                                style="transform: scale(1.5)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-3 mb-4 mt-4">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Experience
                    </p>
                    <div class="border rounded-3 p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="m-0 fw-500">Tutoring Experience</p>
                            <div>
                                <button class="btn btn-light px-2 py-0">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                <button class="btn btn-light px-2 py-0">
                                    <i class="bi bi-pen"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-4">
                            <div>
                                <p class="m-0 fs-14">Category : Bangla Medium</p>
                                <p class="m-0 fs-14">Class : Class 10</p>
                            </div>
                            <div>
                                <p class="m-0 fs-14">Form : 5 Feb, 2023</p>
                                <p class="m-0 fs-14">To : 5 Feb, 2023</p>
                            </div>
                            <div>
                                <p class="m-0 fs-14">
                                    নিজের একটা গাড়ি থাকলে, জীবনটা হয় সহজ ও আরামদায়ক
                                    ...
                                </p>
                            </div>
                            <div class="d-flex justify-content-start gap-1 align-items-center">
                                <i class="bi bi-geo-alt-fill text-primary fs-5 me-1"></i>
                                <p class="m-0 fs-14">Mohammadpur, Dhaka</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rounded-3 mb-4 mt-4">
                    <p class="fs-5 fw-500 border-bottom border-1 pb-2">
                        Documents
                    </p>
                    <div style="margin-left: 13px; margin-right: 13px">
                        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 gap-4">
                            <div class="shadow-lg rounded-3 bg-white p-3">
                                <img src="/images/doc.png" alt="" class="rounded-3 border " width="100%" height="160px"
                                    style="
                          object-fit: cover;
                          filter: contrast(0.5);
                          filter: sepia(0.4);
                        " />
                                <p class="m-0 mt-2 fs-14">
                                    SSC/ O Level Marksheets/ Certificate
                                </p>
                            </div>
                            <div class="shadow-lg rounded-3 bg-white p-3">
                                <img src="/images/doc.png" alt="" class="rounded-3 border " width="100%" height="160px"
                                    style="
                          object-fit: cover;
                          filter: contrast(0.5);
                          filter: sepia(0.4);
                        " />
                                <p class="m-0 mt-2 fs-14">
                                    SSC/ O Level Marksheets/ Certificate
                                </p>
                            </div>
                            <div class="shadow-lg rounded-3 bg-white p-3">
                                <img src="/images/doc.png" alt="" class="rounded-3 border " width="100%" height="160px"
                                    style="
                          object-fit: cover;
                          filter: contrast(0.5);
                          filter: sepia(0.4);
                        " />
                                <p class="m-0 mt-2 fs-14">
                                    SSC/ O Level Marksheets/ Certificate
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-condition" role="tabpanel" aria-labelledby="pills-condition-tab"
                tabindex="0">
                <!-- this is job condition tab -->
                <div class="" style="padding-left: 12px; padding-right: 12px">
                    <div>
                        <div class="row bg-white rounded-3 p-3 gap-4 justify-content-start align-items-center mb-2">
                            <div class="d-flex justify-content-start align-items-center col col-lg-1 col-md-1"
                                style="width: fit-content">
                                <i class="bi bi-2-square-fill fs-3 text-primary"></i>
                            </div>

                            <div class="d-flex justify-content-center align-items-center col-lg-1 col-md-2">
                                <p class="m-0 text-gray-600">123</p>
                            </div>

                            <div class="d-flex justify-content-center align-items-center gap-3 col-lg-3 col-md-3">
                                <img height="45" width="45" class="rounded-3" src="/images/avatar.svg" alt="" />
                                <div class="fw-semibold">
                                    <p class="m-0 text-nowrap">
                                        {{Auth::user()->name}}
                                        <span>
                                            <i class="bi bi-check-circle-fill text-info" style="font-size: 0.8rem"></i>
                                        </span>
                                    </p>
                                    <p class="m-0 fw-light text-nowrap fs-14">
                                        University of Dhaka
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                <div class="fw-semibold">
                                    <p class="m-0 text-nowrap fs-14">Rubel</p>
                                    <p class="m-0 fw-light text-nowrap fs-12">
                                        Sales Manager
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center col-lg-2 col-md-1">
                                <p class="m-0 text-info">Meeting</p>
                            </div>

                            <div class="d-flex justify-content-between gap-4 col-lg-2 g-0">
                                <div class="d-flex justify-content-start align-items-start flex-column">
                                    <p class="m-0 text-muted fs-14 text-nowrap">
                                        Sep 21, 2023
                                    </p>

                                    <p class="m-0 text-muted fs-12 text-nowrap">
                                        12: 30 am
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                        data-bs-target="#somecollapsid">
                                        <i class="bi bi-chevron-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row bg-white rounded-3 p-3 gap-4 justify-content-start align-items-center mb-2">
                            <div class="d-flex justify-content-start align-items-center col col-lg-1 col-md-1"
                                style="width: fit-content">
                                <i class="bi bi-1-square-fill fs-3 text-primary"></i>
                            </div>

                            <div class="d-flex justify-content-center align-items-center col-lg-1 col-md-2">
                                <p class="m-0 text-gray-600">123</p>
                            </div>

                            <div class="d-flex justify-content-center align-items-center gap-3 col-lg-3 col-md-3">
                                <img height="45" width="45" class="rounded-3" src="/images/avatar.svg" alt="" />
                                <div class="fw-semibold">
                                    <p class="m-0 text-nowrap">
                                        Sujon Islam
                                        <span>
                                            <i class="bi bi-check-circle-fill text-info" style="font-size: 0.8rem"></i>
                                        </span>
                                    </p>
                                    <p class="m-0 fw-light text-nowrap fs-14">
                                        University of Dhaka
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                <div class="fw-semibold">
                                    <p class="m-0 text-nowrap fs-14">Rubel</p>
                                    <p class="m-0 fw-light text-nowrap fs-12">
                                        Sales Manager
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center col-lg-2 col-md-1">
                                <p class="m-0 text-info">Meeting</p>
                            </div>

                            <div class="d-flex justify-content-between gap-4 col-lg-2 g-0">
                                <div class="d-flex justify-content-start align-items-start flex-column">
                                    <p class="m-0 text-muted fs-14 text-nowrap">
                                        Sep 21, 2023
                                    </p>

                                    <p class="m-0 text-muted fs-12 text-nowrap">
                                        12: 30 am
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                        data-bs-target="#somecollapsid">
                                        <i class="bi bi-chevron-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- repost/closed -->
                    <div class="mt-4">
                        <p class="fw-500">Repost/Closed</p>
                        <div>
                            <div class="row bg-white rounded-3 p-3 gap-4 justify-content-start align-items-center mb-2">
                                <div class="d-flex justify-content-start align-items-center col col-lg-1 col-md-1"
                                    style="width: fit-content">
                                    <i class="bi bi-3-square-fill fs-3 text-danger"></i>
                                </div>

                                <div class="d-flex justify-content-center align-items-center col-lg-1 col-md-2">
                                    <p class="m-0 text-gray-600">123</p>
                                </div>

                                <div class="d-flex justify-content-center align-items-center gap-3 col-lg-3 col-md-3">
                                    <img height="45" width="45" class="rounded-3" src="/images/avatar.svg" alt="" />
                                    <div class="fw-semibold">
                                        <p class="m-0 text-nowrap">
                                            Sujon Islam
                                            <span>
                                                <i class="bi bi-check-circle-fill text-info"
                                                    style="font-size: 0.8rem"></i>
                                            </span>
                                        </p>
                                        <p class="m-0 fw-light text-nowrap fs-14">
                                            University of Dhaka
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                    <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                    <div class="fw-semibold">
                                        <p class="m-0 text-nowrap fs-14">Rubel</p>
                                        <p class="m-0 fw-light text-nowrap fs-12">
                                            Sales Manager
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-center col-lg-2 col-md-1">
                                    <p class="m-0 text-danger">Closed</p>
                                </div>

                                <div class="d-flex justify-content-between gap-4 col-lg-2 g-0">
                                    <div class="d-flex justify-content-start align-items-start flex-column">
                                        <p class="m-0 text-muted fs-14 text-nowrap">
                                            Sep 21, 2023
                                        </p>

                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                            12: 30 am
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                            data-bs-target="#somecollapsid">
                                            <i class="bi bi-chevron-expand"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row bg-white rounded-3 p-3 gap-4 justify-content-start align-items-center mb-2">
                                <div class="d-flex justify-content-start align-items-center col col-lg-1 col-md-1"
                                    style="width: fit-content">
                                    <i class="bi bi-4-square-fill fs-3 text-danger"></i>
                                </div>

                                <div class="d-flex justify-content-center align-items-center col-lg-1 col-md-2">
                                    <p class="m-0 text-gray-600">123</p>
                                </div>

                                <div class="d-flex justify-content-center align-items-center gap-3 col-lg-3 col-md-3">
                                    <img height="45" width="45" class="rounded-3" src="/images/avatar.svg" alt="" />
                                    <div class="fw-semibold">
                                        <p class="m-0 text-nowrap">
                                            Sujon Islam
                                            <span>
                                                <i class="bi bi-check-circle-fill text-info"
                                                    style="font-size: 0.8rem"></i>
                                            </span>
                                        </p>
                                        <p class="m-0 fw-light text-nowrap fs-14">
                                            University of Dhaka
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                    <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                    <div class="fw-semibold">
                                        <p class="m-0 text-nowrap fs-14">Rubel</p>
                                        <p class="m-0 fw-light text-nowrap fs-12">
                                            Sales Manager
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-center col-lg-2 col-md-1">
                                    <p class="m-0 text-danger">Closed</p>
                                </div>

                                <div class="d-flex justify-content-between gap-4 col-lg-2 g-0">
                                    <div class="d-flex justify-content-start align-items-start flex-column">
                                        <p class="m-0 text-muted fs-14 text-nowrap">
                                            Sep 21, 2023
                                        </p>

                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                            12: 30 am
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button class="btn pb-1 px-2 m-0 btn-light" data-bs-toggle="collapse"
                                            data-bs-target="#somecollapsid">
                                            <i class="bi bi-chevron-expand"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-editlog" role="tabpanel" aria-labelledby="pills-editlog-tab"
                tabindex="0">
                <!-- this is job edit log tab -->
                <div class="mb-5">
                    <div class="d-flex justify-content-start align-items-center gap-4 mb-4 flex-wrap">
                        <div class="d-flex justify-content-start align-items-center gap-4">
                            <p class="m-0 fw-500">Change on</p>
                            <div class="d-flex justify-content-start align-items-start flex-column">
                                <p class="m-0 text-muted fs-14 text-nowrap">
                                    Sep 21, 2023
                                </p>

                                <p class="m-0 text-muted fs-12 text-nowrap">
                                    12: 30 am
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start align-items-center gap-4">
                            <p class="m-0 fw-500">By</p>
                            <div class="d-flex justify-content-center align-items-center gap-3">
                                <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                <div class="fw-semibold">
                                    <p class="m-0 text-nowrap fs-14">Jot Roy</p>
                                    <p class="m-0 fw-light text-nowrap fs-12">
                                        Sales & Marketing
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table shadow-none bg-white">
                            <thead>
                                <tr style="
                          background-color: #f6f6f6;
                          border-bottom: 1px solid #dee2e6;
                        ">
                                    <th scope="col">Title</th>
                                    <th scope="col">New Vlue</th>
                                    <th scope="col">Old Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <th scope="row">Location</th>
                                    <td class="text-info">Mohammadpur, Dhaka</td>
                                    <td class="text-danger">Mirpur -1, Dhaka</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <th scope="row">Class</th>
                                    <td class="text-info">Class 10</td>
                                    <td class="text-danger">Class 9</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <th scope="row">Gender</th>
                                    <td class="text-info">Male</td>
                                    <td class="text-danger">Female</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-5">
                    <div class="d-flex justify-content-start align-items-center gap-4 mb-4 flex-wrap">
                        <div class="d-flex justify-content-start align-items-center gap-4">
                            <p class="m-0 fw-500">Change on</p>
                            <div class="d-flex justify-content-start align-items-start flex-column">
                                <p class="m-0 text-muted fs-14 text-nowrap">
                                    Sep 21, 2023
                                </p>

                                <p class="m-0 text-muted fs-12 text-nowrap">
                                    12: 30 am
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start align-items-center gap-4">
                            <p class="m-0 fw-500">By</p>
                            <div class="d-flex justify-content-center align-items-center gap-3">
                                <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                <div class="fw-semibold">
                                    <p class="m-0 text-nowrap fs-14">Jot Roy</p>
                                    <p class="m-0 fw-light text-nowrap fs-12">
                                        Sales & Marketing
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table shadow-none bg-white">
                            <thead>
                                <tr style="
                          background-color: #f6f6f6;
                          border-bottom: 1px solid #dee2e6;
                        ">
                                    <th scope="col">Title</th>
                                    <th scope="col">New Vlue</th>
                                    <th scope="col">Old Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <th scope="row">Location</th>
                                    <td class="text-info">Mohammadpur, Dhaka</td>
                                    <td class="text-danger">Mirpur -1, Dhaka</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <th scope="row">Class</th>
                                    <td class="text-info">Class 10</td>
                                    <td class="text-danger">Class 9</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <th scope="row">Gender</th>
                                    <td class="text-info">Male</td>
                                    <td class="text-danger">Female</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-assign" role="tabpanel" aria-labelledby="pills-assign-tab"
                tabindex="0">
                <!-- this is job edit assign tab -->
                <div class="table-responsive">
                    <table class="table shadow-none bg-white">
                        <thead>
                            <tr style="
                        background-color: #f6f6f6;
                        border-bottom: 1px solid #dee2e6;
                      ">
                                <th scope="col">Assign Date</th>
                                <th scope="col">Person</th>
                                <th scope="col">Tutor Given</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="
                        border-bottom: 1px solid #dee2e6;
                        vertical-align: middle;
                      ">
                                <th scope="row">
                                    <div class="d-flex justify-content-start align-items-start flex-column">
                                        <p class="m-0 text-muted fs-14 text-nowrap">
                                            Sep 21, 2023
                                        </p>

                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                            12: 30 am
                                        </p>
                                    </div>
                                </th>
                                <td class="">
                                    <div
                                        class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                        <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                        <div class="fw-semibold">
                                            <p class="m-0 text-nowrap fs-14">Rubel</p>
                                            <p class="m-0 fw-light text-nowrap fs-12">
                                                Sales Manager
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="">01</td>
                            </tr>
                            <tr style="
                        border-bottom: 1px solid #dee2e6;
                        vertical-align: middle;
                      ">
                                <th scope="row">
                                    <div class="d-flex justify-content-start align-items-start flex-column">
                                        <p class="m-0 text-muted fs-14 text-nowrap">
                                            Sep 21, 2023
                                        </p>

                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                            12: 30 am
                                        </p>
                                    </div>
                                </th>
                                <td class="">
                                    <div
                                        class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                        <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                        <div class="fw-semibold">
                                            <p class="m-0 text-nowrap fs-14">Rubel</p>
                                            <p class="m-0 fw-light text-nowrap fs-12">
                                                Sales Manager
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="">05</td>
                            </tr>
                            <tr style="
                        border-bottom: 1px solid #dee2e6;
                        vertical-align: middle;
                      ">
                                <th scope="row">
                                    <div class="d-flex justify-content-start align-items-start flex-column">
                                        <p class="m-0 text-muted fs-14 text-nowrap">
                                            Sep 21, 2023
                                        </p>

                                        <p class="m-0 text-muted fs-12 text-nowrap">
                                            12: 30 am
                                        </p>
                                    </div>
                                </th>
                                <td class="">
                                    <div
                                        class="d-flex justify-content-center align-items-center gap-3 col-lg-2 col-md-3">
                                        <img height="35" width="35" class="rounded-3" src="/images/avatar.svg" alt="" />
                                        <div class="fw-semibold">
                                            <p class="m-0 text-nowrap fs-14">Rubel</p>
                                            <p class="m-0 fw-light text-nowrap fs-12">
                                                Sales Manager
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="">02</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</main>




<!--  note model  -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
        <div class="modal-content p-2">
            <div class="modal-body py-0 mt-2">
                <div class="mb-4">

                    <form action="{{ route('admin.application.setnote') }}" id="applicationNote" method="post">
                        @csrf

                        <input type="hidden" name="note_application_id" id="note_application_id">
                        <div class="mb-3">
                            <label for="notet" class="form-label fw-500 fs-14">Note</label>
                            <textarea name="application_note" placeholder="Write your note here..."
                                class="form-control shadow-none rounded-2" id="application_note" rows="4"></textarea>

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

@include('backend.taken_offer.js.index_page_js')

<script>
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

</script>
<script>
    $(".tabsBtn").on("click", ".btn", function () {
        $(".tabsBtn .btn").removeClass("activeClass");
        $(this).addClass("activeClass");
    });

</script>


{{-- @include('backend.tutor.js.swtdeleteMethod_js') --}}

@endpush
