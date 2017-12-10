@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Update Order #{{$order->id}}</h5>
                    {!! Form::model($order, ['route' => ['orders.update', $order->id], 'method' => 'patch','files' =>true]) !!}

                    @include('orders.fields')

                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div>
@endsection

@push('customjs')
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                var addButton = $('.add_button'); //Add button selector
                var wrapper = $('#products_wrapper'); //Input field wrapper
                var productSelector = '{!! form :: select ('products[]',App\Product::pluck('name','id'),null,['class' => 'form-control'])!!}';
                var quantitiesSelector = '{!! Form::text('quantities[]', null, [  'placeholder'=>'Enter Product\'s quantity', 'class' => 'form-control']) !!}';
                @php
                    $cop[-1] = 'Select Co-Payments';
                @endphp
                @for($i = 0; $i <= 35; $i=$i+5)
                @php $cop[$i] = $i; @endphp
                @endfor
                var copaymentsSelector = '{!! Form::select('copayments[]', $cop, null, ['class' => 'select2 form-control']) !!}';
                var fieldHTML = '<div class="form-group row"><div class="col-sm-3">' + productSelector + '</div><div class="col-sm-1 text-center"><span>X</span></div>';
                fieldHTML += '<div class="col-sm-3">'+quantitiesSelector+'</div><div class="col-sm-3">'+copaymentsSelector+'</div><div class="col-sm-2"><a href="javascript:void(0);" style="padding-top:6px;" class=" remove_button btn btn-danger" title="Remove field"><span class="la la-minus-circle la-2x"></span> </a></div></div>'; //New input field html
                $(addButton).click(function(){ //Once add button is clicked
                    $(wrapper).append(fieldHTML); // Add field html
                });
                $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
                    e.preventDefault();
                    $(this).parent().parent().remove(); //Remove field html
                });

            });

        })(jQuery);
    </script>
@endpush

@if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
    @push('customjs')
        <script type="application/javascript">
            // asynchronous content
            (function ($) {
                $(document).ready(function () {
                    $('label[for="prescription"]').removeClass('required');
                    $('label[for="insurance_claim"]').removeClass('required');



                    loadDoctors($('select[name=partner_id]').val());
                    //loadPatients($('select[name=partner_id]').val());
                    $('select[name=partner_id]').on('change', function(e){
                        var partner_id = $(this).val();
                       // loadPatients(partner_id);
                        loadDoctors(partner_id);
                    });
                });
                function loadPatients(partner_id)
                {
                    $.getJSON("{{url('/doctors/get-patients')}}/" + partner_id, [], function (data) {
                        var html = '';
                        if(data.success){
                            html = '<select class="form-control ks-select" name="patient_id">';
                            $.each(data.data , function (key, value) {
                                html += '<option value="'+key+'">'+value+'</option>';
                            });
                            html += '</select>';
                            $('input[type=submit]').prop('disabled', function(i, v) { return false; });
                        }else{
                            html = "<p>You don't have added patients yet, Please <a href='{{route("patients.index")}}'><b class='label-danger'>Add " +
                                "new Nurse</b></a></p>";
                            $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                        }
                        $('#patients-holder').html(html);

                    })
                }
                function loadDoctors(partner_id)
                {
                    $.getJSON("{{url('/doctors/get-doctors')}}/" + partner_id, [], function (data) {
                        var html = '';
                        if(data.success){
                            html = '<select class="form-control ks-select" name="doctor_id">';
                            $.each(data.data , function (key, value) {
                                html += '<option value="'+key+'">'+value+'</option>';
                            });
                            html += '</select>';
                            $('input[type=submit]').prop('disabled', function(i, v) { return false; });
                        }else{
                            html = "<p>You don't have added doctors yet, Please <a href='{{route("nurses.index")}}'><b class='label-danger'>Add " +
                                "new doctor</b></a></p>";
                            $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                        }
                        $('#doctors-holder').html(html);

                    })
                }
            })(jQuery);

        </script>
    @endpush
@endif