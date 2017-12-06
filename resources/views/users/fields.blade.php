<div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger"><b>{{$error}}</b></li>
                @endforeach

            </ul>
        </div>
    @endif
</div>



@if(Auth::user()->isAdmin())
    <!--  user_group_id -->
    <div class="form-group row">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('user_group_id', 'User Group:',['class'=> 'required']) !!}</label>
        {{--<div id="usergroups-holder" class="col-sm-10"> </div>--}}
        <div class="col-sm-10">
            {!! Form::select('user_group_id',
            App\UserGroup::where('id', '!=', 2)->get()->pluck("group_name","id")
            , null, [  'class' => 'form-control ks-select']) !!}
        </div>
    </div>

    <!--  Status -->
    <div class="form-group row partner_form_input  <?= (!empty($user->user_group_id) && $user->user_group_id==1)? 'hidden':''?>">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('partner_id', 'Partner:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            @if(\App\Partner::count() > 0)
                {!! Form::select('partner_id',
                App\Partner::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name', 'id')
                ,null,['style'=>'width:100% !importnat','class' => 'form-control'])!!}
            @else
                <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b
                                class="label-danger">Add
                            new Partner</b></a></p>
            @endif
        </div>
    </div>

@endif


@if(Auth::user()->isPartner())
    <div class="form-group row">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('user_group_id', 'User Group:') !!}</label>
        <div class="col-sm-10">
            @if(\App\Partner::count() > 0)
                {!! Form::select('user_group_id',
            App\UserGroup::where('id', '!=', 2)->where('id', '!=', 1)->where('id', '!=', 28)->where('id', '!=', 29)->get()->pluck("group_name","id")
            , null, [  'class' => 'form-control ks-select']) !!}
            @else
                <p>You don't have added User Group yet, Please <a href="{{route('userfroups.index')}}"><b
                                class="label-danger">Add
                            new User Group</b></a></p>
            @endif
        </div>
    </div>
@endif


<!-- first  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('first_name', 'First Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('first_name', null, [   'class' => 'form-control']) !!}
    </div>
</div>
<!--  last name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('last_name', 'Last Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('last_name', null, [  'class' => 'form-control']) !!}
    </div>
</div>
<!--  Email -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('email', 'email:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::email('email', null, [  'class' => 'form-control']) !!}
    </div>
</div>
<!--  image -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('avatar', 'Image:',['class'=> '']) !!}</label>
    <div class="col-sm-10">
        {!! Form::file('avatar', null, [  'class' => 'form-control']) !!}
    </div>
</div>

@if(request()->route()->getAction()['as'] == "users.index")
<!--  specialty -->
<div class="form-group row doctor_form_input <?= (isset($user->user_group_id) && $user->user_group_id==31)? '':'hidden'?>">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('specialty', 'Specialty:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('specialty', null, [
        'placeholder'=>'Enter Doctor Specialities',
        'class' => 'flexdatalist form-control',
        'data-min-length' => '1',
        'list' => 'ks-flexdatalist-specialities'
        ]) !!}

        <datalist id="ks-flexdatalist-specialities">
            @foreach($specialites as $speciality)
                <option value="{{ $speciality }}">{{ $speciality }}</option>
            @endforeach
        </datalist>
    </div>

</div>

<div class="form-group row doctor_form_input nurse_form_input <?= (!empty($user->user_group_id) && ($user->user_group_id==31 || $user->user_group_id==32))? '':'hidden'?>">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_number', 'Contact Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('contact_number', null, [  'placeholder'=>'Enter Doctor\'s Number','style'=> 'padding-left:50px', 'maxlength'=> '10',  'class' => 'form-control phone-input', 'style' => 'padding-left: 100px;']) !!}
    </div>
</div>

<!-- Nurse -->
<div class="form-group row doctor_form_input <?= (!empty($user->user_group_id) && $user->user_group_id==31)? '':'hidden'?>">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('Nurse', 'Nurse:',['class'=> 'required']) !!}</label>
    <div id="nurses-holder" class="col-sm-10">
        @if(isset($doctor))
            @php $i=1; $nurses = $doctor->nurses; @endphp
            @foreach($nurses as $nurse)
                <?php $nursesArr[] = $nurse->id;?>
            @endforeach
            @foreach($nurses as $nurse)
                <div class="row">
                    <div class="col-md-10">
                        <?php $allNurses = App\Nurse::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->where('partner_id', $doctor['partner_id'])->pluck('name', 'id'); ?>
                        <?php// dump($allNurses)?>
                        <select name="nurses[]" style="width:100% !importnat" class="form-control">
                            @foreach($allNurses as $key => $value)
                            @if($key == $nurse->id || !in_array($key, $nursesArr))
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                        {{--{!! Form::select('nurses[]',App\Nurse::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->where('partner_id', $doctor['partner_id'])->pluck('name', 'id'),$nurse->id,['style'=>'width:100% !importnat','class' => 'form-control'])!!}--}}
                    </div>
                    <div class="col-sm-2">
                        @if($i == 1 )
                        <a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field">
                            <span class="la la-plus-circle la-2x"></span>
                        </a>
                        @else
                        <a href="javascript:void(0);" style="padding-top:6px;" class=" remove_button btn btn-danger" title="Remove field"><span class="la la-minus-circle la-2x"></span> </a>
                        @endif
                        @php($i++)
                    </div>
                </div>
                @endforeach
                @endif
    </div>
