
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-danger"><b>{{ $error }}</b></li>
            @endforeach
        </ul>
    </div>
@endif


<!--  message -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('message', 'Message:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('message', null, [  'class' => 'form-control' , 'required']) !!}
    </div>
</div>
<!--  code -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('code', 'Code:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::select('code', ['success', 'info','danger','warning'], [  'class' => 'form-control' , 'required']) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
    {!! Form::submit('Save', ['class' => 'btn btn-success' ]) !!}
    <a href="{!! route('settings.index') !!}" class="btn btn-default">Cancel</a>

</div>








