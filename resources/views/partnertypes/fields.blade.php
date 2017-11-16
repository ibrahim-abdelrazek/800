@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-danger"><b>{{ $error }}</b></li>
            @endforeach
        </ul>
    </div>
@endif

<!--  Name -->
<div class="form-group col-sm-8 col-sm-offset-2" id='name'>
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, [  'class' => 'form-control', 'required'=> 'required']) !!}
</div>


<!--  Status -->
<div class="form-group col-sm-8 col-sm-offset-2" id='status'>
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['1' => 'active' , '0' => 'not active'] , null, [  'class' => 'form-control']) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! url('/dashboard') !!} " class="btn btn-default" > Cancel</a>
</div>








