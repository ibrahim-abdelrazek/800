<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="commission-datatable" class="orders-datatable table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="1" colspan="1">#</th>
                    <th rowspan="1" colspan="1">Doctor</th>
                    <th rowspan="1">Speciality</th>
                    <th rowspan="1">Email</th>
                    <th rowspan="1">Number</th>
                    @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
                    <th rowspan="1" colspan="1">Partner</th>
                    @endif
                    <th rowspan="1" colspan="1">Commission</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">#</th>
                    <th rowspan="1" colspan="1">Doctor</th>
                    <th rowspan="1">Speciality</th>
                    <th rowspan="1">Email</th>
                    <th rowspan="1">Number</th>
                    @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
                    <th rowspan="1" colspan="1">Partner</th>
                    @endif
                    <th rowspan="1" colspan="1">Commission</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </tr>
                </tfoot>
                <tbody>
                @php($i = 1)
                @foreach($doctors as $doctor)
                    <tr role="row" id="{{$doctor->id}}" class="{{ $i%2==0 ? 'even' : 'odd' }}">
                        <td scope="row">{{ $i }}</td>
                        <td>{{ $doctor->first_name ." ". $doctor->last_name }}</td>
                        <td>{{ $doctor->specialty }}</td>
                        <td>{{$doctor->contact_email}}</td>
                        <td>{{ '+' .$doctor->contact_number }}</td>
                        @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
                            <td>{{ $doctor->partner->first_name . ' ' . $doctor->partner->last_name }}</td>
                        @endif
                        <td class="text-center">{{ $doctor->partner->commission }} %</td>
                        <td>
                            <div class='btn-group'>
                                <input type="hidden" value="{{$doctor->partner->commission}}" id="doctor_commission-{{$doctor->id}}">
                                <a data-toggle="modal" data-target="#myModalXX" class='commission_details btn btn-default btn-xs'>Details</a>
                            </div>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-sm-12">
                    {{--<div style="width:100%;">--}}
                        {{--<h5 style="text-align: center;">Monthly Commission</h5>--}}
                    {{--</div>--}}
                    <table id="table-orders-commission"
                           class="table table-responsive table-striped table-hover"
                           width="100%">
                        <thead>
                        <tr>
                            <th class="hidden-xs hidden-sm hidden-md">Month</th>
                            <th class="hidden-xs hidden-sm hidden-md">Total</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <br/>
                    <br/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

@push('customjs')
{{--   <script src="{{ asset('libs/datatables-net/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>--}}
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
                // commission details
                $(".commission_details").on('click', function () {
                    var ID = $(this).parent().parent().parent().attr('id');
                    var commission = $("#doctor_commission-"+ID).val();
                    $("#myModal .modal-title").html($("#"+ID+" td:nth-child(2)").html());

                    $.ajax({
                        type: "POST",
                        url: "/Order/CommissionDetails",
                        data: {
                            ID: ID
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            var obj = $.parseJSON(data);
//                            console.log(obj.length);
                            if(obj.length <= 0){
//                                $("#table-orders-commission tbody").html('');
                                $("#table-orders-commission").DataTable().destroy();
                                $('#table-orders-commission').DataTable({paging: true,
                                    searching: false,
                                    data: obj,
                                    cache: false,
                                    bAutoWidth: true,
                                    bLengthChange: false,
                                    bFilter: false,
                                    responsive: true,});

                                $('#table-orders-commission tbody tr td').css('width', '1000px');
                            }else {
                                $("#table-orders-commission").DataTable().destroy();
                                $('#table-orders-commission').DataTable({
                                    paging: true,
                                    searching: false,
                                    data: obj,
                                    cache: false,
                                    bAutoWidth: true,
                                    bLengthChange: false,
                                    bFilter: false,
                                    responsive: true,
                                    "aaSorting": [[0, "DESC"]],
                                    "columns": [
                                        {"mDataProp": "new_date", "width": "350px"},
                                        {
                                            "mDataProp": "TOTAL",
                                            "mRender": function (data, type, full) {
                                                return data * commission / 100;
                                            },
                                            "width": "50%"
                                        },
                                    ],
                                });
                                $('#table-orders-commission tbody tr td').css('width', '350px');
                            }
                        },
                        complete: function () {
                            $("#myModal").modal("show");
                        }
                    });
                });


                // Datatables
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
