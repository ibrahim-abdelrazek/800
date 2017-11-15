@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Patients</h3>
            <a href="{{ route('patients.create') }} " class="pull-right btn btn-success create"> Create New Patient</a>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                @include('patients.table')

            </div>
        </div>
    </div>

@endsection
