@extends('layouts.app')

@section('login')
    <div class="ks-page">
        <div class="ks-page-header">
            <a href="#" class="ks-logo">800Pharmacy</a>
        </div>
        <div class="ks-page-content">
            <div class="ks-logo">800Pharmacy</div>

            <div class="card panel panel-default ks-light ks-panel ks-login">
                <div class="card-block">
                    <form action="{{ route('login') }}"  method="POST" class="form-container">
                        {{ csrf_field() }}
                        <h4 class="ks-header">Login</h4>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-icon icon-left icon-lg icon-color-primary">
                                <input name="email" type="text" class="form-control" placeholder="Email">
                                <span class="icon-addon">
                                <span class="la la-at"></span>

                            </span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-icon icon-left icon-lg icon-color-primary">
                                <input name="password" type="password" class="form-control" placeholder="Password">
                                <span class="icon-addon">
                                <span class="la la-key"></span>
                            </span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <div class="ks-text-center">
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="ks-footer">
            <span class="ks-copyright">&copy; {{ date('Y') }} 800Pharmacy</span>

        </div>
    </div>
@endsection
