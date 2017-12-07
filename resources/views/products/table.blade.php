<div class="ks-nav-body">
    <div class="ks-nav-body-wrapper">
        <div class="container-fluid">
            <table id="products-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th rowspan="1" colspan="1"> Barcode</th>
                    <th rowspan="1" colspan="1">Image</th>
                    <th rowspan="1" colspan="1">Title</th>
                    <th rowspan="1" colspan="1">Category</th>
                    <th rowspan="1" colspan="1">Price</th>
                    <th rowspan="1" colspan="1">Quantity</th>
                    <th rowspan="1" colspan="1">Description</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">Barcode</th>
                    <th rowspan="1" colspan="1">Image</th>
                    <th rowspan="1" colspan="1">Title</th>
                    <th rowspan="1" colspan="1">Category</th>
                    <th rowspan="1" colspan="1">Price</th>
                    <th rowspan="1" colspan="1">Quantity</th>
                    <th rowspan="1" colspan="1">Description</th>
                    <th rowspan="1" colspan="1">Actions</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td><img src="{!! URL::asset('upload/products'.'/'.$product->image) !!}" style="width:150px !important; height: 100px !important;"></td>
                        <td>{{ $product->name }}</td>

                        <td><ul>
                            @foreach($product->category as $cat)
                                <li>{{ $cat->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>{{ $product->description }}</td>

                        <td>
                            {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
<!--                                <a href="{!! route('products.show', [$product->id]) !!}" class='btn btn-default btn-xs'>Show</a>
-->                                <a href="{!! route('products.edit', [$product->id]) !!}" class='btn btn-default btn-xs'>Edit</a>
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
            var table = $('#products-datatable').DataTable({
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

            table.buttons().container().appendTo('#products-datatable_wrapper .col-md-6:eq(0)');
            $('#products-datatable_filter').addClass('pull-right');
            $('#products-datatable_paginate').addClass('pull-right');
        });
    })(jQuery);
</script>
@endpush

