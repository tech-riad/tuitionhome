@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

    .custom-tooltip {
    position: relative;
    display: inline-block;
    cursor: pointer;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px; /* Adjust based on your table width */
}

.custom-tooltip .tooltip-text {
    visibility: hidden;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 120%; /* Adjust based on tooltip size */
    left: 50%;
    transform: translateX(-50%);
    width: max-content;
    max-width: 300px; /* Optional: Constrain tooltip width */
    word-wrap: break-word;
    font-size: 12px;
    white-space: normal;
}

.custom-tooltip:hover .tooltip-text {
    visibility: visible;
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
                    href="{{route('admin.reviews.tutor')}}">Tutor Reviews</a>
            </div>
        </div>

        <!-- table starts here -->
        <div class="ps-3 mt-4" style="padding-right: 13px">
            <div class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
                <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bi bi-sliders2 me-1"></i>Filter
                    </button>
                    <a class="btn btn-danger" href="{{ route('admin.reviews.tutor.trash') }}">Trash</a>
                </div>
                <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                    <form action="{{ route('admin.reviews.tutor.search') }}" method="GET">
                        <input name="search" type="text" class="form-control rounded" placeholder="Search" value="{{ request('search') }}" />
                    </form>
                    <form method="GET" action="{{ route($currentRoute) }}">
                        <select name="pagination_limit" class="form-select rounded" style="width: 100px" onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100, 200, 300, 500] as $limit)
                                <option value="{{ $limit }}" {{ (request('pagination_limit') ?? $paginationLimit) == $limit ? 'selected' : '' }}>
                                    {{ $limit }}
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
                                    <th scope="col" class="text-nowrap">
                                        <input class="form-check-input ms-3 ms-xxl-4" type="checkbox" value=""
                                            id="flexCheckDefault" style="margin-right: 12px" />#SL
                                    </th>
                                    <th scope="col" class="text-nowrap">Date</th>
                                    <th scope="col" class="text-nowrap">Employee Name</th>
                                    <th scope="col" class="text-nowrap">Parents ID</th>
                                    <th scope="col" class="text-nowrap">Tutor ID</th>
                                    <th scope="col" class="text-nowrap">Description</th>
                                    <th scope="col" class="text-nowrap">Action By</th>
                                    <th scope="col" class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $item)
                                <tr class="align-middle">
                                    <td scope="row" class="text-center text-nowrap" style="padding: 30px 18px">
                                        <input class="checkboxx" type="checkbox" name="ids" id="" value="" />
                                        <a class="text-decoration-none text-gray-700 btn" id=""
                                            onclick="dateTime(this.id)" data-bs-toggle="modal" data-time=""
                                            data-bs-target="#exampleModal2">


                                        </a>
                                    </td>
                                    <td class="">
                                        {{$item->created_at}}
                                    </td>
                                    <td class="">{{$item->user->name ?? ''}}</td>
                                    <td class=""><a href="{{route('admin.view.parent',$item->parent_id ?? '')}}">{{$item->parent->unique_id ?? ''}}</a></td>
                                    <td class=""><a href="{{ route('admin.tutor.tutorshow', ['tutor' => $item->tutor_id]) }}">{{$item->tutor->unique_id ?? ''}}</a>
                                        @if(@$item->tutor->is_premium == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-regular-9c7ea3fd.svg" alt="">
                                                @endif
                                                @if(@$item->tutor->is_premium_pro == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-pro-fc790c7d.svg" alt="">
                                                @endif
                                                @if(@$item->tutor->is_premium_advance == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-advance-4b8e47d2.svg" alt="">
                                                @endif
                                                @if($item->tutor->is_verified == 1)
                                                <i style="color:#007BFF" class="far fa-check-circle"></i>
                                                @endif
                                                @if(@$item->tutor->is_internal_verify == 1 && $item->tutor->is_verified == 0)
                                                <i style="color:#ed228b" class="far fa-check-circle"></i>
                                                @endif
                                                @if(@$item->tutor->is_featured == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/featured-icon-0c358655.svg" alt="">

                                                @endif
                                                @if(@$item->tutor->is_boost == 1)
                                                <img height="30px" src="https://tuitionterminal.com.bd/assets/boost-icon-d47ce3c5.svg"
                                                    alt="">

                                                @endif


                                    </td>
                                    <td class="text-truncate" style="max-width: 200px;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->description }}">
                                        {{ Str::limit($item->description, 20, '...') }}
                                    </td>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                                return new bootstrap.Tooltip(tooltipTriggerEl);
                                            });
                                        });
                                    </script>
                                    <td>{{$item->action->name ?? ''}}</td>

                                    <td class="text-red">
                                        <a class="text-red" href="{{route('admin.review.tutor.delete',$item->id)}}"><i class="fa fa-trash"></i></a>

                                    </td>



                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- pagination starts here -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                        {{ $reviews->appends(['pagination_limit' => $paginationLimit])->links() }}
                    </div>
                    <!-- pagination ends here -->
                </div>
            </div>
        </div>
        <!-- table ends here -->

        <!-- Filter model starts here -->
        <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-slide-right" style="max-width: 900px">
                <div class="modal-content pb-4 pt-3">
                    <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                        <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0" style="padding-left: 40px">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="datef" class="form-label text-dark text-sm">Date from</label>
                                        <div class="">
                                            <input type="date" class="form-control shadow rounded-3" id="datef" />
                                        </div>
                                    </div>
                                    <div class="pb-3">
                                        <label for="datet" class="form-label text-dark text-sm">Date To</label>
                                        <input type="date" class="form-control shadow rounded-3" id="datet" />
                                    </div>
                                    <div class="pb-3">
                                        <label for="Status" class="form-label text-dark text-sm">Verify Status</label>

                                        <select id="Status" class="shadow rounded-3 form-select"
                                            aria-label="Default select example">
                                            <option selected value="Verified">
                                                Verified
                                            </option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="border-end mt-3" style="height: 210px"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="cntry" class="form-label text-dark text-sm">Country</label>

                                        <select id="cntry" class="shadow rounded-3 form-select"
                                            aria-label="Default select example">
                                            <option selected value="bangladesh">
                                                Bangladesh
                                            </option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="cty" class="form-label text-dark text-sm">City</label>

                                        <select id="cty" class="shadow rounded-3 form-select"
                                            aria-label="Default select example">
                                            <option selected value="dhaka">Dhaka</option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="loc" class="form-label text-dark text-sm">Location</label>

                                        <select id="loc" class="shadow rounded-3 form-select"
                                            aria-label="Default select example">
                                            <option selected value="mirpur 1">
                                                Mirpur 1
                                            </option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="border-end mt-3" style="height: 210px"></div>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 pe-4">
                                    <div class="pb-3">
                                        <label for="Featured" class="form-label text-dark text-sm">Featured</label>

                                        <select id="Featured" class="shadow rounded-3 form-select"
                                            aria-label="Default select example">
                                            <option selected value="SLH">SLH</option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="Other" class="form-label text-dark text-sm">Channel</label>

                                        <select id="Tutor Request" class="shadow rounded-3 form-select"
                                            aria-label="Default select example">
                                            <option selected value="Tutor Request">
                                                Tutor Request
                                            </option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="am" class="form-label text-dark text-sm">Action By</label>

                                        <select id="am" class="shadow rounded-3 form-select"
                                            aria-label="Default select example">
                                            <option selected value="Robel Hosssen">
                                                Robel Hosssen
                                            </option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=""></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                        <div class="pe-2">
                            <button type="button" class="btn btn-danger grayed py-1 me-2">
                                Clear
                            </button>
                            <a href="employee-filter-apply.html" type="button" class="btn btn-primary py-1">
                                Apply
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deactive model ends here-->
        <!-- main content section ends here -->
    </div>
</main>


{{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p>Edit & Update Parents</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="" method="post" action="{{route('parent.update','parent')}}">
                    @csrf

                    <input type="hidden" name="_method" value="put" />
                    <input class="form-control" type="hidden" id="parent_id" name="parent_id" value="">
                    <label style="" class="form-labal">Full Name</label><br>
                    <input type="text" value="" class="form-control name" name="name" id="name" required>
                    <label style="" class="form-labal">Email</label><br>
                    <input type="text" value="" class="form-control name" name="email" id="email">
                    <label style="" class="form-labal">Phone</label><br>
                    <input type="text" value="" class="form-control name" name="phone" id="phone" required>
                    <label style="" class="form-labal">Additional Phone</label><br>
                    <input type="text" value="" class="form-control name" name="additional_phone" id="additional_phone">
                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="btnEdit()">Update Parent</button>
            </div>
            </form>

        </div>

    </div>
</div>


{{-- end Edit Modal --}}



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

{{-- end sms modal --}}


<form style="display: none" action="{{route('admin.parent.sms-editor')}}" method="POST" id="smsForm">
    @csrf
    <input type="hidden" id="var1" name="all_id" value="" />
</form>

@endsection


@push('page_scripts')



@endpush
