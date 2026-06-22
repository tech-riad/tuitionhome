@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')


<form id="" action="" method="post" >
    @csrf
    <div id="">
    <label class="form-label">Tutorial Type</label>
    <select name="tutorial_type" id="tutorial_type" class="form-control" required>
        <option value="">Select Type</option>
        @foreach ($types as $type)
        <option value="{{$type->name}}">{{$type->name}}</option>
        @endforeach
    </select>
    <label class="form-label" style="">Tutorial Title:</label>
    <input type="text" class="form-control" name="video_title" id="name" required>
    <label class="form-label" style="">Tutorial embedded link:</label>
    <input type="text" class="form-control" name="video_link" id="link" required>
    </div>

    {{-- <p>Some text in the modal.</p> --}}
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"  onclick="">Submiit</button>
    </div>
</form>

@endsection