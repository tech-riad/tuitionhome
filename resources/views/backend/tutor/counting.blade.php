@extends('layouts.app')
@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>


<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #11ee24;
        color: black;
    }

</style>
@endpush
{{-- <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" /> --}}

@section('content')
<main class="">
    <div class="col-md-9 ms-sm-auto col-lg-12" style="">
        <!-- mini nav starts here -->
        <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
            <a class="text-decoration-none text-gray-800 active-border" href="{{route('tutor.index')}}">All Tutors</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.premium')}}">Premium Tutor</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.featured')}}">Featured Tutor</a>
        </div>

        @php

        // Dhaka
        $dhaka = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 1);
            })
            ->count();

        // Chittagong
        $chittagong = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 3);
            })
            ->count();

        // Sylhet
        $sylhet = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 7);
            })
            ->count();

        // Rajshahi
        $Rajshahi  = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 11);
            })
            ->count();

        // Barishal
        $Barishal = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 12);
            })
            ->count();

        // Khulna
        $Khulna = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 13);
            })
            ->count();

        // Rangpur
        $Rangpur = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 10);
            })
            ->count();

        // Mymensingh
        $Mymensingh = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 9);
            })
            ->count();

        // Gazipur
        $Gazipur = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 4);
            })
            ->count();

        // Manikganj
        $Manikganj = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 32);
            })
            ->count();

        // Narayanganj
        $Narayanganj = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 5);
            })
            ->count();

        // Narsingdi
        $Narsingdi = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 18);
            })
            ->count();

        // Tangail
        $Tangail = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 24);
            })
            ->count();

        // Bogra
        $Bogra = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 14);
            })
            ->count();

        // Pabna
        $Pabna = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 26);
            })
            ->count();

        // Dinajpur
        $Dinajpur = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 25);
            })
            ->count();

        // Thakurgaon
        $Thakurgaon = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 46);
            })
            ->count();

        // Patuakhali
        $Patuakhali = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 68);
            })
            ->count();

        // Brahmanbaria
        $Brahmanbaria = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 20);
            })
            ->count();

        // Chandpur
        $Chandpur = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 40);
            })
            ->count();

        // Cumilla
        $Cumilla = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 8);
            })
            ->count();

        // Cox's Bazar
        $Coxbazar = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 30);
            })
            ->count();

        // Noakhali
        $Noakhali = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 19);
            })
            ->count();

        // Feni
        $Feni = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 16);
            })
            ->count();

        // Jashore
        $Jashore = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 17);
            })
            ->count();

        // Savar
        $Savar = App\Models\Tutor::where('is_active', 1)
            ->whereHas('tutorPersonalInfo', function ($query) {
                $query->where('city_id', 6);
            })
            ->count();

            $todayInactive = App\Models\Tutor::whereDate('inactive_date', '=', \Carbon\Carbon::now())->count();



        @endphp

        @if(session('message'))
        <p class="alert alert-success">{{ session('message') }}</p>
        @endif

        <div id="count" style="margin-left: 18px">
            <div class="owl-carousel">
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $all_tutor_count ?? ''}}</h2>
                        <span>All Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $all_tutor_confirm ?? ''}}</h2>
                        <span>All Confirm Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $todayInactive ?? ''}}</h2>
                        <span>Today Inactive Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ App\Models\Tutor::where('is_active', 1)->count() }}
                        </h2>
                        <span>Active Tutor</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ App\Models\Tutor::where('is_active', 0)->count() }}
                        </h2>
                        <span>Inactive Tutor</span>
                    </div>
                </div>

                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ App\Models\Tutor::whereDate('verify_date', today())->count() }}
                        </h2>
                        <span>Today Verified Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ App\Models\Tutor::whereDate('created_at', today())->count() }}
                        </h2>
                        <span>Today New Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ App\Models\Tutor::whereDate('created_at', today())->where('gender', 'male')->count() }}
                        </h2>
                        <span>Today Male New Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ App\Models\Tutor::whereDate('created_at', today())->where('gender', 'female')->count() }}
                        </h2>
                        <span>Today Female New Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $uniqueTutorsTakenToday->unique_tutors_taken_today ?? 0 }}
                        </h2>
                        <span>Today Assign Tutor</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $uniqueTutorsShortlistedToday->unique_tutors_shortlisted_today ?? 0 }}
                        </h2>
                        <span>Today Shortlisted Tutor</span>
                    </div>
                </div>

                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $male_tutor_count ?? ''}}</h2>
                        <span>Male Active Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $female_tutor_count ?? ''}}</h2>
                        <span>Female Active Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $premium_tutor_count ?? ''}}</h2>
                        <span>Premium Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ $featured_tutor_count ?? ''}}</h2>
                        <span>Featured Tutors</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">

                                  <h2>
                                    {{App\Models\Tutor::where('is_active', 1)
                                    ->whereHas('tutor_education', function ($query) {
                                        $query->where('degree_name', 'ssc')->where('curriculum_id', 2);
                                    })
                                    ->count();}}

                                  </h2>
                        <span>English Medium(S.S.C)</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">

                        <h2>
                            {{App\Models\Tutor::where('is_active', 1)
                            ->whereHas('tutor_education', function ($query) {
                                $query->where('degree_name', 'ssc')->where('curriculum_id', 3);
                            })
                            ->count();}}

                          </h2>
                        <span>English Version(S.S.C)</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{ App\Models\TutorCourse::where('course_id', 80)
                        ->count() }}
                        </h2>
                        <span>Islamic Studies Tutor</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$dhaka}}
                        </h2>
                        <span>Dhaka</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$chittagong }}
                        </h2>
                        <span>Chittagong</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$sylhet}}
                        </h2>
                        <span>Sylhet</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Rajshahi}}
                        </h2>
                        <span>Rajshahi</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Barishal }}
                        </h2>
                        <span>Barishal</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Khulna }}
                        </h2>
                        <span>Khulna</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Rangpur }}
                        </h2>
                        <span>Rangpur</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Mymensingh }}
                        </h2>
                        <span>Mymensingh</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Gazipur }}
                        </h2>
                        <span>Gazipur</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Manikganj }}
                        </h2>
                        <span>Manikganj</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Narayanganj }}
                        </h2>
                        <span>Narayanganj</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Narsingdi }}
                        </h2>
                        <span>Narsingdi</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Tangail }}
                        </h2>
                        <span>Tangail</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Bogra }}
                        </h2>
                        <span>Bogra</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Pabna }}
                        </h2>
                        <span>Pabna</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Dinajpur }}
                        </h2>
                        <span>Dinajpur</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Thakurgaon }}
                        </h2>
                        <span>Thakurgaon</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Patuakhali }}
                        </h2>
                        <span>Patuakhali</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Brahmanbaria }}
                        </h2>
                        <span>Brahmanbaria</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Chandpur }}
                        </h2>
                        <span>Chandpur</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Cumilla }}
                        </h2>
                        <span>Cumilla</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Coxbazar }}
                        </h2>
                        <span>Coxbazar</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Noakhali }}
                        </h2>
                        <span>Noakhali</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Feni }}
                        </h2>
                        <span>Feni</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Jashore }}
                        </h2>
                        <span>Jashore</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$Savar }}
                        </h2>
                        <span>Savar</span>
                    </div>
                </div>
            </div>
        </div>


@endsection
