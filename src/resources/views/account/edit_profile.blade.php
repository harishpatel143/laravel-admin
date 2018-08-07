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

    var handleValidation = function () {
        var initPickers = function () {};
        var handleEditProfileValidation = function () {
            var form = $('#edit-profile-form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                messages: {
                    first_name: {
                        required: "Please enter first name.",
                        noSpace: "First name can not be empty.",
                        onlyCharLetter: "First name is invalid."
                    },
                    last_name: {
                        required: "Please enter last name.",
                        noSpace: "Last name can not be empty.",
                        onlyCharLetter: "Last name is invalid."
                    },
                    username: {
                        required: "Please enter username.",
                        remote: "Username already exists.",
                        onlyCharLetter: "Username is invalid.",
                        minlength: "Username must be at least 6 characters."
                    },
                    email: {
                        required: "Please enter email.",
                        email: "Please enter valid email.",
                        remote: "Email is already exists."
                    }
                },
                rules: {
                    first_name: {
                        required: true,
                        noSpace: true,
                        onlyCharLetter: true
                    },
                    last_name: {
                        required: true,
                        noSpace: true,
                        onlyCharLetter: true,
                    },
                    username: {
                        required: true,
                        remote: {
                            type: "post",
                            url: "/admin/account/check_username",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {id: "{{  Auth::guard('admin')->user()->id }}"}
                        },
                        onlyCharLetter: true,
                        minlength: 6,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/admin/account/check_email",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {id: "{{  Auth::guard('admin')->user()->id }}"}
                        }
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit
                    success.hide();
                    error.show();
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    $('.form-loader').css('display', 'block');
                    success.show();
                    error.hide();
                    form.submit();
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        };
        var handleAvatarValidation = function () {

            var form = $('#change-avatar-form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                messages: {
                    avatar: {
                        extension: "The avatar must be a file of type: jpeg, bmp, png, jpg, gif."
                    }
                },
                rules: {
                    avatar: {
                        extension: "jpg|jpeg|bmp|gif|png"
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit
                    success.hide();
                    error.show();
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    $('.form-loader').css('display', 'block');
                    success.show();
                    error.hide();
                    form.submit();
                },
                errorPlacement: function (error, element) {
                    if (element.attr("type") == "file" || (element.attr("type") == "hidden" && element.attr("name") == 'avatar')) {
                        error.insertAfter($('.avatar_message'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        };
        var handleChangePasswordValidation = function () {
            $('#change-password').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    current_password: {
                        required: true,
                        remote: {
                            type: "POST",
                            url: "/admin/account/check_password",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {id: $('#id').val()}
                        }
                    },
                    password: {
                        required: true,
                        customPassword: true
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {// custom messages for radio buttons and checkboxes
                    current_password: {
                        required: "Please enter current password.",
                        remote: "Your current password is wrong. Please enter correct password."
                    },
                    password: {
                        required: "Please enter new password.",
                        customPassword: "Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter."
                    },
                    confirm_password: {
                        required: "Please enter confirm password.",
                        equalTo: "The confirm password and password must match."
                    }
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "password") { // insert checkbox errors after the container                  
                        error.insertAfter(element.parent("div"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    $('.form-loader').css('display', 'block');
                    form.submit();
                }
            });
        };

        return {
            //main function to initiate the module
            init: function () {
                initPickers();
                handleEditProfileValidation();
                handleAvatarValidation();
                handleChangePasswordValidation();

            }
        };
    }();
    jQuery(document).ready(function () {
        $("#confirm_password,#password").on('keyup', function () {
            $('.generated-password').addClass('hidden').hide();
        });
    });
</script>
@endSection