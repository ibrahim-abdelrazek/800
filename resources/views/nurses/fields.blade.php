@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach

        </ul>
    </div>
@endif

<!--  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('name', 'Name:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, [  'class' => 'form-control']) !!}
    </div>
</div>

@if(Auth::user()->isAdmin())
    <!--  partner_id -->
    <div class="form-group row">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('partner_id', 'Partner:') !!}</label>
        <div class="col-sm-10">
            {!! form :: select ('partner_id',App\Partner::pluck('name','id'),null,['class' => 'form-control'])!!}
        </div>
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
</div>








