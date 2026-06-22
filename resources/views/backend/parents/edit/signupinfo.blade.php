@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')

<!-- navbar ends here -->


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
                            <a class="t-link text-primary d-none d-lg-block text-nowrap text-decoration-none"
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
                <div>
                    <div class="d-flex gap-4 flex-wrap justify-content-center align-items-center">
                        <div class="d-flex justify-content-center align-items-center flex-column gap-4">
                            <div class="text-gray-500">
                                <i class="bi bi-1-circle-fill fs-3"></i>
                            </div>
                            <div>
                                <button class="btn btn-secondary shadow-lg fs-4 text-gray-800 px-5 py-4" data-bs-toggle="modal"
                                    data-bs-target="#nameModel" data-id="{{ $parent->id }}"  style="border-left: 5px solid #3b3c3d">
                                    <i class="bi bi-person-circle text-primary me-2 fs-3"></i>
                                    Name
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center flex-column gap-4">
                            <div class="text-primary">
                                <i class="bi bi-2-circle-fill fs-3"></i>
                            </div>
                            <div>
                                <button class="btn btn-secondary shadow-lg fs-4 text-gray-800 px-5 py-4"
                                    data-bs-toggle="modal" data-bs-target="#phoneModel"
                                    data-id="{{ $parent->id }}"
                                    style="border-left: 5px solid #3b3c3d">
                                    <i class="bi bi-telephone-fill text-primary me-2 fs-3"></i>
                                    Phone
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-column gap-4">
                            <div class="text-primary">
                                <i class="bi bi-3-circle-fill fs-3"></i>
                            </div>
                            <div>
                                <button class="btn btn-secondary shadow-lg fs-4 text-gray-800 px-5 py-4"
                                    data-bs-toggle="modal" data-bs-target="#emailModel" data-id="{{ $parent->id }}"

                                    style="border-left: 5px solid #3b3c3d">
                                    <i class="bi bi-envelope-open-fill text-primary me-2 fs-4"></i>
                                    Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <section>
                    <div class="modal fade" id="nameModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-2">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        Update Name
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-2">
                                    <input type="text" id="nameInput"  class="form-control shadow-none input-lg rounded"
                                        placeholder="{{$parent->name}}" />
                                    <p id="errorMessage" class="fs-12 text-danger mb-0 d-none">Error Message</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="d-none" data-bs-dismiss="modal">
                                        close
                                    </button>
                                    <button type="button" class="btn btn-primary" id="saveNameBtn">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                            let userId;


                            $('#nameModel').on('show.bs.modal', function (event) {
                                let button = $(event.relatedTarget);
                                userId = button.data('id');
                            });

                            $('#saveNameBtn').on('click', function () {
                                let name = $('#nameInput').val();

                                if (name === '') {
                                    $('#errorMessage').removeClass('d-none').text('Name cannot be empty');
                                    return;
                                }

                                $.ajax({
                                    url: '/admin/parent/name-update/' + userId,
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        name: name
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            $('#nameModel').modal('hide');
                                            Swal.fire({
                                                    position: "top-end",
                                                    icon: "success",
                                                    title: "Name updated successfully",
                                                    showConfirmButton: false,
                                                    timer: 1000,
                                                }).then(() => {

                                                    location.reload();
                                                });

                                        } else {
                                            $('#errorMessage').removeClass('d-none').text(response.error || 'An error occurred');
                                        }
                                    },
                                    error: function (xhr) {
                                        $('#errorMessage').removeClass('d-none').text('An error occurred. Please try again.');
                                    }
                                });
                            });
                        });

                        </script>
                    </div>
                </section>

                <section>
                    <div class="modal fade" id="phoneModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-2">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        Update Phone
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-2">
                                    <input type="text" id="phoneInput" class="form-control shadow-none input-lg rounded"
                                        placeholder="{{$parent->phone}}" />
                                    <p id="phoneErrorMessage" class="fs-12 text-danger mb-0 d-none">Error message</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="d-none" data-bs-dismiss="modal">
                                        close
                                    </button>
                                    <button type="button" class="btn btn-primary" id="savePhoneBtn">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                let userId;


                                $('#phoneModel').on('show.bs.modal', function (event) {
                                    let button = $(event.relatedTarget);
                                    userId = button.data('id');
                                });


                                $('#savePhoneBtn').on('click', function () {
                                    let phone = $('#phoneInput').val();

                                    if (phone === '') {
                                        $('#phoneErrorMessage').removeClass('d-none').text('Phone number cannot be empty');
                                        return;
                                    }

                                    $.ajax({
                                        url: '/admin/parent/phone-update/' + userId,
                                        method: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            phone: phone
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                $('#phoneModel').modal('hide');
                                                Swal.fire({
                                                    position: "top-end",
                                                    icon: "success",
                                                    title: "Phone updated successfully",
                                                    showConfirmButton: false,
                                                    timer: 1000,
                                                }).then(() => {

                                                    location.reload();
                                                });

                                            } else {
                                                $('#phoneErrorMessage').removeClass('d-none').text(response.error || 'An error occurred');
                                            }
                                        },
                                        error: function (xhr) {
                                            $('#phoneErrorMessage').removeClass('d-none').text('An error occurred. Please try again.');
                                        }
                                    });
                                });
                            });

                        </script>
                    </div>
                </section>

                <section>
                    <div class="modal fade" id="emailModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-2">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Email</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-2">
                                    <input type="text" id="emailInput" class="form-control shadow-none input-lg rounded" placeholder="{{$parent->email}}" />
                                    <p id="emailErrorMessage" class="fs-12 text-danger mb-0 d-none">Error message</p>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="button" class="btn btn-warning" id="verifyEmailBtn">Verify Email</button>
                                    <div class="">
                                        <button class="d-none" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="saveEmailBtn">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            let userId;


                            $('#emailModel').on('show.bs.modal', function (event) {
                                let button = $(event.relatedTarget);
                                userId = button.data('id');
                            });

                            // Handle the save button click
                            $('#saveEmailBtn').on('click', function () {
                                let email = $('#emailInput').val();

                                if (email === '') {
                                    $('#emailErrorMessage').removeClass('d-none').text('Email cannot be empty');
                                    return;
                                }

                                $.ajax({
                                    url: '/admin/parent/email-update/' + userId,
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        email: email
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            $('#emailModel').modal('hide');
                                            Swal.fire({
                                                position: "top-end",
                                                icon: "success",
                                                title: "Email updated successfully",
                                                showConfirmButton: false,
                                                timer: 1000,
                                            }).then(() => {

                                                location.reload();
                                            });
                                        } else {
                                            $('#emailErrorMessage').removeClass('d-none').text(response.error || 'An error occurred');
                                        }
                                    },
                                    error: function (xhr) {
                                        $('#emailErrorMessage').removeClass('d-none').text('An error occurred. Please try again.');
                                    }
                                });
                            });
                        });
                    </script>

                </section>

                <!-- settings content ends here -->
            </div>
        </div>
        <!-- contents ends here -->
    </div>
</main>

@endsection
@push('page_scripts')


@endpush
