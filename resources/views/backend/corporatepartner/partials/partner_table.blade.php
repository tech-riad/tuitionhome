
<div class="table-responsive">
    <table class="table table-sm table-hover bg-white shadow-none" style="border-collapse: collapse">
        <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
            <tr>
                <th scope="col" class="text-nowrap">
                    <input class="form-check-input ms-3" type="checkbox" value="" id="flexCheckDefault"
                        style="margin-right: 12px" />#SL
                </th>
                <th scope="col" class="text-nowrap">Date</th>
                <th scope="col" class="text-nowrap">Partner ID</th>
                <th scope="col" class="text-nowrap">Tutor ID</th>

                <th scope="col" class="text-nowrap">Name</th>
                <th scope="col" class="text-nowrap">Phone</th>
                <th scope="col" class="text-nowrap">Location</th>
                <th scope="col" class="text-nowrap">Gender</th>
                <th scope="col" class="text-nowrap">Channel</th>
                <th scope="col" class="text-nowrap">Action By</th>
                <th scope="col" class="text-nowrap">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partners as $partner)
            <tr class="align-middle">
                <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" />

                    {{ $loop->iteration }}
                </td>
                <td class="">
                    <a type="button" class="text-decoration-none text-gray-800 text-nowrap" data-bs-toggle="modal"
                        data-bs-target="#showDateTimeModal{{ $partner->id }}">
                        {{ $partner->created_at->format('d-m-y') }}
                    </a>
                </td>
                <!-- Show Date time model starts here-->
                <div class="modal fade" id="showDateTimeModal{{ $partner->id }}" tabindex="-1"
                    aria-labelledby="showDateTimeModalLabel" aria-hidden="true">
                    <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                        <div class="modal-content">
                            <div class="modal-body pt-5 pb-4">
                                <p class="text-center text-info fs-3">{{ $partner->created_at->format('d M Y') }}</p>
                                <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                    {{ $partner->created_at->format('h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Show Date time model ends here-->
                <td class="text-info">
                    <a href="{{route('admin.getcpProfile.index', $partner->id)}}"
                        class="text-decoration-none text-info">{{ $partner->unique_id }}</a>
                    <div style="display: inline-block">
                        <img src="{{ asset('backend/file/images/yollow-star-mark.svg') }}" alt="yollow-star-mark" />
                        <img src="{{ asset('backend/file/images/green-mark.svg') }}" alt="green-mark" />
                        <img src="{{ asset('backend/file/images/blue-tick-mark.svg') }}" alt="blue-tick" />
                    </div>
                </td>
                <td class="text-info">{{ $partner->tutor->unique_id ?? 'N/A' }}</td>
                <td class="text-nowrap">{{$partner->name}}</td>
                <td>{{ $partner->phone }}</td>
                @php
                $contactInfo = $partner->contactInfo;

                $locationName = $contactInfo && $contactInfo->location
                ? $contactInfo->location->name
                : null;

                $cityName = $contactInfo && $contactInfo->city
                ? $contactInfo->city->name
                : null;

                $countryName = $contactInfo && $contactInfo->country
                ? $contactInfo->country->name
                : null;

                $location = collect([
                $locationName,
                $cityName,
                $countryName,
                ])->filter()->implode(', ');
                @endphp

                <td>
                    <span data-toggle="tooltip" data-placement="top" title="{{ $location ?: 'N/A' }}"
                        style="cursor: pointer;">
                        {{ $location ? \Illuminate\Support\Str::limit($location, 12, '...') : 'N/A' }}
                    </span>
                </td>
                <td>{{ $partner->gender }}</td>
                <td>{{ $partner->channel_name }}</td>
                <td class="">
                    <button type="button" class="btn btn-outline-primary px-2 py-1 text-dark" data-bs-toggle="modal"
                        data-bs-target="#viewModal">
                        <i class="bi bi-eye-fill"></i>
                        View
                    </button>
                </td>

                <td class="">
                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button class="btn shadow-none py-1 px-2" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" style="border: 1px solid #d7dfe9">
                                <li>
                                    <a class="dropdown-item" href="#">Super Lead Hunter</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Average Lead Hunter</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Make Verify</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Deactive</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#noteModal"
                                        href="#">Note</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createNoteModal"
                                        href="#">Create a Note</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logModal"
                                        href="#">Log</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
