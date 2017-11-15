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
    @foreach($usergroups as $usergroup)
        <tr>
            <td>{{$i}}</td>
            <td>{!! $usergroup->group_name !!}</td>

            <td>
                <div class='btn-group'>
                    <button data-id="{{$usergroup->id}}"
                            class='btn btn-default show-details btn-xs'>Details</button>
                    <a href="{!! route('usergroups.edit', [$usergroup->id]) !!}" class='btn btn-default btn-xs'>Edit</a>
                    {!! Form::open(['route' => ['usergroups.destroy', $usergroup->id], 'method' => 'delete']) !!}
                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure? if delete this , all related users will delete also')"]) !!}
                    {!! Form::close() !!}

                </div>
            </td>
        </tr>
        @php($i++)
    @endforeach
    </tbody>
</table>