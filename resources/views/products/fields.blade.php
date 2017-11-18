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
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, [  'class' => 'form-control']) !!}
</div>


<!--  image -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image',  [  'class' => 'form-control']) !!}
</div>



<!--  price -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price',null, [ 'step'=>"any", 'class' => 'form-control']) !!}
</div>

<!--  partner_id -->
@if(Auth::user()->isAdmin())
    <div class="form-group col-sm-8 col-sm-offset-2" >
            {!! Form::label('partner_id', 'Partner:') !!}</label>
            {!! Form::select('partner_id',  App\Partner::pluck('name', 'id') , null, ['class' => 'form-control' , 'required']) !!}

    </div>
@endif




<!-- usr-id-->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
{!! Form::hidden('user_id', Auth::user()->id ) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('products.index') !!} " class="btn btn-default" > Cancel</a>
</div>








