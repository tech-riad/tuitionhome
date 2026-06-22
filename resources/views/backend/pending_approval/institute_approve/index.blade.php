
@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')

<h5>New Institute Request</h5>

    @if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif



    {{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         <p>Edit & Update institution</p>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <form id="" method="post" action="{{route('admin.approve.institute.update')}}" >
            @csrf

           <input class="form-control" type="hidden" id="id" name="id" value="">
           <input class="form-control" type="hidden" id="tutor_id" name="tutor_id" value="">
          <label style="" class="form-labal">Institution Title</label><br>
          <input type="text" value="" class="form-control name" name="university" id="title" required>
          <label style="" class="form-labal">Degree Name</label><br>
          <input type="text" value="" class="form-control name" name="degree_name" id="degree_name" required readonly>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"  onclick="btnEdit()">Save</button>
        </div>
      </form>

      </div>

    </div>
  </div>


  {{-- end Edit Modal --}}


<div class="row">
    <div class="col-md-8">

        <div class="card mb-4">


            <div class="card-header">

            </div>
        <div class="card-body1">
            {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}

            <table id="datatablesSimple" class="dataTable-table">
                <thead>
                            <tr>
                                <th data-sortable="" style="width: 25%;"><a href="#" class="dataTable-sorter">SL</a></th>
                                <th data-sortable="" style="width: 25%;"><a href="#" class="dataTable-sorter">Tutor Id</a></th>
                                <th data-sortable="" style="width: 25%;"><a href="#" class="dataTable-sorter">Type</a></th>
                                <th data-sortable="" style="width: 25%;"><a href="#" class="dataTable-sorter">institution</a></th>
                                <th data-sortable="" style="width: 25%;"><a href="#" class="dataTable-sorter">Approved Status</a></th>
                                <th data-sortable="" style="width: 25%;"><a href="#" class="dataTable-sorter">Action</a></th>


                            </tr>
                </thead>

                <tbody id="panding_institute_table">

                    @foreach ($Tutor_universities as $Tutor_university)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        {{-- <td>{{$Tutor_university->id}}</td> --}}
                        <td>{{$Tutor_university->tutor_id}}</td>
                        <td>{{$Tutor_university->type}}</td>
                        <td>{{$Tutor_university->university}}</td>
                        <td>
                            <span class="badge badge-warning">{{$Tutor_university->is_approved}}</span>
                        </td>

                        <td>

                            @if($Tutor_university->is_approved == "pending")
                            <form style="display:inline" id="approveInstitute{{$Tutor_university->id}}" action="{{ route('admin.approve.institute.approve', ['institute' => $Tutor_university->id]) }}" method="POST">
                                @csrf
                                <button id="{{$Tutor_university->id}}" type="button" class="btn btn-sm btn-success" onclick="btnApproveInstitute(this, this.id)">Approve Now</button>
                              </form>

                             @else
                            @endif
                            <button id="{{$Tutor_university->id}}" onclick="btnEdit(this.id)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal">
                                <i class="fa fa-edit"></i>
                                </button>
                            <form id="btndelete{{$Tutor_university->id}}" action="{{ route('admin.approve.institute.delete', ['institute' => $Tutor_university->id]) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger btn-sm " id="{{$Tutor_university->id}}" onclick="btnDelete(this, this.id)" ><i class="fa fa-trash"></i></button>
                            </form>
                            <button  id="{{$Tutor_university->tutor_id}}-{{$Tutor_university->university}}" type="button" class="btn btn-secondary" onclick="btnChangeSearchInput(this.id)" >
                                <svg xmlns="" width="14" height="14" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                           <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                           </svg></button>

                           <input type="checkbox" onchange="clickfunction({{$Tutor_university->tutor_id}})" name="checkbox_tutor_id" id="checkbox_tutor_id{{$Tutor_university->tutor_id}}" value="{{$Tutor_university->tutor_id}}">

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        </div>

        {{$Tutor_universities->links()}}

    </div>

    <div class="col-md-4">
        <div class="card mb-4">



            <div class="card-header">

                <form method="POST" id="searchForm" action="" onsubmit="event.preventDefault();">
                    @csrf
                <div class="input-group">
                    <input type="text" onkeyup="btnSearch(event)" id="inputSearch" name="search" value="" class="form-control" placeholder="Search from institute">
                    <div class="input-group-btn">
                </div>
                    </div>
                </form>



            </div>
        <div class="card-body2">

            <table id="datatablesSimple2" class="dataTable-table">
                <b id="displayError" style="color:red;" class="derger"></b>
                <thead>
                            <tr>
                                <th data-sortable="" style="width: 6.6154%;"><a href="#" class="dataTable-sorter">ID</a></th>
                                <th data-sortable="" style="width: 10.0385%;"><a href="#" class="dataTable-sorter">Title</a></th>
                                <th data-sortable="" style="width: 10.0385%;"><a href="#" class="dataTable-sorter">Type</a></th>

                            </tr>
                </thead>

                <tbody id="dataTable2">



                </tbody>




            </table>
        </div>
        </div>


    </div>
</div


@endsection

@push('page_scripts')
@include('js.swtdeleteMethod_js')
@include('backend.pending_approval.institute_approve.js.index_page_js')

@endpush
