@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 ks-panels-column-section">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title">Create new User Group</h5>

                {!! Form::open(['route' => 'usergroups.store']) !!}

                @if (isset($repeat))
                    <div class="alert alert-danger">
                        <ul>
                            <li class="text-danger"><b>{{ $repeat }}</b></li>
                        </ul>
                    </div>
                @endif

                @include('usergroups.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection