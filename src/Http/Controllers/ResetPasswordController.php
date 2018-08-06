<?php

namespace Multidots\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Multidots\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Multidots\Admin\Models\Administrator;

class ResetPasswordController extends Controller
{

    //admin redirect path
    protected $redirectTo = '/admin/account/dashboard';

    //trait for handling reset Password
    use ResetsPasswords;

    /**
     * Show form to administrator where they can reset password
     * 
     * @param Request $request
     * @param type $token
     * @return type
     */
    public function showResetForm(Request $request, $token = null)
    {
        config(['app.name' => 'Administrator Reset Password']);

        return view('admin::adminAuth.passwords.reset')->with(['token' => $request->token, 'email' => $request->email]);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Please enter email.',
            'email.email' => 'Please enter valid email.',
            'password.required' => 'Please enter password.',
            'password.regex' => 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.',
            'password_confirmation.required' => 'Please enter confirm password.',
            'password_confirmation.same' => 'The confirm password and password must match.',
        ];
    }

    /**
     * returns Password broker of admin
     * 
     * @return type
     */
    public function broker()
    {
        return Password::broker('administrators');
    }

    /**
     * returns authentication guard of admin
     * 
     * @return type
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * checkUserEmail Method
     * Check user email already exists or not
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function checkAdminEmail(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $data = Administrator::select('id')->active()->where('email', '=', $request->email)->get();
        $flag = ($data->count() > 0) ? 'true' : 'false';

        return $flag;
    }

}
