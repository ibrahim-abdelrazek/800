@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Edit Dr. {{ $doctor->name }}</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            {!! Form::model($doctor, ['route' => ['doctors.update', $doctor->id], 'method' => 'patch']) !!}

            @include('doctors.fields')

            {!! Form::close() !!}

        </div>
    </div>

@endsection
