@extends('layouts.app')
@section('content')


<section class="content-header">
    <h1>SMS Editor</h1>
</section>



<div class="row d-flex justify-content-center">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <h4>To:</h4>
                @foreach($phonenumbers as $phonenumber)
                <span class="badge badge-dark">{{$phonenumber}}</span>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('admin.parent.send-sms')}}" method="post">
                    @csrf
                    <input type="hidden" name="phone_numbers" value="{{$numbers}}">
                    <div class="form-group">
                        <label for="SMS_body">SMS Body</label>
                        <textarea id="SMS_body" name="body" maxlength="160" cols="30" rows="6" class="form-control"
                            required=""></textarea>
                    </div>
                    <div class="">
                        <div id="char">0/160</div>
                        <div>Remaining:<span id="rem">160</span></div>
                        <div>Message:<span id="msg">0</span></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection
