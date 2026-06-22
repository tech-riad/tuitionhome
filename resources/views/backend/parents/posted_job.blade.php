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
        <!-- tab like button group (it should be tab) -->
        <div class="pt-4 row row-cols-2">
            <div>
                <a href="{{route('admin.view.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid #669ad1;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">View</a>
            </div>
            <div>
                <a href="{{route('admin.edit.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
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
            <a class="text-decoration-none text-gray-800  text-nowrap"
                href="{{route('admin.view.parent',$parent->id)}}">About Me</a>
            <a class="text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.view.parent',$parent->id)}}">Dashboard
                Details</a>
            
            <a class="text-decoration-none text-gray-800 text-nowrap active-border"
                href="{{route('admin.parent.posted.job',$parent->id)}}">Posted
                Jobs</a>
            <a class="text-decoration-none text-gray-800 text-nowrap" href="/log-files/view/status.html">Status</a>
            <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="/log-files/view/basic-log.html">Basic Log</a>
            <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="/log-files/view/advance-log.html">Advance Log</a>
        </div>
        <!-- mini nav ends here -->
        <!-- contents starts here -->
        <div>
            <!-- welcome section -->
            <div
                class="shadow-lg bg-white rounded d-flex flex-column py-4 flex-lg-row justify-content-center align-items-center">
                <div class="p-4">
                    <p class="mb-2" style="font-weight: 600; font-size: 34px">
                        Welcome to Tuition Terminal
                    </p>
                    <p class="w-75 text-muted">
                        Tuition Terminal is an outstanding platform. It's incredible
                        how smoothly and neatly the entire communication process has
                        been carried out. From guardians to teachers, people are
                        receiving
                    </p>
                </div>
                <div class="pe-lg-4">
                    <img class="" src="/images/welcome-img2.svg" alt="welcome-image" />
                </div>
            </div>
            <!-- status section -->
            <div class="mt-4 mb-4 row row-cols-1 row-cols-md-2 row-cols-lg-3">
                <div>
                    <div class="bg-white mb-4 mb-xl-0 rounded shadow-lg px-4 py-2 mb-xl-4">
                        <div class="d-flex gap-4 justify-content-start align-items-center">
                            <div class="text-white py-2 px-3 shadow-lg rounded" style="background-color: #86c240">
                                <i class="bi bi-patch-check-fill fs-4"></i>
                            </div>
                            <div class="pt-3">
                                <div class="d-flex justify-content-center align-itema-center flex-column">
                                    <p class="fs-3 fw-bold mb-0">{{$liveOffJobsCount + $liveOnJobsCount}}</p>
                                    <p class="text-gray-600 text-nowrap" style="font-size: 14px">
                                        All Approved Job
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-white mb-4 mb-xl-0 rounded shadow-lg px-4 py-2 mb-xl-4">
                        <div class="d-flex gap-4 justify-content-start align-items-center">
                            <div class="text-white py-2 px-3 shadow-lg rounded" style="background-color: #3378c2">
                                <i class="bi bi-broadcast fs-4"></i>
                            </div>
                            <div class="pt-3">
                                <div class="d-flex justify-content-center align-itema-center flex-column">
                                    <p class="fs-3 fw-bold mb-0">{{$liveOnJobsCount}}</p>
                                    <p class="text-gray-600 text-nowrap" style="font-size: 14px">
                                        Live On Job
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-white mb-4 mb-xl-0 rounded shadow-lg px-4 py-2 mb-xl-4">
                        <div class="d-flex gap-4 justify-content-start align-items-center">
                            <div class="text-white py-2 px-3 shadow-lg rounded" style="background-color: #c4c7cc">
                                <i class="bi bi-broadcast-pin fs-4"></i>
                            </div>
                            <div class="pt-3">
                                <div class="d-flex justify-content-center align-itema-center flex-column">
                                    <p class="fs-3 fw-bold mb-0">{{$liveOffJobsCount}}</p>
                                    <p class="text-gray-600 text-nowrap" style="font-size: 14px">
                                        Live Off Job
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- live on carousel section starts-->
            <div class="pb-4">
                <p class="fs-3 fw-semibold mb-4">Live on Tuition Job</p>
                <!-- This class must be unique! -->
                <div class="owl-carousel live-on-owl-carousel">
                    @foreach ($liveOnJobs as $item)
                    <div class="bg-white p-4 shadow-lg rounded mb-1">
                        <div class="d-flex justify-content-between align-items-start mb-5">
                            <h4 class="text-gray-800">{{$item->course->name}}</h4>
                            <div>
                                <h6 class="text-gray-800 text-end">Job ID -{{$item->id}}</h6>
                                <h6 class="text-gray-800 text-end">
                                    <i class="bi bi-clock-fill"></i> {{ $item->created_at->diffForHumans() }}
                                </h6>
                            </div>
                        </div>
                        <div class="row" style="min-height: 300px">
                            <div class="col-12 mb-5 d-flex align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <span class="fw-600 mx-2 fw-500 text-nowrap mt-1">
                                    {{$item->location->name}}, {{$item->city->name}} - {{ $item->created_at->format('M d, Y') }}
                                </span>
                            </div>

                            <div class="col-6 mb-5 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-file-text-fill"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Subjects
                                    </span>
                                    <p class="">@foreach($item->job_offer_student_subjects as $subject)

                                        {{$subject->subject->title ?? 'N/A'}},&nbsp;&nbsp;

                                        @endforeach </p>
                                </div>
                            </div>
                            <div class="col-6 mb-5 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-tags-fill"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Category
                                    </span>
                                    <p class="ml-40 text-gray-600 text-nowrap">
                                        {{$item->category->name}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-gender-ambiguous"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Tutor Gender
                                    </span>
                                    <p class="ml-40 text-gray-600 text-nowrap">{{$item->student_gender}}</p>
                                </div>
                            </div>
                            <div class="col-6 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-cash"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Salary
                                    </span>
                                    <p class="ml-40 text-gray-600 text-nowrap">
                                        BDT {{$item->salary}} Tk
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex border-top border-2 pt-3 justify-content-end">
                                <a target="_blank" href="{{ route('admin.job-details', ['job' => $item->id]) }}"
                                    class="btn bg-dark rounded-3 text-white"
                                    style="background-color: #e6eef7">View Details</a>

                        </div>
                    </div>

                    @endforeach


                </div>
                <div class="d-flex justify-content-center">
                    <!-- This id must be unique, otherwise navigation won't show up! -->
                    <div id="postAJob_LiveOn_navContainer"></div>
                </div>
            </div>
            <!-- live on carousel section ends-->
            <!-- live off carousel section starts-->
            <div class="pb-4" style="opacity: 0.5">
                <p class="fs-3 fw-semibold mb-4">Live Off Tuition Job</p>
                <!-- This class must be unique! -->
                <div class="owl-carousel live-off-owl-carousel">
                    @foreach ($liveOffJobs as $item)
                    <div class="bg-white p-4 shadow-lg rounded mb-1">
                        <div class="d-flex justify-content-between align-items-start mb-5">
                            <h4 class="text-gray-800">{{$item->course->name}}</h4>
                            <div>
                                <h6 class="text-gray-800 text-end">Job ID -{{$item->id}}</h6>
                                <h6 class="text-gray-800 text-end">
                                    <i class="bi bi-clock-fill"></i> {{ $item->created_at->diffForHumans() }}

                                </h6>
                            </div>
                        </div>
                        <div class="row" style="min-height: 300px">
                            <div class="col-12 mb-5 d-flex align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <span class="fw-600 mx-2 fw-500 text-nowrap mt-1">
                                    {{$item->location->name}}, {{$item->city->name}} - {{ $item->created_at->format('M d, Y') }}
                                </span>
                            </div>

                            <div class="col-6 mb-5 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-file-text-fill"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Subjects
                                    </span>
                                    <p class="">@foreach($item->job_offer_student_subjects as $subject)

                                        {{$subject->subject->title ?? 'N/A'}},&nbsp;&nbsp;

                                        @endforeach </p>
                                </div>
                            </div>
                            <div class="col-6 mb-5 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-tags-fill"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Category
                                    </span>
                                    <p class="ml-40 text-gray-600 text-nowrap">
                                        {{$item->category->name}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-gender-ambiguous"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Tutor Gender
                                    </span>
                                    <p class="ml-40 text-gray-600 text-nowrap">{{$item->student_gender}}</p>
                                </div>
                            </div>
                            <div class="col-6 d-flex gap-2 align-itema-center">
                                <div class="fit-icon text-white bg-primary rounded shadow-lg">
                                    <i class="bi bi-cash"></i>
                                </div>
                                <div class="mt-1">
                                    <span class="fw-600 text-nowrap fw-500">
                                        Salary
                                    </span>
                                    <p class="ml-40 text-gray-600 text-nowrap">
                                        BDT {{$item->salary}} Tk
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex border-top border-2 pt-3 justify-content-end">
                                <a target="_blank" href="{{ route('admin.job-details', ['job' => $item->id]) }}"
                                    class="btn bg-dark rounded-3 text-white"
                                    style="background-color: #e6eef7">View Details</a>

                        </div>
                    </div>

                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    <!-- This id must be unique, otherwise navigation won't show up! -->
                    <div id="postAJob_LiveOff_navContainer"></div>
                </div>
            </div>
            <!-- live off carousel section ends-->
        </div>
        <!-- contents ends here -->
    </div>
</main>

@endsection
