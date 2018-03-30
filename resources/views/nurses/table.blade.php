<table id="nurses-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th rowspan="2">#</th>
        <th rowspan="2">Personal Photo</th>
        <th rowspan="2">Name</th>
        <th colspan="2">Contact Details</th>
        @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
            <th rowspan="2">Partner</th>
        @endif
        <th rowspan="2">Actions</th>
    </tr>
    <tr>
        <th> Email</th>
        <th> Number</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th rowspan="1">#</th>
        <th rowspan="1">Personal Photo</th>
        <th rowspan="1">Name</th>
        <th rowspan="1">Email</th>
        <th rowspan="1">Number</th>
        @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
            <th rowspan="1">Partner</th>
        @endif
        <th rowspan="1">Actions</th>

    </tr>
    </tfoot>
    <tbody>
    @php($i = 1)
    @foreach($nurses as $nurse)
        <tr>
            <td scope="row">{{ $i }}</td>
            <td>
                @if(!empty($nurse->photo))
                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="{{ url($nurse->photo) }}">
                @else
                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                @endif
            </td>
            <td>{{ $nurse->first_name ." " .$nurse->last_name }}</td>
            <td>{{$nurse->contact_email}}</td>
            <td>{{ '+' . $nurse->contact_number }}</td>
            @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
                <td>{{ $nurse->partner->first_name . ' ' . $nurse->partner->last_name }}</td>
            @endif
            <td>

                {!! Form::open(['route' => ['nurses.destroy', $nurse->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a data-id="{{$nurse->id}}" href="#" class="btn view-card btn-default btn-xs">
                        <i class="la la-eye">Show</i>
                    </a>

                     @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('edit', App\Nurse::$model))
                    <a href="{{ URL::to('nurses/' . $nurse->id . '/edit') }}"
                       class='btn btn-default btn-xs'>Edit</a>
                       @endif
                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('delete', App\Nurse::$model))
                         {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                     @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @php($i++)
    @endforeach
    </tbody>
</table>