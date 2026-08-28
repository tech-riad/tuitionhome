<table class="table table-hover align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th scope="col"><input class="form-check-input" type="checkbox"></th>
            <th scope="col">#SL</th>
            <th scope="col">Date</th>
            <th scope="col">CP ID</th>
            <th scope="col">Tutor ID</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Location</th>
            <th scope="col">Gender</th>
            <th scope="col">Channel</th>
            <th scope="col">Action By</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Row 1 -->
        @foreach($partners as $partner)
        <tr>
            <td><input class="form-check-input" type="checkbox"></td>
            <td class="fw-bold">
                {{ $partners->firstItem() + $loop->index }}
            </td>
            <td>{{$partner->created_at->format('d-m-y')}}</td>
            <td><a target="_blank" href="{{route('admin.tutor.tutorshow', $partner->tutor->id ?? 'tutor-not-found')}}"
                    class="fw-semibold text-decoration-none">{{$partner->unique_id ?? 'N/A'}}</a></td>
            <td><a target="_blank" href="{{route('admin.tutor.tutorshow', $partner->tutor->id ?? 'tutor-not-found')}}"
                    class="fw-semibold text-decoration-none">{{$partner->tutor->unique_id ?? 'N/A'}}</a></td>
            <td>{{$partner->name}}
            <td>{{$partner->phone ?? 'N/A'}}</td>
            <td>{{$partner->contactInfo->location->name ?? 'N/A'}}</td>
            <td>{{$partner->gender ?? 'N/A'}}</td>
            <td>{{$partner->channel_name ?? 'N/A'}}</td>
            
            
            
            
        </tr>
        @endforeach



    </tbody>
</table>
{{-- Pagination --}}
<div class="d-flex justify-content-end mt-3" id="paginationLinks">
    {{ $partners->links() }}
</div>
