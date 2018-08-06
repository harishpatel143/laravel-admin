var handleValidation = function () {
    var initPickers = function () {};

    var handleLoginValidation = function () {
        var form = $('#login-form');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                email: {
                    required: "Please enter email or username.",
                    noSpace: "Email or username cannot be empty."
                },
                password: {
                    required: "Please enter password.",
                    noSpace: "Password cannot be empty."
                }
            },
            rules: {
                email: {
                    required: true,
                    noSpace: true,
                },
                password: {
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
    };

    var handleForgorPasswordValidation = function () {
        var form = $('#forgot-password-form');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "This email is not exists in our records.",
                }
            },
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/admin/account/forgot-password/check_email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    },
                },
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

    var handleResetPasswordValidation = function () {
        var form = $('#reset-password');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "This email is not exists in our records.",
                },
                password: {
                    required: "Please enter password.",
                    customPassword: "Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter."
                },
                password_confirmation: {
                    equalTo: "Password and confirm password do not match.",
                    required: "Please enter confirm password."
                }
            },
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/admin/account/reset-password/check_email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    },
                },
                password: {
                    required: true,
                    customPassword: true
                },
                password_confirmation: {
                    equalTo: "#password",
                    required: true
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
                        data: {id: $('#id').val()}
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
                        data: {id: $('#id').val()}
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


    var handleAddAdminValidation = function () {
        var form = $('#add-admin-form');
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
                    noSpaceAllow: "Space is not allowed in first name."
                },
                last_name: {
                    required: "Please enter last name.",
                    noSpaceAllow: "Space is not allowed in last name."
                },
                username: {
                    required: "Please enter username.",
                    onlyCharLetter: "Username is invalid.",
                    remote: "Username already exists.",
                    noSpaceAllow: "Space is not allowed in username.",
                    minlength: "Username must be at least 6 characters."
                },
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "Email is already exists."
                },
                password: {
                    required: "Please enter password.",
                    customPassword: "Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter."
                },
                confirm_password: {
                    equalTo: "Password and confirm password do not match.",
                    required: "Please enter confirm password."
                },
                role_id: {
                    required: "Please select role."
                }
            },
            rules: {
                first_name: {
                    required: true,
                    noSpaceAllow: true
                },
                last_name: {
                    required: true,
                    noSpaceAllow: true
                },
                username: {
                    required: true,
                    noSpaceAllow: true,
                    minlength: 6,
                    onlyCharLetter: true,
                    remote: {
                        type: "post",
                        url: "/admin/account/check_username",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/admin/account/check_email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }
                },
                password: {
                    required: true,
                    customPassword: true
                },
                confirm_password: {
                    equalTo: "#password",
                    required: true
                },
                role_id: {
                    required: true
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
                if (element.attr("name") == "password") { // insert checkbox errors after the container                  
                    error.insertAfter(element.parent("div"));
                } else if (element.attr("name") == 'permission[]') {
                    error.insertAfter($(element).next('div'));
                } else if (element.attr("name") == 'role_id') {
                    error.insertAfter($(element).next('span'));
                } else {
                    error.insertAfter(element);
                }
            }
        });
    };

    var handleAddUserValidation = function () {
        var form = $('#add-user-form');
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
                    noSpaceAllow: "Space is not allowed in first name."
                },
                last_name: {
                    required: "Please enter last name.",
                    noSpaceAllow: "Space is not allowed in last name."
                },
                username: {
                    required: "Please enter username.",
                    onlyCharLetter: "Username is invalid.",
                    remote: "Username already exists.",
                    noSpaceAllow: "Space is not allowed in username.",
                    minlength: "Username must be at least 6 characters."
                },
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "Email is already exists."
                },
                password: {
                    required: "Please enter password.",
                    customPassword: "Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter."
                },
                confirm_password: {
                    equalTo: "Password and confirm password do not match.",
                    required: "Please enter confirm password."
                }
            },
            rules: {
                first_name: {
                    required: true,
                    noSpaceAllow: true
                },
                last_name: {
                    required: true,
                    noSpaceAllow: true
                },
                username: {
                    required: true,
                    noSpaceAllow: true,
                    minlength: 6,
                    onlyCharLetter: true,
                    remote: {
                        type: "post",
                        url: "/admin/users/check_username",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/admin/users/check_email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }
                },
                password: {
                    required: true,
                    customPassword: true
                },
                confirm_password: {
                    equalTo: "#password",
                    required: true
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
                if (element.attr("name") == "password") { // insert checkbox errors after the container                  
                    error.insertAfter(element.parent("div"));
                } else {
                    error.insertAfter(element);
                }
            }
        });
    };

    var handleEditAdminValidation = function () {
        var form = $('#edit-admin-form');
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
                    noSpaceAllow: "Space is not allowed in first name.",
                    onlyCharLetter: "First name is invalid."
                },
                last_name: {
                    required: "Please enter last name.",
                    noSpaceAllow: "Space is not allowed in last name",
                    onlyCharLetter: "Last name is invalid."
                },
                username: {
                    required: "Please enter username.",
                    remote: "Username already exists.",
                    noSpaceAllow: "Space is not allowed in username",
                    onlyCharLetter: "Username is invalid.",
                    minlength: "Username must be at least 6 characters."
                },
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "Email is already exists."
                },
                role_id: {
                    required: "Please select role."
                }
            },
            rules: {
                first_name: {
                    required: true,
                    noSpaceAllow: true,
                    onlyCharLetter: true,
                },
                last_name: {
                    required: true,
                    noSpaceAllow: true,
                    onlyCharLetter: true,
                },
                username: {
                    required: true,
                    noSpaceAllow: true,
                    onlyCharLetter: true,
                    minlength: 6,
                    remote: {
                        type: "post",
                        url: "/admin/account/check_username",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {id: $('#id').val()}
                    }
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/admin/account/check_email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {id: $('#id').val()}
                    }
                },
                role_id: {
                    required: true
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
                if (element.attr("name") === "permissions[]") {
                    error.insertAfter($(element).parents('.checkbox-list'));
                } else if (element.attr("name") == 'permission[]') {
                    error.insertAfter($(element).next('div'));
                } else if (element.attr("name") == 'role_id') {
                    error.insertAfter($(element).next('span'));
                } else {
                    error.insertAfter(element);
                }
            }
        });
    };

    var handleEditUserValidation = function () {
        var form = $('#edit-user-form');
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
                    noSpaceAllow: "Space is not allowed in first name.",
                    onlyCharLetter: "First name is invalid."
                },
                last_name: {
                    required: "Please enter last name.",
                    noSpaceAllow: "Space is not allowed in last name",
                    onlyCharLetter: "Last name is invalid."
                },
                username: {
                    required: "Please enter username.",
                    remote: "Username already exists.",
                    noSpaceAllow: "Space is not allowed in username",
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
                    noSpaceAllow: true,
                    onlyCharLetter: true,
                },
                last_name: {
                    required: true,
                    noSpaceAllow: true,
                    onlyCharLetter: true,
                },
                username: {
                    required: true,
                    noSpaceAllow: true,
                    onlyCharLetter: true,
                    minlength: 6,
                    remote: {
                        type: "post",
                        url: "/admin/users/check_username",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {id: $('#id').val()}
                    }
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/users/check_email",
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {id: $('#id').val()}
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
            }
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            initPickers();
            handleLoginValidation();
            handleForgorPasswordValidation();
            handleResetPasswordValidation();
            handleAddAdminValidation();
            handleAddUserValidation();
            handleEditUserValidation();
            handleEditAdminValidation();
        }
    };
}();

jQuery(document).ready(function () {
    handleValidation.init();

    jQuery.validator.addMethod("customPassword", function (value, element) {
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value);
    }, 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.');

    jQuery.validator.addMethod("onlyCharLetter", function (value, element) {
        return this.optional(element) || /^[0-9A-Za-z\s\-\_\.]+$/.test(value);
    });

    jQuery.validator.addMethod("noSpaceAllow", function (value) {
        return value.trim() !== "";
    }, 'Space is not allowed');

    jQuery.validator.addMethod("noSpace", function (value) {
        return value.trim() !== "";
    }, 'Space is not allowed');

    $("#avatar").change(function () {
        readURL(this);
    });
    $('.generate_password').on('click', function () {
        var text = passwordGenerator(10);
        $('.password-value').text(text);
        $('.generated-password').removeClass('hidden').show();

        $('#password').val(text);
        $('#confirm_password').val(text);
    });
});

function readURL(input)
{
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function passwordGenerator(no)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-";
    for (var i = 0; i < no; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}