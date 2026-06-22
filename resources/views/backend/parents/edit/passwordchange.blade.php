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
                            <a class="t-link d-none text-primary d-lg-block text-nowrap text-decoration-none"
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
                            <a class="t-link d-none d-lg-block text-nowrap text-decoration-none"
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
                <div class="bg-white shadow-lg rounded-3">
                    <div style="background-color: #fbfff6; height: 68"
                        class="d-flex justify-content-start pt-3 align-items-center ps-5 rounded-3">
                        <p class="text-gray-900 ms-4">Passwords</p>
                    </div>
                    <div class="p-4 p-xl-5 mx-xl-4">
                        <form id="passwordUpdateForm">
                            <div class="row row-cols-1 row-cols-lg-2">
                                <div class="position-relative">
                                    <div class="form-floating mb-4">
                                        <input type="password" name="new_password" class="form-control shadowed-floating-input rounded-3"
                                            id="New_Password" placeholder="Type Here.." required />
                                        <label for="New_Password">New Password</label>
                                        <p class="fs-12 text-danger mb-0 error" id="new_password_error"></p>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <div class="form-floating mb-4">
                                        <input type="password" name="confirm_password" class="form-control shadowed-floating-input rounded-3"
                                            id="Re_Type_Password" placeholder="Type Here.." required />
                                        <label for="Re_Type_Password">Re-type Password</label>
                                        <p class="fs-12 text-danger mb-0 error" id="confirm_password_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-2">
                                <button type="submit" class="btn btn-primary shadow-lg px-5 py-2">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#passwordUpdateForm').on('submit', function (e) {
                            e.preventDefault();

                            let formData = {
                                new_password: $('#New_Password').val(),
                                confirm_password: $('#Re_Type_Password').val(),
                            };

                            $.ajax({
                                url: '/admin/parent/pass-update/{{ $parent->id }}',
                                type: 'POST',
                                data: formData,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Password updated successfully',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.message || 'Something went wrong!',
                                        });
                                    }
                                },
                                error: function (xhr) {
                                    let errors = xhr.responseJSON.errors;
                                    $('.error').text('');
                                    if (errors) {
                                        $('#new_password_error').text(errors.new_password);
                                        $('#confirm_password_error').text(errors.confirm_password);
                                    }
                                }
                            });
                        });
                    });

                </script>

                <!-- settings content ends here -->
            </div>
        </div>
        <!-- contents ends here -->
    </div>
</main>
@endsection
