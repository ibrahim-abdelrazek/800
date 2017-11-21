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
            <h3>Patients</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="container-fluid">
                <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-toggle="tab" data-target="#nurses-list">
                            All Patients
                            @if(Auth::user()->isAdmin())
                                <span class="badge badge-info badge-pill">{{ App\Patient::count()}}</span>
                            @elseif(Auth::user()->isPartner())
                                <span class="badge badge-info badge-pill">{{ App\Patient::where('partner_id', Auth::user()->id)->count()}}</span>
                            @else
                                <span class="badge badge-info badge-pill">{{ App\Patient::where('partner_id', Auth::user()->partner->id)->count()}}</span>
                            @endif

                        </a>
                    </li>
                     @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\Patient::$model))
                    <li class="nav-item">
                        <a class="nav-link" id="create_new" href="#" data-toggle="tab" data-target="#new-patient">
                            Create New Patient
                            @if($errors->any())
                                <span class="badge badge-danger badge-pill">{{ count($errors->all()) }}</span>
                            @endif
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active ks-column-section" id="nurses-list" role="tabpanel">
                        <!-- Content Here -->
                        @include('patients.table')
                    </div>
                     @if(Auth::user()->isAdmin() || Auth::user()->isPartner() || Auth::user()->ableTo('add', App\Patient::$model))
                                      
                        <div class="tab-pane" id="new-patient" role="tabpanel">
                        <!-- Second Content -->
                        @include('patients.create')
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-mask/jquery.mask.min.js') }}"></script>
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
        (function ($) {
            $(document).ready(function () {
                var table = $('#patient-datatable').DataTable({
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

                table.buttons().container().appendTo('#patient-datatable_wrapper .col-md-6:eq(0)');

            });
        })(jQuery);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".office").on("click", function () {

                $('#office').css("display", 'block');
                $('#home').css("display", 'none');

                $('#apartment').css("display", 'none');
                $('#villa').css("display", 'none');

                /*    $(".apartmentName").val('');
                   $(".apartmentNumber").val('');
                    $(".villaNumber").val('');*/

            });

            $(".home").on("click", function () {

                $('#home').css("display", 'block');
                $('#office').css("display", 'none');


                $(".villa").on("click", function () {

                    $('#villa').css("display", 'block');
                    $('#apartment').css("display", 'none');
                    /*
                                        $(".compName").val('');
                                        $(".buildName").val('');
                                        $(".officeNumber").val('');
                                        $(".apartmentName").val('');
                                        $(".apartmentNumber").val('');*/
                });


                $(".apartment").on("click", function () {

                    $('#apartment').css("display", 'block');
                    $('#villa').css("display", 'none');

                    /* $(".compName").val('');
                     $(".buildName").val('');
                     $(".officeNumber").val('');
                     $(".villaNumber").val('');*/

                });
            });

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
