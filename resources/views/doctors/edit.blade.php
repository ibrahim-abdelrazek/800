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
                     var i = 1;
                     var partner_id = $('select[name=partner_id]').val();
                    
                    $('select[name=partner_id]').on('change', function(e){
                        i = 1;
                       partner_id = $(this).val();
                       html = loadNurses(i, partner_id);
                      if(i == 1){
                            $('#nurses-holder').html(html);
    
                      }
                       var addButton = $('.add_button'); //Add button selector
                    $(addButton).on('click', function(){ //Once add button is clicked
                    i++;
                         $('#nurses-holder').append(loadNurses(i, partner_id)); // Add field html
                        
                    });
                    $('#nurses-holder').on('click', '.remove_button', function(e){ //Once remove button is clicked
                    e.preventDefault();
                    $(this).parent().parent().remove(); //Remove field html
                     });
                    });
                    
                    var addButton = $('.add_button'); //Add button selector
                    $(addButton).on('click', function(){ //Once add button is clicked
                    i++;
                         $('#nurses-holder').append(loadNurses(i, partner_id)); // Add field html
                        
                    });
                    $('#nurses-holder').on('click', '.remove_button', function(e){ //Once remove button is clicked
                        $('.add_button').removeClass('disabled');
                        $('.add_new_nurse').remove();
                        e.preventDefault();
                        $(this).parent().parent().remove(); //Remove field html
                     });
                });
                   function loadNurses(i, partner_id)
                { 
                    var re = '';
                    $.ajax({
                          url: "{{url('/doctors/get-nurses')}}/" + partner_id,
                          dataType: 'json',
                          async: false,
                          success: function(data) {
                         if(data.success){
                            html = '<div class="row"><div class="col-md-10"><select class="form-control ks-select" name="nurses[]">';
                             var Values = [];
                             $('select[name="nurses[]"]').each(function () {
                                 Values.push($(this).val());
                             });
                             var k = 0;
                            $.each(data.data , function (key, value) {
                                if($('select[name="nurses[]"]').val()==null || Values.indexOf(key)<0) {
                                    k = 1;
                                    html += '<option value="' + key + '">' + value + '</option>';
                                }
                            });
                             if(k==1 || $('select[name="nurses[]"]').val()==null){
                                html += '</select></div>';
                                if(i == 1){
                                   html+=' <div class="col-sm-2"><a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field"><span class="la la-plus-circle la-2x"></span> </a></div>';
                                }else{
                                    html += '<div class="col-sm-1"><a href="javascript:void(0);" style="padding-top:6px;" class=" remove_button btn btn-danger" title="Remove field"><span class="la la-minus-circle la-2x"></span> </a></div>';
                                }
                                html+= '</div>';
                                $('input[type=submit]').prop('disabled', function(i, v) { return false; });
                             }else{
                                 html = '<div class="row add_new_nurse"><div class="col-md-10"><p>You have added all nurses, Please <a href="{{route("nurses.index")}}"><b class="label-danger">Add ' + 'new Nurse</b></a></p></div></div>';

                                 $('.add_button').addClass('disabled');
                             }
                        }else{
                            html = "<p>You don't have added nurses yet, Please <a href='{{route("nurses.index")}}'><b class='label-danger'>Add " +
                                "new Nurse</b></a></p>";
                            $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                        }
                        re = html;
                    }
                    
                    }); 
                    return re;  
                }

            })(jQuery);

        </script>
    @else
        <script type="application/javascript">
            // asynchronous content
            (function ($) {
                $(document).ready(function () {
                  var i = 1;
                    
                    var addButton = $('.add_button'); //Add button selector
                    $(addButton).on('click', function(){ //Once add button is clicked
                    i++;
                         $('#nurses-holder').append(loadNurses(i, {{Auth::user()->partner_id}})); // Add field html
                        
                    });
                    $('#nurses-holder').on('click', '.remove_button', function(e){ //Once remove button is clicked
                    e.preventDefault();
                    $(this).parent().parent().remove(); //Remove field html
                     });
                });
        
                function loadNurses(i, partner_id)
                { 
                    var re = '';
                    $.ajax({
                          url: "{{url('/doctors/get-nurses')}}/" + partner_id,
                          dataType: 'json',
                          async: false,
                          success: function(data) {
                         if(data.success){
                            html = '<div class="row"><div class="col-md-10"><select class="form-control ks-select" name="nurses[]">';
                             var Values = [];
                             $('select[name="nurses[]"]').each(function () {
                                 Values.push($(this).val());
                             });
                             var k = 0;
                             $.each(data.data , function (key, value) {
                                 if($('select[name="nurses[]"]').val()==null || Values.indexOf(key)<0) {
                                     k = 1;
                                     html += '<option value="' + key + '">' + value + '</option>';
                                 }
                             });
                             if(k==1 || $('select[name="nurses[]"]').val()==null){
                                html += '</select></div>';
                                if(i == 1){
                                   html+=' <div class="col-sm-2"><a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field"><span class="la la-plus-circle la-2x"></span> </a></div>';
                                }else{
                                    html += '<div class="col-sm-1"><a href="javascript:void(0);" style="padding-top:6px;" class=" remove_button btn btn-danger" title="Remove field"><span class="la la-minus-circle la-2x"></span> </a></div>';
                                }
                                html+= '</div>';
                                $('input[type=submit]').prop('disabled', function(i, v) { return false; });
                             }else{
                                 html = '<div class="row add_new_nurse"><div class="col-md-10"><p>You have added all nurses, Please <a href="{{route("nurses.index")}}"><b class="label-danger">Add ' + 'new Nurse</b></a></p></div></div>';

                                 $('.add_button').addClass('disabled');
                             }
                        }else{
                            html = "<p>You don't have added nurses yet, Please <a href='{{route("nurses.index")}}'><b class='label-danger'>Add " +
                                "new Nurse</b></a></p>";
                            $('input[type=submit]').prop('disabled', function(i, v) { return true; });
                        }
                        re = html;
                    }
                    
                    }); 
                    return re;  
                }

            })(jQuery);

        </script>
    @endif

@endpush