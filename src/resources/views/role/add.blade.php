<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?= __('Add Role'); ?></h4>
</div>
{!! Form::open(['class' => "form-horizontal", 'id' => 'add-roles-form', 'name' => 'add-roles-form']); !!}
<div class="modal-body">
    <div class="box-body">
        <div class="row">
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Html::decode(Form::label('Name', 'Name <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}

                <div class="col-sm-9">
                    {{ Form::text('name', old('name') ? old('name') :  '', ['id' => 'role_name', 'name' => 'role_name', 'placeholder' => 'Enter name', 'class' => 'form-control']) }}
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Html::decode(Form::label('Description', 'Description <span aria-required="true" class="required"> * </span>', ['class' => 'col-sm-3 control-label'])) !!}
                <div class="col-sm-9">
                    {{ Form::textarea ('description', old('description') ? old('description') :  '', ['id' => 'description', 'placeholder' => 'Enter description', 'class' => 'form-control', 'cols' => '5', 'rows' => '5']) }}
                    @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
            </div> 
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary pull-right" title="Save"><i class="fa fa-check"></i> Save </button>
    <button type="button" class="btn btn-default pull-right margin-r-5" data-dismiss="modal" title="Cancel"><i class="fa fa-mail-reply"></i> Cancel </button>
</div>
{!! Form::close() !!} 

@section('js')
<script type="text/javascript">
    var handleValidation = function () {
        var handleAddRole = function () {
            var form = $('#add-roles-form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
            
            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                messages: {
                    role_name: {
                        required: "Please enter name.",
                        noSpace: "Name can not be empty.",
                        remote: "Role Name is already exists."
                    },
                    description: {
                        required: "Please enter description.",
                        noSpace: "Description can not be empty."
                    }
                },
                rules: {
                    role_name: {
                        required: true,
                        noSpace: true,
                        remote: {
                            url: "roles/check-name",
                            type: "post",
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        }
                    },
                    description: {
                        required: true,
                        noSpace: true
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
        }

        return {
            //main function to initiate the module
            init: function () {
                handleAddRole();
            }
        };
    }();

    jQuery(document).ready(function () {
        jQuery.validator.addMethod("noSpace", function (value) {
            return value.trim() != "";
        });
        handleValidation.init();
    });
</script>
