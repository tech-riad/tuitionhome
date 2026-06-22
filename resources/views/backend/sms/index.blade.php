@extends('layouts.app')

@push('page_css')


@endpush

@section('content')
<div class="card-body">
    <div class="row row-cols-lg-1">
        <div style="">

            <div class="bg-white rounded-3 shadow-lg  mb-4">
                <br>
                <style type="text/css">
                    #element1 {
                        float: left;
                    }

                    #element2 {
                        float: right;
                        padding-right: 10px;
                    }
                    #element3 {
                        float: right;
                        padding-right: 10px;
                    }

                </style>

                <div id="element1">
                    <h5 class="float:left"> &nbsp;Manage Bulk Sms</h5>
                </div>
                <div id="element2">
                    <button style="float: right" class="btn btn-success float-right" data-toggle="modal"
                        data-target="#exampleModal">
                        <i class="bi bi-sliders2 me-1"></i>Add Template
                    </button>
                </div>
                <div id="element3">
                    <form action="{{ route('admin.sms.search') }}" method="POST" id="employeeForm">
                        @csrf
                        <div class="mb-3">
                            <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                    aria-label="Default select" id="user_id">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <script>
                        document.getElementById("user_id").addEventListener("keydown", function(event) {
                            if (event.key === "Enter") {
                                event.preventDefault(); // prevent any default behavior
                                document.getElementById("employeeForm").submit(); // submit the form
                            }
                        });
                    </script>

                </div>


                <div>

                    <br>
                    <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                        <div class="bg-white pb-4 mb-b">
                            <div class="table-responsive">
                                <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse"
                                    id="sms_data_table">
                                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                        <tr>

                                            <th scope="col" class="text-nowrap">SL</th>

                                            <th scope="col" class="text-nowrap">Employee</th>

                                            <th scope="col" class="text-nowrap">Title</th>
                                            <th scope="col" class="text-nowrap">Description</th>
                                            <th scope="col" class="text-nowrap">Created At</th>
                                            <th scope="col" class="text-nowrap">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>





                                        @foreach ($all_sms as $sms)
                                        <tr class="" style="vertical-align: middle">
                                            {{-- <tr class="" > --}}

                                            <td class="text-nowrap">{{$loop->iteration}}</td>
                                            <td class="text-nowrap">{{$sms->user->name}}</td>
                                            <td class="text-nowrap">{{Str::limit($sms->title ?? 'NA', 15)}}</td>
                                            <td class="" style=" width: 900px;">{{$sms->description}}</td>
                                            <td class="text-nowrap">{{$sms->created_at->diffForHumans();}}</td>


                                            <td style=" width: 180px;">


                                                <button id="{{ $sms->id }}" onclick="btnTamplateEdit(this.id)"
                                                    class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#editSmsModal">Edit</button>
                                            </td>

                                        </tr>

                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                {{$all_sms->appends(request()->query())->links()}}
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>






        <!-- add template model starts here -->
        <div class="modal fade font-pop" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered px-4" style="max-width: 700px">
                <div class="modal-content pt-4 pb-4 ps-1">
                    <div class="modal-header pe-5" style="padding-left: 30px">
                        <h5>
                            Sms Tamplate

                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div style="padding: 15px">

                        <form action="{{route('admin.sms.store')}}" method="post" id="smsStoreFrom">
                            @csrf
                            <div class="mb-3">
                                <label for="course" class="form-label">Office Employee</label>
                                <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                    aria-label="Default select " id="user_id">
                                    <option value="">Select Employee</option>


                                    @foreach($employees as $employee)

                                    <option value="{{$employee->id}}">{{$employee->name}}</option>

                                    @endforeach


                                </select>
                                <span class="text-danger error-text user_id_error"></span>
                            </div>

                            <div class="pb-3">
                                <label for="crby" class="form-label">Template Title</label>
                                <input name="title" type="text" value="" class="form-control rounded-3 shadow-none"
                                    id="title" placeholder="sms Title" style="padding: 10px 14px" />

                                <span class="text-danger error-text title_error"></span>

                            </div>


                            <div class="mb-3">
                                <label for="staff" class="form-label required">Tamplate Description</label>
                                <textarea name="description" class="form-control " placeholder="sms body"
                                    id="description" style="
                overflow-y: scroll;
                height: 195px;
                ">
                </textarea>
                                <span class="text-danger error-text description_error"></span>

                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary float-right">
                                    Save
                                </button>
                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>
        <!-- add template Model ends here -->

        <!-- edit template model starts here -->
        <div class="modal fade font-pop" id="editSmsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered px-4" style="max-width: 700px">
                <div class="modal-content pt-4 pb-4 ps-1">
                    <div class="modal-header pe-5" style="padding-left: 30px">
                        <h5>
                            Sms Tamplate

                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div style="padding: 15px">

                        <form action="{{route('admin.sms.update')}}" method="post" id="smsUpdateFrom">
                            @csrf

                            <input type="hidden" name="id" id="edit_id">
                            <div class="mb-3">
                                <label for="course" class="form-label">Office Employee</label>
                                <select name="user_id" class="form-select rounded-3 shadow-none select2"
                                    aria-label="Default select " id="edit_user_id">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)

                                    <option value="{{$employee->id}}">{{$employee->name}}</option>

                                    @endforeach


                                </select>
                                <span class="text-danger error-text user_id_error"></span>
                            </div>

                            <div class="pb-3">
                                <label for="crby" class="form-label">Template Title</label>
                                <input name="title" type="text" value="" class="form-control rounded-3 shadow-none"
                                    id="edit_title" placeholder="sms Title" style="padding: 10px 14px" />

                                <span class="text-danger error-text title_error"></span>

                            </div>


                            <div class="mb-3">
                                <label for="staff" class="form-label required">Tamplate Description</label>
                                <textarea name="description" class="form-control " placeholder="sms body"
                                    id="edit_description" style="
               overflow-y: scroll;
               height: 195px;
               ">
               </textarea>
                                <span class="text-danger error-text description_error"></span>

                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary float-right">
                                    Update
                                </button>
                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>
        <!-- Edit Model ends here -->



    </div>
</div>



@endsection


@push('page_scripts')
@include('backend.sms.js.index_page_js')
@include('backend.tutor.js.swtdeleteMethod_js')


@endpush
