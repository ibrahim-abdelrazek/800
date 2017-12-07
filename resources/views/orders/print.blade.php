<html lang="{{ app()->getLocale() }}">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title>{{$AppName }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/line-awesome/css/line-awesome.min.css') }}">
    <!--<link rel="stylesheet" type="text/css" href="assets/fonts/open-sans/styles.css">-->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/montserrat/styles.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('libs/tether/css/tether.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jscrollpane/jquery.jscrollpane.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/common.min.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/widgets/payment.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/kosmo/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/widgets/panels.min.css') }}">
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/select2/css/select2.min.css') }}"> <!-- Original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/fancybox/jquery.fancybox.css') }}">
    <!-- Customization -->

    <!-- BEGIN THEME STYLES -->
    @guest
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/pages/auth.min.css') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/themes/primary.min.css') }}">

    @endguest

    <link class="ks-sidebar-dark-style" rel="stylesheet" type="text/css"
                  href="{{ asset('assets/styles/themes/sidebar-black.min.css') }}">
            <!-- END THEME STYLES -->
            @stack('customcss')
            <script>
                window.Laravel = { csrfToken: '{{ csrf_token() }}' };
            </script>
            @if(!auth()->guest())
                <script>
                    window.Laravel.userId = <?php echo auth()->user()->id; ?>
                </script>
            @endif
        <script>
            //request user permission for notification and messaging
            window.Notification.requestPermission();
        </script>

            <style>
                .required:after { content:" *"; color: #f31e1e;  font-weight: bold;  font-size: 16px;
                    position: absolute;}
            </style>
</head>

<body>
    <div class="ks-column ks-page">

<div id="printable" class="ks-page-content">
    <div class="ks-page-content-body ks-body-wrap">
        <div class="ks-body-wrap-container">
            <div class="container-fluid">
                <div class="ks-order-page ks-compact">
                    <div class="ks-info">
                        <div class="ks-header">

                        </div>
                        <div class="ks-body">
                            <div class="ks-column">
                                <h5>Billing</h5>
                                <span>{{$order->patient->first_name . " " . $order->patient->last_name}}</span>
                                <span>{{$order->patient->email}}</span>
                                <span>{{$order->patient->contact_number}}</span>
                            </div>
                            <div class="ks-column">
                                <h5>Doctor</h5>
                                <span>{{$order->doctor->first_name .' '.$order->doctor->last_name}}</span>
                                <span>{{$order->doctor->contact_email}}</span>
                                <span>{{$order->doctor->contact_number}}</span>
                            </div>
                        </div>
                        @php
                            $patient = $order->patient;
                            $address = explode(',',$patient->address);

                            $count = count($address) ;
                            if($count == 4){
                                $patient->villa_number = $address[0];
                                $patient->street =$address[1];

                            }elseif($count == 5) {
                                $patient->apartment_number = $address[0];
                                $patient->apartment_name = $address[1];
                                $patient->street =$address[2];
                            }else {
                                $patient->office_number = $address[0];
                                $patient->building_name = $address[1];
                                $patient->company_name = $address[2];
                                $patient->street =$address[3];

                            }
                        @endphp
                        <div class="ks-footer">
                            <div class="ks-column">
                                @if($patient->villa_number)
                                    <span>Villa : {{ $patient->villa_number }}</span>
                                @endif
                                @if($patient->apartment_number)

                                    <span> Apartment Number:{{ $patient->apartment_number }}</span>

                                @endif
                                @if($patient->apartment_name)
                                    <span> Apartment Name:{{ $patient->apartment_name }}</span>
                                @endif
                                @if($patient->office_number)
                                    <span> Office Number:{{ $patient->office_number }}</span>
                                @endif
                                @if($patient->building_name)
                                    <span> Building Name:{{ $patient->building_name }}</span>
                                @endif
                                @if($patient->company_name)
                                    <span> Company Name:{{ $patient->company_name }}</span>
                                @endif
                                <span> Street:{{ $patient->street }}</span>
                                <span> Area: {{ $order->patient->area->neighborhood_name  }}</span>
                                <span >City {{ $order->patient->city->city_name }}</span>


                            </div>
                            <div class="ks-column">
                                <h5>{{$order->partner }}</h5>

                            </div>
                        </div>
                    </div>
                    <div class="ks-details">
                        <h4>Order #18</h4>

                        <table class="ks-table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th class="ks-quantity">Quantity</th>
                                <th>Price</th>
                                <th class="ks-discounts"></th>
                                <th width="100" class="ks-unit-price">Unit Price</th>
                                <th width="100" class="ks-subtotal">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $sum= 0;
                            @endphp
                            @foreach($order->products as $key=>$value)
                                <tr>
                                    @php
                                        $product = App\Product::find($key);
                                        $sum += ($product->price * $value);
                                    @endphp
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->id}}</td>
                                    <td class="ks-quantity">{{$value}}</td>
                                    <td>{{getConfig('currency_code') . " " .$product->price * $value}}</td>
                                    <td class="ks-discounts">-</td>
                                    <td class="ks-unit-price">{{getConfig('currency_code') . " " .$product->price}}</td>
                                    <td class="ks-subtotal">{{getConfig('currency_code') . " " .$product->price * $value}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="ks-total">
                            <div class="ks-tracking-number">
                                <span class="ks-header">Notes</span>
                                <span class="ks-text">{{$order->notes}}</span>
                            </div>
                            <table>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>{{getConfig('currency_code') . " " .$sum}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>{{getConfig('currency_code') . " " . getConfig('shipping_cost', 'int')}}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td>{{getConfig('currency_code') . " " . getConfig('tax_cost', 'int')}}</td>
                                </tr>
                                <tr>
                                    <td class="ks-text-info">Total</td>
                                    <td class="ks-text-info">{{getConfig('currency_code') . " " . ($sum + getConfig('shipping_cost', 'int')+ getConfig('tax_cost', 'int')) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/responsejs/response.min.js') }}"></script>
<script src="{{ asset('libs/loading-overlay/loadingoverlay.min.js') }}"></script>
<script src="{{ asset('libs/tether/js/tether.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/jscrollpane/jquery.jscrollpane.min.js') }}"></script>
<script src="{{ asset('libs/jscrollpane/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('libs/flexibility/flexibility.js') }}"></script>
<script src="{{ asset('libs/noty/noty.min.js') }}"></script>
<script src="{{ asset('libs/velocity/velocity.min.js') }}"></script>
<script src="{{ asset('libs/fancybox/jquery.fancybox.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/scripts/common.min.js') }}"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

<div class="ks-mobile-overlay"></div>
<script>


</script>

</body>
</html>
