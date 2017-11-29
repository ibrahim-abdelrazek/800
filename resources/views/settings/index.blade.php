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
                    <div class="col-lg-12">
                        <div class="ks-tabs-container ks-tabs-default ks-tabs-no-separator ks-tabs-vertical">
                            <ul class="nav ks-nav-tabs nav-stacked">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-toggle="tab" data-target="#general">General</a>
                                </li>
                            
                              {{--  <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#statuses">Order Status</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#products">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#cities">Cities</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#neighbors">Neighbors</a>
                                </li>--}}
                            </ul>
                            <div class="tab-content">

                                 <div class="tab-pane active" id="general" role="tabpanel">
                                    {!! Form::open(['action' => array('SettingsController@update')]) !!}

                                    @foreach($settings as $setting)
                                       <div class="form-group row">
                                                {!! Form::label('', ucfirst(str_replace('_', ' ', $setting->key)), [  'class' => 'col-sm-4 form-control-label', 'readonly'=>'readonly']) !!}
                                                {!! Form::hidden('key[]', $setting->key, [  'class' => 'col-sm-4 form-control-label', 'readonly'=>'readonly']) !!}
                                                <div class="col-sm-8">
                                                    {!! Form::text('value[]', $setting->value, [  'class' => 'form-control']) !!}

                                                </div>
                                            </div>

                                    @endforeach

                                <!-- Submit Field -->
                                    <div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
                                        {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
                                        <a href="{!! url('/dashboard') !!} " class="btn btn-default"> Cancel</a>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                                {{--<div class="tab-pane" id="statuses" role="tabpanel">
                                    Content 2
                                </div>
                                <div class="tab-pane" id="products" role="tabpanel">
                                    Content 3
                                </div>
                                <div class="tab-pane" id="cities" role="tabpanel">
                                    Content 3
                                </div>
                                <div class="tab-pane" id="neighbors" role="tabpanel">
                                    Content 3
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
