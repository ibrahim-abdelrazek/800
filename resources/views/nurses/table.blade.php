<table class="table table-bordered text-light stacktable large-only">
    <thead class="thead-default">
    <tr>
        <th width="1">#</th>
        <th>Name</th>
        <th>Actions</th>

    </tr>
    </thead>
    <tbody>
    @php($i = 1)

    @foreach($nurses as $nurse)
        <tr>
            <td scope="row">{{ $i }}</td>
            <td>{{ $nurse->name }}</td>

            <td>
                <div class='btn-group'>
                    <a href="{{ URL::to('nurses/' . $nurse->id . '/edit') }}" class='btn btn-default btn-xs'>Edit</a>
                    {!! Form::open(['route' => ['nurses.destroy', $nurse->id], 'method' => 'delete']) !!}
                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    {!! Form::close() !!}

                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>