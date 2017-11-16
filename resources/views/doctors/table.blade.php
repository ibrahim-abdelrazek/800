<table id="doctors-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
<thead>
    <tr>
        <th rowspan="2">#</th>
        <th rowspan="2">Personal Photo</th>
        <th rowspan="2">Name</th>
        <th rowspan="2">Speciality</th>
        <th colspan="2">Contact Details</th>
        @if(Auth::user()->isAdmin())
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
        <th rowspan="1">Speciality</th>
        <th rowspan="1">Email</th>
        <th rowspan="1">Number</th>
        @if(Auth::user()->isAdmin())
            <th rowspan="1">Partner</th>
        @endif
        <th rowspan="1">Actions</th>

    </tr>
    </tfoot>
    <tbody>
    @php($i = 1)
    @foreach($doctors as $doctor)
        <tr>
            <td scope="row">{{ $i }}</td>
            <td>
                @if(!empty($doctor->photo))
                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="{{ asset($doctor->photo) }}">
                @else
                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                @endif
            </td>
            <td>{{ $doctor->name }}</td>
            <td>{{ $doctor->specialty }}</td>
            <td>{{$doctor->contact_email}}</td>
            <td>{{ $doctor->contact_number }}</td>
            @if(Auth::user()->isAdmin())
                <td>{{ $http_response_header->partner->name }}</td>
            @endif
            <td>

                {!! Form::open(['route' => ['doctors.destroy', $doctor->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a data-id="{{$doctor->id}}" href="#" class="btn view-card btn-default btn-xs">
                        <i class="la la-eye">Show</i>
                    </a>
                    <a href="{{ URL::to('doctors/' . $doctor->id . '/edit') }}"
                       class='btn btn-default btn-xs'>Edit</a>
                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @php($i++)
    @endforeach
    </tbody>
</table>