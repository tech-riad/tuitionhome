@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')

<!-- sidebar ends here -->
<main class="">
    <div class="col-lg-12 ms-sm-auto col-lg-12 px-3" style="margin-top: 62px">
        <!-- tab like button group (it should be tab) -->
        <div class="pt-4 row row-cols-2">
            <div>
                <a href="{{route('admin.view.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid white;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">View</a>
            </div>
            <div>
                <a href="{{route('admin.edit.parent',$parent->id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid #669ad1;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">Edit</a>
            </div>
        </div>
        <!-- tab like button group ends -->
        <!-- contents starts here -->
        <div class="row gx-1 gx-lg-4 my-lg-4 mt-4 mt-lg-4">
            <div class="col-12 col-xl-3 col-lg-4">
                <div class="bg-white rounded-3 shadow-lg" style="max-height: 400">
                    <ul class="ps-0 d-flex flex-lg-column justify-content-between px-2">
                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link  d-none d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent',$parent->id)}}">
                                <i class="bi bi-person-fill mx-2"></i>Sign-up
                                Information
                            </a>
                            <a class="t-link d-lg-none d-block" href="{{route('admin.edit.parent',$parent->id)}}">
                                <i class="bi bi-person-fill mx-2 fs-1"></i>
                            </a>
                        </li>

                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link d-none d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent.other.info',$parent->id)}}">
                                <i class="bi bi-person-vcard-fill mx-2"></i>Others
                                Information
                            </a>
                            <a class="t-link d-lg-none d-block"
                                href="{{route('admin.edit.parent.other.info',$parent->id)}}">
                                <i class="bi bi-bell-fill mx-2 fs-1"></i>
                            </a>
                        </li>

                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link d-none d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent.password',$parent->id)}}">
                                <i class="bi bi-shield-lock-fill mx-2"></i>Password &
                                Security
                            </a>
                            <a class="t-link d-lg-none d-block" href="{{route('admin.edit.parent.password',$parent->id)}}">
                                <i class="bi bi-shield-lock-fill mx-2 fs-1"></i>
                            </a>
                        </li>

                        <li
                            class="setting-nav-item px-xl-4 px-lg-2 d-flex justify-content-center justify-content-lg-start align-items-center">
                            <a class="t-link d-none text-primary d-lg-block text-nowrap text-decoration-none"
                                href="{{route('admin.edit.parent.account.status',$parent->id)}}">
                                <i class="bi bi-gear-fill mx-2"></i>Accounts Status
                            </a>
                            <a class="t-link d-lg-none d-block" href="{{route('admin.edit.parent.account.status',$parent->id)}}">
                                <i class="bi bi-gear-fill mx-2 fs-1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-xl-9 col-lg-8">
                <!-- settings content starts here -->

                <div class="bg-white shadow-lg mb-4" style="border-radius: 8px">
                    <div style="
                      height: 68px;
                      border-top-left-radius: 8px;
                      border-top-right-radius: 8px;
                    " class="d-flex justify-content-start pt-3 align-items-center px-4 bg-primary text-white">
                        <p class="">Profile Status</p>
                    </div>
                    <div class="px-4 py-4">
                        <div class="">
                            <div class="">
                                <p class="fw-600 m-0 fw-light text-primary">
                                    Your profile has no issues
                                </p>
                                <div class="border w-100 my-1"></div>
                                <p class="fw-ligh m-0 fw-light">
                                    Your profile is now unlocked, and you can update it
                                    whenever you want.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-2">
                            <button class="btn btn-primary shadow-lg px-5 rounded-3">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-lg mb-4" style="border-radius: 8px">
                    <div style="
                      height: 68px;
                      border-top-left-radius: 8px;
                      border-top-right-radius: 8px;
                    " class="d-flex justify-content-start pt-3 align-items-center px-4 bg-warning text-white">
                        <p class="">Profile Status</p>
                    </div>
                    <div class="px-4 py-4">
                        <div class="">
                            <div class="">
                                <p class="fw-600 m-0 fw-light text-warning">
                                    Your profile has some issues
                                </p>
                                <div class="border w-100 my-1"></div>
                                <p class="fw-ligh m-0 fw-light">
                                    Your profile has been violating our terms & policies,
                                    so be aware of using it features.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-2">
                            <button class="btn btn-warning shadow-lg px-5 rounded-3">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-lg" style="border-radius: 8px">
                    <div style="
                      height: 68px;
                      border-top-left-radius: 8px;
                      border-top-right-radius: 8px;
                    " class="d-flex justify-content-start pt-3 align-items-center px-4 bg-danger text-white">
                        <p class="">Profile Status</p>
                    </div>
                    <div class="px-4 py-4">
                        <div class="">
                            <div class="">
                                <p class="fw-600 m-0 fw-light text-danger">
                                    Your profile is locked
                                </p>
                                <div class="border w-100 my-1"></div>
                                <p class="fw-ligh m-0 fw-light">
                                    To unlock your profile, please contact with the
                                    administrator 09678 444477.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-2">
                            <button class="btn btn-danger shadow-lg px-5 rounded-3">
                                Contact
                            </button>
                        </div>
                    </div>
                </div>

                <!-- settings content ends here -->
            </div>
        </div>
        <!-- contents ends here -->
    </div>
</main>
@endsection
