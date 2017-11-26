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
                    @if(!empty($nurse->photo))
                        <img style="width:300px;max-height: 100%; max-width: 100%" class="img-responsive img-circle profile-img" src="{{ asset($nurse->photo) }}">
                    @else
                        <img style="width:300px;max-height: 100%; max-width: 100%" class="img-responsive img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                    @endif
                </div>
                <div class="col-md-10">
                    <h3 style="padding-top: 20px">Edit Nurse: {{ $nurse->name }}</h3>
                </div>

            </div>

        </section>
    </div>

    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="container-fluid">
                {!! Form::model($nurse, ['route' => ['nurses.update', $nurse->id], 'method' => 'patch', 'files'=>true]) !!}

                @include('nurses.fields', ['edit' => true])

                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection
@push('customjs')
    <script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
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
                $('#reset').click(function(){
                    $(this).closest('form').find("input[type=text], textarea").val("");
                });
                $('.flexdatalist').flexdatalist();
            });
        })(jQuery);

    </script>
@endpush