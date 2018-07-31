@extends('admin::layouts.auth')

@section('content')
<h2 class="login-box-msg">Reset Password</h2>
{!! Form::open(['url' => '/admin/account/password/reset','name' => 'reset-password', 'id' => 'reset-password']) !!}
{{ Form::hidden('token', $token) }}

<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">    
    {{ Form::email('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => __('Enter Email'))) }}
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    @if ($errors->has('email'))
    <span class="help-block">
        {{ $errors->first('email') }}
    </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
    <input id="password" type="password" class="form-control" name="password" placeholder="Enter New Password">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    @if ($errors->has('password'))
    <span class="help-block">
        {{ $errors->first('password') }}
    </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Enter Confirm Password">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    @if ($errors->has('password_confirmation'))
    <span class="help-block">
        {{ $errors->first('password_confirmation') }}
    </span>
    @endif
</div>
<div class="row">
    <div class="col-xs-8">        
        {{ Form::button('Reset Password', array('class'=>'btn btn-primary btn-block btn-flat', 'type'=>'submit', 'title' => 'Reset Password'))}}            
    </div>     
</div>
</form>

@endsection

@section('js')
{{ Html::script(config('admin.public-js-css').'js/custom.js') }}
@endSection