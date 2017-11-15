@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/jquery-confirm/jquery.confirm.min.css') }}"> <!-- original -->

@endpush
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Doctors</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-sm-12">
                        @include('doctors.create')
                    </div>
                    <div class="col-lg-6 col-sm-12 col-sm-12">
                        @include('doctors.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script type="application/javascript">
        // asynchronous content
        (function ($) {
            $(document).ready(function () {
                $('.view-card').on('click', function () {
                    $.dialog({
                        title: 'User Group',
                        content: 'url:' + "{{ url('doctors/viewCard') }}/" + $(this).attr('data-id'),
                        animation: 'zoom',
                        columnClass: 'medium',
                        closeAnimation: 'scale',
                        backgroundDismiss: true
                    });
                });

            });
        })(jQuery);
    </script>
@endpush