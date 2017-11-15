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
                            <span class="value" >{!! $hotelguest->name !!}</span>
                        </div>

                        <div class="show">
                            <span>Officer Name: </span>
                            <span class="value" >{!! $hotelguest->officer_name !!}</span>
                        </div>
                        <div class="show">
                            <span>Contact Number: </span>
                            <span class="value" >{!! $hotelguest->contact_number !!}</span>
                        </div>

                        <div class="show">
                            <span>Guest Room Number: </span>
                            <span class="value" >{!! $hotelguest->guest_room_number !!}</span>
                        </div>
                        <div class="show">
                            <span>Guest First Name: </span>
                            <span class="value" >{!! $hotelguest->guest_first_name !!}</span>
                        </div>

                        <div class="show">
                            <span>Guest Last Name: </span>
                            <span class="value" >{!! $hotelguest->guest_last_name !!}</span>
                        </div>
                        <div class="show">
                            <span>Items: </span>
                            <span class="value" >{!! $hotelguest->items !!}</span>
                        </div>

                        <br>
                        <a href="{!! route('hotelguest.index') !!}" class="btn btn-default pull-right">Back</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
