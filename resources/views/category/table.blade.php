<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
<table id="categories-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
<thead>
    <tr>
        <th rowspan="1">Name</th>
        <th rowspan="1">Parent</th>
        <th rowspan="1">Actions</th>
    </tr>

    </thead>
    <tfoot>
    <tr>
        <th rowspan="1">Name</th>
        <th rowspan="1">Parent</th>
        <th rowspan="1">Actions</th>

    </tr>
    </tfoot>
    <tbody>
    @php($i = 1)
    @foreach($categories as $category)

        <tr>
            <td scope="row"><b>{{ $category->name }}</b></td>
            <td scope="row">

                @if($category->parent == 0)
                    {{ 'root' }}
                @else
                    {{\App\Category::where("id",$category->parent)->value('name') }}
                        @endif

            </td>
            <td scope="row">
                <div class='btn-group'>
                <a href="{{ URL::to('category/' . $category->id . '/edit') }}" class='btn btn-default btn-xs'>Edit</a>
                {!! Form::open(['route' => ['category.destroy', $category->id], 'method' => 'delete']) !!}
                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                {!! Form::close() !!}
                </div>
            </td>

        </tr>

        @if(!$category->children->isEmpty())
            <tr>
                @foreach($category->children as $subcategory)
                    <td>&nbsp &nbsp &nbsp{{'__'. $subcategory->name }}</td>
                    <td scope="row">

                        @if($subcategory->parent == 0)
                            {{ 'root' }}
                        @else
                            {{\App\Category::where("id",$subcategory->parent)->value('name') }}
                        @endif

                    </td>
                    <td><div class='btn-group'>
                            <a href="{{ URL::to('category/' . $subcategory->id . '/edit') }}" class='btn btn-default btn-xs'>Edit</a>
                            {!! Form::open(['route' => ['category.destroy', $subcategory->id], 'method' => 'delete']) !!}
                            {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
            </tr>
                            @if(!$subcategory->children->isEmpty())
                                <tr>
                                    @foreach($subcategory->children as $subcategory1)
                                        <tr>
                                        <td>&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp{{'____'.    $subcategory1->name }}</td>
                                        <td scope="row">

                                            @if($subcategory1->parent == 0)
                                                {{ 'root' }}
                                            @else
                                                {{\App\Category::where("id",$subcategory1->parent)->value('name') }}
                                            @endif

                                        </td>
                                        <td>
                                            <div class='btn-group'>
                                                <a href="{{ URL::to('category/' . $subcategory1->id . '/edit') }}" class='btn btn-default btn-xs'>Edit</a>
                                                {!! Form::open(['route' => ['category.destroy', $subcategory1->id], 'method' => 'delete']) !!}
                                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                {!! Form::close() !!}
                                            </div></td>
                                        </tr>
                                    @endforeach

                                </tr>
                            @endif

                @endforeach

        @endif

        @php($i++)
    @endforeach
    </tbody>
</table>
        </div></div></div>
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
                var table = $('#categories-datatable').DataTable({
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

                table.buttons().container().appendTo('#categories-datatable_wrapper .col-md-6:eq(0)');
                $('#categories-datatable_filter').addClass('pull-right');
                $('#categories-datatable_paginate').addClass('pull-right');
            });
        })(jQuery);
    </script>
@endpush
