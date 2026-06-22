@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Institute</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'institutes.store']) !!}

            <div class="card-body">

                <div class="row">
                <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Institute Name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>Institute Type</label>
                        <select name="type" id="" class="form-control">
                            <option >~ select Institute~</option>
                            <option value="school">school</option>
                            <option value="school and college">school and college</option>
                            <option value="college">college</option>
                            <option value="university">university</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>Approve Option</label>
                        <select name="approved" id="" class="form-control">
                            <option >~ select Approve~</option>
                            <option value="1">Approve</option>
                            <option value="0">Disapprove</option>
                        </select>
                    </div>
                </div>


            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('institutes.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
