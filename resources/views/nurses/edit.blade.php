@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Edit Nurse {{ $nurse->name }}</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            {!! Form::model($nurse, ['route' => ['nurses.update', $nurse->id], 'method' => 'patch']) !!}

            @include('nurses.fields')

            {!! Form::close() !!}

        </div>
    </div>

@endsection

