 <!-- main content section starts here -->

 @extends('layouts.app')

 @push('page_css')


 @endpush

 @section('content')


 <h4>&nbsp;&nbsp;&nbsp;Bulk Sms Log</h4>


 <div>

     <div class="ps-3" style="padding-right: 13px">


         <div>


             <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">

                 <div class="d-flex justify-content-between gap-3">

                     <button class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                         </i>Filter
                     </button>
                     <a href="{{ route('admin.sms.log') }}" class="btn btn-outline-ndark">List</a>


                     {{-- <form action="" method="POST">
                            @csrf --}}
                 </div>


                 <div class="d-flex gap-3">


                     <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                         style="border: 1px solid #cfdfdb">
                         {{-- <i class="bi bi-search text-muted ms-1"></i> --}}
                         <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                             placeholder="Search" style="padding: 12px 18px" id="" />
                         <button type="submit" class="btn btn-link"><i
                                 class="bi bi-search text-muted ms-1"></i></button>
                         {{-- </form> --}}

                     </div>


                     {{-- <input type="text" class="form-control rounded" placeholder="Search" /> --}}

                     <select class="form-select rounded" style="width: 100px">
                         <option selected>50</option>
                         <option value="100">100</option>
                         <option value="200">200</option>
                         <option value="400">400</option>
                         <option value="500">500</option>
                     </select>
                 </div>
             </div>
         </div>




         <div class="bg-white shadow-lg rounded-3 p-2 my-4">
             <div class="bg-white pb-4 mb-b">
                 <div class="table-responsive">
                     <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse"
                         id="tutor_data_table">
                         <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                             <tr>

                                 <th scope="col" class="text-nowrap">SL</th>

                                 <th scope="col" class="text-nowrap">Employee</th>
                                 <th scope="col" class="text-nowrap">Title</th>
                                 <th scope="col" class="text-nowrap">Body</th>
                                 <th scope="col" class="text-nowrap">Created at</th>

                                 <th scope="col" class="text-nowrap">&nbsp; &nbsp;Action &nbsp;</th>
                             </tr>
                         </thead>
                         <tbody>

                            @foreach ($smsLogs as $smsLog)
                            <tr class="" style="vertical-align: middle">
                                <td class="text-nowrap">{{$loop->iteration}}</td>
                                <td class="text-nowrap">{{$smsLog->employee->name ?? ''}}</td>
                                <td class="text-nowrap">{{Str::limit($smsLog->title->title ?? 'NA', 20)}}</td>
                                <td>{{Str::limit($smsLog->body ?? 'NA', 80)}}</td>
                                <td>{{$smsLog->created_at->diffForHumans();}}</td>
                                <td style="width: 260px;">
                                    <a href="{{ route('admin.show.sms.log', ['log' => $smsLog->id]) }}">
                                        <button class="btn btn-info btn-sm text-white">View</button>
                                    </a>
                                    <form id="btndelete{{ $smsLog->id }}"
                                        action="{{ route('admin.sms.log.delete', ['log' => $smsLog->id]) }}"
                                        method="POST" style="display:inline">
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm" id="{{ $smsLog->id }}"
                                            onclick="btnDelete(this, this.id)">Delete</button>
                                    </form>
                                    <button class="btn btn-info py-1 px-2 text-nowrap"
                                            onclick="resendSms('{{$smsLog->id}}','{{$smsLog->emp_id}}','{{$smsLog->title_id}}','{{$smsLog->body}}','{{$smsLog->sender_number}}')">
                                        Resend
                                    </button>


                                    <form action="{{ route('admin.resend.sms') }}" method="post" id="resendSmsForm" style="display:none;">
                                        @csrf
                                        <input type="hidden" id="sms_id" name="sms_id">
                                        <input type="hidden" id="emp_id" name="emp_id">
                                        <input type="hidden" id="title_id" name="title_id">
                                        <input type="hidden" id="sms_body" name="sms_body">
                                        <input type="hidden" id="sender_number" name="sender_number">
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                         </tbody>
                     </table>
                 </div>
                 <div class="d-flex justify-content-center align-items-center gap-2">
                     {{$smsLogs->links()}}

                     {{-- <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
                 <i class="bi bi-chevron-left"></i>
             </button>
             <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                 1
             </button>

             <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                 2
             </button>
             <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                 ..
             </button>

             <button class="btn btn-outline-primary py-1 text-gray-500" style="padding: 0 13px">
                 34
             </button>

             <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
                 <i class="bi bi-chevron-right"></i>
             </button> --}}
                 </div>
             </div>
         </div>
     </div>

 </div>



 <!-- add filter model starts here -->
 <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered px-4" style="max-width: 800px">
         <div class="modal-content pt-4 pb-4 ps-1">
             <div class="modal-header pe-5" style="padding-left: 30px">
                 <h5>
                     Filter

                 </h5>
                 <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
             </div>


             <div style="padding: 15px">


                 <div class="row">

                     <div class="col-md-6">
                         <div class="mb-3">
                             <label for="course" class="form-label">Employee Name</label>
                             <select name="emp_id" class="form-select rounded-3 shadow-none select2"
                                 aria-label="Default select " onchange="filterChange('emp_id',this.id)" id="emp_id">
                                 <option value="">Select Country</option>
                                 @foreach(App\Models\User::where('role_id', 2)->orderBy('id', 'desc')->get() as
                                 $country)

                                 <option value="{{$country->id}}">{{$country->name}}</option>

                                 @endforeach


                             </select>
                         </div>

                         <div class="pb-3">
                             <label for="crby" class="form-label">Sender Number</label>
                             <input name="Sender_number" type="number" value=""
                                 class="form-control rounded-3 shadow-none"
                                 onchange="filterChange('sender_number',this.id)" id="Sender_number"
                                 placeholder="sms Title" style="padding: 10px 14px" />

                             <span class="text-danger error-text city_name_error"></span>

                         </div>

                     </div>

                     <div class="col-md-6">

                         <div class="pb-3">
                             <label for="crby" class="form-label">Sms Body</label>
                             <input name="sms_body" type="text" value="" class="form-control rounded-3 shadow-none"
                                 onchange="filterChange('body',this.id)" id="sms_body" placeholder="sms Title"
                                 style="padding: 10px 14px" />

                             {{-- <span class="text-danger error-text city_name_error"></span> --}}

                         </div>

                         <div class="pb-3">
                             <label for="datef" class="form-label">Created At</label>
                             <div>
                                 <input name="created_at" type="date" class="form-control shadow rounded-2"
                                     id="created_at" onchange="filterChange('DATE(created_at)',this.id)" />
                             </div>
                         </div>

                     </div>


                 </div>


                 <form action="{{route('admin.sms.log.filter')}}" method="post" id="">
                     @csrf


                     <input type="hidden" id="searchInput" name="searchInput">
                     <div class="mb-3">
                         <button type="submit" class="btn btn-primary float-right">
                             Apply Filter
                         </button>
                     </div>
                 </form>


             </div>

         </div>
     </div>
 </div>
 <!-- add filter Model ends here -->



 @endsection


 @push('page_scripts')
 @include('backend.sms.js.bulk_sms_page_js')
 @include('backend.tutor.js.swtdeleteMethod_js')
 @include('backend.sms.js.index_page_js')

 <script>
    function resendSms(smsId,empId,titleId, smsBody, senderNumber) {
        document.getElementById('sms_id').value = smsId;
        document.getElementById('emp_id').value = empId;
        document.getElementById('title_id').value = titleId;
        document.getElementById('sms_body').value = smsBody;
        document.getElementById('sender_number').value = senderNumber;
        document.getElementById('resendSmsForm').submit();
    }
</script>



 @endpush
 <!-- main content section ends here -->
