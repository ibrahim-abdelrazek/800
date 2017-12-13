@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/media/css/dataTables.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/extensions/buttons/css/buttons.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/datatables-net/datatables.min.css')}}"> <!-- customization -->

@endpush
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Commissions</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link @if(!$errors->any()) active @endif" href="#" data-toggle="tab" data-target="#hotelguests-list">
                            All Commissions
                            @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
                                <span class="badge badge-info badge-pill">{{ App\Doctor::count()}}</span>
                            @elseif(Auth::user()->isPartner())
                                <span class="badge badge-info badge-pill">{{ App\Doctor::where('partner_id', Auth::user()->id)->count()}}</span>
                            @else
                                <span class="badge badge-info badge-pill">{{ App\Doctor::where('partner_id', Auth::user()->partner_id)->count()}}</span>
                            @endif

                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(!$errors->any()) active @endif ks-column-section" id="hotelguests-list" role="tabpanel">
                        <!-- Content Here -->
                        @include('orders.commission.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
