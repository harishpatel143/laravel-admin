@extends('admin::layouts.app')

@section('content')
<section class="content-header">
    <h1>{{ $administrators->full_name }} <small>Edit details</small> </h1>    

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
                {!! Form::model($administrators, ['name' => 'edit-admin-form', 'id' => 'edit-admin-form', 'class' => 'form-horizontal']) !!}
                {{ Form::hidden('id', $administrators->id, ['id' => 'id']) }}
                {{ Form::hidden('form_type', 'edit') }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('First Name', 'First Name <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}

                                <div class="col-sm-9">
                                    {{ Form::text('first_name', null, ['id' => 'first_name', 'placeholder' => 'Enter first name', 'class' => 'form-control', 'required']) }}
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
                                    {{ Form::email('email', null, ['id' => 'email', 'placeholder' => 'Enter email', 'class' => 'form-control', 'required']) }}
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
                                    {{ Form::text('last_name', null, ['id' => 'last_name', 'placeholder' => 'Enter last name', 'class' => 'form-control', 'required']) }}
                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('role_id') ? ' has-error' : '' }}">
                                {!! Html::decode(Form::label('Role', 'Role <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                                <div class="col-sm-9">
                                    {{ Form::select('role_id', $roles, null, ['id' => 'role_id', 'placeholder' => 'Select role','class' => 'form-control']) }}
                                    @if ($errors->has('role_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role_id') }}</strong>
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
                                    {{ Form::text('username', null, ['id' => 'username', 'placeholder' => 'Enter username', 'class' => 'form-control', 'required']) }}
                                    @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('status', 'Status', ['class' => 'control-label col-md-3']) }}
                                <div class="col-md-9">
                                    @php $checked = ($administrators->status == 1) ? 'true' : null; @endphp
                                    {{ Form::checkbox('status', $administrators->status, $checked, ['class' => 'make-switch', 'id' => 'switch-status', 'data-size' => 'small', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'Active', 'data-off-text' => 'Inactive', 'name' => 'status' ,'data-id' => $administrators->id]) }}
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right" title="Save"><i class="fa fa-check"></i>  Save </button>
                    @if (Multidots\Admin\Traits\CheckRolePermission::hasAccess('administrators-listing')) 
                    <a href="{{ route('administrators') }}" class="btn btn-default pull-right margin-r-5" title="Cancel"><i class="fa fa-mail-reply"></i> Cancel </a>
                    @endif
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>    
        </div>
    </div>
</section>
@endsection

@section('css')
{{ Html::style(config('admin.public-js-css').'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css') }}
@endsection

@section('js')
{{ Html::script(config('admin.public-js-css').'/plugins/select2/js/select2.full.min.js') }}
{{ Html::script(config('admin.public-js-css').'/plugins/bootstrap-switch/dist/js/bootstrap-switch.js') }}
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
                            data: {id: "{{ $administrators->id }}"}
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
                            data: {id: "{{ $administrators->id }}"}
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
                    $('.bong-loader').css('display', 'block');
                    success.show();
                    error.hide();
                    form.submit();
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        };
        return {
            //main function to initiate the module
            init: function () {
                initPickers();
                handleEditProfileValidation();

            }
        };
    }();

    $(document).ready(function () {
        handleValidation.init();
        $("#role_id").select2();
        $('input[name="status"]').bootstrapSwitch();
        $('input[name="status"]').on('switchChange.bootstrapSwitch', function (event, state) {
            var status = state == true ? 1 : 0;
            $('#switch-status').val(status);
        });
    });
</script>   
@endSection