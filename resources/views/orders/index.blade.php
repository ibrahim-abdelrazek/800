@extends('layouts.app')
@push('customcss')

    <link rel="stylesheet" type="text/css"
          href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/styles/libs/jquery-confirm/jquery.confirm.min.css') }}"> <!-- original -->
    <!-- customization -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/sweetalert/sweetalert.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/styles/libs/sweetalert/sweetalert.min.css')}}"> <!-- customization -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/styles/libs/bootstrap-notify/bootstrap-notify.min.css') }}"> <!-- customization -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/prism/prism.css')}}"> <!-- original -->

    <link href="http://800pharmacy.1001dubaipanel.com/Content/dataTables/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="http://800pharmacy.1001dubaipanel.com/Content/dataTables/css/responsive.dataTables.min.css" rel="stylesheet" />

    <link href="http://800pharmacy.1001dubaipanel.com//Content/select2/css/select2.min.css" rel="stylesheet">
    <link href="http://800pharmacy.1001dubaipanel.com//Content/select2/css/select2-bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/bootstrap-notify/bootstrap-notify.min.css')}}"> <!-- customization -->
    <style>
       .dropdown-item{ width:100%;}
       .ks-navbar-actions{position:absolute; right:0;}
        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
            pointer-events: none;
        }

        . {
            /* To center vertically */
            display: table-cell;
            vertical-align: middle;
            pointer-events: none;
        }

        .modal-content {
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
            pointer-events: all;
        }

        .loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url({{asset('assets/img/loaders/svg-loaders/three-dots.svg')}}) 50% 50% no-repeat;
            background-color: rgb(0, 0, 0);
            opacity: 0.3;
        }

        .table tr {
            cursor: pointer;
        }

        .alignRight {
            text-align: right;
        }

        .banned {
            background-color: red !important;
            color: white !important;
        }

        .m-n-t-10 {
            margin-top: -10px;
        }

        .cancel-item {
            font-style: italic;
            text-decoration: line-through;
            text-decoration-color: red;
            opacity: 0.5;
        }

        .datatable_datepicker {
            padding: 2px;
            border-radius: 0;
            border: 1px solid #707070;
        }

        .textbox_danger {
            background-color: #d9534f !important;
            color: white !important;
        }

        .textbox_service_order {
            background-color: #363636 !important;
            color: white !important;
        }

        .textbox_stamp_order {
            background-color: #006eee !important;
            color: white !important;
        }
    </style>
