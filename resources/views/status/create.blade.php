@extends('layouts.app')

@push('customcss')
<link rel="stylesheet" type="text/css" href="{{asset('assets/styles/apps/crm/roles-permissions.min.css')}}">
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12 ks-panels-column-section">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title">Create New Status</h5>

                {!! Form::open(['route' => 'status.store']) !!}


                @include('status.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection