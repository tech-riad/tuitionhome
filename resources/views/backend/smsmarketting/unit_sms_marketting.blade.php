@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

    .form-select {
        width: 215px !important;
    }
    #loading-spinner {
    position: fixed;
    top: 50%;
    left: 50%;
    z-index: 9999;
    transform: translate(-50%, -50%);
    }

</style>

@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div id="loading-spinner" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ms-sm-auto col-lg-12" style="margin-top: 62px">
            <!-- mini nav starts here -->
            <div class="d-flex flex-wrap mb-4 mb-md-0 justify-content-between align-items-center">
                <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
                    <a class="text-decoration-none text-gray-800" href="{{route('admin.all.notice')}}">All Notice
                        Dashboard</a>
                    <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.all.popupimage')}}">All Popup Images</a>
                    <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.sms.marketting')}}">SMS
                        Marketing</a>
                    <a class="text-decoration-none text-gray-800 text-nowrap active-border" href="{{route('admin.sms.marketing.unit')}}">SMS
                        Marketing Unit</a>
                        <a class="text-decoration-none text-gray-800 text-nowrap " href="{{route('admin.popup.image')}}">Popup
                        Image</a>
                </div>
                <div class="bg-white shadow-lg rounded-3 px-3 py-2 mx-3">
                    <p class="mb-0" style="font-weight: 500">Audience : 000</p>
                </div>
            </div>
            <!-- mini nav ends here -->
            <!-- main content section starts here -->
            <!-- submit form starts here -->
            <div class="mx-3 bg-white shadow-lg p-4 rounded-3 mb-4 px-lg-5 py-lg-4">
                <div class="py-4">
                    <form id="smsForm" method="POST">
                        @csrf
                        <input type="hidden" name="send_now" id="sendNow">
                        <input type="hidden" name="recurring" id="recurring">
                        <input type="hidden" name="send_later_time" id="sendLaterTime">

                        <div class="mb-4">
                            <label class="mb-2" style="font-weight: 500">SMS Title</label>
                            <input id="title" name="title" class="form-control rounded-2 shadow-none py-3" placeholder="Maximum 30 Character" />
                        </div>

                        <div class="mb-4">
                            <label class="mb-2" style="font-weight: 500">Add Numbers</label>
                            <textarea name="numbers" id="numbers" placeholder="Add numbers (separated by comma or newline)" class="form-control rounded-2 shadow-none" style="min-height: 100px"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label required">SMS Body</label>
                            <textarea name="sms_body" class="form-control" placeholder="SMS Body" id="description" style="overflow-y: scroll; height: 195px;"></textarea>
                            <span class="text-danger error-text description_error"></span>
                        </div>

                        <div id="char-left-message" class="text-danger"></div>
                        <div>
                            <div id="char">0/320</div>
                            <div>Remaining: <span id="rem">320</span></div>
                            <div>Message: <span id="msg">0</span></div>
                        </div>

                        <div class="d-flex justify-content-end gap-4">
                            <button type="button" class="btn btn-primary" id="sendNowBtn">Send Now</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendModal">Send Later</button>
                        </div>

                        <!-- Send Later Modal -->
                        <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <label>Select Time</label>
                                        <input type="datetime-local" class="form-control" id="sendLaterInput">
                                        <div class="mt-3">
                                            <label for="sendRecurringInput" class="form-label text-dark text-sm">Recurring</label>
                                            <select id="sendRecurringInput" class="shadow rounded-2 form-select">
                                                <option value="">Select</option>
                                                <option value="3">3 Days</option>
                                                <option value="7">7 Days</option>
                                                <option value="15">15 Days</option>
                                                <option value="30">1 Month</option>
                                                <option value="60">2 Months</option>
                                                <option value="90">3 Months</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-primary" id="sendLaterBtn">Save & Send Later</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Optional: Spinner -->
                    <div id="loading-spinner" style="display: none;">Loading...</div>

                </div>
            </div>
            <!-- submit form ends here -->
            <!-- table starts here -->
            <div class="ps-3" style="padding-right: 13px">
                <div
                    class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
                    <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-sliders2 me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-ndark">Send Bulk SMS</button>
                    </div>
                    <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                        <input type="text" class="form-control rounded shadow-none" placeholder="Search" />
                        <select class="form-select rounded shadow-none" style="width: 100px">
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
                            <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                                <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                    <tr>
                                        <th scope="col" class="text-nowrap">
                                            <input class="form-check-input me-2" type="checkbox"
                                                id="flexCheckDefault" />#SL
                                        </th>
                                        <th scope="col" class="text-nowrap">Date</th>
                                        <th scope="col" class="text-nowrap">User</th>
                                        <th scope="col" class="text-nowrap">Title</th>
                                        <th scope="col" class="text-nowrap">Audience</th>
                                        <th scope="col" class="text-nowrap">Status</th>
                                        <th scope="col" class="text-nowrap">
                                            Recurring Loop
                                        </th>
                                        <th scope="col" class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($smsMarketing as $item)
                                        <tr class="align-middle">
                                            <td scope="row" class="text-nowrap">
                                                <input class="form-check-input me-2" type="checkbox"
                                                    id="flexCheckDefault" />
                                                    {{$loop->iteration}}
                                            </td>
                                            <td class="">
                                                <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                                    data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                    {{$item->created_at}}
                                                </a>
                                            </td>
                                            <td>{{$item->user_type}}</td>
                                            <td class="text-truncate" style="max-width: 200px;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->title }}">
                                                {{ Str::limit($item->title, 20, '...') }}
                                            </td>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                                    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                                        return new bootstrap.Tooltip(tooltipTriggerEl);
                                                    });
                                                });
                                            </script>
                                            <td class="text-nowrap text-info">{{$item->updated_audience}}</td>

                                            @if (!is_null($item->send_latter) && \Carbon\Carbon::parse($item->send_latter)->gt(now()))
                                            <td class="text-nowrap text-warning" data-bs-toggle="modal"
                                                data-bs-target="#pendingDateTimeModal_{{$item->id}}" style="cursor: pointer">
                                                Pending
                                            </td>
                                            @else
                                            <td>
                                                <div class="switch-toggle">
                                                    <div class="button-check" id="button-check" data-id="{{$item->id}}"
                                                        onclick="liveChange({{$item->id}})">
                                                        <input type="checkbox" class="checkbox" @if($item->status == 1) checked @endif
                                                        />
                                                        <span class="switch-btn"></span>
                                                        <span class="layer"></span>
                                                    </div>
                                                </div>
                                            </td>


                                            @endif
                                            <td>{{ $item->recurring ? $item->recurring . ' days' : 'n/a' }}</td>

                                            <td class="">
                                                <div class="d-flex gap-4">
                                                    <a href="javascript:void(0);" class="btn btn-pink rounded-3 deletePopup" data-id="{{ $item->id }}">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="pendingDateTimeModal_{{$item->id}}" tabindex="-1" aria-labelledby="pendingDateTimeModalLabel_{{$item->id}}"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                                                <div class="modal-content">
                                                    <div class="modal-body pt-5 pb-4">
                                                        <p class="text-center text-warning fs-3">
                                                            {{ $item->send_latter ? \Carbon\Carbon::parse($item->send_latter)->format('Y-m-d') : '' }}
                                                        </p>
                                                        <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                                            {{ $item->send_latter ? \Carbon\Carbon::parse($item->send_latter)->format('h:i A') : '' }}
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
                            {{$smsMarketing->links()}}
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
            <!-- Pending Date time model starts here-->
            <div class="modal fade" id="pendingDateTimeModal" tabindex="-1" aria-labelledby="pendingDateTimeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                    <div class="modal-content">
                        <div class="modal-body pt-5 pb-4">
                            <p class="text-center text-warning fs-3">01 Aug 2023</p>
                            <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                03:30 PM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Date time model ends here-->
            <!-- Filter model starts here -->
            <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-slide-right" style="max-width: 650px">
                    <div class="modal-content pb-4 pt-3">
                        <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                            <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-0" style="padding-left: 40px">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label for="datef" class="form-label text-dark text-sm">Date from</label>
                                            <div class="">
                                                <input type="date" class="form-control shadow rounded-2" id="datef" />
                                            </div>
                                        </div>
                                        <div class="pb-3">
                                            <label for="datet" class="form-label text-dark text-sm">Date To</label>
                                            <input type="date" class="form-control shadow rounded-2" id="datet" />
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Start Date</label>
                                            <input type="date" class="form-control shadow rounded-2" />
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label for="gndr" class="form-label text-dark text-sm">User</label>

                                            <select id="gndr" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="Tutor">Tutor</option>
                                                <option value="Option 1">Option 1</option>
                                                <option value="Option 2">Option 2</option>
                                                <option value="Option 3">Option 3</option>
                                                <option value="Option 4">Option 4</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="src" class="form-label text-dark text-sm">Status</label>

                                            <select id="src" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="On">On</option>
                                                <option value="Option 1">Option 1</option>
                                                <option value="Option 2">Option 2</option>
                                                <option value="Option 3">Option 3</option>
                                                <option value="Option 4">Option 4</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="gndr" class="form-label text-dark text-sm">Recurring
                                                Loop</label>

                                            <select id="gndr" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="">15 Days</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end align-items-center"
                            style="padding-right: 27px">
                            <div class="pe-2 d-flex gap-3">
                                <button type="button" class="btn btn-pink">Clear</button>
                                <button type="button" class="btn btn-primary">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filter Model ends here -->

            <!-- main content section ends here -->
        </div>
    </div>
</div>


@endsection
@push('page_scripts')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@include('backend.smsmarketting.js.unit_smsjs');

@endpush
