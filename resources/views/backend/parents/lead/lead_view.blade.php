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

                <div class="ps-3 mt-4" style="padding-right: 13px">

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                                <div class="bg-white pb-4 mb-b">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover bg-white shadow-none"
                                            style="border-collapse: collapse">
                                            <tbody>
                                                <tr>
                                                    <div class="mb-4">
                                                        <div class="bg-white py-4 shadow-lg rounded-3">
                                                            <h5 class="mb-5 ms-4">Parent Lead</h5>
                                                            <div class="">
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Parent Id</p>
                                                                    <p class=""><a class="text-decoration-none" target="_blank" href="{{route('admin.view.parent',$lead->parents_id)}}">{{$lead->parent->unique_id}} </a> </p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Student Gender</p>
                                                                    <p class="">{{$lead->student_gender ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Country</p>
                                                                    <p class="">{{$lead->country->name ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">City</p>
                                                                    <p class="">{{$lead->city->name ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Location</p>
                                                                    <p class="">{{$lead->location->name ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Address</p>
                                                                    <p class="">{{$lead->address ?? ''}} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- pagination starts here -->
                                    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                        {{-- {{ $leads->appends(request()->except('page'))->links() }} --}}
                                    </div>
                                    <!-- pagination ends here -->
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                                <div class="bg-white pb-4 mb-b">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover bg-white shadow-none"
                                            style="border-collapse: collapse">
                                            <tbody>
                                                <tr>
                                                    <div class="mb-4">
                                                        <div class="bg-white py-4 shadow-lg rounded-3">
                                                            <h5 class="mb-5 ms-4">Parent Lead</h5>
                                                            <div class="">
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Category</p>
                                                                    <p class="">{{$lead->category->name ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Course</p>
                                                                    <p class="">{{$lead->course->name ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Subject</p>
                                                                    @php
                                                                        $subjectIds = explode(',', $lead->subject_id);
                                                                        $subjects = App\Models\Subject::whereIn('id', $subjectIds)->pluck('title');
                                                                    @endphp
                                                                    <p class="">
                                                                        {{ $subjects->join(', ') ?? '' }}
                                                                    </p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Tutor Gender</p>
                                                                    <p class="">{{$lead->tutor_gender ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Additional Requirement</p>
                                                                    <p class="">{{$lead->addition_requirement ?? ''}}</p>
                                                                </div>
                                                                <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                                                    <p class="fw-semibold">Action By</p>

                                                                    <p class="">
                                                                        {{$lead->user->name ?? ''}}

                                                                         </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- pagination starts here -->
                                    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                        {{-- {{ $leads->appends(request()->except('page'))->links() }} --}}
                                    </div>
                                    <!-- pagination ends here -->
                                </div>
                            </div>
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
