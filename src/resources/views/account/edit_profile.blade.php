<?php

use Multidots\Admin\Traits\CheckRolePermission;
?>
@extends('admin::layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Edit Profile</h1>    
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{  asset(Auth::guard('admin')->user()->avatar) }}" alt="User profile picture">
                    <h3 class="profile-username text-center">{{ Auth::guard('admin')->user()->full_name }}</h3>
                    <p class="text-muted text-center">{{ Auth::guard('admin')->user()->role->name }}</p>
                </div>                
            </div>
            <!-- End Profile Image -->
        </div>        
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                @if(CheckRolePermission::hasAccess('manage-personal-info') ||
                CheckRolePermission::hasAccess('change-avatar') ||
                CheckRolePermission::hasAccess('change-password'))
                <ul class="nav nav-tabs">
                    @if (CheckRolePermission::hasAccess('manage-personal-info'))<li class="active"><a href="#personalInfo" data-toggle="tab">Perosnal Info</a></li>@endif
                    @if (CheckRolePermission::hasAccess('change-avatar'))<li><a href="#changeAvatar" data-toggle="tab">Change Avatar</a></li>@endif
                    @if (CheckRolePermission::hasAccess('change-password'))<li><a href="#changePassword" data-toggle="tab">Change Password</a></li>@endif
                </ul>                
                <div class="tab-content">
                    <!-- Manage personal information -->
                    @if (CheckRolePermission::hasAccess('manage-personal-info'))
                    <div class="active tab-pane" id="personalInfo">
                        {!! Form::open(['route' => ['update-profile','domain' => config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')], 'name' => 'edit-profile-form', 'id' => 'edit-profile-form', 'class' => 'form-horizontal']) !!}
                        {{ Form::hidden('id', Auth::guard('admin')->user()->id) }}
                        {{ Form::hidden('form_type', 'edit_profile') }}
                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            {!! Html::decode(Form::label('First Name', 'First Name <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-2 control-label'])) !!}
                            <div class="col-sm-10">
                                {{ Form::text('first_name', old('first_name') ? old('first_name') :  Auth::guard('admin')->user()->first_name, ['id' => 'first_name', 'placeholder' => 'Enter first name', 'class' => 'form-control']) }}
                                @if ($errors->has('first_name'))
                                <span class="help-block">
                                    {{ $errors->first('first_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {!! Html::decode(Form::label('Last Name', 'Last Name <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-2 control-label'])) !!}
                            <div class="col-sm-10">
                                {{ Form::text('last_name', old('last_name') ? old('last_name') :  Auth::guard('admin')->user()->last_name, ['id' => 'last_name', 'placeholder' => 'Enter last name', 'class' => 'form-control']) }}
                                @if ($errors->has('last_name'))
                                <span class="help-block">
                                    {{ $errors->first('last_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                            {!! Html::decode(Form::label('Username', 'Username <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-2 control-label'])) !!}
                            <div class="col-sm-10">
                                {{ Form::text('username', old('username') ? old('username') :  Auth::guard('admin')->user()->username, ['id' => 'username', 'placeholder' => 'Enter username', 'class' => 'form-control']) }}
                                @if ($errors->has('username'))
                                <span class="help-block">
                                    {{ $errors->first('username') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Html::decode(Form::label('Email', 'Email <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-2 control-label'])) !!}
                            <div class="col-sm-10">
                                {{ Form::email('email', old('email') ? old('email') :  Auth::guard('admin')->user()->email, ['id' => 'email', 'placeholder' => 'Enter email', 'class' => 'form-control']) }}
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" title="Save"><i class="fa fa-check"></i> Save </button>
                            <a href="{{ route('home',['domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')]) }}" class="btn btn-default pull-right margin-r-5" title="Cancel"><i class="fa fa-mail-reply"></i> Cancel </a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @endif
                    <!-- End Manage personal information -->

                    <!-- Change avatar -->
                    @if (CheckRolePermission::hasAccess('change-avatar'))
                    <div class="tab-pane" id="changeAvatar">
                        {!! Form::open(['route' => ['update-profile','domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')], 'name' => 'change-avatar-form', 'id' => 'change-avatar-form', 'class' => 'form-horizontal', 'files' => true]) !!}
                        {{ Form::hidden('form_type', 'edit_avatar') }}
                        {{ Form::hidden('id', Auth::guard('admin')->user()->id) }}
                        <div class="form-group timeline-body {{ $errors->has('avatar') ? 'has-error' : '' }} ">                             
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 140px; height: 140px;">                                                
                                    <img src="{{ asset(Auth::guard('admin')->user()->avatar) }}" alt="" /> </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file select-image-btn">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>                                                        
                                        {!! Form::file('avatar', null,['class' => 'form-control', 'id' => 'avatar']) !!}</span>
                                    <a href="javascript:;" class="btn default fileinput-exists avatar_message" data-dismiss="fileinput"> Remove </a>
                                </div>                            
                                @if ($errors->has('avatar'))
                                <span class="help-block">
                                    {{ $errors->first('avatar') }}
                                </span>
                                @endif  
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" title="Save"><i class="fa fa-check"></i> Save </button>
                            <a href="{{ route('home',['domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')]) }}" class="btn btn-default pull-right margin-r-5" title="Cancel"><i class="fa fa-mail-reply"></i> Cancel </a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @endif
                    <!-- End Change avatar -->

                    <!-- Change password -->
                    @if (CheckRolePermission::hasAccess('change-password'))
                    <div class="tab-pane" id="changePassword">
                        {!! Form::open(['route' => ['update-profile','domain' => config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')], 'name' => 'change-password', 'id' => 'change-password', 'class' => 'form-horizontal']) !!}
                        {{ Form::hidden('form_type', 'edit_password') }}
                        {{ Form::hidden('id', Auth::guard('admin')->user()->id) }}
                        <div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
                            {!! Html::decode(Form::label('Current Password', 'Current Password <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-2 control-label'])) !!}
                            <div class="col-sm-10">
                                {{ Form::password('current_password', ['id' => 'current_password', 'placeholder' => 'Enter current password', 'class' => 'form-control']) }}
                                @if ($errors->has('current_password'))
                                <span class="help-block">
                                    {{ $errors->first('current_password') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Html::decode(Form::label('New Password', 'New Password <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-2 control-label'])) !!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    {{ Form::password('password', ['type' => 'password', 'id' => 'password', 'placeholder' => 'Enter new password', 'class' => 'form-control']) }}
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary generate_password" id="genpassword" title="Generated Password">
                                            <i class="fa fa-arrow-left fa-fw"></i> Generate Password</button>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                            {!! Html::decode(Form::label('Confirm Password', 'Confirm Password <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-2 control-label'])) !!}
                            <div class="col-sm-10">
                                {{ Form::password('confirm_password', ['type' => 'password', 'id' => 'confirm_password', 'placeholder' => 'Enter confirm password', 'class' => 'form-control']) }}
                                @if ($errors->has('confirm_password'))
                                <span class="help-block">
                                    {{ $errors->first('confirm_password') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group generated-password hidden">
                            {{ Form::label('generated_password', 'Generated Password', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
                                <p class="form-control password-value help-block"></p>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" title="Save"><i class="fa fa-check"></i> Save </button>
                            <a href="{{ route('home',['domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')]) }}" class="btn btn-default pull-right margin-r-5" title="Cancel"><i class="fa fa-mail-reply"></i> Cancel </a>
                        </div>
                        {!! Form::close() !!}
                    </div>             
                    @endif
                    <!-- End Change password -->
                </div>
                @endif
            </div>            
        </div>        
    </div>    
</section>
<!-- End content -->
@endsection

@section('js')
{{ Html::script(config('admin.public-js-css').'js/custom.js') }}
<script type="text/javascript">
    jQuery(document).ready(function () {
        $("#confirm_password,#password").on('keyup', function () {
            $('.generated-password').addClass('hidden').hide();
        });
    });
</script>
@endSection