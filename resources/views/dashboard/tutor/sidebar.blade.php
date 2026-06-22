<div class="mx-auto" style="max-width: 1530px">
    <div
        class="t-sidebar position-fixed d-md-block"
        x-transition
        x-show="open"
    >
        <div class="t-user-details mx-auto">
            <div style="position: relative">
{{--                <?php--}}
{{--                if (isset($tutor)){--}}
{{--                if ($tutor->pic != null)--}}
{{--                {?>--}}
{{--                <img--}}
{{--                    style="height: 80px; border-radius: 50%"--}}
{{--                    src="{{ asset('files/profile') }}/{{$tutor->pic}}" class="profile_image_view"--}}
{{--                    alt="user"--}}
{{--                />--}}
{{--                <?php } elseif ($tutor->t_user->gender == 'male')--}}
{{--                {?>--}}
{{--                <img--}}
{{--                    style="height: 80px; border-radius: 50%"--}}
{{--                    src="{{ asset('dashboard/tutor') }}/assets/user.svg"--}}
{{--                    alt="user"--}}
{{--                />--}}

{{--                <?php }elseif ($tutor->t_user->gender == 'female')--}}
{{--                {?>--}}
{{--                <img--}}
{{--                    style="height: 80px; border-radius: 50%"--}}
{{--                    src="{{ asset('dashboard/tutor') }}/assets/default_female.png"--}}
{{--                    alt="user"--}}
{{--                />--}}
{{--                <?php }--}}
{{--                }--}}
{{--                ?>--}}


            </div>
            <p class="t-username mt-3">{{ Auth::guard('tutor')->user()->name }}</p>
            <p class="t-user-id mt-2">Tutor ID {{ Auth::guard('tutor')->user()->id }}</p>
        </div>
        <div class="t-line"></div>

        <div class="d-scroll">
            <div class="t-sidebar-item">
                <div class="t-logo-container">
                    <img
                        style="margin-left: 1px"
                        src="{{ asset('/dashboard/tutor') }}/assets/home-icon.svg"
                        alt="home-icon"
                    />
                    <p class="t-sidebar-item-text">
                        <a class="t-link" href="{{ route('tutor.dashboard') }}">Dashboard</a>
                    </p>
                </div>
            </div>
            <div class="t-sidebar-item">
                <div class="t-logo-container-gray">
                    <img
                        style="margin-left: 1px"
                        src="{{ asset('/dashboard/tutor') }}/assets/jobs-icon.svg"
                        alt="home-icon"
                    />
                    <p class="t-sidebar-item-text">
                        <a class="t-link" href="{{ route('tutor.jobs-board') }}">Jobs</a>
                    </p>
                </div>
            </div>
            <!-- collaps -->
            <div>
                <div class="t-sidebar-item">
                    <div class="t-logo-container-gray">
                        <img
                            style="margin-left: 1px"
                            src="{{ asset('/dashboard/tutor') }}/assets/user-profile-icon.svg"
                            alt="home-icon"
                        />
                        <a
                            class="t-sidebar-item-text t-link"
                            data-bs-toggle="collapse"
                            href="#collapseExample"
                            role="button"
                            aria-expanded="false"
                            aria-controls="collapseExample"
                        >
                            Tutor Profile
                        </a>
                    </div>
                </div>

                <div class="collapse" id="collapseExample">
                    <div>
                        <div class="t-collaps-item">
                            <p class="t-collaps-item-text">
                                <a class="t-link" href="{{ route('tutor.profile-view') }}"
                                >View Profile</a
                                >
                            </p>
                        </div>
                        <div class="t-collaps-item">
                            <p class="t-collaps-item-text">
                                <a class="t-link" href="{{ route('tutor.profile.update') }}"
                                >Profile Update</a
                                >
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- collaps end -->
            <div class="t-sidebar-item">
                <div class="t-logo-container-gray">
                    <img
                        style="margin-left: 1px"
                        src="{{ asset('/dashboard/tutor') }}/assets/history-icon.svg"
                        alt="home-icon"
                    />
                    <p class="t-sidebar-item-text">Tutoring History</p>
                </div>
            </div>
            <div class="t-sidebar-item">
                <div class="t-logo-container-gray">
                    <img
                        style="margin-left: 1px"
                        src="{{ asset('/dashboard/tutor') }}/assets/payment-icon.svg"
                        alt="home-icon"
                    />
                    <p class="t-sidebar-item-text">
                        <a class="t-link" href="{{ route('tutor.payment') }}">Payment</a>
                    </p>
                </div>
            </div>
            <div class="t-sidebar-item">
                <div class="t-logo-container-gray">
                    <img
                        style="margin-left: 1px"
                        src="{{ asset('/dashboard/tutor') }}/assets/confarmation-icon.svg"
                        alt="home-icon"
                    />
                    <p class="t-sidebar-item-text">
                        <a class="t-link" href="{{ route('tutor.confirmation') }}">Confarmetion Latter</a>
                    </p>
                </div>
            </div>
            <div class="t-sidebar-item">
                <div class="t-logo-container-gray">
                    <img
                        style="margin-left: 1px"
                        src="{{ asset('/dashboard/tutor') }}/assets/copy-success.svg"
                        alt="home-icon"
                    />
                    <p class="t-sidebar-item-text">
                        <a class="t-link" href="{{ route('tutor.membership') }}">Membership </a>
                    </p>
                </div>
            </div>
            <div class="t-sidebar-item">
                <div class="t-logo-container-gray">
                    <img
                        style="margin-left: 1px"
                        src="{{ asset('/dashboard/tutor') }}/assets/settings.svg"
                        alt="home-icon"
                    />
                    <p class="t-sidebar-item-text">
                        <a class="t-link" href="{{ route('tutor.Setting') }}">Settings </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
