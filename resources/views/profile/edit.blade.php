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
        {!! Form::model($profile, ['route' => ['profile.update', $profile['id']], 'method' => 'patch']) !!}

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
                       class="col-sm-2 form-control-label">{!! Form::label('password', 'password:') !!}</label>
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

                        {!! Form::text('location', null, [  'class' => 'form-control' ]) !!}
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
