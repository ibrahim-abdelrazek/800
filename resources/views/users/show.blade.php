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
                            <span class="value" >{!! $user->name !!}</span>
                        </div>

                        <div class="show">
                            <span>Username: </span>
                            <span class="value" >{!! $user->username !!}</span>
                        </div>
                        <div class="show">
                            <span>email: </span>
                            <span class="value" >{!! $user->email !!}</span>
                        </div>

                        <div class="show">
                            <span>Sub-User: </span>
                            <span class="value" >{!! $user->UserGroup->group_name !!}</span>
                        </div>

                        <br>
                        <a href="{!! route('users.index') !!}" class="btn btn-default pull-right">Back</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
