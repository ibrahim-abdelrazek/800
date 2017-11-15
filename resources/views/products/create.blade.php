@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 > Create anew product</h3>
                    </div>
                    
                    <div class="panel-body">

                        {!! Form::open(array('route' => 'products.store',
                        'files'=>true
                        )) !!}

                            @include('products.fields')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
