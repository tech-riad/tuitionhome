@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                @if (Session::has('success'))
                    <div class="alert alert-info">
                        <ul>
                            <li style="color: #000;">{{ Session::get('success') }}</li>
                        </ul>
                    </div>
                @endif




                <div class="card-body">
                    <form action="{{ url('home/update-institute') }}" method="post">
                        @csrf
                        <div class="row">
                            <!-- Institute From -->
                            <div class="form-group col-md-4">
                                <label for="frominstitute">Institute (From)</label>
                                <select id="frominstitute" name="frominstitute" class="form-control" placeholder="Select an Institute">
                                    <option value="" disabled selected>Select an Institute</option>
                                    @foreach ($institutes as $institute)
                                        <option value="{{ $institute->id }}">{{ $institute->title }} ({{ $institute->type }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Institute To -->
                            <div class="form-group col-md-4">
                                <label for="toinstitute">Institute (To)</label>
                                <select id="toinstitute" name="toinstitute" class="form-control" placeholder="Select an Institute">
                                    <option value="" disabled selected>Select an Institute</option>
                                    @foreach (App\Models\Institute::orderBy('title', 'asc')->get() as $institute)
                                        <option value="{{ $institute->id }}">{{ $institute->title }} ({{ $institute->type }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Change Button -->
                            <div class="form-group col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Change</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('page_scripts')


<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


            {{-- @include('backend.tutor.js.edit_info_page_js') --}}
            {{-- @include('backend.tutor.js.index_page_js') --}}

            <script>
                $('#frominstitute').select2();
                $('#toinstitute').select2();
            </script>

@endpush


