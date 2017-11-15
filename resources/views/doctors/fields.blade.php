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
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('name', 'Name:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, [  'placeholder'=>'Enter Doctor\'s name', 'class' => 'form-control']) !!}
    </div>
</div>

<!--  specialty -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('specialty', 'specialty:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('specialty', null, [  'placeholder'=>'Enter Doctor\'s Speciality', 'class' => 'form-control']) !!}
    </div>
</div>
<!--  contact -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact', 'Contact details:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('contact_details', null, [  'placeholder'=>'Enter Doctor\'s Contact details', 'class' => 'form-control']) !!}
    </div>
</div>
@if(Auth::user()->isAdmin())
<!--  Partner -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner') !!}</label>
    <div class="col-sm-10">
        @if(\App\Partner::count() > 0)
            {!! Form::select('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-control'])!!}
        @else
            <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b class="label-danger">Add
                        new Partner</b></a></p>
        @endif
    </div>
</div>
<!-- End Partner -->
@endif
<!-- Nurse -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('Nurse', 'Nurse:') !!}</label>
    <div class="col-sm-10">
        
        @if(\App\Nurse::where('partner_id', Auth::user()->id)->count() > 0)
            {!! Form::select('nurse_id',App\Nurse::where('partner_id', Auth::user()->id)->pluck('name','id'),null,['class' => 'form-control'])!!}
        @else
            <p>You don't have added nurses yet, Please <a href="{{route('nurses.index')}}"><b class="label-danger">Add
                        new Nurse</b></a></p>
        @endif
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
    @if(\App\Nurse::count() > 0 && \App\Partner::count() > 0)
        {!! Form::submit('Save', ['class' => 'btn btn-large btn-success']) !!}
    @else
        {!! Form::submit('Save', ['disabled', 'class' => 'btn btn-large btn-success']) !!}
    @endif
</div>








