@extends('layouts.app')

@push('page_css')

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
                    href="{{route('admin.user.agent')}}">User Agent</a>
            </div>
        </div>
        <div class="card-header">
            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#deskAdd" > <i class="fas fa-plus-circle"></i> Add Desk</a>
        </div>

        <div class="modal fade" id="deskAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Desk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="user-agent-form" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="country_flag">Desk Number</label>
                                <input type="number" class="form-control" name="desk_number" required>
                            </div>
                            <div class="form-group">
                                <label for="country_flag">User Agent</label>
                                <input type="text" class="form-control" name="user_agent" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Desk</button>
                        </div>
                    </form>

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

                                    <th scope="col" class="text-nowrap">Desk Number</th>
                                    <th scope="col" class="text-nowrap">User Agent</th>
                                    <th scope="col" class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userAgent as $item)
                                <tr class="align-middle">
                                    <td class="">{{$item->desk_number ?? ''}}</td>
                                    <td class="">{{$item->user_agent ?? ''}}</td>
                                    <td class="text-red"><i class="fa fa-trash"></i></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- pagination starts here -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                        {{$userAgent->links()}}
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('user-agent-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("{{ route('admin.user.agent.add') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Desk added successfully",
                            showConfirmButton: false,
                            timer: 1500,
                });
                form.reset();
                $('#yourModalId').modal('hide');
                location.reload();
            } else {
                alert("Failed to add User Agent");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while processing your request.");
        });
    });
});

</script>


@endpush
