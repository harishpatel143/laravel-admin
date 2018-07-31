<?php

namespace Multidots\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AdministratorRequest extends FormRequest
{

    /**
     * Determine if the administrator is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $formType = $request->form_type;
        $rule = [];

        switch ($formType) {
            case "add":
                $rule['first_name'] = 'required|regex:/^[0-9A-Za-z\s\-\_\.]+$/|max:255';
                $rule['last_name'] = 'required|regex:/^[0-9A-Za-z\s\-\_\.]+$/|max:255';
                $rule['username'] = 'required|max:255|min:6|regex:/^[0-9A-Za-z\s\-\_\.]+$/|unique:administrators';
                $rule['email'] = 'required|email|max:255|unique:administrators';
                $rule['password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
                $rule['confirm_password'] = 'required|same:password';
                $rule['role_id'] = 'required';
                break;

            case "edit":
                $rule['first_name'] = 'required|regex:/^[0-9A-Za-z\s\-\_\.]+$/|max:255';
                $rule['last_name'] = 'required|regex:/^[0-9A-Za-z\s\-\_\.]+$/|max:255';
                $rule['username'] = 'required|max:255|min:6|regex:/^[0-9A-Za-z\s\-\_\.]+$/|unique:administrators,username,' . $request->id;
                $rule['email'] = 'required|email|max:255|unique:administrators,email,' . $request->id;
                $rule['role_id'] = 'required';
                break;

            case "edit_profile":
                $rule['first_name'] = 'required|regex:/^[0-9A-Za-z\s\-\_\.]+$/|max:255';
                $rule['last_name'] = 'required|regex:/^[0-9A-Za-z\s\-\_\.]+$/|max:255';
                $rule['username'] = 'required|max:255|min:6|regex:/^[0-9A-Za-z\s\-\_\.]+$/|unique:administrators,username,' . $request->id;
                $rule['email'] = 'required|email|max:255|unique:administrators,email,' . $request->id;
                break;
            case "edit_avatar":
                $rule['avatar'] = 'mimes:jpg,jpeg,bmp,gif,png';
                break;
            case "edit_password":
                $rule['current_password'] = 'required|min:6|max:20';
                $rule['password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
                $rule['confirm_password'] = 'required|same:password';
                break;
        }
        return $rule;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'Please enter first name.',
            'first_name.regex' => 'Please enter valid first name.',
            'last_name.required' => 'Please enter last name.',
            'last_name.regex' => 'Please enter valid last name.',
            'username.required' => 'Please enter username.',
            'username.unique' => 'Username already exists.',
            'username.regex' => 'Please enter valid username.',
            'email.required' => 'Please enter email.',
            'email.email' => 'Please enter valid email.',
            'email.unique' => 'Email is already exists.',
            'password.required' => 'Please enter password.',
            'password.regex' => 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.',
            'new_password.regex' => 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.',
            'current_password.required' => 'Please enter current password.',
            'confirm_password.required' => 'Please enter confirm password.',
            'confirm_password.same' => 'The confirm password and new password must match.',
            'permission.required' => 'Please select atleast one permission for user.', // Role and permission.
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, bmp, png, jpg.',
            'role_id.required' => 'Please select role.',
        ];
    }

}
