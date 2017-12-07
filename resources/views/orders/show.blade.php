@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/stacktable/stacktable.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/payment/order.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/jquery-confirm/jquery.confirm.min.css') }}"> <!-- original -->

    <style>
        img { cursor: pointer;}
    </style>
@endpush

@section('content')
        <div class="ks-page-header">
            <section class="ks-title">
                <h3>Order #{{$order->id}}</h3>
            <a href="{{url('orders/print/'.$order->id)}}" class="printDiv btn btn-info pull-right"><i class="la la-print la-1x">Print Receipt</i></a>
            </section>
        </div>

        <div id="printable" class="ks-page-content">
            <div class="ks-page-content-body ks-body-wrap">
                <div class="ks-body-wrap-container">
                    <div class="container-fluid">
                        <div class="ks-order-page ks-compact">
                            <div class="ks-info">
                                <div class="ks-header">
                                    <h5>Prescription </h5>
                                        @if(!empty($order->prescription) && strpos(mime_content_type(base_path().'/public/'.$order->prescription), 'image') !== false)
                                            <img class="ks-logo" src="{{asset($order->prescription)}}" height="60">
                                        @elseif(!empty($order->prescription) && strpos(mime_content_type(base_path().'/public/'.$order->prescription), 'pdf') !== false)
                                            <a href="{{$order->prescription}}" target="_blank">
                                                <img src="/upload/pdf.png" style="width:75px; height:75px;">
                                            </a>
                                        @else
                                            <img src="/upload/doc.png" style="width:45px; height:45px;">
                                        @endif

                                    <h5>Insurance Claim</h5>

                                    @if(!empty($order->insurance_claim) && file_exists(base_path().'/public/'.$order->insurance_claim) && strpos(mime_content_type(base_path().'/public/'.$order->insurance_claim), 'image') !== false)
                                        <img class="ks-insurance" src="{{asset($order->insurance_claim)}}" height="60">
                                    @elseif(!empty($order->insurance_claim) && file_exists(base_path().'/public/'.$order->insurance_claim) && strpos(mime_content_type(base_path().'/public/'.$order->insurance_claim), 'pdf') !== false)
                                        <a href="{{$order->insurance_claim}}" target="_blank">
                                            <img src="/upload/pdf.png" style="width:75px; height:75px;">
                                        </a>
                                    @else
                                        <img src="/upload/doc.png" style="width:45px; height:45px;">
                                    @endif

                                    @php
                                        $color = '';
                                        switch($order->status->code){
                                         case 'success':
                                          $color = '#4caf50';
                                          break;
                                          case 'info':
                                          $color = '#42a5f5';
                                          break;
                                          case 'warning':
                                          $color = '#ffb300';
                                          case 'danger':
                                          $color = '#ef5350';
                                            break;
                                        }
                                    @endphp
                                    <span  style="background:{{$color}}" class="ks-status-paid"><span class="ks-icon la la-check"></span> {{$order->status->message}}</span>
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
                                        <span>{{$order->doctor->first_name .' ' . $order->doctor->last_name}}</span>
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

@endsection

@push('customjs')
    <script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>

    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.print.min.js') }}"></script>
<script type="text/javascript">
    (function($){
        $(document).ready(function () {
           $('.printDiv').on('click', function(e){
               $("#printable").printThis({
                   header: "<h3>{{$AppName}}</h3>",               // prefix to html
                   footer: "<h5>Copyrights Reserved {{$AppName . date('Y')}}",               // postfix to html
               });
           });

            $('.ks-logo').on('click', function () {
                $.dialog({
                    title: 'Prescription',
                    content: '<img src="' + $(this).attr('src') +'"> <br> <a id="download"  href="{{asset($order->prescription)}}" class="btn btn-xs btn-default pull-right" download="{{asset($order->prescription)}}">Download</a><div class="clearfix"></div>',
                    animation: 'zoom',
                    columnClass: 'medium',
                    closeAnimation: 'scale',
                    backgroundDismiss: true
                });
            });
            $('.ks-insurance').on('click', function () {
                $.dialog({
                    title: 'Insurance Claim',
                    content: '<img src="' + $(this).attr('src') +'"> <br> <a id="download" href="{{asset($order->insurance_claim)}}" class="btn btn-xs btn-default pull-right" download="{{asset($order->insurance_claim)}}">Download</a><div class="clearfix"></div>',
                    animation: 'zoom',
                    columnClass: 'medium',
                    closeAnimation: 'scale',
                    backgroundDismiss: true
                });
            });


        });


    })(jQuery);

</script>
@endpush
