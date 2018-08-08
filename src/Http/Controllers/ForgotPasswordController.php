<?php

namespace Multidots\Admin\Http\Controllers;

use Multidots\Admin\Models\Administrator;
use Multidots\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{

    //Sends Password Reset emails
    use SendsPasswordResetEmails;

    //Password Broker for Seller Model
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
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate(
                $request, ['email' => 'required|email'], ['email.required' => 'Please enter email.']
        );
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

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $user_check = Administrator::select('status')->where('email', '=', $request->email)->where('status', '=', 1)->first();
        Session::put('email', $request->email);
        if (empty($user_check)) {
            return back()->with('status', __('Your email does not exist in our records.'));
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
                $request->only('email')
        );
        

        return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($response) : $this->sendResetLinkFailedResponse($request, $response);
    }

}
