@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Location</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'locations.store']) !!}

            <div class="card-body">

                <div class="row">
{{--                    @include('backend.config.locations.fields')--}}
                    <div class="form-group">
                        <label for="country_name">Country Name</label>
                      <select name="country_id" class="form-control">
                          <option value="">~Select Country~</option>
                          @foreach($countries as $country)
                              <option value="{{ $country->id }}">{{ $country->name }}</option>
                          @endforeach

                      </select>
                    </div>
                    <div class="form-group">
                        <label for="user_email">City Name</label>
                        <select name="city_id"  class="form-control">
                            <option value="">~Select Country~</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country_flag">Location Name</label>
                        <input type="text" class="form-control" name="name" id="nationality"
                               placeholder="Location Name">
                    </div>

                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('locations.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
