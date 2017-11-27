<table id="guest-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th rowspan="1" colspan="1">Hotel</th>
        <th rowspan="1" colspan="1">Guest Name</th>
        <th rowspan="1" colspan="1">Officer Name</th>
        <th rowspan="1" colspan="1">Contact Number</th>
        <th rowspan="1" colspan="1">Guest Room Number</th>
        <th rowspan="1" colspan="1">Partner</th>
        <th rowspan="1" colspan="1">Items</th>


                       @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('view', App\HotelGuest::$model) || Auth::user()->ableTo('edit', App\HotelGuest::$model) || Auth::user()->ableTo('delete', App\HotelGuest::$model))
        <th rowspan="1" colspan="3">Actions</th>
        @endif
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th rowspan="1" colspan="1">Hotel</th>
        <th rowspan="1" colspan="1">Guest Name</th>
        <th rowspan="1" colspan="1">Officer Name</th>
        <th rowspan="1" colspan="1">Contact Number</th>
        <th rowspan="1" colspan="1">Guest Room Number</th>
        <th rowspan="1" colspan="1">Partner</th>
        <th rowspan="1" colspan="1">Items</th>
        @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('view', App\HotelGuest::$model) || Auth::user()->ableTo('edit', App\HotelGuest::$model) || Auth::user()->ableTo('delete', App\HotelGuest::$model))
        <th rowspan="1" colspan="3">Actions</th>
        @endif
    </tr>
    </tfoot>
    <tbody>
    @foreach($hotelguests as $hotelguest)
        <tr>
            <td>{!! $hotelguest->name !!}</td>
            <td>{!! $hotelguest->guest_first_name . " " . $hotelguest->guest_last_name  !!}</td>
            <td>{!! $hotelguest->officer_name !!}</td>
            <td>{!! $hotelguest->contact_number !!}</td>
            <td>{!! $hotelguest->guest_room_number !!}</td>
            <td>{!! $hotelguest->partner->first_name . ' ' .$hotelguest->partner->last_name !!}</td>
            <td>{!! $hotelguest->items !!}</td>

                       @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('view', App\HotelGuest::$model) || Auth::user()->ableTo('edit', App\HotelGuest::$model) || Auth::user()->ableTo('delete', App\HotelGuest::$model))
            <td>
                {!! Form::open(['route' => ['hotelguest.destroy', $hotelguest->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                       @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('view', App\HotelGuest::$model))
                    <a href="{!! route('hotelguest.show', [$hotelguest->id]) !!}"
                       class='btn btn-default btn-xs'>Show</a>
                       @endif
                       @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('edit', App\HotelGuest::$model))
                    <a href="{!! route('hotelguest.edit', [$hotelguest->id]) !!}"
                       class='btn btn-default btn-xs'>Edit</a>
                    @endif
                       @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('delete', App\HotelGuest::$model))
                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
            @endif
        </tr>
    @endforeach

    </tbody>
</table>
