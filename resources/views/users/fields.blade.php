<div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger"><b>{{$error}}</b></li>
                @endforeach

            </ul>
        </div>
    @endif
</div>
<!--  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('name', 'Name:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, [   'class' => 'form-control']) !!}
    </div>
</div>
<!--  username -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('username', 'Username:') !!}</label>
    <div class="col-sm-10">
        {!! Form::text('username', null, [  'class' => 'form-control']) !!}
    </div>
</div>
<!--  Email -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('email', 'email:') !!}</label>
    <div class="col-sm-10">
        {!! Form::email('email', null, [  'class' => 'form-control']) !!}
    </div>
</div>
<!--  image -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('avatar', 'Image:') !!}</label>
    <div class="col-sm-10">
        {!! Form::file('avatar', null, [  'class' => 'form-control']) !!}
    </div>
</div>


<!--  password -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('password', 'Password:') !!}</label>
    <div class="col-sm-10">
        {!! Form::password('password',[  'class' => 'form-control']) !!}
        <br>
        <b class="text-warning"> Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). </b>
    </div>
</div>
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('password_confirmation', 'Confirm Password:') !!}</label>
    <div class="col-sm-10">
        {!! Form::password('password_confirmation', ['class' => 'form-control'] ) !!}
    </div>
</div>

@if(Auth::user()->isAdmin())
    <!--  Status -->
    <div class="form-group row">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('partner_id', 'Partner:') !!}</label>
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
@endif

<!--  user_group_id -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('user_group_id', 'User Group:') !!}</label>
    <div id="usergroups-holder" class="col-sm-10">
        @if(!isset($user))
            @if(\App\UserGroup::where('partner_id', Auth::user()->id)->count() > 0)
                {!! Form::select('user_group_id',App\UserGroup::where('partner_id', Auth::user()->id)->pluck('group_name','id'),null,['class' => 'form-control'])!!}
            @else
                <p>You don't have added user groups yet, Please <a href="{{route('usergroups.index')}}"><b class="label-danger">Add
                            new User Group</b></a></p>
            @endif
        @else
            {!! Form::select('user_group_id',App\UserGroup::where('partner_id',Auth::user()->id)->pluck('group_name','id'),null,['class' => 'form-control'])!!}

        @endif

    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('users.index') !!} " class="btn btn-default"> Cancel</a>
</div>








