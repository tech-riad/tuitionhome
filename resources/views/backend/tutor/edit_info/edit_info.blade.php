
@extends('layouts.app')

@push('page_css')

<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #11ee24;
    color: black;
}
</style>

@endpush

@section('content')



<div class="tutor_edit_all_page">
    <div class="card-header p-2">
      <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link @if(request()->tab=='ti' || request()->tab==null) active @endif" href="#activity" data-toggle="tab">Tutoring related Information</a></li>
        <li class="nav-item"><a class="nav-link @if(request()->tab=='pi') active @endif" href="#settings" data-toggle="tab">Personal Infromation</a></li>
        <li class="nav-item"><a class="nav-link @if(request()->tab=='ei') active @endif" href="#education" data-toggle="tab">Educational Information</a></li>
        <li class="nav-item"><a class="nav-link @if(request()->tab=='ci') active @endif" href="#certificate" data-toggle="tab">Certificates Information</a></li>

      </ul>
    </div><!-- /.card-header -->


    <div class="card-body">
      <div class="tab-content">
        <div class="@if(request()->tab=='ti' || request()->tab==null) active @endif tab-pane" id="activity">
            @include('backend.tutor.edit_info.edit_tutoring_info')
        </div>
        <!-- /.tab-pane -->
        <div class="@if(request()->tab=='ei') active @endif tab-pane" id="education">
          @include('backend.tutor.edit_info.edit_educational_info')
        </div>
        <!-- /.tab-pane -->

        <div class="@if(request()->tab=='pi') active @endif tab-pane" id="settings">
          @include('backend.tutor.edit_info.edit_personal_info')
        </div>
        
        <div class="@if(request()->tab=='ci') active @endif tab-pane" id="certificate">
            @include('backend.tutor.edit_info.tutor_files')
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div><!-- /.card-body -->
  </div>


  @endsection


  @push('page_scripts')


<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  
            @include('backend.tutor.js.edit_info_page_js')
            @include('backend.tutor.js.index_page_js')

@endpush

