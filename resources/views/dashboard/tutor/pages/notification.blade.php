@extends('dashboard.tutor.layout')
@push('css')
@endpush

@section('content')
    <div class="t-dashboard-contant  px-2 py-md-3 " style="margin-left: 245px">
        <div class="d-flex justify-content-start  ">
            @include('dashboard.tutor.pages.src.setting_menu')
            <!-- nav ends -->
            <div class="mx-1 mx-md-3 flex-fill rounded-2" style="background-color: white">
                <div class="mx-auto w-100">
                    <div
                        style="background-color: #fbfff6; height: 68px"
                        class="d-flex justify-content-start align-items-center px-3 rounded-2"
                    >
                        <h6>Notifications</h6>
                    </div>
                    <div class="mx-0 mx-md-5 mt-3 mt-md-5">
                        <div
                            class="d-flex flex-wrap flex-md-nowrap justify-content-evenly"
                        >
                            <div class="px-3">
                                <div class="mb-5">
                                    <p class="fw-bold">Email Notifications</p>
                                    <p class="t-text-gray py-4">
                                        Get emails to find out what”s going on when you”re not
                                        online. You can turn these off.
                                    </p>
                                </div>

                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold text-nowrap"
                                            for="flexSwitchCheckDefault"
                                        >News And Updates</label
                                        >
                                    </div>
                                    <div class="t-text-gray mt-md-0 text-nowrap " style="margin-left: 40px;">
                                        News about products and feature updates.
                                    </div>
                                </div>

                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch ">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold"
                                            for="flexSwitchCheckDefault"
                                        >Tips And Tutorials</label
                                        >
                                        <div class="t-text-gray mt-3 mt-md-0">
                                            Tips on getting more out of tution.
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch ">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold"
                                            for="flexSwitchCheckDefault"
                                        >User Research</label
                                        >
                                        <div class="t-text-gray mt-3">
                                            Get involved in our beta testing program or
                                            participate in paid product user research..
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold"
                                            for="flexSwitchCheckDefault"
                                        >Comments</label
                                        >
                                        <div class="t-text-gray mt-3">
                                            Comments on your posts and replies to comments.
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch ">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold"
                                            for="flexSwitchCheckDefault"
                                        >Reminders</label
                                        >
                                        <div class="t-text-gray my-3">
                                            These are notification to remind you of updates you
                                            might have missed.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-3">
                                <div class="mb-5">
                                    <p class="fw-bold">Push Notifications</p>
                                    <p class="t-text-gray py-4 mt-3">
                                        Get push notification in_app to find out what”s going
                                        on when you”re online.
                                    </p>
                                </div>
                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold text-nowrap"
                                            for="flexSwitchCheckDefault"
                                        >Comments</label
                                        >
                                    </div>
                                    <div class="t-text-gray my-2 " style="margin-left: 40px;">
                                        Comments on your posts and replies to comments.
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold text-nowrap"
                                            for="flexSwitchCheckDefault"
                                        >Reminders</label
                                        >
                                    </div>
                                    <div class="t-text-gray   my-4" style="margin-left: 40px;">
                                        These are notification to remind you of updates you
                                        might have missed.
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between my-3">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                        />
                                        <label
                                            class="form-check-label fw-bold text-nowrap"
                                            for="flexSwitchCheckDefault"
                                        >More activity about you</label
                                        >
                                    </div>
                                    <div class="t-text-gray my-4 " style="margin-left: 40px;">
                                        These are notification for posts on your profile,
                                        likes and other reactions to your posts, and more.
                                    </div>
                                </div>





                            </div>
                        </div>

                        <div
                            class="my-4 d-flex justify-content-md-end justify-content-center mb-md-5"
                        >
                            <button class="t-btn-primary btn px-5 mx-3">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('js')
@endpush
