<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="commission-datatable" class="orders-datatable table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="1" colspan="1">#</th>
                    <th rowspan="1" colspan="1">Doctor</th>
                    <th rowspan="1" colspan="1">Partner</th>
                    <th rowspan="1" colspan="1">Commission</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">#</th>
                    <th rowspan="1" colspan="1">Doctor</th>
                    <th rowspan="1" colspan="1">Partner</th>
                    <th rowspan="1" colspan="1">Commission</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </tr>
                </tfoot>
                <tbody>
                @foreach($doctors as $doctor)
                    <tr role="row" class="{{ $i%2==0 ? 'even' : 'odd' }}">
                        <td>{{$doctor->id}}</td>
                        <td>{{ $doctor->doctor }}</td>
                        <td>{{ $doctor->partner }}</td>
                        <td>{{ $doctor->commission }}</td>
                        <td>
                            <div class='btn-group'>
                                <a href="{!! route('hotelguest.show', [$hotelguest->id]) !!}" class='btn btn-default btn-xs'>Show</a>
                            </div>
                        </td>
                    </tr>
                    @php $i++ @endif
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@push('customjs')
   <script src="{{ asset('libs/datatables-net/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/media/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
    
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
                var table = $('#commission-datatable').DataTable({
                    lengthChange: false,
                    responsive: true,
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

                table.buttons().container().appendTo('#commission-datatable_wrapper .col-md-6:eq(0)');

            });
        })(jQuery);
    </script>
@endpush
