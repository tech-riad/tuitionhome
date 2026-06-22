@extends('dashboard.tutor.layout')
@push('css')
@endpush

@section('content')
    <div class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog pay-model modal-content">
            <div class="d-flex justify-content-between">
                <h6 class="" id="exampleModalLabel">Payment For Tutor Matching</h6>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="d-flex">
                <button type="button" class="balance-btn">My Balance</button>
                <button type="button" class="pay-btn-white mx-2" style="padding: 22px">
                    Apply
                </button>
            </div>
            <div class="pay-desc">
                <div class="d-flex justify-content-between fw-bold">
                    <p>Description</p>
                    <p>Amount</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="fw-light">Tution Matching | Job Id : 2746</p>
                    <p class="fw-light"><spam class="fw-bold">4000</spam>/taka</p>
                </div>
                <div class="d-flex justify-content-between fw-bold border-top pt-2">
                    <p>Total Amount</p>
                    <p class="fw-light"><spam class="fw-bold">4000</spam>/taka</p>
                </div>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="flexCheckChecked"
                    checked
                />
                <label
                    style="font-size: 14px"
                    class="form-check-label"
                    for="flexCheckChecked"
                >
                    Please check to accept our
                    <span class="text-primary">Privacy Policy and Terms of Use</span>
                </label>
            </div>
            <button type="button" class="balance-btn">Pay 4000 Taka</button>

        </div>
    </div>
    <div class="t-dashboard-contant p-4" x-data="{ open: false }">

        <div class="d-flex flex-wrap flex-md-row mb-3">
            <div class="mx-4 status-link status-link-border">
                <a class="t-link" href="jobs.html"> Current Status (7) </a>
            </div>
            <div class="mx-4 status-link">
                <a class="t-link" href="job-aplied.html"> Applied (10) </a>
            </div>
            <div class="mx-4 status-link">Shortlisted (6)</div>
            <div class="mx-4 status-link">Apointed (1)</div>
            <div class="mx-4 status-link">Payment (10)</div>
            <div class="mx-4 status-link">Cancl (8)</div>
        </div>

        <!-- job detail slider -->
        <div
            class="job-detail-slider position-fixed"
            x-show="open"
            x-transition
        >
            <div class="mb-2" @click="open = false">
                <i class="bi bi-arrow-right-circle fs-4"></i>
            </div>
            <div class="d-flex flex-column d-scroll">
                <div>
                    <p>Student Information</p>
                    <div
                        class="slider-student-info d-flex flex-wrap mb-3 border border-primary"
                    >
                        <div class="row mx-auto t-card-body">
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                          <span class="fs-custom text-nowrap"
                          >Bangla Medium
                          </span>
                                        <br />
                                        <span class="key text-nowrap">Category</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">Class 10 </span>
                                        <br />
                                        <span class="key text-nowrap">Course</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap"> Math</span>
                                        <br />
                                        <span class="key text-nowrap">Subjects</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">4 day </span>
                                        <br />
                                        <span class="key text-nowrap">Days In Week</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">Class 10 </span>
                                        <br />
                                        <span class="key text-nowrap">Tutoring Time</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">One Hour </span>
                                        <br />
                                        <span class="key text-nowrap">Tutoring Duration</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                          <span class="fs-custom text-nowrap"
                          >Students Home
                          </span>
                                        <br />
                                        <span class="key text-nowrap">Tutoring Method</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">20000 </span>
                                        <br />
                                        <span class="key text-nowrap">Salary</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">Female</span>
                                        <br />
                                        <span class="key text-nowrap">Student Gender</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">8 pm</span>
                                        <br />
                                        <span class="key text-nowrap">Tutoring Time </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Tutor Requierments</p>
                    <div class="slider-tutor-requ mb-3">
                        <div class="row mx-auto mt-0 t-card-body">
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">Male </span>
                                        <br />
                                        <span class="key text-nowrap">Tutor Gender</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                          <span class="fs-custom text-nowrap"
                          >45 Feb 288457
                          </span>
                                        <br />
                                        <span class="key text-nowrap">Hiring Date</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                          <span class="fs-custom text-nowrap">
                            Math, English</span
                          >
                                        <br />
                                        <span class="key text-nowrap">Subjects</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                          <span class="fs-custom text-nowrap"
                          >Experienced Tutor
                          </span>
                                        <br />
                                        <span class="key text-nowrap">Tutor Requirment</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Tutoring Locations</p>
                    <div class="slider-tutor-location mb-3">
                        <div class="row mx-auto t-card-body">
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                                        <span class="fs-custom text-nowrap">Dhaka </span>
                                        <br />
                                        <span class="key text-nowrap">City</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                          <span class="fs-custom text-nowrap"
                          >Mohammadpur
                          </span>
                                        <br />
                                        <span class="key text-nowrap">Locayion</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex slider-card-item">
                                <img
                                    style="height: 36px; margin-top: 20px"
                                    src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                                />
                                <div class="mx-3 mt-3">
                                    <p>
                          <span class="fs-custom text-nowrap">
                            10/5, main road</span
                          >
                                        <br />
                                        <span class="key text-nowrap">Address</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-flex">
                    <button class="pay-btn-white px-5">Direction</button>
                    <button class="pay-btn-white mx-3 px-5">Location</button>
                </div>
            </div>
        </div>
        <!-- job detail slider end -->

        <div class="row">

            <!-- card starts -->
            <div class="col col-md-6 job-card  c-margin">
                <div class="d-flex justify-content-start">
                    <div>
                        <p class="key">Job ID : <span class="value">12456</span></p>
                    </div>
                    <div>
                        <p class="key">
                            Posted date : <span class="value">23 Feb 2023</span>
                        </p>
                    </div>
                    <div>
                        <p class="key">
                            Apply Date : <span class="value">27 Feb 2023</span>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="t-alert mx-auto my-2">
                        <p>Payment Pending</p>
                    </div>
                </div>
                <div>
                    <div class="row mx-auto t-card-body">
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">Class 10 </span>
                                    <br />
                                    <span class="key text-nowrap">Class</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Bangla Medium
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Version</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Mirpur 1, Tolarberg
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Location</span>
                                </p>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom t-primary text-nowrap"
                        >Apointed
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Status</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">4000 </span>
                                    <br />
                                    <span class="key text-nowrap">Carge</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">23 Jan 2040 </span>
                                    <br />
                                    <span class="key text-nowrap">Payment Date</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="divider mx-auto mb-3"></div>
                        <div class="d-flex justify-content-end">
                            <button class="pay-btn-white mx-3" @click="open = !open">
                                View
                            </button>
                            <button
                                class="pay-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                            >
                                Pay Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end -->
            <div class="col col-md-6 job-card c-margin">
                <div class="d-flex justify-content-start">
                    <div>
                        <p class="key">Job ID : <span class="value">12456</span></p>
                    </div>
                    <div>
                        <p class="key">
                            Posted date : <span class="value">23 Feb 2023</span>
                        </p>
                    </div>
                    <div>
                        <p class="key">
                            Apply Date : <span class="value">27 Feb 2023</span>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="t-alert mx-auto my-2">
                        <p>Payment Pending</p>
                    </div>
                </div>
                <div>
                    <div class="row mx-auto t-card-body">
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">Class 10 </span>
                                    <br />
                                    <span class="key text-nowrap">Class</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Bangla Medium
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Version</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Mirpur 1, Tolarberg
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Location</span>
                                </p>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom t-primary text-nowrap"
                        >Apointed
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Status</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">4000 </span>
                                    <br />
                                    <span class="key text-nowrap">Carge</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">23 Jan 2040 </span>
                                    <br />
                                    <span class="key text-nowrap">Payment Date</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="divider mx-auto mb-3"></div>
                        <div class="d-flex justify-content-end">
                            <button class="pay-btn-white mx-3">View</button>
                            <button class="pay-btn">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end -->
            <div class="col col-md-6 job-card c-margin">
                <div class="d-flex justify-content-start">
                    <div>
                        <p class="key">Job ID : <span class="value">12456</span></p>
                    </div>
                    <div>
                        <p class="key">
                            Posted date : <span class="value">23 Feb 2023</span>
                        </p>
                    </div>
                    <div>
                        <p class="key">
                            Apply Date : <span class="value">27 Feb 2023</span>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="t-alert mx-auto my-2">
                        <p>Payment Pending</p>
                    </div>
                </div>
                <div>
                    <div class="row mx-auto t-card-body">
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">Class 10 </span>
                                    <br />
                                    <span class="key text-nowrap">Class</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Bangla Medium
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Version</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Mirpur 1, Tolarberg
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Location</span>
                                </p>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom t-primary text-nowrap"
                        >Apointed
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Status</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">4000 </span>
                                    <br />
                                    <span class="key text-nowrap">Carge</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">23 Jan 2040 </span>
                                    <br />
                                    <span class="key text-nowrap">Payment Date</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="divider mx-auto mb-3"></div>
                        <div class="d-flex justify-content-end">
                            <button class="pay-btn-white mx-3">View</button>
                            <button class="pay-btn">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end -->
            <div class="col col-md-6 job-card c-margin ">
                <div class="d-flex justify-content-start">
                    <div>
                        <p class="key">Job ID : <span class="value">12456</span></p>
                    </div>
                    <div>
                        <p class="key">
                            Posted date : <span class="value">23 Feb 2023</span>
                        </p>
                    </div>
                    <div>
                        <p class="key">
                            Apply Date : <span class="value">27 Feb 2023</span>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="t-alert mx-auto my-2">
                        <p>Payment Pending</p>
                    </div>
                </div>
                <div>
                    <div class="row mx-auto t-card-body">
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">Class 10 </span>
                                    <br />
                                    <span class="key text-nowrap">Class</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Bangla Medium
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Version</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex card-item">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom text-nowrap"
                        >Mirpur 1, Tolarberg
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Location</span>
                                </p>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                        <span class="fs-custom t-primary text-nowrap"
                        >Apointed
                        </span>
                                    <br />
                                    <span class="key text-nowrap">Status</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">4000 </span>
                                    <br />
                                    <span class="key text-nowrap">Carge</span>
                                </p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <img
                                style="height: 36px; margin-top: 20px"
                                src="{{ asset('dashboard/tutor') }}/assets/class-icon.svg"
                            />
                            <div class="mx-3 mt-3">
                                <p>
                                    <span class="fs-custom text-nowrap">23 Jan 2040 </span>
                                    <br />
                                    <span class="key text-nowrap">Payment Date</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="divider mx-auto mb-3"></div>
                        <div class="d-flex justify-content-end">
                            <button class="pay-btn-white mx-3">View</button>
                            <button class="pay-btn">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end -->
        </div>
        </div>

@endsection
@push('js')
@endpush
