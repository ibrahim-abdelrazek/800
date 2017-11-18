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
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/select2/css/select2.min.css')}}"> <!-- Original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/select2/select2.min.css')}}"> <!-- Customization -->

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
                    @include('orders.table')
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