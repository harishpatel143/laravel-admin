@extends('admin::layouts.auth')

@section('content')
<h2 class="login-box-msg">Sign In</h2>

<form method="POST" action="{{ route('admin-login') }}" id="login-form">
    {{ csrf_field() }}
    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">        
        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email or username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

        @if ($errors->has('email'))
        <span class="help-block">
            {{ $errors->first('email') }}
        </span>
        @endif


    </div>
    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

        @if ($errors->has('password'))
        <span class="help-block">
            {{ $errors->first('password') }}
        </span>
        @endif

    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>        
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
    </div>
</form>
<a href="{{ route('admin-password-reset') }}">I forgot my password</a>

@endsection

@section('js')
{{ Html::script(config('admin.public-js-css').'js/custom.js') }}
@endSection
