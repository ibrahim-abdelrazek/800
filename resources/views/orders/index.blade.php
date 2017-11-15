@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Orders</h3>

            <a href="{{ route('orders.create') }} " class="pull-right btn btn-default create"> Create new order </a>

        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                    @include('orders.table')
            </div>
        </div>
    </div>

@endsection
