@extends('layouts.app')

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Settings </h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(['action' => array('SettingsController@update')]) !!}

                        @foreach($settings as $setting)
                            <div class="row">
                                <div class="col-sm-6">
                                    <!--  Name -->
                                    <div class="form-group">
                                        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('key', 'Key:') !!}</label>
                                        {!! Form::text('key[]', $setting->key, [  'class' => 'form-control', 'readonly'=>'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!--  Name -->
                                    <div class="form-group">
                                        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('value', 'Value:') !!}</label>
                                        {!! Form::text('value[]', $setting->value, [  'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        <hr>
                        @endforeach

                        <!-- Submit Field -->
                        <div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
                            {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
                            <a href="{!! url('/dashboard') !!} " class="btn btn-default"> Cancel</a>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
