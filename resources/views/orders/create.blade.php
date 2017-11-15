@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Create new Order</h5>


                        {!! Form::open(array('route' => 'orders.store',
                        'files' => true)) !!}

                            @include('orders.fields')

                        {!! Form::close() !!}

                  </div>
            </div>

        </div>
    </div>
@endsection
