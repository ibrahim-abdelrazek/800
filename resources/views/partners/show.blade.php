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
                            <span class="value" >{!! $partner->name !!}</span>
                        </div>

                        <div class="show">
                            <span>Locations: </span>
                            <span class="value" >{!! $partner->location !!}</span>
                        </div>

                        <div class="show">
                            <span>Partner Type: </span>
                            <span class="value" >{!! $partner->partnerType->name !!}</span>
                        </div>

                        <div class="show">
                            <span>Username: </span>
                            <span class="value" >{!! $partner->user->username !!}</span>
                        </div>

                        <div class="show">
                            <span>Email: </span>
                            <span class="value" >{!! $partner->user->email !!}</span>
                        </div>

                        <div class="pull-right">
                            <a href="{!! route('partners.index') !!}" class="btn btn-default">Back</a>
                        </div>
                        <div class="clearfix"></div>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
