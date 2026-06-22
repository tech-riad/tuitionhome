@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Create Template</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('adminlte-templates::common.errors')

    <div class="card">

        <form action="{{route('admin.config.requirement.template.store')}}" method="post">

            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group col-sm-6">
                        <label for="name">Title:</label>
                        <input class="form-control" name="title" type="text" id="title">
                    </div>
                </div>
                <div class="col-lg-8 ml-2">
                    <div class="mb-3">
                        <label for="requ" class="form-label required">Tutor Requirement</label>
                        <textarea required="" name="body" id="body"
                            class="form-control rounded-3 shadow-none" style="
                            overflow-y: scroll;
                            resize: none;
                            height: 165px;
                            ">
                            </textarea>
                        <span class="text-danger error-text body_error"></span>

                    </div>
                    <button type="submit" class="btn btn-primary py-1 px-2 mb-3" >Submit

                </div>


            </div>
        </form>


    </div>
</div>
@endsection
