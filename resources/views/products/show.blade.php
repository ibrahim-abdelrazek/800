@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class=""> product </h3>
                    </div>

                    <div class="panel-body">

                        <div class="show">
                            <span>Title: </span>
                            <span class="value" >{{ $product->name }}</span>
                        </div>
                        <div class="show">
                            <span>Category </span>
                            <span class="value" >
                                <ul>
                                    @foreach($product->category as $cat)
                                        <li>{{ $cat->name }}</li>
                                        @endforeach
                                </ul>
                            </span>
                        </div>

                        <div class="show">
                            <span>price </span>
                            <span class="value" >{{ $product->price }}</span>
                        </div>
                         <div class="show">
                            <span>Quantity </span>
                            <span class="value" >{{ $product->qty }}</span>
                        </div>
                         <div class="show">
                            <span>Description </span>
                            <span class="value" >{{ $product->description }}</span>
                        </div>

                        <div class="show">
                            <span>image: </span>
                            <span class="value" ><img style="width:100px" src="{!! URL::asset('upload/product'.'/'.$product->image) !!}"></span>
                        </div>
                        


                        <br>
                        <a href="{!! route('products.index') !!}" class="btn btn-default pull-right">Back</a>

                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
