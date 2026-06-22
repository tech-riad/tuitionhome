@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')

<main class="">
    <div class="col-md-12 ms-sm-auto col-lg-12 px-3" style="margin-top: 62px">
        <!-- tab like button group (it should be tab) -->
        <div class="pt-4 row row-cols-2">
            <div>
                <a href="{{route('admin.view.parent',$id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid #669ad1;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">View</a>
            </div>
            <div>
                <a href="{{route('admin.edit.parent',$id)}}" class="btn bg-white shadow-lg w-100" style="
                    border: 2px solid white;
                    color: #6c6d6d;
                    font-size: 16px;
                    padding-top: 12px;
                    padding-bottom: 12px;
                  ">Edit</a>
            </div>
        </div>
        <!-- tab like button group ends -->
        <!-- mini nav starts here -->
        <div class="d-flex gap-4 flex-wrap flex-column flex-md-row py-4 align-items-center">
            <a class="text-decoration-none text-gray-800  text-nowrap"
                href="{{route('admin.view.parent',$id)}}">About Me</a>
            <a class="text-decoration-none text-gray-800 text-nowrap"
                href="{{route('admin.view.parent',$id)}}">Dashboard
                Details</a>
            
            <a class="text-decoration-none text-gray-800 text-nowrap" href="{{route('admin.parent.posted.job',$id)}}">Posted
                Jobs</a>
            <a class="text-decoration-none text-gray-800 text-nowrap" href="/log-files/view/status.html">Status</a>
            <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap active-border"
                href="{{route('admin.parent.basic.log',$id)}}">Basic Log</a>
            <a class="btn btn-outline-gdark text-decoration-none text-gray-800 text-nowrap"
                href="/log-files/view/advance-log.html">Advance Log</a>
        </div>
        <!-- mini nav ends here -->
        <!-- contents starts here -->
        <div>
            <div class="d-flex flex-wrap gap-4 gap-lg-0 justify-content-between mb-4">
                <!-- dummy starts -->
                <div class="btn btn-gdark d-flex gap-3">
                    <div>Copy</div>
                    <div>CSV</div>
                    <div>Excel</div>
                    <div>PDF</div>
                    <div>Column Visibility ▾</div>
                </div>
                <!-- dummy ends -->
                <div class="rounded-2 bg-white gap-1 d-flex justify-content-center align-content-center py-1 px-3"
                    style="border: 2px solid #e0e0e0">
                    <i class="bi bi-search" style="margin-top: 3px"></i>
                    <input type="" placeholder="Search" class="border-0" style="outline: none" />
                </div>
            </div>
            <div class="table-responsive">
                <table class="table bg-white shadow-lg rounded-2">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $item)
                            <tr>
                                <td >{{$item->created_at}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                            </tr>

                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>

        <!-- contents ends here -->
    </div>
</main>

@endsection
