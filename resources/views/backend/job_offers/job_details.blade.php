@extends('layouts.app')
@push('page_css')



{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

@endpush


@section('content')


<main class="container-custom">
    <div class="col-md-9 ms-sm-auto col-lg-12" style="">
        <!-- main content section starts here -->
        <div class="ps-3 py-4" style="padding-right: 13px">
            <ul class="nav nav-tabs row row-cols-2" id="myTab" role="tablist">
                <li>
                    <button class="w-100 nav-link active text-muted rounded-3 bg-white" id="details-taby"
                        data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab"
                        aria-controls="details-tab-pane" aria-selected="true">
                        Tuition Details
                    </button>
                </li>
                <li class="">
                    <button class="w-100 nav-link bg-white text-muted rounded-3" id="history-taby" data-bs-toggle="tab"
                        data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane"
                        aria-selected="false">
                        Edit History
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel"
                    aria-labelledby="details-tab" tabindex="0">
                    <div class="row row-cols-1 row-cols-lg-2 mt-4">
                        <div class="mb-4">
                            <div class="bg-white py-4 shadow-lg rounded-3" style="height: 400px">
                                <h5 class="mb-3 ms-4">Parents Information</h5>
                                <div class="">
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Name</p>
                                        <p class="">{{$job->parent->name ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Parents ID</p>
                                        <p class="">
                                            <a href="#
                      job.html" class="text-decoration-none text-info">{{$job->parent->unique_id ?? 'N/A'}}</a>
                                        </p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Job ID</p>
                                        <p class="">{{$job->id}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Number</p>
                                        <p class="">{{$job->parent->phone ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">
                                            When are you looking to hire?
                                        </p>

                                        @php
                                        $input = $job->date;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'H:i:s';
                                        $date = Carbon\Carbon::parse($input)->format($format1);
                                        // $time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <p class="">{{$date}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">
                                            Schedule For
                                        </p>
                                        <p class="">{{$job->hire_date ?? ''}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="bg-white py-4 shadow-lg rounded-3" style="height: 400px">
                                <h5 class="mb-5 ms-4">Reference Information</h5>
                                <div class="">
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Reference Name</p>
                                        <p class="">{{$job->reference->name ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Reference ID</p>
                                        <p class="">
                                            <a href="#
                      job.html" class="text-decoration-none text-info">{{$job->reference->id ?? 'N/A'}}</a>
                                        </p>
                                    </div>
                                    <div class="m-4 p-4 rounded-3 d-flex justify-content-between align-items-center flex-column"
                                        style="
                        box-shadow: 0px 4px 30px 0px
                          rgba(59, 60, 61, 0.15);
                        height: 135px;
                      ">
                                        <p class="">
                                            Sms Send (Are you sure to send sms to this offer)
                                        </p>
                                        <div class="bg-info text-white rounded px-2">
                                            <i class="bi bi-check-lg fs-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="bg-white py-4 shadow-lg rounded-3">
                                <h5 class="mb-5 ms-4">Student Information-1</h5>
                                <div class="">
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Name</p>
                                        <p class="">{{$job->student_name ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Gender</p>
                                        <p class="">{{$job->student_gender ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Name of Institute</p>
                                        <p class="">{{$job->institute_name ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Category</p>
                                        <p class="">{{$job->category->name ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Course</p>
                                        <p class="">{{$job->course->name ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Subjects</p>

                                        <p class="">@foreach($job->job_offer_student_subjects as $subject)

                                            {{$subject->subject->title ?? 'N/A'}},&nbsp;&nbsp;

                                            @endforeach </p>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="mb-4">
                            <div class="bg-white py-4 shadow-lg rounded-3">
                                <h5 class="mb-5 ms-4">Student Information-2</h5>
                                <div class="">
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Days in Week</p>
                                        <p class="">{{$job->days_in_week ?? 'N/A'}} Days</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">

                                        @php
                                        $format1 = 'd-m-Y';
                                        $format2 = 'h:i A';
                                        $time = Carbon\Carbon::parse($job->tutoring_time)->format($format2);
                                        @endphp


                                        <p class="fw-semibold">Tutoring Time</p>
                                        <p class="">{{$time ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Tutoring Duration</p>
                                        <p class="">{{$job->tutoring_duration ?? 'N/A'}}Hours</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Teaching Method</p>
                                        <p class="">{{$job->teachingMethod->name ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Maximum Salary</p>
                                        <p class="">{{$job->salary ?? 'N/A'}}</p>
                                    </div>
                                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                        <p class="fw-semibold">Number of Students</p>
                                        <p class="">{{$job->number_of_students ?? 'N/A'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($additionChild != null)
                        @foreach ($additionChild as $item)
                            <div class="mb-4">
                                <div class="bg-white py-4 shadow-lg rounded-3">
                                    <h5 class="mb-5 ms-4">Student Information-1.{{$loop->iteration}} </h5>
                                    <div class="">
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Name</p>
                                            <p class="">{{$item->student_name ?? 'N/A'}}</p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Gender</p>
                                            <p class="">{{$item->student_gender ?? 'N/A'}}</p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Name of Institute</p>
                                            <p class="">{{$item->institute_name ?? 'N/A'}}</p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Category</p>
                                            <p class="">{{$item->category->name ?? 'N/A'}}</p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Course</p>
                                            <p class="">{{$item->course->name ?? 'N/A'}}</p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Subjects</p>
                                            <p class="">
                                                @if ($item->job_offer_additional_child_subjects)
                                                    @foreach ($item->job_offer_additional_child_subjects as $subject)
                                                        {{$subject->subject->title ?? 'N/A'}},&nbsp;&nbsp;
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($loop->iteration % 2 == 0)
                                @break
                            @endif
                        @endforeach

                        @if (count($additionChild) % 2 == 1)
                            <div class="mb-4">
                                <div class="bg-white py-4 shadow-lg rounded-3">
                                    <h5 class="mb-5 ms-4">Student Information</h5>
                                    <div class="">
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Name</p>
                                            <p class=""></p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Gender</p>
                                            <p class=""></p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Name of Institute</p>
                                            <p class=""></p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Category</p>
                                            <p class=""></p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Course</p>
                                            <p class=""></p>
                                        </div>
                                        <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                                            <p class="fw-semibold">Subjects</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif








                        {{-- @if($job->additional_child_info != null)

              <div class="mb-4">
                <div class="bg-white py-4 shadow-lg rounded-3">
                  <h5 class="mb-5 ms-4">additional Student Information</h5>
                  <div class="">
                    <div
                      class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4"
                    >
                      <p class="fw-semibold">Name</p>
                      <p class="">{{$job->additional_child_info->student_name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Gender</p>
                        <p class="">{{$job->additional_child_info->student_gender ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Name of Institute</p>
                        <p class="">{{$job->additional_child_info->institute_name ?? 'N/A'}}</p>
                    </div>

                </div>
            </div>
        </div>


        <div class="mb-4">
            <div class="bg-white py-4 shadow-lg rounded-3">
                <h5 class="mb-5 ms-4">additional Student Information</h5>
                <div class="">

                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Category</p>
                        <p class="">{{$job->additional_child_info->category->name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Course</p>
                        <p class="">{{$job->additional_child_info->course->name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Subjects</p>

                        <p class="">@foreach($job->additional_child_info->job_offer_additional_child_subjects as
                            $subject)

                            {{$subject->subject->title ?? 'N/A'}},&nbsp;&nbsp;

                            @endforeach </p>
                    </div>
                </div>
            </div>
        </div>

        @endif --}}


        <div class="mb-4 " >
            <div class="bg-white py-4 shadow-lg rounded-3" style="min-height: 480px">
                <h5 class="mb-5 ms-4">Location</h5>
                <div class="">
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Country</p>
                        <p class="">{{$job->country->name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">City</p>
                        <p class="">{{$job->city->name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Location</p>
                        <p class="">{{$job->location->name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Details Address</p>
                        <p class="">
                            {{ Str::limit($job->full_address ?? 'N/A') }}



                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="bg-white py-4 shadow-lg rounded-3" style="min-height: 480px">
                <h5 class="mb-5 ms-4">Title Note</h5>
                <div class="">
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Tutor Requirement</p>
                        <p class="">
                            {{ Str::limit($job->tutor_requirement ?? 'N/A') }}

                        </p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Staff Note</p>
                        <p class="">{{ $job->staff_note ?? '' }}


                        </p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Special Note</p>
                        <p class="">
                            {{ Str::limit($job->special_note ?? 'N/A') }}

                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="bg-white py-4 shadow-lg rounded-3">
                <h5 class="mb-5 ms-4">Tutor Requirement -1</h5>
                <div class="">
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">
                            Preferred Tutoring Category
                        </p>
                        <p class="">@foreach($job->job_offer_tutor_categories as $category)

                            {{$category->name ?? 'N/A'}},&nbsp;&nbsp;

                            @endforeach </p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Course</p>
                        <p class="">@foreach($job->job_offer_tutor_courses as $course)

                            {{$course->name ?? 'N/A'}},&nbsp;&nbsp;

                            @endforeach</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Subjects</p>
                        <p class="">@foreach($job->job_offer_tutor_subjects as $subject)

                            {{$subject->subject->title ?? 'N/A'}},&nbsp;&nbsp;

                            @endforeach </p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Tutor's Gender</p>
                        <p class="">{{$job->tutor_gender ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Tutor's Religion</p>
                        <p class="">{{$job->tutor_religion ?? 'N/A'}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="bg-white py-4 shadow-lg rounded-3">
                <h5 class="mb-5 ms-4">Tutor Requirement -2</h5>
                <div class="">
                    <div class="row row-cols-2 border-bottom  mb-3 g-0 mx-4">
                        <p class="fw-semibold">University</p>

                        <p class="">@foreach($job->job_offer_tutor_universities as $university)

                            {{$university->title ?? 'N/A'}},&nbsp;&nbsp;

                            @endforeach</p>

                        {{-- <span class="badge badge-success">{{$university->title}}</span> --}}
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">



                        <p class="fw-semibold">University Type</p>

                        <p class="">{{$job->tutor_university_type ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Study Type</p>
                        <p class="">@foreach($job->job_offer_tutor_study_types as $studyType)

                            {{$studyType->title  ?? 'N/A'}},&nbsp;&nbsp;

                            @endforeach</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Departments</p>
                        <p class="">@foreach($job->job_offer_tutor_departments as $department)

                            {{$department->title ?? 'N/A'}},&nbsp;&nbsp;

                            @endforeach</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Year</p>
                        <p class="">{{$job->year}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="bg-white py-4 shadow-lg rounded-3">
                <h5 class="mb-5 ms-4">Tutor Requirement -3</h5>
                <div class="">
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">School</p>
                        <p class="">{{$job->tutorSchool->title ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">College</p>
                        <p class="">{{$job->tutorCollege->title ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Board</p>
                        <p class="">{{$job->tutor_board ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Group</p>
                        <p class="">{{$job->tutor_group ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Background Curriculum</p>
                        <p class="">{{$job->tutorCurriculam->title ?? 'N/A'}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="bg-white py-4 shadow-lg rounded-3">
                <h5 class="mb-5 ms-4">Source Information</h5>
                <div class="">
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Channel</p>
                        <p class="">{{$source->channel ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Source Name</p>
                        <p class="">{{$source->source_name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Source ID</p>
                        <p class="">
                            <a href="#
                      job.html" class="text-decoration-none text-info">{{$source->source_code ?? 'N/A'}}</a>
                        </p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Offer Created By</p>
                        <p class="">{{$job->user->name ?? 'N/A'}}</p>
                    </div>
                    <div class="row row-cols-2 border-bottom border-1 mb-3 g-0 mx-4">
                        <p class="fw-semibold">Offer Created At</p>
                        <p class="">{{$job->created_at ?? 'N/A'}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">

        <a class="btn btn-primary" href="{{ route('admin.job.edit', ['id' => $job->id]) }}">Edit</a>


    </div>
    </div>


    <div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
        <div class="bg-white p-2 rounded-3 shadow-lg mt-4">
            <div class="table-responsive">

                <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                        <tr>
                            <th scope="col" class="text-nowrap">Sl</th>
                            <th scope="col" class="text-nowrap">Job ID</th>

                            <th scope="col " class="text-nowrap">
                                Created By
                            </th>
                            <th scope="col " class="text-nowrap">Input Time</th>
                            <th scope="col " class="text-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr class="" style="vertical-align: middle">
                                <td><b>1</b></td>
                                <td>{{$job_created_log->job_id}}</td>
                                <td class="">{{$job_created_log->user->name}}</td>
                                <td class="text-nowrap">
                                    <p class="mb-0 mt-3">{{$job_created_log->updated_at}}</p>
                                </td>
                                <td>
                                    <a href="{{ route('admin.job.jobLogDetails', ['id' => $job_created_log->job_id]) }}"
                                     class="btn btn-primary text-nowrap">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                    </tbody>
                </table>

                <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                        <tr>
                            <th scope="col">sl</th>
                            <th scope="col" class="text-nowrap">Job ID</th>

                            <th scope="col " class="text-nowrap">
                                Edited By
                            </th>
                            <th scope="col " class="text-nowrap">Input Time</th>
                            <th scope="col " class="text-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($job_edit_log as $item)
                            <tr class="" style="vertical-align: middle">
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$item->job_id}}</td>
                                <td class="">{{$item->updater->name ?? ''}}</td>
                                <td class="text-nowrap">
                                    <p class="mb-0 mt-3">{{$item->updated_at}}</p>
                                </td>
                                <td>
                                    <a href="{{ route('admin.job.edit-history.view-details', ['id' => $item->id]) }}?job_id={{ $item->job_id }}"
                                    class="btn btn-primary text-nowrap">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- main content section ends here -->
    </div>
</main>




@endsection

@push('page_scripts')


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

@endpush
