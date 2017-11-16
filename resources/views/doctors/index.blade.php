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
                            @if($errors->any())
                                <span class="badge badge-danger badge-pill">{{ count($errors->all()) }}</span>
                            @endif
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
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script type="application/javascript">
        // asynchronous content
        (function ($) {
            $(document).ready(function () {
                $('.view-card').on('click', function () {
                    $.dialog({
                        title: 'Doctor Card',
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
                $('.ks-phone-mask-input').mask('(000)000-0000#');
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
                var table = $('#doctors-datatable').DataTable({
                    lengthChange: false,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions:{
                                columns: [0,2,3,4]
                            }
                        },
                        {
                            extend : 'excelHtml5',
                            exportOptions:{
                                columns: [0,2,3,4]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions:{
                                columns: [0,2,3,4]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions:{
                                columns: [0,2,3,4]
                            }
                        }
                        
                    ],
                    initComplete: function () {
                        $('.dataTables_wrapper select').select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                });

                table.buttons().container().appendTo('#doctors-datatable_wrapper .col-md-6:eq(0)');

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
                            html = '<select class="form-control ks-select" name="nurse_id">';
                            $.each(data.data , function (key, value) {
                                html += '<option value="'+key+'">'+value+'</option>';
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
                $('select.ks-select').select2();
            })(jQuery);

        </script>
    @endif
@endpush
