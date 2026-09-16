@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@push('page_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endpush

@section('content')

<div>
    <h3>Social Media</h3>
</div>

@if(session('message'))
<p class="alert alert-success">{{ session('message') }}</p>
@endif


<main class="container-custom">
    <div class="row">
        <div class="col-lg-12">
            <section class="content">

                <div class="card">

                    <div class="card-header">
                        <a href="" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#exampleModal"> <i class="fas fa-plus-circle"></i> Add Account</a>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Social Media Account</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="socialMediaForm" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Laravel CSRF token -->
                                        <div class="form-group">
                                            {!! Form::label('name', 'Name:') !!}
                                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('link', 'URL:') !!}
                                            {!! Form::text('link', null, ['class' => 'form-control', 'id' => 'link']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('logo', 'Logo:') !!}
                                            {!! Form::file('logo', ['class' => 'form-control', 'id' => 'logo']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label for="userRole">View For</label>
                                            <br>
                                            @foreach ($roles as $item)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $item->id }}" >
                                                <label class="form-check-label" for="role_{{ $item->id }}">{{ $item->name }}</label>
                                            </div>
                                            <br>
                                            @endforeach
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>

                                    <div id="responseMessage" class="mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .card {
                            position: relative;
                            overflow: hidden;
                        }

                        .image-container {
                            position: relative;
                        }

                        .overlay {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0, 0, 0, 0.6);
                            opacity: 0;
                            transition: opacity 0.3s ease-in-out;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 15px;
                        }

                        .image-container:hover .overlay {
                            opacity: 1;
                        }

                        .overlay a {
                            color: white;
                            font-size: 18px;
                            background: rgba(14, 13, 13, 0.7);
                            padding: 10px;
                            border-radius: 50%;
                            transition: background 0.3s;
                        }

                        .overlay a:hover {
                            background: rgba(53, 52, 52, 0.5);
                        }

                    </style>
                    <div class="card-body">

                        <div class="row">
                            @foreach ($socialmedia as $item)
                            <div class="col-lg-3">
                                <div class="card" style="width: 12rem;">
                                    <div class="image-container">
                                        <img class="card-img-top"
                                        src="{{ Storage::disk('r2')->url('logos/' . $item->logo) }}"
                                        alt="{{ $item->name }}"
                                        style="padding:40px;">
                                        <div class="overlay">

                                            @if(in_array(auth()->user()->role_id, [1, 6]))
                                            <a href="javascript:void(0);" class="editSocialMediaBtn" data-id="{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" onclick="deleteItem({{ $item->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                            @endif






                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <a target="_blank" href="{{ $item->link }}" class="btn btn-primary">
                                            {{ $item->name }}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card-body -->

                <!-- /.card -->

                <!-- Modal for editing social media -->
                <!-- Modal for editing social media -->
                <!-- Modal for editing social media -->
                <div class="modal fade" id="editSocialMediaModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Social Media</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="socialMediaFormEdit" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" id="socialMediaId">

                                    <div class="form-group">
                                        {!! Form::label('name', 'Name:') !!}
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'oldName']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('link', 'URL:') !!}
                                        {!! Form::text('link', null, ['class' => 'form-control', 'id' => 'oldLink']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('logo', 'Logo:') !!}
                                        {!! Form::file('logo', ['class' => 'form-control', 'id' => 'logo']) !!}
                                        <img id="currentLogo" src="" alt="Current Logo" style="max-width: 100px; margin-top: 10px;">
                                    </div>

                                    <div class="form-group">
                                        <label for="userRole">View For</label>
                                        <br>
                                        @foreach ($roles as $item)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $item->id }}" id="role_{{ $item->id }}">
                                            <label class="form-check-label" for="role_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                        <br>
                                        @endforeach
                                    </div>

                                    <div class="mt-3">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>





            </section>
        </div>
    </div>
</main>





@endsection


@push('page_scripts')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select roles...",
            allowClear: true,
            closeOnSelect: false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#socialMediaForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this); // Create FormData object
            let url = "{{ route('admin.add.social.media') }}"; // Get the route URL

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // Show a loading Swal message
                    Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait while we save the data.',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: "Social Media Account Added Successfully!",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            $('#socialMediaForm')[0].reset(); // Reset form
                            $('#socialMediaModal').modal('hide'); // Close modal if applicable
                            location.reload(); // Refresh data table or list
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong!",
                            icon: "error"
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "";

                    if (errors) {
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + "\n"; // Collect errors
                        });
                    } else {
                        errorMessage = "An error occurred. Please try again.";
                    }

                    Swal.fire({
                        title: "Validation Error!",
                        text: errorMessage,
                        icon: "warning"
                    });
                },
                complete: function() {
                    $('.btn-primary').prop('disabled', false).text('Save changes');
                }
            });
        });
    });
</script>



<script>
    $(document).ready(function () {
        $('.editSocialMediaBtn').on('click', function () {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ url('/admin/get-social-media') }}/" + id,
                type: "GET",
                success: function (response) {
                if (response.success) {
                    let data = response.data;
                    $('#socialMediaId').val(data.id);
                    $('#oldName').val(data.name);
                    $('#oldLink').val(data.link);

                    if (data.logo) {
                        $('#currentLogo').attr('src', data.logo).show();
                    } else {
                        $('#currentLogo').hide();
                    }

                    $('input[name="roles[]"]').prop('checked', false);

                    if (data.roles) {
                        let selectedRoles = data.roles.split(',');
                        selectedRoles.forEach(function (roleId) {
                            $('input[name="roles[]"][value="' + roleId + '"]').prop('checked', true);
                        });
                    }

                    $('#editSocialMediaModal').modal('show');
                } else {
                    Swal.fire("Error!", "Data not found.", "error");
                }
            },
                error: function () {
                    Swal.fire("Error!", "Failed to fetch data.", "error");
                }
            });
        });

        $('#socialMediaFormEdit').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            let id = $('#socialMediaId').val();
            let url = "{{ url('/admin/update-social-media') }}/" + id;

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait...',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: "Social Media Account Updated Successfully!",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            $('#editSocialMediaModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error!", "Something went wrong!", "error");
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "An error occurred. Please try again.";
                    if (errors) {
                        errorMessage = "";
                        $.each(errors, function (key, value) {
                            errorMessage += value[0] + "\n";
                        });
                    }
                    Swal.fire("Validation Error!", errorMessage, "warning");
                }
            });
        });
    });
</script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    function deleteItem(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "This social media account will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/social-media') }}/" + id,
                    type: "POST",
                    data: {
                        _method: "DELETE",
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: "Deleting...",
                            text: "Please wait...",
                            icon: "info",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message || "The social media account has been deleted.",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Error!", response.message || "Delete failed.", "error");
                        }
                    },
                    error: function(xhr) {
                        let message = "There was an error processing your request.";

                        if (xhr.status === 403) {
                            message = "403 Forbidden. CSRF token or permission issue.";
                        } else if (xhr.status === 404) {
                            message = "Delete route not found.";
                        } else if (xhr.status === 419) {
                            message = "CSRF token mismatch or session expired.";
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire("Error!", message, "error");
                    }
                });
            }
        });
    }
</script>




@endpush
