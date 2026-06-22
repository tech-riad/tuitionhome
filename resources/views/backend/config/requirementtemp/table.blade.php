<div class="table-responsive">
    <table class="table" id="cities-table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @if ($templates)
        @foreach($templates as $item)
            <tr>
                <td>{{ @$item->title }}</td>
                <td>{{ @$item->body }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.config.requirement.template.edit',@$item->id)}}" class="btn btn-default btn-xs">
                            <i class="far fa-edit"></i>
                        </a>
                        {{-- <a href="{{route('admin.config.requirement.template.delete',@$item->id)}}" class="btn btn-danger btn-xs">
                            <i class="far fa-trash-alt "></i>
                        </a> --}}
                        {{-- <button type="submit" class="btn btn-danger btn-xs" ><i class="far fa-trash-alt"></i></button> --}}
                    </div>
                </td>

            </tr>
        @endforeach

        @else

        


        @endif
        </tbody>
    </table>
</div>
