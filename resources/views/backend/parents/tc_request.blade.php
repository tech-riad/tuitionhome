@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')

<main class="">
    <div class="col-md-12 ms-sm-auto col-lg-12 px-3" style="margin-top: 62px">
        <!-- tab like button group (it should be tab) -->
        <div class="pt-4 row row-cols-2">
            <div>
                <a href="{{route('admin.view.parent',$id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid #669ad1;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">View</a>
            </div>
            <div>
                <a href="{{route('admin.edit.parent',$id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid white;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">Edit</a>
            </div>
        </div>
        <!-- tab like button group ends -->
        <!-- mini nav starts here -->
        <div class="d-flex gap-4 flex-wrap flex-column flex-md-row py-4 align-items-center">
            <a class="text-decoration-none text-gray-800  text-nowrap" href="{{route('admin.view.parent',$id)}}">About
                Me</a>
            <a class="text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.view.parent',$id)}}">Dashboard
                Details</a>

            <a class="text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.parent.posted.job',$id)}}">Posted
                Jobs</a>
            <a class="text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.parent.job.status',$id)}}">Status</a>
            <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.parent.basic.log',$id)}}">Basic Log</a>
            <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.parent.advance.log',$id)}}">Advance Log</a>
            <a class="btn btn-outline-gdark text-decoration-none active-border text-gray-800 text-nowrap"
                href="{{route('admin.parent.category.request.status',$id)}}">T & C Request</a>
        </div>
        <!-- mini nav ends here -->

        <!-- contents starts here -->
        <div class="font-pop">
            <div
                class="mt-4 d-flex flex-wrap flex-xl-nowrap justify-content-between align-items-center flex-column flex-lg-row gap-2 gap-lg-0">
                <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bi bi-sliders2 me-1"></i>Filter
                    </button>
                    <button class="btn btn-outline-dark">Send Bulk SMS</button>
                </div>
                <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                    <input type="text" class="form-control rounded shadow-none" placeholder="Search..." />
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
            <div class="">
                <div class="">
                    <div class="table-responsive mt-4">
                        <table class="rounded-2 table table-sm shadow-lg bg-white">
                            <thead class="text-dark" style="border-bottom: 1px solid #c2cbd7">
                                <tr>
                                    <th scope="col" class="text-nowrap ps-3">
                                        <div class="form-check" style="margin-bottom: -2px">
                                            <input class="form-check-input" type="checkbox" id="#SL" />
                                            <label class="form-check-label" for="#SL">
                                                #SL
                                            </label>
                                        </div>
                                    </th>
                                    <th scope="col" class="text-nowrap">Date</th>
                                    <th scope="col" class="text-nowrap">Request Type</th>
                                    <th scope="col" class="text-nowrap">Request Title</th>
                                    <th scope="col" class="text-nowrap">ID</th>
                                    <th scope="col" class="text-nowrap">Status</th>
                                    <th scope="col" class="text-nowrap">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tutorHireRequests as $item)
                                <tr class="align-middle" style="border-bottom: 10px solid #f9f9f9">
                                    <td scope="row" class="text-start text-nowrap ps-3 py-4">
                                        <div class="form-check" style="margin-bottom: -2px">
                                            <input class="form-check-input" type="checkbox"
                                                id="{{ $loop->iteration }}" />
                                            <label class="form-check-label" for="{{ $loop->iteration }}">
                                                {{ $loop->iteration }}
                                            </label>
                                        </div>
                                    </td>
                                    <td class="">
                                        <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                            data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                            {{$item->created_at ?? ''}}
                                        </a>
                                    </td>
                                    <td class="text-info">{{$item->request_type ?? ''}}</td>
                                    <td class="text-nowrap text-info">
                                        @if ($item->category_title != null)
                                        {{$item->category_title ?? ''}}

                                        @elseif($item->category_title == null)
                                        <a href="{{route('admin.tutor.tutorshow' , ['tutor' => $item->tutor->id])}}"
                                            class="p-1 rounded text-info text-decoration-none"
                                            style="background-color: #e6eef7">{{$item->tutor->name ?? ''}}</a>

                                        @endif

                                    </td>
                                    <td class="text-info">
                                        @if ($item->category_id != null)
                                        {{$item->category_id ?? ''}}

                                        @elseif($item->category_id == null)
                                        <a href="{{route('admin.tutor.tutorshow' , ['tutor' => $item->tutor->id])}}"
                                            class="p-1 rounded text-info text-decoration-none"
                                            style="background-color: #e6eef7">{{$item->tutor_id ?? ''}}</a>

                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($item->status == 'pending')
                                        <div class="px-3 py-1 rounded-2" style="
                                                background-color: #fdf7e8;
                                                color: #f0c149;
                                                border: 1px solid #f0c149;
                                                width: fit-content;
                                            ">
                                            Pending
                                        </div>

                                        @endif
                                        @if ($item->status == 'accepted')
                                        <div class="py-1 rounded-2" style="
                                                        background-color: #f3f9ec;
                                                        color: #86c240;
                                                        border: 1px solid #86c240;
                                                        width: fit-content;
                                                        padding-left: 13px;
                                                        padding-right: 13px;
                                                    ">
                                            Accepted
                                        </div>

                                        @endif
                                        @if ($item->status == 'rejected')
                                        <div class="px-3 py-1 rounded-2" style="
                                                        background-color: #fdecec;
                                                        color: #f26969;
                                                        border: 1px solid #f26969;
                                                        width: fit-content;
                                                    ">
                                            Rejected
                                        </div>

                                        @endif

                                    </td>
                                    <td class="">
                                        <button type="button" class="d-flex btn btn-outline-primary px-2 py-1"
                                            data-bs-toggle="modal" data-bs-target="#viewModal" style="color: #6c6d6d">
                                            <i class="bi bi-eye-fill me-1 d-block" style="margin-top: 1px"></i>
                                            View
                                        </button>
                                    </td>
                                </tr>

                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                    {{ $tutorHireRequests->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
        <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-slide-right" style="max-width: 600px">
                <div class="modal-content pb-4 pt-3">
                    <div class="modal-header" style="padding-right: 40px; padding-left: 40px">
                        <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0" style="padding-left: 40px">
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="datef" class="form-label">Date from</label>
                                        <div>
                                            <input type="date" class="form-control shadow rounded-2" id="datef"
                                                onchange="inputChange('created_at >=', this.id)" />
                                        </div>
                                    </div>
                                    <div class="pb-3">
                                        <label for="datet" class="form-label">Date To</label>
                                        <input type="date" class="form-control shadow rounded-2" id="datet"
                                            onchange="inputChange('created_at <=', this.id)" />
                                    </div>
                                </div>
                                <div class="border-end mt-3" style="height: 170px"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="cty" class="form-label text-dark">Request Type</label>

                                        <select name="cat_service" class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select"
                                            onchange="inputChange('request_type',this.id)" id="cat_type">
                                            <option value="">Select Type</option>
                                            <option value="tutor">Tutor</option>
                                            <option value="category">Category</option>
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="ss" class="form-label text-dark text-sm">
                                            Status
                                        </label>

                                        <select name="status" class="form-select rounded-3 shadow-none select2"
                                            aria-label="Default select"
                                            onchange="inputChange('status',this.id)" id="status">
                                            <option value="">Select Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="accepted">Accepted</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=""></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                        <form action="{{route('admin.parent.category.request.filter',$id)}}" method="post">
                            @csrf
                            <div>
                                <button type="button" class="btn btn-danger py-1 me-2">
                                    Clear
                                </button>
                                <input type="hidden" id="tc_filter" name="tc_filter" value="">

                                <button type="submit" class="btn btn-primary py-1">
                                    Apply
                                </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body rounded-3 p-4" style="background-color: #f5f6fa">
                        <div class="bg-white p-3 shadow-lg rounded-3 border-top border-primary border-3 mb-4">
                            <h5 class="text-dark fw-500">15 Augest-2024</h5>
                            <h5 class="text-dark fw-500">10 : 00 AM</h5>
                            <p class="mb-0">
                                Mr./Mrs. Md Jabed Hossain text of the printing and
                                typesetting industry. Lorem Ipsum has been the
                                industry's standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and
                                scrambled it to make a type specimen book. Lorem Ipsum
                                has been the the industry's standard dummy text ever
                                since the 1500s, at the bing of days
                            </p>
                        </div>
                        <div class="bg-white p-3 shadow-lg rounded-3 border-top border-primary border-3">
                            <h5 class="text-dark fw-500">10 July-2024</h5>
                            <h5 class="text-dark fw-500">03 : 23 PM</h5>
                            <p class="mb-0">
                                Mr./Mrs. Md Jabed Hossain text of the printing and
                                typesetting industry. Lorem Ipsum has been the
                                industry's standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and
                                scrambled it to make a type specimen book. Lorem Ipsum
                                has been the the industry's standard dummy text ever
                                since the 1500s, at the bing of days
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- contents ends here -->
    </div>
</main>

    <script>
        let filter = {};

        function inputChange(colname, id) {
        filter[colname] = $("#" + id).val();
        var input = '';

        const dateValue = filter[colname].replace(/-/g, '');

        Object.entries(filter).forEach((entry, index) => {
            const [key, value] = entry;

            if (index == (Object.keys(filter).length - 1)) {
                input += `${key}='${value}' `;
            } else {
                input += `${key}='${value}' and `;
            }
        });

        $('#tc_filter').val(input);
        }
    </script>


@endsection
