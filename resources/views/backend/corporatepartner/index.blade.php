@extends('layouts.app')

@push('page_css')
<style>
        body {
            background-color: #f8f9fa;
        }
        .table-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-approved {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .badge-cancel {
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
@endpush


@section('content')
<main class="container-custom">

    <div class=" my-5">
        <div class="card table-card p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col"><input class="form-check-input" type="checkbox"></th>
                            <th scope="col">#SL</th>
                            <th scope="col">Date</th>
                            <th scope="col">Tutor ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action By</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        @foreach($requests as $request)
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td class="fw-bold">
                                {{ $requests->firstItem() + $loop->index }}
                            </td>
                            <td>{{$request->created_at->format('d-m-y')}}</td>
                            <td><a target="_blank" href="{{route('admin.tutor.tutorshow', $request->tutor_id)}}" class="fw-semibold text-decoration-none">A108186</a></td>
                            <td>{{$request->tutor->name}}</td>
                            <td>{{$request->tutor_personal_info->location->name ?? 'N/A'}}</td>
                            <td>{{$request->tutor->phone}}</td>
                            <td>
                                @if($request->status == 'pending')
                                    <span class="badge badge-pending px-3 py-2 rounded-pill">
                                        Pending
                                    </span>

                                @elseif($request->status == 'approved')
                                    <span class="badge badge-success px-3 py-2 rounded-pill">
                                        Approved
                                    </span>

                                @elseif($request->status == 'rejected')
                                    <span class="badge badge-danger px-3 py-2 rounded-pill">
                                        Rejected
                                    </span>

                                @else
                                    <span class="badge badge-secondary px-3 py-2 rounded-pill">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>—</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                @if($request->status == 'approved')

                                    <button type="button"
                                            class="btn btn-sm btn-success"
                                            disabled>
                                        <i class="fas fa-check-circle"></i> Applied
                                    </button>

                                {{-- @elseif($request->status == 'rejected')

                                    <button type="button"
                                            class="btn btn-sm btn-outline-success"
                                            >
                                        Apply Now
                                    </button> --}}

                                @else

                                    <button type="button"
                                            class="btn btn-sm btn-outline-success apply-request"
                                            data-url="{{ route('admin.cprequest.apply', $request->id) }}"
                                            data-id="{{ $request->id }}">
                                        Apply Now
                                    </button>

                                @endif
                               @if($request->status == 'rejected')

                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            disabled>
                                        <i class="fas fa-times-circle"></i> Cancelled
                                    </button>

                                @elseif($request->status == 'approved')

                                    {{-- Approved হলে আর Cancel করা যাবে না --}}

                                @else

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger cancel-request"
                                            data-url="{{ route('admin.cprequest.cancel', $request->id) }}"
                                            data-id="{{ $request->id }}">
                                        Cancel
                                    </button>

                                @endif
                                <a class="btn btn-sm btn-secondary">Note</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-3">
                            {{ $requests->links() }}
    </div>

</main>

@endsection
@push('page_scripts')
<script>
$(document).on('click', '.apply-request', function () {

    let button = $(this);
    let url = button.data('url');

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this request?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Apply',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }

        // Disable button
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },

            success: function (response) {

                if (response.status) {

                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {

                        // Remove row if table row exists
                        button.closest('tr').fadeOut(500, function () {
                            $(this).remove();
                        });

                    });

                } else {

                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                    });

                    button.prop('disabled', false);
                    button.html('Apply Now');
                }
            },

            error: function (xhr) {

                let message = 'Something went wrong. Please try again.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    title: 'Error!',
                    text: message,
                    icon: 'error'
                });

                button.prop('disabled', false);
                button.html('Apply Now');
            }
        });
    });
});
</script>

<script>
$(document).on('click', '.cancel-request', function () {

    let button = $(this);
    let url = button.data('url');

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to cancel this request?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Cancel',
        cancelButtonText: 'No'
    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }

        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },

            success: function (response) {

                if (response.status) {

                    Swal.fire({
                        title: 'Cancelled!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {

                        button
                            .removeClass('btn-outline-danger')
                            .addClass('btn-danger')
                            .prop('disabled', true)
                            .html('<i class="fas fa-times-circle"></i> Cancelled');

                    });

                } else {

                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                    });

                    button
                        .prop('disabled', false)
                        .html('Cancel');
                }
            },

            error: function (xhr) {

                let message = 'Something went wrong. Please try again.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    title: 'Error!',
                    text: message,
                    icon: 'error'
                });

                button
                    .prop('disabled', false)
                    .html('Cancel');
            }
        });
    });
});
</script>

@endpush
