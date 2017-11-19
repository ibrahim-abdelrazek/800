<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="user-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="1" colspan="1">Image</th>
                    <th rowspan="1" colspan="1">Name</th>
                    <th rowspan="1" colspan="1">User Name</th>
                    <th rowspan="1" colspan="1">Email</th>
                    <th rowspan="1" colspan="1">User Group</th>
                    @if(Auth::user()->isAdmin())
                        <th>Partner</th>
                    @endif
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">Image</th>
                    <th rowspan="1" colspan="1">Name</th>
                    <th rowspan="1" colspan="1">User Name</th>
                    <th rowspan="1" colspan="1">Email</th>
                    <th rowspan="1" colspan="1">User Group</th>
                    @if(Auth::user()->isAdmin())
                        <th>Partner</th>
                    @endif
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </tfoot>
                <tbody>
                @php($i=1)
        @foreach($users as $user)
            <tr role="row" class="{{ $i%2==0 ? 'even' : 'odd' }}">
                <td><img style="width:100px" src="{!! URL::asset($user->avatar) !!}"></td>
                <td>{!! $user->name !!}</td>
                <td>{!! $user->username !!}</td>
                <td>{!! $user->email !!}</td>
                <td>{!! $user->userGroup->group_name !!}</td>
                @if(Auth::user()->isAdmin())
                    <td>{!! \App\Partner::where('id',$user->partner_id)->value('name')!!}</td>
                @endif

                    <td>
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'>Show</a>
                        <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'>Edit</a>
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
    <script type="application/javascript">
        (function ($) {
            $(document).ready(function () {
                var table = $('#user-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions:{
                                columns: [1,2,3,4,5]
                            }
                        },
                        {
                            extend : 'excelHtml5',
                            exportOptions:{
                                columns: [1,2,3,4,5]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions:{
                                columns: [1,2,3,4,5]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions:{
                                columns: [1,2,3,4,5]
                            }
                        }

                    ],

                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });

                table.buttons().container().appendTo('#user-datatable_wrapper .col-md-6:eq(0)');

            });
        })(jQuery);
    </script>
@endpush