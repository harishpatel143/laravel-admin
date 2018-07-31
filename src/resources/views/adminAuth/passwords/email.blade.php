@extends('admin::layouts.auth')

@section('content')
<h2 class="login-box-msg">Forgot Password</h2>

@if (session('status'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {{ session('status') }}
</div>
@endif
{!! Form::open(['url' => '/admin/account/password/email','name' => 'email-form', 'id' => 'forgot-password-form', 'class' => 'forget-form']) !!}

<h4 class="form-group">Enter Email</h4>
<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">        
    {!! Form::email('email', null, array( 'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Enter email', 'autofocus' => 'autofocus')) !!}
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    @if ($errors->has('email'))
    <span class="help-block">
        {{ $errors->first('email') }}
    </span>
    @endif
</div>
<div class="row">
    <div class="col-xs-4">
        <a href="{{ route('admin-login',['domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')]) }}" class="btn btn-default btn-block btn-flat">Back</a>            
    </div>        
    <div class="col-xs-8">
        {{ Form::button('Send Reset Password Link', array('class'=>'btn btn-primary btn-block btn-flat', 'type'=>'submit', 'title' => 'Send Reset Password Link')) }}            
    </div>
</div>
{!! Form::close() !!}

@endsection

@section('js')
{{ Html::script(config('admin.public-js-css').'js/custom.js') }}
@endSection

