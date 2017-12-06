@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/media/css/dataTables.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/extensions/buttons/css/buttons.bootstrap4.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/datatables-net/datatables.min.css')}}"> <!-- customization -->

@endpush
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Guests</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">

            <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link @if(!$errors->any()) active @endif" href="#" data-toggle="tab" data-target="#hotelguests-list">
                            All Guests
                            @if(Auth::user()->isAdmin())
                                <span class="badge badge-info badge-pill">{{ App\HotelGuest::count()}}</span>
                            @elseif(Auth::user()->isPartner())
                                <span class="badge badge-info badge-pill">{{ App\HotelGuest::where('partner_id', Auth::user()->id)->count()}}</span>
                            @else
                                <span class="badge badge-info badge-pill">{{ App\HotelGuest::where('partner_id', Auth::user()->partner_id)->count()}}</span>
                            @endif

                        </a>
                    </li>
                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\HotelGuest::$model))
                        <li class="nav-item">
                            <a class="nav-link @if($errors->any()) active @endif" href="#" data-toggle="tab" data-target="#new-hotelguest">
                                Create New Guest
                                @if($errors->any())
                                    <span class="badge badge-danger badge-pill">{{ count($errors->all()) }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(!$errors->any()) active @endif ks-column-section" id="hotelguests-list" role="tabpanel">
                        <!-- Content Here -->
                        @include('hotelguest.table')
                    </div>

                    @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\HotelGuest::$model))

                        <div class="tab-pane @if($errors->any()) active @endif" id="new-hotelguest" role="tabpanel">
                            <!-- Second Content -->

                            @include('hotelguest.create')
                        </div>
                    @endif

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
    <script type="application/javascript">
        (function ($) {
            $(document).ready(function () {
                var table = $('#guest-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5,6]
                            }
                        },
                        {
                            extend : 'excelHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5,6]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5,6]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions:{
                                columns: [0,1,2,3,4,5,6]
                            }
                        }

                    ],
                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });

                table.buttons().container().appendTo('#guest-datatable_wrapper .col-md-6:eq(0)');

            });
        })(jQuery);
    </script>
@endpush
