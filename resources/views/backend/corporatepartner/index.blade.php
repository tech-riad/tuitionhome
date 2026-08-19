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
                            <td class="fw-bold">001</td>
                            <td>{{$request->created_at->format('d-m-y')}}</td>
                            <td><a target="_blank" href="{{route('admin.tutor.tutorshow', $request->tutor_id)}}" class="fw-semibold text-decoration-none">A108186</a></td>
                            <td>{{$request->tutor->name}}</td>
                            <td>{{$request->tutor_personal_info->location->name}}</td>
                            <td>{{$request->tutor->phone}}</td>
                            <td><span class="badge badge-pending px-3 py-2 rounded-pill">Pending</span></td>
                            <td>—</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-outline-success">Apply Now</button>
                                    <button class="btn btn-sm btn-outline-danger">Cancel</button>
                                    <button class="btn btn-sm btn-secondary">Note</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

@endsection
