<!-- Title Field -->
<div class="form-group col-sm-4">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}

</div>
<div class="form-group col-sm-4">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::select('type',
        [
            'honours' => 'Honours',
            'masters' => 'Masters',

        ],
        null,
        ['class' => 'form-control', 'placeholder' => 'Select Type']
    ) !!}
</div>

