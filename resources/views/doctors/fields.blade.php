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
<!--  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('name', 'Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, [  'placeholder'=>'Enter Doctor\'s name', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group row">

    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('photo', 'Upload Doctor\'s Photo (Optional):',['class'=> 'required']) !!}</label>
    {!! Form::file('photo',null,  [  'class' => 'form-control']) !!}
</div>
<!--  specialty -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('specialty', 'specialty:',['class'=> 'required']) !!}</label>
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
<!--  contact -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_email', 'Contact Email:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::email('contact_email', null, [  'placeholder'=>'Enter Doctor\'s Contact Email', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_number', 'Contact Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('contact_number', null, [  'placeholder'=>'Enter Doctor\'s Number', 'id'=>'', 'class' => 'form-control ks-phone-mask-input']) !!}
    </div>
</div>

@if(Auth::user()->isAdmin())
    <!--  Partner -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            @if(\App\Partner::count() > 0)
                {!! Form::select('partner_id',App\Partner::pluck('name','id'),null,['style'=>'width:100% !importnat','class' => 'form-control'])!!}
            @else
                <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b
                                class="label-danger">Add
                            new Partner</b></a></p>
            @endif
        </div>
    </div>
    <!-- End Partner -->
@endif
<!-- Nurse -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('Nurse', 'Nurse:',['class'=> 'required']) !!}</label>
    <div id="nurses-holder" class="col-sm-10">
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
    @if(\App\Nurse::count() > 0 && \App\Partner::count() > 0)
        {!! Form::submit('Save', ['class' => 'btn btn-large btn-success']) !!}
    @else
        {!! Form::submit('Save', ['disabled', 'class' => 'btn btn-large btn-success']) !!}
    @endif

    @if(!empty($edit))
            <a id="back" class="btn btn-default" href="{{ route('doctors.index') }}" >back</a>
    @else
            <button id="reset" class="btn btn-default" type="button">Reset</button>
    @endif

</div>






