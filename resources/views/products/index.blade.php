@extends('layouts.app')
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3 > Products </h3>
            <a href="{{ route('products.create') }} " class="pull-right btn btn-default create"> Creat New Product </a>

        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-12 col-sm-12 col-sm-12">
                        @include('products.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
