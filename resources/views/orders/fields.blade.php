
<div>
                    @if($errors->any())
                       <div class="alert alert-danger">
                           <ul>
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach

                           </ul>
                           </div>
                           @endif
                    </div>
<!--  prescription -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('prescription', 'prescription:') !!}
    {!! Form::text('prescription', null, [  'class' => 'form-control']) !!}
</div>


<!--  insurance_image -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('insurance_image', 'insurance image:') !!}
    {!! Form::file('insurance_image',null,  [  'class' => 'form-control']) !!}
</div>



<!--  insurance_text -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('insurance_text', 'insurance text:') !!}
    {!! Form::text('insurance_text',null, [  'class' => 'form-control']) !!}
</div>


<!-- notes -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('notest', 'notes:') !!}
    {!! Form::textarea('notes',null, [  'class' => 'form-control']) !!}
</div>

@if(Auth::user()->isAdmin())

<!--  patient_id -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('patient', 'patient') !!}
   {!! form :: select ('patient_id',App\Patient::select(DB::raw("CONCAT(first_name,' ', last_name) AS full_name, id"))->pluck('full_name','id'),null,['class' => 'form-controller'])!!}
 
</div>
@elseif(Auth::user()->isPartner())
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('patient', 'Patient:') !!}
 @if(\App\Patient::where('partner_id', Auth::user()->id)->count() > 0)

   {!! form :: select ('patient_id',App\Patient::select(DB::raw("CONCAT(first_name,' ', last_name) AS full_name, id"))->pluck('full_name','id'),null,['class' => 'form-controller'])!!}
  @else
            <p>You don't have added patients yet, Please <a href="{{route('nurses.index')}}"><b class="label-danger">Add
                        new Patient</b></a></p>
        @endif
</div>
@endif

@if(Auth::user()->isAdmin())
<!--  doctor_id -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('doctor', 'doctor') !!}
   {!! form :: select ('doctor_id',App\Doctor::pluck('name','id'),null,['class' => 'form-controller'])!!}
 
</div>
@elseif(Auth::user()->isPartner())
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('doctor', 'doctor') !!}
 @if(\App\Doctor::where('partner_id', Auth::user()->id)->count() > 0)

   {!! form :: select ('doctor_id',App\Doctor::where('partner_id', Auth::user()->id)->pluck('name','id'),null,['class' => 'form-controller'])!!}
  @else
            <p>You don't have added nurses yet, Please <a href="{{route('nurses.index')}}"><b class="label-danger">Add
                        new Doctor</b></a></p>
        @endif
</div>
@endif

@if(Auth::user()->isAdmin())
<!--  partner_id -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('partner', 'Partner') !!}
   {!! form :: select ('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-controller'])!!}
 
</div>

@endif
<!--  product_id -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('product', 'Product') !!}
   {!! form :: select ('product_id',App\Product::pluck('name','id'),null,['class' => 'form-controller'])!!}
 
</div>





<!-- user-id-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
{!! Form::hidden('user_id', Auth::user()->id ) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
@if(\App\Doctor::where('partner_id', Auth::user()->id)->count() > 0 && \App\Product::where('partner_id', Auth::user()->id)->count() > 0 &&
    \App\Patient::where('partner_id', Auth::user()->id)->count() > 0)
    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    @else
        {!! Form::submit('Save', ['class' => 'btn btn-danger disabled', 'disabled' => 'disabled']) !!}
@endif
    <a href="{!! route('orders.index') !!} " class="btn btn-default" > Cancel</a>
</div>








