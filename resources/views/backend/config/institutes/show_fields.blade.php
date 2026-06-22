<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $institute->title }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $institute->type }}</p>
</div>

<!-- Approved Field -->
<div class="col-sm-12">
    {!! Form::label('approved', 'Approved:') !!}
    <p>{{ ($institute->approved == 1) ?  'Approved': 'Disapproved' }} </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $institute->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $institute->updated_at }}</p>
</div>

