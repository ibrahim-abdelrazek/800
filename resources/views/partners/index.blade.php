@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Doctors</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-sm-12">

                        @include('partners.create')
                    </div>
                    <div class="col-lg-8 col-sm-12 col-sm-12">
                        @include('partners.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
