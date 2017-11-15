@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Nurses</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        @include('nurses.create')
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        @include('nurses.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
