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
                                    <a class="nav-link " href="#" data-toggle="tab" data-target="#order-statuses">Order Statuses</a>
                                </li>
                            
                              {{--  <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#status">Order Status</a>
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
                                           @if($setting->key == 'order_default_status')
                                               <div class="col-sm-8">

                                               {!! Form::select('value[]',\App\Status::pluck('message','id'),$setting->value , [  'class' => 'form-control']) !!}
                                               </div>
                                           @else
                                               <div class="col-sm-8">
                                                   {!! Form::text('value[]',  $setting->value, [  'class' => 'form-control']) !!}
                                               </div>
                                            @endif
                                       </div>

                                    @endforeach

                                <!-- Submit Field -->
                                    <div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
                                        {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
                                        <a href="{!! url('/dashboard') !!} " class="btn btn-default"> Cancel</a>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                                {{--<div class="tab-pane" id="status" role="tabpanel">
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
                                <div class="tab-pane " id="order-statuses" role="tabpanel">
                                    <a href="{{route('status.create')}}" class="btn btn-success pull-right"> Create New Status</a><br>
                                    <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Message</th>
                                            <th>Code</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($statuses as $status)
                                            <tr>
                                                <td>{{ $status->message }}</td>
                                                <td><b class="text-{{$status->code}}">{{$status->code}}</b></td>
                                                <td>
                                                    <div class='btn-group'>

                                                    <a href="{{ URL::to('status/' . $status->id . '/edit') }}" class='btn btn-default btn-xs'>Edit</a>

                                                    {!! Form::open(['route' =>['status.destroy' , $status->id ] ,'method'=> 'delete' ]) !!}
                                                    {!! Form::button('Delete', ['type' =>'submit' , 'class' => 'btn btn-danger btn-xs', 'onclick'=> "return Confrirm('Are you Sure?')" ]) !!}
                                                    {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
