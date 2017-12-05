@extends('layouts.app')
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3 > Products </h3>
{{--            <a href="{{ route('products.create') }} " class="pull-right btn btn-default create"> Creat New Product </a>--}}

        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link @if(!$errors->any()) active @endif" href="#" data-toggle="tab" data-target="#products-list">
                            All Products
                            @if(Auth::user()->isAdmin())
                                <span class="badge badge-info badge-pill">{{ App\Product::count()}}</span>
                            @elseif(Auth::user()->isPartner())
                                <span class="badge badge-info badge-pill">{{ App\Product::where('partner_id', Auth::user()->id)->count()}}</span>
                            @else
                                <span class="badge badge-info badge-pill">{{ App\Product::where('partner_id', Auth::user()->partner_id)->count()}}</span>
                            @endif

                        </a>
                    </li>
                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\Product::$model))
                        <li class="nav-item">
                            <a class="nav-link @if($errors->any()) active @endif" href="#" data-toggle="tab" data-target="#new-product">
                                Create New Product
                                @if($errors->any())
                                    <span class="badge badge-danger badge-pill">{{ count($errors->all()) }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(!$errors->any()) active @endif ks-column-section" id="products-list" role="tabpanel">
                        <!-- Content Here -->
                        @include('products.table')
                    </div>

                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\Product::$model))

                        <div class="tab-pane @if($errors->any()) active @endif" id="new-product" role="tabpanel">
                            <!-- Second Content -->

                            @include('products.create')
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
