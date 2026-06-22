<div class="table-responsive">
    <table class="table" id="studies-table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($studies as $study)
            <tr>
                <td>{{ $study->title }}</td>
                <td>{{ $study->type ?? 'n/a' }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['studies.destroy', $study->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('studies.show', [$study->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('studies.edit', [$study->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
