<div class="table-responsive">
    <table class="table" id="degrees-table">
        <thead>
        <tr>
            <th>Title</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($degrees as $degree)
            <tr>
                <td>{{ $degree->title }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['degrees.destroy', $degree->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('degrees.show', [$degree->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('degrees.edit', [$degree->id]) }}"
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