@endpush
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Orders</h3>

            <a href="{{ route('orders.create') }} " class="pull-right btn btn-default create"> Create new order </a>

        </section>
    </div>
    <div class="ks-page-content">
        
        <div class="ks-page-content-body">
            <div class="container-fluid">
                <div class="loading"></div>
                <!-- Tables -->
                <div class="row" style="padding-left: 3px; padding-right: 3px;">
                    <!-- New Order Table -->
                   
                    <div class="col-md-4 col-sm-12 col-lg-4" style="padding-left: 3px; padding-right: 3px;">
                        <div class="card panel panel-primary block-default" >
                            <h5 class="card-header">New Order List</h5>

                            <div class="card-block" style="height: 400px;max-height: 400px;overflow: auto; padding: 5px;width: 100%; overflow-x: hidden;">
                                    <table id="table-new-order" class="table table-striped table-hover dt-responsive"
                                           cellspacing="0" width="100%">
                                        <thead style="background-color: #52B3D9;">
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Address</th>
                                            <th>Time Ago</th>
                                            <th>Total</th>
                                            <th>Partner</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <!-- Order Confirmed -->
                    <div class="col-md-4 col-sm-12 col-lg-4" style="padding-left: 3px; padding-right: 3px;">
                        <div class="card panel panel-magenta block-default" >
                            <h5 class="card-header">Orders Confirmed List</h5>
                            <div class="card-block" style="height: 400px;max-height: 400px;overflow: auto; padding: 5px;width: 100%; overflow-x: hidden;">
                                    <table id="table-confirmed-order" class="table table-striped table-hover dt-responsive"
                                           cellspacing="0" width="100%">
                                        <thead style="background-color: #D149D0;">
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Address</th>
                                            <th>Time Ago</th>
                                            <th>Total</th>
                                            <th>Partner</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <!-- Order Under Process List -->
                    <div class="col-md-4 col-sm-12 col-lg-4" style="padding-left: 3px; padding-right: 3px;">
                        <div class="card panel panel-warning block-default" >
                            <h5 class="card-header">Orders Under Process List</h5>
                            <div class="card-block" style="height: 400px;max-height: 400px;overflow: auto; padding: 5px;width: 100%; overflow-x: hidden;">
                                    <table id="table-in-process-order" class="table table-striped table-hover dt-responsive"
                                           cellspacing="0" width="100%">
                                        <thead style="background-color: #F7CA18;">
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Address</th>
                                            <th>Time Ago</th>
                                            <th>Total</th>
                                            <th>Partner</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                <div class="row" style="padding-left: 3px; padding-right: 3px;">
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="card panel panel-warning block-default" >
                            <h5 class="card-header">
                                <span class="ks-text">Dispatched Order List</span>
                            </h5>
                            <div class="card-block" style="height: 400px;max-height: 400px;overflow: auto; padding: 10px;width: 100%; overflow-x: hidden;">

                                <table id="table-dispatched-order" class="table table-striped table-hover dt-responsive"
                                       cellspacing="0" width="100%">
                                    <thead style="background-color: #F7CA18;">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Address</th>
                                        <th>Time Ago</th>
                                        <th>Total</th>
                                        <th>Partner</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="card panel panel-green block-default" >
                            <h5 class="card-header">
                                <span class="ks-text">Delivered Order List</span>
                            </h5>
                            <div class="card-block" style="height: 400px;max-height: 400px;overflow: auto; padding: 10px;width: 100%; overflow-x: hidden;">

                                <table id="table-delivered-order" class="table table-striped table-hover dt-responsive"
                                       cellspacing="0" width="100%">
                                    <thead style="background-color: #98ff98;">
                                    <tr>
                                        <th class="col-xs-2">Name</th>
                                        <th class="col-xs-4">Address</th>
                                        <th class="col-xs-3">Delivered Date</th>
                                        <th class="col-xs-3">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                </div>

                <div class="row" style="padding-left: 3px; padding-right: 3px;">
                    <div class="card panel panel-red block-default" >
                        <h5 class="card-header">
                            <span class="ks-text">Cancelled Order List</span>
                        </h5>
                    <div class="card-block" style="height: 400px;max-height: 400px;overflow: auto;padding: 10px;width: 100%; overflow-x: hidden;">
                        <table id="table-canceled-order" class="table table-striped table-hover dt-responsive"
                                   cellspacing="0" width="100%">
                            <thead style="background-color: #EF535099;">
                            <tr>
                                <th class="col-xs-2">Name</th>
                                <th class="col-xs-4">Address</th>
                                <th class="col-xs-3">Cancelled Date</th>
                                <th class="col-xs-3">Total</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Modals -->
    <div id="myModal" class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-close"></span>
                </button>
                <h4 class="modal-title" id="order-detail-modal-title">Order</h4>
                
            </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Order Time: <span id="order-created-date"></span></label>
                                            </div>
                                            <div class="form-group m-n-t-10" id="status-date-label" hidden="hidden">
                                                <label><span id="status-type"></span> Time: <span
                                                            id="order-status-date"></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div class="form-group" id="order-note-div">
                                                <label for="order-note">Note from the Customer</label>
                                                <input type="text" id="order-note" class="form-control textbox_danger"
                                                       disabled="disabled"/>
                                            </div>

                                            <a href="#" class="btn btn-warning btn-outline bold"
                                               id="button_order_detail_image">View Prescription Order</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 m-n-t-10">
                                            <div class="form-group" hidden="hidden">
                                                <input type="password" id="order-objectid" class="form-control"/>
                                                <input type="password" id="order-userid" class="form-control"/>
                                                <input type="password" id="order_detail_drop_off_total"
                                                       class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="order-name">First Name</label>
                                                <input disabled type="text" id="order-name" class="form-control"/>

                                                <label for="order-surname">Last Name</label>
                                                <input disabled type="text" id="order-surname" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="order-mobile">Mobile</label>
                                                <input disabled type="text" id="order-mobile" class="form-control"/>
                                            </div>
                                            
                                        
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <hr/>
                                            <div style="width:100%;">
                                                <h5 style="text-align: center;">Order Details</h5>
                                            </div>
                                            <table id="table-order-detail"
                                                   class="table table-responsive table-striped table-hover"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="hidden-xs hidden-sm">Picture</th>
                                                    <th>Product</th>
                                                    <th class="hidden-xs hidden-sm hidden-md">Description</th>
                                                    <th class="hidden-xs hidden-sm hidden-md">Price per Unit</th>
                                                    <th class="hidden-xs">Quantity</th>
                                                    <th style="text-align:right" class="hidden-xs hidden-sm">Sum</th>
                                                    <th style="text-align:right" class="hidden-xs hidden-sm">Discount
                                                    </th>
                                                    <th style="text-align:right" class="hidden-xs">Total</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                <tr style="color:black">
                                                    <td></td>
                                                    <td class="hidden-xs hidden-sm"></td>
                                                    <td></td>
                                                    <td class="hidden-xs hidden-sm hidden-md"></td>
                                                    <td class="hidden-xs hidden-sm hidden-md"></td>
                                                    <td style="text-align:right" class="hidden-xs"><b>Total :</b></td>
                                                    <td style="text-align:right" class="hidden-xs hidden-sm"><b>
                                                            <div id="total-normal-price"></div>
                                                        </b></td>
                                                    <td style="text-align:right"
                                                        class="text-danger hidden-xs hidden-sm"><b>
                                                            <div id="total-discount-price"></div>
                                                        </b></td>
                                                    <td style="text-align:right" class="hidden-xs"><b>
                                                            <div id="total-price"></div>
                                                        </b></td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <br/>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div style="margin-top:20px">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-success btn-outline bold"
                                               id="button_update_order">Edit Order</a>
                                            <a href="#" class="btn btn-default bold" id="button_order_detail_add"
                                               hidden="hidden">Add Product</a>
                                            <a href="#" class="btn btn-primary bold" id="button_user_detail"
                                               hidden="hidden">View User Details</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-primary bold" target="_blank" id="button_print_order"><i class="md md-print"></i>&nbsp;Print Order</a>
                                            
                                            <div class="btn-group">
                                     <button class="status-holder btn btn-block" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               <span class="badge ks-circle badge-default">Order Confirmed</span>
                                            </button>
                                            @php 
                                            $statuses = App\Status::all();
                                            @endphp
                                            
                                            @if($statuses->count() > 0)
                                         <div class="dropdown-menu">
                                            @foreach($statuses as $status)
                                                <a id="change-status" data-id="{{ $status->id}}"  data-code="{{$status->code}}" data-message="{{$status->message}}" class="badge ks-circle badge-{{$status->code}} dropdown-item" href="#">{{$status->message}}</a>
                                            @endforeach
                                               
                                            </div>
                                            @endif
                                        </div>
                                        
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
    <!-- Cancel Confirm Modal -->
        <div id="cancel_confirm_model"  class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm ">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title">Order Cancel</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure cancel this order ?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-outline bold" id="button_cancel_order_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_cancel_order_cancel"
                           data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Update Confirm Modal -->
    <div id="update_confirm_model" class="modal  bs-example-modal-sm">
            <div class="modal-dialog modal-sm ">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title">Order Update</h4>
                    </div>
                    <div class="modal-body">
                        <br/>
                        <br/>
                        <h4>Did you call the customer?</h4>
                        <br/>
                        <br/>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-success btn-outline bold"
                           id="button_update_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_update_cancel"
                           data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
            
        </div>
    </div>
    <!-- Update Status -->
    <div id="update_status_confirm_model" class="modal  bs-example-modal-sm">
            <div class="modal-dialog modal-sm ">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title">Order Status Update</h4>
                    </div>
                    <div class="modal-body">
                        <br/>
                        <br/>
                        <h4>Did you call the customer?</h4>
                        <br/>
                        <br/>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-success btn-outline bold" id="button_update_status_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_update_status_cancel"
                           data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Update detail -->
    <div id="update_detail_confirm_model" class="modal  bs-example-modal-sm" style="z-index:9999">
            <div class="modal-dialog modal-sm ">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title">Order Update</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure update this order?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-success btn-outline bold" id="button_update_detail_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_update_detail_cancel"
                           data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Update Order Status Modal -->
    <div id="update_order_status_confirm_model" class="modal  bs-example-modal-sm">
            <div class="modal-dialog modal-sm ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Order Status Update</h4>
                    </div>
                    <div class="modal-body">
                        <div id="normalWarningTextForOrderStatusChange">
                            <p>Are you sure to update the status of this order ?</p>
                        </div>
                        <div id="specialWarningTextForOrderStatusChange">
                            <p><strong>Warning:</strong> Unchecked items in the list will be made out of stock.</p>
                            <p>If all items are unchecked - order will be cancelled. Please double check. </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-success btn-outline bold" id="button_status_update_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Update Order Status Confirm Modal -->
    <div id="update_order_status_confirm_with_drop_off_model" class="modal  bs-example-modal-md">
            <div class="modal-dialog modal-md ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Order Status Update</h4>
                    </div>
                    <div class="modal-body">
                        <div id="normalWarningTextForOrderStatusChange">
                            <p>Are you sure to update the status of this order ?</p>
                        </div>
                        <div id="specialWarningTextForOrderStatusChange">
                            <p><strong>Warning:</strong> Unchecked items in the list will be made out of stock.</p>
                            <p>If all items are unchecked - order will be cancelled. Please double check. </p>
                        </div>
                        <div class="form-group" id="order-docket-number-div">
                            <table class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead style="background-color: #e1b9dd;">
                                <tr>
                                    <th style="color:white;">Docket</th>
                                    <th style="color:white;">Price</th>
                                    <th style="color:white;">Service</th>
                                    <th style="color:white;" width="1%">Delete</th>
                                </tr>
                                </thead>
                                <tbody id="service_order_detail_table_body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-success btn-outline bold" id="button_status_update_confirm_with_drop_off">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>

    <div id="service_order_add_detail_modal" class="modal  bs-example-modal-sm">
            <div class="modal-dialog modal-sm ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add Service Order Detail</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" id="order-docket-number-div">
                            <div>
                                <label for="order-docket-number">Docket Number</label>
                                <input type="text" id="order-docket-number" class="form-control" />
                            </div>
                            <div>
                                <label for="service-order-initial-price">Service Order Price</label>
                                <input type="number" id="service-order-initial-price" class="form-control" step="0.01" min="0.01" />
                            </div>
                            <div class="form-group">
                                <label for="service-order-service-name">Service Name</label>
                                <select class="form-control select2" id="service-order-service-name" style="width: 100%">
                                    <option value="Dry Cleaning" selected="selected">Dry Cleaning</option>
                                    <option value="Press">Press</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-success btn-outline bold" id="button_order_add_service_detail">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                
            </div>
        </div>
    </div>

    <div id="cancel_detail_confirm_model" class="modal  bs-example-modal-sm" style="z-index:9999">
            <div class="modal-dialog modal-sm ">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Cancel Update</h4>
                    </div>
                    <div class="modal-body">
                        <br />
                        <br />
                        <h4>Are you sure to cancel this order detail item?</h4>
                        <br />
                        <br />
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-success btn-outline bold" id="button_cancel_detail_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_cancel_detail_cancel" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>

    <div id="orderDetailEditModal" class="modal  bs-example-modal-lg">
            <div class="modal-dialog modal-lg ">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Order Detail Edit <label style="color:red;" id="order-detail-cancel"> 	&nbsp;	&nbsp;(Canceled)</label></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img id="order-detail-image" class="img-responsive" src="" alt="photo">
                            </div>
                            <div class="col-md-3">
                                <label for="order-detail-product">Product</label>
                                <input type="text" disabled="disabled" id="order-detail-product" class="form-control" />
                                <div hidden="hidden"><input type="text" id="order-detail-product-id" class="form-control" /></div>
                                <div hidden="hidden"><input type="text" id="order-detail-promotion-id" class="form-control" /></div>
                            </div>
                            <div class="col-md-3">
                                <label for="order-detail-quantity">Quantity</label>
                                <input type="number" id="order-detail-quantity" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" min="0" />
                                <div hidden="hidden"><input type="number" id="order-detail-original-quantity" class="form-control" /></div>
                            </div>
                            <div class="col-md-3">
                                <label for="order-detail-price-per-item">Price Per Item</label>
                                <input disabled type="number" id="order-detail-price-per-item" class="form-control" step="0.01" min="0" />
                                <div hidden="hidden"><input type="number" id="order-detail-original-price-per-item" class="form-control" /></div>
                            </div>
                            <div class="col-md-3 col-md-offset-6" id="div-order-detail-discount">
                                <br />
                                <label for="order-detail-price">Discount</label>
                                <input type="number" id="order-detail-discount" class="form-control" disabled min="0" />
                                <div hidden="hidden"><input type="number" id="order-detail-original-discount" class="form-control" /></div>
                            </div>
                            <div class="col-md-3 col-md-offset-6">
                                <br />
                                <label for="order-detail-price">Total</label>
                                <input type="number" id="order-detail-price" class="form-control" disabled onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" min="0" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--<a href="#" class="btn btn-success btn-outline bold" id="button_update_order_detail">Update Order Detail</a>--}}
                        <a href="#" class="btn btn-danger btn-outline bold" id="button_cancel_order_detail" hidden="hidden">Cancel Product</a>
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_close_order_detail_modal" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>

    <div id="userDetailModal" class="modal  bs-example-modal-lg">
            <div class="modal-dialog modal-lg ">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">User Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user-insuramce-provider">Insurance Provider</label>
                                    <input type="text" id="user-insuramce-provider" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label for="user-expiry-date">Expiry Date</label>
                                    <input type="text" id="user-expiry-date" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label for="user-emirates-id">Emirates ID</label>
                                    <input type="text" id="user-emirates-id" class="form-control" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user-expiry-date">Insurance Card</label>
                                    <img id="user-detail-image1" class="img-responsive">
                                </div>
                                <div class="form-group">
                                    <label for="user-expiry-date">User Card</label>
                                    <img id="user-detail-image2" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_cancel_user_detail" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
            </div>
    </div>

    <div id="modal_report_param" class="modal  bs-example-modal-sm">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delivered Order Report</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="col-sm-8 form-control" id="delivered_report_name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Addres</label>
                                <div class="col-sm-8">
                                    <input type="text" class="col-sm-8 form-control" id="delivered_report_address" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Price</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="delivered_report_price_min" placeholder="Min">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="delivered_report_price_max" placeholder="Max">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-4">
                                    <input type="text" class="datepicker form-control" id="delivered_report_date_min" placeholder="Start">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="datepicker form-control" id="delivered_report_date_max" placeholder="End">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-outline bold" id="button_delivered_print_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>

    <div id="modal_service_report_param" class="modal fade bs-example-modal-sm">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delivered Service Order Report</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="col-sm-8 form-control" id="delivered_service_report_name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Price</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="delivered_service_report_price_min" placeholder="Min">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="delivered_service_report_price_max" placeholder="Max">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-4">
                                    <input type="text" class="datepicker form-control" id="delivered_service_report_date_min" placeholder="Start">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="datepicker form-control" id="delivered_service_report_date_max" placeholder="End">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-outline bold" id="button_delivered_service_print_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
        </div>
    </div>

    <div id="userInsuranceCardImageModal" class="modal  bs-example-modal-lg">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">User Insurance Card Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12 text-center">
                            <div hidden="hidden"><input type="text" id="detailImage-id" class="form-control" /></div>
                            <img id="userInsuranceCardImage" style="max-width: 100%" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default btn-outline bold" id="userInsuranceCardImageRotateLeftButton"><i class="la la-rotate-left"></i></a>
                        <a href="#" class="btn btn-default btn-outline bold" id="userInsuranceCardImageRotateRightButton"><i class="la la-rotate-right"></i></a>
                        <a href="#" class="btn btn-default btn-outline bold" id="userInsuranceCardImageCancelButton" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
            </div>
    </div>

    <div id="userIDCardImageModal" class="modal  bs-example-modal-lg">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">User Card Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12 text-center">
                            <div hidden="hidden"><input type="text" id="detailImage-id" class="form-control" /></div>
                            <img id="userIDCardImage" style="max-width: 100%" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default btn-outline bold" id="userIDCardImageCancelButton" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
            </div>
    </div>

    <div id="orderImageModal" class="modal  bs-example-modal-lg">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Order Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12 text-center" id="order-image-modal-div">
                            <div hidden="hidden"><input type="text" id="detailImage-id" class="form-control" /></div>
                            <img id="detailImage" style="max-width: 100%" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default btn-outline bold pull-left" id="orderImageModalPrint"><i class="md md-print"></i>&nbsp;Print Prescription</a>
                        <a href="#" class="btn btn-default btn-outline bold" id="orderImageModalRotateLeftButton"><i class="la la-rotate-left"></i></a>
                        <a href="#" class="btn btn-default btn-outline bold" id="orderImageModalRotateRightButton"><i class="la la-rotate-right"></i></a>
                        <a href="#" class="btn btn-success btn-outline bold" id="orderImageModalUpdateButton">Save</a>
                        <a href="#" class="btn btn-default btn-outline bold" id="orderImageModalCancelButton" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
            </div>
    </div>
     <div id="orderProductAdd" class="modal fade">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-md vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Order Detail Add</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="order-product-add-product">Product</label>
                            <select class="select2 form-control" id="order-product-add-product" name="order-product-add-product" placeholder="Select Product" style="width: 100%;">
                                @php $products = App\Product::all(); @endphp
                                @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
