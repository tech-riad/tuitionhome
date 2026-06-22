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
            <a class="text-decoration-none text-gray-800 " href="{{route('tutor.index')}}">All Tutors</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.premium')}}">Premium Tutor</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.featured')}}">Featured Tutor</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.verified')}}">Verified Tutor</a>
            <a class="text-decoration-none text-gray-800 active-border"
                href="{{route('admin.tutor.member.count')}}">Membership Count</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.counting')}}">Count</a>
        </div>
        @if(session('message'))
        <p class="alert alert-success">{{ session('message') }}</p>
        @endif
        <div style="margin-left: 18px">
            <h2>Membership Count:</h2>
        </div>
        <div id="count" style="margin-left: 18px">
            <div class="owl-carousel">
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$totalPremium ?? '' }}
                        </h2>
                        <span>Total Premium</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$activePremium ?? '' }}
                        </h2>
                        <span>Active Premium</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$regularPremium ?? '' }}
                        </h2>
                        <span>Regular Premium</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$proPremium ?? '' }}
                        </h2>
                        <span>Pro Premium</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$advancePremium ?? '' }}
                        </h2>
                        <span>Advance Premium</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$todayPremium ?? '' }}
                        </h2>
                        <span>Today Premium</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$confirmedTutorsCount ?? '' }}
                        </h2>
                        <span>Job Confirm PM</span>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-left: 18px">
            <h2>Verified Count:</h2>
        </div>
        <div id="count" style="margin-left: 18px">
            <div class="owl-carousel">
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$totalVerify ?? '' }}
                        </h2>
                        <span>Total Verify</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$activeVerify ?? '' }}
                        </h2>
                        <span>Active Verify</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$inActiveVerify ?? '' }}
                        </h2>
                        <span>Inactive Verify</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$todayVerify ?? '' }}
                        </h2>
                        <span>Today Verify</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$confirmedTutorsCountv ?? '' }}
                        </h2>
                        <span>Job Confirm</span>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-left: 18px">
            <h2>Boost Count:</h2>
        </div>
        <div id="count" style="margin-left: 18px">
            <div class="owl-carousel">
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$totalBoost ?? '' }}
                        </h2>
                        <span>Total Boost</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$activeBoost ?? '' }}
                        </h2>
                        <span>Active Boost</span>
                    </div>
                </div>

                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$oneMonthBoost ?? '' }}
                        </h2>
                        <span>One Month B</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$threeMonthBoost ?? '' }}
                        </h2>
                        <span>Three Month B</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$sixMonthBoost ?? '' }}
                        </h2>
                        <span>Six Month B</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$twelveMonthBoost ?? '' }}
                        </h2>
                        <span>Twelve Month B</span>
                    </div>
                </div>
                <div
                    class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                    <div class="report-card " style="text-align:center">
                        <h2>{{$confirmedTutorsCountb ?? '' }}
                        </h2>
                        <span>Job Confirm</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

        @endsection
