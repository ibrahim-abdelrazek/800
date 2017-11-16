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
<!--  first-Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, [  'class' => 'form-control']) !!}
</div>


<!--  last-Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, [  'class' => 'form-control']) !!}
</div>


<!--  date -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date',null,  [  'class' => 'form-control']) !!}
</div>

<!-- gender-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('gender', 'Gender:') !!}
    {!! Form::select('gender',['male' => 'male','female'=>'female' ],null, [  'class' => 'form-control']) !!}
</div>


<!--  contact_number-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('contact_number', 'Contact Number:') !!}
    {!! Form::text('contact_number',null, [  'class' => 'form-control']) !!}
</div>


<!--  email-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email',null, [  'class' => 'form-control']) !!}
</div>


<!-- insurance_card_details-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('insurance card details', 'Insurance Card Details:') !!}
    {!! Form::text('insurance_card_details',null, [  'class' => 'form-control']) !!}
</div>


<!-- emirates_id_details -->

<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('emirates id details', 'Emirates Id Details:') !!}
    {!! Form::text('emirates_id_details',null, [  'class' => 'form-control']) !!}
</div>


<!-- notes-->

<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::textarea('notes',null, [  'class' => 'form-control']) !!}
</div>


<!-- address -->
<!-- address city-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('address city', 'City:') !!}
    {!! Form::text('city',null, [  'class' => 'form-control','required' => 'required']) !!}
</div>

<!-- address area-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('address area', 'Area:') !!}
    {!! Form::text('area',null, [  'class' => 'form-control','required' => 'required']) !!}
</div>

<!-- address street-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('address street', 'Street:') !!}
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


@if(Auth::user()->isAdmin())
<!--  Partner -->
<div class="form-group col-sm-8 col-sm-offset-2">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner:') !!}</label>
    
        @if(\App\Partner::count() > 0)
            {!! Form::select('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-control'])!!}
        @else
            <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b class="label-danger">Add
                        new Partner</b></a></p>
        @endif
   
</div>
<!-- End Partner -->
@endif


<br>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('patients.index') !!} " class="btn btn-default"> Cancel</a>
</div>








