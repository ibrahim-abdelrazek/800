@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Edit Profile </h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-sm-8 col-sm-offset-2">
        {!! Form::model($profile, ['route' => ['profile.update', $profile['id']], 'method' => 'patch', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <img src="<?= (empty($profile['avatar'])) ? asset('/upload/avatars/default.jpg') : asset($profile['avatar']) ;?>" style="width:150px; height:150px; float: left; border-radius:50%;margin-right:25px;">
                    <h2>{{ $profile['name'] }}'s Profile</h2>
                    {!! Form::label('avatar', 'Update Profile Image') !!}<br>
                    {!! Form::file('avatar',null,  [  'class' => 'form-control']) !!}
                </div>
            </div>

        <!--  Name -->
            <!--  Name -->
            <div class="form-group row">
                <label for="default-input"
                       class="col-sm-2 form-control-label">{!! Form::label('name', 'Name:') !!}</label>
                <div class="col-sm-10">
                    {!! Form::text('name', null, [  'class' => 'form-control' , 'required']) !!}
                </div>
            </div>

            <!--  Username -->
            <!--  Name -->
            <div class="form-group row">
                <label for="default-input"
                       class="col-sm-2 form-control-label">{!! Form::label('username', 'User Name:') !!}</label>
                <div class="col-sm-10">
                    {!! Form::text('username', null, [  'class' => 'form-control' , 'required']) !!}
                </div>
            </div>

            <!--  Email -->
            <div class="form-group row">
                <label for="default-input"
                       class="col-sm-2 form-control-label">{!! Form::label('email', 'Email:') !!}</label>
                <div class="col-sm-10">
                    {!! Form::email('email', null, [  'class' => 'form-control' , 'required']) !!}
                </div>
            </div>

            <!--  password -->
            <div class="form-group row">
                <label for="default-input"
                       class="col-sm-2 form-control-label">{!! Form::label('password', 'Password:') !!}</label>
                <div class="col-sm-10">
                    {!! Form::password('password', [  'class' => 'form-control' ]) !!}
                </div>
            </div>
        @if(isset($profile['location']))
            <!--  location -->
                <div class="form-group row">
                    <label for="default-input"
                           class="col-sm-2 form-control-label">{!! Form::label('location', 'Location:') !!}</label>
                    <div class="col-sm-10">

                        {!! Form::select('location', ['Abu Dhabi' , 'Dubai' , 'Sharjah' , 'Ajman' ,'Umm Al Quwain','Ras Al Khaimah' ,'Fujairah' ] , null, [  'class' => 'form-control' , 'required']) !!}
                    </div>
                </div>
        @endif
        <!-- Submit Field -->
            <div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

                {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
                <a href="{!! route('profile.index') !!} " class="btn btn-default"> Cancel</a>
            </div>


            {!! Form::close() !!}
        </div>
    </div>
        </div>
    </div>
</div>


@endsection
