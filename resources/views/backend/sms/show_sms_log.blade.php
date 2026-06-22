@extends('layouts.app')

@push('page_css')


@endpush

@section('content')


<div class="row row-cols-lg-1">
    <div style="">
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4"  style="height: 480px; padding-top: 30px" >

            <div class="row">

                <h5>Show Sms Log</h5>

                <div class="col-md-4 card">


                    <div class="card">
                        <div class="card-header">
                        Sender Information
                        </div>
                        <div class="card-body">
                        <table class="table table-striped table-bordered">
                        <tbody><tr>
                        <td>Sender Id:</td>
                        <td>{{$log->emp_id}}</td>
                        </tr>
                        <tr>
                        <td>Sender Name:</td>
                        <td>{{$log->user->name}}</td>
                        </tr>
                        <tr>
                        <td>Sender Phone:</td>
                        <td>{{$log->user->phone}}</td>
                        </tr>
                        <tr>
                        <td>Sending Date:</td>
                        <td>
                        {{$log->created_at}}
                        </td>
                        </tr>
                        </tbody></table>
                        </div>
                        </div>
                </div>

                <div class="col-md-8 card">




                     
                <div class="card">
                    <div class="card-header">
                    Sms Information
                    </div>
                    <div class="card-body">
                    <h3>Sms Body:</h3>
                    <p class="card-text text-justify">{{$log->body}}</p>
                    <h3>Sended Numbers:</h3>
                    <span class="badge badge-primary p-2 mr-2">{{$log->sender_number}}</span>
                    </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
  
</div>



@endsection