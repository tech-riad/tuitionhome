@extends('layouts.app')

@push('page_css')
<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>

@endpush

@section('content')
<main class="container-custom">
    @if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif

    <div class="col-md-12 ms-sm-auto col-lg-12" style="margin-top: 62px">
        <!-- mini nav starts here -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
                <a class="text-decoration-none text-gray-800 text-nowrap active-border"
                    href="{{route('admin.converted.parent')}}">Converted Parent</a>
            </div>
        </div>
        <div class="card-header">
            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#deskAdd" > <i class="fas fa-plus-circle"></i> Add Parent</a>
        </div>

        <div class="modal fade" id="deskAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Parent</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="convertTutorParentForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div id="loadingSpinner" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <div style="width: 50px; height: 50px; border: 5px solid #ccc; border-top-color: #007bff; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                            </div>
                            <div class="form-group">
                                <label for="from_tutor_id">From Tutor ID</label>
                                <input type="text" class="form-control" name="from_tutor_id" id="from_tutor_id">
                            </div>
                            <div class="form-group">
                                <label for="to_tutor_id">To Tutor ID</label>
                                <input type="text" class="form-control" name="to_tutor_id" id="to_tutor_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Parent</button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('convertTutorParentForm').addEventListener('submit', function (e) {
                            e.preventDefault();

                            const formData = new FormData(this);
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            const loadingSpinner = document.getElementById('loadingSpinner');

                            // Show loading spinner
                            loadingSpinner.style.display = 'block';

                            fetch("{{ route('admin.convert.tutor.parent') }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: formData,
                            })
                            .then(response => response.json())
                            .then(data => {
                                loadingSpinner.style.display = 'none';

                                if (data.success) {


                                    Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "job created successfully",
                                    showConfirmButton: false,
                                    timer: 1500,
                                 });
                                 $('#deskAdd').modal('hide');
                                setTimeout(function () {
                                location.reload();
                                }, 1500);
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            })
                            .catch(error => {
                                loadingSpinner.style.display = 'none';

                                console.error('Error:', error);
                                alert('An error occurred. Please try again.');
                            });
                        });
                        </script>


                </div>
            </div>
        </div>


        <!-- table starts here -->
        <div class="ps-3 mt-4" style="padding-right: 13px">
            <div class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
                <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bi bi-sliders2 me-1"></i>Filter
                    </button>
                </div>
                <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                    {{-- <form action="" method="POST">
                        @csrf
                        <input name="search" type="text" class="form-control rounded" placeholder="Search" />
                    </form> --}}
                    <form method="GET" action="{{ route($currentRoute) }}">
                        <select name="pagination_limit" class="form-select rounded" style="width: 100px"
                            onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100, 200, 300, 500] as $limit)
                            <option value="{{ $limit }}" {{ $paginationLimit == $limit ? 'selected' : '' }}>{{ $limit }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                <div class="bg-white pb-4 mb-b">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover bg-white shadow-none"
                            style="border-collapse: collapse">
                            <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                <tr>

                                    <th scope="col" class="text-nowrap">From Tutor ID</th>
                                    <th scope="col" class="text-nowrap">To Tutor ID</th>
                                    <th scope="col" class="text-nowrap">Action By</th>
                                    <th scope="col" class="text-nowrap">Succeed</th>
                                    <th scope="col" class="text-nowrap">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($converted as $item)
                                <tr class="align-middle">
                                    <td class="">{{$item->from_tutor_id ?? ''}}</td>
                                    <td class="">{{$item->to_tutor_id ?? ''}}</td>
                                    <td class="">{{$item->action_by ?? ''}}</td>
                                    <td class="">{{$item->success ?? ''}}</td>
                                    <td class="">{{$item->created_at ?? ''}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- pagination starts here -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                        {{$converted->links()}}
                    </div>
                    <!-- pagination ends here -->
                </div>
            </div>
        </div>
        <!-- table ends here -->

        <!-- main content section ends here -->
    </div>
</main>
{{-- start sms modal  --}}
<div class="modal" id="smsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page_scripts')

@endpush