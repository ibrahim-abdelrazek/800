@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach

        </ul>
    </div>
@endif
<!--  first-Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('first_name', 'f_Name:') !!}
    {!! Form::text('first_name', null, [  'class' => 'form-control']) !!}
</div>


<!--  last-Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('last_name', 'l_Name:') !!}
    {!! Form::text('last_name', null, [  'class' => 'form-control']) !!}
</div>


<!--  date -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('date', 'date:') !!}
    {!! Form::date('date',null,  [  'class' => 'form-control']) !!}
</div>

<!-- gender-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('gender', 'gender:') !!}
    {!! Form::select('gender',['male' => 'male','female'=>'female' ],null, [  'class' => 'form-control']) !!}
</div>


<!--  contact_number-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('contact_number', 'contact_number:') !!}
    {!! Form::text('contact_number',null, [  'class' => 'form-control']) !!}
</div>


<!--  email-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('email', 'email:') !!}
    {!! Form::email('email',null, [  'class' => 'form-control']) !!}
</div>


<!-- insurance_card_details-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('insurance_card_details', 'insurance card details:') !!}
    {!! Form::text('insurance_card_details',null, [  'class' => 'form-control']) !!}
</div>


<!-- emirates_id_details -->

<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('emirates_id_details', 'emirates id details:') !!}
    {!! Form::text('emirates_id_details',null, [  'class' => 'form-control']) !!}
</div>


<!-- notes-->

<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('notes', 'notes:') !!}
    {!! Form::textarea('notes',null, [  'class' => 'form-control']) !!}
</div>


<!-- address -->
<!-- address city-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('address city', 'city:') !!}
    {!! Form::text('city',null, [  'class' => 'form-control','required' => 'required']) !!}
</div>

<!-- address area-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('address area', 'area:') !!}
    {!! Form::text('area',null, [  'class' => 'form-control','required' => 'required']) !!}
</div>

<!-- address street-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('address street', 'street:') !!}
    {!! Form::text('street',null, [  'class' => 'form-control','required' => 'required']) !!}
</div>

<div class="form-group col-sm-8 col-sm-offset-2">

    {{ Form::radio('type1','home',false , ['class' => 'home' ]) }} Home
    &emsp;&emsp;
    {{ Form::radio('type1','office', false, ['class' => ' office' ]) }} Office

</div>

<div class="form-group  col-sm-8 col-sm-offset-2" id="office" style="display: none">
    <br>
    Company Name{!! Form::text('company_name',null, [  'class' => 'form-control compName']) !!}
    Building Name{!! Form::text('building_name',null, [  'class' => 'form-control buildName ']) !!}
    Office Number{!! Form::text('office_number',null, [  'class' => 'form-control officeNumber']) !!}
</div>

<div class="form-group  col-sm-8 col-sm-offset-2" id="home" style="display: none">
    <br>
    &emsp;&emsp; {{ Form::radio('type2','villa',false , ['class' => 'villa' ]) }} Villa
    &emsp;&emsp; &emsp;&emsp;
    &emsp;&emsp; {{ Form::radio('type2','apartment', false, ['class' => ' apartment' ]) }} Apartment

</div>

<div class="form-group  col-sm-8 col-sm-offset-2" id="villa" style="display: none">
    <br>
    &emsp;Villa Number{!! Form::text('villa_number',null, [ 'class' => 'form-control villaNumber']) !!}
</div>

<div class="form-group  col-sm-8 col-sm-offset-2" id="apartment" style="display: none">
    <br>
    Building Name {!! Form::text('apartment_name',null, [ 'class' => 'form-control apartmentName']) !!}
    Apartment Number{!! Form::text('apartment_number',null, [ 'class' => 'form-control apartmentNumber']) !!}
</div>


@if (Auth::user()->isAdmin())
    <!--  partner_id -->
    <div class="form-group col-sm-8 col-sm-offset-2" id=''>
        {!! Form::label('partner', 'partner') !!}
        {!! form :: select ('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-control'])!!}

    </div>
@endif


<br>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('patients.index') !!} " class="btn btn-default"> Cancel</a>
</div>








