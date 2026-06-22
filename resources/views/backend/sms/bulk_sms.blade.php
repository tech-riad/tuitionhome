@extends('layouts.app')

@push('page_css')


@endpush

@section('content')
<div class="card-body">
    @if(session('message'))
        <p class="alert alert-success">{{ session('message') }}</p>
        @endif
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
                                <form action="{{route('admin.bulk.sms.send')}}" method="POST" id="bulkSmsSend">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="staff" class="form-label required">Multi Numbers</label>
                                        <textarea  name="sender_number" class="form-control" placeholder="Sender Number" id="sender_number"
                                            style="overflow-y: scroll; height: 195px;"></textarea>

                                        <span class="text-danger error-text sender_number_error"></span>

                                    </div>


                                    <div class="mb-3">
                                        <label for="course" class="form-label">Choose Template</label>
                                        <select name="title_id" onchange="changeTemplate(this.options[this.selectedIndex].value)"
                                            class="form-select rounded-3 shadow-none select2" aria-label="Default select " id="title_id"
                                            style="padding: 14px 18px">
                                            <option value="0">Select Template</option>
                                                @if(Auth::user()->id == 1)
                                                    @foreach($all_templates as $template)
                                                        <option value="{{ $template->id }}" data-template="{{ $template->description }}">{{ $template->title }}</option>
                                                    @endforeach
                                                @else
                                                @foreach ($templates as $item)
                                                <option value="{{ $item->id }}" data-template="{{ $item->description }}">{{ $item->title }}</option>

                                                @endforeach


                                                @endif
                                        </select>
                                        <span class="text-danger error-text template_title_error"></span>
                                    </div>

                                    <div class="mb-3">
                                        <label for="staff" class="form-label required">Sms body</label>
                                        <textarea oninput="count(this.value)" name="sms_body" class="form-control" placeholder="sms body" id="sms_body"
                                            style="overflow-y: scroll; height: 195px;"></textarea>
                                        <span class="text-danger error-text sms_body_error"></span>

                                    </div>
                                    <div id="char-left-message" class="text-danger"></div>


                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary float-right">
                                            Send
                                        </button>
                                    </div>

                                </form>
                                <div class="">
                                    <div id="char">0/300</div>
                                    <div>Remaining:<span id="rem">300</span></div>
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
@include('backend.sms.js.bulk_sms_page_js')
{{-- @include('backend.sms.js.index_page_js') --}}
{{-- @include('backend.tutor.js.swtdeleteMethod_js') --}}

<script>
    function changeTemplate(id) {
        const templateDescription = $('option:selected', '#title_id').data('template');
        $('#sms_body').val(templateDescription);
        count(templateDescription);
    }

    function count(value) {
        const maxCharacters = 300;
        let charCount = countCharacters(value);

        // Restrict input to 320 characters
        if (charCount > maxCharacters) {
            charCount = maxCharacters;
            const truncatedValue = value.slice(0, maxCharacters);
            $('#sms_body').val(truncatedValue);
        }

        const remaining = maxCharacters - charCount;
        const msgCount = Math.ceil(charCount / 150);

        $('#char').text(charCount + '/' + maxCharacters);
        $('#rem').text(remaining);
        $('#msg').text(msgCount);

        // Display red alert when remaining characters are 20 or less
        if (remaining <= 20) {
            $('#rem').addClass('text-danger');
            $('#char-left-message').text(remaining + ' characters left');
        } else {
            $('#rem').removeClass('text-danger');
            $('#char-left-message').text('');
        }
    }

    function countCharacters(value) {
        return value.length;
    }
</script>





@endpush