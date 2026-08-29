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
            <td><a target="_blank" href="{{route('admin.tutor.tutorshow', $request->tutor_id)}}"
                    class="fw-semibold text-decoration-none">A108186</a></td>
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
            <td>{{$request->approved_by ?? 'N/A'}} || {{$request->rejected_by ?? 'N/A'}}</td>
            <td>
                <div class="d-flex justify-content-center gap-1">
                    @if($request->status == 'approved')

                    <button type="button" class="btn btn-sm btn-success" disabled>
                        <i class="fas fa-check-circle"></i> Applied
                    </button>

                    {{-- @elseif($request->status == 'rejected')

                                    <button type="button"
                                            class="btn btn-sm btn-outline-success"
                                            >
                                        Apply Now
                                    </button> --}}

                    @else

                    <button type="button" class="btn btn-sm btn-outline-success apply-request"
                        data-url="{{ route('admin.cprequest.apply', $request->id) }}" data-id="{{ $request->id }}">
                        Apply Now
                    </button>

                    @endif
                    @if($request->status == 'rejected')

                    <button type="button" class="btn btn-sm btn-danger" disabled>
                        <i class="fas fa-times-circle"></i> Cancelled
                    </button>

                    @elseif($request->status == 'approved')

                    {{-- Approved হলে আর Cancel করা যাবে না --}}

                    @else

                    <button type="button" class="btn btn-sm btn-outline-danger cancel-request"
                        data-url="{{ route('admin.cprequest.cancel', $request->id) }}" data-id="{{ $request->id }}">
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
{{-- Pagination --}}
<div class="d-flex justify-content-end mt-3" id="paginationLinks">
    {{ $requests->links() }}
</div>
