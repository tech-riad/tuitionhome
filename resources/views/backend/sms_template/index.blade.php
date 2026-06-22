 <!-- main content section starts here -->
 
 @extends('layouts.app')

@push('page_css')


@endpush

@section('content')


<div>
    <section class="content-header">
        <h1><i class="fa fa-bars"></i>
        Sms Templates
        </h1>
        </section>
</div>

{{-- <h4>&nbsp;&nbsp;&nbsp;Balk Sms Log</h4> --}}


<div>
 
 <div class="ps-3" style="padding-right: 13px">

    
    <div>


        <div class="d-flex justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">

            <div class="d-flex justify-content-between gap-3">

                {{-- <h1></i>
                    Sms Templates
                    <a href="https://tuitionterminal.com.bd/admin/sms_templates/add?ref=P0G0C9n" id="btn_add_new_data" class="btn btn-sm btn-success" title="Add Data">
                    <i class="fa fa-plus-circle"></i> Add Data
                    </a>
                    
                    </h1> --}}
       
                <a class="btn btn-primary" data-toggle="modal" data-target="#storeModal">
                  <i class="fa fa-plus-circle"></i> Add Data
                </a>
                {{-- <a href="https://tuitionterminal.com.bd/admin/sms_templates/add?ref=P0G0C9n" id="btn_add_new_data" class="btn btn-sm btn-success" title="Add Data">
                    <i class="fa fa-plus-circle"></i> Add Data
                    </a> --}}
                {{-- <a href="{{ route('admin.sms.log') }}" class="btn btn-outline-ndark">List</a> --}}

       
                <form action="" method="POST">
                    @csrf
        </div>

       
       
            <div class="d-flex gap-3">
       
       
                <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                style="border: 1px solid #cfdfdb">
                {{-- <i class="bi bi-search text-muted ms-1"></i> --}}
                <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                    placeholder="Search" style="padding: 12px 18px" id="" />
              <button type="submit" class="btn btn-link"><i class="bi bi-search text-muted ms-1"></i></button>
        </form>
       
            </div>
        {{-- </form> --}}
       
       
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
             <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse" id="vsms_data_table">
                 <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                     <tr>
                       
                         <th scope="col" class="text-nowrap">SL</th>
                         <th scope="col" class="text-nowrap">Title</th>
                         <th scope="col" class="text-nowrap">Body</th>
                         <th  scope="col" class="text-nowrap">&nbsp; &nbsp;Action &nbsp;</th>
                     </tr>
                 </thead>
                 <tbody>

                   @foreach ($templates as $template)
                     <tr class="" style="vertical-align: middle">


                        <td class="text-nowrap">{{$loop->iteration}}</td>
                         <td class="text-nowrap">{{$template->title}}</td>
                         <td class="text-nowrap">{{Str::limit($template->body ?? 'NA',105)}}</td>

            
                         <td style=" width: 160px;">


                            {{-- <a href=""><button class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i>
                                </button></a> --}}
                          <a href="{{ route('admin.sms_template.show', ['template' => $template->id]) }}">  <button class="btn btn-info btn-sm text-white"> <i class="fa fa-eye"></i></button> </a> 

                          <button id="{{ $template->id }}" onclick="btnTamplateEdit(this.id)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSmsModal"><i class="fa fa-edit"></i></button>

                            {{-- <form id="btndelete{{ $template->id }}"
                                action="{{ route('admin.sms_template.delete', ['template' => $template->id]) }}" method="POST"
                                style="display:inline">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm " id="{{ $template->id }}"
                                    onclick="btnDelete(this, this.id)"><i class="fa fa-trash"></i></button>
                            </form> --}}


                        </td>
                     </tr>
                   @endforeach

                 </tbody>
             </table>
         </div>
         <div class="d-flex justify-content-center align-items-center gap-2">
            {{$templates->links()}}
{{--           
            <button class="btn btn-outline-primary py-1 px-2 text-gray-500">
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
     <div class="modal fade font-pop" id="storeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered px-4" style="max-width: 900px">
       <div class="modal-content pt-4 pb-4 ps-1">
         <div class="modal-header pe-5" style="padding-left: 30px">
           <h5 >
              Add Template
           </h5>
           <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
         </div>

      <div style="padding: 15px">

 
     
          <form action="{{route('admin.sms_template.store')}}" method="post" id="vSmsStoreForm"> 
            @csrf


                <div class="pb-3">
                    <label for="crby" class="form-label">Title</label>
                    <input name="title" type="text" value="" class="form-control rounded-3 shadow-none"
                    id="title" placeholder="Title" style="padding: 10px 14px" />
        
                    <span class="text-danger error-text title_error"></span>
        
                  </div> 
                  
                  <div class="mb-3">
                    <label for="staff" class="form-label required">Body</label>
                    <textarea  name="body" class="form-control " placeholder="body" id="body"
                        style="
                overflow-y: scroll;
                height: 195px;
                ">
                </textarea>
                <span class="text-danger error-text body_error"></span>
 
                 </div>
                 <b><p class="help-block">Variables:-job_id- , -class- , -subjects-, -location-, -days-, -duration- , -time- , -salary-</p></b>
                      
              <div class="mb-3">
              <button  type="submit" class="btn btn-primary float-right">
                Add Data
                </button>
              </div>
          </form>  
    

  </div>
 
       </div>
     </div>
   </div>
   <!-- add filter Model ends here -->


     <!-- edit template model starts here -->
     <div class="modal fade font-pop" id="editSmsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered px-4" style="max-width: 900px">
       <div class="modal-content pt-4 pb-4 ps-1">
         <div class="modal-header pe-5" style="padding-left: 30px">
           <h5 >
              Sms Tamplate
         
           </h5>
           <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
         </div>


      <div style="padding: 15px">

          <form action="{{route('admin.sms_template.update')}}" method="post" id="templateUpdateFrom"> 
              @csrf

              <input type="hidden" name="id" id="edit_id">
              <div class="pb-3">
                <label for="crby" class="form-label">Title</label>
                <input name="title" type="text" value="" class="form-control rounded-3 shadow-none"
                id="edit_title" placeholder="Title" style="padding: 10px 14px" />
    
                <span class="text-danger error-text title_error"></span>
    
              </div> 
              
              <div class="mb-3">
                <label for="staff" class="form-label required">Body</label>
                <textarea  name="body" class="form-control " placeholder="body" id="edit_body"
                    style="
            overflow-y: scroll;
            height: 195px;
            ">
            </textarea>
            <span class="text-danger error-text body_error"></span>

             </div>
             <b><p class="help-block">Variables:-job_id- , -class- , -subjects-, -location-, -days-, -duration- , -time- , -salary-</p></b>
                 

          <div class="mb-3">
              <button  type="submit" class="btn btn-primary float-right" >
                Update
                </button>
              </div>

          </form>  
    

  </div>
 
       </div>
     </div>
   </div>
   <!-- Edit Model ends here -->




@endsection


@push('page_scripts')
@include('backend.sms_template.js.index_page_js')
@include('backend.tutor.js.swtdeleteMethod_js')


@endpush
<!-- main content section ends here -->