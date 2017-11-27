<body>
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
                                <h5>{{$order->partner->first_name . ' ' . $order->partner->last_name }}</h5>
                                <span>{{$order->partner->location}}</span>

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
</body>

