@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 > product </h3>
                        <a href="{{ route('products.create') }} " class="pull-right btn btn-default create"> add anew product </a>
                    </div>

                    <div class="panel-body">

                        @include('products.table')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
