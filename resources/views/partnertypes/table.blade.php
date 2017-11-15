<table class="table table-bordered text-light stacktable large-only">
    <thead class="thead-default">
    <tr>
        <th width="1">#</th>
        <th>Name</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @php($i = 1)
    @foreach($partnertypes as $partnertype)
        <tr>
            <td>{{ $i }}</td>
            <td>{!! $partnertype->name !!}</td>
            <td>
                @if($partnertype->status == 1)
                    <span class="label label-success">Active</span>
                @else
                    <span class="label label-danger">Not Active</span>
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['partnertypes.destroy', $partnertype->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('partnertypes.edit', [$partnertype->id]) !!}" class="btn btn-default btn-xs">
                        <i class="la la-pencil-square-o" aria-hidden="true">Edit</i>
                    </a>
                    {!! Form::button('Delete', ['type' => 'submit', 'style'=>'cursor:pointer;', 'class' => 'btn btn-danger la la-trash btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @php($i++)
    @endforeach
    </tbody>
</table>