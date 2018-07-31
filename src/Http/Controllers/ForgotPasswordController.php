<?php

namespace Multidots\Admin\Http\Controllers;

use Multidots\Admin\Model\Administrator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{

    // Sends Password Reset emails
    use SendsPasswordResetEmails;

    /**
     * Password Broker for Seller Model
     * 
     * @return type
     */
    public function broker()
    {
        return Password::broker('admin');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('admin::adminAuth.passwords.email');
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

        $data = Administrator::active()->where('email', '=', $request->email)->get();
        $flag = ($data->count() > 0) ? 'true' : 'false';

        return $flag;
    }

}
