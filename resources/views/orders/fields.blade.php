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
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('prescription', 'prescription:') !!}
    </label>

    <div class="col-sm-10">
        {!! Form::file('prescription',null,  [  'class' => 'form-control']) !!}
    </div>

</div>
<!-- notes -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('notes', 'notes:') !!}
    </label>
    <div class="col-sm-10">
        {!! Form::textarea('notes',null, [  'class' => 'form-control']) !!}
    </div>
</div>

@if(!Auth::user()->isAdmin())

    <!--  patient_id -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('patient', 'Patient:') !!}
        </label>

        <div class="col-sm-10">
            @if(\App\Patient::where('partner_id', Auth::user()->id)->count() > 0)

                {!! form::select ('patient_id',App\Patient::select(DB::raw("CONCAT(first_name,' ', last_name) AS full_name, id"))->pluck('full_name','id'),null,['class' => 'form-control'])!!}
            @else
                <p>You don't have added patients yet, Please <a href="{{route('patients.index')}}"><b class="label-danger">Add
                            new Patient</b></a></p>
            @endif
        </div>
    </div>
    <!-- Doctor -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('doctor', 'doctor') !!}
        </label>

        <div class="col-sm-10">
            @if(\App\Doctor::where('partner_id', Auth::user()->id)->count() > 0)

                {!! form::select ('doctor_id',App\Doctor::where('partner_id', Auth::user()->id)->pluck('name','id'),null,['class' => 'form-control'])!!}
            @else
                <p>You don't have added doctors yet, Please <a href="{{route('doctors.index')}}"><b class="label-danger">Add
                            new Doctor</b></a></p>
            @endif
        </div>
    </div>


@else
    <!--  partner_id -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('partner', 'Partner') !!}
        </label>

        <div class="col-sm-10">
            {!! form :: select ('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-control'])!!}
        </div>
    </div>
    <!-- Patients Holder -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('patient', 'Patient') !!}
        </label>

        <div id="patients-holder" class="col-sm-10">
        </div>
    </div>
    <!--  doctor_id -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('doctor', 'doctor') !!}
        </label>
        <div id="doctors-holder" class="col-sm-10">
        </div>
    </div>
@endif
<!--  product_id -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('product', 'Product') !!}
    </label>

    <div id="products_wrapper" class="col-sm-10">
     <div class="form-group row">
         <div class="col-sm-3">
             {!! form :: select ('products[]',App\Product::pluck('name','id'),null,['class' => 'form-control'])!!}

         </div>
         <div class="text-center col-sm-1">
             <span class="label label-danger">X</span>
         </div>
         <div class="col-sm-3">
             {!! Form::text('quantities[]', null, [  'placeholder'=>'Enter Product\'s quantity', 'class' => 'form-control']) !!}
         </div>
         <div class="col-sm-2">
             <a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field"><span class="la la-plus-circle la-2x"></span> </a>
         </div>
     </div>
    </div>
</div>
<!-- Submit Field -->
<div class="form-group row" id='submit'>
    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('orders.index') !!} " class="btn btn-default"> Cancel</a>
</div>









