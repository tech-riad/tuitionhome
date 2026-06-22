@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Institutes</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('institutes.create') }}">
                    Add New
                </a>
            </div>
        </div>
    </div>
</section>
{{--   Institute import modal start --}}
<div class="modal fade" id="InstituteImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Institute</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.config.institute.import.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="country_flag">Institute Import CSV FIle</label>
                        <input type="file" class="form-control" name="import_institute" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import Institute</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--end Institute import modal--}}
<div class="content px-3">

    @include('flash::message')
    @if($errors->has('import_institute'))
    <div class="error text-danger">{{ $errors->first('import_institute') }}</div>
    @endif
    <div class="clearfix"></div>

    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#InstituteImport"> <i
                    class="fas fa-plus-circle"></i> Import Institute</a>
        </div>
        <div class="card-body p-0">
            <div class="card-footer clearfix">
                <div class="float-right">
                    <div class="d-flex justify-content-center align-items-center px-2 rounded-3"
                        style="border: 1px solid #cfdfdb">
                        <input name="search" type="text" class="form-control shadow-none rounded-3 border-0"
                            placeholder="Search" style="padding: 12px 18px" id="searchInput">
                        <button type="button" class="btn btn-link" onclick="searchInstitute()"><i
                                class="bi bi-search text-muted ms-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
        @include('backend.config.institutes.table')


        <div id="paginationLinks">
            {{ $institutes->links() }}
        </div>



    </div>
</div>

@endsection


@push('page_scripts')
<script>
function searchInstitute(page = 1) {
    var searchInput = $('#searchInput').val();

    $.ajax({
        type: 'POST',
        url: '/search?page=' + page,
        data: {
            searchInput: searchInput,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            var tableBody = $('#searchResults');
            tableBody.empty();

            if (response.institutes.data.length > 0) {
                $.each(response.institutes.data, function (index, institute) {
                    var approvedStatus = (institute.approved == 1) ? 'Approved' : 'Disapproved';
                    var row = '<tr>' +
                        '<td>' + institute.title + '</td>' +
                        '<td>' + institute.type + '</td>' +
                        '<td>' + approvedStatus + '</td>' +
                        '<td width="120">' +
                        '<div class="btn-group">' +
                        '<a href="{{ url("institutes") }}/' + institute.id +
                        '" class="btn btn-default btn-xs">' +
                        '<i class="far fa-eye"></i>' +
                        '</a>' +
                        '<a href="{{ url("institutes") }}/' + institute.id +
                        '/edit" class="btn btn-default btn-xs">' +
                        '<i class="far fa-edit"></i>' +
                        '</a>' +
                        '{!! Form::open(["route" => ["institutes.destroy", ' + institute.id +
                        '], "method" => "delete"]) !!}' +
                        '<button type="submit" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure?\')">' +
                        '<i class="far fa-trash-alt"></i>' +
                        '</button>' +
                        '{!! Form::close() !!}' +
                        '</div>' +
                        '</td>' +
                        '</tr>';

                    tableBody.append(row);
                });

                // Update pagination dynamically
                $('#paginationLinks').html(response.pagination);

                // Attach event listeners to pagination links
                $('#paginationLinks a').on('click', function (e) {
                    e.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    searchInstitute(page);
                });

            } else {
                var noResultsRow = '<tr><td colspan="4">No results found</td></tr>';
                tableBody.append(noResultsRow);
                $('#paginationLinks').empty(); // Remove pagination if no results
            }
        }
    });
}


</script>



@endpush
