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

@if(Auth::user()->isAdmin())
    @push('customjs')
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
