<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="table-{{$status_id}}" class="orders-datatable table table-striped table-bordered" cellspacing="0" width="100%">
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
                @php $i=1; $orders = $orders->where('status_id', $status_id);
                @endphp
                @foreach($orders as $order)
                    <tr role="row" class="{{ $i%2==0 ? 'even' : 'odd' }}">
                        <td>{{$order->id}}</td>
                        <td>{{ $order->patient->first_name . " " . $order->patient->last_name }}</td>
                        <td>{{ $order->notes }}</td>
                        <td>{{ $order->owner->name }}</td>
                        <td>{{ date('Y m d', strtotime($order->created_at)) }}</td>
                        <td class="text-center">
                           <div class="btn-group">
                                            <button class="status-holder btn btn-{{$order->status->code}} btn-block @if($order->status->code != 'success') dropdown-toggle @endif" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               <span class="badge ks-circle badge-{{$order->status->code}}">{{$order->status->message}}</span>
                                            </button>
                                            @php 
                                            $statuses = App\Status::all();
                                            @endphp
                                            
                                            @if($statuses->count() > 0)
                                           @if($order->status->code != 'success') <div class="dropdown-menu">
                                            @foreach($statuses as $status)
                                                <a id="change-status" data-id="{{ $status->id}}" data-order-id="{{$order->id}}" data-code="{{$status->code}}" data-message="{{$status->message}}" class="badge ks-circle badge-{{$status->code}} dropdown-item" href="#">{{$status->message}}</a>
                                            @endforeach
                                               
                                            </div>
                                            @endif 
                                            @endif
                                        </div>
                                        
                       </td>
                        <td>
                            {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>

                                @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('view', App\Order::$model))
                                <a href="{!! url('orders/'. $order->id) !!}" class='btn btn-default btn-xs'>Show</a>
                               @endif
                                @if( $order->status->code != 'success' && Auth::user()->ableTo('edit', App\Order::$model ))
                                   <a href="{{ URL::to('orders/' . $order->id . '/edit') }}"
                                      class='btn btn-default btn-xs'>Edit</a>
                                @endif
                                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('delete', App\Order::$model))

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
    <script type="application/javascript">
        (function ($) {
            $(document).ready(function () {
                var table = $('#orders-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        },
                        {
                            extend : 'excelHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        }

                    ],
                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });

                table.buttons().container().appendTo('#orders-datatable_wrapper .col-md-6:eq(0)');

            });
        })(jQuery);
    </script>
@endpush
