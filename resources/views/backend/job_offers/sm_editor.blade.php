@extends('layouts.app')
@section('content')


<section class="content-header">
    <h1>SMS Editor</h1>
</section>
@if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif


<div class="row d-flex justify-content-center">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <h4>To:</h4>
                {{-- $key => $value --}}
                @foreach($tutors as $tutor)
                <span class="badge badge-dark">{{$tutor->name}}</span>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.tutor.send-sms') }}" method="post">
                    @csrf
                    <input type="hidden" name="phone_numbers" value="{{ $numbers }}">
                    <input type="hidden" name="job_id" value="{{ isset($job_id) ? $job_id : '' }}">
                    <input type="hidden" name="tutor_id" value="{{ isset($tutor_id) ? $tutor_id : '' }}">
                    <div class="form-group">
                        <label for="SMS_body">SMS Body</label>
                        <textarea id="SMS_body" name="body" maxlength="320" cols="30" rows="6" class="form-control" required=""></textarea>
                    </div>
                    <div id="char-left-message" class="text-danger"></div>

                    <div class="">
                        <div id="char">0/320</div>
                        <div>Remaining:<span id="rem">320</span></div>
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
@push('page_scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var smsBody = document.getElementById("SMS_body");
            var charCount = document.getElementById("char");
            var remainingChars = document.getElementById("rem");
            var msgCount = document.getElementById("msg");
            var charLeftMessage = document.getElementById("char-left-message");

            smsBody.addEventListener("input", function () {
                var currentLength = smsBody.value.length;
                var maxCharacters = 320;
                var remaining = maxCharacters - currentLength;
                var messages = Math.ceil(currentLength / 160);

                // Restrict input to 320 characters
                if (currentLength > maxCharacters) {
                    var truncatedValue = smsBody.value.slice(0, maxCharacters);
                    smsBody.value = truncatedValue;
                    currentLength = maxCharacters;
                }

                charCount.textContent = currentLength + "/" + maxCharacters;
                remainingChars.textContent = remaining;

                if (currentLength > 0) {
                    msgCount.textContent = messages;
                } else {
                    msgCount.textContent = "0";
                }

                // Display red alert when remaining characters are 20 or less
                if (remaining <= 20) {
                    remainingChars.classList.add('text-danger');
                    charLeftMessage.textContent = remaining + ' characters left';
                } else {
                    remainingChars.classList.remove('text-danger');
                    charLeftMessage.textContent = '';
                }
            });
        });
    </script>



@endpush
