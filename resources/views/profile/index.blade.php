@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 > My Profile  </h3>

                        <a href="{!! route('profile.edit', [$profile['id']]) !!} " class="pull-right btn btn-default create"> Edit Profile</a>
                    </div>

                    <div class="panel-body">

                        <div class="show">
                            <span>Name: </span>
                            <span class="value" >{!! $profile['first_name'] .' ' . $profile['last_name'] !!}</span>
                        </div>
                        <br>


                        <div class="show">
                            <span>Email: </span>
                            <span class="value" >{!! $profile['email'] !!}</span>
                        </div>
                        <br>

                        @if(isset($profile['location']))

                            <div class="show">
                                <span>Location: </span>
                                <span class="value" >{!! $profile['location'] !!}</span>
                            </div>
                            <br>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
