<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="user-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="1" colspan="1">#</th>
                    <th rowspan="1" colspan="1">Patient</th>
                    <th rowspan="1" colspan="1">Notes</th>
                    <th rowspan="1" colspan="1">Order By</th>
                    <th rowspan="1" colspan="1">Date</th>
                    <th rowspan="1" colspan="1">Status</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">#</th>
                    <th rowspan="1" colspan="1">Patient</th>
                    <th rowspan="1" colspan="1">Notes</th>
                    <th rowspan="1" colspan="1">Order By</th>
                    <th rowspan="1" colspan="1">Date</th>
                    <th rowspan="1" colspan="1">Status</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </tfoot>
                <tbody>
                @php($i=1)
                @foreach($orders as $order)
                    <tr role="row" class="{{ $i%2==0 ? 'even' : 'odd' }}">
                        <td>{{$order->id}}</td>
                        <td>{{ $order->patient->name }}</td>
                        <td>{{ $order->notes }}</td>
                        <td>{{ $order->owner->name }}</td>
                        <td>{{ date('Y m d', $order->created_at) }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{!! url('orders/'. $order->id) !!}" class='btn btn-default btn-xs'>Show</a>

                                <a href="{{ URL::to('orders/' . $order->id . '/edit') }}"
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
                var table = $('#user-datatable').DataTable({
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

                table.buttons().container().appendTo('#user-datatable_wrapper .col-md-6:eq(0)');
                $('#user-datatable_filter').addClass('pull-right');
                $('#user-datatable_paginate').addClass('pull-right');
            });
        })(jQuery);
    </script>
@endpush