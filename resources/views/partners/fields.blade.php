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

<!--  first Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('first_name', 'First Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('first_name', null, [  'placeholder'=>'Enter Partner\'s first name', 'class' => 'form-control']) !!}
    </div>
</div>

<!--  last Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('last_name', 'Last Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('last_name', null, [  'placeholder'=>'Enter Partner\'s last name', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Logo -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('logo', 'Logo:',['class'=> '']) !!}
    </label>

    <div class="col-sm-10">
        {!! Form::file('logo',null,  [  'class' => 'form-control']) !!}
    </div>

</div>

<!--  location -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('location', 'Location:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::select('location', ['Dubai'] , null, [  'class' => 'form-control' , 'required']) !!}

        {{--['Abu Dhabi' , 'Dubai' , 'Sharjah' , 'Ajman' ,'Umm Al Quwain','Ras Al Khaimah' ,'Fujairah' ]--}}
    </div>
</div>

<!--  partner type -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner_type_id', 'Partner Type:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        @if(\App\PartnerType::count() > 0)
            {!! Form::select('partner_type_id',  App\PartnerType::pluck('name', 'id') , null, ['class' => 'form-control' , 'required']) !!}
        @else
            <p>You don't have added Partner Types yet, Please <a href="{{route('partnertypes.index')}}"><b class="label-danger">Add
                        new Partner Types</b></a></p>
        @endif
    </div>
</div>



<!-- Phone -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('phone', 'Phone:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('phone', null, [ 'style'=> 'padding-left:50px', 'maxlength'=> '10','class' => 'form-control phone-input' , 'required', 'style' => 'padding-left: 100px;']) !!}

    </div>
</div>
<!-- FAX -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('fax', 'FAX:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('fax', null, [  'class' => 'form-control']) !!}
    </div>
</div>

<!-- Commission -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('commission', 'commission Percent:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('commission', null, [  'placeholder'=>'5', 'class' => 'form-control' , 'required']) !!}
    </div>
</div>

<!--  email -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('email', 'Email:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::email('email', null, [  'class' => 'form-control' , 'required']) !!}
    </div>
</div>
<!--  password -->

<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('password', 'Password:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        @if(!isset($partner))
        {!! Form::password('password', ['class' => 'form-control' , 'required']) !!}
        <br>
        <b class="text-warning"> Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). </b>
        @else
            {!! Form::password('password', ['class' => 'form-control'] ) !!}
            <br>
            <b class="text-warning"> Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). </b>
        @endif
    </div>
</div>
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('password_confirmation', 'Confirm Password:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::password('password_confirmation', ['class' => 'form-control'] ) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
    <a href="{!! route('partners.index') !!}" class="btn btn-default">Cancel</a>

</div>

@push('customcss')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/international-telephone-input/css/intlTelInput.css') }}">
@endpush
@push('customjs')
<script src="{{ asset('libs/international-telephone-input/js/intlTelInput.min.js') }}"></script>
<script type="application/javascript">
    // asynchronous content
    $(document).ready(function () {
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
