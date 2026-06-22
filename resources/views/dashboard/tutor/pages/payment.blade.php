@extends('dashboard.tutor.layout')
@push('css')
@endpush

@section('content')
    <div class="t-dashboard-contant p-4">
        <div class="d-flex flex-wrap flex-md-row mb-3">
            <div class="mx-4 status-link status-link-border">
                <a class="t-link" href="jobs.html"> My Balance </a>
            </div>
            <div class="mx-4 status-link">
                <a class="t-link" href="payment-due.html"> Payment Due </a>
            </div>
            <div class="mx-4 status-link">Invoice</div>
            <div class="mx-4 status-link">Refund Coin</div>
        </div>

        <!-- ---------------------------------------------- -->
        <div class="balance-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="money-text">My Balance</p>
                    <h5>3000 Taka</h5>
                </div>
                <div>
                    <button class="money-btn">No Balance</button>
                </div>
            </div>
            <div class="border-top pt-3">
                <button class="float-end pay-detail-btn">View Details</button>
            </div>
        </div>
        <h6 class="py-4 money-text">Payment Pending for Tutor Matching</h6>
        <div class="d-flex flex-wrap">
            <div class="payment-painding mb-4">
                <div class="d-flex flex-wrap justify-content-between">
                    <h6 class="money-text">Payment Pending for Tutor Matching</h6>
                    <div class="d-flex flex-wrap">
                        <p class="key">Job Id : <span class="value">4577</span></p>
                        <p class="key">
                            Apply Date : <span class="value">20 Feb 7007</span>
                        </p>
                    </div>
                </div>
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class=" d-flex card-item">

                            <div class="mx-3">
                                <p>
                                    <span class="fs-custom text-nowrap">Class 10 </span>
                                    <br />
                                    <span class="key text-nowrap">Class</span>
                                </p>
                            </div>
                        </div>
                        <div class=" d-flex card-item ">

                            <div class="mx-3 ">
                                <p>
                                    <span class="fs-custom text-nowrap">Bangla Medium </span>
                                    <br />
                                    <span class="key text-nowrap">Category</span>
                                </p>
                            </div>
                        </div>
                        <div class=" d-flex card-item">

                            <div class="mx-3 ">
                                <p>
                                    <span class="fs-custom text-nowrap">Mohammadpur </span>
                                    <br />
                                    <span class="key text-nowrap">Location</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="pay-detail-btn mt-2 " style="width: auto;">View</button>
                    </div>
                </div>
            </div>

            <div class="deu-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="money-text">My Balance</p>
                        <h5>3000 Taka</h5>
                    </div>
                    <div>
                        <button class="money-btn">No Balance</button>
                    </div>
                </div>
                <div class="">
                    <button class="float-end pay-btn" style="font-size: 12px">
                        Pay Now
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
@endpush
