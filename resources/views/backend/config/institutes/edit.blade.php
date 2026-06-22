@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Institute</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($institute, ['route' => ['institutes.update', $institute->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    <div class="row">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" value="{{$institute->title}}" name="title" placeholder="Enter Institute Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Institute Type</label>
                            <select name="type" id="" class="form-control" >
                                <option >~ select Institute~</option>
                                <option value="school" {{ ($institute->type == 'school')? 'selected': '' }}>School</option>
                                <option value="school and college" {{ ($institute->type == 'school and college')? 'selected': '' }}>School and College</option>
                                <option value="college" {{ ($institute->type == 'college')? 'selected': '' }}>College</option>
                                <option value="university" {{ ($institute->type == 'university')? 'selected': '' }}>University</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Approve Option</label>
                            <select name="approved" id="" class="form-control">
                                <option >~ select Approve~</option>
                                <option value="1" {{ ($institute->approved == 1)? 'selected': '' }}>Approve</option>
                                <option value="0" {{ ($institute->approved == 0)? 'selected': '' }}>Disapprove</option>
                            </select>
                        </div>
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
