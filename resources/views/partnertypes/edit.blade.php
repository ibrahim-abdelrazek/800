@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3> Edit Partner Types </h3>
                    </div>

                    <div class="panel-body">

                        {!! Form::model($partnertype, ['route' => ['partnertypes.update', $partnertype->id], 'method' => 'patch']) !!}

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger"><b>{{ $error }}</b></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @include('partnertypes.fields')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
