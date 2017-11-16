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

<!--  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('name', 'Name:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, [  'placeholder'=>'Enter Partner\'s name', 'class' => 'form-control']) !!}
    </div>
</div>

<!--  location -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('location', 'Location:') !!}</label>
    <div class="col-sm-10">
        {!! Form::select('location', ['Abu Dhabi' , 'Dubai' , 'Sharjah' , 'Ajman' ,'Umm Al Quwain','Ras Al Khaimah' ,'Fujairah' ] , null, [  'class' => 'form-control' , 'required']) !!}
    </div>
</div>

<!--  partner type -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner_type_id', 'Partner Type:') !!}</label>
    <div class="col-sm-10">
        {!! Form::select('partner_type_id',  App\PartnerType::pluck('name', 'id') , null, ['class' => 'form-control' , 'required']) !!}
    </div>
</div>

<!--  username -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('username', 'Username:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('username', null, [  'class' => 'form-control' , 'required']) !!}
    </div>
</div>

<!--  email -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('email', 'Email:') !!}</label>
    <div class="col-sm-10">
    {!! Form::email('email', null, [  'class' => 'form-control' , 'required']) !!}
    </div>
</div>
<!--  password -->

<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('password', 'Password:') !!}</label>
    <div class="col-sm-10">
        {!! Form::password('password', ['class' => 'form-control' , 'required']) !!}
        <br>
        <b class="text-warning"> Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). </b>
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
</div>








