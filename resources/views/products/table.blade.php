<div class="table">

   <table class="table table-responsive" id="igfollows-table">
        <thead>
        <th>Name</th>
        <th>image</th>        
        <th>price</th>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td><img width="150" src="{!! URL::asset('upload'.'/'.$product->image) !!}"></td>
                <td>{{ $product->price }}</td>
                <td>
                    {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! url('products/'. $product->id) !!}" class='btn btn-default btn-xs'>Show</a>

                        <a href="{{ URL::to('products/' . $product->id . '/edit') }}" class='btn btn-default btn-xs'>Edit</a>
                        {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>