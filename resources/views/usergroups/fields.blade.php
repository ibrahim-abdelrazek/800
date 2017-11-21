
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
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('group_name', 'Name:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('group_name', null, [  'class' => 'form-control' , 'required']) !!}
    </div>
</div>

@if(Auth::user()->isAdmin())
    <div class="form-group row">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('partner_id', 'Partner:') !!}</label>
        <div class="col-sm-10">
            {!! Form::select('partner_id',  App\Partner::pluck('name', 'id') , null, ['class' => 'form-control' , 'required']) !!}
        </div>
    </div>
@endif

@php

    $models = [
/*    \App\Partner::$model,
    \App\PartnerType::$model,
    \App\UserGroup::$model,*/
    \App\Doctor::$model,
    \App\Patient::$model,
    \App\HotelGuest::$model,
    \App\Nurse::$model,
    \App\Order::$model,
      ] ;
    $actions = ['view', 'add' ,'edit' ,'delete'];


@endphp
<div class="row">
<div class="table text-center" style="margin-left: 17%">
    <table class="table table-responsive">
        <thead>
        <th>Model</th>
        @foreach ($actions  as $action )
            <th>{{ $action }}</th>
        @endforeach
        </thead>

        <tbody>
        @foreach ($models as $model)
            <tr>
                <td>{{$model}}</td>
                @foreach ($actions as $action)
                   <td><label class="custom-control custom-checkbox ks-checkbox ks-no-description ks-checkbox-success">
                        {{ Form::checkbox( $model.$action,1, null, ['class'=> 'custom-control-input']) }}
                        <span class="custom-control-indicator"></span>
                    </label>
                   </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
    {!! Form::submit('Save', ['class' => 'btn btn-success' , 'style' =>'margin-left: 17%']) !!}
    <a href="{!! route('usergroups.index') !!}" class="btn btn-default">Cancel</a>

</div>








