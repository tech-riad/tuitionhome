<div class="table-responsive">
    <table class="table" id="curriculas-table">
        <thead>
        <tr>
            <th>Title</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($curriculas as $curricula)
            <tr>
                <td>{{ $curricula->title }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['curriculas.destroy', $curricula->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('curriculas.show', [$curricula->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('curriculas.edit', [$curricula->id]) }}"
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
