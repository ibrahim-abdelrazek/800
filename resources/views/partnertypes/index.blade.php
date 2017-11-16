@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Partner Types</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-sm-12">

                        @include('partnertypes.create')
                    </div>

                    <div class="col-lg-6 col-sm-12 col-sm-12">
                        @include('partnertypes.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
