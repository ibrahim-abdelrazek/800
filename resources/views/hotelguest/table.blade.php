<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="guest-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="1" colspan="1">Hotel</th>
                    <th rowspan="1" colspan="1">Name</th>
                    <th rowspan="1" colspan="1">Officer Name</th>
                    <th rowspan="1" colspan="1">Contact Number</th>
                    <th rowspan="1" colspan="1">Guest Room Number</th>
                    <th rowspan="1" colspan="1">Special Instructions</th>
                    <th rowspan="1" colspan="1">Actions</th>
                    <th rowspan="1" colspan="1">user</th>
                    <th rowspan="1" colspan="3"></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">Hotel</th>
                    <th rowspan="1" colspan="1">Name</th>
                    <th rowspan="1" colspan="1">Officer Name</th>
                    <th rowspan="1" colspan="1">Contact Number</th>
                    <th rowspan="1" colspan="1">Guest Room Number</th>
                    <th rowspan="1" colspan="1">Special Instructions</th>
                    <th rowspan="1" colspan="1">Actions</th>
                    <th rowspan="1" colspan="1">user</th>
                    <th rowspan="1" colspan="3"></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($hotelguests as $hotelguest)
                    <tr>
                        <td>{!! $hotelguest->name !!}</td>
                        <td>{!! $hotelguest->officer_name !!}</td>
                        <td>{!! $hotelguest->contact_number !!}</td>
                        <td>{!! $hotelguest->guest_room_number !!}</td>
                        <td>{!! $hotelguest->guest_first_name !!}</td>
                        <td>{!! $hotelguest->guest_last_name !!}</td>
                        <td>{!! $hotelguest->items !!}</td>

                        <td>
                            @if($hotelguest->user_id == null)
                                Null
                            @else
                                $hotelguest->user->getUserName;
                            @endif
                        </td>
                        <td>
                            {!! Form::open(['route' => ['hotelguest.destroy', $hotelguest->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{!! route('hotelguest.show', [$hotelguest->id]) !!}"
                                   class='btn btn-default btn-xs'>Show</a>
                                <a href="{!! route('hotelguest.edit', [$hotelguest->id]) !!}"
                                   class='btn btn-default btn-xs'>Edit</a>
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@push('customjs')
    <script src="{{ asset('libs/datatables-net/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/media/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script type="application/javascript">
        (function ($) {
            $(document).ready(function () {
                var table = $('#guest-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                        'colvis'
                    ],
                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });

                table.buttons().container().appendTo('#guest-datatable_wrapper .col-md-6:eq(0)');
                $('#guest-datatable_filter').addClass('pull-right');
                $('#guest-datatable_paginate').addClass('pull-right');
            });
        })(jQuery);
    </script>
@endpush