</div>

@endif


<!--  password -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('password', 'Password:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::password('password',[  'class' => 'form-control']) !!}
        <br>
        <b class="text-warning"> Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). </b>
    </div>
</div>
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('password_confirmation', 'Confirm Password:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::password('password_confirmation', ['class' => 'form-control'] ) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit '>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('users.index') !!} " class="btn btn-default"> Cancel</a>
</div>



@push('customcss')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/international-telephone-input/css/intlTelInput.css') }}">
@endpush

@push('customjs')

@if(Auth::user()->isAdmin())
<script type="application/javascript">
    // asynchronous content
    (function ($) {
        $(document).ready(function () {
            var i = 1;
            var partner_id = $('select[name=partner_id]').val();
            var html = loadNurses(i, partner_id);

            if(i == 1){
                $('#nurses-holder').html(html);

            }
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

    })(jQuery);

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
                        if($("#user_group_id").val()==31) {
                            $('input[type=submit]').prop('disabled', function (i, v) {
                                return false;
                            });
                        }
                    }else{
                        html = '<div class="row add_new_nurse"><div class="col-md-10"><p>You have added all nurses, Please <a href="{{route("nurses.index")}}"><b class="label-danger">Add ' + 'new Nurse</b></a></p></div></div>';

                        $('.add_button').addClass('disabled');
                    }

                }else{
                    html = "<p>You don't have added nurses yet, Please <a href='{{route("nurses.index")}}'><b class='label-danger'>Add " +
                    "new Nurse</b></a></p>";
                    if($("#user_group_id").val()==31) {
                        $('input[type=submit]').prop('disabled', function (i, v) {
                            return true;
                        });
                    }
                }
                re = html;
            }

        });
        return re;
    }
</script>
@else
<script type="application/javascript">
    // asynchronous content
    (function ($) {
        $(document).ready(function () {
            var i = 1;
            var html = loadNurses(i, {{Auth::user()->partner_id}});

            if(i == 1){
                $('#nurses-holder').html(html);

            }
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



    })(jQuery);

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
                        if($("#user_group_id").val()==31) {
                            $('input[type=submit]').prop('disabled', function (i, v) {
                                return false;
                            });
                        }
                    }else{
                        html = '<div class="row add_new_nurse"><div class="col-md-10"><p>You have added all nurses, Please <a href="{{route("nurses.index")}}"><b class="label-danger">Add ' + 'new Nurse</b></a></p></div></div>';

                        $('.add_button').addClass('disabled');
                    }
                }else{
                    html = "<p>You don't have added nurses yet, Please <a href='{{route("nurses.index")}}'><b class='label-danger'>Add new Nurse</b></a></p>";
                    if($("#user_group_id").val()==31) {
                        $('input[type=submit]').prop('disabled', function (i, v) {
                            return true;
                        });
                    }
                }
                re = html;
            }

        });
        return re;
    }
</script>
@endif

<script src="{{ asset('libs/international-telephone-input/js/intlTelInput.min.js') }}"></script>
<script type="application/javascript">
    $(document).ready(function () {
        handle_user_group_form();
        $("#user_group_id").on('change', function () {
            var isAdmin = "<?=  Auth::user()->isAdmin()?>";
            var partnerID = "<?= (!Auth::user()->isAdmin())? Auth::user()->partner_id:'' ?>";
            var partner_id = (isAdmin!='1')? partnerID : $('select[name=partner_id]').val();
            handle_user_group_form();
            if($("#user_group_id").val()==31) {
                loadNurses(1, partner_id);
            }else{
                $('input[type=submit]').prop('disabled', function (i, v) {
                    return false;
                });
            }
        });

        function handle_user_group_form(){
            var userGroup = $("#user_group_id").val();
            if(userGroup==31 || userGroup==32){

                if(userGroup==31){
                    $('.doctor_form_input').each(function () {
                        $(this).removeClass('hidden');
                    })
                }else if(userGroup==32 ){
                    $('.doctor_form_input').each(function () {
                        $(this).addClass('hidden');
                    })
                    $('.nurse_form_input').removeClass('hidden');
                }else{
                    $('.doctor_form_input').each(function () {
                        $(this).addClass('hidden');
                    })
                }
            }else{
                $('.doctor_form_input').each(function () {
                    $(this).addClass('hidden');
                })
            }

            if(userGroup==1){
                $('.partner_form_input').addClass('hidden');
            }else{
                $('.partner_form_input').removeClass('hidden');
            }
        }
        $(".phone-input").intlTelInput({
            autoHideDialCode: false,
            formatOnDisplay: true,
            hiddenInput: "full_number",
            initialCountry: "ae",
            nationalMode: true,
            preferredCountries : ['ae'],
            separateDialCode: true,
            utilsScript: "{{asset("libs/international-telephone-input/js/utils.js")}}"
    });
    });
</script>
@endpush