@extends('layouts.app')


@php
    $userCount = (Auth::user()->isAdmin())? (\App\User::count() - \App\Partner::count() -1):(\App\User::where("partner_id",Auth::user()->partner_id)->count()  -1);
    $nurseCount = (Auth::user()->isAdmin())? (\App\Nurse::count()):(\App\Nurse::where("partner_id",Auth::user()->partner_id)->count());
    $doctorCount = (Auth::user()->isAdmin())? (\App\Doctor::count()):(\App\Doctor::where("partner_id",Auth::user()->partner_id)->count());
    $hotleGuestCount = (Auth::user()->isAdmin())? (\App\HotelGuest::count()):(\App\HotelGuest::where("partner_id",Auth::user()->partner_id)->count());
    $patientCount = (Auth::user()->isAdmin())? (\App\Patient::count()):(\App\Patient::where("partner_id",Auth::user()->partner_id)->count());
    $productCount = (Auth::user()->isAdmin())? (\App\Product::count()):(\App\Product::where("partner_id",Auth::user()->partner_id)->count());
    $orderCount = (Auth::user()->isAdmin())? (\App\Order::count()):(\App\Order::where("partner_id",Auth::user()->partner_id)->count());


@endphp






@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Dashboard</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="container">

                <div class="row">

                    @if( \Illuminate\Support\Facades\Auth::user()->isAdmin() )
                    <div class="col-md-4">
                        <div class="card ks-widget-payment-simple-amount-item ks-green">
                            <div class="payment-simple-amount-item-icon-block">
                                <span class="la la-pie-chart ks-icon"></span>
                            </div>

                            <a href="{{url("/partnertypes")}}">

                                <div class="payment-simple-amount-item-body">
                                    <div class="payment-simple-amount-item-amount">
                                        <span class="ks-amount">{{ \App\PartnerType::count() }}</span>
                                    </div>
                                    <div class="payment-simple-amount-item-description">
                                        Total Partner Types
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if( \Illuminate\Support\Facades\Auth::user()->isAdmin() )

                        <div class=" col-md-4">
                            <div class="card ks-widget-payment-simple-amount-item ks-orange">
                                <div class="payment-simple-amount-item-icon-block">
                                    <span class="la la-area-chart ks-icon"></span>
                                </div>
                                <a href="{{url("/partners")}}">
                                    <div class="payment-simple-amount-item-body">
                                        <div class="payment-simple-amount-item-amount">
                                            <span class="ks-amount">{{ \App\Partner::count() }}</span>
                                        </div>
                                        <div class="payment-simple-amount-item-description">
                                            Total Partners
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif

                    @php
                        $userClass = (\Illuminate\Support\Facades\Auth::user()->isAdmin())?  "" :  "col-md-4";
                        echo "<div class='". $userClass."'></div>";

                    @endphp
                        @if(Auth::user()->isAdmin() || Auth::user()->isPartner())
                            <div class="col-md-4">
                                <div class="card ks-widget-payment-simple-amount-item ks-pink">
                                    <div class="payment-simple-amount-item-icon-block">
                                        <span class="ks-icon-user ks-icon"></span>
                                    </div>
                                    <a href="{{url("/users")}}">

                                        <div class="payment-simple-amount-item-body">
                                            <div class="payment-simple-amount-item-amount">
                                                <span class="ks-amount">{{ $userCount }}</span>
                                            </div>
                                            <div class="payment-simple-amount-item-description">
                                                Total Users
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>

                        @endif

                </div>

                <div class="row">


                <div class="col-xl-4">
                    <a href="{{url("/nurses")}}">
                        <div class="ks-dashboard-widget ks-widget-amount-statistics ks-info">
                            <div class="ks-statistics">

                                <span class="ks-amount">{{ $nurseCount }}</span>
                                <span class="ks-text">Total Nurses</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="{{url("/doctors")}}">

                        <div class="ks-dashboard-widget ks-widget-amount-statistics ks-primary">
                            <div class="ks-statistics">
                                <span class="ks-amount" >{{ $doctorCount}}</span>
                                <span class="ks-text">Total Doctors</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="{{url("/patients")}}">

                    <div class="ks-dashboard-widget ks-widget-amount-statistics ks-success">
                        <div class="ks-statistics">
                            <span class="ks-amount" >{{ $patientCount }}</span>
                            <span class="ks-text">Total Paients</span>
                        </div>
                    </div>
                    </a>
                </div>





            </div>

                <div class="row">


                    <div class="col-xl-4">
                        <a href="{{url("/hotelguest")}}">

                        <div class="ks-dashboard-widget ks-widget-amount-statistics ks-danger">
                            <div class="ks-statistics">
                                <span class="ks-amount" >{{ $hotleGuestCount }}</span>
                                <span class="ks-text">Total HotelGuest </span>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{url("/products")}}">

                        <div class="ks-dashboard-widget ks-widget-amount-statistics ks-purple">
                            <div class="ks-statistics">
                                <span class="ks-amount" >{{ $productCount }}</span>
                                <span class="ks-text">Total Products</span>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{url("/orders")}}">

                        <div class="ks-dashboard-widget ks-widget-amount-statistics ks-yellow">
                            <div class="ks-statistics">
                                <span class="ks-amount" >{{ $orderCount }}</span>
                                <span class="ks-text">Total Orders</span>
                            </div>
                        </div>
                        </a>
                    </div>





                </div>

                <div class="row">
                    <div class="col-xl-12 ks-draggable-column ui-sortable">
                        <div id="ks-bar-chart-panel" class="card panel" data-dashboard-widget="">
                            <h5 class="card-header ui-sortable-handle">
                                Orders chart

                                <div class="ks-controls">
                                    <a href="#" class="ks-control" data-control-content-visible="" data-icon-visible="la la-minus" data-icon-hidden="la la-plus">
                                        <span class="ks-icon la la-minus" data-control-icon=""></span>
                                    </a>
                                    <a href="#" class="ks-control" data-control-refresh="">
                                        <span class="ks-icon la la-refresh" data-control-icon=""></span>
                                    </a>
                                    <a href="#" class="ks-control" data-control-fullscreen="">
                                        <span class="ks-icon la la-expand" data-control-icon=""></span>
                                    </a>
                                    <a href="#" class="ks-control" data-control-close="">
                                        <span class="ks-icon la la-close" data-control-icon=""></span>
                                    </a>
                                </div>
                            </h5>

                            <div class="card-block" data-widget-content="">
                                <div id="ks-bar-chart" data-height="260" style="height: 260px;">
                                    <div style="position: relative; width: 552px; height: 260px;">
                                        <div style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;">

                                            <svg width="552" height="260">

                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



        </div>
    </div>
@endsection
@push('customjs')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">

        var orders = <?php echo $data; ?>;
        console.log(orders);
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(orders);
            var options = {
                chart: {
                    title: 'Orders',
                    subtitle: 'Sales',
                    height: 400
                }

            };
            var chart = new google.charts.Bar(document.getElementById('ks-bar-chart'));
            chart.draw(data, options);
        }



    </script>
@endpush






















