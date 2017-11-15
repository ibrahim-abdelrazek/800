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
                            <span>Name: </span>
                            <span class="value" >{{ $product->name }}</span>
                        </div>

                        <div class="show">
                            <span>image </span>
                            <span class="value" ><img src="{!! URL::asset('upload'.'/'.$product->image) !!}"></span>
                        </div>
                        <div class="show">
                            <span>price </span>
                            <span class="value" >{{ $product->price }}</span>
                        </div>
                        <div class="show">
                            <span>created at </span>
                            <span class="value" >{{ $product->created_at }}</span>
                        </div>
                        <div class="show">
                            <span>updated at </span>
                            <span class="value" >{{ $product->updated_at }}</span>
                        </div>

                        


                        <br>
                        <a href="{!! route('products.index') !!}" class="btn btn-default pull-right">Back</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
