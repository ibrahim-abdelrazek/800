@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Users</h3>
            <a href="{{ route('users.create') }} " class="pull-right btn btn-success create"> Create User</a>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                @include('users.table')
            </div>
        </div>
    </div>

@endsection
