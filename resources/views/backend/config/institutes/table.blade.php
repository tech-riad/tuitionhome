
<div id="#">
    <div class="table-responsive">
        <table class="table" id="institutes-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Approved</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody id="searchResults">
                @forelse($institutes as $institute)
                    <tr>
                        <td>{{ $institute->title }}</td>
                        <td>{{ $institute->type }}</td>
                        <td>{{ ($institute->approved == 1) ?  'Approved': 'Disapproved' }}</td>
                        <td width="120">
                            {!! Form::open(['route' => ['institutes.destroy', $institute->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('institutes.show', [$institute->id]) }}"
                                   class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('institutes.edit', [$institute->id]) }}"
                                   class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                                {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No results found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
