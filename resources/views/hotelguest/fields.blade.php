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
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('name', 'Hotel name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        <div class="col-sm-10">{!! Form::text('name', null, [  'class' => 'form-control']) !!}</div>
    </div>
</div>


<!-- Officer Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('officer_name', 'Officer Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('officer_name', null, [  'class' => 'form-control']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_number', 'Contact Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('contact_number', null,  [  'id'=>'', 'class' => 'form-control ks-phone-mask-input']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('guest_room_number', 'Guest Room Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('guest_room_number', null, [  'class' => 'form-control']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('guest_first_name', 'Guest First Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('guest_first_name', null, [  'class' => 'form-control']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('guest_last_name', 'Guest Last Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('guest_last_name', null, [  'class' => 'form-control']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('items', 'Items:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('items', null, [  'class' => 'form-control']) !!}</div>
</div>

@if(Auth::user()->isAdmin())
    <!--  Partner -->
    <div class="form-group row">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            @if(\App\Partner::count() > 0)
                {!! Form::select('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-control'])!!}
            @else
                <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b
                                class="label-danger">Add
                            new Partner</b></a></p>
            @endif
        </div>
    </div>
    <!-- End Partner -->
@endif

<!-- Submit Field -->
<div class="form-group row" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
        <a href="{!! route('hotelguest.index') !!}</div> " class="btn btn-default"> Cancel</a>
</div>