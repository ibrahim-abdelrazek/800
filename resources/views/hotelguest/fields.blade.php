
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
    {!! Form::text('contact_number', null,  [  'placeholder'=>'Enter Doctor\'s Number', 'id'=>'', 'class' => 'form-control ks-phone-mask-input']) !!}
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

@if(Auth::user()->isAdmin())
<!--  Partner -->
<div class="form-group col-sm-8 col-sm-offset-2">
   {!! Form::label('partner', 'partner') !!}
    
        @if(\App\Partner::count() > 0)
            {!! Form::select('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-control'])!!}
        @else
            <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b class="label-danger">Add
                        new Partner</b></a></p>
        @endif
    
</div>
<!-- End Partner -->
@endif

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('hotelguest.index') !!} " class="btn btn-default" > Cancel</a>
</div>








