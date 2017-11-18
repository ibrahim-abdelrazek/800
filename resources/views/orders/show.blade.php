@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class=""> order </h3>
                    </div>

                    <div class="panel-body">

                        <div class="show">
                            <span>prescription: </span>
                            <span class="value" ><img src="{!! URL::asset('upload'.$order->prescription) !!}"></span>
                        </div>

                        <div class="show">
                            <span>notes </span>
                            <span class="value" >{{ $order->notes }}</span>
                        </div>
                        <div class="show">
                            <span>created at </span>
                            <span class="value" >{{ $order->created_at }}</span>
                        </div>
                        <div class="show">
                            <span>updated at </span>
                            <span class="value" >{{ $order->updated_at }}</span>
                        </div>

                        


                        <br>
                        <a href="{{  route('orders.index') }}" class="btn btn-default pull-right">Back</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
