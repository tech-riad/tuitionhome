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

        @php
        $dhaka = App\Models\JobOffer::where('city_id',1)->count();
        $chittagong = App\Models\JobOffer::where('city_id',3)->count();
        $sylhet = App\Models\JobOffer::where('city_id',7)->count();
        $Rajshahi = App\Models\JobOffer::where('city_id',11)->count();
        $Barishal = App\Models\JobOffer::where('city_id',12)->count();
        $Khulna = App\Models\JobOffer::where('city_id',13)->count();
        $Rangpur = App\Models\JobOffer::where('city_id',10)->count();
        $Mymensingh = App\Models\JobOffer::where('city_id',9)->count();
        $Gazipur = App\Models\JobOffer::where('city_id',4)->count();
        $Manikganj = App\Models\JobOffer::where('city_id',32)->count();
        $Narayanganj = App\Models\JobOffer::where('city_id',5)->count();
        $Narsingdi = App\Models\JobOffer::where('city_id',18)->count();
        $Tangail = App\Models\JobOffer::where('city_id',24)->count();
        $Bogra = App\Models\JobOffer::where('city_id',14)->count();
        $Pabna = App\Models\JobOffer::where('city_id',26)->count();
        $Dinajpur = App\Models\JobOffer::where('city_id',25)->count();
        $Thakurgaon = App\Models\JobOffer::where('city_id',46)->count();
        $Patuakhali = App\Models\JobOffer::where('city_id',68)->count();
        $Brahmanbaria = App\Models\JobOffer::where('city_id',20)->count();
        $Chandpur = App\Models\JobOffer::where('city_id',40)->count();
        $Cumilla = App\Models\JobOffer::where('city_id',8)->count();
        $Coxbazar = App\Models\JobOffer::where('city_id',30)->count();
        $Noakhali = App\Models\JobOffer::where('city_id',19)->count();
        $Feni = App\Models\JobOffer::where('city_id',16)->count();
        $Jashore = App\Models\JobOffer::where('city_id',17)->count();
        $Savar = App\Models\JobOffer::where('city_id',6)->count();
        @endphp

        <h2>All Offer Count ::</h2>

        <div class="owl-carousel">
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">{{App\Models\jobOffer::all()->count()}}</p>
                <p class="">All offer</p>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{ App\Models\JobOffer::whereDate('live_off_date', today())->count() }}</p>

                <p class="">Today Live Off Offer</p>
            </div>

            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{ App\Models\JobOffer::whereDate('created_at', now()->format('Y-m-d'))->count() }}</p>

                <p class="">Todays Offer</p>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{ $uniqueJobsShortlistedToday->unique_jobs_shortlisted_today }}

                    <p class="">Today Shortlisted</p>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{ $uniqueJobsTakenToday->unique_jobs_taken_today }}

                    <p class="">Today Assign Jobs</p>
            </div>

            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$dhaka}}
                </p>
                <p>Dhaka</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$chittagong }}
                </p>
                <p>Chittagong</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$sylhet}}
                </p>
                <p>Sylhet</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Rajshahi}}
                </p>
                <p>Rajshahi</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Barishal }}
                </p>
                <p>Barishal</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Khulna }}
                </p>
                <p>Khulna</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Rangpur }}
                </p>
                <p>Rangpur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Mymensingh }}
                </p>
                <p>Mymensingh</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Gazipur }}
                </p>
                <p>Gazipur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Manikganj }}
                </p>
                <p>Manikganj</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Narayanganj }}
                </p>
                <p>Narayanganj</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Narsingdi }}
                </p>
                <p>Narsingdi</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Tangail }}
                </p>
                <p>Tangail</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Bogra }}
                </p>
                <p>Bogra</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Pabna }}
                </p>
                <p>Pabna</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Dinajpur }}
                </p>
                <p>Dinajpur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Thakurgaon }}
                </p>
                <p>Thakurgaon</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Patuakhali }}
                </p>
                <p>Patuakhali</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Brahmanbaria }}
                </p>
                <p>Brahmanbaria</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Chandpur }}
                </p>
                <p>Chandpur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Cumilla }}
                </p>
                <p>Cumilla</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Coxbazar }}
                </p>
                <p>Coxbazar</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Noakhali }}
                </p>
                <p>Noakhali</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Feni }}
                </p>
                <p>Feni</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Jashore }}
                </p>
                <p>Jashore</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Savar }}
                </p>
                <p>Savar
                </p>
            </div>
        </div>

        <h2>Available Offer Count::</h2>

        @php
        $dhaka = App\Models\JobOffer::where('city_id',1)->where('is_active',1)->count();
        $chittagong = App\Models\JobOffer::where('city_id',3)->where('is_active',1)->count();
        $sylhet = App\Models\JobOffer::where('city_id',7)->where('is_active',1)->count();
        $Rajshahi = App\Models\JobOffer::where('city_id',11)->where('is_active',1)->count();
        $Barishal = App\Models\JobOffer::where('city_id',12)->where('is_active',1)->count();
        $Khulna = App\Models\JobOffer::where('city_id',13)->where('is_active',1)->count();
        $Rangpur = App\Models\JobOffer::where('city_id',10)->where('is_active',1)->count();
        $Mymensingh = App\Models\JobOffer::where('city_id',9)->where('is_active',1)->count();
        $Gazipur = App\Models\JobOffer::where('city_id',4)->where('is_active',1)->count();
        $Manikganj = App\Models\JobOffer::where('city_id',32)->where('is_active',1)->count();
        $Narayanganj = App\Models\JobOffer::where('city_id',5)->where('is_active',1)->count();
        $Narsingdi = App\Models\JobOffer::where('city_id',18)->where('is_active',1)->count();
        $Tangail = App\Models\JobOffer::where('city_id',24)->where('is_active',1)->count();
        $Bogra = App\Models\JobOffer::where('city_id',14)->where('is_active',1)->count();
        $Pabna = App\Models\JobOffer::where('city_id',26)->where('is_active',1)->count();
        $Dinajpur = App\Models\JobOffer::where('city_id',25)->where('is_active',1)->count();
        $Thakurgaon = App\Models\JobOffer::where('city_id',46)->where('is_active',1)->count();
        $Patuakhali = App\Models\JobOffer::where('city_id',68)->where('is_active',1)->count();
        $Brahmanbaria = App\Models\JobOffer::where('city_id',20)->where('is_active',1)->count();
        $Chandpur = App\Models\JobOffer::where('city_id',40)->where('is_active',1)->count();
        $Cumilla = App\Models\JobOffer::where('city_id',8)->where('is_active',1)->count();
        $Coxbazar = App\Models\JobOffer::where('city_id',30)->where('is_active',1)->count();
        $Noakhali = App\Models\JobOffer::where('city_id',19)->where('is_active',1)->count();
        $Feni = App\Models\JobOffer::where('city_id',16)->where('is_active',1)->count();
        $Jashore = App\Models\JobOffer::where('city_id',17)->where('is_active',1)->count();
        $Savar = App\Models\JobOffer::where('city_id',6)->where('is_active',1)->count();
        @endphp


        <div class="owl-carousel">
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">{{App\Models\jobOffer::where('is_active', 1)->count()}}</p>
                <p class="">Available Offer</p>
            </div>

            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{ App\Models\JobOffer::whereDate('created_at', now()->format('Y-m-d'))->where('is_active', 1)->count() }}

                </p>
                <p class="">Todays Available Offer</p>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$dhaka}}
                </p>
                <p>Dhaka</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$chittagong }}
                </p>
                <p>Chittagong</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$sylhet}}
                </p>
                <p>Sylhet</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Rajshahi}}
                </p>
                <p>Rajshahi</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Barishal }}
                </p>
                <p>Barishal</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Khulna }}
                </p>
                <p>Khulna</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Rangpur }}
                </p>
                <p>Rangpur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Mymensingh }}
                </p>
                <p>Mymensingh</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Gazipur }}
                </p>
                <p>Gazipur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Manikganj }}
                </p>
                <p>Manikganj</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Narayanganj }}
                </p>
                <p>Narayanganj</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Narsingdi }}
                </p>
                <p>Narsingdi</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Tangail }}
                </p>
                <p>Tangail</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Bogra }}
                </p>
                <p>Bogra</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Pabna }}
                </p>
                <p>Pabna</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Dinajpur }}
                </p>
                <p>Dinajpur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Thakurgaon }}
                </p>
                <p>Thakurgaon</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Patuakhali }}
                </p>
                <p>Patuakhali</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Brahmanbaria }}
                </p>
                <p>Brahmanbaria</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Chandpur }}
                </p>
                <p>Chandpur</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Cumilla }}
                </p>
                <p>Cumilla</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Coxbazar }}
                </p>
                <p>Coxbazar</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Noakhali }}
                </p>
                <p>Noakhali</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Feni }}
                </p>
                <p>Feni</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Jashore }}
                </p>
                <p>Jashore</p>

            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <p class="fw-bold fs-5 mb-1 mt-3">
                    {{$Savar }}
                </p>
                <p>Savar
                </p>
            </div>
        </div>


    </div>
</main>






@endsection
