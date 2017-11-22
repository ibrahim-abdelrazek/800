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
                <div class="row">
                    <div class="col-md-2">
                        @if(!empty($doctor->photo))
                            <img style="width:300px;max-height: 100%; max-width: 100%" class="img-responsive img-circle profile-img" src="{{ asset($doctor->photo) }}">
                        @else
                            <img style="width:300px;max-height: 100%; max-width: 100%" class="img-responsive img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                        @endif
                    </div>
                    <div class="col-md-10">
                        <h3 style="padding-top: 20px">Edit Dr. {{ $doctor->name }}</h3>
                    </div>

                </div>

            </section>
        </div>

        <div class="ks-page-content">
            <div class="ks-page-content-body">
                <div class="container-fluid">
                {!! Form::model($doctor, ['route' => ['doctors.update', $doctor->id], 'method' => 'patch', 'files'=>true]) !!}

                @include('doctors.fields', ['edit' => true])

                {!! Form::close() !!}
                </div>
            </div>
        </div>


@endsection
@push('customjs')
    <script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('libs/flexdatalist/jquery.flexdatalist.min.js')}}"></script>
    <script type="application/javascript">
        // asynchronous content
        (function ($) {
            $(document).ready(function () {
                $('label[for="photo"]').removeClass('required');



                $('a[data-toggle="tab"]').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
                $('.ks-phone-mask-input').mask('(000)000-0000#');
                $('#reset').click(function(){
                    $(this).closest('form').find("input[type=text], textarea").val("");
                });
                $('.flexdatalist').flexdatalist();
            });
        })(jQuery);

    </script>


    @if(Auth::user()->isAdmin())
        <script type="application/javascript">
            // asynchronous content
            (function ($) {
                $(document).ready(function () {
                    loadNurses($('select[name=partner_id]').val());
                    $('select[name=partner_id]').on('change', function(e){
                        var partner_id = $(this).val();
                        loadNurses(partner_id);
                    });
                });
                function loadNurses(partner_id)
                {
                    $.getJSON("{{url('/doctors/get-nurses')}}/" + partner_id, [], function (data) {
                        var html = '';
                        if(data.success){
                            html = '<select class="form-control" name="nurse_id">';
                            $.each(data.data , function (key, value) {
                                html += '<option '+ selected +' value="'+key+'">'+value+'</option>';
                            });
                            html += '</select>';
                            $('input[type=submit]').prop('disabled', function(i, v) { return false; });
                        }else{
                            html = "<p>You don't have added nurses yet, Please <a href='{{route("nurses.index")}}'><b class='label-danger'>Add " +
                                "new Nurse</b></a></p>";
                            $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                        }
                        $('#nurses-holder').html(html);

                    })
                }
            })(jQuery);

        </script>
    @else
        <script type="application/javascript">
            // asynchronous content
            (function ($) {
                $(document).ready(function () {
                    loadNurses({{Auth::user()->partner_id}});
                 
                });
                function loadNurses(partner_id)
                {
                    $.getJSON("{{url('/doctors/get-nurses')}}/" + partner_id, [], function (data) {
                        var html = '';
                        if(data.success){
                            html = '<select class="form-control" name="nurse_id">';
                            $.each(data.data , function (key, value) {
                                var nurseId = "{{$doctor->nurse_id}}";
                                var selected = (nurseId == key) ? 'selected' : '';
                                html += '<option '+ selected +' value="'+key+'">'+value+'</option>';
                            });
                            html += '</select>';
                            $('input[type=submit]').prop('disabled', function(i, v) { return false; });
                        }else{
                            html = "<p>You don't have added nurses yet, Please <a href='{{route("nurses.index")}}'><b class='label-danger'>Add " +
                                "new Nurse</b></a></p>";
                            $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                        }
                        $('#nurses-holder').html(html);

                    })
                }
            })(jQuery);

        </script>
    @endif
@endpush