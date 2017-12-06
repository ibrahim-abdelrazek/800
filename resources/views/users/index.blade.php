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
            <h3>Users</h3>
{{--            <a href="{{ route('users.create') }} " class="pull-right btn btn-success create"> Create User</a>--}}
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link @if(!$errors->any()) active @endif" href="#" data-toggle="tab" data-target="#users-list">
                            All Users
                            @if(Auth::user()->isAdmin())
                                <span class="badge badge-info badge-pill">{{ App\User::count()}}</span>
                            @elseif(Auth::user()->isPartner())
                                <span class="badge badge-info badge-pill">{{ App\User::where('partner_id', Auth::user()->id)->count()}}</span>
                            @else
                                <span class="badge badge-info badge-pill">{{ App\User::where('partner_id', Auth::user()->partner_id)->count()}}</span>
                            @endif

                        </a>
                    </li>
                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\User::$model))
                        <li class="nav-item">
                            <a class="nav-link @if($errors->any()) active @endif" href="#" data-toggle="tab" data-target="#new-user">
                                Create New User
                                @if($errors->any())
                                    <span class="badge badge-danger badge-pill">{{ count($errors->all()) }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(!$errors->any()) active @endif ks-column-section" id="users-list" role="tabpanel">
                        <!-- Content Here -->
                        @include('users.table')
                    </div>

                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\User::$model))

                        <div class="tab-pane @if($errors->any()) active @endif" id="new-user" role="tabpanel">
                            <!-- Second Content -->

                            @include('users.create')
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
