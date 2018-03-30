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

@endpush
@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Nurses</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link @if(!$errors->any()) active @endif" href="#" data-toggle="tab" data-target="#nurses-list">
                            All Nurses
                            @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
                                <span class="badge badge-info badge-pill">{{ App\Nurse::count()}}</span>
                            @elseif(Auth::user()->isPartner())
                                <span class="badge badge-info badge-pill">{{ App\Nurse::where('partner_id', Auth::user()->partner_id)->count()}}</span>
                            @else
                                <span class="badge badge-info badge-pill">{{ App\Nurse::where('partner_id', Auth::user()->partner_id)->count()}}</span>
                            @endif

                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(!$errors->any()) active @endif ks-column-section" id="nurses-list" role="tabpanel">
                        <!-- Content Here -->
                        @include('nurses.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
    {{--<script src="{{ asset('libs/jquery-mask/jquery.mask.min.js') }}"></script>--}}
    <script src="{{ asset('libs/flexdatalist/jquery.flexdatalist.min.js')}}"></script>
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
        // asynchronous content
        (function ($) {
            $(document).ready(function () {
                $('.view-card').on('click', function () {
                    $.dialog({
                        title: 'Nurse Card',
                        content: 'url:' + "{{ url('nurse/viewCard') }}/" + $(this).attr('data-id'),
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
//                $('.ks-phone-mask-input').mask('(000)000-0000#');
                $('#reset').click(function(){
                    $(this).closest('form').find("input[type=text], textarea").val("");
                });
                $('.flexdatalist').flexdatalist();
            });
        })(jQuery);


    </script>

    <script type="application/javascript">
        (function ($) {
            $(document).ready(function () {
                var table = $('#nurses-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions:{
                                columns: [0,2,3]
                            }
                        },
                        {
                            extend : 'excelHtml5',
                            exportOptions:{
                                columns: [0,2,3]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions:{
                                columns: [0,2,3]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions:{
                                columns: [0,2,3]
                            }
                        }

                    ],
                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });

                table.buttons().container().appendTo('#nurses-datatable_wrapper .col-md-6:eq(0)');

            });
        })(jQuery);
    </script>
@endpush
