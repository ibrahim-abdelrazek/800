@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Edit Status</h5>


                        {!! Form::model($status, ['route' => ['status.update', $status['id']], 'method' => 'patch']) !!}


                        @include('status.fields')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

@endsection
