<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="patient-datatable" class="table table-striped table-bordered datatable dtr-inline" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="1" colspan="1">Name</th>
                    <th rowspan="1" colspan="1">Contact No.</th>
                    <th rowspan="1" colspan="1">Email</th>
                    <th rowspan="1" colspan="1">Notes</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">Name</th>
                    <th rowspan="1" colspan="1">Contact No.</th>
                    <th rowspan="1" colspan="1">Email</th>
                    <th rowspan="1" colspan="1">Notes</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </tfoot>
                <tbody>
                @php($i=1)
        @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->first_name .' '. $patient->last_name}}</td>
                <td>{{ '+' .$patient->contact_number}}</td>
                <td>{{ $patient->email}}</td>
                <td>{{ $patient->notes }}</td>
                <td>
                    {!! Form::open(['route' => ['patients.destroy', $patient->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! url('patients/'. $patient->id) !!}" class='btn btn-default btn-xs'>Show</a>
                         @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('edit', App\Patient::$model))
                  
                        <a href="{{ URL::to('patients/' . $patient->id . '/edit') }}" class='btn btn-default btn-xs'>Edit</a>
                        @endif
                         @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('delete', App\Patient::$model))
                  
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
</div>
</div>
</div>
