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
                    @if(Auth::user()->ableTo('edit', App\PartnerType::$model))
                    <a href="{!! route('partnertypes.edit', [$partnertype->id]) !!}" class="btn btn-default btn-xs">
                        Edit
                    </a>
                    @endif
                    @if(Auth::user()->ableTo('delete', App\PartnerType::$model))
                    {!! Form::button('Delete', ['type' => 'submit', 'style'=>'cursor:pointer;', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @php($i++)
    @endforeach
    </tbody>
</table>