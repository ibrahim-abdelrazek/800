<table class="table table-bordered text-light stacktable large-only">
    <thead class="thead-default">
    <tr>
        <th width="1">#</th>
        <th>Name</th>
        <th>Speciality</th>
        <th>Contact</th>
        <th>Actions</th>

    </tr>
    </thead>
    <tbody>
    @php($i = 1)
    @foreach($doctors as $doctor)
        <tr>
            <td scope="row">{{ $i }}</td>
            <td>{{ $doctor->name }}</td>
            <td>{{ $doctor->specialty }}</td>
            <td>{{ $doctor->contact_details }}</td>
            <td>

                {!! Form::open(['route' => ['doctors.destroy', $doctor->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a data-id="{{$doctor->id}}" href="#" class="btn view-card btn-default btn-xs">
                        <i class="la la-eye">View Card</i>
                    </a>
                    <a href="{!! url('doctors/'. $doctor->id) !!}" class='btn btn-default btn-xs'>Show</a>

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