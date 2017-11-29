@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/jquery-confirm/jquery.confirm.min.css') }}"> <!-- original -->
    <!-- customization -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- customization -->

    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/media/css/dataTables.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/extensions/buttons/css/buttons.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/datatables-net/datatables.min.css')}}"> <!-- customization -->
<link rel="stylesheet" type="text/css" href="{{ asset('libs/sweetalert/sweetalert.css')}}"> <!-- original -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/sweetalert/sweetalert.min.css')}}"> <!-- customization -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/bootstrap-notify/bootstrap-notify.min.css') }}"> <!-- customization 
<link rel="stylesheet" type="text/css" href="{{ asset('libs/prism/prism.css')}}"> <!-- original -->
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
                                            @php 
                                            $statuses = App\Status::all();
                                            $i=0;
                                            @endphp
             <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    @foreach($statuses as $status)
                    <li class="nav-item">
                        <a class="nav-link @if($i==0) active @endif" href="#" data-toggle="tab" data-target="#list{{$status->id}}">
                            {{$status->message}}
                            @if(Auth::user()->isAdmin())
                            <span class="badge badge-{{$status->code}} badge-pill">{{ App\Order::where('status_id', $status->id)->count()}}</span>
                            @elseif(Auth::user()->isPartner())
                            <span class="badge badge-info badge-pill">{{ App\Order::where('partner_id', Auth::user()->id)->where('status_id', $status->id)->count()}}</span>
                            @endif
                            
                        </a>
                    </li>
                    @php $i++; @endphp
                    @endforeach
                    
                </ul>
                 <div class="tab-content">
                     @php $j = 0; @endphp
                    @foreach($statuses as $status)
                    <div class="tab-pane ks-column-section @if($j==0) active @endif" id="list{{$status->id}}" role="tabpanel">
                     <!-- Content Here --> 
                        @include('orders.table', ['status_id'=>$status->id])
                     </div>
                        @php $j++; @endphp
                    @endforeach
                      </div>
                  </div>
        </div>
    </div>

@endsection

@push('customjs')
    <script src="{{ asset('libs/datatables-net/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/media/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/extensions/buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('libs/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('libs/prism/prism.js') }}"></script>
   
   <script type="application/javascript">
        (function ($) {
            $(document).ready(function () {
                var table = $('.orders-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        },
                        {
                            extend : 'excelHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5]
                            }
                        }

                    ],
                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });

                table.buttons().container().appendTo('.orders-datatable_wrapper .col-md-6:eq(0)');
            });
        })(jQuery);
    </script>
    <script type="text/javascript">
        $('a#change-status').click( function(e) {
            e.preventDefault(); /*your_code_here;*/ 
            var stat = $(this).data('id');
            var order = $(this).data('order-id');
            var holder = $(this).parent().parent().find('.status-holder');
            var statCode =  $(this).data('code');
            var statMessage = $(this).data('message')
           
            if($(this).data('code').indexOf('danger') > -1){
                 
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
              if ($.trim(inputValue) == "" || inputValue.length <= 5 ) {
                swal.showInputError("You need to write something!");
                return false;
              }else{
                  var data = {
                          order: order,
                          status: stat,
                          notes: inputValue
                        };
                        $.ajax({
                            url:"{{url('/orders/update-status')}}" ,
                            type: "post",
                            data: data,
                            headers: {
                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                            dataType: 'json',
                            success: function(json){
                                if(json.success){
                                swal(json.message);
                                 holder.removeClass();
                                holder.addClass('status-holder btn btn-'+ statCode + ' btn-block dropdown-toggle');
                                holder.html('<span class="badge ks-circle badge-'+ statCode +'">'+ statMessage +'</span>');
                                    window.location.reload();

                            }else{
                                swal(json.message);
                            }
                        }
                    });
              }
            });
            
            }else{
                 var data = {
                          order: order,
                          status: stat
                        };
                        $.ajax({
                            url:"{{url('/orders/update-status')}}" ,
                            type: "post",
                            data: data,
                            headers: {
                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                            dataType: 'json',
                            success: function(json){
                                if(json.success){
                                    $.notify({
                                	title: 'Order Status Changed!',
                                	message: json.message
                                },{
                                	type: 'success-active'
                                });
                                  holder.removeClass();
                                  holder.addClass('status-holder btn btn-'+ statCode + ' btn-block dropdown-toggle');
                                  holder.html('<span class="badge ks-circle badge-'+ statCode +'">'+ statMessage +'</span>');
                                 window.location.reload();
                                  table.rows().invalidate().draw();
                                }else{
                                    $.notify({
                                	title: 'Failed to change!',
                                	message: json.message
                                },{
                                	type: 'danger-active'
                                });
                                }
                            }
                        });
          
            }
            
            return true;
        });
        
    </script>
@endpush
