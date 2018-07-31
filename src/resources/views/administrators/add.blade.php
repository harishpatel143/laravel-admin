@extends('admin::layouts.app')

@section('content')

<section class="content-header">
    <h1>Add Administrator</h1>    
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">                                     
                    @if (Multidots\Admin\Traits\CheckRolePermission::hasAccess('administrators-listing')) 
                    <a class="btn btn-default pull-right" href="{{ route('administrators') }}" title="Back">
                        <i class="fa fa-mail-reply"></i> Back
                    </a>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->                
                {!! Form::open(['name' => 'add-admin-form', 'id' => 'add-admin-form', 'class' => 'form-horizontal']) !!}
                {{ Form::hidden('form_type', 'add') }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('First Name', 'First Name <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                <div class="col-sm-9">
                                    {{ Form::text('first_name', old('first_name') ? old('first_name') :  '', ['id' => 'first_name', 'placeholder' => 'Enter first name', 'class' => 'form-control']) }}
                                    @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('Email', 'Email <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                <div class="col-sm-9">
                                    {{ Form::email('email', old('email') ? old('email') :  '', ['id' => 'email', 'placeholder' => 'Enter email', 'class' => 'form-control']) }}
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> 

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('Last Name', 'Last Name <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                <div class="col-sm-9">
                                    {{ Form::text('last_name', old('last_name') ? old('last_name') :  '', ['id' => 'last_name', 'placeholder' => 'Enter last name', 'class' => 'form-control']) }}
                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('password', 'Password <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {{ Form::password('password', ['type' => 'password', 'id' => 'password', 'placeholder' => 'Enter password', 'class' => 'form-control']) }}
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary generate_password" id="genpassword">
                                                <i class="fa fa-arrow-left fa-fw"></i> Generate Password</button>
                                        </div>
                                    </div>
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('Username', 'Username <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                <div class="col-sm-9">
                                    {{ Form::text('username', old('username') ? old('username') :  '', ['id' => 'username', 'placeholder' => 'Enter username', 'class' => 'form-control']) }}
                                    @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('confirm_password', 'Confirm Password <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                <div class="col-sm-9">
                                    {{ Form::password('confirm_password', ['type' => 'password', 'id' => 'confirm_password', 'placeholder' => 'Enter confirm password', 'class' => 'form-control']) }}

                                    @if ($errors->has('confirm_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('role_id') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('Role', 'Role <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                @isset($roles)
                                <div class="col-sm-9">
                                    {{ Form::select('role_id', $roles, null, ['id' => 'role_id', 'placeholder' => 'Select role','class' => 'form-control form-filter-dropdown']) }}
                                    @if ($errors->has('role_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @endisset
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group generated-password hidden">                                
                                <label class="control-label col-md-3" title="Generated Password">Generated Password</label>
                                <div class="col-md-9 password-value help-block" style="margin-top: 8px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right" title="Save"><i class="fa fa-check"></i> Save</button>
                    @if (Multidots\Admin\Traits\CheckRolePermission::hasAccess('administrators-listing')) 
                    <a href="{{ route('administrators') }}" class="btn btn-default pull-right margin-r-5" title="Cancel"><i class="fa fa-mail-reply"></i> Cancel</a>
                    @endif
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>    
        </div>
    </div>
</section>
@endsection

@section('js')
{{ Html::script(config('admin.public-js-css').'plugins/select2/js/select2.full.min.js') }}
{{ Html::script(config('admin.public-js-css').'js/custom.js') }}

<script type="text/javascript">
    jQuery(document).ready(function () {
        $("#role_id").select2();
        $("#role_id").on('change', function () {
            $(this).valid();
        });
    });
</script>
@endSection