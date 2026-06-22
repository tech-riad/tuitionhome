@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="container-custom">
            <div class="col-md-12 ms-sm-auto col-lg-12" style="margin-top: 62px">
                <!-- mini nav starts here -->
                @include('backend.parents.lead.lead_menu')
                <!-- mini nav ends here -->
                <!-- main content section starts here -->
                <!-- header cards starts here -->
                {{-- <div class="row gap-4 gap-md-0 ms-1 me-1 mb-4">
                    <div class="col-12">
                        <div class="bg-white shadow-lg rounded-3 p-4">
                            <p class="text-center fw-bold fs-5 mb-1">175</p>
                            <p class="text-center mb-0">Total Leads</p>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 gap-4 row-cols-md-2 row-cols-lg-4 gap-md-0 ms-1 me-1">
                    <div class="mb-md-4 mb-lg-0">
                        <div class="bg-white shadow-lg rounded-3 p-4">
                            <p class="text-center fw-bold fs-5 mb-1">58</p>
                            <p class="text-center mb-0">Parents Leads</p>
                        </div>
                    </div>
                    <div class="mb-md-4 mb-lg-0">
                        <div class="bg-white shadow-lg rounded-3 p-4">
                            <p class="text-center fw-bold fs-5 mb-1">25</p>
                            <p class="text-center mb-0 text-nowrap">FnF Leads</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="bg-white shadow-lg rounded-3 p-4">
                            <p class="text-center fw-bold fs-5 mb-1">41</p>
                            <p class="text-center mb-0">Pending Leads</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="bg-white shadow-lg rounded-3 p-4">
                            <p class="text-center fw-bold fs-5 mb-1">50</p>
                            <p class="text-center mb-0">Approved Leads</p>
                        </div>
                    </div>
                </div> --}}
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
                        </div>
                        <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                            <input type="text" class="form-control rounded" placeholder="Search" />
                            <select class="form-select rounded" style="width: 100px">
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
                                <table class="table table-sm table-hover bg-white shadow-none"
                                    style="border-collapse: collapse">
                                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                        <tr>
                                            <th scope="col" class="text-nowrap">
                                                <input class="form-check-input" type="checkbox" id="flexCheckDefault"
                                                    style="margin-right: 12px; margin-left: 7px" />#SL
                                            </th>
                                            <th scope="col" class="text-nowrap">Date</th>
                                            <th scope="col" class="text-nowrap">Parents ID</th>
                                            <th scope="col" class="text-nowrap">Code</th>
                                            <th scope="col" class="text-nowrap">Class/Course</th>
                                            <th scope="col" class="text-nowrap">Gender</th>
                                            <th scope="col" class="text-nowrap">Loc.</th>
                                            <th scope="col" class="text-nowrap">Source</th>
                                            <th scope="col" class="text-nowrap">Status</th>
                                            <th scope="col" class="text-nowrap">Action By</th>
                                            <th scope="col" class="text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leads as $item)
                                        <tr class="align-middle">
                                            <td scope="row " class="text-center text-nowrap">
                                                <input class="form-check-input me-2" type="checkbox" value=""
                                                    id="flexCheckDefault" />
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="">
                                                <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                                    data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                    {{ $item->created_at->format('M d, Y') }}
                                                </a>
                                            </td>
                                            <td>
                                                <a class="text-decoration-none" target="_blank"
                                                    href="{{route('admin.view.parent',$item->parents_id)}}">
                                                    <div class="rounded-2 px-2 py-1" style="
                                                      background-color: #e5eff9;
                                                      width: 80px !important;
                                                    ">
                                                        <p class="text-info mb-0 text-center">
                                                            {{$item->parent->unique_id}}
                                                        </p>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="text-nowrap">{{$item->id}}</td>
                                            <td class="">{{$item->course ?? ''}}</td>
                                            <td class="">{{$item->tutor_gender}}</td>
                                            <td class="">
                                                <button data-bs-toggle="modal"
                                                    data-bs-target="#locationModal_{{$item->id}}"
                                                    style="border: none; background: none">
                                                    <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                                                </button>
                                            </td>
                                            <!-- location model starts here-->
                                            <div class="modal fade" id="locationModal_{{$item->id}}" tabindex="-1"
                                                aria-labelledby="locationModalLabel_{{$item->id}}" aria-hidden="true">
                                                <div class="modal-dialog model-sm modal-dialog-slide-top"
                                                    style="max-width: 400px">
                                                    <div class="modal-content">
                                                        <div class="modal-body pb-2 pt-2">
                                                            <div
                                                                class="d-flex justify-content-between border-bottom pb-1">
                                                                <div class="d-flex gap-2">
                                                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                                                    <p class="fw-semibold fs-5 mb-0">Location</p>
                                                                </div>
                                                                <button type="button" class="btn-close mt-1"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="mt-2">
                                                                <p class="mb-0">{{$item->address}} </p>
                                                                <hr>
                                                                <p class="mb-0">{{$item->location ?? ''}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- location model ends here-->
                                            <td class="">Fnf</td>
                                            <td class="@if($item->status == 'Accepted') text-primary
                                                @elseif($item->status == 'Pending') text-warning
                                                @elseif($item->status == 'Cancel') text-red
                                                @endif">
                                                {{$item->status}}
                                            </td>
                                            <td class="text-nowrap">{{$item->user->name ?? ''}}</td>

                                            <td class="">
                                                <div class="d-flex gap-2">
                                                    <div class="dropdown">
                                                        <button class="btn shadow-none py-1 px-2" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" style="border: 1px solid #d7dfe9">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{route('admin.parent.fnf.lead.job.post',$item->id)}}">Post
                                                                    Job</a>
                                                            </li>

                                                            <li>
                                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#cancelNoteModal_{{$item->id}}"
                                                                    href="#">Cancel Note</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#adminNoteModal_{{$item->id}}"
                                                                    href="#">Admin Note</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- cancel note modal -->



                                            <!-- cancel note modal ends-->
                                        </tr>

                                        <div class="modal fade" id="adminNoteModal_{{$item->id}}" tabindex="-1"
                                            aria-labelledby="adminNoteModalLabel_{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                                                <div class="modal-content p-2">
                                                    <div class="modal-body py-0 mt-2">
                                                        <div class="mb-4">
                                                            <form id="adminNoteForm_{{$item->id}}" method="POST">
                                                                @csrf
                                                                <div>
                                                                    <label for="admin_note" class="form-label text-dark">
                                                                        Please make a smart note for the admin reasons to
                                                                        Parent
                                                                    </label>
                                                                    <textarea class="form-control shadow-none rounded-3"
                                                                        id="admin_note" name="admin_note" rows="5"
                                                                        placeholder="Maximum 200 characters can be given">{{$item->admin_note ?? ''}}</textarea>
                                                                </div>
                                                            </form>
                                                            <div class="d-flex justify-content-end align-items-center">
                                                                <button class="btn btn-primary px-2 py-1 submit-admin-note">
                                                                    Create
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="cancelNoteModal_{{$item->id}}" tabindex="-1"
                                            aria-labelledby="cancelNoteModalLabel_{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width: 650px">
                                                <div class="modal-content p-3">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel6">
                                                            Job Cancel Note
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form id="cancelNoteForm_{{$item->id}}" method="POST">
                                                            @csrf
                                                            <div>
                                                                <label for="cancel_note" class="form-label text-dark">
                                                                    Please make a smart note about the cancel reasons to
                                                                    Parent
                                                                </label>
                                                                <textarea class="form-control shadow-none rounded-3"
                                                                    id="cancel_note" name="cancel_note" rows="5"
                                                                    placeholder="Maximum 200 characters can be given">{{$item->cancel_note ?? ''}}</textarea>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="modal-footer d-flex gap-2">
                                                        <button type="button" class="btn btn-gdark shadow-lg"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-primary submit-cancel-note "
                                                            @if($item->status == 'Cancel')
                                                            disabled
                                                            @endif
                                                            data-id="{{$item->id}}">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        <script>
                                            $(document).ready(function () {
                                                $(document).on("click", ".submit-cancel-note", function () {
                                                    let leadId = $(this).data("id");
                                                    let cancelNote = $(`#cancel_note`).val();
                                                    let form = $(`#cancelNoteForm_${leadId}`);
                                                    let actionUrl = `/admin/parent/fnf-leads/reject/job/${leadId}`;

                                                    $.ajax({
                                                        url: actionUrl,
                                                        method: "POST",
                                                        data: form.serialize(),
                                                        beforeSend: function () {
                                                            $(".submit-cancel-note").attr("disabled", true);
                                                        },
                                                        success: function (response) {
                                                            if (response.status) {
                                                                Swal.fire({
                                                                    position: "top-end",
                                                                    icon: "success",
                                                                    title: "Job canceled successfully",
                                                                    text: response.message,
                                                                    showConfirmButton: false,
                                                                    timer: 1500
                                                                });

                                                                $(`#cancelNoteModal_${leadId}`).modal("hide");
                                                            } else {
                                                                alert("An error occurred: " + response.message);
                                                            }
                                                        },
                                                        error: function (xhr) {
                                                            if (xhr.status === 403) {
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    title: "Access Denied",
                                                                    text: "You do not have permission to cancel this job.",
                                                                    confirmButtonText: "OK"

                                                                });
                                                            } else {
                                                                let errors = xhr.responseJSON?.errors;
                                                                if (errors) {
                                                                    $.each(errors, function (key, val) {
                                                                        alert(val[0]);
                                                                    });
                                                                } else {
                                                                    console.error(xhr.responseText);
                                                                }
                                                            }
                                                        },
                                                        complete: function () {
                                                            $(".submit-cancel-note").attr("disabled", false);
                                                            location.reload();
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                        <script>
                                            $(document).ready(function () {
                                                $(document).on("click", ".submit-admin-note", function () {
                                                    let leadId = $(this).closest(".modal").attr("id").split("_")[1]; // Get lead ID
                                                    let form = $(`#adminNoteForm_${leadId}`);
                                                    let actionUrl = `/admin/parent/fnf-leads/admin/note/${leadId}`;
                                                    let formData = form.serialize(); // Serialize form data

                                                    $.ajax({
                                                        url: actionUrl,
                                                        method: "POST",
                                                        data: formData,
                                                        headers: {
                                                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Include CSRF token
                                                        },
                                                        beforeSend: function () {
                                                            $(".submit-admin-note").attr("disabled", true);
                                                        },
                                                        success: function (response) {
                                                            if (response.status) {
                                                                Swal.fire({
                                                                    position: "top-end",
                                                                    icon: "success",
                                                                    title: "Note updated successfully",
                                                                    text: response.message,
                                                                    showConfirmButton: false,
                                                                    timer: 1500
                                                                });

                                                                $(`#adminNoteModal_${leadId}`).modal("hide");
                                                            } else {
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    title: "Error",
                                                                    text: response.message,
                                                                    confirmButtonText: "OK"
                                                                });
                                                            }
                                                        },
                                                        error: function (xhr) {
                                                            if (xhr.status === 403) {
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    title: "Access Denied",
                                                                    text: "You do not have permission to update this note.",
                                                                    confirmButtonText: "OK"
                                                                });
                                                            } else {
                                                                let errors = xhr.responseJSON?.errors;
                                                                if (errors) {
                                                                    $.each(errors, function (key, val) {
                                                                        Swal.fire({
                                                                            icon: "error",
                                                                            title: "Validation Error",
                                                                            text: val[0],
                                                                            confirmButtonText: "OK"
                                                                        });
                                                                    });
                                                                } else {
                                                                    console.error(xhr.responseText);
                                                                }
                                                            }
                                                        },
                                                        complete: function () {
                                                            $(".submit-admin-note").attr("disabled", false);
                                                            location.reload();
                                                        }
                                                    });
                                                });
                                            });
                                        </script>


                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                {{ $leads->appends(request()->except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="adminNoteModal" tabindex="-1" aria-labelledby="adminNoteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                        <div class="modal-content p-2">
                            <div class="modal-body py-0 mt-2">
                                <div class="mb-4">
                                    <div class="mb-3">
                                        <label for="notet" class="form-label fw-500 fs-14">Admin Note</label>
                                        <textarea placeholder="Write your note here..."
                                            class="form-control shadow-none rounded-2" id="notet" rows="4"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button class="btn btn-primary px-2 py-1">
                                            Create
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="border-bottom border-1 pb-3">
                                        <div class="bg-light rounded-2 p-2" style="font-size: 14px">
                                            Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. Perspiciatis, dignissimos.
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="d-flex justify-content-start align-items-center gap-3">
                                            <img height="45" width="45" class="rounded-3" src="/images/boy.jpg" alt=""
                                                style="object-fit: cover" />
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
                                </div>
                                <div class="mb-4">
                                    <div class="border-bottom border-1 pb-3">
                                        <div class="bg-light rounded-2 p-2" style="font-size: 14px">
                                            Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. Perspiciatis, dignissimos.
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="d-flex justify-content-start align-items-center gap-3">
                                            <img height="45" width="45" class="rounded-3" src="/images/boy.jpg" alt=""
                                                style="object-fit: cover" />
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--admin  Note model ends here-->

                <!-- cancel note modal -->
                <div class="modal fade" id="cancelNoteModalX" tabindex="-1" aria-labelledby="cancelNoteModalLabelX"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 650px">
                        <div class="modal-content">
                            <div class="modal-body border-top border-primary rounded-3 border-3">
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                    Ea consectetur enim velit facilis corrupti corporis a fuga
                                    quisquam tempore unde amet sapiente inventore vitae
                                    libero, debitis cupiditate aperiam necessitatibus! Eveniet
                                    ab dolores laboriosam, consequatur distinctio amet
                                    doloremque repudiandae dolore earum, perspiciatis ipsa?
                                    Quam, officiis! Unde voluptate, doloremque harum saepe
                                    debitis cupiditate aperiam necessitatibus!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- cancel note modal ends-->
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

                <!-- Filter model starts here -->
                <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-slide-right" style="max-width: 1000px">
                        <div class="modal-content pb-4 pt-3">
                            <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                                <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-0" style="padding-left: 40px">
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 pe-4">
                                            <div class="pb-3">
                                                <label for="datef" class="form-label text-dark text-sm">Date
                                                    from</label>
                                                <div class="">
                                                    <input type="date" class="form-control shadow rounded-2"
                                                        id="datef" />
                                                </div>
                                            </div>
                                            <div class="pb-3">
                                                <label for="datet" class="form-label text-dark text-sm">Date
                                                    To</label>
                                                <input type="date" class="form-control shadow rounded-2" id="datet" />
                                            </div>
                                        </div>
                                        <div class="border-end mt-3" style="height: 125px"></div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 pe-4">
                                            <div class="pb-3">
                                                <label for="gndr" class="form-label text-dark text-sm">Gender</label>

                                                <select id="gndr" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="">Select Gender</option>
                                                    <option value="Option 1">Option 1</option>
                                                    <option value="Option 2">Option 2</option>
                                                    <option value="Option 3">Option 3</option>
                                                    <option value="Option 4">Option 4</option>
                                                </select>
                                            </div>
                                            <div class="pb-3">
                                                <label for="src" class="form-label text-dark text-sm">Source</label>

                                                <select id="src" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="Social Lead">
                                                        Social Lead
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
                                                <label for="stts" class="form-label text-dark text-sm">Status</label>

                                                <select id="stts" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="Pending">Pending</option>
                                                    <option value="Option 1">Option 1</option>
                                                    <option value="Option 2">Option 2</option>
                                                    <option value="Option 3">Option 3</option>
                                                    <option value="Option 4">Option 4</option>
                                                </select>
                                            </div>
                                            <div class="pb-3">
                                                <label for="acby" class="form-label text-dark text-sm">Action
                                                    By</label>

                                                <select id="acby" class="shadow rounded-2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected value="Robel">Robel</option>
                                                    <option value="Option 1">Option 1</option>
                                                    <option value="Option 2">Option 2</option>
                                                    <option value="Option 3">Option 3</option>
                                                    <option value="Option 4">Option 4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-end align-items-center"
                                style="padding-right: 27px">
                                <div class="pe-2 d-flex gap-3">
                                    <button type="button" class="btn btn-danger">
                                        Clear
                                    </button>
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
</div>
@endsection