</select>
                        </div>
                        <div class="form-group">
                            <label for="order-product-add-quantity">Quantity</label>
                            <input type="number" id="order-product-add-quantity" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" min="0" />
                        </div>

                            <div class="form-group">
                                <label for="order-insure-rate">Co-Payment %</label>
                                <select class="form-control select2" id="order-insure-rate" style="width: 100%">
                                    <option value="-1" selected="selected">No Insure</option>
                                    <option value="0">% 0</option>
                                    <option value="5">% 5</option>
                                    <option value="10">% 10</option>
                                    <option value="15">% 15</option>
                                    <option value="20">% 20</option>
                                    <option value="25">% 25</option>
                                    <option value="30">% 30</option>
                                    <option value="35">% 35</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-outline bold" id="button-order-product-add-confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" data-dismiss="modal" aria-hidden="true">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="add_product_confirm_model" class="modal fade bs-example-modal-sm">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-sm vertical-align-center">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Order Detail Add Product</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure add this product ?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-outline bold" id="button_add_product_confirm">Confirm</a>
                        <a href="#" class="btn btn-default  btn-outline bold" id="button_add_product_cancel" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('libs/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('libs/prism/prism.js') }}"></script>
    <script src="http://800pharmacy.1001dubaipanel.com/Content/dataTables/datatables.min.js"></script>
    <script src="http://800pharmacy.1001dubaipanel.com/Content/dataTables/js/dataTables.bootstrap.min.js"></script>
    <script src="http://800pharmacy.1001dubaipanel.com/Content/dataTables/js/responsive.bootstrap.min.js"></script>
    <script src="http://800pharmacy.1001dubaipanel.com/Content/dataTables/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="http://800pharmacy.1001dubaipanel.com/Content/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('libs/howl/howler.min.js') }}"></script>
    <script src="http://800pharmacy.1001dubaipanel.com/Content/rotate/jquery.rotate.1-1.js"></script>
        <script src="{{ asset('libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script src="{{asset('js/order.js')}}"></script>


    <script type="text/javascript">
        $('a#change-status').click(function (e) {
            e.preventDefault();
            /*your_code_here;*/
            var stat = $(this).data('id');
            var order = $(this).data('order-id');
            var holder = $(this).parent().parent().find('.status-holder');
            var statCode = $(this).data('code');
            var statMessage = $(this).data('message')

            if ($(this).data('code').indexOf('danger') > -1) {

                swal({
                    title: "Cancel Order",
                    text: "Write reason for canceling order #" + $(this).data('order-id'),
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    inputPlaceholder: "Write a reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if ($.trim(inputValue) == "" || inputValue.length <= 5) {
                        swal.showInputError("You need to write something!");
                        return false;
                    } else {
                        var data = {
                            order: order,
                            status: stat,
                            notes: inputValue
                        };
                        $.ajax({
                            url: "{{url('/orders/update-status')}}",
                            type: "post",
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function (json) {
                                if (json.success) {
                                    swal(json.message);
                                    holder.removeClass();
                                    holder.addClass('status-holder btn btn-' + statCode + ' btn-block dropdown-toggle');
                                    holder.html('<span class="badge ks-circle badge-' + statCode + '">' + statMessage + '</span>');

                                } else {
                                    swal(json.message);
                                }
                            }
                        });
                    }
                });

            } else {
                var data = {
                    order: order,
                    status: stat
                };
                $.ajax({
                    url: "{{url('/orders/update-status')}}",
                    type: "post",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (json) {
                        if (json.success) {
                            $.notify({
                                title: 'Order Status Changed!',
                                message: json.message
                            }, {
                                type: 'success-active'
                            });
                            holder.removeClass();
                            holder.addClass('status-holder btn btn-' + statCode + ' btn-block dropdown-toggle');
                            holder.html('<span class="badge ks-circle badge-' + statCode + '">' + statMessage + '</span>');
                            window.location.reload();
                        } else {
                            $.notify({
                                title: 'Failed to change!',
                                message: json.message
                            }, {
                                type: 'danger-active'
                            });
                        }
                    }
                });

            }

            return true;
        });

    </script>
    <script src="http://800pharmacy.1001dubaipanel.com/Content/Template/js/plugins.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.modal').on('hidden.bs.modal', function () {
                if ($('.modal').hasClass('in') && !$('body').hasClass('modal-open')) {
                    $('body').addClass('modal-open');
                    
                }
            });
        });

function stopPropagation(evt) {
    if (evt.stopPropagation !== undefined) {
        evt.preventDefault();
        evt.stopPropagation();
    } else {
        evt.cancelBubble = true;
    }
}


    </script>
@endpush
