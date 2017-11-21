<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="usergroups-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="1" colspan="1">Name</th>
                    @if(Auth::user()->isAdmin()) <th rowspan="1" colspan="1">Partner</th>@endif
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">Name</th>
                    @if(Auth::user()->isAdmin()) <th rowspan="1" colspan="1">Partner</th>@endif
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </tfoot>
                <tbody>
                @php($i=1)
                @foreach($usergroups as $usergroup)
                    <tr role="row" class="{{ $i%2==0 ? 'even' : 'odd' }}">
                        <td>{!! $usergroup->group_name !!}</td>
                        @if(Auth::user()->isAdmin())<td>{!! \App\Partner::where('id', $usergroup->partner_id)->value('name') !!}</td>@endif

                        <td>
                            <div class='btn-group'>
                                <button data-id="{{$usergroup->id}}"
                                        class='btn btn-default show-details btn-xs'>Details</button>
                                <a href="{!! route('usergroups.edit', [$usergroup->id]) !!}" class='btn btn-default btn-xs'>Edit</a>
                                {!! Form::open(['route' => ['usergroups.destroy', $usergroup->id], 'method' => 'delete']) !!}
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure? if delete this , all related users will delete also')"]) !!}
                                {!! Form::close() !!}

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
            @if(Auth::user()->isAdmin())

                var table = $('#usergroups-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions:{
                                columns: [0,1]
                            }
                        },
                        {
                            extend : 'excelHtml5',
                            exportOptions:{
                                columns: [0,1]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions:{
                                columns: [0,1]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions:{
                                columns: [0,1]
                            }
                        }

                    ],

                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });
        @else
                var table = $('#usergroups-datatable').DataTable({
                        lengthChange: false,
                        buttons: [
                            {
                                extend: 'copyHtml5',
                                exportOptions:{
                                    columns: [0]
                                }
                            },
                            {
                                extend : 'excelHtml5',
                                exportOptions:{
                                    columns: [0]
                                }
                            },
                            {
                                extend: 'csvHtml5',
                                exportOptions:{
                                    columns: [0]
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                exportOptions:{
                                    columns: [0]
                                }
                            }

                        ],

                        initComplete: function () {
                            $('.dataTables_wrapper select').select2({
                                minimumResultsForSearch: Infinity
                            });
                        }
                    });
        @endif
                table.buttons().container().appendTo('#usergroups-datatable_wrapper .col-md-6:eq(0)');

            });
        })(jQuery);
    </script>
@endpush