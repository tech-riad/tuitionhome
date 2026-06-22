@extends('welcome')

@push('css')
    <style>

        #wrapper{
            display: flex;
            justify-content: center;
            /* align-items: center; */
            /*border: 1px solid gray;*/
            width: 100%;
            height: 43vh;
            text-align: center;
        }

        #dialog h3{
            padding-top:15px;
            color:#50ab1d;
            font-size:25px;
        }

        #dialog #form input {
            background: none;
            border: 1px solid #50ab1d;
            padding: 15px;
            margin: 0 8px;
            border-radius: 10px;
            width: 95px;
            font-size:20px !important;
        }
        #dialog #form button{
            display:block;
            margin:20px auto;
            width:35%;
            padding:15px 0;
        }

        .card_css{
            border:none;
        }

        @media screen and (max-width: 700px) and (min-width: 200px) {
            #wrapper {
                margin:70px 0;
                height: 54vh;
            }
            #dialog h3{
                padding-top:8px;
                color:#50ab1d;
                font-size:18px;
            }
            #dialog span{
                font-size:13px;
                color:#50ab1d;
                display:block;
                margin-bottom:10px;
            }

            #dialog #form input {
                /* border: 1px solid #50ab1d; */
                border-radius: 5px;
                width: 95px;
                margin: -1px;
                font-size: 20px;
                height: 40px;
            }

            #dialog #form button{
                display:block;
                margin-top:10px;
                width:29%;
                padding:8px 0;
            }
        }

    </style>
@endpush
@section('content')
    <div class="container p-5 d-flex justify-content-center align-items-center gap-5">
        <div class="row mt-5">
            <div class="col-md-5 mx-md-5 d-none d-md-block">
                <img src="{{ asset('/dashboard/tutor') }}/assets/verify-done.svg" />
            </div>
            <div class="col-md-5 d-flex justify-content-center align-items-center ms-md-5" >
                @if (session('error'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                {{session('error')}}
                            </div>
                        </div>
                    </div>
                @endif
                @if (session('success'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">
                                {{session('success')}}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="bg-secondary shadow-lg p-md-5 p-4 ms-md-5 rounded-3">
                    <h5 class="fw-bolder text-capitalize">Verify your number</h5>
                    <p>Code is send to <span class="text-dark">{{ Auth::guard('tutor')->user()->phone }}</span></p>
                    <form  action="{{ route('tutor.otp.verify') }}" method="POST" id="otp_form">
                        @csrf
                        <input type="hidden" id="otp" name="otp">
                        <input type="hidden" name="tutor_id" value="{{ Auth::guard('tutor')->user()->id }}">
                    </form>
                    <form  action="{{ route('tutor.otp.resend') }}" method="POST" id="otp_resend">
                        @csrf
                    </form>
                    @if(Session::has('message'))
                        <span class="text-danger">{{ session::get('message') }}</span> <br/>
                    @endif

                    @if(Session::has('remessage'))
                        <span class="text-success">{{ session::get('remessage') }}</span> <br/>
                    @endif
                    <div class="d-flex gap-4 justify-content-between align-items-center" id="form" >
                        <input class="p-1 fw-bold shadow-lg rounded-3 otp" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input class="p-1 fw-bold shadow-lg rounded-3 otp" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input class="p-1 fw-bold shadow-lg rounded-3 otp" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input class="p-1 fw-bold shadow-lg rounded-3 otp" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />

                    </div>

                    <p class="text-dark mt-3" id="timer">00:120 Sec</p>
                    <p id="resend" style="display: none">
                        Don’t receive code ?
                        <span class="text-dark"><a href="#" onclick="resend()">Re-send</a></span>
                    </p>
                    <button class="btn btn-primary w-100 py-2" onclick="submit()">Verify</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
{{--    <script src="{{asset('admin_lte/plugins/jquery/jquery.min.js')}}"></script>--}}
    <script>
        $(function() {
            'use strict';

            var body = $('body');

            function goToNextInput(e) {
                var key = e.which,
                    t = $(e.target),
                    sib = t.next('input');

                if (key !== 9 && (key < 48 || key > 57)) {
                    e.preventDefault();
                    return false;
                }

                if (key === 9) {
                    return true;
                }

                if (!sib || !sib.length) {
                    sib = body.find('input').eq(0);
                }
                sib.select().focus();
            }

            function onKeyDown(e) {
                var key = e.which;

                if (key === 9 || (key >= 48 && key <= 57)) {
                    return true;
                }

                e.preventDefault();
                return false;
            }

            function onFocus(e) {
                $(e.target).select();
            }

            body.on('keyup', 'input', goToNextInput);
            body.on('keydown', 'input', onKeyDown);
            body.on('click', 'input', onFocus);
            var sec=60;
            var interval= window.setInterval(function (){
                if(sec-- == 0){
                    clearInterval(interval);
                    $("#resend").removeAttr("style");
                    $("#timer").remove();
                }
                $("#timer").html("Please wait "+sec+" second(s) before resending otp");
            }, 1000);

        })
        function submit(){
            var inps= $(".otp");
            var otp="";
            for(var inp of inps){
                otp+=inp.value;
            }
            // console.log(otp);
            if(otp.length<4){
                alert('Invalid OTP');
                return;
            }
            $("#otp").val(otp);
            $("#otp_form").submit();

        }
        function resend(){
            $("#otp_resend").submit();
        }
    </script>

@endpush

