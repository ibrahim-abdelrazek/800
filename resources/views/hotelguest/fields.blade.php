

<!--  Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('name', 'Hotel name:') !!}
    {!! Form::text('name', null, [  'class' => 'form-control']) !!}
</div>


<!-- Officer Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('officer_name', 'Officer Name:') !!}
    {!! Form::text('officer_name', null, [  'class' => 'form-control']) !!}
</div>

<!--  Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('contact_number', 'Contact Number:') !!}
    {!! Form::text('contact_number', null, [  'class' => 'form-control']) !!}
</div>

<!--  Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('guest_room_number', 'Guest Room Number:') !!}
    {!! Form::text('guest_room_number', null, [  'class' => 'form-control']) !!}
</div>

<!--  Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('guest_first_name', 'Guest First Name:') !!}
    {!! Form::text('guest_first_name', null, [  'class' => 'form-control']) !!}
</div>

<!--  Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('guest_last_name', 'Guest Last Name:') !!}
    {!! Form::text('guest_last_name', null, [  'class' => 'form-control']) !!}
</div>

<!--  Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('items', 'Items:') !!}
    {!! Form::text('items', null, [  'class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('hotelguest.index') !!} " class="btn btn-default" > Cancel</a>
</div>








