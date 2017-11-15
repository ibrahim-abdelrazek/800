@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Edit User</h5>


                    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

                    @include('users.fields')

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
@endsection
