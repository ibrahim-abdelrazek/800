@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3> Edit order </h3>
                    </div>

                    <div class="panel-body">

                        {!! Form::model($order, ['route' => ['orders.update', $order->id], 'method' => 'patch','files' =>true]) !!}

                        @include('orders.fields')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
