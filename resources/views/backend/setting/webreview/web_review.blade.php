@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')

<div>
    <h3>Website Reviews</h3>
</div>

@if(session('message'))
<p class="alert alert-success">{{ session('message') }}</p>
@endif

<div class="card mb-4" id="dataTable">


    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <!-- Trigger the modal with a button -->
        <a href="" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#exampleModal"> <i
                class="fas fa-plus-circle"></i> Add Review</a>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('profession', 'Profession:') !!}
                            {!! Form::text('profession', null, ['class' => 'form-control', 'id' => 'profession']) !!}
                            <span class="text-danger error-text profession_error"></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('image', 'Image:') !!}
                            {!! Form::file('image', ['class' => 'form-control', 'id' => 'image']) !!}
                            <span class="text-danger error-text image_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="userType">User Type</label>
                            <select name="user_type" id="userType" class="form-control" required>
                                <option value="">~Select user Type</option>
                                <option value="Tutor">Tutor</option>
                                <option value="Parent">Parent</option>
                                <option value="Affiliate Partner">Affiliate Partner</option>
                            </select>
                            <span class="text-danger error-text user_type_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">~Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <span class="text-danger error-text gender_error"></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('description', 'Description:') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
                            <span class="text-danger error-text description_error"></span>
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



    <div class="card-body">
        {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}
        <table id="datatablesSimple" class="dataTable-table">
            <thead>
                <tr>

                    <th data-sortable="" style="width: 8.6154%;"><a href="#" class="dataTable-sorter">SL</a></th>
                    <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">Image</a>
                    <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">User Type</a>
                    <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">Name</a>
                    <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">Gender</a>
                    </th>
                    <th data-sortable="" style="width: 9.13462%;"><a href="#" class="dataTable-sorter">Profession</a>
                    </th>
                    <th data-sortable="" style="width: 26.1923%"><a href="#" class="dataTable-sorter">description</a>
                    <th data-sortable="" style="width: 26.1923%"><a href="#" class="dataTable-sorter">Status</a>
                    </th>
                    <th data-sortable="" style="width: 9.13462%;"><a href="#" class="dataTable-sorter">Action</a></th>
                    {{-- <th data-sortable="" style="width: 11.4423%;"><a href="#" class="dataTable-sorter">Salary</a></th> --}}
                </tr>
            </thead>

            <tbody>

                @foreach ($reviews as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                <td>
                    @if($item->image)
                    <img style="height: 30px;width:30px" src="{{ asset('storage/' . $item->image) }}"
                        alt="Image" class="img-thumbnail">
                    @endif
                </td>
                <td>{{$item->user_type}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->gender}}</td>
                <td>{{$item->profession}}</td>
                <td>{!! Str::limit($item->description,100 ?? 'n/a') !!}</td>
                <td>
                    <div class="switch-toggle">
                        <div class="button-check" id="button-check" data-id="{{$item->id}}"
                            onclick="liveChange({{$item->id}})">
                            <input type="checkbox" class="checkbox" @if($item->status == 1) checked @endif
                            />
                            <span class="switch-btn"></span>
                            <span class="layer"></span>
                        </div>
                    </div>
                </td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm editReviewBtn" data-id="{{ $item->id }}">Edit Review</a>
                </td>
                </tr>


                @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center gap-2">

            {{ $reviews->links() }}

        </div>
    </div>
</div>
</div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReviewForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_review_id"> <!-- Store review ID -->

                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'edit_name']) !!}
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="form-group">
                        {!! Form::label('profession', 'Profession:') !!}
                        {!! Form::text('profession', null, ['class' => 'form-control', 'id' => 'edit_profession']) !!}
                        <span class="text-danger error-text profession_error"></span>
                    </div>

                    <div class="form-group">
                        {!! Form::label('image', 'Image:') !!}
                        {!! Form::file('image', ['class' => 'form-control', 'id' => 'edit_image']) !!}
                        <img id="edit_image_preview" src="" alt="Image Preview" class="mt-2" width="100">
                        <span class="text-danger error-text image_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit_userType">User Type</label>
                        <select name="user_type" id="edit_userType" class="form-control">
                            <option value="">~Select user Type</option>
                            <option value="Tutor">Tutor</option>
                            <option value="Parent">Parent</option>
                            <option value="Affiliate Partner">Affiliate Partner</option>
                        </select>
                        <span class="text-danger error-text user_type_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit_gender">Gender</label>
                        <select name="gender" id="edit_gender" class="form-control">
                            <option value="">~Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span class="text-danger error-text gender_error"></span>
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Description:') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'edit_description']) !!}
                        <span class="text-danger error-text description_error"></span>
                    </div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Review</button>
                    </div>
                </form>

                <div id="editResponseMessage" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('page_scripts')
<script type="text/javascript" src="{{asset('js/dashboard/blog/category_create.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('.error-text').text(''); // Clear previous error messages

            $.ajax({
                url: "{{ route('admin.reviews.website.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#reviewForm button[type="submit"]').prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    $('#reviewForm button[type="submit"]').prop('disabled', false).text('Save changes');

                    if (response.success) {
                        $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#reviewForm')[0].reset(); // Reset the form
                        setTimeout(() => { $('#exampleModal').modal('hide'); }, 2000); // Close modal after success
                    }
                },
                error: function(xhr) {
                    $('#reviewForm button[type="submit"]').prop('disabled', false).text('Save changes');

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        $('#responseMessage').html('<div class="alert alert-danger">Something went wrong! Try again.</div>');
                    }
                }
            });
        });


    });



</script>


<script>
    function liveChange(id) {
        var isChecked = $("#button-check[data-id='" + id + "'] .checkbox").is(":checked");
        var newState = isChecked ? 1 : 0;

        $.ajax({
            url: "{{ route('admin.web_review.status') }}",
            type: "POST",
            data: {
                state: newState,
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.status === "success") {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function (xhr, status, error) {
                toastr.error("An error occurred while updating status.");
            }
        });
    }
</script>


<script>
    $(document).ready(function() {
    // Fetch Review Data and Open Modal
    $(".editReviewBtn").click(function() {
        let reviewId = $(this).data("id");

        $.ajax({
            url: "/admin/web-reviews/" + reviewId + "/edit",
            type: "GET",
            success: function(response) {
                if (response.success) {
                    $("#edit_review_id").val(response.data.id);
                    $("#edit_name").val(response.data.name);
                    $("#edit_profession").val(response.data.profession);
                    $("#edit_userType").val(response.data.user_type);
                    $("#edit_gender").val(response.data.gender);
                    $("#edit_description").val(response.data.description);

                    if (response.data.image) {
                        $("#edit_image_preview").attr("src", "/storage/" + response.data.image);
                    } else {
                        $("#edit_image_preview").attr("src", "");
                    }

                    $("#editModal").modal("show");
                }
            }
        });
    });

    // Update Review
    $("#editReviewForm").submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "/admin/web-reviews/update",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                            title: "Success!",
                            text: "Review updated successfully!",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                } else {
                    alert("Error updating review.");
                }
            },
            error: function(response) {
                alert("Something went wrong!");
            }
        });
    });
});

</script>


@endpush


