@extends('layouts.app')

@push('page_css')


@endpush


@section('content')

<div class="row">

    <div class="col-md-6">
        <section class="content-header">
            <h1>&nbsp; <a href="{{route('admin.sms_template.index')}}" class="btn btn-sm btn-primary">List</a>
            </i>
            Sms Templates
            </h1>
    
            </section>

    </div>
   



</div>
<div class="card-body">
<div class="row row-cols-lg-1">
    <div style="">


        {{-- <div class="d-flex justify-content-between gap-3">

            <a href="{{route('admin.sms_template.index')}}" class="btn btn-outline btn-primary">List</a>
        </div> --}}

        <div class="box-body">
            <div class="table-responsive">
            <table id="table-detail" class="table table-striped">
            <tbody><tr>
            <th width="25%">Title</th>
            <td>
            {{$template->title}} </td>
            </tr>
            <tr>
            <th width="25%">Body</th>
            <td>
                {{$template->body}} </td>
            </tr>
            </tbody></table> </div>
            </div>
       
    </div>
</div>  
</div>  


@endsection



