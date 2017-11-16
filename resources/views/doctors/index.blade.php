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
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-toggle="tab" data-target="#doctors-list">
                            All Doctors
                            @if(Auth::user()->isAdmin())
                            <span class="badge badge-info badge-pill">{{ App\Doctor::count()}}</span>
                            @elseif(Auth::user()->isPartner())
                            <span class="badge badge-info badge-pill">{{ App\Doctor::where('partner_id', Auth::user()->id)->count()}}</span>
                            @endif
                            
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="tab" data-target="#new_doctor">
                            Create New Doctor
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active ks-column-section" id="doctors-list" role="tabpanel">
                     <!-- Content Here --> 
                     @include('doctors.table')
                     </div>
                  
                    <div class="tab-pane" id="new_doctor" role="tabpanel">
                        <!-- Second Content --> 
                        @include('doctors.create')
                    </div>
                      </div>
                </div>
            </div>
        </div>
@endsection
@push('customjs')
    <script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-mask/jquery.mask.min.js') }}"></script>

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
                $('.view-doctor').on('click', function () {
                    $.dialog({
                        title: 'View Doctor',
                        content: 'url:' + "{!! url('doctors') !!}/" + $(this).attr('data-id'),
                        animation: 'zoom',
                        columnClass: 'medium',
                        closeAnimation: 'scale',
                        backgroundDismiss: true
                    });
                });
            $('a[data-toggle="tab"]').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('.ks-phone-mask-input').mask('(000)000-0000');
         $('#reset').click(function(){
             $('input').val(''); $('textarea').val('');
        });
            });
        })(jQuery);
        
    </script>
@endpush