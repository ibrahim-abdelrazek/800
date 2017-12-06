@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/jquery-confirm/jquery.confirm.min.css') }}"> <!-- original -->
    <!-- customization -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- customization -->

    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/media/css/dataTables.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/extensions/responsive/js/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/extensions/buttons/css/buttons.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/datatables-net/datatables.min.css')}}"> <!-- customization -->

@endpush
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Categories</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link @if(!$errors->any()) active @endif " href="#" data-toggle="tab" data-target="#categories-list">
                            All Categories
                            <span class="badge badge-info badge-pill">{{ App\Category::count()}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($errors->any()) active @endif" href="#" data-toggle="tab" data-target="#new_category">
                            Create New Category
                            @if($errors->any())
                                <span class="badge badge-danger badge-pill">{{ count($errors->all()) }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(!$errors->any()) active @endif ks-column-section" id="categories-list" role="tabpanel">
                     <!-- Content Here --> 
                     @include('category.table')
                     </div>
                    @if(Auth::user()->isAdmin() ||  Auth::user()->ableTo('add', App\Category::$model))

                    <div class="tab-pane @if($errors->any()) active @endif" id="new_category" role="tabpanel">
                        <!-- Second Content --> 
                        @include('category.create')
                    </div>
                    @endif
                      </div>
                </div>
            </div>
        </div>
@endsection
