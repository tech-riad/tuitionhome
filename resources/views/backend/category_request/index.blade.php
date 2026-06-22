@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')

    <!-- navbar starts here -->
    <nav class="navbar navbar-expand-lg bg-white shadow-lg fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a href="index.html"><img src="/images/logo.svg" alt="logo" /></a>
            <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="navbarColor02" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="bi bi-caret-down-fill"></i>
            </button>
        </div>
    </nav>
    <!-- navbar ends here -->

    <div class="container-fluid">
        <div class="row">
            <!-- sidebar starts here -->

            <!-- sidebar ends here -->
            <div class="">
                <div class="col-md-12 ms-sm-auto col-lg-12" style="margin-top: 62px">
                    <!-- mini nav starts here -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
                            <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.request.tutor')}}">Tutor
                                Requests</a>
                            <a class="text-decoration-none text-gray-800 text-nowrap active-border"
                                href="{{route('admin.cat.request')}}">Category Requests</a>
                        </div>
                    </div>
                    <!-- mini nav ends here -->
                    <!-- main content section starts here -->
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
                                <form action="{{route('admin.cat.request.search')}}" method="post">
                                    @csrf
                                    <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                                        style="border: 1px solid #cfdfdb">

                                        <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                                            placeholder="Search" style="padding: 12px 18px" id="">
                                        <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
                                    </div>


                                </form>                                <select class="form-select rounded shadow-none" style="width: 100px">
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
                                    <table class="table table-hover bg-white shadow-none"
                                        style="border-collapse: collapse">
                                        <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                            <tr>
                                                <th scope="col" class="text-nowrap">
                                                    <input class="form-check-input me-2" type="checkbox"
                                                        id="flexCheckDefault" />#SL
                                                </th>
                                                <th scope="col" class="text-nowrap">Date</th>
                                                <th scope="col" class="text-nowrap">Code</th>
                                                <th scope="col" class="text-nowrap">Parents Name</th>
                                                <th scope="col" class="text-nowrap">Parents ID</th>
                                                <th scope="col" class="text-nowrap">Category Name</th>
                                                <th scope="col" class="text-nowrap">Category ID</th>
                                                <th scope="col" class="text-nowrap">Status</th>
                                                <th scope="col" class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($catRequest as $item)
                                            <tr class="align-middle">
                                                <td scope="row" class="text-nowrap">
                                                    <input class="form-check-input me-2" type="checkbox"
                                                        id="flexCheckDefault" />
                                                        {{ $loop->iteration }}
                                                </td>
                                                <td class="">
                                                    <a type="button"
                                                        class="text-decoration-none text-gray-800 text-nowrap"
                                                        data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                        {{ $item->created_at }}
                                                    </a>
                                                </td>
                                                <td>CR-{{$item->id}}</td>
                                                <td class="text-nowrap">{{$item->parent->name}}</td>
                                                <td class="text-nowrap text-info">
                                                    <a href="{{route('admin.view.parent',$item->parent_id)}}"
                                                        class="text-decoration-none text-info">{{$item->parent->unique_id}}</a>
                                                        <div style="display: inline-block">
                                                            @if ($item->parent->is_verified == 1)

                                                            <img src="{{ asset('images/blue-tick-mark.svg') }}" alt="blue-tick" />
                                                            @endif
                                                            @if ($item->parent->is_super == 1)
                                                            <img src="{{asset('images/green-star.svg')}}" alt="green-star" />
                                                            @endif
                                                            @if ($item->parent->is_unplesant == 1)
                                                            <img src="{{asset('images/red-face.svg')}}" alt="red-face" />
                                                            @endif
                                                        </div>
                                                </td>
                                                <td class="text-nowrap">{{$item->category_title}}</td>
                                                <td class="text-info">{{$item->category_id}}</td>
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
                                                    <div class="d-flex gap-2">
                                                        <div class="dropdown">
                                                            <button class="btn shadow-none py-1 px-2" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" style="border: 1px solid #d7dfe9">
                                                                <li>
                                                                    <a class="dropdown-item" href="{{route('admin.parent.category.lead.job.post',$item->id)}}">Post Job</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="{{route('admin.cat.request.reject',$item->id)}}">Reject</a>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#parentsNoteModal_{{$item->id}}"
                                                                        href="#">Parents Note</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#adminNoteModal_{{$item->id}}" href="#">Admin
                                                                        Note</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="parentsNoteModal_{{$item->id}}" tabindex="-1" aria-labelledby="parentsNoteModalLabel_{{$item->id}}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                                                    <div class="modal-content p-2">
                                                        <div class="modal-body py-0 mt-2">
                                                            <div class="mb-4">
                                                                <!-- Hidden Input for Parent ID -->
                                                                <input type="hidden" name="parent_id" id="parentId_{{$item->id}}" value="{{$item->parent_id}}">
                                                                <div class="mb-3">
                                                                    <label for="notet_{{$item->id}}" class="form-label fw-500 fs-14">Parents Note</label>
                                                                    <textarea placeholder="Write your note here..."
                                                                        class="form-control shadow-none rounded-2" id="notet_{{$item->id}}"
                                                                        rows="4"></textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <button class="btn btn-info px-2 py-1 create-note-btn" data-lead-id="{{$item->id}}">Create</button>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $parentsNotes = App\Models\HiringRequestNote::where('lead_id',$item->id)->where('note_type','parent_note')->orderBy('id','desc')->get();
                                                            @endphp
                                                            @foreach ($parentsNotes as $parentsNote)
                                                                <div class="mb-4">
                                                                    <div class="border-bottom border-1 pb-3">
                                                                        <div class="bg-light rounded-2 p-2" style="font-size: 14px">
                                                                            {{$parentsNote->note ?? ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                                        <div class="d-flex justify-content-start align-items-center gap-3">
                                                                            <img height="45" width="45" class="rounded-3" src="/images/boy.jpg"
                                                                                alt="" style="object-fit: cover" />
                                                                            <div class="">
                                                                                <p class="m-0" style="font-size: 14; font-weight: 500">
                                                                                    {{$parentsNote->user->name ?? ''}}
                                                                                </p>
                                                                                <p class="m-0 fw-light" style="font-size: 12px">
                                                                                    Sales & Operation Dep:
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <p style="font-size: 12px">{{$parentsNote->created_at ?? ''}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="adminNoteModal_{{$item->id}}" tabindex="-1" aria-labelledby="adminNoteModalLabel_{{$item->id}}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                                                    <div class="modal-content p-2">
                                                        <div class="modal-body py-0 mt-2">
                                                            <div class="mb-4">
                                                                <!-- Hidden Input for Parent ID -->
                                                                <input type="hidden" name="parent_id" id="adminparentId_{{$item->id}}" value="{{$item->parent_id}}">
                                                                <div class="mb-3">
                                                                    <label for="adminnotet_{{$item->id}}" class="form-label fw-500 fs-14">Admin Note</label>
                                                                    <textarea placeholder="Write your note here..."
                                                                        class="form-control shadow-none rounded-2" id="adminnotet_{{$item->id}}"
                                                                        rows="4"></textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <button class="btn btn-info px-2 py-1 create-note-btn-admin" data-lead-id="{{$item->id}}">Create</button>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $adminNotes = App\Models\HiringRequestNote::where('lead_id',$item->id)->where('note_type','admin_note')->orderBy('id','desc')->get();
                                                            @endphp
                                                            @foreach ($adminNotes as $adminNote)
                                                                <div class="mb-4">
                                                                    <div class="border-bottom border-1 pb-3">
                                                                        <div class="bg-light rounded-2 p-2" style="font-size: 14px">
                                                                            {{$adminNote->note ?? ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                                        <div class="d-flex justify-content-start align-items-center gap-3">
                                                                            <img height="45" width="45" class="rounded-3" src="/images/boy.jpg"
                                                                                alt="" style="object-fit: cover" />
                                                                            <div class="">
                                                                                <p class="m-0" style="font-size: 14; font-weight: 500">
                                                                                    {{$adminNote->user->name ?? ''}}
                                                                                </p>
                                                                                <p class="m-0 fw-light" style="font-size: 12px">
                                                                                    Sales & Operation Dep:
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <p style="font-size: 12px">{{$adminNote->created_at ?? ''}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <script>
                                                $(document).on('click', '.create-note-btn', function (e) {
                                                    e.preventDefault();

                                                    const leadId = $(this).data('lead-id');
                                                    const parentId = $(`#parentId_${leadId}`).val();
                                                    const note = $(`#notet_${leadId}`).val();

                                                    if (!note.trim()) {
                                                        alert('Please write a note.');
                                                        return;
                                                    }

                                                    $.ajax({
                                                        url: `/admin/tutor-category-request/note-add/${leadId}`,
                                                        method: 'POST',
                                                        data: {
                                                            note: note,
                                                            note_type: 'general',
                                                            parent_id: parentId,
                                                            _token: $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        success: function (response) {
                                                            if (response.success) {
                                                                toastr.success(response.message);

                                                                $(`#parentsNoteModal_${leadId}`).modal('hide');
                                                                $(`#notet_${leadId}`).val('');
                                                                location.reload();
                                                            }
                                                        },
                                                        error: function (xhr) {
                                                            alert('Something went wrong. Please try again.');
                                                            console.error(xhr.responseText);
                                                        }
                                                    });
                                                });

                                            </script>
                                            <script>
                                                $(document).on('click', '.create-note-btn-admin', function (e) {
                                                    e.preventDefault();

                                                    const leadId = $(this).data('lead-id');
                                                    const parentId = $(`#adminparentId_${leadId}`).val();
                                                    const note = $(`#adminnotet_${leadId}`).val();

                                                    if (!note.trim()) {
                                                        alert('Please write a note.');
                                                        return;
                                                    }

                                                    $.ajax({
                                                        url: `/admin/tutor-category-request/note-add-admin/${leadId}`,
                                                        method: 'POST',
                                                        data: {
                                                            note: note,
                                                            note_type: 'general',
                                                            parent_id: parentId,
                                                            _token: $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        success: function (response) {
                                                            if (response.success) {
                                                                toastr.success(response.message);

                                                                $(`#adminNoteModal_${leadId}`).modal('hide');
                                                                $(`#adminnotet_${leadId}`).val('');
                                                                location.reload();
                                                            }
                                                        },
                                                        error: function (xhr) {
                                                            alert('Something went wrong. Please try again.');
                                                            console.error(xhr.responseText);
                                                        }
                                                    });
                                                });

                                            </script>


                                        </tbody>
                                    </table>
                                </div>
                                <!-- pagination starts here -->
                                <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                    {{ $catRequest->appends(request()->except('page'))->links() }}

                                </div>
                                <!-- pagination ends here -->
                            </div>
                        </div>
                    </div>
                    <!-- table ends here -->
                    <!--admin Note model starts here-->
                    <div class="modal fade" id="adminNoteModal" tabindex="-1" aria-labelledby="adminNoteModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                            <div class="modal-content p-2">
                                <div class="modal-body py-0 mt-2">
                                    <div class="mb-4">
                                        <div class="mb-3">
                                            <label for="notet" class="form-label fw-500 fs-14">Admin Note</label>
                                            <textarea placeholder="Write your note here..."
                                                class="form-control shadow-none rounded-2" id="notet"
                                                rows="4"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button class="btn btn-info px-2 py-1">Create</button>
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
                                                <img height="45" width="45" class="rounded-3" src="/images/boy.jpg"
                                                    alt="" style="object-fit: cover" />
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
                                                <img height="45" width="45" class="rounded-3" src="/images/boy.jpg"
                                                    alt="" style="object-fit: cover" />
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
                    <!--admin Note model starts here-->
                    <div class="modal fade" id="parentsNoteModal" tabindex="-1" aria-labelledby="parentsNoteModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
                            <div class="modal-content p-2">
                                <div class="modal-body py-0 mt-2">
                                    <div class="mb-4">
                                        <div class="mb-3">
                                            <label for="notet" class="form-label fw-500 fs-14">Parents Note</label>
                                            <textarea placeholder="Write your note here..."
                                                class="form-control shadow-none rounded-2" id="notet"
                                                rows="4"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button class="btn btn-info px-2 py-1">Create</button>
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
                                                <img height="45" width="45" class="rounded-3" src="/images/boy.jpg"
                                                    alt="" style="object-fit: cover" />
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
                                                <img height="45" width="45" class="rounded-3" src="/images/boy.jpg"
                                                    alt="" style="object-fit: cover" />
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
                    <!--parents  Note model ends here-->

                    <!-- Show Date time model starts here-->
                    <div class="modal fade" id="showDateTimeModal" tabindex="-1"
                        aria-labelledby="showDateTimeModalLabel" aria-hidden="true">
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
                        <div class="modal-dialog modal-dialog-slide-right" style="max-width: 650px">
                            <div class="modal-content pb-4 pt-3">
                                <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                                    <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-0" style="padding-left: 40px">
                                    <div class="row row-cols-1 row-cols-md-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 pe-4">
                                                <div>
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
                                            </div>
                                            <div class="border-end mt-3" style="height: 125px"></div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 pe-4">
                                                <div class="pb-3">
                                                    <label for="gndr"
                                                        class="form-label text-dark text-sm">Status</label>

                                                    <select id="gndr" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example" onchange="inputChange('status',this.id)">
                                                        <option selected value="">Select One</option>
                                                        <option  value="accepted">
                                                            Accepted
                                                        </option>
                                                        <option  value="pending">
                                                            Pending
                                                        </option>
                                                        <option  value="rejected">
                                                            Rejected
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="pb-3">
                                                    <label for="src" class="form-label text-dark text-sm">Other</label>

                                                    <select id="src" class="shadow rounded-2 form-select"
                                                        aria-label="Default select example">
                                                        <option selected value="Other">Other</option>
                                                        <option value="Option 1">Option 1</option>
                                                        <option value="Option 2">Option 2</option>
                                                        <option value="Option 3">Option 3</option>
                                                        <option value="Option 4">Option 4</option>
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
                                        <form action="{{route('admin.cat.request.filter')}}" method="post">
                                            @csrf
                                            <div>
                                                <button type="button" class="btn btn-danger py-1 me-2">
                                                    Clear
                                                </button>



                                                <input type="hidden" id="cat_filter" name="cat_filter" value="">

                                                <button type="submit" class="btn btn-primary py-1">
                                                    Apply
                                                </button>

                                        </form>
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


@push('page_scripts')
<script>
    let filter = {};

function inputChange(colname, id) {
filter[colname] = $("#" + id).val();
var input = '';

// Convert the date format if necessary
const dateValue = filter[colname].replace(/-/g, '');

Object.entries(filter).forEach((entry, index) => {
    const [key, value] = entry;

    if (index == (Object.keys(filter).length - 1)) {
        input += `${key}='${value}' `;
    } else {
        input += `${key}='${value}' and `;
    }
});

$('#cat_filter').val(input);
}
</script>

@endpush
