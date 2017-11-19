@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3> Edit product </h3>
                    </div>

                    <div class="panel-body">

                        {!! Form::model($product, ['route' => ['products.update', $product['id']], 'method' => 'patch' , 'files' => true ] ) !!}
                        @if (isset($repeat))
                            <div class="alert alert-danger">
                                <ul>
                                    <li class="text-danger"><b>{{ $repeat }}</b></li>
                                </ul>
                            </div>
                        @endif
                        @include('products.fields')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
