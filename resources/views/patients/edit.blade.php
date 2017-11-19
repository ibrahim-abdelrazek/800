@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/jquery-confirm/jquery.confirm.min.css') }}"> <!-- original -->
    <!-- customization -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- customization -->
@endpush

@section('content')

    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Edit Patient </h3>
        </section>
    </div>

    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="container-fluid">
            {!! Form::model($patient, ['route' => ['patients.update', $patient->id], 'method' => 'patch', 'files' => true]) !!}

            @include('patients.fields')


                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection

@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {

            $(".office").on("click", function () {

                $('#office').css("display", 'block');
                $('#home').css("display", 'none');

                $('#apartment').css("display", 'none');
                $('#villa').css("display", 'none');

            });

            $(".home").on("click", function () {

                $('#home').css("display", 'block');
                $('#office').css("display", 'none');


                $(".villa").on("click", function () {

                    $('#villa').css("display", 'block');
                    $('#apartment').css("display", 'none');

                });


                $(".apartment").on("click", function () {

                    $('#apartment').css("display", 'block');
                    $('#villa').css("display", 'none');

                });
            });



            //fot edit form
            if($('.office').is(':checked')) {  $('#office').css("display", 'block');}

            if($('.home').is(':checked')) {
                if ($('.villa').is(':checked')) {
                    $('#home').css("display", 'block');
                    $('#villa').css("display", 'block');
                }
                if($('.apartment').is(':checked')) {
                    $('#home').css("display", 'block');
                    $('#apartment').css("display", 'block');
                }
            }

            if($('.office').is(':checked')) {  $('#office').css("display", 'block');}

        });
    </script>
    <script type="application/javascript">
        // asynchronous content
        (function ($) {
            $(document).ready(function () {
                loadNeighbors($('select[name=city]').val());
                $('select[name=city]').on('change', function(e){
                    var neighbor_id = $(this).val();
                    loadNeighbors(neighbor_id);
                });
            });
            function loadNeighbors(id)
            {
                $.getJSON("{{url('/doctors/get-neighbors')}}/" + id, [], function (data) {
                    var html = '';
                    if(data.success){
                        html = '<select class="form-control" name="area">';
                        $.each(data.data , function (key, value) {
                            html += '<option value="'+key+'">'+value+'</option>';
                        });
                        html += '</select>';
                        $('input[type=submit]').prop('disabled', function(i, v) { return false; });
                    }else{
                        $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                    }
                    $('#neighbors-holder').html(html);

                })
            }
        })(jQuery);

    </script>

@endpush