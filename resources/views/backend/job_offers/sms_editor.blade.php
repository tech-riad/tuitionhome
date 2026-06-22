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
                    }

                </style>

                <div id="element1">
                    <h5 class="float:left"> &nbsp;Sms Editor</h5>
                </div>
                <div id="element2">
                    <h5 class="float:left"> Bulk Sms&nbsp;&nbsp;</h5>
                </div>

                <div>

                    <br>
                    <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                        <div class="bg-white pb-4 mb-b">

                            <div style="padding: 25px 130px ">
                                <form action="{{route('admin.job.tutor.sms.send')}}" method="POST" id="bulkSmsSend">
                                    @csrf

                                    <input type="hidden" name="jod_id" value="{{$job_id}}">
                                    <input type="hidden" name="tutors_id" value="{{$ids}}">
                                    <input type="hidden" name="tutor_numbers" value="{{$numbers}}">

                                    <div class="mb-3">
                                        <label for="staff" class="form-label">To:</label>
                                        <br>

                                        @foreach($tutors as $tutor)
                                        <span class="badge badge-dark">{{$tutor->name}}</span>
                                        @endforeach

                                        <span class="text-danger error-text sender_number_error"></span>
                                    </div>

                                    <div class="mb-3">
                                        <label for="course" class="form-label">choose Template</label>
                                        <select name="title_id" onchange="changeTemplate(this.options[this.selectedIndex].value,{{$job_id}})" class="form-select rounded-3 shadow-none select2" aria-label="Default select " id="title_id" style="padding: 14px 18px">
                                            <option value="0">Select Template</option>
                                            @foreach($templates as $template)
                                            <option value="{{$template->id}}">{{$template->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text template_title_error"></span>
                                    </div>

                                    <div class="mb-3">
                                        <label for="staff" class="form-label required">Sms body</label>
                                        <textarea oninput="countAndUpdate(this.value)" name="sms_body" class="form-control " placeholder="sms body" id="sms_body" style="overflow-y: scroll; height: 195px;"></textarea>
                                        <span class="text-danger error-text sms_body_error"></span>
                                        <div id="charLimitAlert" class="text-danger d-none">You have exceeded the character limit (150 characters).</div>
                                    </div>

                                    <div id="char-left-message" class="text-danger"></div>

                                        @if ($all_sms_number < 40)
                                        <button type="submit" class="btn btn-primary float-right" id="sendButton">
                                            Send
                                        </button>
                                        @endif

                                </form>
                                <div class="">
                                    <div id="char">0/150</div>
                                    <div>Remaining:<span id="rem">150</span></div>
                                    <div>Message:<span id="msg">0</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('page_scripts')
<script>
    $(document).ready(function() {
        $('#sms_body').on('input', function() {
            countAndUpdate($(this).val());
        });
    });
    function changeTemplate(id, job_id) {
    $.ajax({
        type: "GET",
        url: '{{ route("admin.job.sms_template.change") }}',
        data: {
            id: id,
            job_id: job_id,
        },
        success: function (response) {
            let originalBody = response.template.body;
            let job = response.job;

            let replacements = [
                { from: "-job_id-", to: job.id },
                { from: "-class-", to: job.class },
                { from: "-subjects-", to: job.subject },
                { from: "-location-", to: job.full_address },
                { from: "-days-", to: job.days },
                { from: "-duration-", to: job.duration },
                { from: "-time-PM", to: job.time },
                { from: "-salary-", to: job.salary },
                { from: "-offer_id-", to: job.id },
            ];

            let body = originalBody;

            for (let i = 0; i < replacements.length; i++) {
                body = body.replace(replacements[i].from, replacements[i].to);
            }

            $('#sms_body').val(body);

            $('#sms_body').trigger('input');
        },
    });
}

    function countAndUpdate(value) {
        const maxCharacters = 320;

        const truncatedValue = value.slice(0, maxCharacters);

        $('#sms_body').val(truncatedValue);

        const characterCount = countAlphabetsAndSpaces(truncatedValue);
        updateCharacterCount(characterCount);
    }

    function countAlphabetsAndSpaces(sentence) {
    // Replace nothing, just count the length
    const count = sentence.length;
    return count;
}

    function updateCharacterCount(count) {
    const maxCharacters = 150;
    const remaining = Math.max(maxCharacters - count, 0);
    const messageCount = Math.ceil(count / 300);

    const charactersExceeded = Math.max(count - maxCharacters, 0);

    const alertMessage = charactersExceeded > 0 ?
        `You have exceeded the character limit (${maxCharacters} characters). Exceeding by ${charactersExceeded} characters.` :
        `You have exceeded the character limit (${maxCharacters} characters).`;

    $('#charLimitAlert').text(alertMessage);

    if (charactersExceeded > 0) {
        $('#charLimitAlert').removeClass('d-none');
        $('#sendButton').prop('disabled', true);
    } else {
        $('#charLimitAlert').addClass('d-none');
        $('#sendButton').prop('disabled', false);
    }

    if (remaining <= 20) {
        $('#rem').addClass('text-danger');
        $('#char-left-message').text(remaining + ' characters left');
    } else {
        $('#rem').removeClass('text-danger');
        $('#char-left-message').text('');
    }

    if (count <= maxCharacters) {
        $('#char').text(count + '/' + maxCharacters);
        $('#rem').text(remaining);
        $('#msg').text(messageCount);
    }
}

</script>
@endpush