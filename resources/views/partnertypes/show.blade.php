@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class=""> Partner Type </h3>
                    </div>

                    <div class="panel-body">

                        <div class="show">
                            <span>Name: </span>
                            <span class="value" >{!! $partnertype->name !!}</span>
                        </div>

                        <div class="show">
                            <span>Status: </span>
                            <span class="value" >{!! $partnertype->status !!}</span>
                        </div>

                        <br>
                        <a href="{!! route('partnertypes.index') !!}" class="btn btn-default pull-right">Back</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
