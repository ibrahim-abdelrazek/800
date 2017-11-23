@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Create new Order</h5>


                        {!! Form::open(array('route' => 'orders.store',
                        'files' => true)) !!}

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
                var fieldHTML = '<div class="form-group row"><div class="col-sm-3">' + productSelector + '</div><div class="col-sm-1 text-center"><span>X</span></div>';
                fieldHTML += '<div class="col-sm-3">'+quantitiesSelector+'</div><div class="col-sm-2"><a href="javascript:void(0);" style="padding-top:6px;" class=" remove_button btn btn-danger" title="Remove field"><span class="la la-minus-circle la-2x"></span> </a></div></div>'; //New input field html
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
    @push('customjs')
    @if(Auth::user()->isAdmin())

        <script type="application/javascript">
            // asynchronous content
            (function ($) {
                $(document).ready(function () {
                    loadDoctors($('select[name=partner_id]').val());
                    loadPatients($('select[name=partner_id]').val());
                    $('select[name=partner_id]').on('change', function(e){
                        var partner_id = $(this).val();
                        loadPatients(partner_id);
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
                                "new Patient</b></a></p>";
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
                            html = "<p>You don't have added doctors yet, Please <a href='{{route("doctors.index")}}'><b class='label-danger'>Add " +
                                "new doctor</b></a></p>";
                            $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                        }
                        $('#doctors-holder').html(html);

                    })
                }
            })(jQuery);

        </script>
         @endif

    @endpush

