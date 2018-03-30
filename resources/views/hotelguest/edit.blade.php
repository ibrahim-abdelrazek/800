@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Edit Guest</h5>


                    {!! Form::model($hotelguest, ['route' => ['hotelguest.update', $hotelguest->id], 'method' => 'patch']) !!}

                    @include('hotelguest.fields')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
