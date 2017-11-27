@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class=""> nurse </h3>
                    </div>

                    <div class="panel-body">

                        <div class="show">
                            <span>Name: </span>
                            <span class="value" >{{ $nurse->first_name ." " .$nurse->last_name }}</span>
                        </div>
                        <div class="show">
                            <span>created at </span>
                            <span class="value" >{{ $nurse->created_at }}</span>
                        </div>
                        <div class="show">
                            <span>updated at </span>
                            <span class="value" >{{ $nurse->updated_at }}</span>
                        </div>

                        <!-- partner name  ????!!
                        <div class="show">
                            <span>Name: </span>
                            <span class="value" >{{$nurse->name }}</span>
                        </div>
-->

                        <br>
                        <a href="{{ route('nurses.index') }}" class="btn btn-default pull-right">Back</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
